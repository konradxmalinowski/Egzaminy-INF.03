<?php

$conn = mysqli_connect('localhost', 'root', '', 'egzamin');

if (!$conn) {
    echo '<p>Błąd łączenia z bazą danych</p>';
    exit;
}

?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styl3.css">
    <title>Twoje BMI</title>
</head>

<body>
    <section id="logo">
        <img src="./wzor.png" alt="wzór BMI">
    </section>
    <header>
        <h1>Oblicz swoje BMI</h1>
    </header>
    <main>
        <table>
            <tr>
                <th>Interpretacja BMI</th>
                <th>Wartość minimalna</th>
                <th>Wartość maksymalna</th>
            </tr>
            <?php
            $wynik = mysqli_query($conn, 'select informacja, wart_min, wart_max from bmi;');

            if (mysqli_num_rows($wynik) === 0) {
                echo "<p>Błąd wykonywania zapytania</p>";
            } else {
                while ($row = mysqli_fetch_assoc($wynik)) {
                    $informacja = $row['informacja'];
                    $min = $row['wart_min'];
                    $max = $row['wart_max'];

                    echo "<tr>
                    <td>$informacja</td>
                    <td>$min</td>
                    <td>$max</td>
                    </tr>";
                }
            }
            ?>
        </table>
    </main>
    <section id="lewy">
        <h2>Podaj wagę i wzrost</h2>
        <form action="./bmi.php" method="post">
            <label>Waga: <input type="number" name="waga" id="waga" min="1"></label>
            <label>Wzrost w cm: <input type="number" name="wzrost" id="wzrost" min="1"></label>
            <button type="submit">Oblicz i zapamiętaj wynik</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['waga']) && isset($_POST['wzrost'])) {
            $waga = $_POST['waga'];
            $wzrost = $_POST['wzrost'];
            $bmi = $waga / ($wzrost * $wzrost) * 10000;

            echo "<p>Twoja waga: $waga; Twój wzrost: $wzrost <br> BMI wynosi: $bmi</p>";

            $informacjaBMI;
            $numerekBmi;
            if ($bmi <= 18 && $bmi > 0) {
                $informacjaBMI = 'niedowaga';
                $numerekBmi = 1;
            } else if ($bmi <= 25) {
                $informacjaBMI = 'waga prawidłowa';
                $numerekBmi = 2;
            } else if ($bmi <= 30) {
                $informacjaBMI = 'nadwaga';
                $numerekBmi = 3;
            } else if ($bmi <= 100) {
                $informacjaBMI = 'otyłość';
                $numerekBmi = 4;
            }

            $data = date('Y-m-d');
            $wynik = mysqli_query($conn, "INSERT INTO `wynik` (`id`, `bmi_id`, `data_pomiaru`, `wynik`) VALUES (NULL, $numerekBmi, '$data', $bmi);");

            if (!$wynik)
                echo mysqli_error($conn);
        }
        ?>
    </section>
    <section id="prawy">
        <img src="rys1.png" alt="ćwiczenia">
    </section>
    <footer>
        Autor: Konrad Malinowski
        <a href="./kwerendy.txt">Zobacz kwerendy</a>
    </footer>
</body>

</html>


<?php

mysqli_close($conn);

?>