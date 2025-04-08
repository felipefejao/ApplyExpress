<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    body {
        font-family: 'Arial', sans-serif;
        line-height: 1.6;
        padding: 20px;
    }
    .container {
        max-width: 600px;
        margin: auto;
        background: #f8f8f8;
        padding: 20px;
        border: 1px solid #ddd;
    }
    .button {
        display: inline-block;
        padding: 10px 20px;
        margin: 20px 0;
        background-color: #0056b3;
        color: white;
        text-decoration: none;
        border-radius: 5px;
    }
</style>
</head>
<body>
<div class="container">
    <h1>Interesse na Vaga</h1>
    @if ($data['recrutador'])
        <p>Prezados {{ $data['recrutador'] }},</p>
    @endif
    
    <p>Meu nome é <b>{{ $data['nome'] }}</b>, e estou escrevendo para expressar meu interesse na vaga de <b>{{ $data['cargo'] }}</b>. Acredito que minhas habilidades e experiências se alinham bem com os requisitos da vaga, e estou entusiasmado com a possibilidade de contribuir para a equipe da <b>{{ $data['empresa'] ?? 'empresa' }}</b>.</p>
    <p>Em anexo, envio meu currículo para avaliação. Estou à disposição para uma entrevista a qualquer momento e espero ansiosamente a oportunidade de discutir como posso contribuir para o sucesso da sua empresa.</p>
    
    <p>Obrigado pelo seu tempo e consideração.</p>
    <p>Atenciosamente,</p>
    <h3>{{ $data['nome'] }}</h3>
    <p><a target="_blank" href="{{ $data['linkedin'] }}">LinkedIn</a></p>
    <p><a target="_blank" href="{{ $data['github'] }}">GitHub</a></p>
</div>
</body>
</html>
