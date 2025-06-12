    <?php
    session_start();
    if (!isset($_SESSION["nome"]) || $_SESSION["id_tipos_utilizador"] != 0) {
        header("Location: ../index.php");
        exit();
    }

    require "../ligabd.php";

    $order = isset($_GET['order']) ? $_GET['order'] : 'ASC';
    $search = isset($_GET['search']) ? $_GET['search'] : '';



    $sql = "SELECT * FROM utilizadores, tipo_utilizador 
            WHERE utilizadores.id_tipos_utilizador = tipo_utilizador.id_tipos_utilizador";

    if ($search) {
        $search = mysqli_real_escape_string($con, $search);
        $sql .= " AND (utilizadores.email LIKE '%$search%' OR utilizadores.nome LIKE '%$search%')";
    }

    // Definir quantos utilizadores por página
    $limit = 5;
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = ($page - 1) * $limit;

    $order = isset($_GET['order']) ? $_GET['order'] : 'ASC';
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    // Contar total de utilizadores
    $sql_count = "SELECT COUNT(*) AS total FROM utilizadores";
    $result_count = mysqli_query($con, $sql_count);
    $total_rows = mysqli_fetch_assoc($result_count)['total'];
    $total_pages = ceil($total_rows / $limit);

    // Obter utilizadores com paginação
    $sql = "SELECT * FROM utilizadores, tipo_utilizador 
            WHERE utilizadores.id_tipos_utilizador = tipo_utilizador.id_tipos_utilizador";

    if ($search) {
        $search = mysqli_real_escape_string($con, $search);
        $sql .= " AND (utilizadores.email LIKE '%$search%' OR utilizadores.nome LIKE '%$search%')";
    }

    $sql .= " ORDER BY utilizadores.nome $order LIMIT $limit OFFSET $offset";
    $resultado = mysqli_query($con, $sql);


    if (!$resultado) {
        $_SESSION["erro"] = "Não foi possível obter os dados dos utilizadores.";
        header("Location: ../index.php");
        exit();
    }
    
    ?>

    <!DOCTYPE html>
    <html lang="pt">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="gestao.css">
        <link rel="icon" type="image/x-icon" href="../imagens/rodapedaleira2.png">
        <title>Gestão de Utilizadores</title>
        <style>
            .table-section {
                overflow-x: auto;
            }

            .controls {
                display: flex;
                justify-content: space-between;
                margin-bottom: 20px;
            }

            .controls input[type="text"] {
                padding: 2px;
                width: 750px;
                margin-bottom: 1px;
            }

            .controls select {
                padding: 18px;
                width: 93px;
                margin-bottom: 1px;
            }
        </style>

    </head>

    <body>
        <div class="container center">

            <div class="table-section">
                <header>
                    <h1>Gestão de Utilizadores</h1>
                    <a href="../paginas/pagina1.php"><img src="../imagens/rodapedaleira2.png" alt="Imagem de Gestão" class="logo"></a>
                </header>

                <div class="controls">
                    <!-- Barra de pesquisa -->
                    <form method="get" style="display: inline;">
                        <input type="text" name="search" placeholder="Pesquisar por nome de utilizador ou email" value="<?php echo htmlspecialchars($search); ?>">
                        <button type="submit">Pesquisar</button>
                    </form>

                    <!-- Dropdown de ordenação -->
                    <form method="get" style="display: inline;">
                        <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                        <select name="order" onchange="this.form.submit()">
                            <option value="ASC" <?php if ($order == 'ASC') echo 'selected'; ?>>A-Z</option>
                            <option value="DESC" <?php if ($order == 'DESC') echo 'selected'; ?>>Z-A</option>
                        </select>
                    </form>
                </div>

                <table class="center">
                    <tr>
                        <th>𝕦𝕥𝕚𝕝𝕚𝕫𝕒𝕕𝕠𝕣</th>
                        <th>𝕡𝕒𝕝𝕒𝕧𝕣𝕒-𝕡𝕒𝕤𝕤𝕖</th>
                        <th>𝕖𝕞𝕒𝕚𝕝</th>
                        <th>𝕥𝕚𝕡𝕠 𝕕𝕖 𝕦𝕥𝕚𝕝𝕚𝕫𝕒𝕕𝕠𝕣</th>
                        <th>𝔸çõ𝕖𝕤</th>
                    </tr>

                    <form id="formInserir" method="post">
                        <tr>
                            <td>
                                <input name="nome" type="text" placeholder=" Nome Utilizador" style="text-align: center;">
                            </td>

                            <td>
                                <input name="palavra_passe" type="password" placeholder=" Palavra-passe" style="text-align: center;">
                            </td>

                            <td>
                                <input name="email" type="email" placeholder=" email " style="text-align: center;">
                            </td>

                            <td>
                                <select name="id_tipos_utilizador">
                                    <option value="0">Administrador</option>
                                    <option value="1">Utilizador</option>
                                </select>
                            </td>

                            <td class="center" style="gap: 10px;">
                                <button type="submit" formaction="inserir.php" name="botaoInserir">𝕚𝕟𝕤𝕖𝕣𝕚𝕣</button>
                            </td>
                        </tr>
                    </form>

                    <?php while ($registo = mysqli_fetch_assoc($resultado)): ?>

                        <form id="form<?php echo $registo['id']; ?>" method="post">
                            <tr>
                                <td hidden>
                                    <input name="id_utilizadores" type="hidden" value="<?php echo $registo['id']; ?>">
                                </td>

                                <td>
                                    <input name="nome" type="text" value="<?php echo $registo['nome']; ?>">
                                </td>

                                <td>
                                    <input name="palavra_passe" type="password" placeholder="Nova Palavra-passe" style="text-align: center;">
                                </td>

                                <td>
                                    <!-- o email nao pode ser alterado pelo administrador-->
                                    <input  name="email" type="email" value="<?php echo $registo['email']; ?>">
                                </td>

                                <td>
                                    <select name="id_tipos_utilizador">
                                        <option value="0" <?php if ($registo['id_tipos_utilizador'] == 0)
                                            echo "selected"; ?>>
                                            Administrador</option>
                                        <option value="1" <?php if ($registo['id_tipos_utilizador'] == 1)
                                            echo "selected"; ?>>
                                            Utilizador</option>
                                    </select>
                                </td>
                                

                                <td class="center" style="gap: 10px;">
                                    <button type="submit" formaction="gravar.php" name="botaoGravar">𝕘𝕣𝕒𝕧𝕒𝕣</button>
                                    <button type="button" class="btn-remove" data-id="<?php echo $registo['id']; ?>"
                <?php if ($registo['nome'] == 'Afonso Duarte') echo "disabled"; ?>>𝕣𝕖𝕞𝕠𝕧𝕖𝕣</button>

                            </tr>
                        </form>
                    <?php endwhile; ?>
                </table>

                
                                    <!-- Paginação -->
                    <div class="pagination">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?php echo $page - 1; ?>" class="prev">Anterior</a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <a href="?page=<?php echo $i; ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>"> <?php echo $i; ?> </a>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <a href="?page=<?php echo $page + 1; ?>" class="next">Próxima</a>
                        <?php endif; ?>
                    </div>

            </div>

            
            <div id="popup-confirm" class="popup">
                <div class="popup-content">
                    <p>Tem a certeza que quer remover esta conta?</p>
                    <div class="popup-buttons">
                        <button id="confirm-yes" class="popup-button yes">Sim</button>
                        <button id="confirm-no" class="popup-button no">Não</button>
                    </div>
                </div>
            </div>

            <?php if (isset($_SESSION["erro"])): ?>
                <p><?php echo $_SESSION["erro"];
                unset($_SESSION["erro"]); ?></p>
            <?php endif; ?>

        </div>

    </body>

    <script>
        const popup = document.getElementById('popup-confirm');
        const confirmYes = document.getElementById('confirm-yes');
        const confirmNo = document.getElementById('confirm-no');
        let userIdToRemove = null;

        document.querySelectorAll('.btn-remove').forEach(button => {
            button.addEventListener('click', function () {
                userIdToRemove = this.getAttribute('data-id');
                popup.classList.add('active');
            });
        });


        // Adiciona o evento de clique ao botão "Sim" para remover o utilizador
        confirmYes.addEventListener('click', function () {
            if (userIdToRemove) {
                const form = document.createElement('form');
                form.method = 'post';
                form.action = 'remover.php';

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'id_utilizadores';
                input.value = userIdToRemove;

                form.appendChild(input);
                document.body.appendChild(form);

                form.submit();
            }
            popup.classList.remove('active');
        });


        // Adiciona o evento de clique ao botão "Não" para fechar o popup
        confirmNo.addEventListener('click', function () {
            popup.classList.remove('active');
            userIdToRemove = null;
        });
    </script>

    </html>
