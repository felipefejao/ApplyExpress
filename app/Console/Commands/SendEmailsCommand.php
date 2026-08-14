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
            \App\Jobs\SendUserEmailJob::dispatch($vaga);
            $this->info('Job de envio agendado para ' . $vaga->empresa);
        }
    }
}
