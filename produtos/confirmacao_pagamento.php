<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="pagamento.css">
    <link rel="icon" type="image/x-icon" href="../imagens/rodapedaleira2.png">
    <title>Confirmação de Pagamento</title>
</head>

<body>

    <header>
        <div class="logo">
            <a href="../paginas/pagina1.php"><img src="../imagens/rodapedaleira2.png" alt="Logo"></a>
        </div>
    </header>

    <main>
        <h1>Confirmação de Pagamento</h1>
        <?php if (isset($_SESSION['mensagem'])): ?>
            <p><?php echo $_SESSION['mensagem']; unset($_SESSION['mensagem']); ?></p>
        <?php else: ?>
            <p>Pagamento realizado com sucesso!</p>
        <?php endif; ?>
        <a href="main_vendas.php">Voltar às Compras</a>
    </main>

</body>

</html>