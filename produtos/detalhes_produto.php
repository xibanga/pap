<?php
session_start();
require "../ligabd.php"; // Conexão com o banco de dados

// Verificar se o ID do produto foi passado como parâmetro

$_GET['cor'] = $_GET['cor'] ?? 'branca';

if (isset($_GET['id'])) {
    $produto_id = mysqli_real_escape_string($con, $_GET['id']);
    $query = "SELECT * FROM produtos WHERE id = '$produto_id'";
    $resultado = mysqli_query($con, $query);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $produto = mysqli_fetch_assoc($resultado);
    } else {
        echo "Produto não encontrado.";
        exit();
    }
} else {
    echo "ID do produto não fornecido.";
    exit();
}

// Adicionar ao carrinho
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adicionar_ao_carrinho'])) {
    $produto_id = $_POST['produto_id'];
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }

    $query_produto = "SELECT * FROM produtos WHERE id = $produto_id";
    $resultado_produto = mysqli_query($con, $query_produto);
    $produtoData = mysqli_fetch_assoc($resultado_produto);

    if (!in_array($produto_id, array_column($_SESSION['carrinho'], 'id'))) {
        $_SESSION['carrinho'][] = [
            "id" => $produto_id,
            "quantidade" => 1,
            "preco" => $produtoData['preco'],
            "nome" => $produtoData['nome'],
        ];
    }
    header("Location: detalhes_produto.php?id=$produto_id".($_POST["cor"] ? "&cor=".$_POST["cor"] : ""));
    exit();
}


// Adicionar aos favoritos
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adicionar_aos_favoritos'])) {
    $produto_id = $_POST['produto_id'];
    if (!isset($_SESSION['favoritos'])) {
        $_SESSION['favoritos'] = [];
    }

    if (!in_array($produto_id, $_SESSION['favoritos'])) {
        $_SESSION['favoritos'][] = $produto_id;
    }
    header("Location: detalhes_produto.php?id=$produto_id".($_POST["cor"] ? "&cor=".$_POST["cor"] : ""));
    exit();
}


