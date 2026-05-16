<?php
$db = new mysqli('localhost', 'root', '', 'kino');
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styl.css">
    <title>Lista aktorów | KinoTEKA</title>
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
        <h1>Najlepsi aktorzy tylko w naszym kinie</h1>
        <section class="wszyscy-aktorzy">
            <?php
                $zapytanie = "SELECT * FROM aktorzy ORDER BY nazwisko ASC, imie ASC;";
                $rezultat = $db -> query($zapytanie);
                foreach ($rezultat as $wiersz) {
                    $imie = $wiersz['imie'];
                    $nazwisko = $wiersz['nazwisko'];
                    $plik_awatara = "img/" . $wiersz['plik_awatara'];
                    $id = $wiersz['id_aktora'];

                    echo 
                    "
                    <a href=\"aktor.php?id=$id\">
                        <section class=\"aktor-index\">
                            <img src=\"$plik_awatara\" alt=\"$imie $nazwisko\" title=\"$imie $nazwisko\">
                            <p>$imie $nazwisko</p>
                        </section>
                    </a>
                    ";
                }
            ?>
        </section>
    </main>
    <footer><p>Autor: <strong>Konrad Malinowski</strong></p></footer>
</body>
</html>

<?php
$db->close();
?>