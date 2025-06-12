<?php
session_start();
require "../ligabd.php"; // Conexão com o banco de dados

// Verificar se o carrinho está vazio
if (!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {
    header("Location: main_vendas.php");
    exit();
}

// Obter o e-mail do usuário logado
$email = $_SESSION['email']; // Certifique-se de que o e-mail do usuário está armazenado na sessão

// Verificar se os dados do formulário foram enviados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obter detalhes do usuário
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $cidade = $_POST['cidade'];
    $cep = $_POST['cep'];

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

    // Verificar se o pagamento é por cartão de crédito
    if (isset($_POST['cartao'])) {
        $cartao = $_POST['cartao'];
        $validade = $_POST['validade'];
        $cvv = $_POST['cvv'];

        // Processar pagamento por cartão de crédito (simulação)
        // Aqui você pode adicionar a lógica para processar o pagamento com uma API de pagamento

        $_SESSION['mensagem'] = "Pagamento por Cartão de Crédito realizado com sucesso!";
    }

    // Verificar se o pagamento é por MB Way
    if (isset($_POST['telefone'])) {
        $telefone = $_POST['telefone'];

        // Processar pagamento por MB Way (simulação)
        // Aqui você pode adicionar a lógica para processar o pagamento com uma API de pagamento

        $_SESSION['mensagem'] = "Pagamento por MB Way realizado com sucesso!";
    }

    // Enviar e-mail de confirmação
    $assunto = 'Recibo de Compra - Roda Pedaleira';
    $mensagem = '<!DOCTYPE html>
    <html lang="pt">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                color: #333;
                margin: 0;
                padding: 0;
            }
            .container {
                width: 80%;
                margin: auto;
                padding: 20px;
                background: white;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                border-radius: 5px;
            }
            h1 {
                text-align: center;
                color: #333;
            }
            .logo {
                text-align: center;
                margin-bottom: 20px;
            }
            .resumo-carrinho {
                margin-bottom: 20px;
            }
            .resumo-carrinho h2 {
                color: #333;
            }
            .resumo-carrinho ul {
                list-style: none;
                padding: 0;
            }
            .resumo-carrinho ul li {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 0;
                border-bottom: 1px solid #ddd;
            }
            .resumo-carrinho p {
                text-align: right;
                font-weight: bold;
                font-size: 1.2em;
            }
            .endereco-entrega {
                margin-top: 20px;
            }
            .endereco-entrega p {
                margin: 5px 0;
            }
            .agradecimento {
                margin-top: 20px;
                text-align: center;
                font-size: 1.2em;
                color: #4CAF50;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="logo">
                <img src="https://drive.google.com/uc?id=15LfykZXNP0RoRTz1KyifFpX0irXd0SEw " style="width:100px;height:55px;"alt="Roda Pedaleira">
            </div>
            <h1>Obrigado pela sua compra!</h1>
            <div class="resumo-carrinho">
                <h2>Detalhes da compra:</h2>
                <ul>';
    foreach ($produtos as $produto) {
        $mensagem .= '<li>';
        $mensagem .= '<p>' . $produto['nome'] . '</p>'; 
        $mensagem .= '<p>Quantidade: ' . $produto['quantidade'] . '</p>';
        $mensagem .= '</li>';
    }
    $mensagem .= '</ul>
                <p>Total: €' . number_format($total, 2) . '</p>
            </div>
          
            <div class="agradecimento">
                <p>Obrigado por comprar na Roda Pedaleira. Juntos por uma causa maior !</p>
            </div>
        </div>
    </body>
    </html>';

    // Definir cabeçalhos do e-mail
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: <seu_email@example.com>' . "\r\n";

    // Enviar o e-mail
    if (mail($email, $assunto, $mensagem, $headers)) {
        $_SESSION['mensagem'] = " O recibo foi enviado para o seu e-mail!";
    } else {
        $_SESSION['mensagem'] = "Erro ao enviar e-mail de confirmação.";
    }

    // Limpar o carrinho após o pagamento
    unset($_SESSION['carrinho']);

    // Redirecionar para a página de confirmação
    header("Location: confirmacao_pagamento.php");
    exit();
} else {
    // Redirecionar para a página de pagamento se os dados do formulário não foram enviados
    header("Location: pagamento.php");
    exit();
}
?>