<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class Chat extends Component
{
    public $messages = [];      // Holds chat history
    public $input = '';         // User's input text
    public $userName = 'Teman';
    public $lastMood = 'baik';
    public $isLoading = false;

    public function sendMessage()
    {
        if (trim($this->input) === '')
            return;

        $this->isLoading = true; // Start loading

        // Push user message
        $this->messages[] = [
            'sender' => 'user',
            'text' => $this->input,
        ];

        $userMessage = $this->input;
        $this->input = '';

        // Call API
        $reply = $this->getGeminiReply($userMessage);

        $this->messages[] = [
            'sender' => 'ai',
            'text' => $reply,
        ];

        $this->isLoading = false; // Stop loading
        $this->dispatch('scrollChat');
    }


    private function getGeminiReply($message)
    {
        try {
            $apiKey = env('GEMINI_API_KEY');

            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}";

            $response = Http::post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => "Nama user: {$this->userName}\nMood terakhir: {$this->lastMood}\nUser: {$message}\nBerikan jawaban empatik, personal, dan gunakan nama user jika relevan."]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                return $response->json()['candidates'][0]['content']['parts'][0]['text']
                    ?? 'Maaf, AI tidak dapat memberikan jawaban.';
            }

            return "Terjadi kesalahan: " . $response->body();

        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }



    public function render()
    {
        return view('livewire.chat')->layout('template.index');
    }
}

