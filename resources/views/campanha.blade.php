@include("components.header")

<div class="corpo-campanha">

    <div class="titulocamp">
        <h1>Campanhas ativas no momento</h1>
        <p>Aproveite as campanhas para a felicidade do seu PET</p>
    </div>

    <div class="campanha">
        <h3>Campanhas de doação de ração</h3>
        <div class="camps">
            <div class="camp">
                <a href="https://www.cobasicuida.com.br/" target="_blank">
                    <img src="{{ asset('/IMG/CAMPANHAS/cobasi.png') }}" alt="Campanha de ração da Cobasi" id="imag">
                </a>
                <p>
                    Campanha de doação de ração da Cobasi.
                </p>
            </div>
            <div class="camp">
                <a href="https://institutoadimax.org.br/" target="_blank">
                    <img src="{{ asset('/IMG/CAMPANHAS/adimax.png') }}" alt="Campanha de ração da Adimax" id="imag">
                </a>
                <p>
                    Campanha de doação de ração do Instituto Adimax.
                </p>
            </div>
        </div>
    </div>

    <div class="campanha">
        <h3>Campanhas de vacina para PET</h3>
        <div class="camps">
            <div class="camp">
                <a href="https://www.vitoria.es.gov.br/noticia/saude-de-vitoria-inicia-campanha-de-vacinacao-antirrabica-em-20-de-setembro-54379" target="_blank">
                    <img src="{{ asset('/IMG/CAMPANHAS/vacina-vitoria.jpg') }}" alt="Campanha de vacinação" id="imag">
                </a>
                <p>
                    Campanha de vacinação antirrábica em Vitória, Espírito Santo.
                </p>
            </div>

            <div class="camp">
                <a href="https://prefeitura.rio/cidade/campanha-de-vacinacao-antirrabica-comeca-sabado-na-cidade/" target="_blank">
                    <img src="{{ asset('/IMG/CAMPANHAS/vacina-rio.webp') }}" alt="Campanha de vacinação" id="imag">
                </a>
                <p>
                    Campanha de vacinação antirrábica na cidade do Rio de Janeiro.
                </p>
            </div>

            <div class="camp">
                <a href="https://www.anapolis.go.gov.br/prefeitura-de-anapolis-promovera-campanha-de-vacinacao-antirrabica-no-dia-13-de-setembro/" target="_blank">
                    <img src="{{ asset('/IMG/CAMPANHAS/vacina-anapolis.png') }}" alt="Campanha de vacinação" id="imag">
                </a>
                <p>
                    Campanha de vacinação antirrábica em Anápolis, Goiás.
                </p>
            </div>
        </div>
    </div>

    <div class="campanha">
        <h3>Campanhas de castração do PET</h3>
        <div class="camps">
            <div class="camp">
                 <a href="https://itapecerica.sp.gov.br/noticias/autarquia-municipal-de-saude/prefeitura-retoma-castracao-gratuita-de-caes-e-gatos-em-itapecerica-da-serra" target="_blank">
                     <img src="{{ asset('/IMG/CAMPANHAS/castracao-serra.png') }}" alt="Campanha de castração em Itapecerica da Serra" id="imag">
                 </a>
                <p>
                 Campanha de castração em Itapecerica da Serra, São Paulo.
                </p>
            </div>
            <div class="camp">
                <a href="https://www.mongagua.sp.gov.br/noticias/saude/nova-campanha-de-castracao-gratuita-deanimais-acontece-neste-sabado-13-em-mongagua" target="_blank">
                    <img src="{{ asset('/IMG/CAMPANHAS/castracao-mongagua.png') }}" alt="Campanha de castração" id="imag">
                </a>
                <p>
                    Campanha de castração em Mongaguá, São Paulo.
                </p>
            </div>
            <div class="camp">
                <a href="https://educacao.sme.prefeitura.sp.gov.br/noticias/ceu-sapopemba-promove-castracao-gratuita-de-caes-e-gatos/" target="_blank">
                    <img src="{{ asset('/IMG/CAMPANHAS/castracao-sp.jpg') }}"  alt="Campanha de castração" id="imag">
                </a>
                <p>
                    Campanha de castração em São Paulo, São Paulo.
                </p>
            </div>
        </div>
    </div>
</div>

@include("components.footer")