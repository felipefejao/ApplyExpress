<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use App\Models\Vaga;
use App\Mail\SendEmailWithAttachment;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

class SendUserEmailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Vaga $vaga)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = $this->vaga->user;

        if (!$user) {
            return;
        }

        $language = $this->vaga->language;
        $curriculo = $user->curriculos()->where('language', $language)->first();
        $is_fallback_english = false;

        if (!$curriculo && $language !== 'pt_br') {
            $curriculo = $user->curriculos()->where('language', 'us')->first();
            if ($curriculo) {
                $is_fallback_english = true;
            }
        }

        if (!$curriculo) {
            $curriculo = $user->defaultCurriculo;
        }

        $mailData = [
            'empresa' => $this->vaga->empresa,
            'email' => $this->vaga->email,
            'recrutador' => $this->vaga->recrutador,
            'cargo' => $this->vaga->cargo,
            'language' => $this->vaga->language,
            'relocation' => $this->vaga->relocation,
            'relocation_city' => $this->vaga->relocation_city,
            'nome' => $user->name,
            'linkedin' => $user->linkedin_link ?? $user->linkedin,
            'github' => $user->github_link ?? $user->github,
            'user_email' => $user->email,
            'application_text' => $user->application_text,
            'cover_letter' => $user->cover_letter,
            'curriculo_url' => $curriculo?->external_url,
            'is_fallback_english' => $is_fallback_english,
            'pretensao_clt' => $user->pretensao_clt,
            'pretensao_pj' => $user->pretensao_pj,
        ];

        if ($user->smtp_host) {
            Config::set('mail.mailers.smtp.host', $user->smtp_host);
            Config::set('mail.mailers.smtp.port', $user->smtp_port);
            Config::set('mail.mailers.smtp.encryption', $user->smtp_encryption === 'none' ? null : $user->smtp_encryption);
            Config::set('mail.mailers.smtp.username', $user->smtp_username);
            Config::set('mail.mailers.smtp.password', $user->smtp_password);

            if ($user->smtp_from_address) {
                Config::set('mail.from.address', $user->smtp_from_address);
                Config::set('mail.from.name', $user->smtp_from_name ?? $user->name);
            }

            Mail::purge('smtp');
        }

        try {
            Mail::to($this->vaga->email)->send(new SendEmailWithAttachment($mailData));
            $this->vaga->update(['enviado' => true]);
        } catch (\Exception $e) {
            // Log error or handle it as needed
            report($e);
        }
    }
}
