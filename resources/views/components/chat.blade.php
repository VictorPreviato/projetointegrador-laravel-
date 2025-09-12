
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
                    <p  style="font-size:12px; color:#aaa;">
                        {{ $conversa->mensagens->last()->conteudo ?? 'Sem mensagens ainda' }}
                    </p>
                </div>
            @empty
                <p id="noChatsMessage" style="text-align:center; padding:20px;">Sem conversas no momento</p>
            @endforelse
        </div>
    </div>

    <!-- TELA DE CHAT -->
    <div id="chatMessagesView" class="chat-messages" style="display:none;">
        <div class="chat-header">
            <button id="backToList"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#"><path d="M400-80 0-480l400-400 71 71-329 329 329 329-71 71Z"/></svg></button>
            <h4 id="chatUserName"></h4>
            <!-- <button id="minimizeChatMessages"><svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#EFEFEF"><path d="M240-120v-66.67h480.67V-120H240Z"/></svg></button> -->
        </div>

        <div id="chatMessages" style="flex:1; overflow-y:auto;"></div>

        <form id="sendMessageForm" style="display:flex; padding:10px; border-top:1px solid #333;">
    @csrf
    <input type="hidden" name="conversa_id" id="conversaIdInput" value="">
<div style="position:relative; display:flex; align-items:center;">
  <button type="button" id="emojiButton" aria-label="Abrir emojis"
          style="background:none; border:none; cursor:pointer; padding:6px;">
    
    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#31403E"><path d="M620-520q25 0 42.5-17.5T680-580q0-25-17.5-42.5T620-640q-25 0-42.5 17.5T560-580q0 25 17.5 42.5T620-520Zm-280 0q25 0 42.5-17.5T400-580q0-25-17.5-42.5T340-640q-25 0-42.5 17.5T280-580q0 25 17.5 42.5T340-520Zm140 260q68 0 123.5-38.5T684-400H276q25 63 80.5 101.5T480-260Zm0 180q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-400Zm0 320q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Z"/></svg>
  </button>

  
  <div id="emojiPicker"
       style="display:none; position:absolute; bottom:40px; left:0;
              background:#2a2a2a; padding:10px; border-radius:10px;
              width:220px; z-index:100001; box-shadow:0 6px 18px rgba(0,0,0,0.4);
              gap:6px;">

  
  </div>
</div>
    <input type="text" id="chatInput" name="conteudo" placeholder="Mensagem..." style="flex:1; margin-right:10px;" required>

</form>


    </div>
</div>

<div class="chat-toggle" onclick="toggleChat()">
    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EFEFEF"><path d="M80-80v-720q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H240L80-80Zm126-240h594v-480H160v525l46-45Zm-46 0v-480 480Z"/></svg>

     <span id="chatBadge" class="chat-badge" style="display:none;">0</span>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const emojiButton = document.getElementById('emojiButton');
    const emojiPicker = document.getElementById('emojiPicker');
    const chatInput = document.getElementById('chatInput');

    // pequenos estilos via JS (opcional, melhora visual)
    emojiPicker.style.display = 'none';
    emojiPicker.style.flexDirection = 'row';
    emojiPicker.style.flexWrap = 'wrap';

    // Lista de emojis (adicione/edite)
    const emojis = ["😀","😂","😍","😎","😢","👍","👎","🔥","❤️","🙏","🎉","🤔","🙌","😅","😴"];

    function renderPicker() {
        emojiPicker.innerHTML = '';
        emojis.forEach(emo => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'emoji-item';
            btn.style.border = 'none';
            btn.style.background = 'transparent';
            btn.style.cursor = 'pointer';
            btn.style.fontSize = '20px';
            btn.style.padding = '6px';
            btn.textContent = emo;

            btn.addEventListener('click', (ev) => {
                ev.stopPropagation(); // não fechar pelo document
                insertAtCaret(chatInput, emo);
                emojiPicker.style.display = 'none';
                chatInput.focus();
            });

            emojiPicker.appendChild(btn);
        });
    }

    // toggle com stopPropagation para evitar que o click no botão seja capturado pelo listener global
    emojiButton.addEventListener('click', (e) => {
        e.stopPropagation();
        if (emojiPicker.style.display === 'flex') {
            emojiPicker.style.display = 'none';
        } else {
            renderPicker();
            emojiPicker.style.display = 'flex';
        }
    });

    // evita que click dentro do picker feche por conta do listener global
    emojiPicker.addEventListener('click', (e) => e.stopPropagation());

    // clique fora fecha o picker
    document.addEventListener('click', () => {
        emojiPicker.style.display = 'none';
    });

    // tecla Escape fecha
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') emojiPicker.style.display = 'none';
    });

    // função para inserir no caret (mantém seleção)
    function insertAtCaret(input, text) {
        const start = input.selectionStart ?? input.value.length;
        const end = input.selectionEnd ?? start;
        input.value = input.value.slice(0, start) + text + input.value.slice(end);
        const pos = start + text.length;
        input.selectionStart = input.selectionEnd = pos;
        input.focus();
    }
});
</script>


