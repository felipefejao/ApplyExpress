<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    body {
        font-family: 'Arial', sans-serif;
        line-height: 1.6;
        color: #333;
        margin: 0;
        padding: 20px;
    }
    .container {
        max-width: 600px;
        margin: auto;
        background: #ffffff;
        padding: 20px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
    }
    .content-section {
        margin-bottom: 25px;
    }
    .links-section {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid #f0f0f0;
    }
    .link-item {
        margin-bottom: 12px;
    }
    .link-label {
        font-weight: bold;
        color: #555;
        margin-right: 5px;
    }
    .link-anchor {
        font-weight: bold;
        text-decoration: none;
    }
    .linkedin-link {
        color: #0077b5;
    }
    .github-link {
        color: #333;
    }
    .cv-link {
        color: #0056b3;
    }
    .signature {
        margin-top: 40px;
    }
    .signature-name {
        font-size: 1.2em;
        font-weight: bold;
        margin: 0;
        color: #222;
    }
</style>
</head>
<body>
<div class="container">
    @if (!empty($data['application_text']))
        <div class="content-section" style="white-space: pre-line;">
            {!! nl2br(e($data['application_text'])) !!}
        </div>
    @else
        <div class="content-section">
            <p>Olá,</p>
            <p>Gostaria de me candidatar à vaga. Seguem meus dados e links para avaliação.</p>
        </div>
    @endif

    @if (!empty($data['cover_letter']))
        <div class="content-section">
            <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
            <h3 style="color: #666; font-size: 1.1em; margin-bottom: 10px;">Carta de Apresentação</h3>
            <div style="white-space: pre-line;">
                {!! nl2br(e($data['cover_letter'])) !!}
            </div>
        </div>
    @endif

    <div class="links-section">
        @if (!empty($data['curriculo_url']))
            <div class="link-item">
                <span class="link-label">Currículo:</span>
                <a href="{{ $data['curriculo_url'] }}" class="link-anchor cv-link">Currículo</a>
            </div>
        @endif

        @if (!empty($data['linkedin']))
            <div class="link-item">
                <span class="link-label">Linkedin:</span>
                <a href="{{ $data['linkedin'] }}" class="link-anchor linkedin-link" target="_blank">Linkedin</a>
            </div>
        @endif

        @if (!empty($data['github']))
            <div class="link-item">
                <span class="link-label">Github:</span>
                <a href="{{ $data['github'] }}" class="link-anchor github-link" target="_blank">Github</a>
            </div>
        @endif
    </div>

    <div class="signature">
        <p style="margin-bottom: 5px;">Atenciosamente,</p>
        <p class="signature-name">{{ $data['nome'] }}</p>
    </div>
</div>
</body>
</html>
