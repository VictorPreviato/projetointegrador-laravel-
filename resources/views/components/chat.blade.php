@auth
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="chat-sidebar" id="chatSidebar">
    <!-- LISTA DE CONVERSAS -->
   <div id="chatListView" class="chat-list">
    <div class="chat-header">
        <h4>Mensagens</h4>
        <button type="button" id="closeChatList"><svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#31403E"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/></svg></button>
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
        $fotoUser = $outroUser->foto ? asset('storage/'.$outroUser->foto) : asset('IMG/user-icon.svg'); // default
        $lastMensagem = $conversa->mensagens->last();
        $mensagemConteudo = $lastMensagem 
            ? ($lastMensagem->user_id == auth()->id() ? 'Você: '.$lastMensagem->conteudo : $lastMensagem->conteudo)
            : 'Sem mensagens ainda';

        // verifica se há mensagens não lidas desse usuário
        $hasUnread = $conversa->mensagens
            ->where('user_id', '!=', auth()->id())
            ->where('lida', false)
            ->count() > 0;
    @endphp

    <div class="conversa-item"
         data-id="{{ $conversa->id }}"
         data-nome="{{ $outroUser->name }}"
         data-foto="{{ $fotoUser }}"
         style="display:flex; align-items:center; gap:10px; padding:8px; cursor:pointer;">

         <!-- container para a foto, que o JS vai preencher -->
         <div class="foto-container" style="width:50px; height:50px; border-radius:50%; overflow:hidden;"></div>

        <div style="flex:1;">
            <strong class="{{ $hasUnread ? 'unread' : '' }}" style="display:block;">
                {{ $outroUser->name }}
            </strong>
            <p class="last-msg {{ $hasUnread ? 'unread' : '' }}" style="font-size:12px; margin:0;">
                {{ $mensagemConteudo }}
            </p>
        </div>

        <span class="chat-unread"
              style="display:{{ $hasUnread ? 'inline-block' : 'none' }};
                     background:red; color:white; font-size:10px;
                     font-weight:bold; padding:2px 5px; border-radius:50%;">
        </span>
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

            <button type="button" id="backToList">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px"
                     viewBox="0 -960 960 960" width="24px" fill="#">
                     <path d="M400-80 0-480l400-400 71 71-329 329 329 329-71 71Z"/>
                </svg>
            </button>
            <h4 id="chatUserName"></h4>
            <button type="button" id="closeChat"><svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#31403E"><path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/></svg></button>
        </div>

        <div id="chatMessages" style="flex:1; overflow-y:auto;"></div>

        <form id="sendMessageForm" style="display:flex; padding:10px;">
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
    <span id="chatBadge"
          style="display:none; position:absolute; top:0; right:0;
                 background:red; color:white; font-size:12px;
                 font-weight:bold; padding:2px 6px; border-radius:50%;">
    </span>
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

// Função para renderizar foto com cache-busting
function renderConversaFoto(conversaItem) {
    if (!conversaItem) return;
    const fotoContainer = conversaItem.querySelector('.foto-container');
    if (!fotoContainer) return;

    const fotoAttr = conversaItem.dataset.foto || '/IMG/user-icon.svg';
    const sep = fotoAttr.includes('?') ? '&' : '?';
    const src = fotoAttr + sep + 't=' + Date.now();

    // Reuse existing img if houver
    let img = fotoContainer.querySelector('img');
    if (!img) {
        img = document.createElement('img');
        img.style.width = '100%';
        img.style.height = '100%';
        img.style.objectFit = 'cover';
        img.style.borderRadius = '50%';
        img.loading = 'lazy';
        fotoContainer.appendChild(img);
    }

    // debug rápido (remova depois)
    console.log('renderConversaFoto -> id', conversaItem.dataset.id, 'src', src);

    img.onload = () => {
        // opcional: console.log('avatar loaded', conversaItem.dataset.id);
    };
    img.onerror = () => {
        console.warn('Erro ao carregar avatar:', src);
        img.src = '/IMG/user-icon.svg';
    };

    // atribui por último
    img.src = src;
}


