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
            <h3>Wybierz ucznia z listy: </h3>
            <?php
                $zapytanie = "SELECT id, imie, nazwisko FROM maturzysta WHERE szkola = 'T3' ORDER BY nazwisko DESC;";
                $wynik = $db -> query($zapytanie);
                foreach ($wynik as $wiersz) {
                    $id = $wiersz['id'];
                    $imie = $wiersz['imie'];
                    $nazwisko = $wiersz['nazwisko'];
                    echo "<a href=\"wynik.php?id=$id&nazwisko=$nazwisko&imie=$imie\">$id. $imie $nazwisko</a><br>";
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