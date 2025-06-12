<?php
session_start();

if (!isset($_POST["botaoGravar"]) || !isset($_SESSION["nome"]) || $_SESSION["id_tipos_utilizador"] != 0) {
    header("Location: editar_utilizadores.php");
    exit();
}

require "../ligabd.php";

if (!empty($_POST["palavra_passe"])) {
    
    
    $query = "UPDATE utilizadores SET palavra_passe = PASSWORD(?), nome = ?, id_tipos_utilizador = ? WHERE email = ?";
    if ($stmt = $con->prepare($query)) {
        $stmt->bind_param("ssis", $_POST["palavra_passe"], $_POST["nome"], $_POST["id_tipos_utilizador"], $_POST["email"]);
    }  
    else {
        $_SESSION["erro"] = "Erro na preparação da consulta.";
        header("Location: editar_utilizadores.php");
        exit();
    }


} else {

    $query = "UPDATE utilizadores SET nome = ?, id_tipos_utilizador = ? WHERE email = ?";
    if ($stmt = $con->prepare($query)) {
        $stmt->bind_param("sis", $_POST["nome"], $_POST["id_tipos_utilizador"], $_POST["email"]);
    } 
    
    else {
        $_SESSION["erro"] = "Erro na preparação da consulta.";
        header("Location: editar_utilizadores.php");
        exit();
    }
}


if (!$stmt->execute()) {
    $_SESSION["erro"] = "Não foi possível editar os dados do utilizador.";
    $stmt->close();
    header("Location: editar_utilizadores.php");
    exit();
}

// fecha
$stmt->close();

// Redirecionar de volta para a página de edição dos utilizadores
header("Location: editar_utilizadores.php");
exit();
?>
