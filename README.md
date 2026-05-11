# ApplyExpress

ApplyExpress é uma aplicação Laravel projetada para facilitar a gestão de vagas e o envio de e-mails personalizados, utilizando IA para melhorar o conteúdo dos e-mails.

## Pré-requisitos

Antes de começar, certifique-se de ter os seguintes requisitos instalados em sua máquina:

*   **PHP:** >= 8.2
*   **Composer:** Gerenciador de dependências PHP
*   **Node.js & NPM:** Para compilação de assets
*   **SQLite:** (Ou outro banco de dados de sua preferência)
*   **Ollama:** Necessário para as funcionalidades de IA (utiliza o modelo `mistral`)

## Passo a Passo para Instalação

Siga as etapas abaixo para configurar o projeto localmente:

### 1. Clonar o Repositório

```bash
git clone <url-do-repositorio>
cd ApplyExpress
```

### 2. Instalar Dependências do PHP

```bash
composer install
```

### 3. Instalar Dependências do Node.js

```bash
npm install
```

### 4. Configurar o Ambiente

Copie o arquivo de exemplo do ambiente e gere a chave da aplicação:

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configurar o Banco de Dados

Por padrão, o projeto utiliza **SQLite**. O Laravel criará automaticamente o arquivo do banco de dados se ele não existir ao rodar as migrações.

Execute as migrações para criar as tabelas:

```bash
php artisan migrate
```

### 6. Link de Armazenamento

Crie o link simbólico para que os arquivos enviados fiquem acessíveis publicamente:

```bash
php artisan storage:link
```

### 7. Configurar o Ollama (IA)

Esta aplicação utiliza o [Ollama](https://ollama.com/) para melhorar o texto dos e-mails.

1.  Instale o Ollama em sua máquina.
2.  Baixe o modelo `mistral`:
    ```bash
    ollama run mistral
    ```
3.  Certifique-se de que o Ollama está rodando em `http://localhost:11434`.

### 8. Rodar a Aplicação

Para iniciar o servidor de desenvolvimento e o compilador de assets (Vite) simultaneamente, você pode usar o comando customizado definido no `composer.json`:

```bash
composer run dev
```

Ou, se preferir rodar separadamente:

```bash
# Terminal 1: Servidor Laravel
php artisan serve

# Terminal 2: Vite Assets
npm run dev
```

A aplicação estará disponível em `http://localhost:8000`.

## Envio de E-mails

Para enviar os e-mails das vagas cadastradas que ainda não foram enviados, utilize o comando:

```bash
php artisan app:send-emails-command
```

Este comando percorre as vagas com status `enviado = false`, envia o e-mail e aguarda 60 segundos entre cada envio para evitar bloqueios.

## Personalização de Dados

Os dados do remetente (nome, links sociais, etc.) que aparecem nos e-mails estão configurados em `config/user.php`. Lembre-se de alterá-los com suas informações:

```php
// config/user.php
return [
    'nome' => 'Seu Nome',
    'email' => 'seu.email@exemplo.com',
    'linkedin' => 'https://www.linkedin.com/in/seu-perfil/',
    'github' => 'https://www.github.com/seu-usuario',
];
```

## Funcionalidades Principais

*   **Gestão de Vagas:** Interface administrativa utilizando Filament.
*   **Melhoria de E-mail com IA:** Utiliza o Ollama (Mistral) para otimizar o HTML dos e-mails.
*   **Envio de E-mails:** Sistema integrado para envio de comunicações.

## Painel Administrativo

O projeto utiliza o **Filament** para o painel administrativo.
Acesse em: `http://localhost:8000/admin`

Para criar um usuário administrador:
```bash
php artisan make:filament-user
```
