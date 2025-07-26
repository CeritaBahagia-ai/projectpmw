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

<!-- Community Section -->
<section id="community-section" class="px-4 py-6 hidden">
<div class="bg-white rounded-lg shadow-sm p-4 mb-6">
<div class="flex items-center justify-between mb-4">
<h2 class="text-lg font-semibold text-gray-800">Komunitas</h2>
<div class="text-xs text-gray-500">
<i class="ri-shield-check-fill text-green-500 mr-1"></i> End-to-end encrypted
</div>
</div>
<div class="flex overflow-x-auto space-x-2 py-2 mb-4 scrollbar-hide">
<button class="bg-primary text-white px-4 py-2 rounded-full text-sm whitespace-nowrap !rounded-button cursor-pointer">Semua</button>
<button class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full text-sm whitespace-nowrap !rounded-button cursor-pointer">Kecemasan</button>
<button class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full text-sm whitespace-nowrap !rounded-button cursor-pointer">Depresi</button>
<button class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full text-sm whitespace-nowrap !rounded-button cursor-pointer">Motivasi</button>
<button class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full text-sm whitespace-nowrap !rounded-button cursor-pointer">Relasi</button>
</div>
<div class="space-y-4">
<div class="border border-gray-100 rounded-lg p-4">
<div class="flex justify-between items-start mb-2">
<div class="flex items-center">
<div class="w-8 h-8 flex items-center justify-center bg-blue-100 rounded-full text-blue-500">
<span class="text-xs font-medium">BK</span>
</div>
<div class="ml-2">
<h3 class="text-sm font-medium text-gray-800">BintangKecil</h3>
<p class="text-xs text-gray-500">5 menit yang lalu</p>
</div>
</div>
<div class="px-2 py-1 bg-blue-50 rounded-full">
<span class="text-xs text-blue-600">Kecemasan</span>
</div>
</div>
<p class="text-sm text-gray-700 mb-3">Hari ini saya merasa sangat cemas menghadapi presentasi di kantor. Bagaimana cara kalian mengatasi kecemasan saat harus berbicara di depan banyak orang?</p>
<div class="flex items-center justify-between">
<div class="flex items-center space-x-4">
<button class="flex items-center text-gray-500 cursor-pointer">
<i class="ri-heart-line mr-1"></i>
<span class="text-xs">24</span>
</button>
<button class="flex items-center text-gray-500 cursor-pointer">
<i class="ri-chat-1-line mr-1"></i>
<span class="text-xs">8</span>
</button>
</div>
<button class="text-xs text-primary font-medium cursor-pointer">Lihat Komentar</button>
</div>
</div>
<div class="border border-gray-100 rounded-lg p-4">
<div class="flex justify-between items-start mb-2">
<div class="flex items-center">
<div class="w-8 h-8 flex items-center justify-center bg-green-100 rounded-full text-green-500">
<span class="text-xs font-medium">PS</span>
</div>
<div class="ml-2">
<h3 class="text-sm font-medium text-gray-800">PejuangSehat</h3>
<p class="text-xs text-gray-500">2 jam yang lalu</p>
</div>
</div>
<div class="px-2 py-1 bg-green-50 rounded-full">
<span class="text-xs text-green-600">Motivasi</span>
</div>
</div>
<p class="text-sm text-gray-700 mb-3">Setelah 3 bulan konsisten meditasi setiap pagi, saya merasa jauh lebih tenang menghadapi masalah. Mood saya juga lebih stabil. Sangat merekomendasikan untuk teman-teman yang sering merasa cemas.</p>
<div class="flex items-center justify-between">
<div class="flex items-center space-x-4">
<button class="flex items-center text-gray-500 cursor-pointer">
<i class="ri-heart-line mr-1"></i>
<span class="text-xs">42</span>
</button>
<button class="flex items-center text-gray-500 cursor-pointer">
<i class="ri-chat-1-line mr-1"></i>
<span class="text-xs">15</span>
</button>
</div>
<button class="text-xs text-primary font-medium cursor-pointer">Lihat Komentar</button>
</div>
</div>
<div class="border border-gray-100 rounded-lg p-4">
<div class="flex justify-between items-start mb-2">
<div class="flex items-center">
<div class="w-8 h-8 flex items-center justify-center bg-purple-100 rounded-full text-purple-500">
<span class="text-xs font-medium">LB</span>
</div>
<div class="ml-2">
<h3 class="text-sm font-medium text-gray-800">LangitBiru</h3>
<p class="text-xs text-gray-500">Kemarin</p>
</div>
</div>
<div class="px-2 py-1 bg-purple-50 rounded-full">
<span class="text-xs text-purple-600">Relasi</span>
</div>
</div>
<p class="text-sm text-gray-700 mb-3">Saya kesulitan mengkomunikasikan perasaan saya pada pasangan. Kadang merasa tidak dimengerti. Ada yang punya tips bagaimana cara memulai percakapan tentang perasaan tanpa terkesan menyalahkan?</p>
<div class="flex items-center justify-between">
<div class="flex items-center space-x-4">
<button class="flex items-center text-gray-500 cursor-pointer">
<i class="ri-heart-line mr-1"></i>
<span class="text-xs">18</span>
</button>
<button class="flex items-center text-gray-500 cursor-pointer">
<i class="ri-chat-1-line mr-1"></i>
<span class="text-xs">23</span>
</button>
</div>
<button class="text-xs text-primary font-medium cursor-pointer">Lihat Komentar</button>
</div>
</div>
</div>
</div>
<button class="fixed bottom-20 right-4 w-14 h-14 flex items-center justify-center bg-primary rounded-full shadow-lg text-white cursor-pointer">
<i class="ri-add-fill ri-xl"></i>
</button>
</section>