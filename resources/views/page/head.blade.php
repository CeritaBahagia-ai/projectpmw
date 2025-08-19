<?php
@vite(['resources/css/app.css', 'resources/js/app.js'])
?>
  
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

h1, h2 {
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

th, td {
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
  const url = `https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=${GEMINI_API_KEY}`;
  const body = {
    contents: [
      {
        parts: [
          { text: prompt }
        ]
      }
    ]
  };
  const res = await fetch(url, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(body)
  });
  const data = await res.json();
  // Ambil hasil jawaban Gemini
  return data?.candidates?.[0]?.content?.parts?.[0]?.text || 'Maaf, AI sedang tidak bisa merespon.';
}

// Endpoint chat AI
app.post('/api/chat', async (req, res) => {
  const { userName, lastMood, message } = req.body;

  // Prompt personalisasi
  const prompt = `Nama user: ${userName || 'Teman'}
Mood terakhir: ${lastMood || 'baik'}
User: ${message}
Berikan jawaban empatik, personal, dan gunakan nama user jika relevan.`;

  try {
    const reply = await getGeminiReply(prompt);
    res.json({ reply });
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

<!-- Dashboard Section -->
<section id="dashboard-section" class="px-4 py-6 hidden">
<div class="bg-white rounded-lg shadow-sm p-4 mb-6">
<h2 class="text-lg font-semibold text-gray-800 mb-4">Statistik Mood</h2>rt" content="width=device-width, initial-scale=1.0">
<div class="mb-4">
<div class="flex justify-between items-center mb-2">
<h3 class="text-sm font-medium text-gray-700">Minggu Ini</h3>
<button class="text-xs text-primary font-medium cursor-pointer">Lihat Bulanan</button>nd.config = {
</div>
<div class="h-48 w-full bg-gray-50 rounded-lg overflow-hidden">
<img src="https://readdy.ai/api/search-image?query=clean%20and%20minimalist%20mood%20tracking%20chart%20with%20days%20of%20the%20week%20on%20x-axis%20and%20mood%20levels%20on%20y-axis%2C%20showing%20fluctuating%20emotional%20states%20throughout%20the%20week%20with%20a%20slight%20upward%20trend%2C%20using%20soft%20blue%20and%20pink%20colors%20on%20white%20background%2C%20professional%20data%20visualization%2C%20clean%20design%2C%20no%20text%20labels&width=400&height=200&seq=6&orientation=landscape" alt="Mood Chart" class="w-full h-full object-cover">colors: { primary: '#6EC1E4', secondary: '#FFB6C1' },
</div>borderRadius: { 'none': '0px', 'sm': '4px', DEFAULT: '8px', 'md': '12px', 'lg': '16px', 'xl': '20px', '2xl': '24px', '3xl': '32px', 'full': '9999px', 'button': '8px' },
</div>}
<div class="grid grid-cols-4 gap-2 mb-4">
<div class="bg-yellow-50 p-2 rounded-lg text-center">
<div class="w-8 h-8 mx-auto flex items-center justify-center">
<img src="https://readdy.ai/api/search-image?query=icon%2C%203D%20cartoon%2C%20happy%20emoji%20face%2C%20the%20icon%20should%20take%20up%2070%25%20of%20the%20frame%2C%20vibrant%20yellow%20color%20with%20soft%20gradients%2C%20minimalist%20design%2C%20smooth%20rounded%20shapes%2C%20subtle%20shading%2C%20no%20outlines%2C%20centered%20composition%2C%20isolated%20on%20white%20background%2C%20playful%20and%20friendly%20aesthetic%2C%20high%20detail%20quality%2C%20clean%20and%20modern%20look&width=40&height=40&seq=7&orientation=squarish" alt="Senang" class="w-full h-full object-contain">pt>
</div>
<span class="text-xs text-gray-700 block mt-1">Senang</span>igin>
<span class="text-xs font-medium text-gray-800 block">2x</span>href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</div>y=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<div class="bg-blue-50 p-2 rounded-lg text-center">/libs/remixicon/4.6.0/remixicon.min.css">
<div class="w-8 h-8 mx-auto flex items-center justify-center">
<img src="https://readdy.ai/api/search-image?query=icon%2C%203D%20cartoon%2C%20sad%20emoji%20face%2C%20the%20icon%20should%20take%20up%2070%25%20of%20the%20frame%2C%20soft%20blue%20color%20with%20gentle%20gradients%2C%20minimalist%20design%2C%20smooth%20rounded%20shapes%2C%20subtle%20shading%2C%20no%20outlines%2C%20centered%20composition%2C%20isolated%20on%20white%20background%2C%20emotional%20and%20sympathetic%20aesthetic%2C%20high%20detail%20quality%2C%20clean%20and%20modern%20look&width=40&height=40&seq=8&orientation=squarish" alt="Sedih" class="w-full h-full object-contain">([class^="ri-"])::before { content: "\f3c2"; }
</div>
<span class="text-xs text-gray-700 block mt-1">Sedih</span>
<span class="text-xs font-medium text-gray-800 block">1x</span>ound-color: #f9fafb;
</div>
<div class="bg-red-50 p-2 rounded-lg text-center">
<div class="w-8 h-8 mx-auto flex items-center justify-center">
<img src="https://readdy.ai/api/search-image?query=icon%2C%203D%20cartoon%2C%20angry%20emoji%20face%2C%20the%20icon%20should%20take%20up%2070%25%20of%20the%20frame%2C%20soft%20red%20color%20with%20gentle%20gradients%2C%20minimalist%20design%2C%20smooth%20rounded%20shapes%2C%20subtle%20shading%2C%20no%20outlines%2C%20centered%20composition%2C%20isolated%20on%20white%20background%2C%20emotional%20and%20expressive%20aesthetic%2C%20high%20detail%20quality%2C%20clean%20and%20modern%20look&width=40&height=40&seq=9&orientation=squarish" alt="Marah" class="w-full h-full object-contain">
</div>
<span class="text-xs text-gray-700 block mt-1">Marah</span>
<span class="text-xs font-medium text-gray-800 block">1x</span>
</div>
<div class="bg-purple-50 p-2 rounded-lg text-center">
<div class="w-8 h-8 mx-auto flex items-center justify-center">
<img src="https://readdy.ai/api/search-image?query=icon%2C%203D%20cartoon%2C%20anxious%20emoji%20face%2C%20the%20icon%20should%20take%20up%2070%25%20of%20the%20frame%2C%20soft%20purple%20color%20with%20gentle%20gradients%2C%20minimalist%20design%2C%20smooth%20rounded%20shapes%2C%20subtle%20shading%2C%20no%20outlines%2C%20centered%20composition%2C%20isolated%20on%20white%20background%2C%20worried%20and%20concerned%20aesthetic%2C%20high%20detail%20quality%2C%20clean%20and%20modern%20look&width=40&height=40&seq=10&orientation=squarish" alt="Cemas" class="w-full h-full object-contain">card:hover {
</div>
<span class="text-xs text-gray-700 block mt-1">Cemas</span>
<span class="text-xs font-medium text-gray-800 block">3x</span>ontainer {
</div>on: relative;
</div>ow: hidden;
</div>border-radius: 16px;

<div class="bg-white rounded-lg shadow-sm p-4">
<h2 class="text-lg font-semibold text-gray-800 mb-4">Aktivitas Rekomendasi</h2>
<div class="space-y-3">
<div class="flex items-center p-3 bg-gray-50 rounded-lg"><div class="w-10 h-10 flex items-center justify-center bg-blue-100 rounded-full"><i class="ri-mental-health-fill text-blue-500"></i></div><div class="ml-3"><h3 class="text-sm font-medium text-gray-800">Meditasi 10 Menit</h3><p class="text-xs text-gray-500">Mengurangi kecemasan</p></div><div class="ml-auto"><span class="text-xs font-medium text-primary">+15 poin</span></div></div><div class="flex items-center p-3 bg-gray-50 rounded-lg"><div class="w-10 h-10 flex items-center justify-center bg-green-100 rounded-full"><i class="ri-run-fill text-green-500"></i></div><div class="ml-3"><h3 class="text-sm font-medium text-gray-800">Jalan Santai 20 Menit</h3><p class="text-xs text-gray-500">Menyegarkan pikiran</p></div><div class="ml-auto"><span class="text-xs font-medium text-primary">+20 poin</span></div</div><div class="flex items-center p-3 bg-gray-50 rounded-lg"><div class="w-10 h-10 flex items-center justify-center bg-purple-100 rounded-full"><i class="ri-book-read-fill text-purple-500"></i></div><div class="ml-3"><h3 class="text-sm font-medium text-gray-800">Membaca Buku</h3><p class="text-xs text-gray-500">Menenangkan pikiran</p></div><div class="ml-auto"><span class="text-xs font-medium text-primary">+10 poin</span></div></div><div class="flex items-center p-3 bg-gray-50 rounded-lg"><div class="w-10 h-10 flex items-center justify-center bg-yellow-100 rounded-full"><i class="ri-music-2-fill text-yellow-500"></i></div><div class="ml-3"><h3 class="text-sm font-medium text-gray-800">Mendengarkan Musik</h3><p class="text-xs text-gray-500">Relaksasi dan ketenangan</p></div><div class="ml-auto"><span class="text-xs font-medium text-primary">+5 poin</span></div></div></div></div>
</section>