<div class="footer">
  <img src="IMG/LOGOS/DotPetLogT.png" alt="" class="logofoot">
  <div class="linkfoot">
    <a href="">Sobre Nós</a>
    <a href="">Contato</a>
    <a href="">Apoie o Projeto</a>
    <a href="">FAQ</a>
    <a href="">Redes Sociais</a>
    <div style="text-align: center; margin-top:5%"><?php echo "© " . date("Y") . " DotMe | Todos os direitos reservados " ?></div>
  </div>

</div>

<script src="//cdn.jsdelivr.net/gh/freeps2/a7rarpress@main/swiper-bundle.min.js"></script>

<script src="//cdn.jsdelivr.net/gh/freeps2/a7rarpress@main/script.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>
  document.querySelectorAll('.show-psswd').forEach(button => {
    const targetSelector = button.getAttribute('data-toggle-target')
    const input = document.querySelector(targetSelector)
    const icon = button.querySelector('img')

    button.addEventListener('click', () => {
      if (input) {
        input.type = input.type === 'password' ? 'text' : 'password'

        icon.src = icon.src.includes('eye_open')
          ? './IMG/ICONSENHA/eye_closed.svg'
          : './IMG/ICONSENHA/eye_open.svg'
      }
    })
  })
</script>


<script>$(document).ready(function () {
 
    $("#telefoneMask").mask('(00) 00000-0000');
    $("#cpfMask").mask('000.000.000-00');
});

</script>

<script>
  var swiper = new Swiper(".slide-content", {
    slidesPerView: 3,
    spaceBetween: 25,
    loop: true,
    centerSlide: 'true',
    fade: 'true',
    grabCursor: 'true',
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
      dynamicBullets: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },

    breakpoints: {
      0: {
        slidesPerView: 1,
      },
      520: {
        slidesPerView: 2,
      },
      950: {
        slidesPerView: 3,
      },
    },
  });
</script>

<script>
  window.onload = () => {
    let sliderImagesBox = document.querySelectorAll('.cards-box');
    sliderImagesBox.forEach(el => {
      let imageNodes = el.querySelectorAll('.card:not(.hide)')
      let arrIndexes = []; // Index array
      (() => {
        // The loop that added values to the arrIndexes array for the first time
        let start = 0;
        while (imageNodes.length > start) {
          arrIndexes.push(start++);
        }
      })();

      let setIndex = (arr) => {
        for (let i = 0; i < imageNodes.length; i++) {
          imageNodes[i].dataset.slide = arr[i] // Set indexes
        }
      }
      el.addEventListener('click', () => {
        arrIndexes.unshift(arrIndexes.pop());
        setIndex(arrIndexes)
      })
      setIndex(arrIndexes) // The first indexes addition
    });
  };
</script>

<script>
    // Função para mostrar/ocultar campo "Outro tipo de animal"
    function verificarOutroTipo() {
      const select = document.getElementById("tipo-animal");
      const campoOutro = document.getElementById("campo-outro-animal");

      if (select.value === "outro") {
        campoOutro.style.display = "block";
      } else {
        campoOutro.style.display = "none";
      }
    }

    // Função para mostrar/ocultar campo "Nome do pet"
    function mostrarCampoNome() {
      const select = document.getElementById("tem-nome");
      const campoNome = document.getElementById("campo-nome");

      if (select.value === "sim") {
        campoNome.style.display = "block";
      } else {
        campoNome.style.display = "none";
      }
    }

    // Função para mostrar/ocultar campo "Última localização" baseado no tipo de cadastro
    function gerenciarCamposPerdido() {
      const tipoCadastroSelect = document.getElementById("tipo-cadastro");
      const campoUltimaLocalizacao = document.getElementById("campo-ultima-localizacao");

      if (tipoCadastroSelect.value === "perdido") {
        campoUltimaLocalizacao.style.display = "block";
      } else {
        campoUltimaLocalizacao.style.display = "none";
      }
    }

    // --- Funcionalidade de Pré-visualização de Imagens ---
    document.addEventListener('DOMContentLoaded', () => {
      const inputArquivo = document.getElementById('inputArquivo');
      const previewContainer = document.getElementById('preview-imagens');

      if (inputArquivo && previewContainer) {
        inputArquivo.addEventListener('change', (event) => {
          previewContainer.innerHTML = ''; // Limpa as pré-visualizações anteriores
          const files = event.target.files;
          const maxImages = 5; // Limite de 5 imagens

          if (files.length > maxImages) {
            alert(`Você pode enviar no máximo ${maxImages} imagens.`);
            inputArquivo.value = ''; // Limpa a seleção de arquivos para forçar o limite
            return;
          }

          for (const file of files) {
            if (file.type.startsWith('image/')) { // Verifica se é um arquivo de imagem
              const reader = new FileReader();

              reader.onload = (e) => {
                const imgWrapper = document.createElement('div');
                imgWrapper.classList.add('preview-imagem-item'); // Classe para estilização

                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Pré-visualização da imagem';

                imgWrapper.appendChild(img);
                previewContainer.appendChild(imgWrapper);
              };

              reader.readAsDataURL(file); // Lê o arquivo como URL de dados (base64)
            }
          }
        });
      }
    });
  </script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

</body>

</html>