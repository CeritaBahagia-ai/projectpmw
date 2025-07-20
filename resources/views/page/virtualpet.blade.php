@section('styles')
    {{ <style>
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
    </style> }}
@endsection

@push('js')
    {{ <script>
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
    </script> }}
@endpush

@section('virtual_pet')
<!-- Virtual Pet Section -->
        <section id="virtual-pet-section" class="px-4 py-6 hidden">
                       <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Virtual Pet</h2>
                    <div class="bg-primary bg-opacity-10 px-3 py-1 rounded-full">
                        <span class="text-xs font-medium text-primary">Level 3</span>
                    </div>
                </div>
                <div
                    class="pet-container bg-gradient-to-b from-blue-50 to-purple-50 p-4 flex flex-col items-center mb-4">
                    <img src="https://readdy.ai/api/search-image?query=cute%203D%20cartoon%20pet%2C%20small%20blue%20cat-like%20creature%20with%20big%20eyes%2C%20friendly%20appearance%2C%20playful%20pose%2C%20standing%20on%20its%20hind%20legs%2C%20soft%20fur%20texture%2C%20adorable%20face%20with%20a%20small%20smile%2C%20detailed%20rendering%2C%20clean%20white%20background%2C%20centered%20composition%2C%20digital%20pet%20character%20design%2C%20high%20quality%203D%20rendering&width=200&height=200&seq=11&orientation=squarish"
                        alt="Virtual Pet" class="w-32 h-32 object-contain mb-3">
                    <h3 class="text-base font-medium text-gray-800">Berry</h3>
                    <p class="text-xs text-gray-600 mb-3">Hewan peliharaan virtualmu</p>
                    <div class="w-full space-y-2">
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-gray-600">Kesehatan</span>
                                <span class="text-gray-800 font-medium">85%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-400 h-2 rounded-full" style="width: 85%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-gray-600">Kebahagiaan</span>
                                <span class="text-gray-800 font-medium">70%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-yellow-400 h-2 rounded-full" style="width: 70%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-gray-600">Energi</span>
                                <span class="text-gray-800 font-medium">60%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-400 h-2 rounded-full" style="width: 60%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <button
                        class="flex-1 bg-primary text-white py-2 rounded-lg text-sm font-medium flex items-center justify-center !rounded-button cursor-pointer">
                        <i class="ri-heart-fill mr-1"></i> Beri Makan
                    </button>
                    <button
                        class="flex-1 bg-secondary text-white py-2 rounded-lg text-sm font-medium flex items-center justify-center !rounded-button cursor-pointer">
                        <i class="ri-gamepad-fill mr-1"></i> Bermain
                    </button>
                </div>
            </div>
         </section>
         @endsection