@extends('template.index')

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

@section('main')
<div class="relative min-h-screen pb-16">
    <!-- Header -->
    <header class="fixed top-0 w-full bg-white shadow-sm z-50 px-4 py-3 flex justify-between items-center">
        <div class="flex items-center">
            <h1 class="text-2xl font-bold text-primary tracking-tight">Ceritia</h1>
        </div>
        <div class="flex items-center space-x-2">
            <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded-full overflow-hidden">
                <img src="https://readdy.ai/api/search-image?query=young%20indonesian%20woman%20portrait%2C%20soft%20lighting%2C%20professional%20headshot%2C%20friendly%20smile%2C%20isolated%20on%20light%20background%2C%20high%20quality&width=100&height=100&seq=1&orientation=squarish"
                    alt="Profile" class="w-full h-full object-cover">
            </div>
        </div>
    </header>
    <!-- Main Content Area -->
    <main class="pt-16 pb-16">
        <!-- Chat Section -->
        <section id="chat-section" class="px-4 py-6">
            <div class="bg-white rounded-lg shadow-sm p-4 h-[550px] flex flex-col">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 flex items-center justify-center bg-primary rounded-full overflow-hidden">
                        <i class="ri-robot-line text-white ri-lg"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="font-medium text-gray-800">Ceritia AI</h3>
                        <p class="text-xs text-gray-500">Online • Siap mendengarkan</p>
                    </div>
                    <button
                        class="ml-auto bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-medium flex items-center !rounded-button cursor-pointer">
                        <i class="ri-first-aid-kit-line mr-1"></i> Bantuan Darurat
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto space-y-4 mb-4" id="chat-container">
                    <div class="flex items-start">
                        <div class="chat-bubble-ai bg-gray-100 p-3 max-w-[80%] text-gray-700 text-sm">
                            <p>Halo! Aku Ceritia, teman ceritamu hari ini. Bagaimana perasaanmu sekarang? Aku siap
                                mendengarkan apapun yang ingin kamu bagikan. 😊</p>
                        </div>
                    </div>
                    <div class="flex items-start justify-end">
                        <div class="chat-bubble-user bg-primary p-3 max-w-[80%] text-white text-sm">
                            <p>Hai Ceritia, hari ini aku merasa sedikit cemas karena besok ada presentasi penting di
                                kantor.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="chat-bubble-ai bg-gray-100 p-3 max-w-[80%] text-gray-700 text-sm">
                            <p>Aku mengerti perasaan cemas sebelum presentasi penting. Itu hal yang wajar dan
                                menunjukkan bahwa kamu peduli dengan pekerjaanmu. Sudahkah kamu mempersiapkan
                                presentasimu? Mungkin kita bisa membahas beberapa teknik pernapasan atau visualisasi
                                positif yang bisa membantumu merasa lebih tenang.</p>
                        </div>
                    </div>
                    <div class="flex items-start justify-end">
                        <div class="chat-bubble-user bg-primary p-3 max-w-[80%] text-white text-sm">
                            <p>Iya, aku sudah menyiapkan materinya, tapi tetap saja merasa gugup. Biasanya aku jadi
                                blank saat banyak orang menatapku.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="chat-bubble-ai bg-gray-100 p-3 max-w-[80%] text-gray-700 text-sm">
                            <p>Kamu sudah melangkah dengan baik dengan mempersiapkan materi! Untuk mengatasi
                                kecemasan saat presentasi, coba teknik 4-7-8: tarik napas selama 4 detik, tahan 7
                                detik, dan keluarkan selama 8 detik. Lakukan beberapa kali sebelum presentasi.</p>
                            <p class="mt-2">Juga, ingat bahwa audiens ingin kamu berhasil. Mereka hadir untuk
                                mendapatkan informasi, bukan untuk mengkritik. Bagaimana kalau kamu mencoba
                                visualisasi positif malam ini? Bayangkan presentasimu berjalan lancar dan mendapat
                                respons positif.</p>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <input type="text" id="chat-input" placeholder="Ceritakan hari-mu..."
                        class="w-full border border-gray-200 rounded-full py-3 px-4 pr-12 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm !rounded-button">
                    <button
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 w-8 h-8 flex items-center justify-center bg-primary rounded-full text-white cursor-pointer">
                        <i class="ri-send-plane-fill"></i>
                    </button>
                </div>
            </div>
        </section>
        <!-- Mood Detector Section -->
        <section id="mood-section" class="px-4 py-6 hidden">
            <div class="bg-white rounded-lg shadow-sm p-4">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Bagaimana perasaanmu hari ini?</h2>
                <div class="grid grid-cols-4 gap-3 mb-6">
                    <div class="mood-card bg-yellow-50 p-3 rounded-lg flex flex-col items-center cursor-pointer">
                        <div class="w-12 h-12 flex items-center justify-center">
                            <img src="https://readdy.ai/api/search-image?query=icon%2C%203D%20cartoon%2C%20happy%20emoji%20face%2C%20the%20icon%20should%20take%20up%2070%25%20of%20the%20frame%2C%20vibrant%20yellow%20color%20with%20soft%20gradients%2C%20minimalist%20design%2C%20smooth%20rounded%20shapes%2C%20subtle%20shading%2C%20no%20outlines%2C%20centered%20composition%2C%20isolated%20on%20white%20background%2C%20playful%20and%20friendly%20aesthetic%2C%20high%20detail%20quality%2C%20clean%20and%20modern%20look&width=64&height=64&seq=1&orientation=squarish"
                                alt="Senang" class="w-full h-full object-contain">
                        </div>
                        <span class="text-xs mt-2 text-gray-700">Senang</span>
                    </div>
                    <div class="mood-card bg-blue-50 p-3 rounded-lg flex flex-col items-center cursor-pointer">
                        <div class="w-12 h-12 flex items-center justify-center">
                            <img src="https://readdy.ai/api/search-image?query=icon%2C%203D%20cartoon%2C%20sad%20emoji%20face%2C%20the%20icon%20should%20take%20up%2070%25%20of%20the%20frame%2C%20soft%20blue%20color%20with%20gentle%20gradients%2C%20minimalist%20design%2C%20smooth%20rounded%20shapes%2C%20subtle%20shading%2C%20no%20outlines%2C%20centered%20composition%2C%20isolated%20on%20white%20background%2C%20emotional%20and%20sympathetic%20aesthetic%2C%20high%20detail%20quality%2C%20clean%20and%20modern%20look&width=64&height=64&seq=2&orientation=squarish"
                                alt="Sedih" class="w-full h-full object-contain">
                        </div>
                        <span class="text-xs mt-2 text-gray-700">Sedih</span>
                    </div>
                    <div class="mood-card bg-red-50 p-3 rounded-lg flex flex-col items-center cursor-pointer">
                        <div class="w-12 h-12 flex items-center justify-center">
                            <img src="https://readdy.ai/api/search-image?query=icon%2C%203D%20cartoon%2C%20angry%20emoji%20face%2C%20the%20icon%20should%20take%20up%2070%25%20of%20the%20frame%2C%20soft%20red%20color%20with%20gentle%20gradients%2C%20minimalist%20design%2C%20smooth%20rounded%20shapes%2C%20subtle%20shading%2C%20no%20outlines%2C%20centered%20composition%2C%20isolated%20on%20white%20background%2C%20emotional%20and%20expressive%20aesthetic%2C%20high%20detail%20quality%2C%20clean%20and%20modern%20look&width=64&height=64&seq=3&orientation=squarish"
                                alt="Marah" class="w-full h-full object-contain">
                        </div>
                        <span class="text-xs mt-2 text-gray-700">Marah</span>
                    </div>
                    <div class="mood-card bg-purple-50 p-3 rounded-lg flex flex-col items-center cursor-pointer">
                        <div class="w-12 h-12 flex items-center justify-center">
                            <img src="https://readdy.ai/api/search-image?query=icon%2C%203D%20cartoon%2C%20anxious%20emoji%20face%2C%20the%20icon%20should%20take%20up%2070%25%20of%20the%20frame%2C%20soft%20purple%20color%20with%20gentle%20gradients%2C%20minimalist%20design%2C%20smooth%20rounded%20shapes%2C%20subtle%20shading%2C%20no%20outlines%2C%20centered%20composition%2C%20isolated%20on%20white%20background%2C%20worried%20and%20concerned%20aesthetic%2C%20high%20detail%20quality%2C%20clean%20and%20modern%20look&width=64&height=64&seq=4&orientation=squarish"
                                alt="Cemas" class="w-full h-full object-contain">
                        </div>
                        <span class="text-xs mt-2 text-gray-700">Cemas</span>
                    </div>
                </div>
                <div class="mb-6">
                    <label for="mood-detail" class="block text-sm font-medium text-gray-700 mb-2">Ceritakan lebih
                        detail tentang perasaanmu:</label>
                    <textarea id="mood-detail" rows="4"
                        class="w-full border border-gray-200 rounded p-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                        placeholder="Aku merasa... karena..."></textarea>
                </div>
                <button
                    class="w-full bg-primary text-white py-3 rounded-lg font-medium mb-6 !rounded-button cursor-pointer">Analisis
                    Perasaanku</button>
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                    <h3 class="font-medium text-gray-800 mb-2">Hasil Analisis Mood</h3>
                    <div class="flex items-center mb-3">
                        <div class="w-10 h-10 flex items-center justify-center bg-purple-100 rounded-full">
                            <img src="https://readdy.ai/api/search-image?query=icon%2C%203D%20cartoon%2C%20anxious%20emoji%20face%2C%20the%20icon%20should%20take%20up%2070%25%20of%20the%20frame%2C%20soft%20purple%20color%20with%20gentle%20gradients%2C%20minimalist%20design%2C%20smooth%20rounded%20shapes%2C%20subtle%20shading%2C%20no%20outlines%2C%20centered%20composition%2C%20isolated%20on%20white%20background%2C%20worried%20and%20concerned%20aesthetic%2C%20high%20detail%20quality%2C%20clean%20and%20modern%20look&width=50&height=50&seq=5&orientation=squarish"
                                alt="Cemas" class="w-8 h-8 object-contain">
                        </div>
                        <div class="ml-3">
                            <h4 class="font-medium text-gray-800">Kecemasan Ringan</h4>
                            <p class="text-xs text-gray-500">Terdeteksi pada 9 Mei 2025, 14:30</p>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h5 class="text-sm font-medium text-gray-700 mb-1">Definisi:</h5>
                        <p class="text-sm text-gray-600">Kecemasan ringan adalah perasaan khawatir atau tegang yang
                            muncul terkait dengan situasi tertentu. Biasanya bersifat sementara dan masih dapat
                            dikelola.</p>
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
                            <button
                                class="ml-auto w-8 h-8 flex items-center justify-center bg-gray-100 rounded-full cursor-pointer">
                                <i class="ri-play-fill text-primary"></i>
                            </button>
                        </div>
                    </div>
                    <button
                        class="w-full bg-secondary text-white py-2 rounded-lg text-sm font-medium !rounded-button cursor-pointer">Catat
                        Mood Ini</button>
                </div>
            </div>
        </section>
        <!-- Dashboard Section -->
        <section id="dashboard-section" class="px-4 py-6 hidden">
            <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Statistik Mood</h2>
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-sm font-medium text-gray-700">Minggu Ini</h3>
                        <button class="text-xs text-primary font-medium cursor-pointer">Lihat Bulanan</button>
                    </div>
                    <div class="h-48 w-full bg-gray-50 rounded-lg overflow-hidden">
                        <img src="https://readdy.ai/api/search-image?query=clean%20and%20minimalist%20mood%20tracking%20chart%20with%20days%20of%20the%20week%20on%20x-axis%20and%20mood%20levels%20on%20y-axis%2C%20showing%20fluctuating%20emotional%20states%20throughout%20the%20week%20with%20a%20slight%20upward%20trend%2C%20using%20soft%20blue%20and%20pink%20colors%20on%20white%20background%2C%20professional%20data%20visualization%2C%20clean%20design%2C%20no%20text%20labels&width=400&height=200&seq=6&orientation=landscape"
                            alt="Mood Chart" class="w-full h-full object-cover">
                    </div>
                </div>
                <div class="grid grid-cols-4 gap-2 mb-4">
                    <div class="bg-yellow-50 p-2 rounded-lg text-center">
                        <div class="w-8 h-8 mx-auto flex items-center justify-center">
                            <img src="https://readdy.ai/api/search-image?query=icon%2C%203D%20cartoon%2C%20happy%20emoji%20face%2C%20the%20icon%20should%20take%20up%2070%25%20of%20the%20frame%2C%20vibrant%20yellow%20color%20with%20soft%20gradients%2C%20minimalist%20design%2C%20smooth%20rounded%20shapes%2C%20subtle%20shading%2C%20no%20outlines%2C%20centered%20composition%2C%20isolated%20on%20white%20background%2C%20playful%20and%20friendly%20aesthetic%2C%20high%20detail%20quality%2C%20clean%20and%20modern%20look&width=40&height=40&seq=7&orientation=squarish"
                                alt="Senang" class="w-full h-full object-contain">
                        </div>
                        <span class="text-xs text-gray-700 block mt-1">Senang</span>
                        <span class="text-xs font-medium text-gray-800 block">2x</span>
                    </div>
                    <div class="bg-blue-50 p-2 rounded-lg text-center">
                        <div class="w-8 h-8 mx-auto flex items-center justify-center">
                            <img src="https://readdy.ai/api/search-image?query=icon%2C%203D%20cartoon%2C%20sad%20emoji%20face%2C%20the%20icon%20should%20take%20up%2070%25%20of%20the%20frame%2C%20soft%20blue%20color%20with%20gentle%20gradients%2C%20minimalist%20design%2C%20smooth%20rounded%20shapes%2C%20subtle%20shading%2C%20no%20outlines%2C%20centered%20composition%2C%20isolated%20on%20white%20background%2C%20emotional%20and%20sympathetic%20aesthetic%2C%20high%20detail%20quality%2C%20clean%20and%20modern%20look&width=40&height=40&seq=8&orientation=squarish"
                                alt="Sedih" class="w-full h-full object-contain">
                        </div>
                        <span class="text-xs text-gray-700 block mt-1">Sedih</span>
                        <span class="text-xs font-medium text-gray-800 block">1x</span>
                    </div>
                    <div class="bg-red-50 p-2 rounded-lg text-center">
                        <div class="w-8 h-8 mx-auto flex items-center justify-center">
                            <img src="https://readdy.ai/api/search-image?query=icon%2C%203D%20cartoon%2C%20angry%20emoji%20face%2C%20the%20icon%20should%20take%20up%2070%25%20of%20the%20frame%2C%20soft%20red%20color%20with%20gentle%20gradients%2C%20minimalist%20design%2C%20smooth%20rounded%20shapes%2C%20subtle%20shading%2C%20no%20outlines%2C%20centered%20composition%2C%20isolated%20on%20white%20background%2C%20emotional%20and%20expressive%20aesthetic%2C%20high%20detail%20quality%2C%20clean%20and%20modern%20look&width=40&height=40&seq=9&orientation=squarish"
                                alt="Marah" class="w-full h-full object-contain">
                        </div>
                        <span class="text-xs text-gray-700 block mt-1">Marah</span>
                        <span class="text-xs font-medium text-gray-800 block">1x</span>
                    </div>
                    <div class="bg-purple-50 p-2 rounded-lg text-center">
                        <div class="w-8 h-8 mx-auto flex items-center justify-center">
                            <img src="https://readdy.ai/api/search-image?query=icon%2C%203D%20cartoon%2C%20anxious%20emoji%20face%2C%20the%20icon%20should%20take%20up%2070%25%20of%20the%20frame%2C%20soft%20purple%20color%20with%20gentle%20gradients%2C%20minimalist%20design%2C%20smooth%20rounded%20shapes%2C%20subtle%20shading%2C%20no%20outlines%2C%20centered%20composition%2C%20isolated%20on%20white%20background%2C%20worried%20and%20concerned%20aesthetic%2C%20high%20detail%20quality%2C%20clean%20and%20modern%20look&width=40&height=40&seq=10&orientation=squarish"
                                alt="Cemas" class="w-full h-full object-contain">
                        </div>
                        <span class="text-xs text-gray-700 block mt-1">Cemas</span>
                        <span class="text-xs font-medium text-gray-800 block">3x</span>
                    </div>
                </div>
            </div>
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
            <div class="bg-white rounded-lg shadow-sm p-4">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Aktivitas Rekomendasi</h2>
                <div class="space-y-3">
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <div class="w-10 h-10 flex items-center justify-center bg-blue-100 rounded-full">
                            <i class="ri-mental-health-fill text-blue-500"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-800">Meditasi 10 Menit</h3>
                            <p class="text-xs text-gray-500">Mengurangi kecemasan</p>
                        </div>
                        <div class="ml-auto">
                            <span class="text-xs font-medium text-primary">+15 poin</span>
                        </div>
                    </div>
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <div class="w-10 h-10 flex items-center justify-center bg-green-100 rounded-full">
                            <i class="ri-run-fill text-green-500"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-800">Jalan Santai 20 Menit</h3>
                            <p class="text-xs text-gray-500">Menyegarkan pikiran</p>
                        </div>
                        <div class="ml-auto">
                            <span class="text-xs font-medium text-primary">+20 poin</span>
                        </div>
                    </div>
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <div class="w-10 h-10 flex items-center justify-center bg-purple-100 rounded-full">
                            <i class="ri-book-read-fill text-purple-500"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-800">Membaca Buku</h3>
                            <p class="text-xs text-gray-500">Menenangkan pikiran</p>
                        </div>
                        <div class="ml-auto">
                            <span class="text-xs font-medium text-primary">+10 poin</span>
                        </div>
                    </div>
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <div class="w-10 h-10 flex items-center justify-center bg-yellow-100 rounded-full">
                            <i class="ri-music-2-fill text-yellow-500"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-gray-800">Mendengarkan Musik</h3>
                            <p class="text-xs text-gray-500">Relaksasi dan ketenangan</p>
                        </div>
                        <div class="ml-auto">
                            <span class="text-xs font-medium text-primary">+5 poin</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
                    <button
                        class="bg-primary text-white px-4 py-2 rounded-full text-sm whitespace-nowrap !rounded-button cursor-pointer">Semua</button>
                    <button
                        class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full text-sm whitespace-nowrap !rounded-button cursor-pointer">Kecemasan</button>
                    <button
                        class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full text-sm whitespace-nowrap !rounded-button cursor-pointer">Depresi</button>
                    <button
                        class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full text-sm whitespace-nowrap !rounded-button cursor-pointer">Motivasi</button>
                    <button
                        class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full text-sm whitespace-nowrap !rounded-button cursor-pointer">Relasi</button>
                </div>
                <div class="space-y-4">
                    <div class="border border-gray-100 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center">
                                <div
                                    class="w-8 h-8 flex items-center justify-center bg-blue-100 rounded-full text-blue-500">
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
                        <p class="text-sm text-gray-700 mb-3">Hari ini saya merasa sangat cemas menghadapi
                            presentasi di kantor. Bagaimana cara kalian mengatasi kecemasan saat harus berbicara di
                            depan banyak orang?</p>
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
                                <div
                                    class="w-8 h-8 flex items-center justify-center bg-green-100 rounded-full text-green-500">
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
                        <p class="text-sm text-gray-700 mb-3">Setelah 3 bulan konsisten meditasi setiap pagi, saya
                            merasa jauh lebih tenang menghadapi masalah. Mood saya juga lebih stabil. Sangat
                            merekomendasikan untuk teman-teman yang sering merasa cemas.</p>
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
                                <div
                                    class="w-8 h-8 flex items-center justify-center bg-purple-100 rounded-full text-purple-500">
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
                        <p class="text-sm text-gray-700 mb-3">Saya kesulitan mengkomunikasikan perasaan saya pada
                            pasangan. Kadang merasa tidak dimengerti. Ada yang punya tips bagaimana cara memulai
                            percakapan tentang perasaan tanpa terkesan menyalahkan?</p>
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
            <button
                class="fixed bottom-20 right-4 w-14 h-14 flex items-center justify-center bg-primary rounded-full shadow-lg text-white cursor-pointer">
                <i class="ri-add-fill ri-xl"></i>
            </button>
        </section>
        <!-- Bottom Navigation -->
        <nav class="fixed bottom-0 w-full bg-white border-t border-gray-200 px-2 py-2 flex justify-between z-50">
            <button id="nav-home"
                class="flex flex-col items-center justify-center w-1/5 text-primary cursor-pointer">
                <div class="w-6 h-6 flex items-center justify-center">
                    <i class="ri-home-fill ri-lg"></i>
                </div>
                <span class="text-xs mt-1">Home</span>
            </button>
            <button id="nav-chat"
                class="flex flex-col items-center justify-center w-1/5 text-gray-500 cursor-pointer">
                <div class="w-6 h-6 flex items-center justify-center">
                    <i class="ri-message-3-fill ri-lg"></i>
                </div>
                <span class="text-xs mt-1">Chat</span>
            </button>
            <button id="nav-mood"
                class="flex flex-col items-center justify-center w-1/4 text-gray-500 cursor-pointer">
                <div class="w-6 h-6 flex items-center justify-center">
                    <i class="ri-emotion-line ri-lg"></i>
                </div>
                <span class="text-xs mt-1">Mood</span>
            </button>
            <button id="nav-dashboard"
                class="flex flex-col items-center justify-center w-1/4 text-gray-500 cursor-pointer">
                <div class="w-6 h-6 flex items-center justify-center">
                    <i class="ri-dashboard-line ri-lg"></i>
                </div>
                <span class="text-xs mt-1">Dashboard</span>
            </button>
            <button id="nav-community"
                class="flex flex-col items-center justify-center w-1/5 text-gray-500 cursor-pointer">
                <div class="w-6 h-6 flex items-center justify-center">
                    <i class="ri-group-line ri-lg"></i>
                </div>
                <span class="text-xs mt-1">Komunitas</span>
            </button>
        </nav>
        <!-- Landing Page Section -->
        <section id="home-section" class="px-4 py-6 pb-16 w-full">
            <!-- Hero Section -->
            <section class="pt-24 pb-16 relative overflow-hidden">
                <div class="absolute inset-0 z-0"
                    style="background-image: url('https://readdy.ai/api/search-image?query=A%20serene%20and%20calming%20landscape%20with%20soft%20blue%20and%20green%20tones%2C%20showing%20a%20peaceful%20natural%20scene%20with%20mountains%2C%20water%2C%20and%20sky.%20The%20left%20side%20has%20a%20smooth%20gradient%20transition%20to%20a%20clean%20white%20background%2C%20perfect%20for%20text%20overlay.%20The%20image%20conveys%20tranquility%2C%20mindfulness%2C%20and%20emotional%20wellbeing%20with%20soft%20lighting%20and%20gentle%20colors.&width=1600&height=900&seq=hero1&orientation=landscape'); background-size: cover; background-position: center;">
                </div>
                <div class="container mx-auto px-4 relative z-10">
                    <div class="w-full flex flex-col md:flex-row items-center">
                        <div class="w-full md:w-1/2 hero-gradient p-8 rounded-lg"
                            style="background: rgba(255,255,255,0.2);">
                            <h1 class="text-4xl md:text-5xl font-bold text-gray mb-4">Sahabat Kesejahteraan
                                Emosional Anda</h1>
                            <p class="text-lg text-gray-800 mb-8 ">Gunakan Ceritia untuk melacak, memahami, dan
                                meningkatkan kesehatan emosional Anda. Aplikasi kami yang didukung AI akan membantu
                                Anda memahami perasaan Anda dan memantau perkembangan kesehatan Anda dari hari ke
                                hari.</p>
                            <div class="flex flex-col sm:flex-row gap-4">
                                <button
                                    class="bg-primary text-white px-6 py-3 !rounded-button hover:bg-opacity-90 transition-colors flex items-center justify-center gap-2 whitespace-nowrap">
                                    <div class="w-6 h-6 flex items-center justify-center">
                                        <i class="ri-apple-fill ri-lg"></i>
                                    </div>
                                    App Store
                                </button>
                                <button
                                    class="bg-secondary text-white px-6 py-3 !rounded-button hover:bg-opacity-90 transition-colors flex items-center justify-center gap-2 whitespace-nowrap">
                                    <div class="w-6 h-6 flex items-center justify-center">
                                        <i class="ri-google-play-fill ri-lg"></i>
                                    </div>
                                    Google Play
                                </button>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2"></div>
                    </div>
                </div>
            </section>
            <!-- Features Section -->
            <section id="features" class="py-16 bg-white">
                <div class="container mx-auto px-4">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">Bagaimana Ceritia Membantu Anda</h2>
                        <p class="text-gray-600 max-w-2xl mx-auto">Aplikasi kami menggabungkan teknologi modern
                            dengan kecerdasan emosional untuk memberi Anda dukungan yang dipersonalisasi.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                            <div
                                class="w-14 h-14 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mb-4">
                                <div class="w-6 h-6 flex items-center justify-center text-primary">
                                    <i class="ri-emotion-happy-line ri-xl"></i>
                                </div>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Deteksi Suasana Hati</h3>
                            <p class="text-gray-600">Lacak emosi Anda dengan antarmuka intuitif Ceritia dan
                                dapatkan wawasan serta rekomendasi aktivitas yang sesuai dengan pola emosi Anda.</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                            <div
                                class="w-14 h-14 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mb-4">
                                <div class="w-6 h-6 flex items-center justify-center text-primary">
                                    <i class="ri-robot-line ri-xl"></i>
                                </div>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Pendamping AI</h3>
                            <p class="text-gray-600">Chatbot AI kami yang berempati memberikan dukungan, dorongan
                                refleksi, dan rekomendasi yang dipersonalisasi serta layanan bantuan darurat di
                                kondisi yang emergency.</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                            <div
                                class="w-14 h-14 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mb-4">
                                <div class="w-6 h-6 flex items-center justify-center text-primary">
                                    <i class="ri-bar-chart-line ri-xl"></i>
                                </div>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Dashboard Analisis</h3>
                            <p class="text-gray-600">Visualisasi perjalanan emosional Anda dengan analisis
                                komprehensif dan wawasan yang dapat menyelesaikan masalah Anda, serta hewan
                                peliharaan virtual pilihan Anda.</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                            <div
                                class="w-14 h-14 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mb-4">
                                <div class="w-6 h-6 flex items-center justify-center text-primary">
                                    <i class="ri-group-line ri-xl"></i>
                                </div>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Komunitas Empatik</h3>
                            <p class="text-gray-600">Terhubung dengan orang lain dalam perjalanan yang sama dan
                                membangun komunitas yang mendukung untuk pertumbuhan emosional.</p>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Antarmuka Aplikasi -->
            <section id="app-interface" class="py-16 bg-primary bg-opacity-10">
                <div class="container mx-auto px-4">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-primary mb-4">Antarmuka Aplikasi</h2>
                        <p class="text-gray-700 max-w-2xl mx-auto">Dirancang dengan cermat untuk memberikan
                            pengalaman pengguna yang menenangkan dan intuitif.</p>
                    </div>
                    <div class="flex-1 flex-2 md:flex 1-2 gap-7 justify-center items-stretch">
                        <!-- Card 1: Mood Today -->
                        <div class="bg-white rounded-xl shadow-lg p-6 w-full md:w-1/3 flex flex-col items-center">
                            <h3 class="text-lg font-semibold text-primary mb-2">Suasana Saat Ini</h3>
                            <div class="text-5xl mb-2">😊</div>
                            <div class="text-base font-medium text-gray-800 mb-4">Senang</div>
                            <div class="w-full">
                                <h4 class="text-sm font-semibold text-gray-700 mb-1">Kemajuan Mingguan</h4>
                                <div class="w-full bg-gray-200 rounded-full h-3 mb-2">
                                    <div class="bg-primary h-3 rounded-full" style="width:75%"></div>
                                </div>
                                <div class="flex justify-between text-xs text-gray-500">
                                    <span>Senin</span>
                                    <span>Jum'at</span>
                                    <span>Minggu</span>
                                </div>
                            </div>
                        </div>
                        <!-- Card 2: Daily Activities -->
                        <div class="bg-white rounded-xl shadow-lg p-6 w-full md:w-1/3 flex flex-col items-center">
                            <h3 class="text-lg font-semibold text-primary mb-2">Kegiatan Hari Ini</h3>
                            <ul class="w-full space-y-2 mb-4">
                                <li class="flex items-center">
                                    <i class="ri-meditation-line text-xl text-primary mr-2"></i>
                                    <span>Meditasi pagi</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="ri-book-2-line text-xl text-primary mr-2"></i>
                                    <span>Jurnal rasa syukur</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="ri-moon-clear-line text-xl text-primary mr-2"></i>
                                    <span>Refleksi malam</span>
                                </li>
                            </ul>
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Bagaimana perasaanmu hari ini?
                            </h4>
                            <div class="flex justify-center gap-2 mb-2">
                                <span class="text-2xl cursor-pointer">😊</span>
                                <span class="text-2xl cursor-pointer">😐</span>
                                <span class="text-2xl cursor-pointer">😢</span>
                                <span class="text-2xl cursor-pointer">😡</span>
                                <span class="text-2xl cursor-pointer">😴</span>
                            </div>
                            <textarea
                                class="w-full border border-gray-200 rounded p-2 text-sm mb-2 focus:outline-none focus:ring-2 focus:ring-primary"
                                rows="2" placeholder="Beritahu kami lebih lanjut:"></textarea>
                            <button
                                class="w-full bg-primary text-white py-2 rounded-lg font-medium !rounded-button cursor-pointer">Simpan
                                Suasana Hati</button>
                        </div>
                        <!-- Card 3: Chat Example -->
                        <div class="bg-white rounded-xl shadow-lg p-6 w-full md:w-1/3 flex flex-col">
                            <h3 class="text-lg font-semibold text-primary mb-2">Chat Ceritia AI</h3>
                            <div class="flex flex-col gap-2 mb-2">
                                <div
                                    class="self-start bg-primary bg-opacity-10 text-gray-800 px-4 py-2 rounded-2xl max-w-[80%]">
                                    Hai Emily, apa kabarmu hari ini?</div>
                                <div class="self-end bg-primary text-white px-4 py-2 rounded-2xl max-w-[80%]">Aku
                                    merasa agak cemas tentang presentasiku besok.</div>
                                <div
                                    class="self-start bg-primary bg-opacity-10 text-gray-800 px-4 py-2 rounded-2xl max-w-[80%]">
                                    Saya mengerti. Apakah Anda ingin mencoba latihan pernapasan cepat untuk membantu
                                    menenangkan saraf Anda?</div>
                            </div>
                            <input type="text"
                                class="w-full border border-gray-200 rounded-full py-2 px-4 mt-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary"
                                placeholder="Ketik pesan...">
                        </div>
                    </div>
                    <!-- Card 4: Mood Analysis Chart -->
                    <div class="mt-12 flex flex-col md:flex-row gap-8 justify-center items-center">
                        <div class="bg-white rounded-xl shadow-lg p-6 w-full md:w-1/2">
                            <h3 class="text-lg font-semibold text-primary mb-4">Analisis Suasana Hati</h3>
                            <div class="flex justify-between text-xs text-gray-500 mb-2">
                                <span>Senin</span>
                                <span>Selasa</span>
                                <span>Rabu</span>
                                <span>Kamis</span>
                                <span>Jum'at</span>
                                <span>Sabtu</span>
                                <span>Minggu</span>
                            </div>
                            <img src="https://readdy.ai/api/search-image?query=clean%20and%20minimalist%20mood%20tracking%20chart%20with%20days%20of%20the%20week%20on%20x-axis%20and%20mood%20levels%20on%20y-axis%2C%20showing%20fluctuating%20emotional%20states%20throughout%20the%20week%20with%20a%20slight%20upward%20trend%2C%20using%20soft%20blue%20and%20pink%20colors%20on%20white%20background%2C%20professional%20data%20visualization%2C%20clean%20design%2C%20no%20text%20labels&width=400&height=200&seq=6&orientation=landscape"
                                alt="Mood Chart" class="w-full h-40 object-cover rounded-lg mb-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-700 font-medium">Kebahagiaan</span>
                                <span class="text-sm text-primary font-bold">75% <span
                                        class="text-green-500">↑</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- App Features Details -->
            <section class="py-16 bg-white">
                <div class="container mx-auto px-4">
                    <div class="flex flex-col md:flex-row items-center gap-12">
                        <div class="w-full md:w-1/2">
                            <img src="https://readdy.ai/api/search-image?query=A%20calming%20and%20serene%20image%20showing%20a%20person%20meditating%20or%20practicing%20mindfulness%20in%20a%20peaceful%20natural%20setting.%20The%20image%20has%20soft%20blue%20and%20green%20tones%2C%20with%20gentle%20lighting%20that%20creates%20a%20tranquil%20atmosphere.%20The%20background%20shows%20elements%20of%20nature%20like%20water%2C%20trees%2C%20or%20mountains%20that%20convey%20peace%20and%20emotional%20wellbeing.%20The%20composition%20is%20balanced%20with%20the%20person%20as%20the%20main%20focus%2C%20showing%20a%20state%20of%20calm%20and%20emotional%20balance.&width=600&height=400&seq=feature1&orientation=landscape"
                                alt="Mindfulness features"
                                class="w-full h-auto rounded-lg shadow-lg object-cover object-top">
                        </div>
                        <div class="w-full md:w-1/2">
                            <h2 class="text-3xl font-bold text-gray-800 mb-6">Dukungan Suasana Hati yang
                                Dipersonalisasi</h2>
                            <div class="space-y-6">
                                <div class="flex">
                                    <div
                                        class="w-12 h-12 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                        <div class="w-6 h-6 flex items-center justify-center text-primary">
                                            <i class="ri-mental-health-line ri-lg"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Deteksi Suasana Hati
                                            yang Didukung AI</h3>
                                        <p class="text-gray-600">Algoritme canggih kami menganalisis input Anda
                                            untuk mengidentifikasi kondisi emosi Anda secara akurat dan memberikan
                                            dukungan yang relevan.</p>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div
                                        class="w-12 h-12 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                        <div class="w-6 h-6 flex items-center justify-center text-primary">
                                            <i class="ri-customer-service-2-line ri-lg"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Dukungan Emosional
                                            24/7</h3>
                                        <p class="text-gray-600">Dapatkan bantuan segera kapan pun Anda
                                            membutuhkannya, dengan pendamping AI kami yang tersedia sepanjang waktu
                                            untuk membantu Anda memproses emosi Anda.</p>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div
                                        class="w-12 h-12 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                        <div class="w-6 h-6 flex items-center justify-center text-primary">
                                            <i class="ri-heart-pulse-line ri-lg"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Integrasi yang dapat
                                            Digunakan</h3>
                                        <p class="text-gray-600">Hubungkan dengan pelacak kebugaran dan jam tangan
                                            pintar Anda untuk mendapatkan wawasan yang lebih dalam tentang bagaimana
                                            kesehatan fisik Anda memengaruhi kesejahteraan emosional Anda.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Testimonials -->
            <section id="testimonials" class="py-16 bg-gray-50">
                <div class="container mx-auto px-4">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">Apa Kata Pengguna Kami</h2>
                        <p class="text-gray-600 max-w-2xl mx-auto">Kata mereka yang telah mengubah kesejahteraan
                            emosional mereka dengan Ceritia.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
                            <img src="https://randomuser.me/api/portraits/women/10.jpg"
                                class="w-16 h-16 rounded-full mb-2" alt="User 1">
                            <p class="text-gray-700 text-center mb-2">"Ceritia membantu saya memahami emosi saya
                                dan selalu ada ketika saya membutuhkan dukungan setiap hari."</p>
                            <span class="text-sm text-primary font-semibold">Mira, 19</span>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
                            <img src="https://randomuser.me/api/portraits/men/60.jpg"
                                class="w-16 h-16 rounded-full mb-2" alt="User 2">
                            <p class="text-gray-700 text-center mb-2">"Pelacakan suasana hati dan fitur komunitas
                                sangat membantu ketika saya sedang bingung dengan kondisi emosional saya dan
                                membutuhkan seseorang untuk berbagi cerita."</p>
                            <span class="text-sm text-primary font-semibold">Aris, 24</span>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center">
                            <img src="https://randomuser.me/api/portraits/women/40.jpg"
                                class="w-16 h-16 rounded-full mb-2" alt="User 3">
                            <p class="text-gray-700 text-center mb-2">"Saya suka dashboard analisis. Itu membantu
                                saya dalam melihat kemajuan diri saya dan tetap termotivasi."</p>
                            <span class="text-sm text-primary font-semibold">Sinta, 27</span>
                        </div>
                    </div>
                </div>
            </section>
            <!-- App Features Showcase -->
            <section class="py-16 bg-white">
                <div class="container mx-auto px-4">
                    <div class="flex flex-col md:flex-row items-center gap-12">
                        <div class="w-full md:w-1/2 order-2 md:order-1">
                            <h2 class="text-3xl font-bold text-gray-800 mb-6">Pertumbuhan Emosi dengan Permainan
                            </h2>
                            <div class="space-y-6">
                                <div class="flex">
                                    <div
                                        class="w-12 h-12 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                        <div class="w-6 h-6 flex items-center justify-center text-primary">
                                            <i class="ri-award-line ri-lg"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Sistem Prestasi</h3>
                                        <p class="text-gray-600">Dapatkan poin dan hadiah saat Anda menyelesaikan
                                            aktivitas yang meningkatkan kesejahteraan emosional Anda.</p>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div
                                        class="w-12 h-12 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                        <div class="w-6 h-6 flex items-center justify-center text-primary">
                                            <i class="ri-calendar-check-line ri-lg"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Tantangan Beruntun
                                        </h3>
                                        <p class="text-gray-600">Bangun kebiasaan sehat melalui pemeriksaan harian
                                            dan aktivitas yang memperkuat praktik emosional yang positif.</p>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div
                                        class="w-12 h-12 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                        <div class="w-6 h-6 flex items-center justify-center text-primary">
                                            <i class="ri-group-line ri-lg"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Tantangan Komunitas
                                        </h3>
                                        <p class="text-gray-600">Bergabunglah dengan kegiatan dan tantangan
                                            komunitas untuk terhubung dengan orang lain dan saling memotivasi dalam
                                            perjalanan kesejahteraan emosional Anda.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 order-1 md:order-2">
                            <img src="https://readdy.ai/api/search-image?query=A%20modern%20and%20clean%20image%20showing%20a%20smartphone%20with%20a%20wellness%20app%20interface%20displayed%20on%20screen.%20The%20app%20interface%20shows%20achievement%20badges%2C%20progress%20charts%2C%20and%20gamification%20elements%20like%20points%20and%20rewards.%20The%20image%20has%20a%20clean%2C%20minimalist%20style%20with%20soft%20blue%20and%20green%20color%20tones%20that%20match%20the%20apps%20calming%20aesthetic.%20The%20composition%20shows%20the%20phone%20being%20held%20or%20placed%20on%20a%20clean%20surface%20with%20some%20subtle%20decorative%20elements%20around%20it%20that%20suggest%20wellness%20and%20mindfulness.&width=600&height=400&seq=feature2&orientation=landscape"
                                alt="Gamification features"
                                class="w-full h-auto rounded-lg shadow-lg object-cover object-top">
                        </div>
                    </div>
                </div>
            </section>
            <!-- User Profile Section -->
            <section class="py-16 bg-gray-50">
                <div class="container mx-auto px-4">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">Pengalaman Pengguna yang Dipersonalisasi
                        </h2>
                        <p class="text-gray-600 max-w-2xl mx-auto mb-8">Profil yang beradaptasi dengan perjalanan
                            emosional Anda yang unik, memberikan dukungan yang disesuaikan di setiap langkah.</p>
                    </div>
                    <div class="flex flex-col md:flex-row gap-8 items-center justify-center">
                        <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center w-full md:w-1/3">
                            <img src="https://randomuser.me/api/portraits/men/60.jpg"
                                class="w-16 h-16 rounded-full mb-2" alt="User Profile">
                            <h3 class="text-xl font-semibold text-gray-800 mb-1">Profil Anda</h3>
                            <p class="text-gray-600 text-center mb-2">Lacak riwayat suasana hati Anda, tetapkan
                                tujuan, dan sesuaikan pengalaman Anda.</p>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center w-full md:w-1/3">
                            <i class="ri-flag-2-line text-primary text-4xl mb-2"></i>
                            <h3 class="text-xl font-semibold text-gray-800 mb-1">Tujuan</h3>
                            <p class="text-gray-600 text-center mb-2">Tetapkan sasaran kesejahteraan emosional dan
                                pantau perkembangan hidup Anda dari waktu ke waktu.</p>
                        </div>
                        <div class="bg-white rounded-lg shadow p-6 flex flex-col items-center w-full md:w-1/3">
                            <i class="ri-history-line text-primary text-4xl mb-2"></i>
                            <h3 class="text-xl font-semibold text-gray-800 mb-1">Riwayat Aktivitas</h3>
                            <p class="text-gray-600 text-center mb-2">Tinjau kembali aktivitas Anda di masa lalu
                                dan lihat bagaimana kebiasaan Anda memengaruhi suasana hati Anda.</p>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Pricing Section -->
            <section class="py-16 bg-white">
                <div class="container mx-auto px-4">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">Pilih Perjalanan Kesejahteraan Hidup Anda
                        </h2>
                        <p class="text-gray-600 max-w-2xl mx-auto">Pilih paket yang paling sesuai dengan kebutuhan
                            kesehatan emosional Anda</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                        <div class="bg-gray-50 rounded-lg shadow p-8 flex flex-col items-center">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Gratis</h3>
                            <p class="text-gray-600 mb-4">Pelacakan suasana hati dasar, obrolan AI, dan akses
                                komunitas.</p>
                            <div class="text-3xl font-bold text-primary mb-4">Rp0</div>
                            <ul class="text-gray-600 mb-6 space-y-2 text-center">
                                <li>✔️ Lacak Suasana Hati 24/7</li>
                                <li>✔️ Analisis Dasar</li>
                                <li>✔️ Obrolan AI (terbatas)</li>
                                <li>✔️ Komunitas (hanya lihat)</li>
                            </ul>
                            <button
                                class="bg-primary text-white px-6 py-3 !rounded-button hover:bg-opacity-90 transition-colors font-semibold">Mulai</button>
                        </div>
                        <div
                            class="bg-white border-2 border-primary rounded-lg shadow-lg p-8 flex flex-col items-center scale-105">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Premium</h3>
                            <p class="text-gray-600 mb-4">Analisis tingkat lanjut, obrolan AI tanpa batas, dan
                                lebih banyak fitur.</p>
                            <div class="text-3xl font-bold text-primary mb-4">Rp39.000<span
                                    class="text-base font-normal text-gray-600">/bulan</span></div>
                            <ul class="text-gray-600 mb-6 space-y-2 text-center">
                                <li>✔️ Semua fitur gratis</li>
                                <li>✔️ Obrolan AI 24/7</li>
                                <li>✔️ Analisis Lanjutan</li>
                                <li>✔️ Wawasan Personalisasi</li>
                                <li>✔️ Dukungan Prioritas</li>
                                <li>✔️ Virtual Pet</li>
                            </ul>
                            <button
                                class="bg-primary text-white px-6 py-3 !rounded-button hover:bg-opacity-90 transition-colors font-semibold">Tingkatkan
                                Sekarang</button>
                        </div>
                        <div class="bg-gray-50 rounded-lg shadow p-8 flex flex-col items-center">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Keluarga</h3>
                            <p class="text-gray-600 mb-4">Berbagi perjalanan emosional Anda dengan orang yang Anda
                                cintai.</p>
                            <div class="text-3xl font-bold text-primary mb-4">Rp135.000<span
                                    class="text-base font-normal text-gray-600">/bulan</span></div>
                            <ul class="text-gray-600 mb-6 space-y-2 text-center">
                                <li>✔️ Semua fitur Premium</li>
                                <li>✔️ Hingga 5 anggota keluarga</li>
                                <li>✔️ Dasbor analisis keluarga</li>
                                <li>✔️ Tantangan kelompok</li>
                            </ul>
                            <button
                                class="bg-primary text-white px-6 py-3 !rounded-button hover:bg-opacity-90 transition-colors font-semibold">Dapatkan
                                Paket Keluarga</button>
                        </div>
                    </div>
                </div>
            </section>
            <!-- CTA Section -->
            <section class="py-16 bg-primary bg-opacity-5">
                <div class="container mx-auto px-4 text-center">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Mulailah Perjalanan Kesejahteraan Emosional
                        Anda Hari Ini</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto mb-8">Bergabunglah dengan ribuan pengguna yang
                        mengubah hubungan mereka dengan emosi mereka dan membangun ketahanan dari hari ke hari.</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button
                            class="bg-primary text-white px-8 py-3 !rounded-button hover:bg-opacity-90 transition-colors flex items-center justify-center gap-2 whitespace-nowrap">
                            <div class="w-6 h-6 flex items-center justify-center">
                                <i class="ri-apple-fill ri-lg"></i>
                            </div>
                            Dapatkan di App Store
                        </button>
                        <button
                            class="bg-secondary text-white px-8 py-3 !rounded-button hover:bg-opacity-90 transition-colors flex items-center justify-center gap-2 whitespace-nowrap">
                            <div class="w-6 h-6 flex items-center justify-center">
                                <i class="ri-google-play-fill ri-lg"></i>
                            </div>
                            Dapatkan di Google Play
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection