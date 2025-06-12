<?php
include('../ligabd.php'); // Conexão com a base de dados
session_start();
date_default_timezone_set('Europe/Lisbon');
$agora = date('Y-m-d H:i:s');

$is_admin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

// Definir quantas bicicletas por página
$limit = 9;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Obter total de bicicletas
$sql_count = "SELECT COUNT(*) AS total FROM bicicletas WHERE disponibilidade = 1 AND tipo = 'aluguer'";
$result_count = $con->query($sql_count);
$total_rows = $result_count->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

// Obter bicicletas para a página atual
$sql = "SELECT * FROM bicicletas WHERE disponibilidade = 1 AND tipo = 'aluguer' LIMIT $limit OFFSET $offset";
$result = $con->query($sql);

// Filtros
$search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';
$min_price = isset($_GET['min_price']) ? floatval($_GET['min_price']) : 0;
$max_price = isset($_GET['max_price']) ? floatval($_GET['max_price']) : 10000;
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'modelo';

// Obter total de bicicletas com filtros aplicados
$sql_count = "SELECT COUNT(*) AS total FROM bicicletas WHERE disponibilidade = 1 AND tipo = 'aluguer' 
              AND preco BETWEEN $min_price AND $max_price";

if (!empty($search)) {
    $sql_count .= " AND modelo LIKE '%$search%'";
}
$result_count = $con->query($sql_count);
$total_rows = $result_count->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

// Obter bicicletas com filtros aplicados
$sql = "SELECT * FROM bicicletas WHERE disponibilidade = 1 AND tipo = 'aluguer' 
        AND preco BETWEEN $min_price AND $max_price";

if (!empty($search)) {
    $sql .= " AND modelo LIKE '%$search%'";
}

$sql .= " ORDER BY $order_by LIMIT $limit OFFSET $offset";
$result = $con->query($sql);
?>


<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../imagens/rodapedaleira2.png">
    <title>Aluguer de Bicicletas</title>
    <link rel="stylesheet" href="aluguer.css">
    <style>
        .disabled {
            pointer-events: none;
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    <header>
        <div class="direita">
            <div class="logo">
                <a href="../paginas/pagina1.php"><img src="../imagens/rodapedaleira2.png" alt="Logo"></a>
            </div>
        </div>
        <h2>Escolha a sua Bicicleta para Aluguer</h2>
        <!-- Botão "Adicionar Evento" visível apenas para administradores -->
        <?php if (isset($_SESSION['id_tipos_utilizador']) && $_SESSION['id_tipos_utilizador'] == 0): ?>
            <a href="gerir.php" class="admin-button">Gerir Alugueres</a>
        <?php endif; ?>
    </header>

    <div class="main-container">
        <!-- Sidebar de Filtros -->
        <aside class="sidebar">
            <h3 style="color: black">Filtros</h3>
            <form method="GET">
                <input type="text" name="search" placeholder="🔍 Buscar bicicleta..."
                    value="<?php echo htmlspecialchars($search); ?>">
                <label style="color: black">💰 Faixa de preço:</label>
                <input type="number" name="min_price" placeholder="Preço Mínimo" value="<?php echo $min_price; ?>">
                <input type="number" name="max_price" placeholder="Preço Máximo" value="<?php echo $max_price; ?>">
                <label style="color: black">📊 Ordenar por:</label>
                <select name="order_by">
                    <option value="modelo">Ordenar por Modelo (A-Z) </option>
                    <option value="preco">Ordenar por Preço (Ascendente) </option>
                </select>
                <button type="submit">Aplicar Filtros</button>
            </form>
        </aside>


        <!-- Bicicletas -->

        <div class="container">
            <?php while ($row = $result->fetch_assoc()): ?>
                <?php
                $bicicleta_id = $row['id'];
                $stmt = $con->prepare("SELECT COUNT(*) FROM alugueres WHERE bicicleta_id = ? AND data_inicio <= ? AND data_fim >= ?");
                $stmt->bind_param("iss", $bicicleta_id, $agora, $agora);
                $stmt->execute();
                $stmt->bind_result($em_uso);
                $stmt->fetch();
                $stmt->close();
                $classe = $em_uso > 0 ? 'disabled' : '';
                ?>
                <a href="detalhes.php?id=<?php echo $row['id']; ?>" class="bike-card <?php echo $classe; ?>">
                    <img src="<?php echo $row['imagem']; ?>" alt="<?php echo $row['modelo']; ?>">
                    <h2><?php echo $row['modelo']; ?></h2>
                    <p><?php echo $row['descricao']; ?></p>
                    <p><strong>Preço:</strong> €<?php echo $row['preco']; ?>/hora</p>
                </a>

            <?php endwhile; ?>
        </div>

        <!-- Paginação -->
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>" class="prev">&#8592; Anterior</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>"> <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="?page=<?php echo $page + 1; ?>" class="next">Próxima &#8594;</a>
            <?php endif; ?>
        </div>


        <!-- Footer -->
        <footer class="footer">
            <div class="footer-content">
                <div class="footer-section logo-section">
                    <h3>Roda Pedaleira</h3>
                    <a href="../sobrenos/sobrenos.html">A nossa Equipa</a>
                </div>
                <div class="footer-section contact-section">
                    <h3>Contato</h3>
                    <p><i class="icon">📍</i> <a href="https://maps.app.goo.gl/xzcDq5eb2nb1xgcQA">Eiras, Coimbra,
                            Portugal</a></p>
                    <p><i class="icon">📞</i> (+351) 914 928 796</p>
                    <p><i class="icon">📧</i> <a href="https://mail.google.com/">rodapedaleirapap@gmail.com</a></p>
                </div>
                <div class="footer-section links-section">
                    <h3>Links</h3>
                    <ul>
                        <li><a href="http://localhost/PAP/codigos/registo/termos/termos.html">Termos e Condições </a>
                        </li>
                    </ul>
                </div>
            </div>
        </footer>

</body>

</html>