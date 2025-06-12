<?php
session_start();
require "../ligabd.php"; // Conexão com a base de dados

// Adicionar trilho
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adicionar'])) {
    $nome = mysqli_real_escape_string($con, $_POST['nome']);
    $distancia = mysqli_real_escape_string($con, $_POST['distancia']);
    $dificuldade = mysqli_real_escape_string($con, $_POST['dificuldade']);

    // Query corrigida (sem a vírgula extra)
    $query = "INSERT INTO trilhos (nome, distancia_km, dificuldade) 
              VALUES ('$nome', '$distancia', '$dificuldade')";

    if (mysqli_query($con, $query)) {
        $_SESSION['mensagem'] = "Trilho adicionado com sucesso!";
    } else {
        $_SESSION['mensagem'] = "Erro ao adicionar trilho: " . mysqli_error($con);
    }
}

// Remover trilho
if (isset($_GET['remover'])) {
    $id = mysqli_real_escape_string($con, $_GET['remover']);
    $query = "DELETE FROM trilhos WHERE id = $id";
    mysqli_query($con, $query);
    $_SESSION['mensagem'] = "Trilho removido com sucesso!";
    header("Location: gestao_trilhos.php");
    exit();
}

// Buscar trilhos
$query = "SELECT * FROM trilhos";
$resultado = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Trilhos</title>
    <link rel="icon" type="image/x-icon" href="../imagens/rodapedaleira2.png">
    <link rel="stylesheet" href="gestao.css">
</head>


<body>

    <!-- Navbar -->
    <header class="navbar">
        <div class="logo">
            <a href="../paginas/pagina1.php"><img src="../imagens/rodapedaleira2.png" alt="Logo"></a>
        </div>
    </header>

    <main style="min-height: calc(100vh - 120px);">
        <div class="container">
            <h1>Gestão de Trilhos</h1>
    
            <?php if (isset($_SESSION['mensagem'])): ?>
                <div class="mensagem">
                    <?php echo $_SESSION['mensagem'];
                    unset($_SESSION['mensagem']); ?>
                </div>
            <?php endif; ?>
    
            <form action="gestao_trilhos.php" method="post">
                <input type="text" name="nome" placeholder="Nome do Trilho" required>
                <input type="number" name="distancia" placeholder="Distância (km)" required>
                <select name="dificuldade" required>
                    <option value="Iniciante">Iniciante</option>
                    <option value="Intermediário">Intermediário</option>
                    <option value="Profissional">Profissional</option>
                </select>
                <button type="submit" name="adicionar">Adicionar Trilho</button>
            </form>
    
            <table>
                <tr>
                    <th>Nome</th>
                    <th>Distância (km)</th>
                    <th>Dificuldade</th>
                    <th>Ações</th>
                </tr>
                <?php while ($trilho = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($trilho['nome']); ?></td>
                        <td><?php echo htmlspecialchars($trilho['distancia_km']); ?></td>
                        <td><?php echo htmlspecialchars($trilho['dificuldade']); ?></td>
                        <td><a href="gestao_trilhos.php?remover=<?php echo $trilho['id']; ?>"
                                onclick="return confirm('Tem certeza que deseja remover este trilho?');">Remover</a></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2025 Rodapedaleira. Todos os direitos reservados.</p>
    </footer>
</body>

</html>