<?php
session_start();
include('../ligabd.php'); // Conexão com a base de dados

if (!isset($_SESSION['id_utilizador'])) {
    header("Location: ../login.php");
    exit();
}

$id_utilizador = $_SESSION['id_utilizador'];

// Adicionar ou remover favoritos
if (isset($_GET['favorito'])) {
    $id_bicicleta = intval($_GET['favorito']);
    
    // Verificar se a bicicleta já está nos favoritos
    $sql_check = "SELECT * FROM favoritos_aluguer WHERE id_utilizador = $id_utilizador AND id_bicicleta = $id_bicicleta";
    $result_check = $con->query($sql_check);

    if ($result_check->num_rows > 0) {
        // Remover dos favoritos
        $sql_remove = "DELETE FROM favoritos_aluguer WHERE id_utilizador = $id_utilizador AND id_bicicleta = $id_bicicleta";
        $con->query($sql_remove);
    } else {
        // Adicionar aos favoritos
        $sql_add = "INSERT INTO favoritos_aluguer (id_utilizador, id_bicicleta) VALUES ($id_utilizador, $id_bicicleta)";
        $con->query($sql_add);
    }
    header("Location: aluguer.php");
    exit();
}

// Obter favoritos do utilizador
$sql = "SELECT bicicletas.* FROM favoritos_aluguer 
        JOIN bicicletas ON favoritos_aluguer.id_bicicleta = bicicletas.id 
        WHERE favoritos_aluguer.id_utilizador = $id_utilizador";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../imagens/rodapedaleira2.png">
    <title>Favoritos - Aluguer</title>
    <link rel="stylesheet" href="aluguer.css">
</head>
<body>
    <header>
        <div class="direita">
            <div class="logo">
                <a href="../paginas/pagina1.php"><img src="../imagens/rodapedaleira.jpg" alt="Logo"></a>
            </div>
        </div>
        <h1>Bicicletas Favoritas</h1>
    </header>
    <div class="container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="bike-card" onclick="window.location.href='detalhes.php?id=<?php echo $row['id']; ?>'">
                <img src="<?php echo $row['imagem']; ?>" alt="<?php echo $row['modelo']; ?>">
                <h2><?php echo $row['modelo']; ?></h2>
                <p><?php echo $row['descricao']; ?></p>
                <p><strong>Preço:</strong> €<?php echo $row['preco']; ?>/hora</p>
                <a href="favoritos_aluguer.php?favorito=<?php echo $row['id']; ?>" class="favorito">❤️</a>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
