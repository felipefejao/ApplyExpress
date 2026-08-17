<!DOCTYPE html>
<html lang="en">
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
    <h1>Interest in the Position</h1>
    @if ($data['recrutador'])
        <p>Dear {{ $data['recrutador'] }},</p>
    @endif

    @if ($data['application_text'])
        <div style="white-space: pre-line; margin-bottom: 20px;">
            {!! nl2br(e($data['application_text'])) !!}
        </div>
    @else
        <p>My name is <b>{{ $data['nome'] }}</b>, and I am writing to express my interest in the position of <b>{{ $data['cargo'] }}</b>. I believe that my skills and experiences align well with the requirements of the position, and I am excited about the possibility of contributing to the team at <b>{{ $data['empresa'] }}</b>.</p>
    @endif

    @if ($data['cover_letter'])
        <hr>
        <h3>Cover Letter</h3>
        <div style="white-space: pre-line; margin-bottom: 20px;">
            {!! nl2br(e($data['cover_letter'])) !!}
        </div>
    @endif

    @if (!empty($data['curriculo_url']))
        <p>
            <b>Resume:</b> <a href="{{ $data['curriculo_url'] }}" style="font-weight: bold; color: #0056b3;">Resume</a>
        </p>
    @endif

    <p>I am available for an interview at any time and eagerly look forward to the opportunity to discuss how I can contribute to the success of your company.</p>

    @if ($data['relocation'])
        <p>I currently reside in Brazil, state of São Paulo. However, I am interested in realocating
            to {{$data['relocation_city']}}. This is another reason for my interest in this position.</p>
    @endif

    @if ($data['is_fallback_english'])
        <p><i>Note: I am sending my resume in English as it is the foreign language I am proficient in.</i></p>
    @endif

    @if (! in_array($data['language'], ['pt_br', 'us']))
        <p>P.S.: I take the liberty to send this e-mail using your native language, but my main language to communicate is in <b>English</b>, so my resume attached is in english too.</p>
    @endif

    <p>Thank you for your time and consideration.</p>
    <p>Sincerely,</p>
    <h3>{{ $data['nome'] }}</h3>

    <div style="margin-top: 20px;">
        <p><strong>Linkedin:</strong> <a target="_blank" href="{{ $data['linkedin'] }}" style="font-weight: bold; color: #0077b5;">Linkedin</a></p>
        <p><strong>Github:</strong> <a target="_blank" href="{{ $data['github'] }}" style="font-weight: bold; color: #333;">Github</a></p>
    </div>
</div>
</body>
</html>
