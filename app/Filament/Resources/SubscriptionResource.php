<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriptionResource\Pages;
use App\Models\Subscription;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';

    protected static ?string $navigationLabel = 'Assinaturas';

    protected static ?string $label = 'Assinatura';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Usuário')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('plan_id')
                    ->label('Plano')
                    ->relationship('plan', 'name')
                    ->required(),
                Forms\Components\Select::make('gateway')
                    ->label('Gateway')
                    ->options([
                        'stripe' => 'Stripe',
                        'paddle' => 'Paddle',
                        'mercado_pago' => 'Mercado Pago',
                    ])
                    ->default('stripe')
                    ->required(),
                Forms\Components\TextInput::make('gateway_subscription_id')
                    ->label('ID da Assinatura no Gateway'),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Ativa',
                        'canceled' => 'Cancelada',
                        'past_due' => 'Atrasada',
                        'trialing' => 'Trial',
                        'paused' => 'Pausada',
                    ])
                    ->default('active')
                    ->required(),
                Forms\Components\DateTimePicker::make('trial_ends_at')
                    ->label('Fim do trial'),
                Forms\Components\DateTimePicker::make('starts_at')
                    ->label('Início')
                    ->required(),
                Forms\Components\DateTimePicker::make('ends_at')
                    ->label('Término'),
                Forms\Components\DateTimePicker::make('canceled_at')
                    ->label('Cancelada em'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Usuário')->searchable(),
                Tables\Columns\TextColumn::make('plan.name')->label('Plano')->searchable(),
                Tables\Columns\TextColumn::make('gateway')->label('Gateway'),
                Tables\Columns\TextColumn::make('status')->label('Status')->badge(),
                Tables\Columns\TextColumn::make('starts_at')->label('Início')->dateTime(),
                Tables\Columns\TextColumn::make('ends_at')->label('Término')->dateTime(),
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
            'index' => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscription::route('/create'),
            'edit' => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }
}
