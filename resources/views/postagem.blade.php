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
    const labelLocalizacao = document.getElementById('label-localizacao');

    tipoCadastro.addEventListener('change', function() {
        if (this.value === 'perdido' || this.value === 'doacao') {
            campoUltimaLocalizacao.style.display = 'block';
            if (this.value === 'perdido') {
                labelLocalizacao.textContent = 'Última localização';
            } else if (this.value === 'doacao') {
                labelLocalizacao.textContent = 'Localização';
            }
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

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const tipoCadastro = document.getElementById('tipo_cadastro');
    const campoUltimaLocalizacao = document.getElementById('campo-ultima-localizacao');
    const labelLocalizacao = document.getElementById('label-localizacao');

    function atualizarCampos() {
        if (tipoCadastro.value === 'perdido' || tipoCadastro.value === 'doacao') {
            campoUltimaLocalizacao.style.display = 'block';
            labelLocalizacao.textContent = tipoCadastro.value === 'perdido' 
                ? 'Última localização' 
                : 'Localização';
        } else {
            campoUltimaLocalizacao.style.display = 'none';
        }
    }

    // Executa ao mudar o select
    tipoCadastro.addEventListener('change', atualizarCampos);

    // Executa no carregamento para restaurar estado após erro
    atualizarCampos();
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
        <input type="file" name="foto" id="inputArquivo" accept="image/*" required>
    </div>
    <div id="preview-imagens" class="preview-imagens-container"></div>
</div>
        </div>
        


        <!-- Tipo de cadastro -->
        <label for="tipo_cadastro">Tipo de cadastro</label>
        @if($errors->has('tipo_cadastro'))
        <span style="color:red;">{{ $errors->first('tipo_cadastro') }}</span>
        @endif
        <select name="tipo_cadastro" id="tipo_cadastro" onchange="gerenciarCamposPerdido()">
          <option value="" disabled selected>Ex: Doação, Perdido</option>
          <option value="perdido" {{ old('tipo_cadastro') == 'perdido' ? 'selected' : '' }}>Perdido</option>
        <option value="doacao" {{ old('tipo_cadastro') == 'doacao' ? 'selected' : '' }}>Doação</option>
        </select>
        


        <!-- Tipo de animal -->
        <label for="tipo_animal">Tipo de animal</label>
        @if($errors->has('tipo_animal'))
        <span style="color:red;">{{ $errors->first('tipo_animal') }}</span>
        @endif
        <select name="tipo_animal" id="tipo_animal" onchange="verificarOutroTipo()">
          <option value="" disabled selected>Ex: Cachorro, Gato</option>
          <option value="cachorro" {{ old('tipo_animal') == 'cachorro' ? 'selected' : '' }}>Cachorro</option>
          <option value="gato" {{ old('tipo_animal') == 'gato' ? 'selected' : '' }}>Gato</option>
          <option value="outro" {{ old('tipo_animal') == 'outro' ? 'selected' : '' }}>Outro</option>
        </select>
 


        <!-- Tem nome -->
         <label for="tem_nome">O pet tem nome?</label>
         @if($errors->has('tem_nome'))
         <span style="color:red;">{{ $errors->first('tem_nome') }}</span>
         @endif
      <select id="tem_nome" name="tem_nome">
        <option value="">Selecione</option>
        <option value="sim" {{ old('tem_nome') == 'sim' ? 'selected' : '' }}>Sim</option>
        <option value="nao" {{ old('tem_nome') == 'não' ? 'selected' : '' }}>Não</option>
      </select>
      
 

      <!-- Preenchimento do nome -->
      <div id="campo-nome" style="display: none;">
        <label for="nome_pet">Nome do pet</label>
        @if($errors->has('nome_pet'))
      <span style="color:red;">{{ $errors->first('nome_pet') }}</span>
      @endif
        <input type="text" id="nome_pet" name="nome_pet" value="{{ old('nome_pet') }}" placeholder="Digite o nome do pet" />
      </div>
 


      <!-- Raça -->
       <label>Raça</label>
      @if($errors->has('raca'))
      <span style="color:red;">{{ $errors->first('raca') }}</span>
      @endif
        <input type="text" name="raca" id="raca" value="{{ old('raca') }}" placeholder="Ex: Labrador, Vira-lata" />



      <!-- Porte do animal -->
        <label for="porte">Porte do animal</label>
        @if($errors->has('porte'))
        <span style="color:red;">{{ $errors->first('porte') }}</span>
        @endif
        <select name="porte" id="porte">
        <option value="">Selecione</option>
        <option value="grande" {{ old('porte') == 'grande' ? 'selected' : '' }}>Grande</option>
        <option value="medio" {{ old('porte') == 'medio' ? 'selected' : '' }}>Médio</option>
        <option value="pequeno" {{ old('porte') == 'pequeno' ? 'selected' : '' }}>Pequeno</option>
        </select>
 


      <!-- Gênero -->
        <div class="campos-lado-a-lado">
          <div>
            <label for="genero">Gênero</label>
            @if($errors->has('genero'))
            <span style="color:red;">{{ $errors->first('genero') }}</span>
            @endif
            <select name="genero" id="genero">
              <option value="" disabled selected>Selecione</option>
              <option value="macho" {{ old('genero') == 'macho' ? 'selected' : '' }}>Macho</option>
              <option value="femea" {{ old('genero') == 'femea' ? 'selected' : '' }}>Fêmea</option>
            </select>
          </div>
 


        <!-- Idadde -->
          <div>
            <label for="idade">Idade</label>
            @if($errors->has('idade'))
            <span style="color:red;">{{ $errors->first('idade') }}</span>
            @endif
             <input type="text" name="idade" id="idade" placeholder="Ex: 2 anos, filhote" />
          </div>
        </div>
 


        <!-- Contato -->
        <label>Contato com tutor</label>
        @if($errors->has('contato'))
        <span style="color:red;">{{ $errors->first('contato') }}</span>
        @endif
        <input type="text" name="contato" value="{{ old('contato') }}" placeholder="Ex: Telefone; Email; Whatsapp." />



        <!-- Última localização -->
        <div id="campo-ultima-localizacao" style="display: none;">
          <label id="label-localizacao" for="ultima-localizacao">Última localização</label>
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


        
        <!-- Informações adicionais -->
        <textarea name="informacoes" id="informacoes" rows="4">{{ old('informacoes') }}</textarea>
 
        <button type="submit" class="botao-publicar">Publicar</button>
      </form>

    </section>
 
     <button type="submit" class="botao-publicar-mobile">Publicar</button>
  </main>

@include("components.footer")