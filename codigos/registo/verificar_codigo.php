<?php
session_start();

// Verificar se o código foi enviado ao e-mail
if (!isset($_SESSION["codigoVerificacao"])) {
    header("Location: registo.php");
    exit();
}

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $codigoInserido = $_POST["codigo"];

    // Validar o código
    if ($_SESSION["codigoVerificacao"] == $codigoInserido) {
        include "../../ligabd.php";

        // Recuperar os dados do utilizador
        $dados = $_SESSION["dadosUtilizador"];

        // Inserir os dados na base de dados
        $nome = $dados['nome'];
        $email = $dados['email'];
        $nif = $dados['nif']; // garantir que já está definido

        $sql = "INSERT INTO utilizadores (
            id, nome, email, palavra_passe, nif, telefone, codigo_postal, genero, data_nascimento,
            id_tipos_utilizador, reset_token, token_expiry, id_foto_perfil
        ) VALUES (
            NULL, '$nome', '$email', PASSWORD('" . $dados['palavra_passe'] . "'), '$nif',
            '" . $dados['telefone'] . "', '" . $dados['codigo_postal'] . "', '" . $dados['genero'] . "',
            '" . $dados['data_nascimento'] . "', '" . $dados['id_tipos_utilizador'] . "',
            NULL, NULL, '" . $dados['id_foto_perfil'] . "'
        )";
        

        var_dump($sql);

        if (mysqli_query($con, $sql)) {
            // Limpar sessão e redirecionar
            unset($_SESSION["codigoVerificacao"]);
            unset($_SESSION["dadosUtilizador"]);
            $_SESSION["sucesso"] = "Conta criada com sucesso!";
            header("Location: ../../index.php");
            exit();
        } else {
            $_SESSION["erro"] = "Erro ao criar conta. Tente novamente mais tarde.";
        }
    } else {
        $_SESSION["erro"] = "Código incorreto. Por favor, tente novamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação de Código</title>
    <link rel="stylesheet" href="registo.css">
    <link rel="icon" type="image/x-icon" href="../../imagens/rodapedaleira2.png">
</head>

<body>
    <div class="container">
        <!-- Imagem da roda pedaleira -->
        <div class="image-section">
            <a href="../../"><img src="../../imagens/rodapedaleira2.png" alt="Roda Pedaleira"></a>
        </div>

        <!-- Formulário -->
        <div class="form-section">
            <h2>Verificação de Código</h2>
            <p>Insira o código de verificação enviado para o e-mail.</p>

            <?php
            if (isset($_SESSION["erro"])) {
                echo "<p style='color: red;'>{$_SESSION['erro']}</p>";
                unset($_SESSION["erro"]);
            }

            // Exibir mensagem de sucesso (reenvio do código)
            if (isset($_SESSION["sucesso"])) {
                echo "<p style='color: green;'>{$_SESSION['sucesso']}</p>";
                unset($_SESSION["sucesso"]);
            }

            ?>

            <form action="" method="POST">
                <input type="text" name="codigo" placeholder="Código de Verificação" required>
                <br>
                <button type="submit">Concluir Registo</button>
            </form>

            <br>
            <p>Não recebeu o código? <a href="reenviar_codigo.php">Reenviar código</a></p>
        </div>
    </div>


</body>

</html>