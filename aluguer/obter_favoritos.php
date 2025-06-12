<?php
session_start();
include('../ligabd.php'); // Conectar ao banco de dados

$user_id = $_SESSION['user_id']; // Certifica-te que o usuário está logado

$sql = "SELECT b.modelo FROM favoritos f 
        JOIN bicicletas b ON f.bicicleta_id = b.id
        WHERE f.user_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$favoritos = [];
while ($row = $result->fetch_assoc()) {
    $favoritos[] = $row;
}

echo json_encode($favoritos);
?>
