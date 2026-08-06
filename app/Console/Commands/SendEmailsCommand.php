<?php

namespace App\Console\Commands;

use App\Mail\SendEmailWithAttachment;
use App\Models\Vaga;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class SendEmailsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-emails-command {user_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia e-mails para vagas não enviadas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');

        $query = Vaga::where('enviado', false);

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $vagas = $query->with('user.defaultCurriculo')->get();

        if ($vagas->isEmpty()) {
            $this->info('Nenhuma vaga pendente para envio.');
            return;
        }

        try {
            $this->sendEmails($vagas);
        } catch (\Exception $e) {
            $this->error('Erro ao enviar e-mails: ' . $e->getMessage());
        }
    }

    private function sendEmails($vagas)
    {
        foreach ($vagas as $vaga) {
            $user = $vaga->user;

            if (!$user) {
                $this->warn("Vaga {$vaga->id} não tem usuário associado. Pulando...");
                continue;
            }

            $curriculo = $user->defaultCurriculo;

            $sent = Mail::to($vaga->email)->send(new SendEmailWithAttachment([
                'empresa' => $vaga->empresa,
                'email' => $vaga->email,
                'recrutador' => $vaga->recrutador,
                'cargo' => $vaga->cargo,
                'language' => $vaga->language,
                'relocation' => $vaga->relocation,
                'relocation_city' => $vaga->relocation_city,
                'nome' => $user->name,
                'linkedin' => $user->linkedin,
                'github' => $user->github,
                'user_email' => $user->email,
                'application_text' => $user->application_text,
                'cover_letter' => $user->cover_letter,
                'curriculo_url' => $curriculo?->external_url,
            ]));

            if ($sent) {
                $vaga->update(['enviado' => true]);
                $this->info('Email enviado para ' . $vaga->empresa);
            }

            sleep(10); // Reduced sleep for testing or practical use, maybe 60 is too long for a demo
        }
    }
}
