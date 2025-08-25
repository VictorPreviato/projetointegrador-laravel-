@include("components.header")


<div class="caixa-rsenha">
    <h1 class="trsenha" style="text-align: center;">Redefinição de senha</h1>
    <p class="prsenha" style="margin-bottom: 50px;">Digite a nova senha no campo abaixo para a alteração</p>

    <div class="col-12" style="text-align: center;">
        <form method="POST" action="{{ route('alterar-senha') }}">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="row" style="position: relative;">
                <input type="password" id="nova-senha" name="nova_senha" placeholder="Nova senha" required>
                <button id="nova-senhatoggle" class="show-psswd" type="button" data-toggle-target="#nova-senha">
                    <img src="./IMG/ICONSENHA/eye_open.svg" alt="">
                </button>
            </div>

            <div class="row" style="position: relative;">
                <input type="password" id="confirmar-nsenha" name="nova_senha_confirmation" placeholder="Confirmar a senha" required>
                <button id="confirmar-nsenhatoggle" class="show-psswd" type="button" data-toggle-target="#confirmar-nsenha">
                    <img src="./IMG/ICONSENHA/eye_open.svg" alt="">
                </button>
            </div>

            @if ($errors->any())
                <ul style="color:red; margin-top: 15px;">
                    @foreach ($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            @endif

            <div class="bt-rsenha" style="margin-top: 20px;">
                <div>
                    <button class="but-rcasenha" type="reset"><b>Cancelar</b></button>
                </div>
                <div>
                    <button class="but-rcsenha" type="submit"><b>Confirmar</b></button>
                </div>
            </div>
        </form>
    </div>
</div>

@include("components.footer")