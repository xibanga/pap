<?php
session_start();

function test_input($dados)
{
    $dados = htmlspecialchars($dados);
    $dados = trim($dados);
    $dados = stripslashes($dados);

    return $dados;
}

include "../../ligabd.php";

// Capturar os dados do formulário
$nome = test_input($_POST["nome1"]) . " " . test_input($_POST["nome2"]);
$email = test_input($_POST["email"]);
$palavra_passe = test_input($_POST["palavra_passe"]);
$confirm_password = test_input($_POST["confirm_password"]);
$nif = trim($_POST['nif']);
$telefone = test_input($_POST["telefone"]);
$codigo_postal = test_input($_POST["codigo_postal"]);
$genero = test_input($_POST["genero"]);
$data_nascimento = test_input($_POST["data_nascimento"]);
$id_tipos_utilizador = 1;
$id_foto_perfil = 0;

// Verificar se a palavra-passe e a confirmação coincidem
if ($palavra_passe !== $confirm_password) {
    $_SESSION["erro"] = "A palavra-passe e a confirmação não coincidem.";
    header("Location: registo.php");
    exit();
}

// Verificar se o utilizador já está registrado
$sql = "SELECT * FROM utilizadores WHERE email='$email'";
$resultado = mysqli_query($con, $sql);

if (mysqli_num_rows($resultado) > 0) {
    $_SESSION["erro"] = "Um utilizador com este email já está registado no sistema.";
    header("Location: registo.php");
    exit();
}



// Gerar um código de verificação de 6 dígitos
$codigo = rand(100000, 999999);
$_SESSION["codigoVerificacao"] = $codigo;


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
             <p style='font-size: 16px; color: #555;'>Aqui está o seu código para concluir o registo:</p>
             
             <div class='email-body'>
            <p>Olá, <strong>$nome</strong>,</p>
            <p>Obrigado por se registar na Roda Pedaleira! Para concluir o seu registo, insira o código de verificação abaixo:</p>
            <span class='email-code'>$codigo</span>
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


// Salvar os dados do utilizador em sessão (antes de salvar na base de dados)
$_SESSION["dadosUtilizador"] = [
    'nome' => $nome,
    'email' => $email,
    'palavra_passe' => $palavra_passe,
    'telefone' => $telefone,
    'codigo_postal' => $codigo_postal,
    'genero' => $genero,
    'data_nascimento' => $data_nascimento,
    'id_tipos_utilizador' => $id_tipos_utilizador,
    'id_foto_perfil' => $id_foto_perfil
];

// Redirecionar para o formulário de verificação
header("Location: verificar_codigo.php");
exit();
?>