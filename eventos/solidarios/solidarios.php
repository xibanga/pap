<?php

session_start();
include '../../ligabd.php';

$query = "SELECT * FROM eventos WHERE tipo = 'solidario'";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos Desportivos</title>
    <link rel="stylesheet" href="solidarios.css">
    <link rel="icon" type="image/x-icon" href="../../imagens/rodapedaleira2.png">
</head>

<body>
    <!-- Navbar -->
    <header class="navbar">
        
        <div class="image-section">
                <a href="../eventos.php"><img src="../../imagens/rodapedaleira2.png" alt="Roda Pedaleira Logo" class="logo"></a>
        </div>

        <nav>
            <ul class="nav-links">
                <li>
                    <div class="dropdown">
                        <button class="dropbtn">Eventos Solidários</button>
                        <div class="dropdown-content">
                            <a href="#natal-solidario">Natal Solidário</a>
                            <a href="#travessia-sico">Travessia de Sicó</a>
                            <a href="#avalanche">Avalanche</a>
                            <a href="#rota-das-febras">Rota das Febras</a>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Conteúdo Principal -->
    <main class="container">
        <!-- Eiras Single Track -->
        <section id="natal-solidario" class="event-section">
            <div class="text-section">
                <h1>Natal Solidário</h1>

                <li>
                O Eiras Single Track é um percurso de BTT com 25 km, 
                repleto de desafios técnicos, com subidas e descidas emocionantes, 
                ideal para quem busca adrenalina e contato com a natureza. 

                <p></p>

                <li>Localizado em Eiras, Coimbra, é muito procurado por ciclistas, com eventos anuais que atraem participantes de várias regiões.</li>
                </li>
            </div>
            
            <div class="carousel">
                <div class="carousel-images">
               <img src="../../imagens/st/st.jpg" alt="cartaz 2024">
                    <img src="../../imagens/st/st1.jpg" alt="Imagem 2 de Eiras Single Track">
                    <img src="../../imagens/st/st1.jpg" alt="Imagem 2 de Eiras Single Track">
                    <img src="../../imagens/st/st1.jpg" alt="Imagem 2 de Eiras Single Track">
                    <img src="../../imagens/st/st1.jpg" alt="Imagem 2 de Eiras Single Track">
                    <img src="../../imagens/st/st1.jpg" alt="Imagem 2 de Eiras Single Track">
                    <img src="../../imagens/st/st1.jpg" alt="Imagem 2 de Eiras Single Track">
                    <img src="../../imagens/st/st1.jpg" alt="Imagem 2 de Eiras Single Track">
                </div>
                <button class="carousel-prev">&#10094;</button>
                <button class="carousel-next">&#10095;</button>
            </div>
        </section>


        <!-- Travessia de Sicó -->
        <section id="travessia-sico" class="event-section">
            <div class="text-section">
                <h1>Travessia de Sicó</h1>
                <p>
                    Uma travessia épica por paisagens deslumbrantes! Ideal para ciclistas que buscam aventura e superação em trajetos de longa distância.
                </p>
            </div>
            <div class="carousel">
                <div class="carousel-images">
                    <img src="https://via.placeholder.com/600x400" alt="Imagem 1 de Travessia de Sicó">
                    <img src="https://via.placeholder.com/600x400" alt="Imagem 2 de Travessia de Sicó">
                </div>
                <button class="carousel-prev">&#10094;</button>
                <button class="carousel-next">&#10095;</button>
            </div>
        </section>


        <section id="avalanche" class="event-section">
            <div class="text-section">
                <h1>Avalanche Licor-Beirão</h1>
                <p>
                    Uma travessia épica por paisagens deslumbrantes! Ideal para ciclistas que buscam aventura e superação em trajetos de longa distância.
                </p>
            </div>
            <div class="carousel">
                <div class="carousel-images">
                    <img src="https://via.placeholder.com/600x400" alt="Imagem 1 de Avalanche">
                    <img src="https://via.placeholder.com/600x400" alt="Imagem 2 de Avalanche">
                </div>
                <button class="carousel-prev">&#10094;</button>
                <button class="carousel-next">&#10095;</button>
            </div>
        </section>


        <section id="rota das febras" class="event-section">
            <div class="text-section">
                <h1>Rota das Febras</h1>
                <p>
                    Uma travessia épica por paisagens deslumbrantes! Ideal para ciclistas que buscam aventura e superação em trajetos de longa distância.
                </p>
            </div>
            <div class="carousel">
                <div class="carousel-images">
                    <img src="https://via.placeholder.com/600x400" alt="Imagem 1 de Rota das Febras">
                    <img src="https://via.placeholder.com/600x400" alt="Imagem 2 de Rota das Febras">
                </div>
                <button class="carousel-prev">&#10094;</button>
                <button class="carousel-next">&#10095;</button>
            </div>
        </section>


    </main>
    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Roda Pedaleira. Todos os direitos reservados.</p>
        <p><a href="../../paginas/pagina1.php">Voltar à Página Inicial</a></p>
    </footer>

    <script src="../desportivos/carousel.js"></script>
</body>

</html>
