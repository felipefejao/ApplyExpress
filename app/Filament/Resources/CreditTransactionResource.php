<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CreditTransactionResource\Pages;
use App\Models\CreditTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CreditTransactionResource extends Resource
{
    protected static ?string $model = CreditTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'Transações de Créditos';

    protected static ?string $label = 'Transação';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Usuário')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->label('Quantidade')
                    ->numeric()
                    ->required(),
                Forms\Components\Select::make('type')
                    ->label('Tipo')
                    ->options([
                        'add' => 'Adição',
                        'deduct' => 'Débito',
                        'refund' => 'Reembolso',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('description')
                    ->label('Descrição'),
                Forms\Components\TextInput::make('reference_type')
                    ->label('Tipo de referência'),
                Forms\Components\TextInput::make('reference_id')
                    ->label('ID de referência')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Usuário')->searchable(),
                Tables\Columns\TextColumn::make('amount')->label('Quantidade'),
                Tables\Columns\TextColumn::make('type')->label('Tipo')->badge(),
                Tables\Columns\TextColumn::make('description')->label('Descrição'),
                Tables\Columns\TextColumn::make('created_at')->label('Data')->dateTime(),
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
            'index' => Pages\ListCreditTransactions::route('/'),
            'create' => Pages\CreateCreditTransaction::route('/create'),
            'edit' => Pages\EditCreditTransaction::route('/{record}/edit'),
        ];
    }
}
