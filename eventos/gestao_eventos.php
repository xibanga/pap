<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="gestao_eventos.css">
    <link rel="icon" type="image/x-icon" href="../imagens/rodapedaleira2.png">
    <title>Gestão de Eventos</title>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <a href="eventos.php"><img src="../imagens/rodapedaleira2.png" alt="Roda Pedaleira Logo" class="logo"></a>
        </div>
        <ul class="menu">
            <li><a href="eventos.php">Eventos</a></li>
            <li><a href="../paginas/ajuda.php">Contato</a></li>
        </ul>
    </nav>

    <!-- Formulário de Criação de Evento -->
    <div class="container">
        <div class="text-section">
            <h1>Criar Novo Evento</h1>
            
            <!-- Exibir mensagem de erro/sucesso -->
            <?php if(isset($_SESSION['mensagem'])): ?>
                <p style="color: green;"><?php echo $_SESSION['mensagem']; unset($_SESSION['mensagem']); ?></p>
            <?php endif; ?>
            
            <?php if(isset($_SESSION['erro'])): ?>
                <p style="color: red;"><?php echo $_SESSION['erro']; unset($_SESSION['erro']); ?></p>
            <?php endif; ?>

            <form action="processar_evento.php" method="post" class="form-evento" enctype="multipart/form-data">
                <label for="nome_evento">Nome do Evento:</label>
                <input type="text" id="nome_evento" name="nome_evento" required>

                <label for="tipo_evento">Tipo de Evento:</label>
                <select id="tipo_evento" name="tipo" required>
                    <option value="desportivo">Desportivo</option>
                    <option value="solidario">Solidário</option>
                </select>

                <label for="data_evento">Data do Evento:</label>
                <input type="date" id="data_evento" name="data_evento" required>

                <label for="hora_evento">Hora do Evento:</label>
                <input type="time" id="hora_evento" name="hora_evento" required>

                <label for="localizacao">Localização do Evento:</label>
                <input type="text" id="localizacao" name="localizacao" required>

                <label for="descricao">Descrição do Evento:</label>
                <textarea id="descricao" name="descricao" required></textarea>

                <label for="imagem">Imagem do Evento:</label>
                <input type="file" id="imagem" name="imagem" accept="image/*" required>
                
                <button type="submit" class="submit-button">Criar Evento</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section logo-section">
                <h3>Roda Pedaleira</h3>
                <a href="#">A nossa Equipa</a>
            </div>
            <div class="footer-section contact-section">
                <h3>Contacto</h3>
                <p><i class="icon">📍</i> <a href="https://maps.app.goo.gl/xzcDq5eb2nb1xgcQA">Eiras, Coimbra, Portugal</a></p>
                <p><i class="icon">📞 <br></i> (+351) 914 928 796</p>
                <p><i class="icon">📧</i> <a href="https://mail.google.com/">rodapedaleirapap.com</a></p>
            </div>
            <div class="footer-section links-section">
                <h3>Links</h3>
                <ul>
                    <li><a href="#">Afiliados</a></li>
                    <li><a href="http://localhost/PAP/codigos/registo/termos/termos.html">Termos e Condições</a></li>
                </ul>
            </div>
        </div>
    </footer>
</body>
</html>
