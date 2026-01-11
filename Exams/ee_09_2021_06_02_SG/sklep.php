<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styl2.css">
    <title>Warzywniak</title>
</head>

<body>
    <header>
        <section class="lewy">
            <h1>Internetowy sklep z eko-warzywami</h1>
        </section>
        <section class="prawy">
            <ol>
                <li>warzywa</li>
                <li>owoce</li>
                <li><a href="https://terapiasokami.pl/" target="_blank">soki</a></li>

            </ol>
        </section>
        <div class="clear-both"></div>
    </header>
    <main>

        <?php
        $conn = new mysqli('localhost', 'root', '', 'dane2');
        if ($conn->connect_error) {
            echo "<p>Błąd łączenie z bazą danych</p>";
        } else {
            $zapytanie = "select nazwa, ilosc, opis, cena, zdjecie from produkty where rodzaje_id in (1, 2);";
            $wynik = $conn->query($zapytanie);
            $dane;

            if ($wynik) {
                while ($dane = $wynik->fetch_assoc()) {
                    $obraz = $dane['zdjecie'];
                    $nazwa = $dane['nazwa'];
                    $opis = $dane['opis'];
                    $ilosc = $dane['ilosc'];
                    $cena = $dane['cena'];
                    echo "<section class='wygenerowany-blok'>
                    <img src='$obraz' alt='warzywniak'/>
                    <h5>$nazwa</h5>
                    <p>opis: $opis</p>
                    <p>na stanie: $ilosc</p>
                    <h5>$cena zł</h5>
                    </section>";
                }
            }
        }
        ?>

    </main>
    <footer>
        <form action="./sklep.php" method="post">
            <label>Nazwa<input type="text" id="nazwa" name="nazwa"></label>
            <label>Cena<input type="number" id="cena" name="cena"></label>
            <button type="submit">Dodaj produkt</button>
        </form>

        <?php

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nazwa = $_POST['nazwa'];
            $cena = $_POST['cena'];

            $zapytanie = "insert into produkty (Rodzaje_id, Producenci_id, nazwa, ilosc, opis, cena, zdjecie) VALUES (1, 4, '$nazwa', 10, null, $cena, 'owoce.jpg');";
            $wynik = $conn->query($zapytanie);
            if (!$wynik) {
                echo '<p>Błąd dodawania produktu</p>';
            }
        }


        $conn->close();
        ?>
        Stronę wykonał Konrad Malinowski
    </footer>
</body>

</html>