<?php
$color_type = require 'src/colortypes.php';

//requisição se foi por busca
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['pokemon'])) {
    $pokemonName = null;
    $pokemonDetails = null;
    $pokemonName = strtolower(trim($_POST['pokemon']));
    $url = 'https://pokeapi.co/api/v2/pokemon/' . $pokemonName; // encapsulamento da url
    $response = file_get_contents($url);
    if ($response !== false) {
        $pokemonDetails = json_decode($response, true);
    }
} else {
    $url = 'https://pokeapi.co/api/v2/pokemon?limit=200';
    $response = file_get_contents($url);
    $pokemons = json_decode($response, true);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PokeApi</title>
    <link rel="stylesheet" href="poke.css">
</head>

<body>
    <header>
        <h1>Lista de Pokémons</h1>
        <p>Consumo de API usando PHP</p>
        <p><a href="https://www.linkedin.com/in/liliamteixeira/">Linkedin</a></p>
        <br>
    </header>

    <div class="busca">
        <form action="index.php" method="POST">
            <input type="text" id="pokemon" classname="pokemon" placeholder="Digite o nome do Pokémon">
            <input type="submit" value="Buscar">
        </form>
    </div>

    <section class="container">
        <?php if(isset ($pokemonDetails)){
            ?>
                   <div class="card" style="background-color: <?=$color_type[$pokemonDetails['types'][0]['type']['name']]?>">
                        <div class="card-image">
                            <figure class="image is-128x128">
                                <img src="<?= $pokemonDetails['sprites']['front_default'] ?>" alt="<?= $pokemonDetails['name'] ?>">
                            </figure>
                        </div>
                        <div class="card-text">
                            <h3><?= ucfirst($pokemonDetails['name']) ?></h3>
                            <p>Type: <?= $pokemonDetails['types'][0]['type']['name']?></p>
                            <p>Ability: <?= $pokemonDetails['abilities'][0]['ability']['name']?></p>
                            <a href="details.php" class="button">Detalhes</a>
                        </div>
                    </div>
        <?php
        } elseif
            (isset($pokemons['results']) && is_array($pokemons['results'])) {
        ?>
            <div class="grid3">
                <?php
                foreach ($pokemons['results'] as $pokemon) {
                    $detailsData = json_decode(file_get_contents($pokemon['url']), true);
                ?>
                    <div class="card" style="background-color: <?=$color_type[$detailsData['types'][0]['type']['name']]?>">
                        <div class="card-image">
                            <figure class="image is-128x128">
                                <img src="<?= $detailsData['sprites']['front_default'] ?>" alt="<?= $pokemon['name'] ?>">
                            </figure>
                        </div>
                        <div class="card-text">
                            <h3><?= ucfirst($pokemon['name']) ?></h3>
                            <p> Type: <?= ucfirst($detailsData['types'][0]['type']['name']) ?></p>
                            <a href="details.php" id="modal" class="modal-button">Details</a>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        <?php
        } else {
            echo "<strong>Nenhum Pokémon retornado pela API</strong>";
        }
        ?>
    </section>
</body>

</html>