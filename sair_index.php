<?php
    session_start();
    unset($_SESSION['email']);
    unset($_SESSION['cpf']);
    header("Location: index.php");

?>
    
