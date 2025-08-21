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

        <button id="contdono" onclick="window.location.href='mailto:{{ $post->user->email }}'">
            Contate o dono
        </button>
    </div>
</div>



@include("components.footer")