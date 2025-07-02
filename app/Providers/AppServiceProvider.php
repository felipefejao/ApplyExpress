<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->booted(function () {
            $schedule = app(\Illuminate\Console\Scheduling\Schedule::class);
            $schedule->job(new \App\Jobs\SendEmailsJob())
                ->everyTenMinutes()
                ->withoutOverlapping()
                ->onFailure(function (\Exception $e) {
                    Log::error('Erro ao enviar emails: ' . $e->getMessage());
                });

        });
    }
}
