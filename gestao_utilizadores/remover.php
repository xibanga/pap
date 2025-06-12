<?php
session_start();

// Verificar se o utilizador tem permissão para remover contas
if (!isset($_POST["id_utilizadores"]) || !isset($_SESSION["id_tipos_utilizador"]) || $_SESSION["id_tipos_utilizador"] != 0) {
    header("Location: editar_utilizadores.php");
    exit();
}

// Verificar se a sessão de tipo de utilizador está definida
if (!isset($_SESSION["id_tipos_utilizador"])) {
    header("Location: editar_utilizadores2.php");
    exit();
}

// Impedir acesso se o tipo de utilizador não for administrador
if ($_SESSION["id_tipos_utilizador"] != 0) {
    header("Location: editar_utilizadores3.php");
    exit();
}

// Incluir a conexão com o banco de dados
require "../ligabd.php";

// Obter o ID do utilizador a ser removido
$id_utilizadores = intval($_POST["id_utilizadores"]);

// Consultar o utilizador para verificar restrições
$sql_check_user = "SELECT * FROM utilizadores WHERE id = $id_utilizadores";
$result_check = mysqli_query($con, $sql_check_user);

if (!$result_check || mysqli_num_rows($result_check) == 0) {
    $_SESSION["erro"] = "O utilizador especificado não existe.";
    header("Location: editar_utilizadores.php");
    exit();
}

$utilizador = mysqli_fetch_assoc($result_check);

// Restringir a remoção da conta principal "Afonso Duarte"
if ($utilizador['nome'] === 'Afonso Duarte' && $_SESSION['nome'] !== 'Afonso Duarte') {
    $_SESSION["erro"] = "A conta 'Afonso Duarte' só pode ser removida pelo próprio utilizador.";
    header("Location: editar_utilizadores.php");
    exit();
}

// Remover o utilizador
$sql_remover = "DELETE FROM utilizadores WHERE id = $id_utilizadores";
$resultado = mysqli_query($con, $sql_remover);

if (!$resultado) {
    $_SESSION["erro"] = "Não foi possível remover o utilizador.";
    header("Location: editar_utilizadores.php");
    exit();
}

// Redirecionar após a remoção
$_SESSION["sucesso"] = "O utilizador foi removido com sucesso.";
header("Location: editar_utilizadores.php");
exit();
?>
