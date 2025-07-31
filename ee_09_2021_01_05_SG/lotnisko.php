<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styl5.css">
    <title>Port lotniczy</title>
</head>

<body>
    <header>
        <section class="baner1">
            <img src="./zad5.png" alt="logo lotnisko">
        </section>
        <section class="baner2">
            <h1>Przyloty</h1>
        </section>
        <section class="baner3">
            <h3>przydatne linki</h3>
            <a href="./kwerendy.txt" target="_blank">Pobierz...</a>
        </section>
        <div class="clear-both"></div>
    </header>
    <main>
        <table>
            <tr>
                <th>czas</th>
                <th>kierunek</th>
                <th>numer rejsu</th>
                <th>status</th>
            </tr>
            <?php
            $conn = new mysqli('localhost', 'root', '', 'egzamin');
            if ($conn->connect_error) {
                echo "<p>Błąd połączenia z bazą danych</p>";
            } else {
                $zapytanie = "select czas, kierunek, nr_rejsu, status_lotu from przyloty order by czas asc;";
                $wynik = $conn->query($zapytanie);

                if ($wynik && $wynik->num_rows > 0) {
                    while ($dane = $wynik->fetch_assoc()) {
                        $czas = $dane['czas'] ?? '';
                        $kierunek = $dane['kierunek'] ?? '';
                        $nr_rejsu = $dane['nr_rejsu'] ?? '';
                        $status = $dane['status_lotu'] ?? '';

                        echo "<tr>
                        <td>$czas</td>
                        <td>$kierunek</td>
                        <td>$nr_rejsu</td>
                        <td>$status</td>
                        </tr>";
                    }
                }

                $conn->close();
            }
            ?>
        </table>
    </main>
    <footer>
        <section class="stopka1">
            <?php
            if (!isset($_COOKIE['odwiedziny'])) {
                echo '<p class="bold">Dzień dobry! Strona lotniska używa ciasteczek</p>';
                setcookie('odwiedziny', 'odwiedziny', time() + 2 * 60 * 60);
            } else {
                echo '<p class="ciasteczko-parapraf">Witaj ponownie na stronie lotniska</p>';
            }
            ?>
        </section>
        <section class="stopka2">
            Autor: Konrad Malinowski
        </section>
        <div class="clear-both"></div>
    </footer>
</body>

</html>