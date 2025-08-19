<div class="h-screen w-screen flex justify-center pt-10 pb-4">
    <section id="chat-section" class="w-full max-w-[600px] bg-white rounded-lg shadow-md flex flex-col h-full pb-[45px]">
        
        <!-- Header -->
        <div class="flex items-center p-4 border-b">
            <div class="w-10 h-10 flex items-center justify-center bg-primary rounded-full overflow-hidden">
                <i class="ri-robot-line text-white ri-lg"></i>
            </div>
            <div class="ml-3">
                <h3 class="font-medium text-gray-800">Ceritia AI</h3>
                <p class="text-xs text-gray-500">Online • Siap mendengarkan</p>
            </div>
            <button class="ml-auto bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-medium flex items-center cursor-pointer">
                <i class="ri-first-aid-kit-line mr-1"></i> Bantuan Darurat
            </button>
        </div>

        <!-- Chat Container -->
        <div id="chat-container" class="flex-1 overflow-y-auto p-4 space-y-4">
            <div class="chat-bubble-ai bg-gray-100 p-3 max-w-[80%] text-gray-700 text-sm">
<p>Halo! Aku Ceritia, teman ceritamu hari ini. Bagaimana perasaanmu sekarang? Aku siap mendengarkan apapun yang ingin kamu bagikan. 😊</p>
</div>
            @foreach ($messages as $msg)
                @if ($msg['sender'] === 'ai')
                    <div class="flex items-start">
                        <div class="chat-bubble-ai bg-gray-100 p-3 max-w-[80%] text-gray-700 text-sm">
                            <p>{{ $msg['text'] }}</p>
                        </div>
                    </div>
                @else
                    <div class="flex items-start justify-end">
                        <div class="chat-bubble-user bg-primary p-3 max-w-[80%] text-white text-sm">
                            <p>{{ $msg['text'] }}</p>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Input -->
        <div class="p-4 border-t relative">
            <input type="text" wire:model="input" wire:keydown.enter="sendMessage"
                placeholder="Ceritakan hari-mu..."
                class="w-full border border-gray-200 rounded-full py-3 px-4 pr-12 focus:outline-none focus:ring-2 focus:ring-primary text-sm">
            <button wire:click="sendMessage" wire:loading.attr="disabled" 
                class="absolute right-6 top-1/2 transform -translate-y-1/2 w-8 h-8 flex items-center justify-center rounded-full text-white bg-black cursor-pointer">
                <span wire:loading.remove><i class="ri-send-plane-fill"></i></span>
                <span wire:loading>
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </span>
            </button>
        </div>
    </section>
</div>
