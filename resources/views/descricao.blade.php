@include("components.header")

<div class="sitdesc">
    <h4>
        @if($post->tipo_cadastro === 'doacao')
            Doação
        @elseif($post->tipo_cadastro === 'perdido')
            Perdido
        @else
            {{ ucfirst($post->tipo_cadastro) }}
        @endif
    </h4>
</div>


<div class="descflex">
    <div>
        <img id="imgdesc" src="{{ asset('storage/' . $post->foto) }}" alt="{{ $post->nome_pet ?? 'Pet' }}">
    </div>
    <div class="desccontent">
        <div class="headcontdesc">
            <div>
                <h1>{{ $post->nome_pet ?? 'Sem nome' }}</h1>
                <p>{{ $post->tipo_animal }} | {{ $post->genero }} | {{ $post->idade ?? '-' }} | Porte {{ $post->porte }}</p>
            </div>
        </div>
        <div>
            <p>Está em {{ $post->cidade ?? '-' }}, {{ $post->estado ?? '-' }}</p>
            <p>Publicado por {{ $post->user->name }} em {{ $post->created_at->format('d/m/Y') }}</p>
        </div>
        <div id="tdescani">
            <h3>Sobre o pet</h3>
            <p>{{ $post->informacoes ?? 'Sem descrição' }}</p>
        </div>
        <h3>Descrição do animal</h3>
        <div id="descval">
            <div>
                <h5>Idade</h5>
                <p>{{ $post->idade ?? '-' }}</p>
            </div>
            <div>
                <h5>Sexo</h5>
                <p>{{ $post->genero }}</p>
            </div>
            <div>
                <h5>Espécie</h5>
                <p>{{ $post->tipo_animal }}</p>
            </div>
            <div>
                <h5>Raça</h5>
                <p>{{ $post->raca ?? '-' }}</p>
            </div>
            <div>
                <h5>Porte</h5>
                <p>{{ $post->porte }}</p>
            </div>
        </div>
    </div>
</div>

<h3 style="text-align: center; margin-top:3%">Sobre o dono</h3>


<div class="descdono">
      <div class="mapflex">
        <div class="maptx">
            <h5>Endereço</h5>
            <p>{{ $post->endereco ?? '' }} 
                {{ $post->bairro ?? '' }}, 
                {{ $post->cidade ?? '' }} - 
                {{ $post->estado ?? '' }} 
                {{ $post->cep ?? '' }}</p>

                @if($post->cidade && $post->estado)
    <div id="map"></div>
@endif
        </div>

    </div>
    <div class="descdonocont">
        <div>
            <h5>Nome do Dono</h5>
            <p>{{ $post->user->name }}</p>
        </div>
        <div>
            <h5>Contato</h5>
            <p>{{ $post->user->telefone ?? 'Não informado' }}</p>
        </div>
        <div>
            <h5>E-mail</h5>
            <p>{{ $post->user->email }}</p>
        </div>

        @if(auth()->id() == $post->user_id)
   <button type="button" class="contdono"
    onclick="window.location='{{ route('postagem.edit', $post->id) }}'">
    Editar
</button>
@endif

     @if(auth()->id() !== $post->user_id)
    <button class="contdono" onclick="startChat({{ $post->user->id }})">
        Fale com {{ $post->user->name }}
    </button>
@endif

<script>
  function startChat(userId) {
    fetch(`/chat/start/${userId}`)
        .then(res => res.json())
        .then(data => {
            const outroUser = data.outro_user;

            // abre sidebar e troca pra view de mensagens
            document.getElementById('chatSidebar').classList.add('active');
            document.getElementById('chatListView').style.display = "none";
            document.getElementById('chatMessagesView').style.display = "flex";

            // seta conversa atual
            currentConversaId = data.conversa_id;
            lastMessageId = 0;

            // preenche header
            document.getElementById('chatUserName').innerText = outroUser.name;
            document.getElementById('chatUserFoto').src = outroUser.foto !== "" 
                ? outroUser.foto 
                : "/IMG/user-icon.svg";

            document.getElementById('conversaIdInput').value = currentConversaId;

            // carrega mensagens
            loadChat(currentConversaId, true);

          
            if (!document.querySelector(`.conversa-item[data-id="${data.conversa_id}"]`)) {
                const chatList = document.getElementById('chatList');

                // remove "Sem conversas" se existir
                const noChats = document.getElementById('noChatsMessage');
                if (noChats) noChats.remove();

                // cria novo item
const div = document.createElement('div');
div.classList.add('conversa-item');
div.dataset.id = data.conversa_id;
div.dataset.nome = outroUser.name;
div.dataset.foto = outroUser.foto ?? "/IMG/user-icon.svg";

div.style.display = "flex";
div.style.alignItems = "center";
div.style.gap = "10px";
div.style.padding = "8px";
div.style.cursor = "pointer";

div.innerHTML = `
    <div class="foto-container" style="width:50px; height:50px; border-radius:50%; overflow:hidden;"></div>
    <div style="flex:1;">
        <strong style="display:block;">${outroUser.name}</strong>
        <p style="font-size:12px; color:#aaa; margin:0;">Sem mensagens ainda</p>
    </div>
`;

chatList.prepend(div);

// 🔥 renderiza a foto (com cache-busting)
renderConversaFoto(div);

// reanexa evento de clique
div.addEventListener('click', () => {
    currentConversaId = div.dataset.id;
    lastMessageId = 0;

    document.getElementById('chatListView').style.display = "none";
    document.getElementById('chatMessagesView').style.display = "flex";

    document.getElementById('chatUserName').innerText = div.dataset.nome;
    document.getElementById('chatUserFoto').src = div.dataset.foto !== "" 
        ? div.dataset.foto 
        : "/IMG/user-icon.svg";

    document.getElementById('conversaIdInput').value = currentConversaId;
    loadChat(currentConversaId, true);
});

            }
        });
}

</script>

    </div>
</div>


 
 
<script>
document.addEventListener("DOMContentLoaded", function() {
    @if($post->cidade && $post->estado)
        var endereco = "{{ $post->bairro . ', ' . $post->cidade . ' - ' . $post->estado }}";
 
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(endereco)}`)
            .then(res => res.json())
            .then(data => {
                if (data && data.length > 0) {
                    var lat = data[0].lat;
                    var lon = data[0].lon;
 
                    var map = L.map('map').setView([lat, lon], 15);
 
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                    }).addTo(map);
 
                    L.marker([lat, lon]).addTo(map)
                        .bindPopup("Local aproximado")
                        .openPopup();
                }
            })
            .catch(err => console.error("Erro ao buscar localização:", err));
    @endif
});
</script>

@include("components.footer")