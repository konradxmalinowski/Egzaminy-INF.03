<?php 
$db = new mysqli('localhost', 'root', '', 'matura');
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styl.css">
    <title>Matura</title>
</head>

<body>
    <header>
        <h1>System informacyjny dla maturzystów</h1>
    </header>
    <div class="kontener">
        <aside>
            <img src="ma.jpg" alt="Matura">
            <img src="tu.jpg" alt="Matura">
            <img src="ra.jpg" alt="Matura">
        </aside>
        <section class="sekcja-1">
            <?php

            if (isset($_GET['id']) && isset($_GET['nazwisko']) && isset($_GET['imie'])) {
                $id = $_GET['id'];
                $imie = $_GET['imie'];
                $nazwisko = $_GET['nazwisko'];

                echo "<h2>$imie $nazwisko</h2>";
                
                $zapytanie = "SELECT arkusz.rok, arkusz.sesja, arkusz.przedmiot, wynik.punkty FROM arkusz JOIN wynik ON arkusz.symbol = wynik.symbol WHERE wynik.maturzysta_id = $id;";
                $wynik = $db -> query($zapytanie);

                foreach ($wynik as $wiersz) {
                    $rok = $wiersz['rok'];
                    $sesja = $wiersz['sesja'];
                    $przedmiot = $wiersz['przedmiot'];
                    $punkty = $wiersz['punkty'];

                    echo 
                    "
                    <h3>$rok $sesja</h3>
                    <p>$przedmiot: $punkty</p>
                    "
                    ;
                }
            }

            ?>
        </section>
        <section class="sekcja-2">
            <div class="blok">
                <h4>Przedmioty</h4>
                <?php
                    $zapytanie = "SELECT DISTINCT przedmiot FROM arkusz;";
                    $wynik = $db -> query($zapytanie);
                    $przedmioty = [];
                    foreach ($wynik as $wiersz) {
                        $przedmiot = $wiersz['przedmiot'];
                        $przedmioty[] = $przedmiot;
                    }

                    echo implode(" ", $przedmioty);
                ?>
            </div>
            <div class="blok">
                <h4>Lata</h4>
                 <?php
                    $zapytanie = "SELECT MAX(rok) AS max_wartosc, MIN(rok) AS min_wartosc FROM arkusz;";
                    $wynik = $db -> query($zapytanie);
                    $wiersz = $wynik -> fetch_assoc();

                    $max = floatval($wiersz['max_wartosc']);
                    $min = floatval($wiersz['min_wartosc']);
                    echo "$min - $max";
                ?>
            </div>
            <div class="blok">
                <h4>Najlepszy wynik</h4>
                <?php
                    $zapytanie = "SELECT id, AVG(punkty) as 'Wynik' FROM wynik GROUP BY id ORDER BY AVG(punkty) DESC LIMIT 1;";
                    $wynik = $db -> query($zapytanie);
                    $wiersz = $wynik -> fetch_assoc();

                    $wynik = $wiersz['Wynik'];
                    echo $wynik . '%';
                ?>
            </div>
            <div class="blok">
                <h4>Najgorszy wynik</h4>
                <?php
                    $zapytanie = "SELECT id, AVG(punkty) as 'Wynik' FROM wynik GROUP BY id ORDER BY AVG(punkty) ASC LIMIT 1;";
                    $wynik = $db -> query($zapytanie);
                    $wiersz = $wynik -> fetch_assoc();

                    $wynik = $wiersz['Wynik'];
                    echo $wynik . '%';
                ?>
            </div>
        </section>

        <div class="clear-both"></div>
    </div>
    <footer>
        <p>Stronę wykonał: Konrad Malinowski</p>
    </footer>
</body>

</html>

<?php
$db -> close();
?>