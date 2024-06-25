<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            <a class="link_nav" href="index.php">Inicio</a>
            <a class="link_nav" href="cadastro.php">Cadastre-se</a>
        </div>
    </header>
    <h1 class="h1_login">Bem vindo novamente! :)</h1>
    <div class="container">
        <h2 class="espaco_login">Login:</h2>
        <br>
        <form action="testar_login.php" method="POST">
            <input type="text" name="email" id="email" placeholder="Email" class="input_user">
            <br><br><br>
            <input type="password" name="cpf" id="cpf" placeholder="CPF" class="input_user">
            <br><br>
            <input type="submit" class="submit" name="submit" value="Entrar">
        </form>
        <br>
        <p>Não tem cadastro? <a class="link" href="cadastro.php">Cadastrar-se</a></p>
    </div>
    
</body>
</html>