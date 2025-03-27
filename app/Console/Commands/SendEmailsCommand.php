<?php

namespace App\Console\Commands;

use App\Mail\SendEmailWithAttachment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmailsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-emails-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $vagas = \App\Models\Vaga::where('enviado', false)->get();

        try {
            $this->sendEmails($vagas);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    private function sendEmails($vagas)
    {
        foreach ($vagas as $vaga) {
            $sent = Mail::to($vaga->email)->send(new SendEmailWithAttachment([
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
                $this->info('Email enviado para ' . $vaga->empresa);
            }
            
            sleep(60);
        }
    }
}
