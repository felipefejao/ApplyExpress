<?php

namespace App\Filament\Resources\CurriculoResource\Pages;

use App\Filament\Resources\CurriculoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCurriculos extends ListRecords
{
    protected static string $resource = CurriculoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
