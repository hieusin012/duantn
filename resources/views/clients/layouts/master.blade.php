<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')
    <title>@yield('title', 'SportBay')</title>

    <link rel="shortcut icon" href="{{ asset('assets/client/images/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/client/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/client/css/style-min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/client/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/client/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/client/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/client/css/style-min.css') }}">




    @stack('styles')
    <style>
        #chatbot-icon {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #0084ff;
            color: white;
            font-size: 24px;
            border-radius: 50%;
            padding: 15px;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            z-index: 999;
        }

        #chatbox {
            position: fixed;
            bottom: 80px;
            right: 20px;
            width: 300px;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 10px;
            display: none;
            flex-direction: column;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }

        #chat-header {
            background-color: #0084ff;
            color: white;
            padding: 10px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            font-weight: bold;
        }

        #chat-body {
            display: flex;
            flex-direction: column;
            padding: 10px;
            max-height: 350px;
            overflow: hidden;
        }

        #chat-messages {
            flex-grow: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .message {
            max-width: 80%;
            padding: 8px 12px;
            border-radius: 18px;
            font-size: 14px;
            line-height: 1.4;
            display: inline-block;
            word-wrap: break-word;
        }

        /* Tin nhắn người dùng (bên phải) */
        .user-message {
            align-self: flex-end;
            background-color: #0084ff;
            color: white;
            border-bottom-right-radius: 4px;
        }

        /* Tin nhắn bot/người khác (bên trái) */
        .bot-message {
            align-self: flex-start;
            background-color: #e4e6eb;
            color: black;
            border-bottom-left-radius: 4px;
        }


        #chat-form {
            display: flex;
            gap: 5px;
        }

        #chat-input {
            flex-grow: 1;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #chat-form button {
            padding: 5px 10px;
            background-color: #0084ff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body class="template-index index-demo1">
    <div class="page-wrapper">
        @include('clients.layouts.partials.header')
        @yield('banner')

        @yield('content')
        <!-- Nút Chatbot -->
        <div id="chatbot-icon" onclick="toggleChat()">
            💬
        </div>

        <!-- Khung Chat -->
        <!-- Khung Chat -->
        <div id="chatbox">
            <div id="chat-header">Chat với chúng tôi!</div>
            <div id="chat-body">
                <div id="chat-messages">
                    <!-- Tin nhắn sẽ được thêm vào đây bằng JS -->
                </div>
                <form id="chat-form">
                    <input type="text" id="chat-input" placeholder="Nhập tin nhắn..." required />
                    <button type="submit">Gửi</button>
                </form>
            </div>
        </div>


        @include('clients.layouts.partials.footer')

    </div>

    <script src="{{ asset('assets/client/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/vendor/jquery-migrate-1.4.1.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/vendor/slick.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/client/js/main.js') }}"></script>
    <script>
        function toggleChat() {
            const chatbox = document.getElementById('chatbox');
            chatbox.style.display = chatbox.style.display === 'none' || chatbox.style.display === '' ? 'flex' : 'none';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('chat-form');
            const input = document.getElementById('chat-input');
            const messages = document.getElementById('chat-messages');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const userMessage = input.value.trim();
                if (!userMessage) return;

                // Tin nhắn người dùng
                const userBubble = document.createElement('div');
                userBubble.className = 'message user-message';
                userBubble.textContent = userMessage;
                messages.appendChild(userBubble);
                messages.scrollTop = messages.scrollHeight;
                input.value = '';

                // (Mô phỏng phản hồi bot)
                setTimeout(() => {
                    const botBubble = document.createElement('div');
                    botBubble.className = 'message bot-message';
                    botBubble.textContent = "Tôi đã nhận được: " + userMessage;
                    messages.appendChild(botBubble);
                    messages.scrollTop = messages.scrollHeight;
                }, 500);
            });

        });
    </script>



    @stack('scripts')
    @yield('scripts')

</body>

</html>