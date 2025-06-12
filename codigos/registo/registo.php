<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registo de Utilizador</title>
    <link rel="stylesheet" href="registo.css">
    <link rel="icon" type="image/x-icon" href="../../imagens/rodapedaleira2.png">
</head>

<body>

    <!-- Container principal -->
    <div class="container">
        <!-- Imagem da roda pedaleira -->
        <div class="image-section">
            <a href="../../"><img src="../../imagens/rodapedaleira2.png" alt="Roda Pedaleira"></a>
        </div>

        <!-- Formulário -->
        <div class="form-section">
            <h2>Registo de Utilizador</h2>

            <!-- Exibir mensagens de erro ou sucesso -->
            <?php if (isset($_SESSION["erro"])): ?>
                <p style="color: red;"><?= $_SESSION["erro"];
                unset($_SESSION["erro"]); ?></p>
            <?php endif; ?>

            <?php if (isset($_SESSION["sucesso"])): ?>
                <p style="color: green;"><?= $_SESSION["sucesso"];
                unset($_SESSION["sucesso"]); ?></p>
            <?php endif; ?>

            <!-- Formulário de Registo -->
            <form action="submit.php" method="POST">
                <!-- Campos lado a lado -->
                <div class="form-row">
                    <input type="text" name="nome1" placeholder="Primeiro Nome" required>
                    <input type="text" name="nome2" placeholder="Último Nome" required>
                </div>
                <div class="form-row">
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="tel" name="telefone" placeholder="Telefone" required>
                </div>
                <div class="form-row">
                    <input type="password" name="palavra_passe" placeholder="Palavra-passe" required>
                    <input type="password" name="confirm_password" placeholder="Confirmar Palavra-passe" required>
                </div>
                <div class="form-row">
                    <input type="text" name="nif" placeholder="NIF" maxlength="9" pattern="\d{9}"
                        title="Insira um NIF válido com 9 dígitos" required>
                </div>
                <div style="margin-top: 10px;"></div>
                <div class="form-row">
                    <label>Data de Nascimento:</label>
                </div>
                <div style="margin-top: -15px;"></div>
                <div class="form-row">
                    <input type="date" name="data_nascimento" required>
                    <input type="text" name="codigo_postal" placeholder="Código-Postal" required>
                </div>
                <div style="display: flex; align-items: center; gap: 80px;">
                    <div>
                        <label>Gênero:</label>
                        <input type="radio" name="genero" value="Masculino" required> Masculino
                        <input type="radio" name="genero" value="Feminino" required> Feminino
                        <input type="radio" name="genero" value="Outro" required> Outro
                    </div>
                    <div>
                        <br>
                        <input type="radio" name="termos" value="condicoes" required>
                        Aceito os <a href="http://localhost/PAP/codigos/registo/termos/termos.html">Termos e
                            Condições</a> do Site
                    </div>
                </div>
                <br>
                <button type="submit">Registar</button>
            </form>

            <!-- Formulário de Verificação do Código -->
            <?php if (isset($_SESSION["codigoVerificacao"])): ?>
                <div class="code-verification">
                    <h2>Verificação de Código</h2>
                    <p>Insira o código de verificação enviado para o seu e-mail.</p>

                    <form action="verificar_codigo.php" method="POST">
                        <input type="text" name="codigo" placeholder="Código de Verificação" required>
                        <button type="submit">Concluir Registo</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>