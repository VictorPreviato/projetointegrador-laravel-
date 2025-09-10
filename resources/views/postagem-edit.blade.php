@include("components.header")



<h1 style="text-align: center;">Editar Postagem</h1>

<main class="container postcont">
  <section class="right-panel">
    <form method="POST" action="{{ route('postagem.update', $postagem->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
<div class="left-panel">
        <!-- Foto -->
        <div class="upload-box">
    <span>📷</span>
    <p>Altere a foto do pet (opcional)</p>

    <div id="preview-imagens" class="preview-imagens-container">
        @if($postagem->foto)
            <img id="imagePreview" src="{{ asset('storage/'.$postagem->foto) }}" 
                 alt="Foto atual" style="max-width:200px; display:block;" />
        @else
            <img id="imagePreview" style="max-width:200px; display:none;" />
        @endif
    </div>

    <div class="input-file-container">
        <input type="file" name="foto" id="inputArquivo" accept="image/*">
    </div>
</div>
</div>



        <!-- Tipo de cadastro -->
        <label for="tipo_cadastro">Tipo de cadastro*</label>
        <select name="tipo_cadastro" id="tipo_cadastro" required>
            <option value="perdido" {{ $postagem->tipo_cadastro == 'perdido' ? 'selected' : '' }}>Perdido</option>
            <option value="doacao" {{ $postagem->tipo_cadastro == 'doacao' ? 'selected' : '' }}>Doação</option>
        </select>

        <!-- Tipo de animal -->
        <label for="tipo_animal">Tipo de animal*</label>
        <select name="tipo_animal" id="tipo_animal" required>
            <option value="cachorro" {{ $postagem->tipo_animal == 'cachorro' ? 'selected' : '' }}>Cachorro</option>
            <option value="gato" {{ $postagem->tipo_animal == 'gato' ? 'selected' : '' }}>Gato</option>
        </select>

        <!-- Nome do pet -->
        <label for="nome_pet">Nome do pet</label>
        <input type="text" name="nome_pet" value="{{ $postagem->nome_pet }}">

        <!-- Raça -->
        <label>Raça</label>
        <input type="text" name="raca" value="{{ $postagem->raca }}">

        <!-- Porte -->
        <label for="porte">Porte do animal*</label>
        <select name="porte" id="porte" required>
            <option value="grande" {{ $postagem->porte == 'grande' ? 'selected' : '' }}>Grande</option>
            <option value="medio" {{ $postagem->porte == 'medio' ? 'selected' : '' }}>Médio</option>
            <option value="pequeno" {{ $postagem->porte == 'pequeno' ? 'selected' : '' }}>Pequeno</option>
        </select>

        <!-- Gênero -->
        <label for="genero">Gênero*</label>
        <select name="genero" id="genero" required>
            <option value="macho" {{ $postagem->genero == 'macho' ? 'selected' : '' }}>Macho</option>
            <option value="femea" {{ $postagem->genero == 'femea' ? 'selected' : '' }}>Fêmea</option>
        </select>

        <!-- Idade -->
        <label for="idade">Idade*</label>
        <select name="idade" id="idade" required>
            <option value="filhote" {{ $postagem->idade == 'filhote' ? 'selected' : '' }}>Filhote</option>
            <option value="adulto" {{ $postagem->idade == 'adulto' ? 'selected' : '' }}>Adulto</option>
            <option value="idoso" {{ $postagem->idade == 'idoso' ? 'selected' : '' }}>Idoso</option>
        </select>

        <!-- Informações -->
        <label>Informações adicionais</label>
        <textarea name="informacoes" rows="4">{{ $postagem->informacoes }}</textarea>

        

        <button type="submit" class="botao-publicar">Salvar Alterações</button>
    </form>
  </section>
</main>

@include("components.footer")