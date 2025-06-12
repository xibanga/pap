<?php
include('../ligabd.php'); // Conexão com a base de dados
session_start();
date_default_timezone_set('Europe/Lisbon');
$agora = date('Y-m-d H:i:s');

if (!isset($_GET['id'])) {
    die("Erro: Nenhuma bicicleta selecionada.");
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM bicicletas WHERE id = $id";
$result = $con->query($sql);

if ($result->num_rows == 0) {
    die("Erro: Bicicleta não encontrada.");
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../imagens/rodapedaleira2.png">
    <link rel="stylesheet" href="detalhes.css">
    <title>Detalhes da Bicicleta</title>
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <a href="aluguer.php"><img src="../imagens/rodapedaleira.jpg" alt="Logo Pedaleira"></a>
    </div>

    <div class="container">
        <div class="image-section">
            <div class="zoom-container">
                <img src="<?php echo $row['imagem']; ?>" alt="<?php echo $row['modelo']; ?>" id="bike-image">
            </div>
        </div>
        <div class="details-section">
            <h1><?php echo $row['modelo']; ?></h1>
            <p>Esta bicicleta de montanha é ideal para trilhos desafiadores, proporcionando estabilidade, controle e
                durabilidade em terrenos acidentados. Equipada com uma suspensão robusta e pneus aderentes, é perfeita
                para aventuras ao ar livre.</p>
            <p><strong><b>Preço:</b></strong> €<?php echo $row['preco']; ?>/hora</p>
            <form action="processar.php" method="POST">
                <input type="hidden" name="bicicleta" value="<?php echo $row['id']; ?>">

                <label for="horas">Horas de Aluguer:</label>
                <input type="number" name="horas" min="1" required>
                <br><br>

                <label for="data_inicio">Data e Hora de Início:</label>
                <input type="datetime-local" name="data_inicio" min="<?php echo date('Y-m-d\TH:i', strtotime('+30 minutes')); ?>" required>
                <br><br>

                <button type="submit">Alugar Agora</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; <?php echo date('Y'); ?> Roda Pedaleira. Todos os direitos reservados.</p>
    </div>

    <script>
        document.getElementById("bike-image").addEventListener("mousemove", function (e) {
            let img = e.target;
            let rect = img.getBoundingClientRect();
            let x = (e.clientX - rect.left) / rect.width * 100;
            let y = (e.clientY - rect.top) / rect.height * 100;
            img.style.transformOrigin = `${x}% ${y}%`;
            img.style.transform = "scale(1.5)";
        });

        document.getElementById("bike-image").addEventListener("mouseleave", function (e) {
            let img = e.target;
            img.style.transform = "scale(1)";
        });
    </script>
</body>

</html>
