<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class SendEmailsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $vagas = \App\Models\Vaga::where('enviado', false)->get();

        try {
            $this->sendEmails($vagas);
        } catch (\Exception $e) {
            Log::error('Erro ao enviar emails: ' . $e->getMessage());
            // Optionally, you can rethrow the exception if you want it to be handled by the queue system
            // throw $e;
        }
    }

    private function sendEmails(Collection $vagas): void
    {
        foreach ($vagas as $vaga) {
            $sent = Mail::to($vaga->email)->send(new \App\Mail\SendEmailWithAttachment([
                'empresa' => $vaga->empresa,
                'email' => $vaga->email,
                'recrutador' => $vaga->recrutador,
                'cargo' => $vaga->cargo,
                'language' => $vaga->language,
                'nome' => config('user.nome'),
                'linkedin' => config('user.linkedin'),
                'github' => config('user.github'),
                'user_email' => config('user.email'),
            ]));

            if ($sent) {
                $vaga->update(['enviado' => true]);
                Log::info('Email enviado para ' . $vaga->empresa);
            }

            sleep(120 * 10);
        }
    }

}
