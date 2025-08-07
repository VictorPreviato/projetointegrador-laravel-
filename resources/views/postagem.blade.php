@include("components.header")

<h1 style="text-align: center;">CADASTRO DE PET</h1>
 
  <main class="container postcont">
   
<script>
document.addEventListener('DOMContentLoaded', () => {
    const inputArquivo = document.getElementById('inputArquivo');
    const previewContainer = document.getElementById('preview-imagens');

    if (inputArquivo && previewContainer) {
        inputArquivo.addEventListener('change', (event) => {
            previewContainer.innerHTML = ''; // Limpa antes de adicionar novas imagens
            const arquivos = event.target.files;
            if (arquivos) {
                for (const arquivo of arquivos) {
                    if (arquivo.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            const previewItem = document.createElement('div');
                            previewItem.classList.add('preview-imagem-item');
                            const imagem = document.createElement('img');
                            imagem.src = e.target.result;
                            imagem.alt = arquivo.name;
                            previewItem.appendChild(imagem);
                            previewContainer.appendChild(previewItem);
                        };
                        reader.readAsDataURL(arquivo);
                    }
                }
            }
        });
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectTemNome = document.getElementById('tem_nome');
    const campoNome = document.getElementById('campo-nome');

    selectTemNome.addEventListener('change', function() {
        if (this.value === 'sim') {
            campoNome.style.display = 'block';
        } else {
            campoNome.style.display = 'none';
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipoCadastro = document.getElementById('tipo_cadastro');
    const campoUltimaLocalizacao = document.getElementById('campo-ultima-localizacao');

    tipoCadastro.addEventListener('change', function() {
        if (this.value === 'perdido') {
            campoUltimaLocalizacao.style.display = 'block';
        } else {
            campoUltimaLocalizacao.style.display = 'none';
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cepInput = document.getElementById('cep');
    const cidadeInput = document.getElementById('cidade');
    const estadoInput = document.getElementById('estado');
    const ultimaLocalizacaoInput = document.getElementById('ultima-localizacao');

    if (cepInput) {
        cepInput.addEventListener('blur', function() {
            const cep = cepInput.value.replace(/\D/g, '');
            if (cep.length === 8) {
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            cidadeInput.value = data.localidade;
                            estadoInput.value = data.uf;
                            ultimaLocalizacaoInput.value = `${data.localidade} - ${data.uf}`;
                        } else {
                            cidadeInput.value = '';
                            estadoInput.value = '';
                            ultimaLocalizacaoInput.value = '';
                            alert('CEP não encontrado.');
                        }
                    })
                    .catch(() => {
                        cidadeInput.value = '';
                        estadoInput.value = '';
                        ultimaLocalizacaoInput.value = '';
                        alert('Erro ao buscar o CEP.');
                    });
            } else {
                cidadeInput.value = '';
                estadoInput.value = '';
                ultimaLocalizacaoInput.value = '';
            }
        });
    }
});
</script>

    <section class="right-panel">

      <form method="POST" action="{{ route('postagem.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="left-panel">
          @if($errors->has('foto'))
        <span style="color:red;">{{ $errors->first('foto') }}</span>
          @endif
        <div class="upload-box">
    <span>📷</span>
    <p style="color: white">Envie uma ou mais fotos do pet</p>
    <div class="input-file-container">
        <label for="inputArquivo" class="custom-file-upload">Selecionar fotos</label>
        <input type="file" name="foto" id="inputArquivo" accept="image/*">
    </div>
    <div id="preview-imagens" class="preview-imagens-container"></div>
</div>
        </div>
        
        <label for="tipo_cadastro">Tipo de cadastro</label>
        @if($errors->has('tipo_cadastro'))
        <span style="color:red;">{{ $errors->first('tipo_cadastro') }}</span>
        @endif
        <select name="tipo_cadastro" id="tipo_cadastro" onchange="gerenciarCamposPerdido()">
          <option value="" disabled selected>Ex: Doação, Perdido</option>
          <option value="doacao">Doação</option>
          <option value="perdido">Perdido</option>
        </select>
        
        <label for="tipo_animal">Tipo de animal</label>
        @if($errors->has('tipo_animal'))
        <span style="color:red;">{{ $errors->first('tipo_animal') }}</span>
        @endif
        <select name="tipo_animal" id="tipo_animal" onchange="verificarOutroTipo()">
          <option value="" disabled selected>Ex: Cachorro, Gato</option>
          <option value="cachorro">Cachorro</option>
          <option value="gato">Gato</option>
          <option value="outro">Outro</option>
        </select>
 
         <label for="tem_nome">O pet tem nome?</label>
         @if($errors->has('tem_nome'))
         <span style="color:red;">{{ $errors->first('tem_nome') }}</span>
         @endif
      <select id="tem_nome" name="tem_nome">
        <option value="">Selecione</option>
        <option value="sim">Sim</option>
        <option value="nao">Não</option>
      </select>
      
 
      <div id="campo-nome" style="display: none;">
        <label for="nome_pet">Nome do pet</label>
        @if($errors->has('nome_pet'))
      <span style="color:red;">{{ $errors->first('nome_pet') }}</span>
      @endif
        <input type="text" id="nome_pet" name="nome_pet" placeholder="Digite o nome do pet" />
      </div>
 
       <label>Raça</label>
      @if($errors->has('raca'))
      <span style="color:red;">{{ $errors->first('raca') }}</span>
      @endif
        <input type="text" name="raca" placeholder="Ex: Labrador, Vira-lata, Pintcher" />
      

        <div class="campos-lado-a-lado">
          <div>
            <label for="genero">Gênero</label>
            @if($errors->has('genero'))
            <span style="color:red;">{{ $errors->first('genero') }}</span>
            @endif
            <select name="genero" id="genero">
              <option value="" disabled selected>Selecione</option>
              <option value="macho">Macho</option>
              <option value="femea">Fêmea</option>
            </select>
          </div>
 
          <div>
            <label for="idade">Idade</label>
            @if($errors->has('idade'))
            <span style="color:red;">{{ $errors->first('idade') }}</span>
            @endif
            <input type="text" name="idade" placeholder="Ex: 05 meses, 5 anos" />
          </div>
        </div>
 
        <label>Características do Pet (Tags)</label>
<div class="tag-checkboxes">
    <div class="tag-item">
      <input type="checkbox" id="tag-castrado" name="tags[]" value="castrado">
      <label for="tag-castrado">Castrado</label>
    </div>
 
    <div class="tag-item">
      <input type="checkbox" id="tag-vacinado" name="tags[]" value="vacinado">
      <label for="tag-vacinado">Vacinado</label>
    </div>
 
    <div class="tag-item">
      <input type="checkbox" id="tag-porte-pequeno" name="tags[]" value="porte pequeno">
      <label for="tag-porte-pequeno">Porte Pequeno</label>
    </div>
 
    <div class="tag-item">
      <input type="checkbox" id="tag-porte-medio" name="tags[]" value="porte médio">
      <label for="tag-porte-medio">Porte Médio</label>
    </div>
 
    <div class="tag-item">
      <input type="checkbox" id="tag-porte-grande" name="tags[]" value="porte grande">
      <label for="tag-porte-grande">Porte Grande</label>
    </div>
 
    <div class="tag-item">
      <input type="checkbox" id="tag-bom-criancas" name="tags[]" value="bom com crianças">
      <label for="tag-bom-criancas">Bom com Crianças</label>
    </div>
 
    <div class="tag-item">
      <input type="checkbox" id="tag-adocao-urgente" name="tags[]" value="adoção urgente">
      <label for="tag-adocao-urgente">Adoção Urgente</label>
    </div>
 
    <div class="tag-item">
      <input type="checkbox" id="tag-adestrado" name="tags[]" value="adestrado">
      <label for="tag-adestrado">Adestrado</label>
    </div>  
 
    <div class="tag-item">
      <input type="checkbox" id="tag-boa-saude" name="tags[]" value="boa saúde">
      <label for="tag-boa-saude">Boa Saúde</label>
    </div>
 
    <div class="tag-item">
      <input type="checkbox" id="tag-docil" name="tags[]" value="dócil">
      <label for="tag-docil">Dócil</label>
    </div>
 
    <div class="tag-item">
      <input type="checkbox" id="tag-brincalhao" name="tags[]" value="brincalhão">
      <label for="tag-brincalhao">Brincalhão</label>
    </div>
 
    <div class="tag-item">
      <input type="checkbox" id="tag-sociavel" name="tags[]" value="sociável">
      <label for="tag-sociavel">Sociável</label>
    </div>
 
    <div class="tag-item">
      <input type="checkbox" id="tag-alegre" name="tags[]" value="alegre">
      <label for="tag-alegre">Alegre</label>
    </div>
 
    <div class="tag-item">
      <input type="checkbox" id="tag-companheiro" name="tags[]" value="companheiro">
      <label for="tag-companheiro">Companheiro</label>
    </div>
</div>
 
        <label>Contato com tutor</label>
        @if($errors->has('contato'))
        <span style="color:red;">{{ $errors->first('contato') }}</span>
        @endif
        <input type="text" name="contato" placeholder="Ex: Telefone; Email; Whatsapp." />

        <div id="campo-ultima-localizacao" style="display: none;">
          <label for="ultima-localizacao">Última localização</label>
          <br>
          <label for="cep">CEP</label>
          @if($errors->has('ultima_localizacao'))
          <span style="color:red;">{{ $errors->first('ultima_localizacao') }}</span>
          @endif
          <input type="text" name="cep" id="cep" maxlength="9" placeholder="Digite o CEP" />

         <label for="cidade">Cidade</label>
         <input type="text" name="cidade" id="cidade" readonly />

         <label for="estado">Estado</label>
         <input type="text" name="estado" id="estado" readonly />

  <!-- Campo oculto para enviar a localização completa -->
  <input type="hidden" name="ultima_localizacao" id="ultima-localizacao" />
  </div>
 
        <label>Informações adicionais</label>
        
        <textarea name="informacoes" rows="4"></textarea>
 
        <button type="submit" class="botao-publicar">Publicar</button>
      </form>

    </section>
 
     <button type="submit" class="botao-publicar-mobile">Publicar</button>
  </main>

@include("components.footer")