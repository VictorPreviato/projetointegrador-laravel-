@auth
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="chat-sidebar" id="chatSidebar">
    <!-- LISTA DE CONVERSAS -->
    <div id="chatListView" class="chat-list">
        <div class="chat-header">
            <h4>Mensagens</h4>
        </div>
        
        <div id="chatList">
            @php
                $conversas = \App\Models\Conversa::where('user1_id', auth()->id())
                    ->orWhere('user2_id', auth()->id())
                    ->with(['user1', 'user2', 'mensagens.user'])
                    ->latest()
                    ->get();
            @endphp

            @forelse($conversas as $conversa)
                @php
                    $outroUser = $conversa->user1_id == auth()->id() ? $conversa->user2 : $conversa->user1;
                @endphp

                <div class="conversa-item"
                     data-id="{{ $conversa->id }}"
                     data-nome="{{ $outroUser->name }}"
                     data-foto="{{ $outroUser->foto ? asset('storage/'.$outroUser->foto) : '' }}">
                    <strong>{{ $outroUser->name }}</strong>
                    <p style="font-size:12px; color:#aaa;">
                        {{ $conversa->mensagens->last()->conteudo ?? 'Sem mensagens ainda' }}
                    </p>
                </div>
            @empty
                <p id="noChatsMessage" style="text-align:center; padding:20px;">Sem conversas no momento</p>
            @endforelse
        </div>
    </div>

    <!-- CHAT -->
    <div id="chatMessagesView" class="chat-messages" style="display:none;">
        <div class="chat-header">
            <div class="ftperfilheadchat">
                <img id="chatUserFoto" src="" alt="Foto do usuário">
            </div>

            <button id="backToList">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                     viewBox="0 -960 960 960" width="24px" fill="#">
                     <path d="M400-80 0-480l400-400 71 71-329 329 329 329-71 71Z"/>
                </svg>
            </button>
            <h4 id="chatUserName"></h4>
        </div>

        <div id="chatMessages" style="flex:1; overflow-y:auto;"></div>

        <form id="sendMessageForm" style="display:flex; padding:10px; border-top:1px solid #333;">
            @csrf
            <input type="hidden" name="conversa_id" id="conversaIdInput" value="">
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
            <input type="text" id="chatInput" name="conteudo"
                   placeholder="Mensagem..."  required>
        </form>
    </div>
</div>
@endauth

<div class="chat-toggle" onclick="toggleChat()">
    <svg xmlns="http://www.w3.org/2000/svg" height="24px"
         viewBox="0 -960 960 960" width="24px" fill="#EFEFEF">
         <path d="M80-80v-720q0-33 23.5-56.5T160-880h640q33 0
                  56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H240L80-80Z"/>
    </svg>
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
function toggleChat() {
    document.getElementById('chatSidebar').classList.toggle('active');
}

document.addEventListener('click', function(e) {
    const sidebar = document.getElementById('chatSidebar');
    const toggle = document.querySelector('.chat-toggle');
    if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
        sidebar.classList.remove('active');
    }
});

let currentConversaId = null;
let lastMessageId = 0;

document.querySelectorAll('.conversa-item').forEach(item => {
    item.addEventListener('click', () => {
        currentConversaId = item.dataset.id;
        lastMessageId = 0;

        document.getElementById('chatListView').style.display = "none";
        document.getElementById('chatMessagesView').style.display = "flex";

        // 🔥 Atualiza nome e foto do usuário
        document.getElementById('chatUserName').innerText = item.dataset.nome;
        const foto = item.dataset.foto;
        document.getElementById('chatUserFoto').src = foto !== "" ? foto : `data:image/svg+xml;base64,${btoa(`
        <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#485958"><path d="M226-266q62-39 122.5-58T480-343q71 0 133 20t122 57q42-55 59-105.46 17-50.45 17-108.54 0-140.25-95.33-235.62Q620.35-811 480.17-811 340-811 244.5-715.62 149-620.25 149-480q0 58 17.03 108.22Q183.05-321.57 226-266Zm253.81-177q-60.97 0-101.89-41.19Q337-525.37 337-585.69q0-60.31 41.11-101.81 41.1-41.5 102.08-41.5 60.97 0 101.89 41.69 40.92 41.68 40.92 102Q623-525 581.89-484q-41.1 41-102.08 41Zm-.21 388q-87.15 0-164.9-33.28-77.75-33.29-135.82-91.56-58.07-58.27-90.98-135.44Q55-392.46 55-480.39t33.5-165.27Q122-723 180-780.5T315.25-872q77.24-34 165.25-34t165.25 34Q723-838 780.5-780.5T872-645.59q34 77.4 34 165.32 0 87.93-34 165.1Q838-238 780.5-180 723-122 645.46-88.5 567.93-55 479.6-55Z"/></svg>
    `)}`;
        document.getElementById('conversaIdInput').value = currentConversaId;
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


