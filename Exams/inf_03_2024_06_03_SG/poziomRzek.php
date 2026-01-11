<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styl.css">
    <title>Poziomy rzek</title>
</head>

<body>
    <header>
        <section class="header-lewy"><img src="./obraz1.png" alt="Mapa Polski"></section>
        <section class="header-prawy">
            <h1>Rzeki w województwie
                dolnośląskim</h1>
        </section>
        <div class="clear"></div>
    </header>
    <section class="menu">
        <form action="./poziomRzek.php" method="post">
            <label class="stany"><input type="radio" name="stany" value="wszystkie" id="wszystkie">Wszystkie</label>
            <label class="stany"><input type="radio" name="stany" id="ponad-stan-ostrzegawczy"
                    value="ponad-stan-ostrzegawczy">Ponad stan ostrzegawczy</label>
            <label class="stany"><input type="radio" name="stany" id="ponad-stan-alarmowy"
                    value="ponad-stan-alarmowy">Ponad stan alarmowy</label>
            <button type="submit">Pokaż</button>
        </form>
    </section>
    <section class="lewy">
        <h3>Stany na dzień 2022-05-05</h3>
        <table>
            <tr>
                <th>Wodomierz</th>
                <th>Rzeka</th>
                <th>Ostrzegawczy</th>
                <th>Alarmowy</th>
                <th>Aktualny</th>
            </tr>
            <?php

            $conn = new mysqli('localhost', 'root', '', 'rzeki');
            if ($conn->connect_error) {
                echo "<p>Błąd łączenia z bazą danych</p>";
                exit;
            }
            $wybranaOpcja;
            $zapytanie;
            $dane;

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['stany'])) {
                $wybranaOpcja = $_POST['stany'];

                switch ($wybranaOpcja) {
                    case 'wszystkie': {
                        $zapytanie = "select nazwa, rzeka, stanOstrzegawczy, stanAlarmowy, stanWody from wodowskazy join pomiary on pomiary.wodowskazy_id = wodowskazy.id where dataPomiaru = '2022-05-05';";
                        break;
                    }
                    case 'ponad-stan-ostrzegawczy': {
                        $zapytanie = "select nazwa, rzeka, stanOstrzegawczy, stanAlarmowy, stanWody from wodowskazy join pomiary on pomiary.wodowskazy_id = wodowskazy.id where dataPomiaru = '2022-05-05' and stanWody > stanOstrzegawczy;";
                        break;
                    }
                    case 'ponad-stan-alarmowy': {
                        $zapytanie = "select nazwa, rzeka, stanOstrzegawczy, stanAlarmowy, stanWody from wodowskazy join pomiary on pomiary.wodowskazy_id = wodowskazy.id where dataPomiaru = '2022-05-05' and stanWody > stanAlarmowy;";
                        break;
                    }
                    default: {
                        $zapytanie = '';
                    }
                }

                if ($zapytanie) {
                    $wynik = $conn->query($zapytanie);

                    if ($wynik) {
                        while ($wiersz = mysqli_fetch_assoc($wynik)) {
                            echo "<tr>";
                            $wodomierz = $wiersz['nazwa'];
                            $rzeka = $wiersz['rzeka'];
                            $stanOstrzegawczy = $wiersz['stanOstrzegawczy'];
                            $stanAlarmowy = $wiersz['stanAlarmowy'];
                            $aktualny = $wiersz['stanWody'];
                            echo "
                            <td>$wodomierz</td>
                            <td>$rzeka</td>
                            <td>$stanOstrzegawczy</td>
                            <td>$stanAlarmowy</td>
                            <td>$aktualny</td>
                            ";
                            echo "</tr>";
                        }
                    }
                }
            }

            ?>
        </table>
    </section>
    <section class="prawy">
        <h3>Informacje</h3>
        <ul>
            <li>Brak ostrzeżeń o burzach
                z gradem</li>
            <li>Smog w mieście Wrocław</li>
            <li>Silny wiatr w Karkonoszach</li>
        </ul>
        <h3>Średnie stany wód</h3>
        <?php
        $zapytanie = "select dataPomiaru, avg(stanWody) as srednia from pomiary group by 1";
        $wynik = $conn->query($zapytanie);
        if ($wynik) {
            while ($dane = mysqli_fetch_assoc($wynik))
                if ($wynik->num_rows) {
                    $data = $dane['dataPomiaru'];
                    $srednia = $dane['srednia'];

                    echo "<p>$data: $srednia</p>";
                }
        }

        $conn->close();

        ?>
        <a href="https://komunikaty.pl">Dowiedz się wiecej</a>
        <img src="./obraz2.jpg" alt="rzeka">
    </section>
    <footer>
        <p>Stronę wykonał: Konrad Malinowski</p>
    </footer>
</body>

</html>
