<?php

namespace Tests\Feature;

use App\Jobs\SendUserEmailJob;
use App\Mail\SendEmailWithAttachment;
use App\Models\User;
use App\Models\Vaga;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserSmtpTest extends TestCase
{
    use RefreshDatabase;

    public function test_send_user_email_job_uses_user_smtp_settings(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'smtp_host' => 'smtp.custom.com',
            'smtp_port' => 587,
            'smtp_username' => 'user@custom.com',
            'smtp_password' => 'secret',
            'smtp_encryption' => 'tls',
            'smtp_from_address' => 'from@custom.com',
            'smtp_from_name' => 'Custom Sender',
        ]);

        $vaga = Vaga::factory()->create([
            'user_id' => $user->id,
            'email' => 'target@example.com',
            'enviado' => false,
        ]);

        $job = new SendUserEmailJob($vaga);
        $job->handle();

        $this->assertEquals('smtp.custom.com', Config::get('mail.mailers.smtp.host'));
        $this->assertEquals(587, Config::get('mail.mailers.smtp.port'));
        $this->assertEquals('user@custom.com', Config::get('mail.mailers.smtp.username'));
        $this->assertEquals('secret', Config::get('mail.mailers.smtp.password'));
        $this->assertEquals('tls', Config::get('mail.mailers.smtp.encryption'));
        $this->assertEquals('from@custom.com', Config::get('mail.from.address'));
        $this->assertEquals('Custom Sender', Config::get('mail.from.name'));

        Mail::assertSent(SendEmailWithAttachment::class, function ($mail) use ($vaga) {
            return $mail->hasTo($vaga->email);
        });

        $this->assertTrue($vaga->fresh()->enviado);
    }

    public function test_user_can_save_smtp_settings_via_filament(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_CANDIDATO,
        ]);

        $this->actingAs($user);

        // We use Livewire because Filament pages are Livewire components
        \Livewire\Livewire::test(\App\Filament\Pages\ApplicationSettings::class)
            ->fillForm([
                'application_text' => 'My application text',
                'smtp_host' => 'smtp.test.com',
                'smtp_port' => 465,
                'smtp_username' => 'test@test.com',
                'smtp_password' => 'new-secret',
                'smtp_encryption' => 'ssl',
                'smtp_from_address' => 'test@test.com',
                'smtp_from_name' => 'Test Name',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $user->refresh();

        $this->assertEquals('smtp.test.com', $user->smtp_host);
        $this->assertEquals(465, $user->smtp_port);
        $this->assertEquals('test@test.com', $user->smtp_username);
        $this->assertEquals('new-secret', $user->smtp_password);
        $this->assertEquals('ssl', $user->smtp_encryption);
        $this->assertEquals('test@test.com', $user->smtp_from_address);
        $this->assertEquals('Test Name', $user->smtp_from_name);
    }
}