<script>
let currentConversaId = null;
let lastMessageId = 0;

// Abre ou fecha sidebar
function toggleChat() {
    document.getElementById('chatSidebar').classList.toggle('active');
}

// Fecha sidebar ao clicar fora
document.addEventListener('click', function(e) {
    const sidebar = document.getElementById('chatSidebar');
    const toggle = document.querySelector('.chat-toggle');

    if (!sidebar.contains(e.target) && (!toggle || !toggle.contains(e.target))) {
        sidebar.classList.remove('active');
    }
});

// Inicia ou abre conversa (para botão na descrição)
function startChat(userId) {
    fetch(`/chat/start/${userId}`)
        .then(res => res.json())
        .then(data => {
            const outroUser = data.outro_user;

            // Abre sidebar
            document.getElementById('chatSidebar').classList.add('active');

            // Remove mensagem "sem chats"
            const noChats = document.getElementById('noChatsMessage');
            if (noChats) noChats.remove();

            // Adiciona conversa à lista se não existir
            let chatItem = document.querySelector(`.conversa-item[data-id="${data.conversa_id}"]`);
            if (!chatItem) {
                const chatList = document.getElementById('chatList');
                chatItem = document.createElement('div');
                chatItem.classList.add('conversa-item');
                chatItem.dataset.id = data.conversa_id;
                chatItem.dataset.foto = outroUser.foto;
                chatItem.innerHTML = `<strong>${outroUser.name}</strong><p style="font-size:12px;color:#aaa;">Sem mensagens ainda</p>`;
                chatList.prepend(chatItem);

                chatItem.addEventListener('click', () => openChat(data.conversa_id, outroUser));
            }

            // Abre chat imediatamente
            openChat(data.conversa_id, outroUser);
        });
}

// Abre chat de qualquer item
function openChat(conversaId, outroUser) {
    currentConversaId = conversaId;
    lastMessageId = 0;

    document.getElementById('chatListView').style.display = "none";
    document.getElementById('chatMessagesView').style.display = "flex";

    document.getElementById('conversaIdInput').value = conversaId;
    document.getElementById('chatUserName').innerText = outroUser.name;
    document.getElementById('chatUserFoto').src = outroUser.foto;

    loadChat(conversaId, true);

    // Marca mensagens como lidas
    fetch(`/chat/read/${conversaId}`, {
        method: 'POST',
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    }).then(() => updateChatBadge());
}

// Carrega mensagens
function loadChat(conversaId, scroll = false) {
    fetch(`/chat/fetch/${conversaId}?last_id=${lastMessageId}`)
        .then(res => res.text())
        .then(html => {
            const container = document.getElementById('chatMessages');
            if (lastMessageId === 0) {
                container.innerHTML = html;
            } else {
                container.insertAdjacentHTML('beforeend', html);
            }

            const mensagens = container.querySelectorAll('[data-id]');
            if (mensagens.length) lastMessageId = parseInt(mensagens[mensagens.length - 1].getAttribute('data-id'));

            if (scroll) container.scrollTop = container.scrollHeight;

            // Atualiza preview da última mensagem no sidebar
            const chatItem = document.querySelector(`.conversa-item[data-id="${conversaId}"]`);
            if (chatItem && mensagens.length) {
                const lastMsgText = mensagens[mensagens.length - 1].querySelector('p').innerText;
                chatItem.querySelector('p').innerText = lastMsgText;
            }
        });
}

// Listener para itens existentes na lista de chats
document.querySelectorAll('.conversa-item').forEach(item => {
    item.addEventListener('click', () => {
        const conversaId = item.dataset.id;
        const outroUser = {
            name: item.querySelector('strong').innerText,
            foto: item.dataset.foto || '/images/default-avatar.png'
        };
        openChat(conversaId, outroUser);
    });
});

// Botão voltar para lista de chats
document.getElementById('backToList').addEventListener('click', () => {
    document.getElementById('chatMessagesView').style.display = "none";
    document.getElementById('chatListView').style.display = "block";
    currentConversaId = null;
});

// Envio de mensagem
document.getElementById('sendMessageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch("/chat/send", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(res => res.text())
    .then(html => {
        const container = document.getElementById('chatMessages');
        container.insertAdjacentHTML('beforeend', html);

        const mensagens = container.querySelectorAll('[data-id]');
        if (mensagens.length) lastMessageId = parseInt(mensagens[mensagens.length - 1].getAttribute('data-id'));

        this.reset();
        container.scrollTop = container.scrollHeight;

        // Atualiza preview no sidebar
        const chatItem = document.querySelector(`.conversa-item[data-id="${currentConversaId}"]`);
        if (chatItem && mensagens.length) {
            const lastMsgText = mensagens[mensagens.length - 1].querySelector('p').innerText;
            chatItem.querySelector('p').innerText = lastMsgText;
        }
    });
});

// Atualiza chat automaticamente a cada 3s
setInterval(() => {
    if (currentConversaId) loadChat(currentConversaId);
}, 3000);
</script>

@endauth
