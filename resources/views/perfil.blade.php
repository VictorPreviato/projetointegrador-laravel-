@include("components.header")

<main class="profile-cont">
    @php
        $user = Session::get('user');
    @endphp

    <section class="perfil-h">
        <div class="img-us-container" style="text-align: center;">
            @if($user->foto)
                <img src="{{ asset('storage/fotos/' . $user->foto) }}" alt="foto do usuário" class="img-us" />
            @else
                <img src="{{ asset('IMG/user-icon.png') }}" alt="foto padrão" class="img-us" />
            @endif
        </div>
        
        <form action="{{ route('perfil.foto') }}" method="POST" enctype="multipart/form-data" style="text-align: center; margin-top: 10px;">
    @csrf
    <input type="file" name="foto" id="foto" style="display: none;">
    <label for="foto" style="display: inline-block; background-color: #ffffff22; color: #fff; padding: 8px 15px; border-radius: 6px; cursor: pointer;">
        Alterar foto de perfil
    </label>
    <button type="submit">Enviar foto</button> <!-- botão temporário -->
</form>


        <div class="info-us">
            <h1 style="color: #fff;">{{ $user->nome }}</h1>
        </div>
    </section>

    <section class="info-b">
        <div class="info-c">
            <h3><b>Informações</b></h3>
            <p>{{ $user->telefone ?? '(00) 00000-0000' }}</p>
            <p>{{ $user->email }}</p>
        </div>

        <div class="post-listas">
            <h3><b>Post realizados</b></h3>
            {{-- Em breve: listar posts do usuário --}}
        </div>
    </section>

    <section class="info-c" style="margin-top: 40px;">
        <h3><b>Depoimentos realizados</b></h3>
        {{-- Em breve: listar depoimentos do usuário --}}
    </section>
</main>

@include("components.footer")