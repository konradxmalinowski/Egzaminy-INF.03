<?php

$conn = new mysqli('localhost', 'root', '', 'wazenietirow');
if ($conn->error) {
    echo "<p>Błąd łączenia z bazą danych</p>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styl2.css">
    <title>Ważenie samochodów ciężarowych</title>
</head>

<body>
    <header>
        <section class="baner-lewy">
            <h1>Ważenie pojazdów we Wrocławiu</h1>
        </section>
        <section class="baner-prawy"><img src="obraz1.png" alt="waga"></section>
        <div class="clear-both"></div>
    </header>
    <section class="lewy">
        <h2>Lokalizacje wag</h2>
        <ol>
            <?php
            $zapytanie = 'select ulica from lokalizacje';
            $wynik = $conn->query($zapytanie);
            if (!$wynik) {
                echo "<p>Brak lokalizacji</p>";
            } else {
                while ($wiersz = $wynik->fetch_assoc()) {
                    $ulica = $wiersz['ulica'];
                    echo "<li>ulica $ulica</li>";
                }
            }
            ?>


        </ol>
        <h2>Kontakt</h2>
        <a href="mailto:wazenie@wroclaw.pl">napisz</a>
    </section>
    <main>
        <h2>Alerty</h2>
        <table>
            <tr>
                <th>rejestracja</th>
                <th>ulica</th>
                <th>waga</th>
                <th>dzień</th>
                <th>czas</th>
            </tr>
            <?php
            $zapytanie = "select rejestracja, ulica, waga, dzien, czas from wagi join lokalizacje on lokalizacje.id = wagi.lokalizacje_id where waga > 5;";
            $wynik = $conn->query($zapytanie);
            if (!$wynik) {
                echo "<p>Brak danych</p>";
            } else {
                while ($wiersz = $wynik->fetch_assoc()) {
                    $rejestracja = $wiersz['rejestracja'];
                    $ulica = $wiersz['ulica'];
                    $waga = $wiersz['waga'];
                    $dzien = $wiersz['dzien'];
                    $czas = $wiersz['czas'];

                    echo "<tr>
                        <td>$rejestracja</td>
                        <td>$ulica</td>
                        <td>$waga</td>
                        <td>$dzien</td>
                        <td>$czas</td>
                    </tr>";
                }
            }

            ?>
        </table>
    </main>
    <section class="prawy">
        <img src="./obraz2.jpg" alt="tir" class="obraz2">
    </section>
    <footer>
        <p>Stronę wykonał: Konrad Malinowski</p>
    </footer>

    <?php
    $zapytanie = "insert into wagi (lokalizacje_id, waga, rejestracja, dzien, czas) VALUES (5, FLOOR(RAND() * (10 - 1 + 1) + 1), 'DW12345', CURRENT_DATE(), CURRENT_TIME());";
    $wynik = $conn->query($zapytanie);
    if (!$wynik) {
        echo "<p>Błąd dodawania nowych wierszy do bazy</p>";
        exit;
    }

    echo "<script>
    setTimeout(() => {
        window.document.location.reload();
    }, 10000);

</script>"
        ?>
</body>

</html>


<?php
$conn->close();

?>