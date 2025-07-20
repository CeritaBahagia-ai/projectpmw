<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ceritia - AI Companion Mental Health</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#6EC1E4',
                        secondary: '#FFB6C1'
                    },
                    borderRadius: {
                        'none': '0px',
                        'sm': '4px',
                        DEFAULT: '8px',
                        'md': '12px',
                        'lg': '16px',
                        'xl': '20px',
                        '2xl': '24px',
                        '3xl': '32px',
                        'full': '9999px',
                        'button': '8px'
                    },
                    animation: {
                        bounce: 'bounce 0.6s'
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <style>
        :where([class^="ri-"])::before {
            content: "\f3c2";
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafb;
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
    @yield('styles')
</head>

<body class="bg-gray-50">
    @yield('main')
    @include('js.index')
    @stack('js')
</body>

</html>