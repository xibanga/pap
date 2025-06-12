<?php
session_start();
require "../ligabd.php";

if (isset($_POST['botaoUpload']) && isset($_FILES['foto_perfil'])) {
    $id = $_POST['id_utilizadores'];
    $foto_perfil = $_FILES['foto_perfil'];

    // Verificar se o upload foi bem-sucedido
    if ($foto_perfil['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($foto_perfil['name'], PATHINFO_EXTENSION);
        $novo_nome = uniqid() . '.' . $extensao;
        $destino = '../fotos_perfil/' . $novo_nome;

        // Mover o arquivo para o destino
        if (move_uploaded_file($foto_perfil['tmp_name'], $destino)) {
            // Atualizar a base de dados com o novo caminho da foto
            $sql = "UPDATE utilizadores SET id_foto_perfil = ? WHERE id = ?";
            $stmt = $con->prepare($sql);

            if ($stmt === false) {
                die('Erro na preparação da query: ' . $con->error);
            }

            $stmt->bind_param('si', $novo_nome, $id);

            if ($stmt->execute() === false) {
                die('Erro na execução da query: ' . $stmt->error);
            }

            // Atualizar a sessão com o novo caminho da foto
            $_SESSION['id_foto_perfil'] = $novo_nome;

            $stmt->close();
            $con->close();

            // Redirecionar de volta para a página de perfil
            header("Location: perfil.php");
            exit();
        } else {
            $_SESSION['erro'] = 'Erro ao mover o arquivo.';
        }
    } else {
        $_SESSION['erro'] = 'Erro no upload da foto.';
    }
} else {
    $_SESSION['erro'] = 'Nenhuma foto foi enviada.';
}

// Redirecionar de volta para a página de perfil em caso de erro
header("Location: perfil.php");
exit();
?>