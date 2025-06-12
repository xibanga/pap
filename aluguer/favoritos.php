<?php
session_start();
require "../ligabd.php"; // Certifica-te que a conexão está correta

// Verifica se o utilizador está autenticado
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['id'];

// Adicionar aos favoritos
if (isset($_GET['add'])) {
    $bike_id = intval($_GET['add']);
    $sql = "INSERT INTO favoritos_aluguer (user_id, bicicleta_id) VALUES ('$user_id', '$bike_id')";
    $con->query($sql);
    header("Location: favoritos.php");
    exit();
}

// Remover dos favoritos
if (isset($_GET['remove'])) {
    $bike_id = intval($_GET['remove']);
    $sql = "DELETE FROM favoritos_aluguer WHERE user_id = '$user_id' AND bicicleta_id = '$bike_id'";
    $con->query($sql);
    header("Location: favoritos.php");
    exit();
}

// Buscar favoritos do utilizador
$sql = "SELECT b.* FROM bicicletas b
        INNER JOIN favoritos_aluguer f ON b.id = f.bicicleta_id
        WHERE f.user_id = '$user_id'";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../imagens/rodapedaleira2.png">
    <title>Favoritos - Aluguer de Bicicletas</title>
    <link rel="stylesheet" href="favoritos.css">
</head>
<body>
    <header>
        
        <h1>As Tuas Bicicletas Favoritas</h1>
        <a href="aluguer.php">Voltar</a>
    </header>
    <div class="container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="bike-card">
                <img src="<?php echo $row['imagem']; ?>" alt="<?php echo $row['modelo']; ?>">
                <h2><?php echo $row['modelo']; ?></h2>
                <p><strong>Preço:</strong> €<?php echo $row['preco']; ?>/hora</p>
                <a href="favoritos.php?remove=<?php echo $row['id']; ?>">❌ Remover</a>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
