<?php
session_start();

if (isset($_SESSION['nome'])) {
    header("Location: terminarsessao.php");
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Roda Pedaleira</title>
    <link rel="icon" type="image/x-icon" href="imagens/rodapedaleira2.png">
    <link rel="stylesheet" href="index.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
</head>

<body>

    <!-- Navbar -->
    <header>
        <img src="imagens/rodapedaleira2.png" alt="Roda Pedaleira Logo" class="logo">
        <div>
            <a href="codigos/registo/registo.php" class="button">Registar</a>
            <a href="codigos/login/login.php" class="button">Entrar</a>
        </div>
    </header>



    <!-- Main Content -->
    <main>


        <div class="carousel">
            <div class="carousel-images">
                <img src="imagens/tigre.jpg" alt="cartaz 2024">
                <img src="imagens/tigre1.jpg" alt="cartaz 2024">
                <img src="imagens/tigre2.jpg" alt="cartaz 2024">
                <img src="imagens/tigre3.jpg" alt="cartaz 2024">
                <img src="imagens/tigre10.jpg" alt="cartaz 2024">
                <img src="imagens/tigre4.jpg" alt="cartaz 2024">
                <img src="imagens/tigre5.jpg" alt="cartaz 2024">
                <img src="imagens/tigre6.jpg" alt="cartaz 2024">
                <img src="imagens/tigre7.jpg" alt="cartaz 2024">
                <img src="imagens/tigre8.jpg" alt="cartaz 2024">
                <img src="imagens/tigre9.jpeg" alt="cartaz 2024">
                <img src="imagens/tigre10.jpg" alt="cartaz 2024">
                <img src="imagens/tigre11.jpg" alt="cartaz 2024">
                <img src="imagens/tigre12.jpg" alt="cartaz 2024">
                <img src="imagens/tigre13.jpg" alt="cartaz 2024">
                <img src="imagens/tigre14.jpg" alt="cartaz 2024">
                <img src="imagens/tigre.jpg" alt="cartaz 2024">
                <img src="imagens/tigre1.jpg" alt="cartaz 2024">
                <img src="imagens/tigre2.jpg" alt="cartaz 2024">
                <img src="imagens/tigre3.jpg" alt="cartaz 2024">
                <img src="imagens/tigre.jpg" alt="cartaz 2024">



            </div>
            <button class="carousel-prev">&#10094;</button>
            <button class="carousel-next">&#10095;</button>
        </div>
        </section>

        <!-- Video Section -->
        <div class="video-section">
            <h2>Roda Pedaleira ShortMovie</h2>
            <iframe src="imagens/eiras.mp4" frameborder="0"
                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
        </div>

        <!-- Botão para abrir o Chatbot -->
        <button class="chat-toggle" onclick="toggleChat()">
            💬
        </button>


        <!-- Chatbot -->
        <div class="chat-box" id="chatbox">
            <div class="chat-header">
                <img src="imagens/rodapedaleira.jpg" alt="Logo" class="chat-logo">
                <button class="chat-close" onclick="toggleChat()">❌</button>
            </div>

            <div class="chat-messages">

                <br>
                <br>

                <div class="bot-message">Olá! Sou o assistente da Roda Pedaleira. Como posso ajudar?</div>

                <div class="options">
                    <button class="chat-option" onclick="botResponse('O que é a Roda Pedaleira?')">🚴‍♂️
                        O que é a Roda Pedaleira?
                    </button>


                    <button class="chat-option" onclick="botResponse('Preciso de criar uma conta para aceder ao conteúdo do site?')"> 👤  
                        Preciso de criar uma conta para aceder ao conteúdo do site?
                    </button>


                    <button class="chat-option" onclick="botResponse('Onde fica localizada a Sede da Roda Pedaleira?')">📍 
                        Onde fica localizada a Sede da Roda Pedaleira?
                    </button>


                    <button class="chat-option" onclick="botResponse('A Roda Pedaleira também vende Roupa?')"> 👕 
                    A Roda Pedaleira também vende Roupa?
                    </button>

                </div>
            </div>
        </div>



        <!-- Digital Flyer Section -->
        <div class="flyer">
            <img src="imagens/rodapedaleira.png" alt="Ciclaveiro">
            <h2>Conheça a nossa associação</h2>
            <h3>Clique para entrar, o melhor do ciclismo vai encontrar!</h3>
            <a href="codigos/login/login.php" class="button">Saber Mais</a>
        </div>
    </main>









    <br>
    <br>
    <br>
    <br>
    <br>
    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>Roda Pedaleira</h3>
                <a href="sobrenos/sobrenos.html">A nossa Equipa</a>
            </div>
            <div class="footer-section">
                <h3>Contato</h3>
                <p><i class="icon">📍</i> <a href="https://maps.app.goo.gl/xzcDq5eb2nb1xgcQA">Eiras, Coimbra,
                        Portugal</a></p>
                <p><i class="icon">📞</i> (+351) 914 928 796</p>
                <p><i class="icon">📧</i> <a href="mailto:rodapedaleirapap.com">rodapedaleirapap.com</a></p>
            </div>
            <div class="footer-section">
                <h3>Links</h3>
                <ul>
                    <li><a href="http://localhost/PAP/codigos/registo/termos/termos.html" color="white">Termos e
                            Condições</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script>
        function botResponse(question) {
            let chatMessages = document.querySelector(".chat-messages");
            let userMessage = `<div class="user-message">👤 ${question}</div>`;
            let botReply = "";

            if (question.includes("O que é a Roda Pedaleira?")) {
                botReply = `<div class="bot-message">🚴‍♂️ A Roda Pedaleira é uma associação de BTT, que procura despertar o interesse pelo mundo aventureiro nas pessoas.</div>`;
            } 
            
            else if (question.includes("Preciso de criar uma conta para aceder ao conteúdo do site?")) {
                botReply = `<div class="bot-message">🔄  Sim, para aceder ao conteúdo principal do site, tem de ter sessão iniciada . <a href="http://localhost/PAP/codigos/registo/registo.php">Para isso basta criar uma conta no nosso site
                            </a> </div>`;

            } else if (question.includes("Onde fica localizada a Sede da Roda Pedaleira?")) {
                botReply = `<div class="bot-message">📍 A Sede da Roda Pedaleira fica localizada em <a href="https://maps.app.goo.gl/viCFXKeH4VxRVGHN8">Eiras, Coimbra, Portugal </a></div>`;
            } else if 
            
            (question.includes("A Roda Pedaleira também vende Roupa?")) {
                botReply = `<div class="bot-message">👕 Sim, a Roda Pedaleira também tem a sua merchendise, mas para descobrir mais <a href="http://localhost/PAP/codigos/registo/registo.php"> tens de te tornar um membro Pedaleira! </a></div>`;
            } 
            

            chatMessages.innerHTML += userMessage + botReply;
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function toggleChat() {
            let chatbox = document.getElementById("chatbox");
            chatbox.classList.toggle("open");
        }


        function toggleChat() {
            let chatbox = document.getElementById("chatbox");
            chatbox.classList.toggle("open");

            // Alterna o botão quando a chatbox é aberta ou fechada
            let chatButton = document.querySelector(".chat-toggle");
            if (chatbox.classList.contains("open")) {
                chatButton.innerHTML = "❌"; // Ícone de fechar
            } else {
                chatButton.innerHTML = "💬"; // Ícone de chat
            }
        }
    </script>


    <script src="eventos/desportivos/carousel.js"></script>


</body>

</html>