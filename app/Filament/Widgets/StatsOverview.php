<?php

namespace App\Filament\Widgets;

use App\Models\Vaga;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total de Vagas', Vaga::forUser()->count())
                ->description('Vagas cadastradas no sistema')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('primary'),
            Stat::make('Vagas Enviadas', Vaga::forUser()->where('enviado', true)->count())
                ->description('Candidaturas processadas')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            Stat::make('Vagas Pendentes', Vaga::forUser()->where('enviado', false)->count())
                ->description('Aguardando envio')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            Stat::make('Total de Usuários', User::count())
                ->description('Usuários registrados')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
        ];
    }
}
