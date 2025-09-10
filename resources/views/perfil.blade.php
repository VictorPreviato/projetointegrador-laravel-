@include("components.header")

<main class="profile-cont">
    @php
        $user = Auth::user();
    @endphp

    <section class="perfil-h">
        <div class="img-us-container" style="text-align: center;">
            
            @if($user->foto)
               <img src="{{ asset('storage/' . $user->foto) }}" alt="foto do usuário" class="img-us" />
            @else
                <svg xmlns="http://www.w3.org/2000/svg" height="200px" viewBox="0 -960 960 960" width="200px" fill="#F3F3F3"><path d="M222.96-257.63q62.76-39.76 124.02-59.9T480-337.67q71.76 0 133.76 20.38 62 20.38 124.28 59.66 43.53-54.24 61.67-108.15Q817.85-419.7 817.85-480q0-143.86-96.98-240.86-96.98-96.99-240.83-96.99-143.84 0-240.87 96.99-97.02 97-97.02 240.86 0 60.28 18.53 114.14t62.28 108.23Zm256.85-190.7q-58.57 0-98.4-40.04-39.84-40.05-39.84-98.46t40.02-98.39q40.03-39.98 98.6-39.98 58.57 0 98.4 40.17 39.84 40.16 39.84 98.57 0 58.42-40.02 98.28-40.03 39.85-98.6 39.85Zm-.21 374.31q-84.11 0-158.34-31.93-74.23-31.92-129.28-87.33-55.05-55.4-86.5-129.28-31.46-73.87-31.46-157.91 0-84.04 31.98-157.96t87.32-128.75q55.33-54.84 129.23-86.94 73.89-32.1 157.95-32.1 84.06 0 157.95 32.1 73.9 32.1 128.73 86.94 54.84 54.83 86.94 128.89 32.1 74.05 32.1 158.02 0 83.98-32.1 157.8-32.1 73.82-86.94 129.15-54.83 55.34-129.01 87.32-74.19 31.98-158.57 31.98Z"/></svg>
                
            @endif
            
       

        </div>
        
   <div class="info-us">
            
            <h1 style="color: #fff;">{{ $user->name }}</h1>
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


    </section>

  
            <h2><b>Informações</b></h2>
            <p>{{ $user->telefone ?? '(00) 00000-0000' }}</p>
            <p>{{ $user->email }}</p>
    

<div class="fperposttt">
 <div > <h2><b>Postagens</b></h2></div> 
 <div><button onclick="document.location='postagem' ">Novo post</button> </div>
</div>

<div class="perfil-post">
@if($posts->isEmpty())
  <p>Você ainda não fez nenhuma postagem.</p>
@else
  @foreach($posts as $post)
    <div class="card-post">

      <a href="{{ route('postagem.show', $post->id) }}" class="linkpostprof">
        @if($post->foto)
          <img src="{{ asset('storage/' . $post->foto) }}" alt="Foto da postagem">
        @endif

        <div id="infopostprof">
          <h4 class="tl">{{ $post->nome_pet ?? 'Sem nome' }}</h4>
          <p>{{ $post->tipo_animal }} - {{ $post->tipo_cadastro }}</p>
          <small>Postado em {{ $post->created_at->format('d/m/Y') }}</small>
           <a href="{{ route('postagem.edit', $post->id) }}" style="color:white; ">
          Editar</a>
          <a href="#"
                   onclick="event.preventDefault(); 
                            if(confirm('Tem certeza que deseja excluir este post?')) {
                                document.getElementById('delete-post-{{ $post->id }}').submit();
                            }" 
                   style="color:red; margin-left:2px">Excluir</a>
                   

                <form id="delete-post-{{ $post->id }}" 
                      action="{{ route('postagem.destroy', $post->id) }}" 
                      method="POST" style="display:none;">
                    @csrf
                    @method('DELETE')
                </form>
        </div>
      </a>

      
    


    </div>
  @endforeach
@endif
</div>



 </div>

 <div>
 <h2 ><b>Meu Depoimento</b></h2>
 <div class="dep-list">
    

    @if($depoimentos->isEmpty())
        <p>Você ainda não publicou um depoimento.</p>
    @else
        @foreach($depoimentos as $dep)
            <div class="dep-item">
                <h4>{{ $dep->titulo }}</h4>
                <p>{{ $dep->depoimento }}</p>
                <small>Publicado em {{ $dep->created_at->format('d/m/Y') }}</small>
                <a href="#" 
                   onclick="event.preventDefault(); 
                            if(confirm('Tem certeza que deseja excluir este depoimento?')) {
                                document.getElementById('delete-dep-{{ $dep->id }}').submit();
                            }" 
                   style="color:red;">Excluir</a>

                <form id="delete-dep-{{ $dep->id }}" 
                      action="{{ route('depoimentos.destroy', $dep->id) }}" 
                      method="POST" style="display:none;">
                    @csrf
                    @method('DELETE')
                </form>
                </div>
                <!-- Botão de excluir -->
                
            
        @endforeach
    @endif
</div>


   
</main>

<div class="dep-container">
 
<h2 class="h2-dep">Adicione um depoimento</h2>
 
<form action="{{ route('depoimentos.store') }}" method="POST">
   @csrf
    <label class="label-dep"  for="titulo">Título*</label>
    <input class="input-dep" type="text" name="titulo" required>
 
    <label class="label-dep" for="depoimento">Escreva seu depoimento*</label>
    <textarea id="depoimento" name="depoimento" maxlength="500" required></textarea>
 
   
 
    <button class="button-dep" type="submit">Enviar</button>
 
  </form>
</div>

@include("components.footer")