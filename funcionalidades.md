# Funcionalidades do ApplyExpress

Este documento descreve as funcionalidades principais da aplicação ApplyExpress.

## 1. Job Board (Painel de Vagas Público)
O painel de vagas é a interface pública onde os usuários podem visualizar e interagir com as vagas disponíveis.

- **Listagem de Vagas**: Visualização de todas as vagas marcadas como públicas.
- **Busca e Filtro**: Busca de vagas por empresa, cargo ou palavras-chave (slugs).
- **Detalhes da Vaga**: Visualização detalhada de uma vaga específica (os IDs são criptografados para segurança).
- **Candidatura (Apply)**: Funcionalidade para o usuário logado "clonar" uma vaga pública para sua lista privada de candidaturas, permitindo o acompanhamento individual.

## 2. Gestão de Vagas (Admin Filament)
Interface administrativa para gerenciamento completo do ciclo de vida das vagas.

- **CRUD de Vagas**: Criação, leitura, atualização e exclusão de registros de vagas.
- **Multi-idioma**: Suporte para definição do idioma da vaga (Nacional/PT-BR, Inglês/US, Espanhol, Alemão, Francês).
- **Informações de Realocação**: Campos específicos para indicar se a vaga oferece auxílio realocação e para qual cidade.
- **Controle de Visibilidade**: Opção para tornar uma vaga pública (visível no Job Board) ou privada (visível apenas para o dono).
- **Status de Envio**: Controle visual se o e-mail de candidatura já foi processado/enviado.
- **Isolamento por Usuário**: Cada usuário visualiza apenas suas próprias vagas, exceto SuperAdmins.

## 3. Automação de E-mails
Sistema para automatizar o envio de currículos para as empresas.

- **Comando de Console**: `app:send-emails-command` processa as vagas pendentes de envio.
- **Disparo via Admin**: Interface no painel administrativo para acionar o processo de envio de e-mails.
- **Templates Dinâmicos**: E-mails são gerados com base no idioma e informações de realocação da vaga, utilizando dados do perfil do usuário (LinkedIn, GitHub, etc.).
- **Controle de Vazão (Rate Limiting)**: O sistema inclui pausas entre disparos para evitar bloqueios/spam.

## 4. Sistema de Assinaturas e Créditos
Modelo de negócio baseado em recorrência e transações.

- **Gestão de Planos**: Cadastro e configuração de diferentes níveis de assinatura.
- **Assinaturas**: Acompanhamento de usuários ativos em cada plano.
- **Transações de Créditos**: Sistema para gerenciar o saldo e histórico de créditos dos usuários para utilização das automações.

## 5. Perfil e Níveis de Acesso
- **Tipos de Usuário**: Suporte a diferentes papéis (Candidato, Empresa, SuperAdmin).
- **Campos de Perfil**: Armazenamento de informações profissionais essenciais para as automações.
