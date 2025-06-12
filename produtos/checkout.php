<?php
session_start();

if (!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {
    header("Location: carrinho.php");
    exit();
}

// Processar o checkout
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Aqui você pode adicionar o código para processar o pagamento e salvar o pedido no banco de dados
    // Por exemplo, você pode usar uma API de pagamento como Stripe ou PayPal

    // Limpar o carrinho após o checkout
    unset($_SESSION['carrinho']);

    echo "<script>
            alert('Compra realizada com sucesso!');
            window.location.href = 'merch.php';
          </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../imagens/rodapedaleira2.png">
    <link rel="stylesheet" href="checkout.css">
    <title>Checkout</title>
</head>
<body>

<header class="navbar">
    <div class="logo"> 
        <a href="../paginas/pagina1.php"> 
            <img src="../imagens/rodapedaleira2.png" alt="rodapedaleira" width="170px"> 
        </a> 
    </div>
</header>

<br>
<br>
<div class="container">
    <h1>Checkout</h1>
    <br><br>

    <form method="post" action="checkout.php">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco" required><br>

        <label for="cidade">Cidade:</label>
        <input type="text" id="cidade" name="cidade" required><br>

        <label for="cep">Código-Postal:</label>
        <input type="text" id="cep" name="cep" required><br>

        <label for="pais">País:</label>
        <input type="text" id="pais" name="pais" required><br>

        <h2>Detalhes do Pedido</h2>
        <table>
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                    <th>Total</th>
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
                        <td><?php echo $produto['quantidade']; ?></td>
                        <td>€<?php echo number_format($produto['preco'], 2); ?> EUR</td>
                        <td>€<?php echo number_format($total, 2); ?> EUR</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h2>Total Geral: €<?php echo number_format($total_geral, 2); ?> EUR</h2>
        <br>
        <a href="pagamento.php" class="checkout-button">Finalizar Compra</a>
    </form>
</div>

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