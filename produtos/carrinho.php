<?php
session_start();

// unset($_SESSION['carrinho']);

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = array();
}

// Remover produto do carrinho
if (isset($_GET['remover'])) {
    $produto_id = $_GET['remover'];
    foreach ($_SESSION['carrinho'] as $key => $produto) {
        if ($produto['id'] == $produto_id) {
            unset($_SESSION['carrinho'][$key]);
            break;
        }
    }
    $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);
}

// Atualizar quantidade do produto
if (isset($_POST['atualizar'])) {
    $produto_id = $_POST['produto_id'];
    $quantidade = $_POST['quantidade'];
    foreach ($_SESSION['carrinho'] as &$produto) {
        if ($produto['id'] == $produto_id) {
            $produto['quantidade'] = $quantidade;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../imagens/rodapedaleira2.png">
    <link rel="stylesheet" href="carrinho.css">
    <title>Carrinho de Compras</title>
</head>

<body>

    <header class="navbar">
        <div class="logo">
            <a href="main_vendas.php">
                <img src="../imagens/rodapedaleira2.png" alt="rodapedaleira" width="170px">
            </a>
        </div>
    </header>

    <br>
    <br>

    <div class="container">
        <h1>Carrinho de Compras</h1>
        <br><br>

        <?php if (empty($_SESSION['carrinho'])): ?>
            <p>O seu carrinho está vazio.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Nome Produto</th>
                        <th>Preço</th>
                        <th>Cor</th>
                        <th>Tamanho</th>
                        <th>Quantidade</th>
                        <th>Total</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_geral = 0;
                    foreach ($_SESSION['carrinho'] as $produto):
                        $total = $produto['preco'] * $produto['quantidade'];
                        $total_geral += $total;
                        ?>
                        <tr>
                            <td><?php echo $produto['nome']; ?></td>
                            <td>€<?php echo number_format($produto['preco'], 2); ?> EUR</td>
                            <td><?= ucfirst(strtolower($produto["cor"])) ?></td>
                            <td><?= $produto["tamanho"] ?></td>
                            <td>
                                <form method="post" action="carrinho.php">
                                    <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
                                    <input type="number" name="quantidade" value="<?php echo $produto['quantidade']; ?>" min="1"
                                        style="border-radius: 5px;">
                            </td>
                            <td>€<?php echo number_format($total, 2); ?> EUR</td>
                            <td>
                                <button type="submit" name="atualizar">Atualizar</button>
                                </form>
                                <a href="carrinho.php?remover=<?php echo $produto['id']; ?>" class="action-button">Remover</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <h2>Total Geral: €<?php echo number_format($total_geral, 2); ?> EUR</h2>
            <br>
            <a href="checkout.php" class="checkout-button">Finalizar Compra</a>
        <?php endif; ?>
    </div>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

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