<?php
session_start();
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
        <div class="event-card">
            <h3>Eiras Single Track</h3>
            <p><b>Data:</b> 15 de Maio de 2025</p>
            <p><b>Local:</b> Eiras, Coimbra, Portugal</p>
        </div>

        <div class="event-card">
            <h3>Travessia de Sicó</h3>
            <p><b>Data:</b> 19 a 22 de agosto</p>
            <p><b>Local:</b> Eiras, Coimbra, Portugal</p>
        </div>

        <div class="event-card">
            <h3>Jantar de Natal</h3>
            <p><b>Data:</b> 1 de Dezembro</p>
            <p><b>Local:</b> Quinta do Outeiro, Tentúgal</p>
        </div>

        <div class="event-card">
            <h3>Natal Solidário</h3>
            <p><b>Data:</b> 21 de Dezembro de 2025</p>
            <p><b>Local:</b> Coimbra, Portugal</p>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Roda Pedaleira. Todos os direitos reservados.</p>
        <p><a href="../paginas/pagina1.php">Voltar à Página Inicial</a></p>
    </footer>

</body>

</html>
