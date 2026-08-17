<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OllamaService
{
    public function improveHtml(string $html, string $language): string
    {
        if (!$this->isEnabled()) {
            return $html;
        }

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

    public function isEnabled(): bool
    {
        try {
            $response = Http::timeout(2)->get('http://localhost:11434/api/tags');
            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }

    private function buildPrompt(string $html, string $language)
    {
        $languages = [
            'pt_br' => 'Portuguese (Brazil)',
            'us' => 'English',
            'es' => 'Spanish',
            'fr' => 'French',
            'de' => 'German',
            'it' => 'Italian',
        ];

        $targetLanguage = $languages[$language] ?? $language;

        return config('prompt.html-improvement') . "
            CRITICAL: You MUST translate ALL text content within the HTML to {$targetLanguage}.
            The original text might be in another language, but the output MUST be in {$targetLanguage}.
            Do not translate proper names or technical links if they should remain unchanged.
            
            HTML to process:
            {$html}
        ";
    }
}
