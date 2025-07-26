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


   <!-- ========== CALM ZONE & MOOD DIARY TABS ========== -->
   <section> 
   <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
      <h2 class="text-lg font-semibold text-gray-800 mb-4">Calm Zone & Mood Diary</h2>
      <div class="flex space-x-2 mb-4">
        <button id="tab-calm-breath" class="px-4 py-2 rounded-full text-sm font-medium bg-primary text-white focus:outline-none">Napas</button>
        <button id="tab-calm-journal" class="px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-800 focus:outline-none">Jurnal</button>
        <button id="tab-calm-affirm" class="px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-800 focus:outline-none">Afirmasi</button>
        <button id="tab-mood-diary" class="px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-800 focus:outline-none">Mood Diary</button>
      </div>
      <!-- Napas -->
      <div id="tab-content-calm-breath">
        <div class="flex flex-col items-center">
          <div id="breath-circle" class="w-28 h-28 mb-4 rounded-full bg-primary opacity-80 transition-all duration-400 ease-in-out"></div>
          <div id="breath-text" class="mb-4 text-sm text-gray-700">Klik mulai untuk relaksasi</div>
          <button id="start-breathing" class="bg-secondary text-white px-6 py-2 rounded-full font-medium text-sm">Mulai Latihan Pernapasan</button>
        </div>
      </div>
      <!-- Jurnal -->
      <div id="tab-content-calm-journal" class="hidden">
        <form id="journal-form" class="flex flex-col items-center">
          <textarea id="journal-text" rows="3" class="w-full border border-gray-200 rounded p-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent mb-3" placeholder="Tulis perasaanmu hari ini..."></textarea>
          <button type="submit" class="bg-primary text-white px-6 py-2 rounded-full font-medium text-sm">Catat Jurnal</button>
          <div id="journal-success" class="mt-3 text-green-600 text-sm hidden">Jurnal tersimpan! 🎉</div>
        </form>
      </div>
      <!-- Afirmasi -->
      <div id="tab-content-calm-affirm" class="hidden">
        <div class="flex flex-col items-center">
          <div id="affirmation-text" class="text-lg text-primary font-semibold mb-4">"Kamu berharga dan mampu melewati hari ini."</div>
          <button id="next-affirmation" class="bg-primary text-white px-6 py-2 rounded-full font-medium text-sm">Afirmasi Lainnya</button>
        </div>
      </div>
      <!-- Mood Diary Visual -->
      <div id="tab-content-mood-diary" class="hidden">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="mood-diary-gallery"></div>
      </div>
    </div>
    <!-- ========== END CALM ZONE & MOOD DIARY TABS ========== -->

  </div>
</section>
