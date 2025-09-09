@include("components.header")


<div class="txtcad">
<h1 style="text-align: center;">Crie sua conta</h1>

<h3 style="text-align: center;" >Enviaremos uma confirmação de cadastro para você pelo e-mail.</h3>
</div>

<form action="{{ route('cadastro.post') }}" method="POST">
    @csrf
<div class="container m-auto" id="cardform">
    <div class="row d-flex">
          @error('nome')
            <div class="text-danger">{{ $message }}</div>
        @enderror
        <div class="col-6">
            <input class="inputcol6cad" type="text" placeholder="Nome Completo*" required name="name" value="{{ old('name') }}" oninput="this.value = this.value.replace(/[^A-Za-zÀ-ÿ\s]/g, '')">
        </div>
        <div class="col-6">
            <input class="inputcol6cad" type="date" required name="data_nasc" required value="{{ old('data_nasc') }} " max="2025-12-31" >
        </div>
    </div>
    <div class="row">
          @error('cpf')
            <div class="text-danger">{{ $message }}</div>
        @enderror
        <div class="col-6">
            <input class="inputcol6cad" id="cpfMask" type="text" placeholder="CPF*" name="cpf" required value="{{ old('cpf') }}">
        </div>
        <div class="col-6">
            <input class="inputcol6cad" id="telefoneMask" type="text" placeholder="Telefone celular*" name="telefone" value="{{ old('telefone') }}">
            
        </div>
    </div>
   <div class="row">
    <div class="col-12">
        <input type="email" placeholder="E-mail*" required name="email" value="{{ old('email') }}">
        @error('email')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-12">
        <input type="email" placeholder="Confirme seu e-mail*" required name="email_confirmation" value="{{ old('email_confirmation') }}">
    </div>
</div>
    <div class="row">
        @error('password')
            <div class="text-danger">{{ $message }}</div>
        @enderror
        <div class="col-6 pass">
              <input class="a" type="password" name="password" id="password" placeholder="Crie sua senha*" required>
  <button class="show-psswd" type="button" data-toggle-target="#password">
    <img src="{{ asset('./IMG/ICONSENHA/eye_open.svg') }}" alt="">
  </button>

         
        </div>
        <div class="col-6 pass">
              <input class="a" type="password" placeholder="Confirme sua senha*" name="password_confirmation" id="confirm-password" required>
  <button class="show-psswd" type="button" data-toggle-target="#confirm-password">
    <img src="{{ asset('./IMG/ICONSENHA/eye_open.svg') }}" alt="">
  </button>
        </div>

          <small>A senha deve ter no mínimo 8 caracteres, incluindo: <b style="color:#31403E;">1 letra maiúscula, 1 letra minúscula e 1 número.</b>
  </small>
                        <!-- Pergunta Secreta -->
                         
         
<div class="custom-select-container">
  <h1 style="text-align: center;">Escolha uma pergunta secreta</h1>
  <p>Responda a pergunta de forma correta para ter acesso à alteração de senha.</p>

  <div class="custom-select" id="perguntaSelect">
    <div class="custom-select-trigger">Escolha sua pergunta</div>
    <div class="custom-options">
      <span class="custom-option" data-value="1">Qual o nome do seu herói favorito?</span>
      <span class="custom-option" data-value="2">Qual o nome do seu primeiro animal de estimação?</span>
      <span class="custom-option" data-value="3">Qual o nome da sua mãe?</span>
      <span class="custom-option" data-value="4">Qual o nome da sua escola primária?</span>
    </div>
  </div>

  <input type="hidden" name="pergunta" id="perguntaInput">

    

  <input class="resposta-secreta" type="text" placeholder="Resposta*" name="resposta_secreta" required>
</div>
  @error('resposta_secreta')
        <span class="text-danger">{{ $message }}</span>
    @enderror


        <div>
        <input type="checkbox" required> Estou de acordo com os <b><a href="{{ route('privacidade') }}" target="_blank" style="color: var(--cor-3);">termos de privacidade</a></b>
        </div>
        <div>
            <input type="submit" class="" name="but-cad" value="Criar Conta">
        </div>
    </div>
</div>
</form>

<p style="text-align: center;">Ja possui cadastro? <b><a href="{{ route('log') }}" style="color: var(--cor-3);">Acesse aqui!</a></b></p>

<script>
    document.addEventListener("DOMContentLoaded", function () {
  const select = document.getElementById("perguntaSelect");
  const trigger = select.querySelector(".custom-select-trigger");
  const options = select.querySelector(".custom-options");
  const hiddenInput = document.getElementById("perguntaInput");

  // abre/fecha lista
  trigger.addEventListener("click", () => {
    options.style.display = options.style.display === "block" ? "none" : "block";
  });

  // quando escolher opção
  select.querySelectorAll(".custom-option").forEach(option => {
    option.addEventListener("click", () => {
      trigger.textContent = option.textContent;
      hiddenInput.value = option.dataset.value;
      hiddenInput.setCustomValidity(""); // limpa erro de required
      select.classList.remove("invalid"); // remove borda vermelha se estava
      options.style.display = "none";
    });
  });

  // fecha se clicar fora
  document.addEventListener("click", e => {
    if (!select.contains(e.target)) {
      options.style.display = "none";
    }
  });

  // valida antes do submit
  const form = select.closest("form");
  if (form) {
    form.addEventListener("submit", e => {
      if (!hiddenInput.value) {
        hiddenInput.setCustomValidity("Por favor, escolha uma pergunta.");
        select.classList.add("invalid"); // adiciona borda vermelha
        e.preventDefault(); // bloqueia envio
      }
    });
  }
});

</script>

@include("components.footer")