<?php
session_start();
require "../ligabd.php"; // Conexão com o banco de dados

// Remover dos favoritos
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remover_dos_favoritos'])) {
    $produto_id = $_POST['produto_id'];
    if (($key = array_search($produto_id, $_SESSION['favoritos'])) !== false) {
        unset($_SESSION['favoritos'][$key]);
    }
    header("Location: favoritos.php");
    exit();
}

// Obter detalhes dos produtos favoritos
$favoritos = [];
if (isset($_SESSION['favoritos']) && count($_SESSION['favoritos']) > 0) {
    $ids = implode(',', $_SESSION['favoritos']);
    $query = "SELECT * FROM produtos WHERE id IN ($ids)";
    $resultado = mysqli_query($con, $query);
    while ($produto = mysqli_fetch_assoc($resultado)) {
        $favoritos[] = $produto;
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="favoritos.css">
    <link rel="icon" type="image/x-icon" href="../imagens/rodapedaleira2.png">
    <title>Favoritos</title>
</head>

<body>
    <header>
        <div class="navbar">
            <div class="logo">
                <a href="main_vendas.php"><img src="../imagens/rodapedaleira2.png" alt="Logo" ></a>
            </div>
        </div>
    </header>

    <main class="favoritos">
        <h2>Favoritos</h2>
        <table class="tabela-produtos">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th onclick="sortTable(1)">Nome</th>
                    <th onclick="sortTable(2)">Preço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($favoritos) > 0): ?>
                    <?php foreach ($favoritos as $produto): ?>
                        <tr>
                            <td><img src="../imagens/<?php echo $produto['imagem']; ?>" alt="<?php echo $produto['nome']; ?>" class="produto-imagem"></td>
                            <td><a href="detalhes_produto.php?id=<?php echo $produto['id']; ?>"><?php echo $produto['nome']; ?></a></td>
                            <td>€<?php echo number_format($produto['preco'], 2); ?></td>
                            <td>
                                <form method="post" action="favoritos.php">
                                    <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
                                    <button type="submit" class="btn-remover" name="remover_dos_favoritos">Remover</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Não há produtos nos favoritos.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

    <script>
        function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.querySelector(".tabela-produtos");
            switching = true;
            dir = "asc"; 
            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }
    </script>
</body>

</html>