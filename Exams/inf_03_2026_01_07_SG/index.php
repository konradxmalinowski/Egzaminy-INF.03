<?php
$db = new mysqli("localhost", "root", "", "pogoda");
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styl.css">
    <title>Pogoda</title>
</head>
<body>
    <header>
        <section class="header-lewy">
            <img src="slonce.png" alt="Słonecznie">
        </section>
        <section class="header-prawy">
            <h1>Pogoda w Europie</h1>
        </section>
    </header>
    <main>
        <section class="sekcja-lewa">
            <h2>Temperatury w lipcu</h2>
            <table>
                <tr>
                    <th>Miasto</th>
                    <th>Kraj</th>
                    <th>Temperatura</th>
                    <th>Pogoda</th>
                </tr>

                <?php 
                    $zapytanie = "SELECT miejscowosc.nazwa, miejscowosc.kraj, pomiary.temperatura FROM miejscowosc JOIN pomiary on pomiary.id_miejscowosc = miejscowosc.id WHERE pomiary.id_miesiac = 7";
                    $rezultat = $db -> query($zapytanie);
                    foreach ($rezultat as $wiersz) {
                        $miejscowosc = $wiersz['nazwa'];
                        $kraj = $wiersz['kraj'];
                        $temperatura = intval($wiersz['temperatura']);
                        $obrazek = "";

                        if ($temperatura > 30) $obrazek = "slonce.png";
                        else if ($temperatura < 26) $obrazek = "deszcz.png";
                        else $obrazek = "chmury.png";

                        echo "
                        <tr>
                            <td>$miejscowosc</td>
                            <td>$kraj</td>
                            <td>$temperatura</td>
                            <td><img src=\"$obrazek\" alt=\"ikona pogody\"></td>
                        </tr>
                        ";
                    }
                ?>
            </table>
        </section>
        <section class="sekcja-prawa">
            <h2>Średnie temperatury w roku</h2>
            <a href="index.php?id=1">Styczeń</a>
            <a href="index.php?id=2">Luty</a>
            <a href="index.php?id=3">Marzec</a>
            <a href="index.php?id=4">Kwiecień</a>
            <a href="index.php?id=5">Maj</a>
            <a href="index.php?id=6">Czerwiec</a>
            <a href="index.php?id=7">Lipiec</a>
            <a href="index.php?id=8">Siepień</a>
            <a href="index.php?id=9">Wrzesień</a>
            <a href="index.php?id=10">Październik</a>
            <a href="index.php?id=11">Listopad</a>
            <a href="index.php?id=12">Grudzień</a>

            <p>Średnia temperatura wybranego miesiaca wynosi: </p>

            <?php
                if (isset($_GET['id'])) {
                    $id = intval($_GET['id']);
                    $zapytanie = "SELECT ROUND(AVG(temperatura), 2) FROM pomiary WHERE id_miesiac = 7;";
                    $rezultat = $db -> query($zapytanie);
                    $wiersz = $rezultat -> fetch_assoc();
                    $temp = floatval($wiersz['AVG(temperatura)']);

                    echo "<h3>$temp stopni</h3>";
                }
                
            ?>
        </section>

        <div class="clear-both"></div>
    </main>
    <footer>
        <p>Numer zdajacego: Konrad Malinowski</p>
    </footer>
</body>
</html>

<?php
$db -> close();
?>