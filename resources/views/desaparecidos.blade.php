@include("components.header")

<header class="filtros">
  <h1>Pets Perdidos</h1>
  <p>Ajude a resgatar a felicidade de um dono!</p>

  <div class="fill">
    <h4 class="fil">Filtre por localização:</h4>
    <form class="filter-form" method="GET" action="">

  <select name="especie">
      <option value="">Espécie</option>
      <option value="cachorro" <?= ($_GET['especie'] ?? '') === 'cachorro' ? 'selected' : '' ?>>Cachorro</option>
      <option value="gato" <?= ($_GET['especie'] ?? '') === 'gato' ? 'selected' : '' ?>>Gato</option>
    </select>

  <select name="sexo">
      <option value="">Sexo</option>
      <option value="macho" <?= ($_GET['sexo'] ?? '') === 'macho' ? 'selected' : '' ?>>Macho</option>
      <option value="femea" <?= ($_GET['sexo'] ?? '') === 'femea' ? 'selected' : '' ?>>Fêmea</option>
  </select>

  <select name="idade">
      <option value="">Idade</option>
      <option value="filhote" <?= ($_GET['idade'] ?? '') === 'filhote' ? 'selected' : '' ?>>Filhote</option>
      <option value="adulto" <?= ($_GET['idade'] ?? '') === 'adulto' ? 'selected' : '' ?>>Adulto</option>
      <option value="idoso" <?= ($_GET['idade'] ?? '') === 'idoso' ? 'selected' : '' ?>>Idoso</option>
    </select>

  <select name="porte">
      <option value="">Porte do animal</option>
      <option value="pequeno" <?= ($_GET['porte'] ?? '') === 'pequeno' ? 'selected' : '' ?>>Pequeno</option>
      <option value="medio" <?= ($_GET['porte'] ?? '') === 'medio' ? 'selected' : '' ?>>Médio</option>
      <option value="grande" <?= ($_GET['porte'] ?? '') === 'grande' ? 'selected' : '' ?>>Grande</option>
  </select>

  <input type="text" id="cep" name="cep" placeholder="Digite o CEP" maxlength="9"
         value="<?= $_GET['cep'] ?? '' ?>" onblur="buscarCEP()"   >

  <input type="text" id="cidade" name="cidade" placeholder="Cidade"
         value="<?= $_GET['cidade'] ?? '' ?>" readonly>

  <input type="text" id="estado" name="estado" placeholder="Estado"
         value="<?= $_GET['estado'] ?? '' ?>" readonly>

  <button type="submit">Filtrar</button>
</form>
  </div>
</header>

