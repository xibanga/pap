<?php
session_start();

include "../../ligabd.php";

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    if (!empty($email)) {
        // Verifica se o email está registrado no banco de dados
        $stmt = $con->prepare("SELECT id FROM utilizadores WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $userId = $row['id'];

            // Gera um token único e define o tempo de validade
            $token = bin2hex(random_bytes(16));
            $expiry = date("Y-m-d H:i:s", strtotime('+1 hour')); // Token expira em 1 hora

            // Armazena o token no banco de dados
            $stmt = $con->prepare("UPDATE utilizadores SET reset_token = ?, token_expiry = ? WHERE id = ?");
            $stmt->bind_param("ssi", $token, $expiry, $userId);
            $stmt->execute();

            // Configuração de email
            $resetLink = "http://localhost/PAP/codigos/login/reset_password.php?token=$token";
            $to = $email;
            $subject = "Redefinição de Palavra-passe - Roda Pedaleira";
            $message = "Olá,\n\nClique no link abaixo para redefinir sua palavra-passe:\n\n$resetLink\n\nO link expira em 1 hora.\n\nObrigado,\nEquipa Roda Pedaleira.";
            $headers = "From: rodapedaleirapap@gmail.com";

            if (mail($to, $subject, $message, $headers)) {

                $mensagem = "Um link de redefinição foi enviado para o seu email." ;
            } else {
                $mensagem = "Erro ao enviar o email. Tente novamente mais tarde.";
            }
        } else {
            $mensagem = "O email fornecido não está registado.";
        }
    } else {
        $mensagem = "Por favor, insira o seu email.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Palavra-passe</title>
    <link rel="stylesheet" href="palavrapasse.css">
    <link rel="icon" type="image/x-icon" href="../../imagens/rodapedaleira2.png">
</head>
<body>
    <div class="container">
        <!-- Seção da Imagem -->
        <div class="image-section">
            <a href="../../"><img src="../../imagens/rodapedaleira2.png" alt="Roda Pedaleira Logo"></a>
        </div>

        <!-- Seção do Formulário -->
        <div class="form-section">
            <h2>Recuperar Palavra-passe</h2>
            <p>Insira o seu email para recuperar a sua palavra-passe.</p>
            <?php if (!empty($mensagem)): ?>
                <div><?php echo $mensagem; ?></div>
            <?php endif; ?>
            <form action="palavrapasse.php" method="post">
                <div class="form-row">
                    <br>
                    <input type="email" name="email" placeholder="Seu Email" required>
                </div>
                <button type="submit">Recuperar Palavra-passe</button>
            </form>
        </div>
    </div>
</body>
</html>
