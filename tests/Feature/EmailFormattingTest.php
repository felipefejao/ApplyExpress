<?php

namespace Tests\Feature;

use App\Mail\SendEmailWithAttachment;
use App\Models\User;
use App\Models\Vaga;
use App\Models\Curriculo;
use App\Jobs\SendUserEmailJob;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class EmailFormattingTest extends TestCase
{
    use DatabaseTransactions;

    public function test_email_view_has_correct_formatting_and_no_attachments(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'name' => 'Felipe Silva',
            'application_text' => 'Olá, tenho interesse na vaga.',
            'linkedin_link' => 'https://linkedin.com/in/felipe',
            'github_link' => 'https://github.com/felipe',
        ]);

        $curriculo = Curriculo::factory()->create([
            'user_id' => $user->id,
            'language' => 'pt_br',
            'external_url' => 'https://meu-cv.com/pdf',
        ]);

        $vaga = Vaga::factory()->create([
            'user_id' => $user->id,
            'cargo' => 'Desenvolvedor Laravel',
            'empresa' => 'Empresa X',
            'language' => 'pt_br',
        ]);

        $mailData = [
            'empresa' => $vaga->empresa,
            'email' => $vaga->email,
            'recrutador' => $vaga->recrutador,
            'cargo' => $vaga->cargo,
            'language' => $vaga->language,
            'relocation' => $vaga->relocation,
            'relocation_city' => $vaga->relocation_city,
            'nome' => $user->name,
            'linkedin' => $user->linkedin_link,
            'github' => $user->github_link,
            'user_email' => $user->email,
            'application_text' => $user->application_text,
            'cover_letter' => $user->cover_letter,
            'curriculo_url' => $curriculo->external_url,
            'is_fallback_english' => false,
        ];

        $mailable = new SendEmailWithAttachment($mailData);

        // Assert no attachments
        $this->assertEmpty($mailable->attachments());

        // Render the view to check content
        $html = view('email.application', ['data' => $mailData])->render();

        $this->assertStringContainsString('Olá, tenho interesse na vaga.', $html);
        $this->assertStringContainsString('Currículo', $html);
        $this->assertStringContainsString('https://meu-cv.com/pdf', $html);
        $this->assertStringContainsString('Linkedin', $html);
        $this->assertStringContainsString('https://linkedin.com/in/felipe', $html);
        $this->assertStringContainsString('Github', $html);
        $this->assertStringContainsString('https://github.com/felipe', $html);
        $this->assertStringNotContainsString('Empresa X', $html); // Should not be in the body anymore
        
        // Check for specific highlight styles
        $this->assertStringContainsString('color: #0077b5;', $html); // LinkedIn color
        $this->assertStringContainsString('color: #333;', $html); // Github color
    }

    public function test_email_view_has_correct_formatting_with_only_user_data(): void
    {
        $mailData = [
            'empresa' => 'Tech Corp',
            'email' => 'hr@tech.com',
            'recrutador' => 'John Doe',
            'cargo' => 'Laravel Developer',
            'language' => 'us',
            'relocation' => false,
            'relocation_city' => null,
            'nome' => 'Felipe Silva',
            'linkedin' => 'https://linkedin.com/in/felipe',
            'github' => 'https://github.com/felipe',
            'user_email' => 'felipe@test.com',
            'application_text' => 'Hello, I am interested.',
            'cover_letter' => null,
            'curriculo_url' => 'https://meu-cv.com/en',
            'is_fallback_english' => false,
        ];

        $html = view('email.application', ['data' => $mailData])->render();

        $this->assertStringContainsString('Hello, I am interested.', $html);
        $this->assertStringContainsString('Currículo', $html); // Text is now fixed to "Currículo"
        $this->assertStringContainsString('Linkedin', $html);
        $this->assertStringContainsString('Github', $html);
        $this->assertStringNotContainsString('Tech Corp', $html);
        $this->assertStringNotContainsString('John Doe', $html);
    }

    public function test_email_view_replaces_company_placeholder(): void
    {
        $mailData = [
            'empresa' => 'Apple Inc',
            'email' => 'hr@apple.com',
            'recrutador' => 'Tim Cook',
            'cargo' => 'iOS Developer',
            'language' => 'pt_br',
            'relocation' => false,
            'relocation_city' => null,
            'nome' => 'Felipe Silva',
            'linkedin' => 'https://linkedin.com/in/felipe',
            'github' => 'https://github.com/felipe',
            'user_email' => 'felipe@test.com',
            'application_text' => 'Olá, gostaria de trabalhar na [NOME_EMPRESA].',
            'cover_letter' => 'Prezados da [NOME_EMPRESA], segue meu CV.',
            'curriculo_url' => 'https://meu-cv.com/pt',
            'is_fallback_english' => false,
        ];

        $mailable = new SendEmailWithAttachment($mailData);
        $content = $mailable->content();
        $html = $content->htmlString;

        $this->assertStringContainsString('Olá, gostaria de trabalhar na Apple Inc.', $html);
        $this->assertStringContainsString('Prezados da Apple Inc, segue meu CV.', $html);
        $this->assertStringNotContainsString('[NOME_EMPRESA]', $html);
    }
}
