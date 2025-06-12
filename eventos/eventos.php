<?php
session_start();
include '../ligabd.php'; // Certifique-se de que este arquivo conecta corretamente ao banco de dados

// Buscar os 5 eventos mais próximos, ordenados por data
$query = "SELECT * FROM eventos WHERE data_evento >= CURDATE() ORDER BY data_evento ASC LIMIT 5";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos</title>
    <link rel="stylesheet" href="eventos.css">
    <link rel="icon" type="image/x-icon" href="../imagens/rodapedaleira2.png">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar">
        <a href="../paginas/pagina1.php"><img src="../imagens/rodapedaleira2.png" alt="Roda Pedaleira Logo" class="logo"></a>

        <ul class="menu">
            <li class="dropdown">
                <a href="#">Eventos▼</a>
                <ul class="dropdown-content">
                    <li><a href="desportivos/desportivos.php">Desportivos</a></li>
                    <li><a href="solidarios/solidarios.php">Solidários</a></li>
                </ul>
            </li>
            <li><a href="../paginas/ajuda.php">Contato</a></li>

            <!-- Botão "Adicionar Evento" visível apenas para administradores -->
            <?php if (isset($_SESSION['id_tipos_utilizador']) && $_SESSION['id_tipos_utilizador'] == 0): ?>
                <li><a href="gestao_eventos.php" class="admin-button">Gerir Eventos</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- Seção de Eventos -->
    <section class="events">
        <h2>Próximos Eventos</h2>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($evento = mysqli_fetch_assoc($result)): ?>
                <div class="event-card">
                    <h3><?php echo htmlspecialchars($evento['nome_evento']); ?></h3>
                    <p><b>Data:</b> <?php echo date("d/m/Y", strtotime($evento['data_evento'])); ?></p>
                    <p><b>Hora:</b> <?php echo date("H:i", strtotime($evento['hora'])); ?></p>
                    <p><b>Local:</b> <?php echo htmlspecialchars($evento['localizacao']); ?></p>
                    <p><?php echo nl2br(htmlspecialchars($evento['descricao'])); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Não há eventos programados no momento.</p>
        <?php endif; ?>

    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Roda Pedaleira. Todos os direitos reservados.</p>
        <p><a href="../paginas/pagina1.php">Voltar à Página Inicial</a></p>
    </footer>

</body>
</html>
