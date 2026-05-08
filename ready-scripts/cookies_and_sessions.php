<?php

if (!isset($_COOKIE['count'])) {
    setcookie("count", 1, time() + (86400 * 30), "/");
}
else {
    $value = (int)$_COOKIE["count"];
    $value += 1;
    setcookie("count", $value, time() + (86400 * 30), "/");
    echo "<p>Witaj po raz $value</p>";
}