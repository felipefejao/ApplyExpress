<?php

    namespace App\Filament\Resources;

    use App\Filament\Resources\CurriculoResource\Pages;
    use App\Models\Curriculo;
    use Filament\Forms;
    use Filament\Forms\Form;
    use Filament\Resources\Resource;
    use Filament\Tables;
    use Filament\Tables\Table;
    use Illuminate\Database\Eloquent\Builder;

    class CurriculoResource extends Resource
    {
        protected static ?string $model = Curriculo::class;

        protected static ?string $navigationIcon = 'heroicon-o-document-text';

        protected static ?string $navigationLabel = 'Meus Currículos';

        protected static ?string $label = 'Currículo';

        protected static ?string $pluralLabel = 'Currículos';

        public static function shouldRegisterNavigation(): bool
        {
            return auth()->user()?->isCandidato() || auth()->user()?->isSuperAdmin();
        }

        public static function form(Form $form): Form
        {
            return $form
                ->schema([
                    Forms\Components\TextInput::make('description')
                        ->label('Descrição')
                        ->placeholder('Ex: Currículo Fullstack, Currículo Backend...')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('external_url')
                        ->label('URL Externa')
                        ->placeholder('https://...')
                        ->url()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('language')
                        ->label('Idioma')
                        ->options([
                            'pt_br' => 'Português (Brasil)',
                            'us' => 'Inglês',
                            'es' => 'Espanhol',
                            'de' => 'Alemão',
                            'fr' => 'Francês',
                        ])
                        ->required(),

                ]);
        }

        public static function table(Table $table): Table
        {
            return $table
                ->columns([
                    Tables\Columns\TextColumn::make('description')
                        ->label('Descrição')
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('external_url')
                        ->label('URL Externa')
                        ->copyable()
                        ->searchable(),
                    Tables\Columns\TextColumn::make('language')
                        ->label('Idioma')
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('created_at')
                        ->label('Criado em')
                        ->dateTime()
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true),
                ])
                ->filters([
                    //
                ])
                ->actions([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
                ->bulkActions([
                    Tables\Actions\BulkActionGroup::make([
                        Tables\Actions\DeleteBulkAction::make(),
                    ]),
                ]);
        }

        public static function getEloquentQuery(): Builder
        {
            return parent::getEloquentQuery()
                ->where('user_id', auth()->id());
        }

        public static function getPages(): array
        {
            return [
                'index' => Pages\ListCurriculos::route('/'),
                'create' => Pages\CreateCurriculo::route('/create'),
                'edit' => Pages\EditCurriculo::route('/{record}/edit'),
            ];
        }
    }
