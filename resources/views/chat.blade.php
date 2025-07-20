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
<button class="ml-auto bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-medium flex items-center !rounded-button cursor-pointer">
<i class="ri-first-aid-kit-line mr-1"></i> Bantuan Darurat
</button>
</div>
<div class="flex-1 overflow-y-auto space-y-4 mb-4" id="chat-container">
<div class="flex items-start">
<div class="chat-bubble-ai bg-gray-100 p-3 max-w-[80%] text-gray-700 text-sm">
<p>Halo! Aku Ceritia, teman ceritamu hari ini. Bagaimana perasaanmu sekarang? Aku siap mendengarkan apapun yang ingin kamu bagikan. 😊</p>
</div>
</div>
<div class="flex items-start justify-end">
<div class="chat-bubble-user bg-primary p-3 max-w-[80%] text-white text-sm">
<p>Hai Ceritia, hari ini aku merasa sedikit cemas karena besok ada presentasi penting di kantor.</p>
</div>
</div>
<div class="flex items-start">
<div class="chat-bubble-ai bg-gray-100 p-3 max-w-[80%] text-gray-700 text-sm">
<p>Aku mengerti perasaan cemas sebelum presentasi penting. Itu hal yang wajar dan menunjukkan bahwa kamu peduli dengan pekerjaanmu. Sudahkah kamu mempersiapkan presentasimu? Mungkin kita bisa membahas beberapa teknik pernapasan atau visualisasi positif yang bisa membantumu merasa lebih tenang.</p>
</div>
</div>
<div class="flex items-start justify-end">
<div class="chat-bubble-user bg-primary p-3 max-w-[80%] text-white text-sm">
<p>Iya, aku sudah menyiapkan materinya, tapi tetap saja merasa gugup. Biasanya aku jadi blank saat banyak orang menatapku.</p>
</div>
</div>
<div class="flex items-start">
<div class="chat-bubble-ai bg-gray-100 p-3 max-w-[80%] text-gray-700 text-sm">
<p>Kamu sudah melangkah dengan baik dengan mempersiapkan materi! Untuk mengatasi kecemasan saat presentasi, coba teknik 4-7-8: tarik napas selama 4 detik, tahan 7 detik, dan keluarkan selama 8 detik. Lakukan beberapa kali sebelum presentasi.</p>
<p class="mt-2">Juga, ingat bahwa audiens ingin kamu berhasil. Mereka hadir untuk mendapatkan informasi, bukan untuk mengkritik. Bagaimana kalau kamu mencoba visualisasi positif malam ini? Bayangkan presentasimu berjalan lancar dan mendapat respons positif.</p>
</div>
</div>
</div>
<div class="relative">
<input type="text" id="chat-input" placeholder="Ceritakan hari-mu..." class="w-full border border-gray-200 rounded-full py-3 px-4 pr-12 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm !rounded-button">
<button class="absolute right-2 top-1/2 transform -translate-y-1/2 w-8 h-8 flex items-center justify-center bg-primary rounded-full text-white cursor-pointer">
<i class="ri-send-plane-fill"></i>
</button>
</div>
</div>
</section>