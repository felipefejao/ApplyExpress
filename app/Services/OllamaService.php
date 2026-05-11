<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OllamaService
{
    public function improveHtml(string $html, string $language): string
    {
        try {
            $response = Http::timeout(120)->post('http://localhost:11434/api/generate', [
                'model' => 'mistral',
                'prompt' => $this->buildPrompt($html, $language),
                'stream' => false,
            ]);

            return $response->json()['response'];
        } catch (\Exception $e) {
            return $html;
        }
    }

    private function buildPrompt(string $html,string $language)
    {
        return config('prompt.html-improvement') . "
            all text MUST be translate to {$language}.
            HTML:
            {$html}
        ";
    }
}
