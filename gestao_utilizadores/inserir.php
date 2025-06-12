<?php

session_start();

if(!isset ($_POST["botaoInserir"]) || !isset ($_SESSION["nome"])  || $_SESSION["id_tipos_utilizador"]!=0){
    header("Location: editar_utilizadores.php");
    exit();
}

require "../ligabd.php";

$sql_inserir= "INSERT INTO utilizadores VALUES
        (null, '" . $_POST["nome"] . "', '" . $_POST["email"] . "', password(" . $_POST["palavra_passe"] . "),
        '0', '2222-222', 'Outro', 
        '01/01/2000',  '" . $_POST["id_tipos_utilizador"] . "', 
        '0', null, null )";

$resultado = mysqli_query($con, $sql_inserir);

if (!$resultado){
    $_SESSION["erro"] = "Não foi possivel inserir o utilizador.";
    header("Location: index.php");
    exit();
 }

 header("Location: editar_utilizadores.php");