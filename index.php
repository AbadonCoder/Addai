<?php
    require('user.php');

    if(isset($_POST['submit'])) {
        $response = User::login($_POST['username'], $_POST['password']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/app.css">
    <title>Playhard | Iniciar Sesión</title>
</head>
<body class="login">
    <div class="container">
        <form action="index.php" method="post" class="form" id="form">
            <h1 class="form__title">Iniciar Sesión</h1>

            <?php if(isset($response)) {?>
                <div class="alert <?=$response['type'];?>"><?=$response['msg'];?></div>
            <?php } ?>
    
            <div class="field">
                <input type="text" class="field__input" name="username" id="username" placeholder="Nombre de usuario">
            </div>
    
            <div class="field">
                <input type="password" class="field__input" name="password" id="password" placeholder="Contraseña">
            </div>
    
            <input type="submit" value="Login" class="btn" name="submit">
    
            <div class="form__links">
                <a href="#" id="resetPassword">¿Perdiste tu contraseña?</a>
                <a href="createAccount.php" id="createAccount">¿No tienes cuenta? Registrate</a>
            </div>
        </form>
    </div>
</body>
</html>