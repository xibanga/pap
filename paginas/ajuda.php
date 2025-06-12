<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajuda</title>
    <link rel="stylesheet" href="ajuda.css">
    <link rel="icon" type="image/x-icon" href="../imagens/rodapedaleira2.png">

</head>

<body>
    <div class="container">
        <!-- Imagem à esquerda -->
        <div class="image-section">
            <a href="pagina1.php"><img src="../imagens/rodapedaleira2.png" alt="Roda Pedaleira Logo" class="logo"></a>
        </div>

        <!-- Formulário à direita -->
        <div class="form-section">
            <h2>Precisa de Ajuda?</h2>
            <p>Preencha o formulário abaixo para entrar em contacto connosco.</p>
            <!-- Formulário -->
            <form action="ajuda.php" method="POST">
                <!-- Campo do email -->
                <label for="email">Endereço de Email:</label>
                <input type="email" id="email" name="email" placeholder="Insira o seu email" required>

                <br>

                <!-- Campo da mensagem -->
                <label for="mensagem">Mensagem:</label>
                <textarea id="mensagem" name="mensagem" rows="6" placeholder="Escreva a sua mensagem aqui..."
                    required></textarea>

                <!-- Botão de envio -->
                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>
</body>

</html>

<?php
// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Dados do formulário
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $mensagem = htmlspecialchars($_POST['mensagem']);

    // Configuração do email
    $destinatario = "rodapedaleirapap@gmail.com"; // Seu email
    $assunto = "Pedido de Ajuda - Roda Pedaleira";
    $corpoEmail = "Você recebeu uma nova mensagem de ajuda:\n\n";
    $corpoEmail .= "Email: $email\n";
    $corpoEmail .= "Mensagem:\n$mensagem\n";

    // Cabeçalhos do email
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Envia o email
    if (mail($destinatario, $assunto, $corpoEmail, $headers)) {
        echo "<script>alert(' A sua mensagem foi enviada com sucesso!');</script>";
    } else {
        echo "<script>alert('Ocorreu um erro ao enviar a sua mensagem. Tente novamente mais tarde.');</script>";
    }
}
?>