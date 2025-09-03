@include("components.header")
 
<header class="filtros">
  <h1>Pets Perdidos</h1>
  <p>Ajude a resgatar a felicidade de um dono!</p>
 
  <div class="fill">
    <h4 class="fil">Filtre por localização:</h4>
    <form class="filter-form" method="GET" action="">
 
      <select name="especie">
        <option value="">Espécie</option>
        <option value="cachorro" {{ request('especie') === 'cachorro' ? 'selected' : '' }}>Cachorro</option>
        <option value="gato" {{ request('especie') === 'gato' ? 'selected' : '' }}>Gato</option>
      </select>
 
      <select name="sexo">
        <option value="">Sexo</option>
        <option value="macho" {{ request('sexo') === 'macho' ? 'selected' : '' }}>Macho</option>
        <option value="femea" {{ request('sexo') === 'femea' ? 'selected' : '' }}>Fêmea</option>
      </select>
 
      <select name="idade">
        <option value="">Idade</option>
        <option value="filhote" {{ request('idade') === 'filhote' ? 'selected' : '' }}>Filhote</option>
        <option value="adulto" {{ request('idade') === 'adulto' ? 'selected' : '' }}>Adulto</option>
        <option value="idoso" {{ request('idade') === 'idoso' ? 'selected' : '' }}>Idoso</option>
      </select>
 
      <select name="porte">
        <option value="">Porte do animal</option>
        <option value="pequeno" {{ request('porte') === 'pequeno' ? 'selected' : '' }}>Pequeno</option>
        <option value="medio" {{ request('porte') === 'medio' ? 'selected' : '' }}>Médio</option>
        <option value="grande" {{ request('porte') === 'grande' ? 'selected' : '' }}>Grande</option>
      </select>
 
      <input  type="text" id="cepMask" name="cep" placeholder="Digite o CEP" maxlength="9"
             value="{{ request('cep') }}" onblur="buscarCEP()">
 
      <input type="text" id="cidade" name="cidade" placeholder="Cidade"
             value="{{ request('cidade') }}" readonly>
 
      <input type="text" id="estado" name="estado" placeholder="Estado"
             value="{{ request('estado') }}" readonly>
 
      <button type="submit">Filtrar</button>
    </form>
  </div>
</header>
 
<main class="filtro">
  <h2>Desaparecidos:</h2>
 
  <div class="fundos">
    @if($postagens->isEmpty())
      <p>Nenhum pet desaparecido encontrado com esses filtros.</p>
    @else
      @php $totalMostrados = 0; @endphp
      @foreach($postagens as $pet)
        @php $hidden = $totalMostrados < 6 ? '' : 'hidden'; @endphp
        <div class="foto {{ $hidden }}">
        <a href="{{ route('postagem.show', $pet->id) }}" class="foto {{ $hidden }}">
          <img src="{{ asset('storage/' . $pet->foto) }}" alt="{{ $pet->nome_pet ?? 'Pet' }}">
          <h3 class="tl">{{ $pet->nome_pet ?? 'Sem nome' }}</h3>
          <p class="tl">{{ $pet->ultima_localizacao }}</p>
          <p class="tl">
          Dono: {{ $pet->user->name ?? 'Não informado' }}<br>
          Telefone: {{ $pet->user->telefone ?? 'Não informado' }}
          </p>
        </a>
        </div>
        @php $totalMostrados++; @endphp
      @endforeach
    @endif
  </div>
 
  <button class="load-more" onclick="mostrarMais()">Ver mais...</button>
</main>
 
<div class="botao-doacao">
  <p>Seu PET sumiu?<br>Precisa de ajuda?</p>
  <button onclick="document.location='{{ url('postagem') }}'">Clique aqui</button>
</div>
 
@include("components.footer")