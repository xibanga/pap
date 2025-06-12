<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="perfil.css">
    <link rel="icon" type="image/x-icon" href="../imagens/rodapedaleira2.png">
    <title>Perfil do Utilizador</title>
</head>

<body>

    <!-- Navbar -->
    <header>
        <div class="navbar">
            <div class="logo">
                <a href="../paginas/pagina1.php"><img src="../imagens/rodapedaleira2.png" alt="Logo"></a>
            </div>
        </div>
    </header>


    <div class="container">
        <!-- Lado Esquerdo: Foto de Perfil -->
        <div class="profile-section">
            <div class="profile-card">
                <img id="foto_perfil" alt="Foto Perfil" class="foto-perfil">
                <h2><?php echo $_SESSION['nome']; ?></h2>
                <p><?php echo $_SESSION['email']; ?></p>
                <br>
                <form id="upload-form" method="post" enctype="multipart/form-data" action="upload_foto.php">
                    <input type="hidden" name="id_utilizadores" value="<?php echo $_SESSION['id']; ?>">
                    <input type="file" name="foto_perfil" accept="image/*" required>
                    <button type="submit" name="botaoUpload">Carregar Nova Foto</button>
                </form>
            </div>
        </div>

        <!-- Lado Direito: Edição do Perfil -->
        <div class="details-section">
            <h2>Perfil do Utilizador</h2>
            <form id="form" method="post">
                <div class="info">
                    <label>Nome:</label>
                    <input name="nome" type="text" value="<?php echo $_SESSION['nome']; ?>">
                </div>
                <div class="info">
                    <label>Palavra-passe:</label>
                    <input name="palavra_passe" type="password" placeholder="Nova Palavra-passe">
                </div>
                <div class="info">
                    <label>Email:</label>
                    <input name="email" type="email" value="<?php echo $_SESSION['email']; ?>">
                </div>
                <br>
                <button type="submit" formaction="gravar.php" name="botaoGravar">Guardar Alterações</button>
            </form>
        </div>
    </div>
 

</body>


<script>
    var foto_perfil = "../fotos_perfil/<?php echo $_SESSION['id_foto_perfil']; ?>";
    document.getElementById("foto_perfil").src = foto_perfil;
</script>

</html>



