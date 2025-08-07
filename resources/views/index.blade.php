@include("components.header")

@if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
@endif

<!-- Carrossel topo -->

<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1" id="on"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2" id="off"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3" id="off"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="6000">
            <div class="tcar1">
                <h1>Ajude um pet a encontrar uma nova família</h1>
                <h5>Conheça os animais para adoção na sua região</h5>
            </div>
            <button id="bcar1">Verificar</button>
            <img src="IMG/HOME/CARINI/pexels-alinaskazka-24740464.jpg" class="d-block" alt="...">
            <div class="carousel-caption d-none d-md-block">
            </div>
        </div>
        <div class="carousel-item" data-bs-interval="6000">
            <div class="tcar2">
                <h1>Onde começa um clique... e nasce um amor!</h1>
                <h5>Confira histórias reais de quem teve a vida transformada com a nossa ajuda.</h5>
            </div>
            <button id="bcar2">Depoimentos</button>
            <img src="IMG/HOME/CARINI/pexels-cong-h-613161-1404819.jpg" class="d-block" alt="...">
            <div class="carousel-caption d-none d-md-block">
            </div>
        </div>
        <div class="carousel-item" data-bs-interval="6000">
            <div class="tcar3">
                <h1 style="color: white;">Use seu talento pra salvar patinhas!</h1>
                <h5 style="color: white;">Se você é dev e curte pets, vem ajudar a gente a mudar vidas com uns cliques!</h5>
            </div>
            <img src="IMG/HOME/CARINI/pexels-edd1egalaxy-3628100.jpg" class="d-block" alt="...">
            <div class="carousel-caption d-none d-md-block">
            </div>
        </div>
    </div>
</div>
</div>

<!-- Encaminhar para postagem -->
<div id="posthome">
    <div id="poshomecontent">
        <h3 style="color: white;">Seu companheiro sumiu ou você precisa doá-lo?</h3>
        <button onclick="document.location='postagem' ">Clique aqui</button>
    </div>
</div>

<!-- Carrossel animais - Desaparecidos -->

 <div class="slide-container swiper">
    <div class="tcaranim">
    <h1>Animais Desaparecidos</h1>
    <h4>Reconhece algum desses bichinhos? Ajude-os a voltar para casa!</h4>
    </div>
            <div class="slide-content">
                <div class="card-wrapper swiper-wrapper">
                    <div class="card swiper-slide" id="cardani">
                        <div><img src="IMG/PET/robin.jpg" alt=""></div>
                        <div class="card-content">
                            <h4 class="name">Robin</h4>
                            <p>Contato:(11) 99999-9999</p>
                            <p>Último local visto:</p>
                        </div>
                    </div>
                    <div class="card swiper-slide" id="cardani">
                        <div><img src="IMG/PET/robin.jpg" alt=""></div>
                        <div class="card-content">
                            <h4 class="name">Robin</h4>
                            <p>Contato:(11) 99999-9999</p>
                            <p>Último local visto:</p>
                        </div>
                    </div>
                    <div class="card swiper-slide" id="cardani">
                        <div><img src="IMG/PET/robin.jpg" alt=""></div>
                        <div class="card-content">
                            <h4 class="name">Robin</h4>
                            <p>Contato:(11) 99999-9999</p>
                            <p>Último local visto:</p>
                        </div>
                    </div>
                    <div class="card swiper-slide" id="cardani">
                        <div><img src="IMG/PET/robin.jpg" alt=""></div>
                        <div class="card-content">
                            <h4 class="name">Robin</h4>
                            <p>Contato:(11) 99999-9999</p>
                            <p>Último local visto:</p>
                        </div>
                    </div>
                    <div class="card swiper-slide" id="cardani">
                        <div><img src="IMG/PET/robin.jpg" alt=""></div>
                        <div class="card-content">
                            <h4 class="name">Robin</h4>
                            <p>Contato:(11) 99999-9999</p>
                            <p>Último local visto:</p>
                        </div>
                    </div>
                    <div class="card swiper-slide" id="cardani">
                        <div><img src="IMG/PET/robin.jpg" alt=""></div>
                        <div class="card-content">
                            <h4 class="name">Robin</h4>
                            <p>Contato:(11) 99999-9999</p>
                            <p>Último local visto:</p>
                        </div>
                    </div>
                    <div class="card swiper-slide" id="cardani">
                        <div><img src="IMG/PET/robin.jpg" alt=""></div>
                        <div class="card-content">
                            <h4 class="name">Robin</h4>
                            <p>Contato:(11) 99999-9999</p>
                            <p>Último local visto:</p>
                        </div>
                    </div>
                   
                </div>
            </div>

             <div class="swiper-button-next swiper-navBtn"></div>
            <div class="swiper-button-prev swiper-navBtn"></div>
             <div class="swiper-pagination"></div>
        </div>

