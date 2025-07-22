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
        $color_type = [
            "normal" => "#A0A2A0",
            "poison" => "#923FCC",
            "psychic" => "#EF3F7A",
            "grass" => "#3DA224",
            "ground" => "brown",
            "ice" => "#3DD9FF",
            "fire" => "#E72324",
            "rock" => "#B0AB82",
            "dragon" => "#4F60E2",
            "water" => "#2481F0",
            "bug" => "#92A212",
            "dark" => "black",
            "fighting" => "#FF8100",
            "ghost" => "#713F71",
            "steel" => "#60A2B9",
            "flying" => "	#82BAF0",
            "electric" => "#FAC100",
            "fairy" => "#EF71F0"
        ];
        $url = 'https://pokeapi.co/api/v2/pokemon?limit=20';
        $response = file_get_contents($url);
        $pokemons = json_decode($response, true); // decode como array associativo

        if (isset($pokemons['results']) && is_array($pokemons['results'])) {
        ?>
            <div class="grid3"> 
                <?php
                foreach ($pokemons['results'] as $pokemon) {
                    preg_match('/pokemon\/(\d+)\//', $pokemon['url'], $matches);
                    $id = $matches[1] ?? null;
                    $imageUrl = $id
                        ? "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/{$id}.png"
                        : "https://via.placeholder.com/128";
                ?>
                    <div class="card">
                        <div class="card-image has-text-centered">
                            <figure class="image is-128x128">
                                <img src="<?= $imageUrl ?>" alt="<?= $pokemon['name'] ?>">
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