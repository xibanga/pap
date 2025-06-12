<?php
session_start();
require "../ligabd.php"; // Conexão com o banco de dados

// Verifica se o usuário é administrador
$is_admin = isset($_SESSION['id_tipos_utilizador']) && $_SESSION['id_tipos_utilizador'] == 0;

// Inicializa os filtros com valores padrão
$min_preco = isset($_GET['min_preco']) ? (float) $_GET['min_preco'] : 0;
$max_preco = isset($_GET['max_preco']) ? (float) $_GET['max_preco'] : 10000;
$categoria = isset($_GET['categoria']) ? mysqli_real_escape_string($con, $_GET['categoria']) : '';
$search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';

// Monta a query com os filtros aplicados
$query = "SELECT * FROM produtos WHERE preco BETWEEN $min_preco AND $max_preco";

if (!empty($categoria)) {
    $query .= " AND categoria = '$categoria'";
}

if (!empty($search)) {
    $query .= " AND (nome LIKE '%$search%' OR descricao LIKE '%$search%')";
}

$resultado = mysqli_query($con, $query);

// Consulta para produtos em destaque
$query_destaques = "SELECT * FROM produtos WHERE destaque = 'sim' ORDER BY id LIMIT 5";
$resultado_destaques = mysqli_query($con, $query_destaques);
?>


<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../imagens/rodapedaleira2.png">
    <title>Main Vendas</title>
    <link rel="stylesheet" href="main_vendas.css">
</head>

<body>

    <header>
        <div class="direita">
            <div class="logo">
                <a href="../paginas/pagina1.php"><img src="../imagens/rodapedaleira2.png" alt="Logo"></a>
            </div>

            <div class="header-buttons">
                <?php if ($is_admin): ?>
                    <a href="adicionar_equipamento.php" class="admin-button">Gerir Produtos</a>
                <?php endif; ?>
            </div>
        </div>
        <nav>
            <ul>
                <a href="carrinho.php" class="btn-carrinho"><img src="../imagens/cart1.png" alt="Carrinho"
                        width="30"></a>
                <li><a href="../paginas/ajuda.php"><b>Contacto</b></a></li>
            </ul>
        </nav>
    </header>

    <!-- Sidebar -->
    <div class="pagina">
        <div class="sidebar" id="sidebar">
            <h2>Filtros</h2>
            <form method="GET" action="main_vendas.php">

                <div class="search-bar">
                    <input type="text" name="search" placeholder=" 🔍 O que estás a procurar?"
                        value="<?php echo htmlspecialchars($search); ?>">
                </div>


                <br>

                <label style="color: black">💰 Faixa de preço:</label>

                <input type="number" id="min_preco" name="min_preco"
                    value="<?php echo htmlspecialchars($min_preco); ?>">

                <input type="number" id="max_preco" name="max_preco"
                    value="<?php echo htmlspecialchars($max_preco); ?>">


                <br>
                <br>
                <label for="categoria"> 🔖 Categoria:</label>
                <select id="categoria" name="categoria">
                    <option value="">Todas</option>
                    <?php
                    $categorias = ["sweatshirts", "t-shirts"];
                    foreach ($categorias as $cat) {
                        $selected = ($categoria == $cat) ? "selected" : "";
                        echo "<option value='$cat' $selected>" . ucfirst($cat) . "</option>";
                    }
                    ?>
                </select>

                <br>
                <br>
                <label for="tamanho"> 📏Tamanho:</label>
                <select id="tamanho" name="tamanho">
                    <option value="">Todos</option>
                    <?php
                    $tamanhos = ["XS", "S", "M", "L", "XL"];
                    foreach ($tamanhos as $tam) {
                        $selected = ($tamanho == $tam) ? "selected" : "";
                        echo "<option value='$tam' $selected>$tam</option>";
                    }
                    ?>
                </select>

                <br>
                <br>
                <label for="cor"> 🎨 Cor:</label>
                <select id="cor" name="cor">
                    <option value="">Todas</option>
                    <?php
                    $cores = [
                        "Branco" => "#FFFFFF",
                        "Preto" => "#000000",
                        "Amarelo" => "#FFFF00",
                        "Vermelho" => "#FF0000",
                        "Azul" => "#0000FF"
                    ];
                    foreach ($cores as $nome => $hex) {
                        $selected = ($cor == $nome) ? "selected" : "";
                        echo "<option value='$nome' $selected style='background-color: $hex; color: " . ($nome == "Preto" ? "white" : "black") . ";'>$nome</option>";
                    }
                    ?>
                </select>

            

                <br><br>

                <button type="submit">Aplicar Filtros</button>
            </form>
        </div>

        <main>
            <?php if (isset($_SESSION['mensagem'])): ?>
                <div class="mensagem">
                    <?php echo $_SESSION['mensagem'];
                    unset($_SESSION['mensagem']); ?>
                </div>
            <?php endif; ?>

            <!-- Seções de Produtos em Destaque -->
            <section class="produtos-destaque">
                <h2>Produtos em Destaque</h2>
                <div class="grid">
                    <?php while ($produto = mysqli_fetch_assoc($resultado_destaques)): ?>
                        <div class="produto" data-id="<?php echo $produto['id']; ?>">
                            <img src="../imagens/<?= $produto['categoria']; ?>/branca/frente.png"
                                alt="<?php echo $produto['nome']; ?>">
                            <h3><?php echo $produto['nome']; ?></h3>
                            <p>€<?php echo number_format($produto['preco'], 2); ?></p>

                            <form action="main_vendas.php" method="post">
                                <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
                            </form>
                        </div>
                    <?php endwhile; ?>
                </div>
            </section>

            <!-- Seção de Produtos -->
            <section class="produtos-detalhados">
                <h2>Produtos</h2>
                <div class="grid">

                    <?php while ($produto = mysqli_fetch_assoc($resultado)): ?>
                        <?php foreach (['amarela', 'azul', 'branca', 'preta', 'vermelha'] as $cor): ?>
                            <?php if ($produto['destaque'] != 'sim'): ?>
                                <a class="produto" href="detalhes_produto.php?id=<?= $produto['id'] ?>&cor=<?= $cor ?>">
                                    <img src="../imagens/<?= $produto['categoria']; ?>/<?= $cor ?>/frente.png"
                                        alt="<?php echo $produto['nome']; ?>">
                                    <h3><?php echo $produto['nome']; ?></h3>
                                    <p>€<?php echo number_format($produto['preco'], 2); ?></p>

                                    <form action="main_vendas.php" method="post">
                                        <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
                                    </form>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endwhile; ?>
                </div>
            </section>
        </main>
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
                    <li><a href="http://localhost/PAP/codigos/registo/termos/termos.html">Termos e Condições </a></li>
                </ul>
            </div>
        </div>
    </footer>

</body>

</html>