<!-- Banner -->
<div id="bannerhdiv">
    <div class="textbanner">
        <h1>Descubra como unimos quem quer adotar, ajudar e encontrar pets perdidos. Clique e saiba como nosso projeto transforma vidas!
        </h1>
    </div>
    <button>Leia Sobre</button>
</div>


<!-- Depoimentos -->
<h1 class="h1depoi">Depoimentos</h1>
<div class="depoi">
    <div class="tdepoi">
        <h2>Adotar é transformar vidas</h2>
        <p>Adotar um animal é um gesto de amor que muda tudo — pra quem é adotado e pra quem adota. É acolher, cuidar e, no fim, descobrir que o coração sempre tem espaço pra mais amor (e mais patinhas também).</p>
    </div>
    <div class="cardepoi">
        <div class="cards-box">
            <div class="card hide">
                <div class="content-placeholder">
                    <div class="row">
                        <div class="img-text"></div>
                        <h3>Lucas</h3>
                        <div class="img" data-letter=""></div>
                    </div>
                    <p>“A um mês adotei um gato na Dotme, isso foi a melhor coisa que já fiz, bolt está a tão pouco tempo comigo e já é parte da minha família”</p>
                </div>
            </div>
            <div class="card">
                <div class="content-placeholder">
                    <div class="row">
                        <h3>Lucas</h3>
                        <div class="img" data-letter="L"></div>
                    </div>
                    <h5>Meu novo amigo</h5>
                    <p>“A um mês adotei um gato na Dotme, isso foi a melhor coisa que já fiz, bolt está a tão pouco tempo comigo e já é parte da minha família”</p>
                </div>
            </div>
            <div class="card">
                <div class="content-placeholder">
                    <div class="row">
                        <h3>Nome</h3>
                        <div class="img" data-letter="M"></div>
                    </div>
                    <h5>Título</h5>
                    <p>"Lorem ipsum dolor sit amet consectetur, adipisicing elit. Praesentium consectetur a voluptas ducimus odit"</p>
                </div>
            </div>
            <div class="card">
                <div class="content-placeholder">
                    <div class="row">
                        <h3>Nome</h3>
                        <div class="img" data-letter="S"></div>
                    </div>
                    <h5>Título</h5>
                    <p>“Lorem ipsum dolor sit amet consectetur, adipisicing elit. Praesentium consectetur a voluptas ducimus odia”</p>
                </div>
            </div>
        </div>
    </div>
</div> 

<!-- Feedback -->
<div class="comentario">
    <div class="form_box">
        <h1 style="text-align: center;">Gostaria de fazer uma sugestão?</h1>
        <h4 style="text-align: center;">Comente abaixo o que poderíamos melhorar no site ou funções que gostaria de usar aqui.</h4>
        <br>
        <form action="" method="post">
            <input type="text" name="name" placeholder="Nome Completo*">
            <input id="telefoneMask" type="tel" name="telefone" placeholder="(00) 00000-0000" pattern="[0-9]{2} [0-9]{5}-[0-9]{4}">
            <input type="email" name="email" placeholder="E-mail*">
            <textarea name="comentario" cols="50" rows="10" placeholder="Comentários*"></textarea>
            <button type="submit">Enviar</button>
        </form>
    </div>
</div>

@include("components.footer")