<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TextBoostService
{
    public function improveHtml(string $html): string
    {

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.openai-api-key'),
        ])->retry(3, fn ($attempt) => $attempt * 2000)
            ->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => 'you are a professional html editor, improve the following html.',
                ],
                [
                    'role' => 'user',
                    'content' => "improve this html email following the rules: \n
                    - Do not break HTML
                    - Do not remove styles
                    - Only improve text
                    - Make it persuasive\n\nHTML:\n" . $html,
                ]
            ],
            'temperature' => 0.6,
        ]);

        dd($response);

        return $response['choice'][0]['message']['content'] ??  $html;
    }
}
