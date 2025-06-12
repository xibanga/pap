<?php
// verificar se ja existe sessao inciada
//ou se o utilizador nao clicou no botao de login

session_start();


if (isset($_SESSION["utilizador"]) || !isset($_POST["botaoLogin"])) {
    header("Location: ../../index.php");
    exit();
}

include "../../ligabd.php";

$sql = "SELECT * FROM utilizadores WHERE email='" . $_POST["email"] . "'";

$resultado = mysqli_query($con, $sql);

if (!$resultado) {
    $_SESSION["erro"] = "Não foi possível obter os dados do utilizador.";
    header("Location : login.php");
    exit();
}

if ($registo = mysqli_fetch_array($resultado)) {

    $sqlpass = "SELECT * FROM utilizadores WHERE email='" . $_POST["email"] . "' && palavra_passe=password('" . $_POST["password"] . "')";

    $resultado_pass = mysqli_query($con, $sqlpass);

    if (!$resultado_pass) {
        $_SESSION["erro"] = "Não foi possível verificar os dados do utilizador.";
        header("Location: login.php");
        exit();
    }

    if ($registo = mysqli_fetch_array($resultado_pass)) {
        // o utilizador e a password estao corretos
        // inicar sessao
        $_SESSION = $registo;
        header("Location: ../../paginas/pagina1.php");
    } else {
        $_SESSION["erro"] = "A palavra-passe está incorreta.";
        header("Location: login.php");
        exit();
    }


} else {
    // o utilizador nao existe
    $_SESSION["erro"] = "O utilizador nao existe. ";
    header("Location: login.php ");
    exit();
}

?>