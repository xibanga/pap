<?php
session_start();
include '../ligabd.php'; // Inclua seu arquivo de conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_evento = $_POST['nome_evento'];
    $data_evento = $_POST['data_evento'];
    $hora_evento = $_POST['hora_evento'];
    $loc_evento = $_POST['localizacao'];
    $descricao = $_POST['descricao'];
    $criador_evento = $_POST['criador'];
    $tipo_evento = $_POST['tipo'];

    // Processar upload da imagem
    $imagem = $_FILES['imagem']['name'];
    $target_dir = "../imagens/eventos/";
    $target_file = $target_dir . basename($imagem);

    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $target_file)) {
        // Inserir dados no banco de dados
        $query = "INSERT INTO eventos (nome_evento, data_evento, hora, localizacao, descricao, imagem, criador, tipo) VALUES ('$nome_evento', '$data_evento', '$hora_evento', '$loc_evento', '$descricao', '$imagem', '$criador_evento', '$tipo_evento')";
        if (mysqli_query($con, $query)) {
            $_SESSION['mensagem'] = "Evento criado com sucesso!";
        } else {
            $_SESSION['erro'] = "Erro ao criar evento: " . mysqli_error($con);
        } 
    } else {
        $_SESSION['erro'] = "Erro ao fazer upload da imagem.";
    }

    // Redirecionar para a seção correta
    if ($tipo_evento == 'desportivo') {
        header("Location: ../eventos/desportivos/desportivos.php");
    } else {
        header("Location: ../eventos/solidarios/solidarios.php");
    }
    exit();
}
?>