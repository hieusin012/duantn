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

    .message-wrapper {
        display: flex;
        align-items: flex-end;
        gap: 6px;
        max-width: 100%;
    }

    /* Bot ở bên trái */
    .bot-wrapper {
        justify-content: flex-start;
    }

    /* Người dùng bên phải */
    .user-wrapper {
        justify-content: flex-end;
    }

    .message {
        max-width: 80%;
        padding: 8px 12px;
        border-radius: 18px;
        font-size: 14px;
        line-height: 1.4;
        word-wrap: break-word;
    }

    .user-message {
        background-color: #0084ff;
        color: white;
        border-bottom-right-radius: 4px;
    }

    .bot-message {
        background-color: #e4e6eb;
        color: black;
        border-bottom-left-radius: 4px;
    }

    /* Avatar nhỏ xíu */
    .avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid black;
    }

    #chat-messages {
        height: 350px;
        overflow-y: auto;
        background: #f8f9fa;
        padding: 10px;
        border-radius: 8px;
    }

    img.rounded-circle {
        width: 28px;
        height: 28px;
        object-fit: cover;

    }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Nút Chatbot -->
<div id="chatbot-icon" onclick="toggleChat()">
    <img src="{{ asset('assets/client/images/message.png') }}" alt="" width="50">
</div>

<!-- Khung Chat -->
<!-- Khung Chat -->
<div id="chatbox" class="chatbox flex-column" style="display: none;">
    <div id="chat-header"> <img src="{{ asset('assets/client/images/favicon.png') }}" class="me-2" alt="" width="35" style="border: 1px solid black; border-radius: 50%;">
        <span>Rất hân hạnh được hỗ trợ !</span>
    </div>
    <div id="chat-body">
        <div id="chat-messages" class="mb-2">
            <div class="message bot-message">Xin chào quý khách. Vui lòng đăng nhập để được tư vấn !</div>
        </div>
        <form id="chat-form" onsubmit="return false;">
            <input type="text" id="chat-input" autocomplete="off" placeholder="Nhập tin nhắn..." required />
            <button type="submit">Gửi</button>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('chat-form');
        const input = document.getElementById('chat-input');
        const messages = document.getElementById('chat-messages');

        const myUserId = Number("{{ Auth::id() ?? 0 }}");


        // Gửi tin nhắn
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const text = input.value.trim();
            if (!text) return;

            await fetch('/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    message: text
                })
            });

            input.value = '';
            await fetchMessages(); // Tải lại tin nhắn sau khi gửi
        });

        // Tải tin nhắn từ server
        async function fetchMessages() {
            const res = await fetch('/chat/fetch');
            const data = await res.json();
            messages.innerHTML = ''; // Xóa tin cũ

            data.forEach(msg => {
                const isMe = Number(msg.from_user_id) === myUserId;

                const wrapper = document.createElement('div');
                wrapper.className = `message-wrapper ${isMe ? 'user-wrapper' : 'bot-wrapper'}`;

                const message = document.createElement('div');
                message.className = `message ${isMe ? 'user-message' : 'bot-message'}`;
                message.textContent = msg.message;

                if (!isMe) {
                    const avatar = document.createElement('img');
                    avatar.src = "{{ asset('assets/client/images/favicon.png') }}";
                    avatar.className = 'avatar';
                    wrapper.appendChild(avatar);
                }

                wrapper.appendChild(message);
                messages.appendChild(wrapper);
            });

            messages.scrollTop = messages.scrollHeight;
        }

        // Gọi mỗi 2 giây để làm mới tin nhắn
        setInterval(fetchMessages, 2000);
        fetchMessages();
    });

    function toggleChat() {
        const chatbox = document.getElementById('chatbox');
        chatbox.style.display = (chatbox.style.display === 'none' || chatbox.style.display === '') ? 'flex' : 'none';
    }
</script>