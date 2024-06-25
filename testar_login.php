<?php

    session_start();

    // print_r($_REQUEST);

    if(isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['cpf']))
    {
        include_once('config.php');
        $email = $_POST['email'];
        $cpf = $_POST['cpf'];

        // print_r('Email: ' . $email);
        // print_r('<br>');
        // print_r('CPF: ' . $cpf);

        $sql = "SELECT * FROM pessoa WHERE email_pessoa = '$email' and cpf_pessoa = '$cpf'";

        $resultado = $conexao->query($sql);

        // print_r($sql);
        // print_r($resultado);

        if(mysqli_num_rows($resultado) < 1)
        {
            unset($_SESSION['email']);
            unset($_SESSION['cpf']);
            header('Location: login.php');
        }
        else
        {
            $_SESSION['email'] = $email;
            $_SESSION['cpf'] = $cpf;
            header('Location: sistema.php');
        }

    }
    else{
        header('Location: login.php');
    }
?>