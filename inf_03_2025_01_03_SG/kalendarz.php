<?php

$conn = new mysqli("localhost", "root", "", "kalendarz");
if ($conn->connect_error) {
    echo "Błąd połączenia z bazą danych";
    exit;
}

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styl.css">
    <title>Kalendarz</title>
</head>

<body>
    <header>
        <h1>Dni, miesiące, lata...</h1>
    </header>
    <section class="napis">
        <p><?php
        $data = Date('m-d');
        $dayOfWeek = Date('w');
        $fullDate = Date('Y-m-d');
        switch ($dayOfWeek) {
            case 0:
                $dayOfWeek = "Niedziela";
                break;
            case 1:
                $dayOfWeek = "Poniedziałek";
                break;
            case 2:
                $dayOfWeek = "Wtorek";
                break;
            case 3:
                $dayOfWeek = "Środa";
                break;
            case 4:
                $dayOfWeek = "Czwartek";
                break;
            case 5:
                $dayOfWeek = "Piątek";
                break;
            case 6:
                $dayOfWeek = "Sobota";
                break;
            default:
                $dayOfWeek = "nieznany dzień tygodnia";
        }

        $sql = "select imiona from imieniny where data = '$data'";
        $result = $conn->query($sql);

        if ($result->num_rows === 0) {
            echo "Brak imienin";
        } else {
            $wiersz = $result->fetch_assoc();
            if (!$wiersz) {
                echo "Błąd pobierania danych z bazy danych";
            } else {
                $imiona = $wiersz["imiona"];
                echo "Dzisiaj jest $dayOfWeek, $fullDate, imieniny: $imiona";
            }
        }
        ?></p>
    </section>
    <section class="lewy-blok">
        <table>
            <tr>
                <th class="pierwsza-kolumna-wiersz">liczba dni</th>
                <th>miesiąc</th>
            </tr>
            <tr>
                <td rowspan="7">31</td>
                <td>styczeń</td>
            </tr>
            <tr>
                <td>marzec</td>
            </tr>
            <tr>
                <td>maj</td>
            </tr>
            <tr>
                <td>lipiec</td>
            </tr>
            <tr>
                <td>sierpień</td>
            </tr>
            <tr>
                <td>październik</td>
            </tr>
            <tr>
                <td>grudzień</td>
            </tr>
            <tr>
                <td rowspan="4">30</td>
                <td>kwiecień</td>
            </tr>
            <tr>
                <td>czerwiec</td>
            </tr>
            <tr>
                <td>wrzesień</td>
            </tr>
            <tr>
                <td>listopad</td>
            </tr>
            <tr>
                <td>28 lub 29</td>
                <td>luty</td>
            </tr>
        </table>
    </section>
    <section class="srodkowy-blok">
        <h2>Sprawdź kto ma urodziny</h2>
        <form action="kalendarz.php" method="post">
            <input type="date" name="data" id="data" min="2024-01-01" max="2024-12-31" required>
            <button type="submit">wyślij</button>

        </form>

        <?php

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['data']) && $_POST['data'] !== '') {
                $fullDate = $_POST['data'];
                $formattedData = substr($fullDate, 5);
                $sql = "select imiona from imieniny where data = '$formattedData';";
                $result = $conn->query($sql);

                if ($result->num_rows === 0) {
                    echo "Błąd pobierania imion";
                } else {
                    $data = $result->fetch_assoc();
                    $names = $data['imiona'];
                    echo "Dnia $fullDate są imieniny: $names";
                }
            } else {
                echo "Podaj wymagane dane";
            }
        }

        $conn->close();

        ?>
    </section>
    <section class="prawy-blok">
        <img src="kalendarz.gif" alt="Kalendarz Majów"
            onclick="window.open(`https://pl.wikipedia.org/wiki/Kalendarz_Majów`)">
        <h2>Rodzaje kalendarzy</h2>
        <ol>
            <li>
                słoneczny
                <ul>
                    <li>kalendarz Majów</li>
                    <li>juliański</li>
                    <li>gregoriański</li>
                </ul>
            </li>

            <li>
                księżycowy
                <ul>
                    <li>starogrecki</li>
                    <li>babiloński</li>
                </ul>
            </li>

        </ol>
    </section>
    <footer>
        <p>Stronę opracował: Konrad Malinowski</p>
    </footer>
</body>

</html>