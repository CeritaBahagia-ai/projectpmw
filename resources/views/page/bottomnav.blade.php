@push('styles')
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
@endpush

<!-- Bottom Navigation -->
<nav class="fixed bottom-0 w-full bg-white border-t border-gray-200 px-2 py-2 flex justify-between z-50">
    <a href="{{route('home')}}" id="nav-home" class="flex flex-col items-center justify-center w-1/5 text-primary cursor-pointer">
        <div class="w-6 h-6 flex items-center justify-center">
            <i class="ri-home-fill ri-lg"></i>
        </div>
        <span class="text-xs mt-1">Home</span>
    </a>
    <a  href="{{route('chat')}}" id="nav-chat" class="flex flex-col items-center justify-center w-1/5 text-gray-500 cursor-pointer">
        <div class="w-6 h-6 flex items-center justify-center">
            <i class="ri-message-3-fill ri-lg"></i>
        </div>
        <span class="text-xs mt-1">Chat</span>
    </a> 
    <button id="nav-mood" class="flex flex-col items-center justify-center w-1/4 text-gray-500 cursor-pointer">
        <div class="w-6 h-6 flex items-center justify-center">
            <i class="ri-emotion-line ri-lg"></i>
        </div>
        <span class="text-xs mt-1">Mood</span>
    </button>
    <button id="nav-dashboard" class="flex flex-col items-center justify-center w-1/4 text-gray-500 cursor-pointer">
        <div class="w-6 h-6 flex items-center justify-center">
            <i class="ri-dashboard-line ri-lg"></i>
        </div>
        <span class="text-xs mt-1">Dashboard</span>
    </button>
    <button id="nav-community" class="flex flex-col items-center justify-center w-1/5 text-gray-500 cursor-pointer">
        <div class="w-6 h-6 flex items-center justify-center">
            <i class="ri-group-line ri-lg"></i>
        </div>
        <span class="text-xs mt-1">Komunitas</span>
    </button>
</nav>
