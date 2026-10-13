<?php

namespace App\Filament\Pages;

use App\Models\Curriculo;
use Filament\Forms\Components\TextInput;
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
            'github_link' => $user->github_link,
            'linkedin_link' => $user->linkedin_link,
            'pretensao_clt' => $user->pretensao_clt,
            'pretensao_pj' => $user->pretensao_pj,
            'smtp_host' => $user->smtp_host,
            'smtp_port' => $user->smtp_port,
            'smtp_username' => $user->smtp_username,
            'smtp_password' => $user->smtp_password,
            'smtp_encryption' => $user->smtp_encryption,
            'smtp_from_address' => $user->smtp_from_address,
            'smtp_from_name' => $user->smtp_from_name,
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
                Section::make('Links Profissionais (Opcional)')
                    ->description('Adicione seus links profissionais para facilitar a visualização pelos recrutadores.')
                    ->schema([
                        TextInput::make('github_link')
                            ->label('Link do GitHub')
                            ->placeholder('https://github.com/seu-usuario')
                            ->url()
                            ->maxLength(255),
                        TextInput::make('linkedin_link')
                            ->label('Link do LinkedIn')
                            ->placeholder('https://linkedin.com/in/seu-perfil')
                            ->url()
                            ->maxLength(255),
                    ])->columns(2),
                Section::make('Pretensões Salariais')
                    ->description('Prentensões salariais para candidaturas CLTs e PJs')
                    ->schema([
                        TextInput::make('pretensao_clt')
                            ->label('Pretensão CLT')
                            ->placeholder('R$ 1.000,00'),
                        TextInput::make('pretensao_pj')
                            ->label('Pretensão PJ')
                            ->placeholder('R$ 1.000,00'),
                    ]),
                Section::make('Configurações de E-mail (SMTP)')
                    ->description('Configure seu próprio servidor SMTP para que os e-mails sejam enviados diretamente por você.')
                    ->schema([
                        TextInput::make('smtp_host')
                            ->label('Servidor SMTP')
                            ->placeholder('smtp.example.com'),
                        TextInput::make('smtp_port')
                            ->label('Porta SMTP')
                            ->numeric()
                            ->placeholder('587'),
                        TextInput::make('smtp_username')
                            ->label('Usuário SMTP')
                            ->placeholder('seu-email@example.com'),
                        TextInput::make('smtp_password')
                            ->label('Senha SMTP')
                            ->password()
                            ->revealable(),
                        Select::make('smtp_encryption')
                            ->label('Criptografia')
                            ->options([
                                'tls' => 'TLS',
                                'ssl' => 'SSL',
                                'none' => 'Nenhuma',
                            ]),
                        TextInput::make('smtp_from_address')
                            ->label('E-mail de Envio (From)')
                            ->email()
                            ->placeholder('seu-email@example.com'),
                        TextInput::make('smtp_from_name')
                            ->label('Nome de Envio (From)')
                            ->placeholder('Seu Nome'),
                    ])->columns(2),
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
