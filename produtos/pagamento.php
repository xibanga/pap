<?php
session_start();
require "../ligabd.php"; // Conexão com o banco de dados

// Verificar se o carrinho está vazio
if (!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {
    header("Location: main_vendas.php");
    exit();
}

// Obter produtos no carrinho
$produtos_no_carrinho = $_SESSION['carrinho'];
$produtos = [];
$total = 0;

foreach ($produtos_no_carrinho as $produto) {
    $produto_id = $produto['id'];
    $query = "SELECT * FROM produtos WHERE id = $produto_id";
    $resultado = mysqli_query($con, $query);
    $produto_info = mysqli_fetch_assoc($resultado);
    $produto_info['quantidade'] = $produto['quantidade'];
    $produtos[] = $produto_info;
    $total += $produto_info['preco'] * $produto_info['quantidade'];
}

// Verificar se o método de envio foi selecionado
if (isset($_POST['envio'])) {
    $envio = $_POST['envio'];
    $_SESSION['envio'] = $envio;
} elseif (isset($_SESSION['envio'])) {
    $envio = $_SESSION['envio'];
} else {
    $envio = 0;
}

$total += $envio;
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="pagamento.css">
    <link rel="icon" type="image/x-icon" href="../imagens/rodapedaleira2.png">
    <title>Pagamento</title>
</head>

<style>
        .opcoes-envio {
            text-align: center; /* Centraliza o conteúdo */
            margin-bottom: 20px; /* Espaçamento entre as opções */
        }

        .opcoes-envio img {
            display: block; /* Faz a imagem ocupar uma linha inteira */
            margin: 0 auto 10px; /* Centraliza a imagem e adiciona espaço abaixo */
        }

        .opcoes-envio label {
            display: block; /* Faz cada label ocupar uma linha inteira */
            margin: 5px 0; /* Espaçamento entre as labels */
        }
    </style>

<body>

    <header>
        <div class="logo">
            <a href="../paginas/pagina1.php"><img src="../imagens/rodapedaleira2.png" alt="Logo"></a>
        </div>
    </header>

    <main>
        <h1>Pagamento</h1>
        <div class="resumo-carrinho">
            <h2>Resumo do Carrinho</h2>
            <ul>
                <?php foreach ($produtos as $produto): ?>
                    <li>
                        <div style="display: flex; align-items: center">
                            <img src="../imagens/<?php echo $produto['categoria']; ?>/preta/frente.png" alt="<?php echo $produto['nome']; ?>" width="50">
                            <span><?php echo $produto['nome']; ?></span>
                        </div>
                        <span>Quantidade: <?php echo $produto['quantidade']; ?></span>
                        <span>€<?php echo number_format($produto['preco'] * $produto['quantidade'], 2); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
            <p>Total: €<?php echo number_format($total, 2); ?></p>
        </div>

        <div class="envio">
            <button type="button" class="button-envio" onclick="mostrarPopupEnvio()"> 🚚 Envio</button>
        </div>

        <div id="popup-envio" class="popup-envio" style="display: none;">
            <div class="popup-content">
                <span class="close" onclick="fecharPopupEnvio()">&times;</span>
                <h2>Escolha o Tipo de Envio</h2>
                <form action="" method="post">
                    <div class="opcoes-envio">
                        <h3>CTT</h3>
                        <img src="../imagens/ctt.png" alt="CTT" class="logo-envio">
                        <label>
                            <input type="radio" name="envio" value="9.99" onchange="atualizarTotal(9.99)"> 🚚 2 a 5 dias úteis: 9,99
                        </label>
                        <label>
                            <input type="radio" name="envio" value="3.99" onchange="atualizarTotal(3.99)"> 🚚 7 a 9 dias úteis: €3,99
                        </label>
                    </div>
                    <div class="opcoes-envio">
                        <h3>DHL Express</h3>
                        <img src="../imagens/dhl.png" alt="DHL" class="logo-envio">
                        <label>
                            <input type="radio" name="envio" value="12.99" onchange="atualizarTotal(12.99)"> 🚚 1 a 2 dias úteis: €12,99
                        </label>
                        <label>
                            <input type="radio" name="envio" value="4.99" onchange="atualizarTotal(4.99)"> 🚚 5 a 9 dias úteis: €4,99
                        </label>
                    </div>
                    <button type="submit" class="btn-fechar">Fechar</button>
                </form>
            </div>
        </div>

        <div class="escolha-pagamento">
            <h2>Escolha o Método de Pagamento</h2>
            <button onclick="mostrarFormulario('cartao')">Cartão de Crédito</button>
            <button onclick="mostrarFormulario('mbway')">MB Way</button>
        </div>

        <div class="formulario-pagamento" id="formulario-cartao" style="display: none;">
            <h2>Detalhes do Pagamento</h2>
            <div class="cartao-container">
                <div class="imagem-cartao">
                    <img src="../imagens/visa.png" alt="Visa">
                </div>
                <form action="processar_pagamento.php" method="post" class="form-cartao">
                    <label for="nome">Nome Cartão:</label>
                    <input type="text" id="nome" name="nome" required>

                    <label for="cartao">Número do Cartão:</label>
                    <input type="text" id="cartao" name="cartao" required>

                    <label for="validade">Validade:</label>
                    <input type="text" id="validade" name="validade" placeholder="MM/AA" required>

                    <label for="cvv">CVV:</label>
                    <input type="text" id="cvv" name="cvv" required>

                    <button type="submit" width="130px" >Finalizar Pagamento</button>
                </form>
            </div>
        </div>

        <div class="formulario-pagamento" id="formulario-mbway" style="display: none;">
            <h2> <b>Pagamento por MB Way</b></h2>
            <div class="mbway-container">
                <div class="imagem-mbway">
                    <img src="../imagens/mbway.png" alt="MB Way">
                </div>
                <form action="processar_pagamento.php" method="post" class="form-mbway">
                    <label for="telefone">Número de Telefone:</label>
                    <input type="text" id="telefone" name="telefone" required>

                    <button type="submit">Finalizar Pagamento</button>
                </form>
            </div>
        </div>
    </main>

    <!-- Moeda -->
    <?php include "moeda.php"; ?>

    <!-- FOOTER -->
    <footer>
        <div class="footer-content">
            <div class="currency">
                <label for="currency">País/Região:</label>
                <select id="currency">
                    <?php echo listar(); ?>
                </select>
            </div>
            <p>© 2025, Roda Pedaleira.</p>
            <div class="payment-methods">
                <img src="../imagens/visa.jpg" alt="Visa">
                <img src="../imagens/mbway.jpeg" alt="MB Way">
            </div>
        </div>
    </footer>

    <script>
        function mostrarFormulario(metodo) {
            document.getElementById('formulario-cartao').style.display = 'none';
            document.getElementById('formulario-mbway').style.display = 'none';

            if (metodo === 'cartao') {
                document.getElementById('formulario-cartao').style.display = 'block';
            } else if (metodo === 'mbway') {
                document.getElementById('formulario-mbway').style.display = 'block';
            }
        }

        function mostrarPopupEnvio() {
            document.getElementById('popup-envio').style.display = 'flex';
        }

        function fecharPopupEnvio() {
            document.getElementById('popup-envio').style.display = 'none';
        }

        function atualizarTotal(valorEnvio) {
            const totalElement = document.querySelector('.resumo-carrinho p');
            const totalAtual = parseFloat(totalElement.textContent.replace('Total: €', '').replace(',', '.'));
            const novoTotal = totalAtual + valorEnvio;
            totalElement.textContent = 'Total: €' + novoTotal.toFixed(2);
        }
    </script>


</body>

</html>