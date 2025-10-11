<?php

$db = new mysqli('localhost', 'root', '', 'gry');
if ($db->connect_error) {
    echo "Błąd połączenia z bazą danych";
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styl.css">
    <title>Gry komputerowe</title>
</head>

<body>
    <header>
        <h1>Ranking gier komputerowych</h1>
    </header>
    <section class="lewy">
        <h3>Top 5 gier w tym miesiącu</h3>
        <ol>
            <?php
            $zapytanie = "select nazwa, punkty from gry order by punkty DESC limit 5";

            $wynik = $db->query($zapytanie);
            foreach ($wynik as $wiersz) {
                $nazwa = $wiersz['nazwa'];
                $punkty = $wiersz['punkty'];
                echo "<li>$nazwa <span class=\"punkty\">$punkty</span></li>";
            }
            ?>
        </ol>
        <h3>Nasz sklep</h3>
        <a href="http://sklep.gry.pl">Tu kupisz gry</a>
        <h3>Stronę wykonał</h3>
        <p>Konrad Malinowski</p>
    </section>
    <section class="srodkowy">
        <?php
        $zapytanie = "select id, nazwa, zdjecie from gry";
        $wynik = $db->query($zapytanie);
        foreach ($wynik as $wiersz) {
            $id = $wiersz['id'];
            $nazwa = $wiersz['nazwa'];
            $zdjecie = $wiersz['zdjecie'];
            echo "<div class=\"gra\">";
            echo "<img src=\"$zdjecie\" alt=\"$nazwa\" title=\"$id\" />";
            echo "<p>$nazwa</p>";
            echo "</div>";
        }

        echo "<div class=\"clear-both\"></div>";
        ?>
    </section>
    <section class="prawy">
        <h3>Dodaj nową grę</h3>
        <form action="gry.php" method="post">
            <label>nazwa<input type="text" id="nazwa" name="nazwa"></label>
            <label>opis<input type="text" id="opis" name="opis"></label>
            <label>cena<input type="number" id="cena" name="cena"></label>
            <label>zdjęcie<input type="text" id="zdjecie" name="zdjecie"></label>
            <button type="submit">DODAJ</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['nazwa'])) {
                $nazwa = $_POST['nazwa'];
                $opis = $_POST['opis'];
                $cena = $_POST['cena'];
                $zdjecie = $_POST['zdjecie'];

                $zapytanie = "insert into gry (nazwa, opis, punkty, cena, zdjecie) values ('$nazwa', '$opis', 0, $cena, '$zdjecie');";
                $db->query($zapytanie);
            }
        }
        ?>

    </section>
    <footer>
        <form action="gry.php" method="post">
            <input type="number" id="id" name="id">
            <button type="submit">Pokaż opis</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['id'])) {
                $id = $_POST['id'];

                $zapytanie = "select nazwa, left(opis, 100) as opis, punkty, cena from gry where id = $id";
                $wynik = $db->query($zapytanie);
                foreach ($wynik as $wiersz) {
                    $nazwa = $wiersz['nazwa'];
                    $opis = $wiersz['opis'];
                    $punkty = $wiersz['punkty'];
                    $cena = $wiersz['cena'];

                    echo "<h2>
                    $nazwa, $punkty punktów, $cena zł
                    </h2>";
                    echo "<p>$opis</p>";
                }
            }
        }
        ?>
    </footer>
</body>

</html>

<?php
$db->close();
?>