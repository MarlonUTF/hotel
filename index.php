<?php 
    include_once('config.php');

    $selectedQuarto = '';

    // Verifica se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quarto'])) {
        $idQuarto = $_POST['quarto'];
    } else {
        // Se o formulário não foi enviado, define o quarto padrão como 1
        $idQuarto = 1;
    }

    // Busca o nome do quarto selecionado no banco de dados
    $stmt = $conexao->prepare("SELECT nome_quarto FROM quarto WHERE id_quarto = ?");
    $stmt->bind_param('i', $idQuarto);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $selectedQuarto = $row['nome_quarto'];
    }
    ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vitrine de Quartos</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="img/cama.svg">
</head>
<body>
    <header>
        <div id="titulo">
            <a href="index.php">
                <h1 id="title">Central</h1>
                <p id="p_title">Pousada do Vale Sereno</p>
            </a>
        </div>
        <div>
            <nav>
                <a class="link_nav" href="login.php">Login</a>
                <a class="link_nav" href="cadastro.php">Cadastre-se</a>
            </nav>
        </div>
    </header>
    <div class="vitrine">
        <!-- <form id="busca_vitrine" method="POST" action="index.php">
                <select name="quarto" id="quarto">
                <?php
                    $querry = $conexao->query(
                    "SELECT
                        quarto.id_quarto AS id,
                        quarto.nome_quarto AS quarto
                    FROM
                        quarto
                    ORDER BY
                        id ASC");
                    $registros = $querry->fetch_all(MYSQLI_ASSOC);
                
                    foreach($registros as $option) {
                        ?>
                            <option value="<?php echo $option['id']?>">
                                <?php echo $option['quarto']?>
                            </option>
                        <?php
                    }
                ?>
                </select>
            <button type="submit" class="pesquisa">Buscar</button>
        </form>
        <br>
        <?php
        if (!empty($selectedQuarto)) {
            echo "<h3>Quarto selecionado: " . htmlspecialchars($selectedQuarto) . "</h3>";}
        ?> -->


        <div class="todos_quartos">
            <?php
                 $querry = $conexao->query(
                 "SELECT
                     quarto.id_quarto AS id,
                     quarto.nome_quarto AS quarto
                 FROM
                     quarto
                 ORDER BY
                     id ASC");
                 $registros = $querry->fetch_all(MYSQLI_ASSOC);
            
                 foreach($registros as $option) {
                    ?>
                        <div class="quarto">
                            <p value="<?php echo $option['id']?>">
                                <?php echo $option['quarto']?>
                            </p>
                        </div>
                    <?php
                }
            ?>
        </div>

    </div>
    
</body>
</html>
