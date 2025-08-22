@include("components.header")

<div class="caixa m-auto">
 
<img class="img-login"  src="IMG/LOGOS/Logosn.svg" alt="dotme">
 
<h1 class="text-log" style="text-align: center; margin-bottom: 3vw;">Acesse sua conta</h1>
 
<!-- Mensagem de erro -->
 
@if ($errors->any())
    <div style="color: red; text-align: center; margin-bottom: 1rem;">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

 
<!-- Formulário único envolvendo os campos -->
<form action="{{ route('dotmelogin.post') }}" method="POST">
    @csrf
 
    <div class="row">
        <div class="col-12">
            <input id="email-password" type="email" name="email" placeholder="E-mail" required>
        </div>
    </div>
 
    <div class="row">
        <div class="col-12 log-input">
            <input type="password" name="password" placeholder="Senha" id="login-password" required>
            <button class="show-psswd" type="button" data-toggle-target="#login-password" id="passtogglelog">
                <img src="./IMG/ICONSENHA/eye_open.svg" alt="">
            </button>
        </div>
    </div>
 
    <div class="row">
        <a style="color: var(--cor-1);" href="#">
            <h7 class="text-log7">Esqueci minha senha</h7>
        </a>
 
        <h7 style="color: var(--cor-1);" class="checkbox-login">
            Manter-me conectado <input style="padding: 10px;" type="checkbox" name="remember">
        </h7>
    </div>
 
    <div class="row">
        <button class="but-log" type="submit" name="but-log">
            <b>Login</b>
        </button>
    </div>
</form>
 
<div class="row">
    <form style="text-align: center; margin-top: 2vw">  
        <h7 class="text-log7">Não possui uma conta?
            <a style="color: var(--cor-1);" href="{{ route('cadastro')}}"><b> cadastre-se aqui!</b></a>
        </h7>
    </form>
</div>
 
</div>

@include("components.footer")