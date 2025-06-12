<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../imagens/rodapedaleira2.png">
    <title>Aluguer Confirmado</title>
    <link rel="stylesheet" href="confirmar.css">
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <a href="../paginas/pagina1.php"><img src="../imagens/rodapedaleira.jpg" alt="Logo Pedaleira"></a>
    </div>

    <!-- Primeiro Container -->
    <div class="container">
        <h1>Aluguer Confirmado!</h1>
        <p>A sua bicicleta foi alugada com sucesso.</p>
        <p class="devolucao"><strong>Hora de devolução:</strong> <?php echo isset($_GET['hora_devolucao']) ? htmlspecialchars($_GET['hora_devolucao']) : 'Hora não especificada'; ?></p>
    </div>

    <!-- Segundo Container com a Imagem da Bicicleta -->
    <div class="container">
    <?php
    if (!isset($_GET['imagem']) || empty($_GET['imagem'])) {
        echo "<p style='color: red; text-align: center;'>Erro: Nenhuma imagem foi fornecida.</p>";
    } else {
        $imagem = htmlspecialchars($_GET['imagem']);
        echo "<img src='$imagem' alt='Bicicleta Alugada' style='max-width: 100%; border-radius: 8px;'>";
    }
    ?>
    <br>
        <p>Obrigado por usar o nosso serviço!</p>
        <br>
        <br>
        <a href="aluguer.php" class="voltar">Voltar para a Página de Aluguer</a>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; <?php echo date('Y'); ?> Roda Pedaleira. Todos os direitos reservados.</p>
    </div>

</body>
</html>
