@include("components.header")


<div class="txtcad">
<h1 style="text-align: center;">Crie sua conta</h1>

<h3 style="text-align: center;" >Enviaremos uma confirmação de cadastro para você pelo e-mail.</h3>
</div>

<form action="{{ route('cadastro.post') }}" method="POST">
    @csrf
<div class="container m-auto" id="cardform">
    <div class="row d-flex">
        <div class="col-6">
            <input type="text" placeholder="Nome Completo*" required name="nome">
        </div>
        <div class="col-6">
            <input type="date" required name="data_nasc" required>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <input id="cpfMask" type="text" placeholder="CPF*" name="cpf" required>
        </div>
        <div class="col-6">
            <input id="telefoneMask" type="text" placeholder="Telefone celular*" name="telefone" >
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <input  type="email" placeholder="E-mail*" required name="email">
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <input type="email" placeholder="Confirme seu e-mail*" required>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <input type="password" placeholder="Crie sua senha*" required name="password">
        </div>
        <div class="col-6">
            <input type="password"  placeholder="Confirme sua senha*"  required>
        </div>
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