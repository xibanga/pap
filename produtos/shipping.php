<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../imagens/rodapedaleira2.png">
    <title>Informações de Envio - Roda Pedaleira</title>
    <style>
        <style>* {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        /* Navbar */
        .navbar {
            opacity: 0.9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #222;
            padding: 15px;
        }

        .logo img {
            height: 50px;
        }

        /* Conteúdo Principal */
        .container {
            max-width: 900px;
            margin: 40px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h1,
        h2 {
            text-align: center;
            color: #222;
            margin-bottom: 20px;
        }

        .transportadora {
            background: #f9f9f9;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .transportadora p {
            margin: 10px 0;
            line-height: 1.5;
        }

        .botao {
            display: inline-block;
            padding: 10px 15px;
            margin: 10px 5px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }

        .botao:hover {
            background-color: #0056b3;
        }

        /* Footer */
        .footer {
            opacity: 0.9;
            background: #222;
            color: white;
            padding: 20px 0;
            text-align: center;
            margin-top: 50px;
        }

        .footer-content {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .footer-section {
            margin: 10px;
        }

        .footer-section h3 {
            margin-bottom: 10px;
        }

        .footer-section p,
        .footer-section a {
            color: white;
            text-decoration: none;
        }

        .footer-section a:hover {
            text-decoration: underline;
        }

        /* Ícones */
        .icon {
            margin-right: 5px;
        }

        .chat-box {
            border: 2px solid #007bff;
            padding: 10px;
            width: 300px;
            height: 400px;
            overflow-y: scroll;
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: white;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
        }

        .chat-messages {
            flex-grow: 1;
            overflow-y: auto;
            padding: 10px;
            margin-bottom: 10px;
        }

        .chat-input {
            width: 100%;
            padding: 10px;
            border: none;
            box-sizing: border-box;
            border-top: 1px solid #ddd;
        }

        .bot-message {
            color: #007bff;
            font-weight: bold;
        }

        .user-message {
            color: #333;
        }

        .bot-icon {
            color: #007bff;
        }

        .user-icon {
            color: #333;
        }


        /* Reset */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Layout principal */
        .container {
            max-width: 900px;
            margin: 40px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Chatbot */
        .chat-box {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 320px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            transform: scale(0);
            transition: transform 0.3s ease;
        }

        .chat-box.open {
            transform: scale(1);
        }

        .chat-header {
            background: white color: black;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            position: relative;
        }

        .chat-logo {
            height: 30px;
            position: absolute;
            left: 10px;
        }

        .chat-close {
            position: absolute;
            right: 10px;
            background: transparent;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .chat-messages {
            padding: 10px;
            height: 300px;
            overflow-y: auto;
        }

        .chat-option {
            display: block;
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            text-align: left;
            cursor: pointer;
            border-radius: 5px;
        }

        .chat-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #007bff;
            color: white;
            padding: 10px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
        }

        /* Botão Flutuante do Chat */
        .chat-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, background 0.3s ease;
        }

        .chat-toggle:hover {
            background: #0056b3;
            transform: scale(1.1);
        }

        /* Botão de Fechar */
        .close-chat {
            background: none;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
        }

        .close-chat:hover {
            color: #ccc;
        }

        /* Animação para Abrir e Fechar */
        .chat-box.open {
            display: flex;
            transform: translateY(0);
            opacity: 1;
        }
    </style>

</head>

<body>

    <!-- Navbar -->
    <header class="navbar">
        <div class="logo">
            <a href="main_vendas.php"><img src="../imagens/rodapedaleira2.png" alt="Logo"></a>
        </div>
    </header>

    <!-- Conteúdo Principal -->
    <div class="container">
        <h1>📦 Informações de Envio</h1>
        <p><b>Descobre tudo sobre os serviços de transporte, prazos de entrega e como acompanhar a tua encomenda.</b>
        </p>

        <div class="transportadora">
            <h2>🚚 CTT (Correios de Portugal)</h2>
            <p>Os CTT oferecem entregas nacionais e internacionais com horários de distribuição das <b>9h às 18h</b>.
                O prazo de entrega é de <b>2 a 5 dias úteis</b> para envios standard e <b>1 dia útil</b> para serviço
                expresso.</p>
            <p>Os CTT operam com várias opções, incluindo entrega ao domicílio e levantamento em postos autorizados.</p>
            <br>
            <a class="botao" href="https://www.ctt.pt" target="_blank">Visitar CTT</a>
            <a class="botao" href="https://www.ctt.pt/feapl_2/app/open/objectSearch/objectSearch.jspx"
                target="_blank">Seguir Encomenda</a>
        </div>

        <div class="transportadora">
            <h2>✈️ DHL Express</h2>
            <p>A DHL é especializada em entregas rápidas nacionais e internacionais. As entregas standard ocorrem entre
                <b>8h e 20h</b>,
                e o tempo de envio para Portugal é de <b>1 a 2 dias úteis</b>.
            </p>
            <p>Os serviços incluem rastreamento avançado, seguro opcional e entrega prioritária.</p>
            <br>
            <a class="botao" href="https://www.dhl.com/pt-pt/home.html" target="_blank">Visitar DHL</a>
            <a class="botao" href="https://www.dhl.com/pt-pt/home/rastreamento.html" target="_blank">Seguir
                Encomenda</a>
        </div>



        <div class="transportadora">
            <h2>🔄 Política de Devoluções</h2>
            <p>Se não estiver satisfeito com a sua encomenda, poderá devolvê-la em até <b>14 dias úteis</b> após a
                receção. <br>
                <br> Os custos de envio da devolução serão de responsabilidade do cliente, salvo em casos de defeitos ou
                erro de envio. Para mais detalhes, consulte a nossa <a href="politica.php">Política de Devoluções</a>.
            </p>
        </div>

        <div class="transportadora">
            <h2>🔒 Segurança no Envio</h2>
            <p>Garantimos a máxima segurança durante o transporte das encomendas. <br>
                <br>As transportadoras utilizadas oferecem sistemas de rastreamento em tempo real, para que possa
                acompanhar sua encomenda a qualquer momento.<br>
        </div>

        <div class="transportadora">
            <h2>🤝 Suporte ao Cliente</h2>
            <p>Se tiver alguma dúvida ou problema com a sua encomenda, a nossa equipa de apoio ao cliente está
                disponível para ajudar. Pode entrar em contacto conosco através de:</p>
            <br>
            <ul>
                <li><b>Email:</b> <a href="mailto:support@rodapedaleira.com">rodapedaleirapap@gmail.com</a></li>
                <br>
                <li><b>Ajuda:</b> <a href="../paginas/ajuda.php">Ajuda</a></li>
                <br>
                <li><b>Telefone:</b> (+351) 914 928 796</li>
                <br>
                <li><b>Chat ao vivo:</b> Disponível no canto inferior direito da página.</li>
            </ul>
        </div>



        <div class="transportadora">
            <h2>📦 Embalagem dos Produtos</h2>
            <p>Todos os nossos produtos são cuidadosamente embalados para garantir que cheguem em perfeitas condições.
                <br>
                <br> Utilizamos materiais de alta qualidade para proteger os itens durante o transporte, especialmente
                no caso de produtos frágeis.
            </p>
        </div>

        <div class="container">
            <h2>❓ Perguntas Frequentes</h2>
            <br>
            <ul>
                <li><b>Como posso alterar o endereço de entrega?</b><br>Entre em contato conosco o mais rápido possível
                    através do email ou chat ao vivo para alterar a morada de entrega antes que o envio seja feito.</li>
                <br> <br>
                <li><b>O que fazer se minha encomenda estiver atrasada?</b><br>Se o seu pedido não chegar dentro do
                    prazo previsto, por favor entre em contacto conosco e verificaremos o status do seu envio.</li>
            </ul>
        </div>
    </div>


    <!-- Botão para abrir o Chatbot -->
    <button class="chat-toggle" onclick="toggleChat()">
        💬
    </button>

    <!-- Chatbot -->
    <div class="chat-box" id="chatbox">
        <div class="chat-header">
            <img src="../imagens/rodapedaleira.jpg" alt="Logo" class="chat-logo">
            Xibanga Bot 🤖
            <button class="chat-close" onclick="toggleChat()">❌</button>
        </div>
        <div class="chat-messages">
            <br>
            <div class="bot-message">Olá! Sou o assistente da Roda Pedaleira. Como posso ajudar?</div>
            <div class="options">
                <button class="chat-option" onclick="botResponse('Qual o prazo de entrega?')">📦 Qual o prazo de
                    entrega?</button>
                <button class="chat-option" onclick="botResponse('Como posso devolver um produto?')">🔄 Como posso
                    devolver um produto?</button>
                <button class="chat-option" onclick="botResponse('Os envios são rastreados?')">📍 Os envios são
                    rastreados?</button>
                <button class="chat-option" onclick="botResponse('Quais as formas de pagamento?')">💳 Quais as formas de
                    pagamento?</button>
                <button class="chat-option" onclick="botResponse('Onde fica a loja física?')">📍 Onde fica a loja
                    física?</button>
                <button class="chat-option" onclick="botResponse('O que fazer se o pedido atrasar?')">⏳ O que fazer se o
                    pedido atrasar?</button>
            </div>
        </div>
    </div>



</body>

</html>

<!-- Footer -->
<footer class="footer">
    <div class="footer-content">
        <div class="footer-section logo-section">
            <h3>Roda Pedaleira</h3>
            <a href="#">A nossa Equipa</a>
        </div>
        <div class="footer-section contact-section">
            <h3>Contato</h3>
            <p><i class="icon">📍</i> <a href="https://maps.app.goo.gl/xzcDq5eb2nb1xgcQA">Eiras, Coimbra, Portugal</a>
            </p>
            <p><i class="icon">📞</i> (+351) 914 928 796</p>
            <p><i class="icon">📧</i> <a href="https://mail.google.com/">rodapedaleirapap@gmail.com</a></p>
        </div>
        <div class="footer-section links-section">
            <h3>Links</h3>
            <ul>
                <li><a href="#">Afiliados</a></li>
                <li><a href="../codigos/registo/termos/termos.html">Termos e Condições</a></li>
            </ul>
        </div>
    </div>
</footer>


<script>
    function botResponse(question) {
        let chatMessages = document.querySelector(".chat-messages");
        let userMessage = `<div class="user-message">👤 ${question}</div>`;
        let botReply = "";

        if (question.includes("prazo de entrega")) {
            botReply = `<div class="bot-message">📦 O prazo de entrega varia de acordo com o método escolhido pelo utilizador, na finalização da compra.</div>`;
        } else if (question.includes("devolver")) {
            botReply = `<div class="bot-message">🔄 Para devolver um produto, entre em contato pelo nosso email e siga as instruções de envio.</div>`;
        } else if (question.includes("rastreado")) {
            botReply = `<div class="bot-message">📍 Sim! Todas as encomendas incluem um código de rastreamento.</div>`;
        } else if (question.includes("pagamento")) {
            botReply = `<div class="bot-message">💳 Aceitamos pagamentos por MB WAY, e Cartão de Crédito.</div>`;
        } else if (question.includes("loja física")) {
            botReply = `<div class="bot-message">📍  A nossa loja física está localizada em Eiras, Coimbra, Portugal.</div>`;
        } else if (question.includes("pedido atrasar")) {
            botReply = `<div class="bot-message">⏳ Se o seu pedido estiver atrasado, entre em contato conosco pelo chat ou email para verificarmos o estado do seu envio.</div>`;
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



</body>

</html>