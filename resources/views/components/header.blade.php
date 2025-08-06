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
  <link rel="icon" type="image/x-icon" href="IMG/LOGOS/Logosn.svg">
<link href="CSS/style.css" rel="stylesheet" >

</head>
<body>

<div class="headdesk"> <!-- Navbar Desktop -->
  <div>
    <a href="/"><img src="{{ asset('IMG/LOGOS/Logosn.svg') }}" alt="" class="logonav"></a>
    <button onclick="document.location='adote'" class="bnav">Adote um Pet</button>
    <button onclick="document.location='desaparecidos'" class="bnav">Desaparecidos</button>
    <button onclick="document.location='sobre'" class="bnav">Sobre o Projeto</button>
  </div>

  <div class="user-actions">
    <form action="">
      <img src="{{ asset('IMG/search.svg') }}" class="pesbtn" alt="">
      <input type="search">
    </form>

    @php
        $user = Session::get('user');
    @endphp

    @if ($user)
      {{-- Usuário logado: mostrar nome + opções --}}
      <div class="img-box">
     <nav class="nav-header">
  <div class="profile">
    <div class="img-box">
       @if($user->foto)
                <img src="{{ asset('storage/fotos/' . $user->foto) }}" alt="foto do usuário" class="img-us" />
            @else
                <img src="{{ asset('IMG/user-icon.png') }}" alt="foto padrão" class="img-us" />
            @endif
    </div>
  </div>
  <div class="menu">
    <ul>
      <li><a href="{{ route('perfil') }}"><i class="ph-bold ph-user"></i>&nbsp;Meu perfil</a></li>
      <li><a href="#"><i class="ph-bold ph-gear-six"></i>&nbsp;Configurações</a></li>
      <li><a href="#"><i class="ph-bold ph-question"></i>&nbsp;Ajuda</a></li>
      <li><a href="{{ route('logout') }}"><i class="ph-bold ph-sign-out"></i>&nbsp;Sair</a></li>
    </ul>
 
    </div>
    </nav>
      </div>
    @else
      {{-- Usuário não logado: mostrar botões padrão --}}
      <button onclick="document.location='cadastro'" id="bcad">Cadastrar-se</button>
      <button onclick="document.location='log'" id="blog">Login</button>
    @endif
  </div>
</div>



 <nav class="navbar bg-body-tertiary fixed-top"> <!-- Navbar Mobile --> 
  <div class="container-fluid">
    <a href="/">
    <img src="IMG/LOGOS/Logosn.svg" alt="" class="logonav"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        @if ($user)
        <p class="d-inline-flex gap-1">
  <a class="btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
    <img class="foto-header-mob" src="https://i.postimg.cc/BvNYhMHS/user-img.jpg" alt="some user image">
  </a>
 
</p>
<div class="collapse" id="collapseExample">
  <div class="card-body">
 
     <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">  
 
      <li><a class="a-perfil-mob" href="#"><i class="ph-bold ph-user"></i>&nbsp;Meu perfil</a></li>
      <li><a class="a-perfil-mob" href="#"><i class="ph-bold ph-gear-six"></i>&nbsp;Configurações</a></li>
      <li><a class="a-perfil-mob" href="#"><i class="ph-bold ph-question"></i>&nbsp;Ajuda</a></li>
      <li><a class="a-perfil-mob" href="#"><i class="ph-bold ph-sign-out"></i>&nbsp;Sair</a></li>
    </ul>
 
  </div>
</div>
 
 
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="container ms-1 mt-4">
 
</a>
<div>
        @else
        <button onclick="document.location='log'" id="blog">Login</button>
  <button onclick="document.location='cadastro'" id="bcad">Cadastrar-se</button>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      @endif
      <div class="container ms-1 mt-4">

</a>
<div>


  <form action="" class="ms-3">
    <img src="IMG/search.svg" class="pesbtn" alt="">
    <input type="search">
  </form>
</div>
</div>
      <div class="offcanvas-body mt-4 ms-3">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link" href="adote">Adote um Pet</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="dasaparecidos">Desaparecidos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="sobre">Sobre o Projeto</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>