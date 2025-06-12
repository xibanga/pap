<?php
require '../ligabd.php';

// Verificar se foi passado um ID válido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Erro: Nenhum trilho foi selecionado.");
}

$id = intval($_GET['id']);
$result = $con->query("SELECT * FROM trilhos WHERE id = $id");

if ($result->num_rows == 0) {
    die("Erro: Trilho não encontrado.");
}

$trilho = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($trilho['nome'], ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
    <script defer src="mapa.js"></script>
</head>
<body>

    <div class="container">
        <h1><?php echo htmlspecialchars($trilho['nome'], ENT_QUOTES, 'UTF-8'); ?></h1>
        <p><strong>Distância:</strong> <?php echo htmlspecialchars($trilho['distancia'], ENT_QUOTES, 'UTF-8'); ?> km</p>
        <p><strong>Dificuldade:</strong> <?php echo htmlspecialchars($trilho['dificuldade'], ENT_QUOTES, 'UTF-8'); ?></p>

        <button class="direcoes-botao" onclick="obterDirecoes(<?php echo $trilho['id']; ?>)">📍 Como chegar ao trilho</button>

        <div id="map" data-coords='<?php echo htmlspecialchars($trilho['coordenadas'], ENT_QUOTES, 'UTF-8'); ?>'></div>
    </div>

    <script>
        var trilhoCoords = <?php echo $trilho['coordenadas']; ?>;
    </script>

</body>
</html>
