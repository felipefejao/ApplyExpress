<?php

namespace App\Filament\Pages;

use App\Models\Curriculo;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Actions\Action;

class ApplicationSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view = 'filament.pages.application-settings';

    protected static ?string $navigationLabel = 'Configuração de Candidatura';

    protected static ?string $title = 'Configuração de Candidatura';

    protected static ?string $navigationGroup = 'Configurações';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->isCandidato() || auth()->user()?->isSuperAdmin();
    }

    public ?array $data = [];

    public function mount(): void
    {
        $user = auth()->user();
        $this->form->fill([
            'application_text' => $user->application_text,
            'cover_letter' => $user->cover_letter,
            'default_curriculo_id' => $user->default_curriculo_id,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Textos Padrão')
                    ->description('Defina os textos que serão usados por padrão em suas candidaturas.')
                    ->schema([
                        Textarea::make('application_text')
                            ->label('Texto de Candidatura (Obrigatório)')
                            ->placeholder('Escreva aqui o texto principal da sua candidatura...')
                            ->required()
                            ->rows(5),
                        Textarea::make('cover_letter')
                            ->label('Carta de Apresentação (Opcional)')
                            ->placeholder('Escreva aqui sua carta de apresentação...')
                            ->rows(5),
                    ]),
                Section::make('Currículo Padrão')
                    ->description('Selecione o currículo que será enviado por padrão.')
                    ->schema([
                        Select::make('default_curriculo_id')
                            ->label('Currículo')
                            ->options(Curriculo::where('user_id', auth()->id())->pluck('description', 'id'))
                            ->searchable()
                            ->placeholder('Selecione um currículo'),
                    ]),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Salvar Alterações')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $user = auth()->user();
        $user->update($data);

        Notification::make()
            ->title('Configurações salvas com sucesso!')
            ->success()
            ->send();
    }
}
