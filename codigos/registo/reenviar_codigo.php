<?php
session_start();

if (!isset($_SESSION["dadosUtilizador"])) {
    header("Location: registo.php");
    exit();
}

include "../../ligabd.php";


// Gera um novo código de 6 dígitos aleatório
$novoCodigo = rand(100000, 999999);
$_SESSION["codigoVerificacao"] = $novoCodigo;

// Dados do utilizador para envio do e-mail
$email = $_SESSION["dadosUtilizador"]["email"];

// Enviar e-mail com o código de verificação
$assunto = "Código de Verificação - Roda Pedaleira";
$mensagem = "
<!DOCTYPE html>
     <html lang='pt'>
     <head>
         <meta charset='UTF-8'>
         <meta name='viewport' content='width=device-width, initial-scale=1.0'>
         <title>Confirmação de Aluguer</title>
     </head>
     <body style='font-family: Arial, sans-serif; text-align: center; padding: 20px; background-color: #f8f8f8;'>
         <div style='max-width: 600px; background: white; padding: 20px; border-radius: 8px; margin: auto; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);'>
             <img src='https://drive.google.com/uc?id=15LfykZXNP0RoRTz1KyifFpX0irXd0SEw' alt='Roda Pedaleira' style='width: 100px; margin-bottom: 20px;'>
             <h2 style='color: #333;'>Obrigado por se registar!</h2>
             <p style='font-size: 16px; color: #555;'>Aqui está o seu novo código para concluir o registo:</p>
             
             <div class='email-body'>
            <span class='email-code'>$novoCodigo</span>
            <p>Se não foi você que solicitou este registo, por favor ignore este e-mail.</p>
        </div>
 
             <p style='font-weight: bold; color: #28a745;'>Obrigado se registar na Roda Pedaleira!</p>
         </div>
     </body>
     </html>
     ";

$headers = "From: noreply@rodapedaleira.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

if (!mail($email, $assunto, $mensagem, $headers)) {
    $_SESSION["erro"] = "Erro ao enviar o código de verificação. Tente novamente mais tarde.";
    header("Location: registo.php");
    exit();
}

if (mail($email, $assunto, $mensagem, $headers)) {
    $_SESSION["sucesso"] = "Um novo código foi enviado para $email.";
} else {
    $_SESSION["erro"] = "Erro ao enviar o novo código. Por favor, tente novamente mais tarde.";
}

if (mail($email, $assunto, $mensagem, $headers)) {
    $_SESSION["sucesso"] = "Um novo código foi enviado para $email.<br> Verifique a sua caixa de entrada.";
} else {
    $_SESSION["erro"] = "Erro ao enviar o novo código. Por favor, tente novamente mais tarde.";
}

// Redireciona de volta para a página de verificação
header("Location: verificar_codigo.php");
exit();
?>
