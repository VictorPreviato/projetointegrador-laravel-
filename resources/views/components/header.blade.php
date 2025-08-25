<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dotme</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=search" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>  
  <link rel="icon" type="image/x-icon" href="{{ asset('IMG/LOGOS/Logosn.svg') }}">
  <link rel="stylesheet" href="{{ asset('CSS/style.css') }}">
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>

</head>
<body>

<div class="headdesk"> <!-- Navbar Desktop -->
  <div>
    <a href="/"><img src="{{ asset('IMG/LOGOS/Logosn.svg') }}" alt="" class="logonav"></a>
    <button onclick="document.location='{{ route('adote') }}'" class="bnav">Adote um Pet</button>
    <button onclick="document.location='{{ route('desaparecidos') }}'" class="bnav">Desaparecidos</button>
    <button onclick="document.location='{{ route('sobre') }}'" class="bnav">Sobre o Projeto</button>
  </div>

  <div class="user-actions">
    <!-- <form action="">
      <img src="{{ asset('IMG/search.svg') }}" class="pesbtn" alt="">
      <input type="search">
    </form> -->

    @php
        $user = Auth::user();
    @endphp

    @if ($user)
      {{-- Usuário logado: mostrar nome + opções --}}
      <div class="img-box">
     <nav class="nav-header">
  <div class="profile">
    <div class="img-box">
       @if($user->foto)
                <img src="{{ asset('storage/' . $user->foto) }}" alt="foto do usuário" class="img-us" />
            @else
                <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#485958"><path d="M226-266q62-39 122.5-58T480-343q71 0 133 20t122 57q42-55 59-105.46 17-50.45 17-108.54 0-140.25-95.33-235.62Q620.35-811 480.17-811 340-811 244.5-715.62 149-620.25 149-480q0 58 17.03 108.22Q183.05-321.57 226-266Zm253.81-177q-60.97 0-101.89-41.19Q337-525.37 337-585.69q0-60.31 41.11-101.81 41.1-41.5 102.08-41.5 60.97 0 101.89 41.69 40.92 41.68 40.92 102Q623-525 581.89-484q-41.1 41-102.08 41Zm-.21 388q-87.15 0-164.9-33.28-77.75-33.29-135.82-91.56-58.07-58.27-90.98-135.44Q55-392.46 55-480.39t33.5-165.27Q122-723 180-780.5T315.25-872q77.24-34 165.25-34t165.25 34Q723-838 780.5-780.5T872-645.59q34 77.4 34 165.32 0 87.93-34 165.1Q838-238 780.5-180 723-122 645.46-88.5 567.93-55 479.6-55Z"/></svg>
            @endif
    </div>
  </div>
  <div class="menu">
    <ul>
      <li><a href="{{ route('perfil') }}"><i class="ph-bold ph-user"></i>&nbsp;Meu perfil</a></li>
      <li><a href="{{ route('config-perfil') }}"><i class="ph-bold ph-gear-six"></i>&nbsp;Configurações</a></li>
      <li><a href="#"><i class="ph-bold ph-question"></i>&nbsp;Ajuda</a></li>
      <form method="GET" action="{{ route('logout') }}">
    @csrf
      <li><a href="{{ route('logout') }}"><i class="ph-bold ph-sign-out"></i>&nbsp;Sair</a></li>
      </form>
    </ul>
 
    </div>
    </nav>
      </div>
    @else
      {{-- Usuário não logado: mostrar botões padrão --}}
      <button onclick="document.location='{{ route('cadastro') }}'" id="bcad">Cadastrar-se</button>
      <button onclick="document.location='{{ route('log') }}'" id="blog">Login</button>
    @endif
  </div>
</div>



 <nav class="navbar bg-body-tertiary fixed-top"> <!-- Navbar Mobile --> 
  <div class="container-fluid">
    <a href="/">
    <img src="{{ asset('IMG/LOGOS/Logosn.svg') }}" alt="" class="logonav"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        @if ($user)
        <p class="d-inline-flex gap-1">
  <a class="btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
     @if($user->foto)
                <img src="{{ asset('storage/' . $user->foto) }}" alt="foto do usuário" class="img-us" />
            @else
                <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#485958"><path d="M226-266q62-39 122.5-58T480-343q71 0 133 20t122 57q42-55 59-105.46 17-50.45 17-108.54 0-140.25-95.33-235.62Q620.35-811 480.17-811 340-811 244.5-715.62 149-620.25 149-480q0 58 17.03 108.22Q183.05-321.57 226-266Zm253.81-177q-60.97 0-101.89-41.19Q337-525.37 337-585.69q0-60.31 41.11-101.81 41.1-41.5 102.08-41.5 60.97 0 101.89 41.69 40.92 41.68 40.92 102Q623-525 581.89-484q-41.1 41-102.08 41Zm-.21 388q-87.15 0-164.9-33.28-77.75-33.29-135.82-91.56-58.07-58.27-90.98-135.44Q55-392.46 55-480.39t33.5-165.27Q122-723 180-780.5T315.25-872q77.24-34 165.25-34t165.25 34Q723-838 780.5-780.5T872-645.59q34 77.4 34 165.32 0 87.93-34 165.1Q838-238 780.5-180 723-122 645.46-88.5 567.93-55 479.6-55Z"/></svg>
            @endif
  </a>
 
</p>
<div class="collapse" id="collapseExample">
  <div class="card-body">
 
     <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">  

      <li><a class="a-perfil-mob" href="{{ route('perfil') }}"><i class="ph-bold ph-user"></i>&nbsp;Meu perfil</a></li>
      <li><a class="a-perfil-mob" href="{{ route('config-perfil') }}"><i class="ph-bold ph-gear-six"></i>&nbsp;Configurações</a></li>
      <li><a class="a-perfil-mob" href="#"><i class="ph-bold ph-question"></i>&nbsp;Ajuda</a></li>
      <form method="POST" action="{{ route('logout') }}">
    @csrf
      <li><a class="a-perfil-mob" href="{{ route('logout') }}"><i class="ph-bold ph-sign-out"></i>&nbsp;Sair</a></li>
      </form>
    </ul>
 
  </div>
</div>
 
 
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="container ms-1 mt-4">
 
</a>
<div>
        @else
        <button onclick="document.location='{{ route('log') }}'" id="blog">Login</button>
  <button onclick="document.location='{{ route('cadastro') }}'" id="bcad">Cadastrar-se</button>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      @endif
      <div class="container ms-1 mt-4">

</a>
<div>


  <!-- <form action="" class="ms-3">
    <img src="IMG/search.svg" class="pesbtn" alt="">
    <input type="search">
  </form> -->
</div>
</div>
      <div class="offcanvas-body mt-4 ms-3">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('adote')}}">Adote um Pet</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('desaparecidos')}}">Desaparecidos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="sobre">Sobre o Projeto</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>