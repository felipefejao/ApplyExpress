<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VagaResource\Pages;
use App\Filament\Resources\VagaResource\RelationManagers;
use App\Models\Vaga;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VagaResource extends Resource
{
    protected static ?string $model = Vaga::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Vagas';

    protected static ?string $label = 'Vagas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('empresa')
                    ->label('Empresa')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->required(),
                Forms\Components\TextInput::make('recrutador')
                    ->label('Recrutador'),
                Forms\Components\TextInput::make('cargo')
                    ->label('Cargo')
                    ->required(),
                Forms\Components\Select::make('language')
                    ->label('Idioma')
                    ->required()
                    ->options([
                        'pt_br' => 'Nacional',
                        'us' => 'Inglês',
                        'es' => 'Espanhol',
                        'de' => 'Alemão',
                        'fr' => 'Francês',
                    ]),
                Forms\Components\Checkbox::make('enviado')
                    ->label('Enviado'),
                Section::make('Realocação')
                    ->schema([
                        Forms\Components\Checkbox::make('relocation')
                            ->label('Realocação?'),
                        Forms\Components\TextInput::make('relocation_city')
                            ->label('Cidade para Realocação')
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('empresa')->sortable()->searchable(),
                TextColumn::make('email')->sortable()->searchable(),
                TextColumn::make('recrutador')->sortable()->searchable(),
                TextColumn::make('cargo')->sortable()->searchable(),
                TextColumn::make('language')->sortable()->searchable(),
                Tables\Columns\BooleanColumn::make('enviado')->label('Enviado')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVagas::route('/'),
            'create' => Pages\CreateVaga::route('/create'),
            'edit' => Pages\EditVaga::route('/{record}/edit'),
        ];
    }
}
