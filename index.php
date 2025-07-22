<?php
    require_once 'Filter.php';
    $url = 'https://pokeapi.co/api/v2/' . Filter::POKEMON . '?limit=30';
    $response = file_get_contents($url);
    $pokemons = json_decode($response, true);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="poke.css">
    <title>PokeApi</title>
</head>
<body>
    <header>
        <h1>Lista de Pokémons</h1>
        <p>Consumo de API usando PHP</p>
        <br><a href="https://www.linkedin.com/in/liliamteixeira/">Linkedin</a>
    </header>
    <section class="container">
        <?php
        if (isset($pokemons['results']) && is_array($pokemons['results'])) {
        ?>
            <div class="grid3"> 
                <?php
                 foreach ($pokemons['results'] as $pokemon) {
                    $detailsData = json_decode(file_get_contents($pokemon['url']), true);
                ?>
                    <div class="card">
                        <div class="card-image has-text-centered">
                            <figure class="image is-128x128">
                                <img src="<?=  $detailsData['sprites']['front_default'] ?>" alt="<?= $pokemon['name'] ?>">
                            </figure>
                        </div>
                        <div class="card-content has-text-centered">
                            <h3><?= ucfirst($pokemon['name']) ?></h3>
                            <p>Mais informações: <a href="<?= $pokemon['url'] ?>">Ver na API</a></p>
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