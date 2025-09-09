@include("components.header")



    <h1 class="trsenha" style="text-align: center;">Redefinição de senha</h1>
    <p class="prsenha" style="margin-bottom: 50px;">Digite a nova senha no campo abaixo para a alteração</p>

    <div class="col-12" style="text-align: center;">
        <form method="POST" action="{{ route('alterar-senha') }}">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="dvnsenha">
                <input type="password" id="nova-senha" name="nova_senha" placeholder="Nova senha" required>               
                <button class="show-psswd" type="button" data-toggle-target="#nova-senha" id="nsenhatoggle">
    <img src="{{ asset('./IMG/ICONSENHA/eye_open.svg') }}" alt="">
  </button>
            </div>

            <div class="dvnsenhaconf" >
                <input type="password" id="confirmar-nsenha" name="nova_senha_confirmation" placeholder="Confirmar a senha" required>               
                <button class="show-psswd" type="button" data-toggle-target="#confirmar-nsenha" id="nsenhaconftoggle">
    <img src="{{ asset('./IMG/ICONSENHA/eye_open.svg') }}" alt="">
  </button>   
  
               
            </div>
                @if ($errors->any())
                <ul style="color:red; margin-top: 15px;">
                    @foreach ($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            @endif
            <small>A senha deve ter no mínimo 8 caracteres, incluindo: <b style="color:#31403E;">1 letra maiúscula, 1 letra minúscula e 1 número.</b>
            </div>

        
            <center><div>
         
                    <button onclick="document.location=' {{ route('log') }}'" 
                    class="but-casenha" type="button"><b>Cancelar</b></button>
          
                    <button class="but-rcsenha" type="submit"><b>Confirmar</b></button>
                    </div></center>
          
        </form>
    </div>



@include("components.footer")