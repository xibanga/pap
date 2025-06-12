<?php
include('../ligabd.php'); // Conexão com a base de dados
session_start();

// Verificar conexão
if (!$con) {
    die("Erro na conexão: " . mysqli_connect_error());
}

// Adicionar bicicleta
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $modelo = mysqli_real_escape_string($con, $_POST['modelo']);
    $marca = mysqli_real_escape_string($con, $_POST['marca']);
    $preco = mysqli_real_escape_string($con, $_POST['preco']);
    $disponibilidade = mysqli_real_escape_string($con, $_POST['disponibilidade']);
    
    // Upload da imagem
    $imagem_nome = $_FILES['imagem']['name'];
    $imagem_tmp = $_FILES['imagem']['tmp_name'];
    $imagem_destino = "../imagens/" . basename($imagem_nome);
    
    // Verificar se o diretório tem permissões de escrita
    if (!is_writable('../imagens/')) {
        die("Erro: Sem permissões para gravar na pasta de imagens.");
    }

    if (move_uploaded_file($imagem_tmp, $imagem_destino)) {
        // Corrigir SQL para incluir `descricao` e `tipo`
        $sql = "INSERT INTO bicicletas (modelo, imagem, descricao, preco, disponibilidade, tipo) 
                VALUES ('$modelo', '$imagem_destino', '$marca', '$preco', '$disponibilidade', 'aluguer')";

        if ($con->query($sql) === TRUE) {
            $_SESSION['mensagem'] ="<p style='color: green;'>✅ Bicicleta adicionada com sucesso!";
            header("Location: gerir.php");
            exit();
        } else {
            $_SESSION['mensagem'] = "❌ Erro ao adicionar bicicleta: " . $con->error;
        }
    } else {
        $_SESSION['mensagem'] = "❌ Falha ao mover a imagem.";
    }
}

if (isset($_GET['remover'])) {
    $id = intval($_GET['remover']);

    // Excluir primeiro os alugueres associados à bicicleta
    $sql_delete_alugueres = "DELETE FROM alugueres WHERE bicicleta_id = $id";
    $con->query($sql_delete_alugueres);

    // Agora, excluir a bicicleta
    $sql_delete_bicicleta = "DELETE FROM bicicletas WHERE id = $id";
    if ($con->query($sql_delete_bicicleta) === TRUE) {
        $_SESSION['mensagem'] = "<p style='color: green;'> 🚮 Bicicleta e alugueres removidos com sucesso!";
    } else {
        $_SESSION['mensagem'] = "❌ Erro ao remover bicicleta: " . $con->error;
    }

    header("Location: gerir.php");
    exit();
}

// Paginação
$limit = 8;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$sql_count = "SELECT COUNT(*) AS total FROM bicicletas WHERE tipo = 'aluguer'";
$result_count = $con->query($sql_count);
$total_rows = $result_count->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $limit);

// Obter todas as bicicletas com limite
$sql = "SELECT * FROM bicicletas WHERE tipo = 'aluguer' LIMIT $limit OFFSET $offset";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../imagens/rodapedaleira2.png">
    <title>Gerir Bicicletas</title>
    <link rel="stylesheet" href="gerir.css">
</head>
<>
    <div class="direita">
        <div class="logo">
            <a href="aluguer.php"><img src="../imagens/rodapedaleira2.png" alt="Logo"></a>
        </div>
    </div>

    <h1>Gerir Bicicletas</h1>

    <?php if (isset($_SESSION['mensagem'])): ?>
        <p><?php echo $_SESSION['mensagem']; unset($_SESSION['mensagem']); ?></p>
    <?php endif; ?>

    <form action="gerir.php" method="POST" enctype="multipart/form-data">
        <label>Nome da Bike:</label>
        <input type="text" name="modelo" required>
        
        <label>Imagem:</label>
        <input type="file" name="imagem" accept="image/*" required>
        
        <label>Marca:</label>
        <input type="text" name="marca" required>
        
        <label>Preço por Hora (€):</label>
        <input type="number" name="preco" step="0.01" required>
        
        <label>Disponibilidade:</label>
        <select name="disponibilidade">
            <option value="1">Disponível</option>
            <option value="0">Indisponível</option>
        </select>

        <br>
        
        <button type="submit">Adicionar Bicicleta</button>
    </form>

    <h2>Bicicletas em Exposição</h2>
    <table id="produtosTable" border="1">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Marca</th>
                <th>Preço por Hora (€)</th>
                <th>Imagem</th>
                <th>Disponibilidade</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['modelo']; ?></td>
                <td><?php echo $row['descricao']; ?></td>
                <td>€<?php echo $row['preco']; ?></td>
                <td><img src="<?php echo $row['imagem']; ?>" width="100"></td>
                <td><?php echo $row['disponibilidade'] ? 'Disponível' : 'Indisponível'; ?></td>
                <td><a href="gerir.php?remover=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que deseja remover esta bicicleta?');">Remover</a></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Paginação -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>" class="prev">&#8592; Anterior</a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>"> <?php echo $i; ?> </a>
        <?php endfor; ?>
        <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $page + 1; ?>" class="next">Próxima &#8594;</a>
        <?php endif; ?>
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

            if (dir === "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            } else if (dir === "desc") {
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
            if (switchcount === 0 && dir === "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}

    </script>
</body>
</html>

