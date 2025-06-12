<?php
session_start();
require "../ligabd.php"; // Conexão com o banco de dados

// Adicionar produto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adicionar'])) {
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $descricao = $_POST['descricao'];
    $categoria = $_POST['categoria'];
    $destaque = $_POST['destaque'];
    $imagem = $_FILES['imagem']['name'];
    $target_imagem = "../imagens/" . basename($imagem);

    // Inserir produto no banco de dados
    $query = "INSERT INTO produtos (nome, preco, descricao, categoria, destaque, imagem) VALUES ('$nome', '$preco', '$descricao', '$categoria', '$destaque', '$imagem')";
    mysqli_query($con, $query);

    // Mover arquivo de imagem
    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $target_imagem)) {
        $_SESSION['mensagem'] = "Produto adicionado com sucesso!";
    } else {
        $_SESSION['mensagem'] = "Falha ao adicionar produto!";
    }
}

// Remover produto
if (isset($_GET['remover'])) {
    $id = $_GET['remover'];
    $query = "DELETE FROM produtos WHERE id = $id";
    mysqli_query($con, $query);
    $_SESSION['mensagem'] = "Produto removido com sucesso!";
    header("Location: adicionar_equipamento.php");
    exit();
}

// Consulta para obter produtos
$query = "SELECT * FROM produtos";
$resultado = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="adicionar_equipamento.css">
    <link rel="icon" type="image/x-icon" href="../imagens/rodapedaleira2.png">
    <title>Adicionar Equipamento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            /* Aumentar a largura do container */
            max-width: 1200px;
            /* Definir uma largura máxima */
            margin: auto;
            overflow: hidden;
        }

        h1,
        h2 {
            text-align: center;
            color: #333;
        }

        .mensagem {
            background: #4CAF50;
            color: white;
            padding: 10px;
            margin-bottom: 20px;
            text-align: center;
        }

        form {
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        form input[type="text"],
        form textarea,
        form select,
        form input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        form button {
            background: #333;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        form button:hover {
            background: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: white;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background: #333;
            color: white;
            cursor: pointer;
        }

        tr:hover {
            background: #e9e9e9;
        }

        .search-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-container input {
            width: 50%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .btn-remover {
            width: 100%;
            padding: 0.8rem;
            background: linear-gradient(145deg, #0a196e, #1a1672);
            border: none;
            border-radius: 8px;
            text-decoration: none;
            color: #ffffff;
            font-weight: bold;
            cursor: pointer;
            text-shadow: 0px 1px 3px #000;
            box-shadow: 2px 2px 5px #1a1a1a, -2px -2px 5px #3a3a3a;
            transition: transform 0.3s ease, box-shadow;
            display: block;
            text-align: center;
        }

        td.actions {
            text-align: center;
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <a href="main_vendas.php"><img src="../imagens/rodapedaleira2.png" alt="Logo"></a>
        </div>
    </header>

    <div class="container">
        <h1>Adicionar Equipamento</h1>
        <?php if (isset($_SESSION['mensagem'])): ?>
            <div class="mensagem">
                <?php echo $_SESSION['mensagem'];
                unset($_SESSION['mensagem']); ?>
            </div>
        <?php endif; ?>

        <form action="adicionar_equipamento.php" method="post" enctype="multipart/form-data">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="preco">Preço:</label>
            <input type="number" id="preco" name="preco" step="0.01" required>

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" required></textarea>

            <label for="categoria">Categoria:</label>
            <select id="categoria" name="categoria" required>
                <option value="sweatshirts">Sweatshirts</option>
                <option value="tshirts">Tshirts</option>
            </select><br>

            <label for="tamanhos">Tamanhos Disponíveis:</label>
            <select id="tamanhos" name="tamanhos[]" multiple required>
                <option value="XS">XS</option>
                <option value="S">S</option>
                <option value="M">M</option>
                <option value="L">L</option>
                <option value="XL">XL</option>
            </select><br>

            <label for="destaque">Destaque:</label>
            <select name="destaque">
                <option value="sim">Sim</option>
                <option value="nao">Não</option>
            </select><br>

            <label for="imagem">Imagem:</label>
            <input type="file" id="imagem" name="imagem"><br>

            <label for="miniatura1">Miniatura 1:</label>
            <input type="file" id="miniatura1" name="miniatura1" required>

            <label for="miniatura2">Miniatura 2:</label>
            <input type="file" id="miniatura2" name="miniatura2" required>

            <button type="submit" name="adicionar">Adicionar Produto</button>
        </form>

        <h2 style="color:white">Produtos Existentes</h2>

        <div class="search-container">
            <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Pesquisar por nome...">
        </div>
        <table id="produtosTable">
            <thead>
                <tr>
                    <th onclick="sortTable(0)">ID</th>
                    <th onclick="sortTable(1)">Nome</th>
                    <th onclick="sortTable(2)">Preço</th>
                    <th onclick="sortTable(3)">Descrição</th>
                    <th onclick="sortTable(4)">Categoria</th>
                    <th>Imagem</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($produto = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?php echo $produto['id']; ?></td>
                        <td><?php echo $produto['nome']; ?></td>
                        <td><?php echo $produto['preco']; ?></td>
                        <td><?php echo $produto['descricao']; ?></td>
                        <td><?php echo $produto['categoria']; ?></td>
                        <td>
                            <?php if ($produto['imagem']): ?>
                                <img src="../imagens/<?php echo $produto['imagem']; ?>" alt="<?php echo $produto['nome']; ?>"
                                    width="50">
                            <?php elseif ($produto['video']): ?>
                                <video width="100" controls>
                                    <source src="../videos/<?php echo $produto['video']; ?>" type="video/mp4">
                                    Seu navegador não suporta o elemento de vídeo.
                                </video>
                            <?php endif; ?>
                        </td>
                        <td class="actions">
                            <a href="adicionar_equipamento.php?remover=<?php echo $produto['id']; ?>" class="btn-remover"
                                onclick="return confirm('Tem certeza que deseja remover este produto?')">Remover</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        function filterTable() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("produtosTable");
            tr = table.getElementsByTagName("tr");
            for (i = 1; i < tr.length; i++) {
                tr[i].style.display = "none";
                td = tr[i].getElementsByTagName("td");
                for (j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        }
                    }
                }
            }
        }

        function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("produtosTable");
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