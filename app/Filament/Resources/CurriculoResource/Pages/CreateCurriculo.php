<?php

namespace App\Filament\Resources\CurriculoResource\Pages;

use App\Filament\Resources\CurriculoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCurriculo extends CreateRecord
{
    protected static string $resource = CurriculoResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
