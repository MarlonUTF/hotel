<?php

if(isset($_POST['submit']))
{
    include_once('config.php');

    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $data_nascimento = $_POST['data_nascimento'];
    $renda = $_POST['renda'];

    $query_check_cpf_cliente = "SELECT pessoa_cpf_pessoa FROM cliente WHERE pessoa_cpf_pessoa = '$cpf'";
    $result_check_cpf_cliente = mysqli_query($conexao, $query_check_cpf_cliente);

    function validar_cpf($cpf) {
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        if (strlen($cpf) != 11) {
            return false;
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }

    function validar_email($email, $cpf, $nome, $data_nascimento, $renda, $conexao, $result_check_cpf_cliente){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            cadastrar_cliente($cpf, $nome, $email, $data_nascimento, $renda, $conexao, $result_check_cpf_cliente);
        } else {
            echo "Email inválido";
        }
    }

    function cadastrar_cliente($cpf, $nome, $email, $data_nascimento, $renda, $conexao, $result_check_cpf_cliente) {
        if(mysqli_num_rows($result_check_cpf_cliente) > 0) {
            echo "Erro: CPF já cadastrado como cliente.";
        } else {
            $query_insert_pessoa = "INSERT INTO pessoa(cpf_pessoa, nome_pessoa, data_nasc_pessoa, email_pessoa, status_idstatus) 
                                    VALUES('$cpf', '$nome', '$data_nascimento', '$email', 1)";
            $result_insert_pessoa = mysqli_query($conexao, $query_insert_pessoa);

            if($result_insert_pessoa) {
                $query_insert_cliente = "INSERT INTO cliente(pessoa_cpf_pessoa, data_cadastro, renda, status_idstatus)
                                         VALUES('$cpf', CURDATE(), '$renda', 1)";
                $result_insert_cliente = mysqli_query($conexao, $query_insert_cliente);

                if($result_insert_cliente) {
                    echo "Cadastro realizado com sucesso!";
                } else {
                    echo "Erro ao cadastrar cliente: " . mysqli_error($conexao);
                }
            } else {
                echo "Erro ao cadastrar pessoa: " . mysqli_error($conexao);
            }
        }
    }

    if (validar_cpf($cpf)) {
        validar_email($email, $cpf, $nome, $data_nascimento, $renda, $conexao, $result_check_cpf_cliente);
    } else {
        echo "CPF inválido";
    }

    // header('Location: login.php');
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="img/cama.svg">
    <script defer src="app.js"></script>
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
            <a class="link_nav" href="index.php">Inicio</a>
            <a class="link_nav" href="login.php">Login</a>
        </div>
    </header>
    <div class="container">
        <form action="cadastro.php" method="POST">
            <fieldset>
                <legend><b>Cadastro de Clientes</b></legend>
                <br>
                <div class="input_box">
                    <input type="text" name="cpf" id="cpf" class="input_user" required>
                    <label for="cpf" class="animacao_label">CPF</label>
                </div>
                <br><br>
                <div class="input_box">
                    <input type="text" name="nome" id="nome" class="input_user" required>
                    <label for="nome" class="animacao_label">Nome Completo</label>
                </div>
                <br><br>
                <div class="input_box">
                    <input type="text" name="email" id="email" class="input_user" required>
                    <label for="email" class="animacao_label">Email</label>
                </div>
                <br><br>
                <label for="data_nascimento">Data de Nascimento:</label>
                <input type="date" name="data_nascimento" id="data_nascimento" required>
                <br><br>
                <div class="input_box">
                    <input type="number" name="renda" id="renda" class="input_user" required>
                    <label for="renda" class="animacao_label">Renda (R$)</label>
                </div>
                <br><br>
                <input type="submit" name="submit" class="submit">
            </fieldset>
        </form>
        <br><br>
        <p>Já tem uma conta? <a class="link" href="login.php">Fazer Login</a></p>
    </div>

</body>
</html>
