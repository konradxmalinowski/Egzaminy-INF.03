<?php
$db = new mysqli('localhost', 'root', '', 'kino');
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styl.css">
    <title>Informacje o aktorze | KinoTEKA</title>
</head>
<body>
    <header>
        <section class="header-lewy">
            <h2><a href="index.php">KinoTEKA</a></h2>
        </section>
        <section class="header-prawy">
            <p><em>W naszej bazie znajdują się najlepsi aktorzy</em></p>
        </section>
    </header>
    <main>
        <section class="wszyscy-aktorzy">
            <?php
                $imie;

                if (isset($_GET['id'])) {
                    $id = intval($_GET['id']);
                    $zapytanie = "SELECT imie, nazwisko, plik_awatara FROM aktorzy WHERE id_aktora = $id;";
                    $rezultat = $db -> query($zapytanie);
                    $wiersz = $rezultat -> fetch_assoc(); 
                    
                    $imie = $wiersz['imie'];
                    $nazwisko = $wiersz['nazwisko'];
                    $plik_awatara = "img/" . $wiersz['plik_awatara'];

                    echo 
                    "
                    <section class=\"aktor-podstrona\">
                        <img src=\"$plik_awatara\" alt=\"$imie $nazwisko\" title=\"$imie $nazwisko\">
                        <h1>$imie $nazwisko</h1>
                    </section>
                    ";
                }
            ?>
        </section>

        <?php 
             if (isset($_GET['id'])) {
                    $id = intval($_GET['id']);
                    $zapytanie = "SELECT filmy.id_filmu, filmy.tytul, filmy.rok_produkcji FROM filmy JOIN filmy_aktorzy ON filmy_aktorzy.id_filmu = filmy.id_filmu JOIN aktorzy ON aktorzy.id_aktora = filmy_aktorzy.id_aktora WHERE aktorzy.id_aktora = $id";
                    $rezultat = $db -> query($zapytanie);
                    
                    $liczba = $rezultat -> num_rows;

                    if ($liczba === 0) {
                        echo "<span>$imie nie znajduje się na listach obsady znanych nam produkcji.</span>";
                    }
                    else {
                        echo "<span>$imie znajduje się na listach obsady $liczba znanych nam produkcji.</span>";
                    }
                }
        ?>
    </main>
    <footer><p>Autor: <strong>Konrad Malinowski</strong></p></footer>
</body>
</html>

<?php
$db->close();
?>