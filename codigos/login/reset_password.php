<?php
session_start();
include "../../ligabd.php";  // Certifique-se de que o caminho está correto

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter dados do formulário
    $email = trim($_POST['email']);
    $nova_palavra_passe = trim($_POST['nova_palavra_passe']);
    $confirmar_palavra_passe = trim($_POST['confirmar_palavra_passe']);
    
    if (empty($email) || empty($nova_palavra_passe) || empty($confirmar_palavra_passe)) {
        $mensagem = "Por favor, preencha todos os campos.";
    } elseif ($nova_palavra_passe !== $confirmar_palavra_passe) {
        $mensagem = "As palavras-passe não coincidem.";
    } else {
        // Verificar conexão
        if ($con->connect_error) {
            die("Erro de conexão com a base de dados: " . $con->connect_error);
        }

        // Verificar se o email existe
        $sql="SELECT * FROM utilizadores WHERE email = '$email' ";
        $resultado= mysqli_query($con, $sql);
        

        if (mysqli_num_rows($resultado) > 0) {
            // Encriptar a nova palavra-passe
            $nova_palavra_passe_hash = password_hash($nova_palavra_passe, PASSWORD_DEFAULT);

            // Atualizar a palavra-passe
            if (mysqli_query($con, "UPDATE utilizadores SET palavra_passe = password($nova_palavra_passe) WHERE email = '$email'")) {
                
                $mensagem = "A palavra-passe foi atualizada com sucesso.";
            } else {
                $mensagem = "Erro ao preparar a query de atualização: " . $con->error;
            }
        } else {
            $mensagem = "O email fornecido não está registrado.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Palavra-passe</title>
    <link rel="stylesheet" href="resetpassword.css"> <!-- Certifique-se que o caminho está correto -->
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
            <h2>Redefinir Palavra-passe</h2>
            <p>Insira o seu email e nova palavra-passe para redefinir.</p>
            <?php if (!empty($mensagem)): ?>
                <p class="mensagem"><?php echo $mensagem; ?></p>
            <?php endif; ?>
            <form action="reset_password.php" method="post">
                <div class="form-row">
                    <input type="email" name="email" placeholder="Seu Email" required>
                </div>
                <div class="form-row">
                    <input type="password" name="nova_palavra_passe" placeholder="Nova Palavra-passe" required>
                </div>
                <div class="form-row">
                    <input type="password" name="confirmar_palavra_passe" placeholder="Confirmar Palavra-passe" required>
                </div>
                <button type="submit">Redefinir Palavra-passe</button>
            </form>
        </div>
    </div>
</body>
</html>
