<?php

$db = new mysqli('localhost', 'root', '', 'piekarnia');
if ($db->connect_error) {
    echo "Błąd połączenia z bazą danych";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>PIEKARNIA</title>
</head>

<body>
    <img src="wypieki.png" alt="Produkty naszej piekarni">
    <nav>
        <a href="">KWERENDA 1</a>
        <a href="">KWERENDA 2</a>
        <a href="">KWERENDA 3</a>
        <a href="">KWERENDA 4</a>
    </nav>
    <header>
        <h1>WITAMY</h1>
        <h4>NA STRONIE PIEKARNI</h4>
        <p>Od 31 lat oferujemy najwyższej jakości pieczywo. Naturalnie świeże, naturalnie smaczne. Pieczemy
            wyłącznie wypieki na naturalnym zakwasie bez polepszaczy i zagęstników. Korzystamy wyłącznie z
            najlepszych ziaren pochodzących z ekologicznych upraw położonych w rejonach zgierskim i ozorkowskim.</p>
    </header>
    <main>
        <h4>Wybierz rodzaj wypieków:</h4>
        <form action="piekarnia.php" method="post">
            <select name="rodzaj" id="rodzaj">
                <?php
                $zapytanie = "select DISTINCT Rodzaj from wyroby order by Rodzaj DESC";
                $wynik = $db->query($zapytanie);
                foreach ($wynik as $wiersz) {
                    $rodzaj = $wiersz['Rodzaj'];
                    echo "<option value=\"$rodzaj\">$rodzaj</option>";
                }
                ?>
            </select>
            <button type="submit">Wybierz</button>
        </form>

        <table>
            <tr>
                <th>Rodzaj</th>
                <th>Nazwa</th>
                <th>Gramatura</th>
                <th>Cena</th>
            </tr>
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $rodzaj = $_POST['rodzaj'];
                $zapytanie = "select Rodzaj, Nazwa, Gramatura, Cena from wyroby WHERE Rodzaj = '$rodzaj'";
                $wynik = $db->query($zapytanie);
                foreach ($wynik as $wiersz) {
                    $rodzaj = $wiersz['Rodzaj'];
                    $nazwa = $wiersz['Nazwa'];
                    $gramatura = $wiersz['Gramatura'];
                    $cena = $wiersz['Cena'];
                    echo "<tr>";
                    echo "<td>$rodzaj</td>";
                    echo "<td>$nazwa</td>";
                    echo "<td>$gramatura</td>";
                    echo "<td>$cena</td>";
                    echo "</tr>";
                }
            }

            $db->close();
            ?>
        </table>
    </main>
    <footer>
        <p>AUTOR: Konrad Malinowski</p>
        <p>Data: data</p>
    </footer>
</body>

</html>