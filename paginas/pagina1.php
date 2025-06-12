<?php

session_start(); // Inicia a sessão

include('../ligabd.php'); // Conexão com o banco de dados


?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roda Pedaleira</title>
    <link rel="icon" type="image/x-icon" href="../imagens/rodapedaleira2.png">
    <link rel="stylesheet" href="pagina1.css">
</head>

<body>
    <!-- Navbar -->
    <header class="navbar">
        <div class="left">

            <a href="ajuda.php"><img src="../imagens/ajuda.png" alt="Ajuda" class="logo"></a>

            <!-- Botão do Painel de Utilizadores, visível apenas para administradores -->
            <?php if (isset($_SESSION["id_tipos_utilizador"]) && $_SESSION["id_tipos_utilizador"] == 0): ?>
                <a href="../gestao_utilizadores/editar_utilizadores.php" class="painel-botao">Painel de Utilizadores</a>
            <?php endif; ?>
        </div>


        <div class="left">
            <?php echo $_SESSION["nome"];
            if (!isset($_SESSION['id_foto_perfil'])) {
                $_SESSION['id_foto_perfil'] = '0.jpg'; // Defina a foto padrão se não estiver definida
            }
            ?>

            <a href="../perfil/perfil.php" class="foto_perfil"><img id="foto_perfil" alt="Foto Perfil"
                    class="foto_perfil">
            </a>



            <!-- Botão para terminar sessão -->
            <a href="../paginas/logout.php" class="logout-botao"> Terminar Sessão </a>
        </div>
    </header>


    <!-- Tela inicial com imagem de fundo -->
    <main style="min-height: 100vh; justify-content: center; align-items: center; display: flex;">
        <div class="container">
            <div><img src="../imagens/rodapedaleira2.png" alt="Roda Pedaleira" class="rodapedaleira2"
                    style="height: 200px; width: auto;"></div>

            <div class="menu">

                <!-- Informações -->
                <a class="menu-item" href="http://localhost/PAP/sobrenos/sobrenos.html">
                    <img src="../imagens/sobrenos.png" alt="Sobre Nós" class="icon">
                    <p> Sobre Nós </p>
                </a>


                <a class="menu-item" href="../eventos/eventos.php">
                    <img src="../imagens/evento.png" alt="Eventos" class="icon">
                    <p>Eventos</p>
                </a>


                <!-- Diversões -->
                <a class="menu-item vendas" href="http://localhost/PAP/trilhos_app_final/index.php">
                    <img src="../imagens/trilho.png" alt="Trilhos" class="icon">
                    <p>Trilhos</p>
                </a>

                <!-- Vendas -->
                <a class="menu-item vendas" href="http://localhost/PAP/produtos/main_vendas.php">
                    <img src="../imagens/merch.png" alt="Merch" class="icon">
                    <p>Vendas</p>
                </a>

                <a class="menu-item" href="../aluguer/aluguer.php">
                    <img src="../imagens/bike.png" alt="Bicicletas" class="icon">
                    <p>Aluguer de Bicicletas</p>
                </a>



            </div>




            <!-- Ícones de redes sociais -->
            <div class="social-icons">
                <a href="https://www.instagram.com/rodapedaleiraoficial/"><img src="../imagens/insta.png"
                        alt="Instagram">
                </a>
                <a href="https://www.facebook.com/search/top?q=roda%20pedaleira&locale=pt_PT"><img
                        src="../imagens/facebook.png" alt="Facebook"></a>
                <a href="https://www.youtube.com/@RPedaleira"><img src="../imagens/youtube.png" alt="Youtube"></a>
            </div>
        </div>
    </main>







    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section logo-section">
                <h3>Roda Pedaleira</h3>
                <a href="../sobrenos/sobrenos.html">A nossa Equipa</a>
            </div>
            <div class="footer-section contact-section">
                <h3>Contato</h3>
                <p><i class="icon">📍</i> <a href="https://maps.app.goo.gl/xzcDq5eb2nb1xgcQA">Eiras, Coimbra,
                        Portugal</a></p>
                <p><i class="icon">📞</i> (+351) 914 928 796</p>
                <p><i class="icon">📧</i> <a href="https://mail.google.com/">rodapedaleirapap@gmail.com</a></p>
            </div>
            <div class="footer-section links-section">
                <h3>Links</h3>
                <ul>
                    <li><a href="http://localhost/PAP/codigos/registo/termos/termos.html">Termos e Condições </a></li>
                </ul>
            </div>
        </div>
    </footer>
</body>

</html>

<script>
    var foto_perfil = "../fotos_perfil/<?php echo $_SESSION['id_foto_perfil']; ?>";
    var default_foto = "../fotos_perfil/0.jpg";
    var img = new Image();
    img.onload = function () {
        document.getElementById("foto_perfil").src = foto_perfil;
    }
    img.onerror = function () {
        document.getElementById("foto_perfil").src = default_foto;
    }
    img.src = foto_perfil;
</script>