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
        <p>Prezado {{ $data['recrutador'] }},</p>
    @endif

    @if ($data['application_text'])
        <div style="white-space: pre-line; margin-bottom: 20px;">
            {!! nl2br(e($data['application_text'])) !!}
        </div>
    @else
        <p>Meu nome é <b>{{ $data['nome'] }}</b>, e estou escrevendo para expressar meu interesse na vaga de <b>{{ $data['cargo'] }}</b>. Acredito que minhas habilidades e experiências se alinham bem com os requisitos da vaga, e estou entusiasmado com a possibilidade de contribuir para a equipe da <b>{{ $data['empresa'] ?? 'empresa' }}</b>.</p>
    @endif

    @if ($data['cover_letter'])
        <hr>
        <h3>Carta de Apresentação</h3>
        <div style="white-space: pre-line; margin-bottom: 20px;">
            {!! nl2br(e($data['cover_letter'])) !!}
        </div>
    @endif

    @if (!empty($data['curriculo_url']))
        <p>
            <b>Currículo:</b> <a href="{{ $data['curriculo_url'] }}" style="font-weight: bold; color: #0056b3;">Currículo</a>
        </p>
    @endif

    <p>Estou à disposição para uma entrevista a qualquer momento e espero ansiosamente a oportunidade de discutir como posso contribuir para o sucesso da sua empresa.</p>

    @if ($data['relocation'])
        <p>Atualmente resido no interior do estado de São Paulo. Mas tenho o interesse na realocação para {{$data['relocation_city']}}. Mais um motivo para me interessar nessa posição.</p>
    @endif

    <p>Obrigado pelo seu tempo e consideração.</p>
    <p>Atenciosamente,</p>
    <h3>{{ $data['nome'] }}</h3>

    <div style="margin-top: 20px;">
        <p><strong>Linkedin:</strong> <a target="_blank" href="{{ $data['linkedin'] }}" style="font-weight: bold; color: #0077b5;">Linkedin</a></p>
        <p><strong>Github:</strong> <a target="_blank" href="{{ $data['github'] }}" style="font-weight: bold; color: #333;">Github</a></p>
    </div>
</div>
</body>
</html>
