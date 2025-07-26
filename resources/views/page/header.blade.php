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

<!-- Header -->
<header class="fixed top-0 w-full bg-white shadow-sm z-50 px-4 py-3 flex justify-between items-center">
<div class="flex items-center">
<h1 class="text-2xl font-bold text-primary tracking-tight">Ceritia</h1>
</div>
<div class="flex items-center space-x-2">
<div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded-full overflow-hidden">
<img src="https://readdy.ai/api/search-image?query=young%20indonesian%20woman%20portrait%2C%20soft%20lighting%2C%20professional%20headshot%2C%20friendly%20smile%2C%20isolated%20on%20light%20background%2C%20high%20quality&width=100&height=100&seq=1&orientation=squarish" alt="Profile" class="w-full h-full object-cover">
</div>
</div>
</header>