<?php
    session_start();
    include_once('config.php');
    // print_r($_SESSION);
    if((!isset($_SESSION['email']) == true) or (!isset($_SESSION['cpf']) == true))
    {
        unset($_SESSION['email']);
        unset($_SESSION['cpf']);
        header('Location: login.php');
    }
    $logado = $_SESSION['email'];
    $query = "SELECT nome_pessoa FROM pessoa WHERE email_pessoa = '$logado'";
    $result = mysqli_query($conexao, $query);
    $row = mysqli_fetch_assoc($result);
    $nome = $row['nome_pessoa'];

    $sql = "SELECT 
                r.id_reserva,
                p.nome_pessoa AS nome_cliente,
                f.nome_pessoa AS nome_funcionario,
                q.nome_quarto AS nome_quarto,
                q.num_vagas AS num_vagas,
                r.data_reserva AS data_reserva,
                CASE 
                    WHEN q.vaga_pets = 1 THEN 'Sim'
                    ELSE 'Não'
                END AS vaga_pets
            FROM 
                reserva r
                JOIN cliente c ON r.cliente_pessoa_cpf_pessoa = c.pessoa_cpf_pessoa
                JOIN pessoa p ON c.pessoa_cpf_pessoa = p.cpf_pessoa
                JOIN funcionario fu ON r.funcionario_pessoa_cpf_pessoa = fu.pessoa_cpf_pessoa
                JOIN pessoa f ON fu.pessoa_cpf_pessoa = f.cpf_pessoa
                JOIN quarto_has_reserva qr ON r.id_reserva = qr.reserva_id_reserva
                JOIN quarto q ON qr.quarto_id_quarto = q.id_quarto
            WHERE p.email_pessoa = '$logado'";


    $result = $conexao->query($sql);

    // print_r($result);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema</title>
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
            <a class="link_nav" href="sair_index.php">Inicio</a>
            <a class="sair link_branco" href="sair.php">Sair</a>
        </div>
    </header>
    
    <?php

        echo "<h1 class='oi'>Olá <i><u>$nome</u></i>!</h1>";

    ?>
    <div class="container_reservas">
        <h2>Suas reservas: </h2>
        <div class="reservas">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="coluna">#</th>
                        <th scope="coluna">Cliente</th>
                        <th scope="coluna">Reservado por</th>
                        <th scope="coluna">Quarto</th>
                        <th scope="coluna">Vagas</th>
                        <th scope="coluna">Data reservada</th>
                        <th scope="coluna">Pets</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>".$row["id_reserva"]."</td>";
                                echo "<td>".$row["nome_cliente"]."</td>";
                                echo "<td>".$row["nome_funcionario"]."</td>";
                                echo "<td>".$row["nome_quarto"]."</td>";
                                echo "<td>".$row["num_vagas"]."</td>";
                                echo "<td>".$row["data_reserva"]."</td>";
                                echo "<td>".$row["vaga_pets"]."</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr  class='txt_cinza'><td colspan='7'>Nenhuma reserva encontrada.</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="container_reservas">
        <h2>Pesquisa de reservas</h2>
        <div class="pesquisa_reserva">
            <form action="" method="$_GET">
                <p>data inicial: <input class="data" type="date" name="dat1" required></p>
                <p>data final: <input class="data" type="date" name="dat2" required></p>
                <input class="pesquisa" type="submit" value="Pesquisar">
            </form>
        </div>

        <?php 
if(isset($_GET['dat1']) && isset($_GET['dat2']))
{
    $data1 = $_GET['dat1'];
    $data2 = $_GET['dat2'];

    include_once('config.php');

    $sql = "SELECT 
            r.id_reserva,
            p.nome_pessoa AS nome_cliente,
            f.nome_pessoa AS nome_funcionario,
            q.nome_quarto AS nome_quarto,
            q.num_vagas AS num_vagas,
            r.data_reserva AS data_reserva,
            CASE 
                WHEN q.vaga_pets = 1 THEN 'Sim'
                ELSE 'Não'
            END AS vaga_pets
        FROM 
            reserva r
            JOIN cliente c ON r.cliente_pessoa_cpf_pessoa = c.pessoa_cpf_pessoa
            JOIN pessoa p ON c.pessoa_cpf_pessoa = p.cpf_pessoa
            JOIN funcionario fu ON r.funcionario_pessoa_cpf_pessoa = fu.pessoa_cpf_pessoa
            JOIN pessoa f ON fu.pessoa_cpf_pessoa = f.cpf_pessoa
            JOIN quarto_has_reserva qr ON r.id_reserva = qr.reserva_id_reserva
            JOIN quarto q ON qr.quarto_id_quarto = q.id_quarto
        WHERE p.email_pessoa = '$logado'
        AND r.data_reserva BETWEEN '$data1' AND '$data2'";

    $result = $conexao->query($sql);

    if ($result->num_rows > 0) 
    {
        echo "<h2>Reservas no intervalo de $data1 a $data2:</h2>";
        echo "<div class='reservas'>";
        echo "<table class='table'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th scope='coluna'>#</th>";
        echo "<th scope='coluna'>Cliente</th>";
        echo "<th scope='coluna'>Reservado por</th>";
        echo "<th scope='coluna'>Quarto</th>";
        echo "<th scope='coluna'>Vagas</th>";
        echo "<th scope='coluna'>Data reservada</th>";
        echo "<th scope='coluna'>Pets</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        while($row = $result->fetch_assoc()) 
        {
            echo "<tr>";
            echo "<td>".$row["id_reserva"]."</td>";
            echo "<td>".$row["nome_cliente"]."</td>";
            echo "<td>".$row["nome_funcionario"]."</td>";
            echo "<td>".$row["nome_quarto"]."</td>";
            echo "<td>".$row["num_vagas"]."</td>";
            echo "<td>".$row["data_reserva"]."</td>";
            echo "<td>".$row["vaga_pets"]."</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    }
    else 
    {
        echo "<p class='txt_cinza'>Nenhuma reserva encontrada no intervalo de $data1 a $data2.</p>";
    }
    }
    ?>


    </div>


</body>
</html>