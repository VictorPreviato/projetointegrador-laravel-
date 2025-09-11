
@auth
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="chat-sidebar" id="chatSidebar">
    <!-- TELA DE LISTA DE CONVERSAS -->
    <div id="chatListView" class="chat-list">
        <div class="chat-header">
            <h4>Mensagens</h4>
           
        </div>
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
                    <p style="font-size:12px; color:#aaa;">
                        {{ $conversa->mensagens->last()->conteudo ?? 'Sem mensagens ainda' }}
                    </p>
                </div>
            @empty
                <p style="text-align:center; padding:20px;">Sem conversas no momento</p>
            @endforelse
        </div>
    </div>

    <!-- TELA DE CHAT -->
    <div id="chatMessagesView" class="chat-messages" style="display:none;">
        <div class="chat-header">
            <button id="backToList"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EFEFEF"><path d="M400-80 0-480l400-400 71 71-329 329 329 329-71 71Z"/></svg></button>
            <h4 id="chatUserName"></h4>
            <!-- <button id="minimizeChatMessages"><svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#EFEFEF"><path d="M240-120v-66.67h480.67V-120H240Z"/></svg></button> -->
        </div>

        <div id="chatMessages" style="flex:1; overflow-y:auto;"></div>

        <form id="sendMessageForm" style="display:flex; padding:10px; border-top:1px solid #333;">
            @csrf
            <input type="hidden" name="conversa_id" id="conversaIdInput" value="">
            <input type="text" name="conteudo" placeholder="Mensagem..." style="flex:1; margin-right:10px; width:10px;" required>
            <button type="submit">Enviar</button>
        </form>
    </div>
</div>

<div class="chat-toggle" onclick="toggleChat()">
    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EFEFEF"><path d="M80-80v-720q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H240L80-80Zm126-240h594v-480H160v525l46-45Zm-46 0v-480 480Z"/></svg>
</div>


<script>
function toggleChat() {
    document.getElementById('chatSidebar').classList.toggle('active');
}

// Minimizar chat

// document.getElementById('minimizeChatMessages').addEventListener('click', () => {
//     document.getElementById('chatMessagesView').style.display = 'none';
//     document.getElementById('chatListView').style.display = 'block';
// });

// Abrir conversa
let currentConversaId = null;
let lastMessageId = 0;

document.querySelectorAll('.conversa-item').forEach(item => {
    item.addEventListener('click', () => {
        currentConversaId = item.dataset.id;
        lastMessageId = 0;

        document.getElementById('chatListView').style.display = "none";
        document.getElementById('chatMessagesView').style.display = "flex";

        document.getElementById('conversaIdInput').value = currentConversaId;
        document.getElementById('chatUserName').innerText = item.querySelector("strong").innerText;

        loadChat(currentConversaId, true);
    });
});

// Voltar para lista
document.getElementById('backToList').addEventListener('click', () => {
    document.getElementById('chatMessagesView').style.display = "none";
    document.getElementById('chatListView').style.display = "block";
    currentConversaId = null;
});

// Carregar mensagens
function loadChat(conversaId, scroll = false) {
    fetch(`/chat/fetch/${conversaId}?last_id=${lastMessageId}`)
        .then(res => res.text())
        .then(html => {
            if (lastMessageId === 0) {
                document.getElementById('chatMessages').innerHTML = html;
            } else {
                document.getElementById('chatMessages').insertAdjacentHTML('beforeend', html);
            }

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

// Atualiza a cada 3s
setInterval(() => {
    if (currentConversaId) loadChat(currentConversaId);
}, 3000);

// Enviar mensagem
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
        document.getElementById('chatMessages').insertAdjacentHTML('beforeend', html);

        const mensagens = document.getElementById('chatMessages').querySelectorAll('[data-id]');
        if (mensagens.length) lastMessageId = parseInt(mensagens[mensagens.length - 1].getAttribute('data-id'));

        this.reset();
        let chatDiv = document.getElementById('chatMessages');
        chatDiv.scrollTop = chatDiv.scrollHeight;
    });
});



</script>
@endauth
