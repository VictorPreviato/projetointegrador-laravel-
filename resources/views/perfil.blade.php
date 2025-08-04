@include("components.header")

<main class="profile-cont">
    @php
        $user = Session::get('user');
    @endphp

    <section class="perfil-h">
        {{-- Imagem estática por enquanto --}}
        <img src="{{ asset('IMG/mulher.webp') }}" alt="foto do usuário" class="img-us" />

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