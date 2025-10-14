<?php

$db = new mysqli("localhost", 'root', '', 'przewozy');
if ($db->connect_error) {
    echo "<p>Błąd połączenia z bazą danych</p>";
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $zapytanie = "delete from zadania where id_zadania = $id";
    $db->query($zapytanie);
}

header("Location: przewozy.php");

?>