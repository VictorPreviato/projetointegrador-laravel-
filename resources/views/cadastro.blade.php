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
            <input type="text" placeholder="Nome Completo*" required name="name" value="{{ old('name') }}">
        </div>
        <div class="col-6">
            <input type="date" required name="data_nasc" required value="{{ old('data_nasc') }}">
        </div>
    </div>
    <div class="row">
          @error('cpf')
            <div class="text-danger">{{ $message }}</div>
        @enderror
        <div class="col-6">
            <input id="cpfMask" type="text" placeholder="CPF*" name="cpf" required value="{{ old('cpf') }}">
        </div>
        <div class="col-6">
            <input id="telefoneMask" type="text" placeholder="Telefone celular*" name="telefone" value="{{ old('telefone') }}">
            
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
              <input type="password" name="password" id="password" placeholder="Crie sua senha*" required>
  <button class="show-psswd" type="button" data-toggle-target="#password">
    <img src="./IMG/ICONSENHA/eye_open.svg" alt="">
  </button>
         
        </div>
        <div class="col-6 pass">
              <input type="password" placeholder="Confirme sua senha*" name="password_confirmation" id="confirm-password" required>
  <button class="show-psswd" type="button" data-toggle-target="#confirm-password">
    <img src="./IMG/ICONSENHA/eye_open.svg" alt="">
  </button>
        </div>
                        <!-- Pergunta Secreta -->
                         
         
       <div>
    <h1 style="text-align: center;">Escolha uma pergunta secreta</h1>
    <p>Responda a pergunta de forma correta para ter acesso à alteração de senha.</p>

    
        <select class="pergunta-secreta" name="pergunta" required>
            <option value="" disabled selected>Escolha sua pergunta</option>
            <option value="1">Qual o nome do seu heroi favorito?</option>
            <option value="2">Qual o nome do seu primeiro animal de estimação?</option>
            <option value="3">Qual o nome da sua mãe?</option>
            <option value="4">Qual o nome da sua escola primária?</option>
        </select>
         <input class="resposta-secreta" type="text" placeholder="Resposta*" name="resposta_secreta" required>


        <div>

        <div>
        <input type="checkbox" required> Estou de acordo com os <b><a href="" style="color: var(--cor-3);">termos de privacidade</a></b>
        </div>
        <div>
            <input type="submit" class="" name="but-cad" value="Criar Conta">
        </div>
    </div>
</div>
</form>

<p style="text-align: center;">Ja possui cadastro? <b><a href="" style="color: var(--cor-3);">Acesse aqui!</a></b></p>

@include("components.footer")