<?php

session_start();

if (isset($_SESSION['user'])) {
    echo "<p>Witaj {$_SESSION['user']}</p>";

    if (isset($_COOKIE['login'])) {
        echo "<p>Witaj {$_COOKIE['login']}</p>";
    }
}
else {
    header("Location: login.php");
}