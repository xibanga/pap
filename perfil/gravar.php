<?php
session_start();

if (!isset($_POST["botaoGravar"]) || !isset($_SESSION["nome"])) {
    header("Location: perfil.php");
    exit();
}

require "../ligabd.php";

// Obter os dados do formulário
$palavra_passe = $_POST['palavra_passe'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$id = $_POST['id_utilizadores'];

// Verificar se a palavra-passe foi fornecida
if (!empty($palavra_passe)) {
    // Prepare a query SQL para atualizar os dados do utilizador, incluindo a palavra-passe
    $sql = "UPDATE utilizadores SET palavra_passe = PASSWORD(?), nome = ?, email = ? WHERE id = ?";
    $stmt = $con->prepare($sql);

    // Verificar se a preparação da query foi bem-sucedida
    if ($stmt === false) {
        die('Erro na preparação da query: ' . $con->error);
    }

    // Ligar os parâmetros à query
    $stmt->bind_param('sssi', $palavra_passe, $nome, $email, $id);
} else {
    // Prepare a query SQL para atualizar os dados do utilizador, sem a palavra-passe
    $sql = "UPDATE utilizadores SET nome = ?, email = ? WHERE id = ?";
    $stmt = $con->prepare($sql);

    // Verificar se a preparação da query foi bem-sucedida
    if ($stmt === false) {
        die('Erro na preparação da query: ' . $con->error);
    }

    // Ligar os parâmetros à query
    $stmt->bind_param('ssi', $nome, $email, $id);
}

// Executar a query
if ($stmt->execute() === false) {
    die('Erro na execução da query: ' . $stmt->error);
}

// Atualizar os dados da sessão
$_SESSION['nome'] = $nome;
$_SESSION['email'] = $email;

// Fechar a declaração e a conexão
$stmt->close();
$con->close();

// Redirecionar de volta para a página de edição dos utilizadores
header("Location: perfil.php");
exit();
?>