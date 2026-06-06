<?php
    include('baza.php');
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = intval($_GET['id']);

        $zapytanie = "DELETE FROM zadania WHERE id_zadania = $id;";
        $wynik = $baza -> query($zapytanie);
        $baza -> close();
        header("Location: przewozy.php");
    }
?>