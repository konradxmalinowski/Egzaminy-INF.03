<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = htmlspecialchars($_POST['login']);
    $password = htmlspecialchars($_POST['password']);
    $remember_me = $_POST['remember-me'];

    if (empty($login) || empty($password)) {
        echo "<p>Fill up all the fields</p>";
    }
    else {
        if ($login !== 'admin' || $password !== "1234") {
            echo "<p>Invalid data</p>";
        }
        else {
            $_SESSION['user'] = 'admin';

            if ($remember_me) setcookie("login", $login, time() + 3600, "/");
            header("Location: panel.php");
        }
    }
} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <form action="login.php" method="post">
        <label for="login">Login: </label> <br>
        <input type="text" name="login" id="login"> <br>
        <label for="password">Password: </label> <br>
        <input type="password" name="password" id="password"> <br>
        <label for="remember-me">Remember me</label>
        <input type="checkbox" name="remember-me" id="remember-me" value="remember-me">
        <button type="submit">Zaloguj</button>
    </form>
</body>
</html>