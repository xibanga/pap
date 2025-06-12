<?php

// Conexão com a base de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rodapedaleira";

$con = new mysqli($servername, $username, $password, $dbname);

if ($con->connect_error) {
    die("Erro de conexão: " . $con->connect_error);
}

?>