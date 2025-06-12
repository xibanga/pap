<?php
session_start();
require "../../ligabd.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    // Verificar se o reCAPTCHA foi preenchido
    if (empty($recaptchaResponse)) {
        $_SESSION["erro"] = "Por favor, complete o reCAPTCHA.";
        header("Location: login.php");
        exit();
    } else {
        // Verificar o reCAPTCHA com a API do Google
        $secretKey = "SUA_CHAVE_SECRETA_DO_RECAPTCHA"; // Substitua pela sua chave secreta
        $verifyUrl = "https://www.google.com/recaptcha/api/siteverify";
        $response = file_get_contents($verifyUrl . "?secret=" . $secretKey . "&response=" . $recaptchaResponse);
        $responseData = json_decode($response);

        if ($responseData->success) {
            // Se o reCAPTCHA for válido, continuar com o login
            if (!empty($email) && !empty($password)) {
                $sql = "SELECT id_utilizadores, utilizador, palavra_passe, id_tipos_utilizador FROM utilizadores WHERE email = ?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();

                    if (password_verify($password, $user['palavra_passe'])) {
                        // Login bem-sucedido
                        $_SESSION['id_utilizador'] = $user['id_utilizadores'];
                        $_SESSION['utilizador'] = $user['utilizador'];
                        $_SESSION['id_tipos_utilizador'] = $user['id_tipos_utilizador'];

                        if ($user['id_tipos_utilizador'] == 0) {
                            header("Location: editar_utilizadores.php"); // Redirecionar para o painel admin
                        } else {
                            header("Location: perfil.php"); // Redirecionar utilizadores normais para o perfil
                        }
                        exit();
                    } else {
                        $_SESSION["erro"] = "Palavra-passe incorreta.";
                        header("Location: login.php");
                        exit();
                    }
                } else {
                    $_SESSION["erro"] = "Email não encontrado.";
                    header("Location: login.php");
                    exit();
                }
            } else {
                $_SESSION["erro"] = "Por favor, preencha todos os campos.";
                header("Location: login.php");
                exit();
            }
        } else {
            $_SESSION["erro"] = "Falha na verificação do reCAPTCHA. Tente novamente.";
            header("Location: login.php");
            exit();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="../../imagens/rodapedaleira2.png">
    <link rel="stylesheet" href="login.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }
    </script>
</head>
<body>
    <!-- Container Principal -->
    <div class="container">
        <!-- Seção da Imagem -->
        <div class="image-section">
            <a href="../../"><img src="../../imagens/rodapedaleira2.png" alt="Roda Pedaleira Logo"></a>
        </div>

        <!-- Seção do Formulário -->
        <div class="form-section">
            <h2>Iniciar Sessão</h2>
            <p>Clique para entrar, o melhor do ciclismo vai encontrar!</p>
            <form action="submit.php" method="post">
                <!-- Campo de Email -->
                <div class="form-row">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                
                <br>

                <!-- Campo de Palavra-passe com Olhinho -->
                <div class="password-container">
                    <input type="password" id="password" name="password" placeholder="Palavra-passe" required>
                    <span class="toggle-password" onclick="togglePassword()">👁️</span>
                </div>

                <p><a href="palavrapasse.php" style="color: white; text-decoration: underline;">Esqueceu-se da Palavra-passe?</a></p>
                
               
                
                
                <!-- Captcha -->
                <div class="recaptcha-container">
                    <div class="g-recaptcha" data-sitekey="6LdKsXkqAAAAALDNFNAMFrDlsC37hN1Gd7bGKOy5"></div>
                </div>

                <br>
                
                <!-- Botão -->
                <button type="submit" class="login-btn" name="botaoLogin">Iniciar Sessão</button>

                <p> Não tem uma Conta? <a href="../registo/registo.php" style="color: white; text-decoration: underline;">Registe-se!</a></p>


                <p> <p xmlns:cc="http://creativecommons.org/ns#" xmlns:dct="http://purl.org/dc/terms/"><span property="dct:title">Roda Pedaleira</span> by <span property="cc:attributionName">Afonso Duarte</span> is licensed under <a href="https://creativecommons.org/licenses/by/4.0/?ref=chooser-v1" target="_blank" rel="license noopener noreferrer" style="display:inline-block;">CC BY 4.0<img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/cc.svg?ref=chooser-v1" alt=""><img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;" src="https://mirrors.creativecommons.org/presskit/icons/by.svg?ref=chooser-v1" alt=""></a></p></p>
            </form>
            <div style="color: red;" id="erro"></div>
        </div>
    </div>

    <?php
    if (isset($_SESSION["erro"])) {
        echo "<script> document.getElementById('erro').textContent = '".$_SESSION["erro"]."' </script>";
        unset($_SESSION["erro"]);
    }
    ?>
</body>
</html>
