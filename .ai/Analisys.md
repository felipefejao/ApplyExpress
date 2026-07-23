# Análise Funcional do Projeto ApplyExpress

## Visão Geral
O **ApplyExpress** é uma aplicação Laravel projetada para automatizar e otimizar o processo de candidatura a vagas de emprego. A ferramenta permite gerenciar oportunidades de trabalho e enviar e-mails de apresentação personalizados, utilizando Inteligência Artificial para refinar o conteúdo e aumentar a taxa de conversão.

---

## Funcionalidades Principais

### 1. Gestão de Vagas (Painel Administrativo)
- **Interface Administrativa:** Utiliza o **Filament PHP** para fornecer um dashboard moderno e intuitivo.
- **Cadastro de Oportunidades:** Permite registrar detalhes cruciais de cada vaga, incluindo:
    - Nome da Empresa
    - E-mail de contato
    - Nome do Recrutador
    - Cargo pretendido
    - Idioma da aplicação (Português, Inglês, etc.)
    - Informações de Relocação (Interesse e Cidade de destino)
- **Controle de Status:** Rastreamento visual de quais e-mails já foram enviados através da coluna `enviado`.

### 2. Otimização de Conteúdo com IA
O sistema integra-se com modelos de linguagem para transformar e-mails genéricos em textos persuasivos e profissionais.
- **Ollama Service:** Integração local com o modelo **Mistral** para:
    - Melhorar a gramática e fluidez do texto.
    - Tornar a mensagem mais persuasiva.
    - Tradução automática para o idioma especificado na vaga.
- **Tratamento de HTML:** A IA é instruída a manter a estrutura e os estilos do HTML original, focando apenas na melhoria do conteúdo textual.

### 3. Sistema de Envio de E-mails
- **Envio em Lote (CLI):** Comando `php artisan app:send-emails-command` que processa todas as vagas com status `enviado = false`.
- **E-mails Personalizados:** Utiliza templates Blade (`SendEmailWithAttachment`) que injetam dados dinâmicos da vaga e do usuário.
- **Antispam & Rate Limiting:** Implementa um intervalo de segurança de 60 segundos entre cada e-mail enviado para proteger a reputação do servidor de e-mail.

### 4. Configurações de Identidade (Personalização)
- **Centralização de Dados:** Arquivo `config/user.php` que armazena informações globais do candidato:
    - Nome completo
    - LinkedIn
    - GitHub
    - E-mail de resposta
- **Assinatura Dinâmica:** Inclusão automática de links sociais e portfólio em todas as comunicações.

---

## Características Funcionais e Regras de Negócio

- **Automação de Tradução:** O sistema identifica o idioma alvo da vaga e utiliza a IA para garantir que a comunicação seja feita na língua correta.
- **Persistência de Estado:** Cada envio bem-sucedido atualiza o banco de dados, garantindo que não haja duplicidade de e-mails para a mesma vaga em execuções futuras.
- **Flexibilidade de IA:** Suporte para uso de IA local (Ollama/Mistral) ou nuvem (OpenAI/GPT-4o-mini), dependendo da configuração do serviço.
- **Anexos:** Suporte para envio de currículos ou portfólios anexados (conforme implementado em `SendEmailWithAttachment`).

---

## Stack Tecnológica
- **Backend:** Laravel 12
- **Admin Panel:** Filament PHP 3
- **Database:** SQLite (padrão)
- **IA:** Ollama (Mistral) / OpenAI API
- **Frontend Assets:** Vite & TailwindCSS
