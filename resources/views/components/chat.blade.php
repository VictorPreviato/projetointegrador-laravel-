<style>
.chat-toggle {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #0095f6;
    color: #fff;
    border-radius: 50%;
    width: 55px;
    height: 55px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    z-index: 9999;
}

.chat-sidebar {
    position: fixed;
    bottom: 80px;
    right: 20px;
    width: 320px;
    height: 400px;
    background: #1e1e1e;
    color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.5);
    display: none;
    flex-direction: column;
    overflow-y: auto;
    z-index: 9999;
}

.chat-sidebar.active {
    display: flex;
}

.chat-sidebar h3 {
    margin: 10px;
    font-size: 18px;
    border-bottom: 1px solid #444;
    padding-bottom: 5px;
}

.conversa-item {
    padding: 10px;
    border-bottom: 1px solid #333;
    cursor: pointer;
}
.conversa-item:hover {
    background: #2c2c2c;
}
</style>

@auth
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="chat-sidebar" id="chatSidebar">
    <h3>Mensagens</h3>

    <div id="chatList">
        @php
            $conversas = \App\Models\Conversa::where('user1_id', auth()->id())
                ->orWhere('user2_id', auth()->id())
                ->with('mensagens.user')
                ->latest()
                ->get();
        @endphp

        @forelse($conversas as $conversa)
            <div class="conversa-item" data-id="{{ $conversa->id }}">
                <strong>
                    {{ $conversa->user1_id == auth()->id() ? $conversa->user2->name : $conversa->user1->name }}
                </strong>
                <p style="font-size: 12px; color: #aaa;">
                    {{ $conversa->mensagens->last()->conteudo ?? 'Sem mensagens ainda' }}
                </p>
            </div>
        @empty
            <p style="text-align:center; padding:20px;">Sem conversas no momento</p>
        @endforelse
    </div>

    <div id="chatMessages" style="flex:1; padding:10px; overflow-y:auto;"></div>

   <form id="sendMessageForm" style="margin-top:10px;">
    @csrf
    <input type="hidden" name="conversa_id" id="conversaIdInput" value="">
    <input type="text" name="conteudo" placeholder="Digite sua mensagem..." style="width:80%" required>
    <button type="submit">Enviar</button>
</form>
</div>

<div class="chat-toggle" onclick="toggleChat()">
    💬
</div>

<script>
function toggleChat() {
    document.getElementById('chatSidebar').classList.toggle('active');
}

let currentConversaId = null;
let lastMessageId = 0;

// Abrir conversa
document.querySelectorAll('.conversa-item').forEach(item => {
    item.addEventListener('click', () => {
        currentConversaId = item.dataset.id;
        lastMessageId = 0; // reset
        document.getElementById('chatSidebar').classList.add('active');
        document.getElementById('conversaIdInput').value = currentConversaId;
        loadChat(currentConversaId, true);
    });
});

// Carrega mensagens (incremental)
function loadChat(conversaId, scroll = false) {
    fetch(`/chat/fetch/${conversaId}?last_id=${lastMessageId}`)
        .then(res => res.text())
        .then(html => {
            if (lastMessageId === 0) {
                document.getElementById('chatMessages').innerHTML = html;
            } else {
                document.getElementById('chatMessages').insertAdjacentHTML('beforeend', html);
            }

            // atualiza lastMessageId
            const mensagens = document.getElementById('chatMessages').querySelectorAll('[data-id]');
            if (mensagens.length) {
                lastMessageId = parseInt(mensagens[mensagens.length - 1].getAttribute('data-id'));
            }

            if (scroll) {
                let chatDiv = document.getElementById('chatMessages');
                chatDiv.scrollTop = chatDiv.scrollHeight;
            }
        });
}

// Atualiza automaticamente a cada 3 segundos
setInterval(() => {
    if (currentConversaId) {
        loadChat(currentConversaId);
    }
}, 3000);

// Enviar mensagem (mantém só esse!)
document.getElementById('sendMessageForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch("/chat/send", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(res => res.text())
    .then(html => {
        // adiciona a nova mensagem no chat
        document.getElementById('chatMessages').insertAdjacentHTML('beforeend', html);

        // pega o último data-id e atualiza o lastMessageId
        const mensagens = document.getElementById('chatMessages').querySelectorAll('[data-id]');
        if (mensagens.length) {
            lastMessageId = parseInt(mensagens[mensagens.length - 1].getAttribute('data-id'));
        }

        this.reset();

        // scroll para o final
        let chatDiv = document.getElementById('chatMessages');
        chatDiv.scrollTop = chatDiv.scrollHeight;
    });
});

</script>
@endauth