// Inicializa fotos na lista
document.querySelectorAll('.conversa-item').forEach(item => renderConversaFoto(item));

// Abrir conversa ao clicar na lista
document.querySelectorAll('.conversa-item').forEach(item => {
    item.addEventListener('click', () => {
        currentConversaId = item.dataset.id;
        lastMessageId = 0;

        document.getElementById('chatListView').style.display = "none";
        document.getElementById('chatMessagesView').style.display = "flex";

        document.getElementById('chatUserName').innerText = item.dataset.nome;
        document.getElementById('chatUserFoto').src = item.dataset.foto + '?t=' + new Date().getTime();

        document.getElementById('conversaIdInput').value = currentConversaId;

        // Atualiza foto da lista
        const conversaItem = document.querySelector(`.conversa-item[data-id="${currentConversaId}"]`);
        renderConversaFoto(conversaItem);

        loadChat(currentConversaId, true);
    });
});

// Voltar para lista
document.getElementById('backToList').addEventListener('click', () => {
    document.getElementById('chatMessagesView').style.display = "none";
    document.getElementById('chatListView').style.display = "block";
    currentConversaId = null;

    requestAnimationFrame(() => {
        document.querySelectorAll('.conversa-item').forEach(item => renderConversaFoto(item));
    });
});

// Carregar mensagens
function loadChat(conversaId, scroll = false) {
    fetch(`/chat/fetch/${conversaId}?last_id=${lastMessageId}`)
        .then(res => res.text())
        .then(html => {
            const chatMessages = document.getElementById('chatMessages');

            if (lastMessageId === 0) {
                chatMessages.innerHTML = html;
            } else {
                chatMessages.insertAdjacentHTML('beforeend', html);
            }

            const mensagens = chatMessages.querySelectorAll('[data-id]');
            if (mensagens.length) {
                lastMessageId = parseInt(mensagens[mensagens.length - 1].getAttribute('data-id'));
            }

            if (scroll) chatMessages.scrollTop = chatMessages.scrollHeight;
        });
}

// Atualiza a cada 3s
function updateUnread() {
    fetch("/chat/unread")
        .then(res => res.json())
        .then(data => {
            // Badge do balão
            const badge = document.getElementById('chatBadge');
            if (data.total > 0) {
                badge.innerText = data.total;
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }

            // Badge por conversa
            for (const [conversaId, count] of Object.entries(data.conversas)) {
                const item = document.querySelector(`.conversa-item[data-id="${conversaId}"] .chat-unread`);
                if (item) {
                    if (count > 0) {
                        item.innerText = count;
                        item.style.display = 'inline-block';
                    } else {
                        item.style.display = 'none';
                    }
                }
            }
        });
}

// roda junto com atualização do chat
setInterval(() => {
    if (currentConversaId) loadChat(currentConversaId);
    updateUnread();
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
        const chatMessages = document.getElementById('chatMessages');
        chatMessages.insertAdjacentHTML('beforeend', html);

        const mensagens = chatMessages.querySelectorAll('[data-id]');
        if (mensagens.length) lastMessageId = parseInt(mensagens[mensagens.length - 1].getAttribute('data-id'));

        this.reset();
        chatMessages.scrollTop = chatMessages.scrollHeight;

        const conversaId = document.getElementById('conversaIdInput').value;
        const inputMsg = formData.get("conteudo");
        const conversaItem = document.querySelector(`.conversa-item[data-id="${conversaId}"]`);
        if (conversaItem) {
            const lastMsgPreview = conversaItem.querySelector("p");
            if (lastMsgPreview) lastMsgPreview.textContent = "Você: " + inputMsg;

            conversaItem.parentNode.prepend(conversaItem);

            // Atualiza a foto da lista com cache-busting 
            renderConversaFoto(conversaItem);
        }
    });
});

// Fecha a lista de chats
document.getElementById('closeChatList').addEventListener('click', () => {
    document.getElementById('chatSidebar').classList.remove('active');
});

// Fecha o chat aberto
document.getElementById('closeChat').addEventListener('click', () => {
    document.getElementById('chatSidebar').classList.remove('active');
});

</script>


