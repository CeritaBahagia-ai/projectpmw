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

<!-- Mood Detector Section -->
<section id="mood-section" class="px-4 py-6 hidden">
<div class="bg-white rounded-lg shadow-sm p-4">
<h2 class="text-lg font-semibold text-gray-800 mb-4">Bagaimana perasaanmu hari ini?</h2>
<div class="grid grid-cols-4 gap-3 mb-6">
<div class="mood-card bg-yellow-50 p-3 rounded-lg flex flex-col items-center cursor-pointer">
<div class="w-12 h-12 flex items-center justify-center">
<img src="https://readdy.ai/api/search-image?query=icon%2C%203D%20cartoon%2C%20happy%20emoji%20face%2C%20the%20icon%20should%20take%20up%2070%25%20of%20the%20frame%2C%20vibrant%20yellow%20color%20with%20soft%20gradients%2C%20minimalist%20design%2C%20smooth%20rounded%20shapes%2C%20subtle%20shading%2C%20no%20outlines%2C%20centered%20composition%2C%20isolated%20on%20white%20background%2C%20playful%20and%20friendly%20aesthetic%2C%20high%20detail%20quality%2C%20clean%20and%20modern%20look&width=64&height=64&seq=1&orientation=squarish" alt="Senang" class="w-full h-full object-contain">
</div>
<span class="text-xs mt-2 text-gray-700">Senang</span>
</div>
<div class="mood-card bg-blue-50 p-3 rounded-lg flex flex-col items-center cursor-pointer">
<div class="w-12 h-12 flex items-center justify-center">
<img src="https://readdy.ai/api/search-image?query=icon%2C%203D%20cartoon%2C%20sad%20emoji%20face%2C%20the%20icon%20should%20take%20up%2070%25%20of%20the%20frame%2C%20soft%20blue%20color%20with%20gentle%20gradients%2C%20minimalist%20design%2C%20smooth%20rounded%20shapes%2C%20subtle%20shading%2C%20no%20outlines%2C%20centered%20composition%2C%20isolated%20on%20white%20background%2C%20emotional%20and%20sympathetic%20aesthetic%2C%20high%20detail%20quality%2C%20clean%20and%20modern%20look&width=64&height=64&seq=2&orientation=squarish" alt="Sedih" class="w-full h-full object-contain">
</div>
<span class="text-xs mt-2 text-gray-700">Sedih</span>
</div>
<div class="mood-card bg-red-50 p-3 rounded-lg flex flex-col items-center cursor-pointer">
<div class="w-12 h-12 flex items-center justify-center">
<img src="https://readdy.ai/api/search-image?query=icon%2C%203D%20cartoon%2C%20angry%20emoji%20face%2C%20the%20icon%20should%20take%20up%2070%25%20of%20the%20frame%2C%20soft%20red%20color%20with%20gentle%20gradients%2C%20minimalist%20design%2C%20smooth%20rounded%20shapes%2C%20subtle%20shading%2C%20no%20outlines%2C%20centered%20composition%2C%20isolated%20on%20white%20background%2C%20emotional%20and%20expressive%20aesthetic%2C%20high%20detail%20quality%2C%20clean%20and%20modern%20look&width=64&height=64&seq=3&orientation=squarish" alt="Marah" class="w-full h-full object-contain">
</div>
<span class="text-xs mt-2 text-gray-700">Marah</span>
</div>
<div class="mood-card bg-purple-50 p-3 rounded-lg flex flex-col items-center cursor-pointer">
<div class="w-12 h-12 flex items-center justify-center">
<img src="https://readdy.ai/api/search-image?query=icon%2C%203D%20cartoon%2C%20anxious%20emoji%20face%2C%20the%20icon%20should%20take%20up%2070%25%20of%20the%20frame%2C%20soft%20purple%20color%20with%20gentle%20gradients%2C%20minimalist%20design%2C%20smooth%20rounded%20shapes%2C%20subtle%20shading%2C%20no%20outlines%2C%20centered%20composition%2C%20isolated%20on%20white%20background%2C%20worried%20and%20concerned%20aesthetic%2C%20high%20detail%20quality%2C%20clean%20and%20modern%20look&width=64&height=64&seq=4&orientation=squarish" alt="Cemas" class="w-full h-full object-contain">
</div>
<span class="text-xs mt-2 text-gray-700">Cemas</span>
</div>
</div>
<div class="mb-6">
<label for="mood-detail" class="block text-sm font-medium text-gray-700 mb-2">Ceritakan lebih detail tentang perasaanmu:</label>
<textarea id="mood-detail" rows="4" class="w-full border border-gray-200 rounded p-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Aku merasa... karena..."></textarea>
</div>
<button class="w-full bg-primary text-white py-3 rounded-lg font-medium mb-6 !rounded-button cursor-pointer">Analisis Perasaanku</button>
<div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
<h3 class="font-medium text-gray-800 mb-2">Hasil Analisis Mood</h3>
<div class="flex items-center mb-3">
<div class="w-10 h-10 flex items-center justify-center bg-purple-100 rounded-full">
<img src="https://readdy.ai/api/search-image?query=icon%2C%203D%20cartoon%2C%20anxious%20emoji%20face%2C%20the%20icon%20should%20take%20up%2070%25%20of%20the%20frame%2C%20soft%20purple%20color%20with%20gentle%20gradients%2C%20minimalist%20design%2C%20smooth%20rounded%20shapes%2C%20subtle%20shading%2C%20no%20outlines%2C%20centered%20composition%2C%20isolated%20on%20white%20background%2C%20worried%20and%20concerned%20aesthetic%2C%20high%20detail%20quality%2C%20clean%20and%20modern%20look&width=50&height=50&seq=5&orientation=squarish" alt="Cemas" class="w-8 h-8 object-contain">
</div>
<div class="ml-3">
<h4 class="font-medium text-gray-800">Kecemasan Ringan</h4>
<p class="text-xs text-gray-500">Terdeteksi pada 9 Mei 2025, 14:30</p>
</div>
</div>
<div class="mb-4">
<h5 class="text-sm font-medium text-gray-700 mb-1">Definisi:</h5>
<p class="text-sm text-gray-600">Kecemasan ringan adalah perasaan khawatir atau tegang yang muncul terkait dengan situasi tertentu. Biasanya bersifat sementara dan masih dapat dikelola.</p>
</div>
<div class="mb-4">
<h5 class="text-sm font-medium text-gray-700 mb-1">Tips Penanganan:</h5>
<ul class="text-sm text-gray-600 space-y-1 pl-5 list-disc">
<li>Latihan pernapasan dalam selama 5-10 menit</li>
<li>Meditasi singkat untuk menenangkan pikiran</li>
<li>Berjalan santai di luar ruangan</li>
<li>Berbicara dengan teman atau keluarga</li>
</ul>
</div>
<div class="mb-4">
<h5 class="text-sm font-medium text-gray-700 mb-1">Rekomendasi Playlist:</h5>
<div class="flex items-center bg-white p-2 rounded-lg">
<div class="w-10 h-10 flex items-center justify-center bg-primary rounded-lg">
<i class="ri-music-fill text-white"></i>
</div>
<div class="ml-3">
<h6 class="text-xs font-medium text-gray-800">Calming Melodies</h6>
<p class="text-xs text-gray-500">12 lagu • 45 menit</p>
</div>
<button class="ml-auto w-8 h-8 flex items-center justify-center bg-gray-100 rounded-full cursor-pointer">
<i class="ri-play-fill text-primary"></i>
</button>
</div>
</div>
<button class="w-full bg-secondary text-white py-2 rounded-lg text-sm font-medium !rounded-button cursor-pointer">Catat Mood Ini</button>
</div>
</div>
</section>