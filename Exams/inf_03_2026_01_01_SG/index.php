<?php
$db = new mysqli('localhost', 'root', '', 'samochody');
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styl.css">
    <title>Konfigurator samochodów</title>
</head>

<body>
    <header>
        <h1>Serwis konfiguracji samochodów</h1>
    </header>
    <nav>
        <h2>Samochody</h2>
        <h2>Konfigurator</h2>
        <h2>Kontakt</h2>
    </nav>
    <main>
        <section class="sekcja-lewa">
            <table>
                <?php
                    $zapytanie = "SELECT pojazdy.marka, pojazdy.model, pojazdy.cena, kolory.nazwa, kolory.doplata FROM pojazdy JOIN kolory ON pojazdy.kolor = kolory.id WHERE pojazdy.model = 'alfa'";
                    $wynik = $db -> query($zapytanie);
                    foreach ($wynik as $wiersz) {
                        $marka = $wiersz['marka'];
                        $model = $wiersz['model'];
                        $cena = intval($wiersz['cena']);
                        $doplata = intval($wiersz['doplata']);
                        $kolor = $wiersz['nazwa'];
                        $suma = $cena + $doplata;

                        echo 
                        "
                        <tr>
                            <td>$marka</td>
                            <td>$model</td>
                            <td>$kolor</td>
                            <td>$suma</td>
                        </tr>
                        ";
                    }
                ?>
            </table>
        </section>
        <section class="sekcja-srodkowa">
            <?php 
                $zapytanie = "SELECT marka, model, cena FROM pojazdy ORDER BY rand() LIMIT 2;";
                $wynik = $db -> query($zapytanie);
                $wiersze = [];
                
                foreach ($wynik as $wiersz) {
                    $wiersze[] = $wiersz;
                }

            ?>
            <table>
                <tr>
                    <th colspan="2">Konfiguracja</th>
                    <th>Cena</th>
                </tr>
                <tr>
                    <td colspan="3"><img src="a1.jpg" alt="">Konfiguracja 1</td>
                </tr>
                <?php 
                    $marka = $wiersze[0]["marka"];
                    $model = $wiersze[0]["model"];
                    $cena = $wiersze[0]["cena"];
                    echo
                    "
                    <tr>
                        <td>Marka</td>
                        <td>Model</td>
                        <td rowspan=\"2\">$cena</td>
                    </tr>
                        <tr>
                        <td>$marka</td>
                        <td>$model</td>
                    </tr>
                    "; 
                ?>
                <tr>
                    <td colspan="3">
                        <img src="a2.jpg" alt="Konfiguracja 2">
                    </td>
                </tr>

                <?php
                    $marka = $wiersze[1]["marka"];
                    $model = $wiersze[1]["model"];
                    $cena = $wiersze[1]["cena"];
                    echo
                    "
                    <tr>
                        <td>Marka</td>
                        <td>Model</td>
                        <td rowspan=\"2\">$cena</td>
                    </tr>
                        <tr>
                        <td>$marka</td>
                        <td>$model</td>
                    </tr>
                    "; 
                ?>
            </table>
        </section>
        <section class="sekcja-prawa">
            <h3>111 222 444</h3>
            <img src="a3.png" alt="Samochód">
        </section>
    </main>
    <footer>
        <p>Stronę wykonał: Konrad Malinowski</p>
    </footer>
</body>

</html>

<?php
$db -> close();
?>