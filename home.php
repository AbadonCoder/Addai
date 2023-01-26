<?php 
    require('user.php');
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Playhard | Home</title>
</head>
<body>
    <h1>Hola de nuevo <?=$_SESSION['username'];?></h1>
    <a href="logout.php">Cerrar sesion</a>
</body>
</html>