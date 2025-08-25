@include("components.header")

<!-- começo -->

<div class="caixa-senha">
    <h1 class="tsenha" style="text-align: center;">Redefinição de senha</h1>
    <p class="psenha" style="margin-bottom: 50px;">
        Confirme seu e-mail no campo abaixo para enviarmos um código de redefinição de senha
    </p>
    <div class="col-12" style="text-align: center;">
        <div class="row">
            <form method="POST" action="{{ route('verifica-email') }}">
                @csrf
                <input type="email" name="email" placeholder="E-mail" required>
                
                <div class="bt-senha" style="margin-top: 20px; display: flex; justify-content: center; gap: 10px;">
                    <button type="reset" class="but-casenha"><b>Cancelar</b></button>
                    <button type="submit" class="but-csenha"><b>Confirmar</b></button>
                </div>
            </form>
        </div>

        @if ($errors->has('email'))
            <p style="color:red; margin-top: 15px;">{{ $errors->first('email') }}</p>
        @endif
    </div>
</div>

<!-- fim -->

@include("components.footer")