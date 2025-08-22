@include("components.header")

<body>

  <div class="container">
    <div class="perfil">
      @if($user->foto)
                <img src="{{ asset('storage/' . $user->foto) }}" alt="foto do usuário" class="img-us" />
            @else
                <svg xmlns="http://www.w3.org/2000/svg" height="200px" viewBox="0 -960 960 960" width="200px" fill="#F3F3F3"><path d="M222.96-257.63q62.76-39.76 124.02-59.9T480-337.67q71.76 0 133.76 20.38 62 20.38 124.28 59.66 43.53-54.24 61.67-108.15Q817.85-419.7 817.85-480q0-143.86-96.98-240.86-96.98-96.99-240.83-96.99-143.84 0-240.87 96.99-97.02 97-97.02 240.86 0 60.28 18.53 114.14t62.28 108.23Zm256.85-190.7q-58.57 0-98.4-40.04-39.84-40.05-39.84-98.46t40.02-98.39q40.03-39.98 98.6-39.98 58.57 0 98.4 40.17 39.84 40.16 39.84 98.57 0 58.42-40.02 98.28-40.03 39.85-98.6 39.85Zm-.21 374.31q-84.11 0-158.34-31.93-74.23-31.92-129.28-87.33-55.05-55.4-86.5-129.28-31.46-73.87-31.46-157.91 0-84.04 31.98-157.96t87.32-128.75q55.33-54.84 129.23-86.94 73.89-32.1 157.95-32.1 84.06 0 157.95 32.1 73.9 32.1 128.73 86.94 54.84 54.83 86.94 128.89 32.1 74.05 32.1 158.02 0 83.98-32.1 157.8-32.1 73.82-86.94 129.15-54.83 55.34-129.01 87.32-74.19 31.98-158.57 31.98Z"/></svg>
            @endif
      <div class="info-usuario">
        <h1 style="color: #fff;">{{$user->name}}</h1>
        <!-- Link para alterar foto -->
<a href="#" class="alterar-foto" onclick="document.getElementById('inputFoto').click(); return false;">
    Alterar foto de perfil
</a>
@if($user->foto)

   <a href="#" class="remover-foto" 
   onclick="event.preventDefault(); 
            if(confirm('Confirma remoção da foto de perfil?')) { 
                document.getElementById('formRemoverFoto').submit(); 
            }">
    Remover foto de perfil
</a>

<form id="formRemoverFoto" action="{{ route('perfil.removerFoto') }}" method="POST" style="display: none;">
    @csrf
</form>
@endif


<!-- Formulário escondido -->
<form id="formFoto" action="{{ route('perfil.foto') }}" method="POST" enctype="multipart/form-data" style="display: none;">
    @csrf
    <input type="file" name="foto" id="inputFoto" accept="image/*" onchange="document.getElementById('formFoto').submit();">
</form>

      </div>
    </div>
    

   <form action="{{ route('usuario.update') }}" method="POST">
    @csrf
    @method('PUT')

    <h2><b>Dados do Usuário</b></h2>

    <div class="linha">
        <div class="campo">
            <label>Nome:</label>
            <input type="text" name="name" value="{{ $user->name }}" placeholder="Digite seu nome completo" required>
        </div>
        <div class="campo">
            <label>Data de Nascimento:</label>
            <input type="date" name="data_nasc" value="{{ $user->data_nasc }}" required>
        </div>
    </div>

    <h2><b>Contatos</b></h2>

    <div class="linha">
        <div class="campo">
            <label>Celular:</label>
            <input id="telefoneMask" name="telefone" value="{{ $user->telefone }}" placeholder="Telefone celular" required>
        </div>
    </div>

    <div class="linha">
        <div class="campo">
            <label>E-mail:</label>
            <input type="email" name="email" value="{{ $user->email }}" placeholder="E-mail" required>
        </div>
        <div class="campo">
            <label>Confirme seu E-mail:</label>
            <input type="email" name="email_confirmation" value="{{ $user->email }}" placeholder="Confirme seu E-mail" required>
        </div>
    </div>

    <h2><b>Alterar Senha</b></h2>
    <div class="linha">
    <div class="campo">
        @error('current_password')
            <div class="text-danger">{{ $message }}</div>
        @enderror
        <label>Senha atual:</label>
         <div class="redsenhaconf">
        <input type="password" id="asenhaconf" name="current_password" >
        <button class="show-psswd" type="button" data-toggle-target="#asenhaconf" id="passtogglelog">
                <img src="./IMG/ICONSENHA/eye_open.svg" alt="">
         </div>
    </div>
</div>

    <div class="linha">
        <div class="campo">
            <label>Nova senha:</label>
            <div class="redsenhaconf">
            <input type="password" id="nsenhaconf" name="password">
            <button class="show-psswd" type="button" data-toggle-target="#nsenhaconf" id="passtogglelog">
                <img src="./IMG/ICONSENHA/eye_open.svg" alt="">
            </button>
              @error('password')
        <div class="text-danger">{{ $message }}</div>
    @enderror
            </div>

        </div>
        <div class="campo">
            <label>Confirme a nova senha:</label>
             <div class="redsenhaconf">
            <input type="password" id="cnsenhaconf" name="password_confirmation">
              <button class="show-psswd" type="button" data-toggle-target="#cnsenhaconf" id="passtogglelog">
                <img src="./IMG/ICONSENHA/eye_open.svg" alt="">
            </button>
             </div>
        </div>
    </div>


    <div class="botoes">
        <button type="button" class="cancelar">Cancelar</button>
        <button type="submit" class="salvar">Salvar</button>
    </div>
</form>


</body>

@include("components.footer")