@include("components.header")


    <h1 style="text-align: center; margin-top:300px;">Pergunta Secreta</h1>
    <p style="text-align: center;">Responda corretamente para redefinir sua senha</p>

    <form method="POST" action="{{ route('verifica-resposta-secreta') }}">
        @csrf
        <input type="hidden" name="email" value="{{ $user->email }}">

        <div style="text-align: center;">
            <label><strong>Pergunta:</strong></label><br>
            <!-- aqui ele ta chamando a variavel das perguntas -->
           <p>{{ $pergunta }}</p>

            <input type="text" name="resposta_secreta" placeholder="Sua resposta" required>

            @error('resposta_secreta')
                <p style="color:red;">{{ $message }}</p>
            @enderror

            <div style="margin-top: 20px; margin-bottom:250px;">
                <button type="submit" class="but-csenha">Confirmar</button>
            </div>
        </div>
    </form>


@include("components.footer")