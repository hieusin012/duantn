@extends('admin.layouts.index')
@section('title', 'Hỗ trợ khách hàng')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    #chat-box {
        background-color: #f5f6fa;
        padding: 10px;
        border-radius: 8px;
        height: 100%;
        overflow-y: auto;
    }

    .chat-message {
        max-width: 70%;
        padding: 10px 14px;
        border-radius: 18px;
        position: relative;
        margin-bottom: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        word-wrap: break-word;
        font-size: 15px;
    }

    .chat-message.me {
        background-color: #007bff;
        color: white;
        margin-left: auto;
        border-bottom-right-radius: 0;
    }

    .chat-message.other {
        background-color: #e4e6eb;
        color: #111;
        margin-right: auto;
        border-bottom-left-radius: 0;
    }

    .chat-time {
        font-size: 12px;
        color: #555;
        margin-top: 4px;
        text-align: right;
    }

    .chat-item {
        display: flex;
        align-items: flex-end;
        gap: 8px;
    }

    .chat-item.me {
        justify-content: flex-end;
        color: white;
    }

    .chat-item.other {
        justify-content: flex-start;
        color: #555;
    }

    .chat-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: #6c757d;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }

    .chat-time {
        font-size: 12px;
        margin-top: 4px;
        text-align: right;
    }

    /* Thời gian trong tin nhắn admin (màu trắng) */
    .chat-message.me .chat-time {
        color: rgba(255, 255, 255, 0.8);
    }

    /* Thời gian trong tin nhắn người dùng (màu xám đậm) */
    .chat-message.other .chat-time {
        color: #555;
    }

    .user-list {
        padding: 0;
        margin-top: 1rem;
    }

    .user-item {
        cursor: pointer;
        padding: 10px;
        border: none;
        border-bottom: 1px solid #e0e0e0;
        transition: background-color 0.2s;
    }

    .user-item:hover {
        background-color: #f1f1f1;
    }

    .user-item.active {
        background-color: #dbeafe !important;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
        border: 1px solid #ccc;
    }

    .user-name {
        font-weight: 500;
        color: #333;
        margin-left: 20px;
    }

    .user-item:hover {
        background-color: #f8f9fa;
        cursor: pointer;
    }

    .user-name {
        margin-left: 10px;
        font-weight: 500;
    }
</style>



<div class="container-fluid">
    <div class="row mb-5" style="height: 80vh">
        <!-- Sidebar user list -->
        <div class="col-md-3 border-end overflow-auto">
            <h5 class="mt-3">Người dùng</h5>
            <ul class="list-group user-list">
                @foreach($users as $user)

                <li class="list-group-item user-item d-flex align-items-center" data-id="{{ $user->id }}">
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" style="max-width: 60px; border-radius: 30px;">
                    <span class="user-name">{{ $user->fullname }}</span>
                    <form action="{{ route('admin.chat.destroy', $user->id) }}" method="POST" style="display:inline-block; margin-left: auto;" class="ms-auto">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa cuộc trò chuyện này vĩnh viễn !')"><i class="fas fa-trash-alt "></i></button>
                    </form>
                </li>


                @endforeach
            </ul>

        </div>

        <!-- Chat box -->
        <div class="col-md-9 d-flex flex-column">
            <h5 class="mt-3">Đang chat với: <span id="chat-with">Chọn người dùng</span></h5>
            <div id="chat-box" class="flex-grow-1 border p-2 mb-2 overflow-auto" style="background: white;"></div>
            <form id="chat-form" class="d-flex" style="display: none;">
                @csrf
                <input type="hidden" id="to_user_id">
                <input type="text" id="chat-input" class="form-control me-2" style="background: white;" autocomplete="off" placeholder="Nhập tin nhắn..." required>
                <button type="submit" class="btn btn-warning">Gửi</button>
            </form>
        </div>
    </div>
</div>

<script>
    const adminId = Number("{{$adminId}}");
    let currentChatUserId = null;

    document.querySelectorAll('.user-item').forEach(item => {
        item.addEventListener('click', function() {
            document.querySelectorAll('.user-item').forEach(i => i.classList.remove('active'));
            this.classList.add('active');

            currentChatUserId = this.dataset.id;
            document.getElementById('chat-with').innerText = this.innerText;
            document.getElementById('to_user_id').value = currentChatUserId;
            document.getElementById('chat-form').style.display = 'flex';
            fetchMessages();
        });
    });


    async function fetchMessages() {
        if (!currentChatUserId) return;
        const res = await fetch(`/admin/chat/messages/${currentChatUserId}`);
        const messages = await res.json();
        const box = document.getElementById('chat-box');
        box.innerHTML = '';

        messages.forEach(msg => {
            const isMe = msg.from_user_id === adminId;

            const item = document.createElement('div');
            item.className = `chat-item ${isMe ? 'me' : 'other'}`;

            const avatar = document.createElement('div');
            avatar.className = 'chat-avatar';
            avatar.innerText = isMe ? 'A' : 'U'; // Tùy chỉnh theo tên nếu có

            const message = document.createElement('div');
            message.className = `chat-message ${isMe ? 'me' : 'other'}`;
            message.innerText = msg.message;

            const time = document.createElement('div');
            time.className = 'chat-time';
            time.innerText = new Date(msg.created_at).toLocaleTimeString('vi-VN', {
                hour: '2-digit',
                minute: '2-digit'
            });

            message.appendChild(time);

            if (isMe) {
                item.appendChild(message);
                item.appendChild(avatar);
            } else {
                item.appendChild(avatar);
                item.appendChild(message);
            }

            box.appendChild(item);
        });

        box.scrollTop = box.scrollHeight;
    }


    document.getElementById('chat-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        const input = document.getElementById('chat-input');
        const message = input.value.trim();
        if (!message) return;

        await fetch(`/admin/chat/send`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                to_user_id: currentChatUserId,
                message: message
            })
        });

        input.value = '';
        fetchMessages();
    });

    setInterval(fetchMessages, 3000);
</script>

@endsection