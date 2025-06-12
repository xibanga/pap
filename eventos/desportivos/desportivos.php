<?php

session_start();
include '../../ligabd.php';

$query = "SELECT * FROM eventos WHERE tipo = 'desportivo'";
$result = mysqli_query($con, $query);
?>


<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos Solidários</title>
    <link rel="stylesheet" href="desportivos.css">
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
                        <button class="dropbtn">Eventos Desportivos</button>
                        <div class="dropdown-content">
                            <a href="#eiras-single-track">Eiras Single Track</a>
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
        <section id="eiras-single-track" class="event-section">
            <div class="text-section">
                <h1>Eiras Single Track</h1>

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
                    <li>A Travessia de Sicó é um evento de BTT organizado pela Roda Pedaleira,
                    realizado em dois dias. 
                    <p></p>
                    <li>No primeiro dia, os participantes partem de Condeixa,
                    percorrem inúmeros kilómetros pela Serra de Sicó e terminam a etapa na serra,
                    onde passam a noite. 
                    <p></p>
                    <li>No segundo dia, seguem para Conímbriga, 
                    com chegada prevista para a tarde. 
                    <p></p>
                    <li>Durante todo o percurso,
                    há carrinhas de apoio para garantir o suporte necessário.
                </p>
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


        <!-- Avalanche Lousã -->
        <section id="avalanche" class="event-section">
            <div class="text-section">
                <h1>Avalanche Licor-Beirão</h1>
                <p>
                <li>A rota conhecida como "Avalanche na Lousã" é um desafio mais exigente para os ciclistas de BTT,
                com trilhos empolgantes e técnicas, ideais para quem busca adrenalina. O terreno acidentado,
                com subidas íngremes e descidas vertiginosas, proporciona um desafio perfeito para quem se considera experiente.
                <p></p>
                <li>As vistas ao longo do percurso também não decepcionam </li>              
            </p>
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



        <!-- Rota das Febras -->
        <section id="rota-das-febras" class="event-section">
            <div class="text-section">
                <h1>Rota das Febras</h1>
                <p>
                <li>A Rota das Febras é um evento de BTT organizado pela Roda Pedaleira, 
                que combina o prazer do ciclismo com momentos de confraternização.
                <p></p> 
                <li>Realizado no dia 1 de novembro, o percurso começa em Eiras, Coimbra, e percorre os trilhos da zona. 
                <p></p>
                <li>O evento é conhecido pela tradicional paragem para uma refeição de febras grelhadas.
                <p></p> 
                <li>O passeio é descontraído e focado na diversão, com espírito de equipa e amizade entre os participantes.
                </p>
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


    </main>
    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Roda Pedaleira. Todos os direitos reservados.</p>
        <p><a href="../../paginas/pagina1.php">Voltar à Página Inicial</a></p>
    </footer>

    <script src="carousel.js"></script>
</body>

</html>