// Obter detalhes dos produtos favoritos
$favoritos = [];
if (isset($_SESSION['favoritos']) && count($_SESSION['favoritos']) > 0) {
    $ids = implode(',', $_SESSION['favoritos']);
    $query = "SELECT * FROM produtos WHERE id IN ($ids)";
    $resultado = mysqli_query($con, $query);
    while ($produto_fav = mysqli_fetch_assoc($resultado)) {
        $favoritos[] = $produto_fav;
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="detalhes.css">
    <link rel="icon" type="image/x-icon" href="../imagens/rodapedaleira2.png">
    <title><?= $produto['nome']; ?> - Detalhes</title>
</head>
<style>
    .navbar-buttons {
        display: flex;
        align-items: center;
    }

    .navbar-buttons a {
        margin-left: 20px;
    }

    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        background-color: white;
        min-width: 200px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #ddd;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }
</style>

<body>
    <header>
        <div class="navbar">
            <div class="logo">
                <a href="main_vendas.php"><img src="../imagens/rodapedaleira.jpg" alt="Logo"></a>
            </div>
            <div class="navbar-buttons">
                <div class="dropdown">
                    <a href="favoritos.php" class="btn-favoritos"><img src="../imagens/heart.png" alt="Favoritos"
                            width="30"></a>
                    <div class="dropdown-content">
                        <?php if (count($favoritos) > 0): ?>
                            <?php foreach ($favoritos as $produto_fav): ?>
                                <a href="detalhes_produto.php?id=<?php echo $produto_fav['id']; ?>">
                                    <?php echo $produto_fav['nome']; ?>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Não há produtos nos favoritos.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <a href="carrinho.php" class="btn-carrinho"><img src="../imagens/cart.png" alt="Carrinho"
                        width="30"></a>
            </div>
        </div>
    </header>

    <main class="produto-detalhado">
        <div class="produto-imagem">
            <img class="imagem-principal" id="imagemPrincipal" src="" style="display: none;"
                alt="<?php echo $produto['nome']; ?>">
            <video src="" class="imagem-principal" loop id="videoPrincipal"></video>
            <div class="miniaturas">
                <video id="video1" autoplay onclick="trocarImagem(this)" src="../imagens/<?= $produto['categoria']; ?>/<?= $_GET['cor'] ?>/video.mp4">
                </video>
                <img id="mini1" src="../imagens/<?= $produto['categoria']; ?>/<?= $_GET['cor'] ?>/frente.png" alt="Miniatura 2"
                    onclick="trocarImagem(this)">
                <img id="mini2" src="../imagens/<?= $produto['categoria']; ?>/<?= $_GET['cor'] ?>/costas.png" alt="Miniatura 2"
                    onclick="trocarImagem(this)">
            </div>
        </div>
        <div class="produto-info">
            <h2><?php echo $produto['nome']; ?></h2>
            <p class="preco">€<?php echo number_format($produto['preco'], 2); ?></p>
            <p class="descricao"><?php echo $produto['descricao']; ?></p>

            <div class="opcoes">
                <h3>Cor:</h3>
                <div class="cores">
                    <span class="cor" style="background-color: white" onclick="mudarCor('branca')"></span>
                    <span class="cor" style="background-color: black" onclick="mudarCor('preta')"></span>
                    <span class="cor" style="background-color: yellow" onclick="mudarCor('amarela')"></span>
                    <span class="cor" style="background-color: red" onclick="mudarCor('vermelha')"></span>
                    <span class="cor" style="background-color: blue" onclick="mudarCor('azul')"></span>
                </div>

                <h3>Selecione um Tamanho</h3>
                <div class="tamanhos">
                    <button class="tamanho" onclick="selecionarTamanho(this)">XS</button>
                    <button class="tamanho" onclick="selecionarTamanho(this)">S</button>
                    <button class="tamanho" onclick="selecionarTamanho(this)">M</button>
                    <button class="tamanho" onclick="selecionarTamanho(this)">L</button>
                    <button class="tamanho" onclick="selecionarTamanho(this)">XL</button>
                </div>
            </div>

            <form method="post" action="detalhes_produto.php?id=<?php echo $produto['id']; ?>&<?= $_GET["cor"] ?>">
                <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
                <input type="hidden" name="cor" value="<?= $_GET["cor"] ?>">
                <button type="submit" name="adicionar_ao_carrinho" class="adicionar-carrinho">Adicionar ao
                    Carrinho</button>
            </form>

          

            <p class="entrega">🚚 Nós entregamos! Basta dizeres quando e como. <a href="shipping.php">Saber Mais</a></p>
            <form method="post" action="detalhes_produto.php?id=<?php echo $produto['id']; ?>">
                <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
                <button type="submit" name="adicionar_aos_favoritos" class="adicionar-favoritos">💖 Guardar para mais
                    tarde</button>
            </form>
        </div>
    </main>



    <script>
        document.querySelectorAll(".miniatura").forEach(img => {
            img.addEventListener("click", function () {
                document.getElementById("imagemPrincipal").src = this.src;
            });
        });

        document.querySelectorAll(".estrela").forEach((estrela, index) => {
            estrela.addEventListener("click", function () {
                document.querySelectorAll(".estrela").forEach((e, i) => {
                    e.innerHTML = i <= index ? "★" : "☆";
                });
            });
        });

        document.getElementById("addFavoritos").addEventListener("click", function () {
            alert("Produto adicionado aos favoritos!");
        });

        function selecionarTamanho(element) {
            document.querySelectorAll(".tamanho").forEach(btn => {
                btn.classList.remove("selected");
            });
            element.classList.add("selected");
        }

    </script>

    <script>
        var imagemPrincipal = document.getElementById('imagemPrincipal');
        var videoPrincipal = document.getElementById('videoPrincipal');

        function trocarImagem(element) {
            var isImage = element.tagName === "IMG";

            if (isImage) {
                imagemPrincipal.src = element.src;
                imagemPrincipal.style.display = "block";

                videoPrincipal.style.display = "none";
            }

            else {
                videoPrincipal.src = element.src;
                videoPrincipal.style.display = "block";
                videoPrincipal.play();

                imagemPrincipal.style.display = "none";
            }
        }

        trocarImagem(document.getElementById("video1"));

        function mudarCor(corNome) {

            var pastaCor = "../imagens/<?= $produto["categoria"] ?>/" + corNome + "/";

            document.getElementById("mini1").src = pastaCor + "frente.png";
            document.getElementById("mini2").src = pastaCor + "costas.png";
            document.getElementById("video1").src = pastaCor + "video.mp4";

            var video = document.getElementById("videoPrincipal");
            video.src = pastaCor + "video.mp4";
            video.style.display = "block";
            video.play();

            var imagemPrincipal = document.getElementById("imagemPrincipal");
            imagemPrincipal.style.display = "none";

        }
    </script>

</body>

</html>