<main class="filtro">
  <h2>Desaparecidos:</h2>
  <div class="fundos">
    <?php
    // Filtros
    $filtroEspecie = $_GET['especie'] ?? '';
    $filtroSexo = $_GET['sexo'] ?? '';
    $filtroIdade = $_GET['idade'] ?? '';
    $filtroPorte = $_GET['porte'] ?? '';
    $filtroEstado = $_GET['estado'] ?? '';
    $filtroCidade = $_GET['cidade'] ?? '';
    $filtroCep = $_GET['cep'] ?? '';

    // Dados simulados
    $petsPerdidos = [
      ["nome" => "Bob", "img" => "./IMG/PET/bob.jpg", "contato" => "(11) 91234-5678", "cep" => "04750-000", "cidade" => "São Paulo", "estado" => "SP", "idade" => "1 ano", "idade_categoria" => "adulto", "sexo" => "macho", "especie" => "gato", "porte" => "pequeno"],
      ["nome" => "Leaf", "img" => "./IMG/PET/leaf.jpg", "contato" => "(11) 92345-6789", "cep" => "06694-000", "cidade" => "Itapevi", "estado" => "SP", "idade" => "1 ano", "idade_categoria" => "adulto", "sexo" => "macho", "especie" => "cachorro", "porte" => "medio"],
      ["nome" => "Lobinho", "img" => "./IMG/PET/lobinho.jpg", "contato" => "(21) 93456-7890", "cep" => "30130-010", "cidade" => "Belo Horizonte", "estado" => "MG", "idade" => "10 meses", "idade_categoria" => "filhote", "sexo" => "macho", "especie" => "cachorro", "porte" => "medio"],
      ["nome" => "Maggie", "img" => "./IMG/PET/maggie.jpg", "contato" => "(11) 94567-8901", "cep" => "06029-900", "cidade" => "Osasco", "estado" => "SP", "idade" => "2 anos", "idade_categoria" => "adulto", "sexo" => "femea", "especie" => "gato", "porte" => "pequeno"],
      ["nome" => "Math", "img" => "./IMG/PET/math.jpg", "contato" => "(11) 95678-9012", "cep" => "06694-000", "cidade" => "Itapevi", "estado" => "SP", "idade" => "2 ano", "idade_categoria" => "adulto", "sexo" => "macho", "especie" => "cachorro", "porte" => "medio"],
      ["nome" => "Raio", "img" => "./IMG/PET/raio.jpg", "contato" => "(11) 96789-0123", "cep" => "06029-900", "cidade" => "Osasco", "estado" => "SP", "idade" => "8 meses", "idade_categoria" => "filhote", "sexo" => "macho", "especie" => "gato", "porte" => "pequeno"],
      ["nome" => "Robin", "img" => "./IMG/PET/robin.jpg", "contato" => "(11) 96789-0123", "cep" => "06029-900", "cidade" => "Osasco", "estado" => "SP", "idade" => "2 meses", "idade_categoria" => "filhote", "sexo" => "macho", "especie" => "gato", "porte" => "pequeno"],
      ["nome" => "Ted", "img" => "./IMG/PET/ted.jpg", "contato" => "(11) 96789-0123", "cep" => "06029-900", "cidade" => "Osasco", "estado" => "SP", "idade" => "7 meses", "idade_categoria" => "filhote", "sexo" => "macho", "especie" => "cachorro", "porte" => "pequeno"],
      ["nome" => "Thor", "img" => "./IMG/PET/thor.jpg", "contato" => "(11) 96789-0123", "cep" => "06694-000", "cidade" => "Itapevi", "estado" => "SP", "Thor", "idade" => "4 anos", "idade_categoria" => "adulto", "sexo" => "macho", "especie" => "cachorro", "porte" => "medio"],
      ["nome" => "Tom", "img" => "./IMG/PET/tom.jpg", "contato" => "(11) 96789-0123", "cep" => "06694-000", "cidade" => "Itapevi", "estado" => "SP", "tom", "idade" => "3 anos", "idade_categoria" => "adulto", "sexo" => "macho", "especie" => "gato", "porte" => "medio"],
    ];

    // Aplicar filtro
    $filtrados = array_filter($petsPerdidos, function($pet) use ($filtroEspecie, $filtroSexo, $filtroIdade, $filtroPorte, $filtroEstado, $filtroCidade, $filtroCep) {
      return
        ($filtroEspecie === '' || $pet['especie'] === $filtroEspecie) &&
        ($filtroSexo === '' || $pet['sexo'] === $filtroSexo) &&
        ($filtroIdade === '' || $pet['idade_categoria'] === $filtroIdade) &&
        ($filtroPorte === '' || $pet['porte'] === $filtroPorte) &&
        ($filtroEstado === '' || $pet['estado'] === $filtroEstado) &&
        ($filtroCidade === '' || $pet['cidade'] === $filtroCidade) &&
        ($filtroCep === '' || $pet['cep'] === $filtroCep);
    });

    // Mostrar pets
    if (empty($filtrados)) {
      echo "<p>Nenhum pet desaparecido encontrado com esses filtros.</p>";
    } else {
      $totalMostrados = 0;
      foreach ($filtrados as $pet) {
        $hidden = $totalMostrados < 6 ? '' : 'hidden';
        echo '<div class="foto ' . $hidden . '">';
        echo '<img src="'.$pet['img'].'" alt="'.$pet['nome'].'" />';
        echo '<h3 class="tl">'.$pet['nome'].'</h3>';
        echo '<p class="tl">'.$pet['cidade'].' - '.$pet['estado'].'</p>';
        echo '<p class="tl">Contato: '.$pet['contato'].'</p>';
        echo '</div>';
        $totalMostrados++;
      }
    }
    ?>
  </div>

  <button class="load-more" onclick="mostrarMais()">Ver mais...</button>
</main>

<div class="botao-doacao">
  <p>Seu PET sumiu?<br>Precisa de ajuda?</p>
  <button onclick="document.location='postagem' ">Clique aqui</button>
</div>

@include("components.footer")