@section('styles')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            background-color: #f9f9f9;
            color: #333;
        }

        header {
            background: #0078d7;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
        }

        main {
            padding: 20px;
        }

        h1,
        h2 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        footer {
            text-align: center;
            padding: 10px 0;
            background: #0078d7;
            color: #fff;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .chat-bubble-ai {
            border-radius: 18px 18px 18px 0;
        }

        .chat-bubble-user {
            border-radius: 18px 18px 0 18px;
        }

        .mood-card {
            transition: transform 0.3s ease;
        }

        .mood-card:hover {
            transform: translateY(-5px);
        }

        .pet-container {
            position: relative;
            overflow: hidden;
            border-radius: 16px;
        }
    </style>
@endsection

@push('js')
    <script>
        const express = require('express');
        const bodyParser = require('body-parser');
        const cors = require('cors');
        const fetch = require('node-fetch'); // npm install node-fetch@2

        const app = express();
        app.use(cors());
        app.use(bodyParser.json());

        // Ganti dengan API Key Gemini kamu
        const GEMINI_API_KEY = '';

        // Fungsi untuk request ke Gemini
        async function getGeminiReply(prompt) {
            const url =
                `https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=${GEMINI_API_KEY}`;
            const body = {
                contents: [{
                    parts: [{
                        text: prompt
                    }]
                }]
            };
            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(body)
            });
            const data = await res.json();
            // Ambil hasil jawaban Gemini
            return data?.candidates?.[0]?.content?.parts?.[0]?.text || 'Maaf, AI sedang tidak bisa merespon.';
        }

        // Endpoint chat AI
        app.post('/api/chat', async (req, res) => {
            const {
                userName,
                lastMood,
                message
            } = req.body;

            // Prompt personalisasi
            const prompt = `Nama user: ${userName || 'Teman'}
Mood terakhir: ${lastMood || 'baik'}
User: ${message}
Berikan jawaban empatik, personal, dan gunakan nama user jika relevan.`;

            try {
                const reply = await getGeminiReply(prompt);
                res.json({
                    reply
                });
            } catch (err) {
                res.json({
                    reply: `Hai ${userName || 'Teman'}, aku mengerti kamu sedang merasa ${lastMood || 'baik'}. Terima kasih sudah bercerita: "${message}". Aku di sini untuk mendengarkan dan mendukungmu!`
                });
            }
        });

        // Serve file statis (optional)
        app.use(express.static('.'));

        const PORT = 3000;
        app.listen(PORT, () => {
            console.log(`Server Ceritia berjalan di http://localhost:${PORT}`);
        });
    </script>
@endpush

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ceritia - AI Companion Mental Health</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#6EC1E4',
                        secondary: '#FFB6C1'
                    },
                    borderRadius: {
                        'none': '0px',
                        'sm': '4px',
                        DEFAULT: '8px',
                        'md': '12px',
                        'lg': '16px',
                        'xl': '20px',
                        '2xl': '24px',
                        '3xl': '32px',
                        'full': '9999px',
                        'button': '8px'
                    },
                    animation: {
                        bounce: 'bounce 0.6s'
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <style>
        :where([class^="ri-"])::before {
            content: "\f3c2";
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafb;
        }

        .chat-bubble-ai {
            border-radius: 18px 18px 18px 0;
        }

        .chat-bubble-user {
            border-radius: 18px 18px 0 18px;
        }

        .mood-card {
            transition: transform 0.3s ease;
        }

        .mood-card:hover {
            transform: translateY(-5px);
        }

        .pet-container {
            position: relative;
            overflow: hidden;
            border-radius: 16px;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="relative min-h-screen pb-16">
