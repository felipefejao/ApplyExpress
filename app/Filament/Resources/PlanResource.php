<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanResource\Pages;
use App\Models\Plan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationLabel = 'Planos';

    protected static ?string $label = 'Plano';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome')
                    ->required(),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\Textarea::make('description')
                    ->label('Descrição')
                    ->rows(3),
                Forms\Components\TextInput::make('price')
                    ->label('Preço')
                    ->required()
                    ->numeric()
                    ->prefix('R$'),
                Forms\Components\TextInput::make('currency')
                    ->label('Moeda')
                    ->default('BRL')
                    ->required(),
                Forms\Components\Select::make('interval')
                    ->label('Intervalo')
                    ->options([
                        'month' => 'Mensal',
                        'year' => 'Anual',
                        'lifetime' => 'Vitalício',
                    ])
                    ->default('month')
                    ->required(),
                Forms\Components\TextInput::make('credits_included')
                    ->label('Créditos incluídos')
                    ->numeric()
                    ->default(0),
                Forms\Components\KeyValue::make('features')
                    ->label('Funcionalidades'),
                Forms\Components\TextInput::make('gateway_id')
                    ->label('ID do Gateway'),
                Forms\Components\Toggle::make('is_active')
                    ->label('Ativo')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nome')->searchable(),
                Tables\Columns\TextColumn::make('price')->label('Preço')->money('BRL'),
                Tables\Columns\TextColumn::make('interval')->label('Intervalo'),
                Tables\Columns\TextColumn::make('credits_included')->label('Créditos'),
                Tables\Columns\IconColumn::make('is_active')->label('Ativo')->boolean(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlans::route('/'),
            'create' => Pages\CreatePlan::route('/create'),
            'edit' => Pages\EditPlan::route('/{record}/edit'),
        ];
    }
}
