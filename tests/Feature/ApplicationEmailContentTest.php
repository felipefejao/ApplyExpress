<?php

namespace Tests\Feature;

use App\Jobs\SendUserEmailJob;
use App\Mail\SendEmailWithAttachment;
use App\Models\Curriculo;
use App\Models\User;
use App\Models\Vaga;
use App\Services\OllamaService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Mockery;

class ApplicationEmailContentTest extends TestCase
{
    use DatabaseTransactions;

    public function test_it_selects_the_correct_curriculo_language(): void
    {
        Mail::fake();

        $user = User::factory()->create();
        $ptCurriculo = Curriculo::factory()->create([
            'user_id' => $user->id,
            'language' => 'pt_br',
            'external_url' => 'https://pt.com/cv',
        ]);
        $esCurriculo = Curriculo::factory()->create([
            'user_id' => $user->id,
            'language' => 'es',
            'external_url' => 'https://es.com/cv',
        ]);

        // Job in Spanish
        $vagaEs = Vaga::factory()->create([
            'user_id' => $user->id,
            'language' => 'es',
            'enviado' => false,
        ]);

        (new SendUserEmailJob($vagaEs))->handle();

        Mail::assertSent(SendEmailWithAttachment::class, function ($mail) {
            return $mail->data['curriculo_url'] === 'https://es.com/cv' && !$mail->data['is_fallback_english'];
        });

        // Job in Portuguese
        $vagaPt = Vaga::factory()->create([
            'user_id' => $user->id,
            'language' => 'pt_br',
            'enviado' => false,
        ]);

        (new SendUserEmailJob($vagaPt))->handle();

        Mail::assertSent(SendEmailWithAttachment::class, function ($mail) {
            return $mail->data['curriculo_url'] === 'https://pt.com/cv';
        });
    }

    public function test_it_falls_back_to_english_when_language_not_found(): void
    {
        Mail::fake();

        $user = User::factory()->create();
        $enCurriculo = Curriculo::factory()->create([
            'user_id' => $user->id,
            'language' => 'us',
            'external_url' => 'https://en.com/cv',
        ]);

        // Job in French (but no French resume)
        $vagaFr = Vaga::factory()->create([
            'user_id' => $user->id,
            'language' => 'fr',
            'enviado' => false,
        ]);

        (new SendUserEmailJob($vagaFr))->handle();

        Mail::assertSent(SendEmailWithAttachment::class, function ($mail) {
            return $mail->data['curriculo_url'] === 'https://en.com/cv' && $mail->data['is_fallback_english'] === true;
        });
    }

    public function test_it_includes_required_links_and_texts(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'application_text' => 'Candidatura top',
            'cover_letter' => 'Minha carta',
            'github_link' => 'https://github.com/user',
            'linkedin_link' => 'https://linkedin.com/in/user',
        ]);

        $vaga = Vaga::factory()->create([
            'user_id' => $user->id,
            'enviado' => false,
        ]);

        (new SendUserEmailJob($vaga))->handle();

        Mail::assertSent(SendEmailWithAttachment::class, function ($mail) {
            return $mail->data['application_text'] === 'Candidatura top' &&
                   $mail->data['cover_letter'] === 'Minha carta' &&
                   $mail->data['github'] === 'https://github.com/user' &&
                   $mail->data['linkedin'] === 'https://linkedin.com/in/user';
        });
    }

    public function test_it_uses_ollama_service_when_active(): void
    {
        $ollamaMock = Mockery::mock(OllamaService::class)->makePartial();
        $ollamaMock->shouldReceive('isEnabled')->andReturn(true);
        $ollamaMock->shouldReceive('improveText')
            ->with(Mockery::any(), 'pt_br')
            ->andReturn('Improved text content');
        $this->app->instance(OllamaService::class, $ollamaMock);

        $user = User::factory()->create();
        $vaga = Vaga::factory()->create([
            'user_id' => $user->id,
            'language' => 'pt_br',
        ]);

        $mailable = new SendEmailWithAttachment([
            'cargo' => 'Dev',
            'user_email' => 'user@test.com',
            'language' => 'pt_br',
            'nome' => 'Test User',
            'recrutador' => 'Recruiter',
            'application_text' => 'Text',
            'cover_letter' => 'Letter',
            'curriculo_url' => 'http://cv.com',
            'linkedin' => 'link',
            'github' => 'git',
            'relocation' => false,
            'is_fallback_english' => false,
        ]);

        $content = $mailable->content();

        $this->assertEquals('email.plain', $content->text);
        $this->assertEquals('Improved text content', $content->with['body']);
    }

    public function test_ollama_receives_correct_language_from_vaga(): void
    {
        $ollamaMock = Mockery::mock(OllamaService::class)->makePartial();
        $ollamaMock->shouldReceive('isEnabled')->andReturn(true);
        
        // Expecting 'us' as the language for a US job
        $ollamaMock->shouldReceive('improveText')
            ->with(Mockery::any(), 'us')
            ->once()
            ->andReturn('English Translated Content');
            
        $this->app->instance(OllamaService::class, $ollamaMock);

        $mailData = [
            'cargo' => 'Developer',
            'user_email' => 'user@test.com',
            'language' => 'us', // US Job
            'nome' => 'Test User',
            'empresa' => 'Apple',
            'application_text' => 'Olá, tudo bem?', // Text in Portuguese
            'linkedin' => 'link',
            'github' => 'git',
            'curriculo_url' => 'url',
            'relocation' => false,
            'is_fallback_english' => false,
        ];

        $mailable = new SendEmailWithAttachment($mailData);
        $content = $mailable->content();

        $this->assertEquals('English Translated Content', $content->with['body']);
    }
}
