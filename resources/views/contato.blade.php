@include("components.header")

  <main class="secao-contato-principal">
        <section class="formulario-contato-fundo">
            <div class="container-form">
                <h1>Contate-nos</h1>

                <form action="#" method="POST" class="formulario-contato">
                    <div class="campo-grupo">
                        <label for="nome" class="label-flutuante"></label>
                        <input type="text" id="nome" name="nome" placeholder="Nome Completo*" required>
                        </div>

                    <div class="campo-grupo">
                        <label for="email" class="label-flutuante"></label>
                        <input type="email" id="email" name="email" placeholder="Email*" required>
                    </div>

                    <div class="campo-grupo">
                        <label for="mensagem" class="label-flutuante"></label>
                        <textarea id="mensagem" name="mensagem" rows="5" placeholder="Escreva sua mensagem" required></textarea>
                    </div>

                    <button type="submit" class="botao-enviar">Enviar</button>
                </form>
            </div>
        </section>

        <section class="redes-sociais-fundo">
            <div class="container-redes">
                <h2>Siga-nos nas redes</h2>
                <div class="icones-redes">
                    <a href="https://www.instagram.com/" class="icone-rede" aria-label="Instagram">
                <img src="IMG/ICONES/instagram-icone.png">
                    </a>
                    <a href="https://www.facebook.com/?locale=pt_BR" class="icone-rede" aria-label="Facebook">
                <img src="IMG/ICONES/facebook-icone.png">
                </a>
                    </div>
            </div>
        </section>
    </main>


@include("components.footer")