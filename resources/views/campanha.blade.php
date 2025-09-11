@include("components.header")

<div class="corpo-campanha">
        
        <div class="titulocamp">
            <h1>Campanhas ativas no momento</h1>
            <p>Aproveite as campanhas para a felicidade do seu PET</p>
        </div>

        <!-- Nossas campanhas -->
        <div class="nossas-campanhas">
            <h3>Nossas campanhas</h3>
            <div class="camps">
                <div class="camp"></div>
                <div class="camp"></div>
                <div class="camp"></div>
            </div>
        </div>

        <!-- Campanhas específicas -->
         <h3>Campanha de doação de ração</h3>
        <div class="campanha">
          <a href="https://institutoadimax.org.br/racao-solidaria/"> <img  class="camp" src="{{ asset('IMG/CAMPANHAS/imagem.png') }}" alt="Blog Setembro Vermelho" > </a>
                <a href="https://www.petz.com.br/blog/doar-racao/"> <img class="camp" src="{{ asset('IMG/CAMPANHAS/blogpetz.png.png') }}" alt="" class="" > </a>
                <a href="https://sinpatinhas.mma.gov.br/home-primeiro-acesso"> <img class="camp" src="{{ asset('IMG/CAMPANHAS/sinpatinhas.png') }}" alt="" class="" > </a>
        </div>

        <h3>Campanha de vacina para PET</h3>
        <div class="campanha"> 
            <a href="https://www.nuxcell.com.br/conscientizacao-e-prevencao-de-doencas-cardiacas-em-animais/"> <img  class="camp" src="{{ asset('IMG/CAMPANHAS/blog-setembro-vermelho.jpg') }}" alt="Blog Setembro Vermelho" > </a>
                <a href="https://www.gov.br/mma/pt-br/composicao/sbio/dpda/programas-e-Projetos/propatinhas"> <img class="camp" src="{{ asset('IMG/CAMPANHAS/propatinhas.png') }}" alt="" class="" > </a>
                <a href="https://sinpatinhas.mma.gov.br/home-primeiro-acesso"> <img class="camp" src="{{ asset('IMG/CAMPANHAS/sinpatinhas.png') }}" alt="" class="" > </a>
        </div>

         <h3>Campanhas gerais sobre PET</h3>
        <div class="campanha">
                <a href="https://www.nuxcell.com.br/conscientizacao-e-prevencao-de-doencas-cardiacas-em-animais/"> <img  class="camp" src="{{ asset('IMG/CAMPANHAS/blog-setembro-vermelho.jpg') }}" alt="Blog Setembro Vermelho" > </a>
                <a href="https://www.gov.br/mma/pt-br/composicao/sbio/dpda/programas-e-Projetos/propatinhas"> <img class="camp" src="{{ asset('IMG/CAMPANHAS/propatinhas.png') }}" alt="" class="" > </a>
                <a href="https://sinpatinhas.mma.gov.br/home-primeiro-acesso"> <img class="camp" src="{{ asset('IMG/CAMPANHAS/sinpatinhas.png') }}" alt="" class="" > </a>
                
                
        </div>
        </div>
    </div>

@include("components.footer")