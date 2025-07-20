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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Pastikan hanya home-section yang tampil saat pertama kali
        document.getElementById('home-section').classList.remove('hidden');
        document.getElementById('chat-section').classList.add('hidden');
        document.getElementById('mood-section').classList.add('hidden');
        document.getElementById('dashboard-section').classList.add('hidden');
        document.getElementById('community-section').classList.add('hidden');

        const sections = {
            'home': document.getElementById('home-section'),
            'chat': document.getElementById('chat-section'),
            'mood': document.getElementById('mood-section'),
            'dashboard': document.getElementById('dashboard-section'),
            'community': document.getElementById('community-section')
        };
        const navButtons = {
            'home': document.getElementById('nav-home'),
            'chat': document.getElementById('nav-chat'),
            'mood': document.getElementById('nav-mood'),
            'dashboard': document.getElementById('nav-dashboard'),
            'community': document.getElementById('nav-community')
        };

        function showSection(sectionId) {
            // Hide all sections
            Object.values(sections).forEach(section => {
                section.classList.add('hidden');
            });
            // Show selected section
            sections[sectionId].classList.remove('hidden');
            // Update nav buttons
            Object.entries(navButtons).forEach(([id, button]) => {
                if (id === sectionId) {
                    button.classList.remove('text-gray-500');
                    button.classList.add('text-primary');
                } else {
                    button.classList.remove('text-primary');
                    button.classList.add('text-gray-500');
                }
            });
        }
        // Set up click handlers for nav buttons
        navButtons.home.addEventListener('click', () => showSection('home'));
        navButtons.chat.addEventListener('click', () => showSection('chat'));
        navButtons.mood.addEventListener('click', () => showSection('mood'));
        navButtons.dashboard.addEventListener('click', () => showSection('dashboard'));
        navButtons.community.addEventListener('click', () => showSection('community'));

        // Chat functionality
        const chatInput = document.getElementById('chat-input');
        const chatContainer = document.getElementById('chat-container');
        chatInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && chatInput.value.trim() !== '') {
                addMessage(chatInput.value, 'user');
                setTimeout(() => {
                    respondToMessage(chatInput.value);
                }, 1000);
                chatInput.value = '';
            }
        });

        // Tambahan interaktivitas dan animasi
        // Animasi chat bubble
        function animateBubble(bubble) {
            bubble.style.opacity = 0;
            bubble.style.transform = 'translateY(20px)';
            setTimeout(() => {
                bubble.style.transition = 'all 0.4s cubic-bezier(.4,2,.6,1)';
                bubble.style.opacity = 1;
                bubble.style.transform = 'translateY(0)';
            }, 10);
        }

        // Modifikasi addMessage agar pakai animasi
        function addMessage(message, sender) {
            const messageDiv = document.createElement('div');
            messageDiv.className = sender === 'user' ?
                'flex items-start justify-end' :
                'flex items-start';
            const bubbleDiv = document.createElement('div');
            bubbleDiv.className = sender === 'user' ?
                'chat-bubble-user bg-primary p-3 max-w-[80%] text-white text-sm' :
                'chat-bubble-ai bg-gray-100 p-3 max-w-[80%] text-gray-700 text-sm';
            bubbleDiv.style.opacity = 0;
            bubbleDiv.style.transform = 'translateY(20px)';
            const paragraph = document.createElement('p');
            paragraph.textContent = message;
            bubbleDiv.appendChild(paragraph);
            messageDiv.appendChild(bubbleDiv);
            chatContainer.appendChild(messageDiv);
            setTimeout(() => {
                bubbleDiv.style.transition = 'all 0.4s cubic-bezier(.4,2,.6,1)';
                bubbleDiv.style.opacity = 1;
                bubbleDiv.style.transform = 'translateY(0)';
            }, 10);
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        // Tombol kirim chat bisa diklik
        const chatSendBtn = chatInput.parentElement.querySelector('button');
        chatSendBtn.addEventListener('click', function() {
            if (chatInput.value.trim() !== '') {
                addMessage(chatInput.value, 'user');
                setTimeout(() => {
                    respondToMessage(chatInput.value);
                }, 1000);
                chatInput.value = '';
            }
        });

        // Mood card interaktif
        document.querySelectorAll('.mood-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.mood-card').forEach(c => c.classList.remove('ring',
                    'ring-primary', 'scale-105'));
                card.classList.add('ring', 'ring-primary', 'scale-105');
            });
        });

        // Animasi progress bar virtual pet
        function animateProgressBar(selector, percent) {
            const bar = document.querySelector(selector);
            if (bar) {
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.transition = 'width 1s cubic-bezier(.4,2,.6,1)';
                    bar.style.width = percent + '%';
                }, 100);
            }
        }
        animateProgressBar('.bg-green-400', 85);
        animateProgressBar('.bg-yellow-400', 70);
        animateProgressBar('.bg-blue-400', 60);

        // Efek pada tombol virtual pet
        document.querySelectorAll('.pet-container ~ .flex button').forEach((btn, idx) => {
            btn.addEventListener('click', function() {
                const petImg = document.querySelector('.pet-container img');
                if (petImg) {
                    petImg.classList.add('animate-bounce');
                    setTimeout(() => petImg.classList.remove('animate-bounce'), 600);
                }
                // Tambahkan efek pada progress bar
                if (idx === 0) animateProgressBar('.bg-green-400', Math.min(100, 85 + 5));
                if (idx === 1) animateProgressBar('.bg-yellow-400', Math.min(100, 70 + 10));
                if (idx === 2) animateProgressBar('.bg-blue-400', Math.min(100, 60 + 15));
            });
        });

        function respondToMessage(userMessage) {
            let response =
                "Terima kasih sudah berbagi. Aku mengerti perasaanmu. Bagaimana menurutmu jika kita mencoba beberapa teknik pernapasan atau aktivitas yang bisa membantu menenangkan pikiranmu?";
            if (userMessage.toLowerCase().includes('sedih')) {
                response =
                    "Aku mengerti kamu sedang merasa sedih. Tidak apa-apa untuk merasakan emosi ini. Maukah kamu bercerita lebih lanjut tentang apa yang membuatmu sedih? Aku di sini untuk mendengarkan.";
            } else if (userMessage.toLowerCase().includes('cemas') || userMessage.toLowerCase().includes(
                    'khawatir')) {
                response =
                    "Kecemasan bisa sangat tidak nyaman. Coba tarik napas dalam-dalam beberapa kali. Inhale... exhale... Apa yang membuatmu merasa cemas saat ini?";
            } else if (userMessage.toLowerCase().includes('marah')) {
                response =
                    "Aku mengerti kamu sedang merasa marah. Emosi ini wajar dan valid. Mungkin kita bisa mencari cara untuk menyalurkan energi ini dengan cara yang sehat. Apa yang biasanya membantumu saat merasa marah?";
            } else if (userMessage.toLowerCase().includes('senang') || userMessage.toLowerCase().includes(
                    'bahagia')) {
                response =
                    "Senang sekali mendengar kamu merasa bahagia! Momen-momen positif seperti ini penting untuk diapresiasi. Apa yang membuatmu merasa senang hari ini?";
            } else if (userMessage.toLowerCase().includes('butuh bantuan') || userMessage.toLowerCase()
                .includes('tolong')) {
                response =
                    "Aku ingin kamu tetap tenang dan perlahan tarik nafas dalam, kami disini akan membantumu melalui tombol bantuan darurat di sebelah kanan atas";
            }
            addMessage(response, 'ai');
        }
    });
</script>
