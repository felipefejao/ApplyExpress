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
    
    <p>My name is <b>{{ $data['nome'] }}</b>, and I am writing to express my interest in the position of <b>{{ $data['cargo'] }}</b>. I believe that my skills and experiences align well with the requirements of the position, and I am excited about the possibility of contributing to the team at <b>{{ $data['empresa'] }}</b>.</p>
    <p>Attached, I am sending my resume for review. I am available for an interview at any time and eagerly look forward to the opportunity to discuss how I can contribute to the success of your company.</p>
    
    <p>Thank you for your time and consideration.</p>
    <p>Sincerely,</p>
    <h3>{{ $data['nome'] }}</h3>
    <p><a target="_blank" href="{{ $data['linkedin'] }}">LinkedIn</a></p>
    <p><a target="_blank" href="{{ $data['github'] }}">GitHub</a></p>
</div>
</body>
</html>
