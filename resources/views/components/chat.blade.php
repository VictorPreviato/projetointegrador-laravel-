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
        @endphp

        <div class="conversa-item"
             data-id="{{ $conversa->id }}"
             data-nome="{{ $outroUser->name }}"
             data-foto="{{ $fotoUser }}"
             style="display:flex; align-items:center; gap:10px; padding:8px; cursor:pointer;">

             <!-- container para a foto, que o JS vai preencher -->
             <div class="foto-container" style="width:50px; height:50px; border-radius:50%; overflow:hidden;"></div>

            <div style="flex:1;">
                <strong style="display:block; overflow: hidden; white-space: nowrap;text-overflow: ellipsis; width: 250px;">{{ $outroUser->name }}</strong>
                <p style="font-size:12px; color:#aaa; margin:0;">
                    {{ $mensagemConteudo }}
                </p>
            </div>
            <span class="chat-unread"
           >
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
                <img id="chatUserFoto" 
     src="{{ asset('/IMG/user-icon.svg') }}" 
     alt="Foto do usuário" 
     onerror="this.src='/IMG/user-icon.svg'">

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
    <span id="chatBadge">
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
    const sidebar = document.getElementById('chatSidebar');
    const chatMessagesView = document.getElementById('chatMessagesView');
    const chatListView = document.getElementById('chatListView');

    sidebar.classList.toggle('active');

    if (sidebar.classList.contains('active')) {
        // Sempre abre na lista quando reabrir
        chatMessagesView.style.display = "none";
        chatListView.style.display = "block";
        sessionStorage.setItem('chatOpenedTo', 'list');
    }
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

// Renderiza a foto da conversa (lista)
function renderConversaFoto(conversaItem) {
    if (!conversaItem) return;
    const fotoContainer = conversaItem.querySelector('.foto-container');
    if (!fotoContainer) return;

    let fotoAttr = conversaItem.dataset.foto;
    let src;

    if (fotoAttr && fotoAttr.trim() !== "" && fotoAttr !== '/IMG/user-icon.svg') {
        const sep = fotoAttr.includes('?') ? '&' : '?';
        src = fotoAttr + sep + 't=' + Date.now();
    } else {
        src = '/IMG/user-icon.svg'; // fallback imediato sem cache-busting
    }

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

    img.onerror = () => {
        if (src !== '/IMG/user-icon.svg') {
            img.src = '/IMG/user-icon.svg';
        }
    };

    img.src = src;
}

// Setar foto no header
function setChatUserPhoto(src) {
    return new Promise((resolve) => {
        const img = document.getElementById('chatUserFoto');

        // fallback direto sem ?t=
        if (src === '/IMG/user-icon.svg') {
            img.src = src;
            resolve();
            return;
        }

        img.onload = () => resolve();
        img.onerror = () => {
            img.src = '/IMG/user-icon.svg';
            resolve();
        };

        img.src = src;
    });
}

// Inicializa fotos da lista
document.querySelectorAll('.conversa-item').forEach(item => renderConversaFoto(item));

// Abrir conversa
document.querySelectorAll('.conversa-item').forEach(item => {
    item.addEventListener('click', async () => {
        currentConversaId = item.dataset.id;
        lastMessageId = 0;

        document.getElementById('chatUserName').innerText = item.dataset.nome;

        let fotoSrc;
        if (item.dataset.foto && item.dataset.foto.trim() !== "" && item.dataset.foto !== '/IMG/user-icon.svg') {
            fotoSrc = item.dataset.foto + '?t=' + new Date().getTime();
        } else {
            fotoSrc = '/IMG/user-icon.svg'; // sem ?t=
        }

        await setChatUserPhoto(fotoSrc);

        document.getElementById('conversaIdInput').value = currentConversaId;

        document.getElementById('chatListView').style.display = "none";
        document.getElementById('chatMessagesView').style.display = "flex";

        const chatMessages = document.getElementById('chatMessages');
        chatMessages.innerHTML = '<p class="loading-msg" style="color:#ccc; text-align:center; margin-top:20px;">Carregando mensagens...</p>';

        const conversaItem = document.querySelector(`.conversa-item[data-id="${currentConversaId}"]`);
        renderConversaFoto(conversaItem);

        loadChat(currentConversaId, true);

        sessionStorage.setItem('chatOpenedTo', 'chat');
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

    sessionStorage.setItem('chatOpenedTo', 'list');
});

// Carregar chat
function loadChat(conversaId, scroll = false) {
    const chatMessages = document.getElementById('chatMessages');

    // Remove "Carregando mensagens..." se existir
    const loadingMsg = chatMessages.querySelector('.loading-msg');
    if (loadingMsg) loadingMsg.remove();

    fetch(`/chat/fetch/${conversaId}?last_id=${lastMessageId}`)
        .then(res => res.text())
        .then(html => {
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;

            const novasMensagens = tempDiv.querySelectorAll('[data-id]');

            novasMensagens.forEach(msg => {
                if (!chatMessages.querySelector(`[data-id="${msg.dataset.id}"]`)) {
                    chatMessages.appendChild(msg);
                }
            });

            if (novasMensagens.length) {
                lastMessageId = parseInt(
                    novasMensagens[novasMensagens.length - 1].getAttribute('data-id')
                );

                if (scroll) chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        });
}

// Atualizar mensagens não lidas
function updateUnread() {
    fetch("/chat/unread")
        .then(res => res.json())
        .then(data => {
            const badge = document.getElementById('chatBadge');
            if (data.total > 0) {
                badge.innerText = data.total;
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }

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

// Intervalo de atualização
const chatPollInterval = setInterval(() => {
    if (currentConversaId) loadChat(currentConversaId);
    updateUnread();
}, 3000);

// Cancela polling ao submeter formulários que redirecionam
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', () => {
        if (chatPollInterval) clearInterval(chatPollInterval);
    });
});

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
        if (mensagens.length) {
            lastMessageId = parseInt(mensagens[mensagens.length - 1].getAttribute('data-id'));
        }

        this.reset();
        chatMessages.scrollTop = chatMessages.scrollHeight;

        const conversaId = document.getElementById('conversaIdInput').value;
        const inputMsg = formData.get("conteudo");
        const conversaItem = document.querySelector(`.conversa-item[data-id="${conversaId}"]`);
        if (conversaItem) {
            const lastMsgPreview = conversaItem.querySelector("p");
            if (lastMsgPreview) lastMsgPreview.textContent = "Você: " + inputMsg;

            conversaItem.parentNode.prepend(conversaItem);

            renderConversaFoto(conversaItem);
        }
    });
});

// Fechar lista de chats
document.getElementById('closeChatList').addEventListener('click', () => {
    document.getElementById('chatSidebar').classList.remove('active');
});

// Fechar chat aberto
document.getElementById('closeChat').addEventListener('click', () => {
    document.getElementById('chatSidebar').classList.remove('active');

    document.getElementById('chatMessagesView').style.display = "none";
    document.getElementById('chatListView').style.display = "block";

    sessionStorage.setItem('chatOpenedTo', 'list');
});


</script>


