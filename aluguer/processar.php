<?php
include('../ligabd.php');
session_start();
date_default_timezone_set('Europe/Lisbon');

if (!isset($_SESSION['email'])) {
    die("Erro: Usuário não autenticado.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bicicleta_id = intval($_POST['bicicleta']);
    $horas = intval($_POST['horas']);
    $data_inicio_user = $_POST['data_inicio'];
    $user_email = $_SESSION['email'];

    $agora = date('Y-m-d H:i:s');
    $min_inicio = date('Y-m-d H:i:s', strtotime('+30 minutes'));

    
    if (strtotime($data_inicio_user) < strtotime($min_inicio)) {
        die("Erro: A data de início tem de ser pelo menos 30 minutos no futuro.");
    }

    $data_fim = date('Y-m-d H:i:s', strtotime("$data_inicio_user +$horas hours"));

    $sql = "SELECT * FROM bicicletas WHERE id = ? AND disponibilidade = 1";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $bicicleta_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        die("Erro: Bicicleta indisponível.");
    }


     // Verifica se a bicicleta já está ocupada neste intervalo
    $sql_check = "SELECT COUNT(*) FROM alugueres 
                  WHERE bicicleta_id = ? AND data_inicio <= ? AND data_fim >= ?";
    $stmt = $con->prepare($sql_check);
    $stmt->bind_param("iss", $bicicleta_id, $data_inicio_user, $data_inicio_user);
    $stmt->execute();
    $stmt->bind_result($ja_ocupada);
    $stmt->fetch();
    $stmt->close();

    if ($ja_ocupada > 0) {
        die("Erro: Esta bicicleta já está reservada para essa hora.");
    }

     
    $sql = "SELECT id FROM utilizadores WHERE email = ? LIMIT 1";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        die("Erro: Utilizador não encontrado.");
    }
    $row = $result->fetch_assoc();
    $utilizador_id = $row['id'];

    $sql = "SELECT preco, imagem FROM bicicletas WHERE id = ? LIMIT 1";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $bicicleta_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $preco_total = $row['preco'] * $horas;
    $imagem_bicicleta = urlencode($row['imagem']);

    $sql = "INSERT INTO alugueres (utilizador_id, bicicleta_id, data_inicio, data_fim, status, total) 
            VALUES (?, ?, ?, ?, 'Agendado', ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("iissi", $utilizador_id, $bicicleta_id, $data_inicio_user, $data_fim, $preco_total);
    $stmt->execute();

    // Enviar e-mail para o utilizador
    $assunto = "Confirmação de Aluguer - Roda Pedaleira";

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
             <h2 style='color: #333;'>Obrigado pelo seu aluguer!</h2>
             <p style='font-size: 16px; color: #555;'>Aqui estão os detalhes do seu aluguer:</p>
             
             <div style='background: #f2f2f2; padding: 15px; border-radius: 8px; margin-top: 10px;'>
                <p><strong>Data/Hora de Início:</strong> $data_inicio_user</p>
                 <p><strong>Hora de Devolução:</strong> $data_fim</p>
                <p><strong>Total de Horas:</strong> €$horas</p>
                <p><strong>Total a Pagar:</strong> €$preco_total</p>
             </div>
 
             <p style='font-size: 14px; color: #777;'>Por favor, devolva a bicicleta até a hora indicada.</p>
             <p style='font-weight: bold; color: #28a745;'>Obrigado por escolher a Roda Pedaleira!</p>
         </div>
     </body>
     </html>
     ";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Roda Pedaleira <noreply@rodapedaleira.com>" . "\r\n";

    mail($user_email, $assunto, $mensagem, $headers);

    header("Location: confirmacao.php?hora_devolucao=$data_fim&imagem=$imagem_bicicleta");
    exit();
}
?>