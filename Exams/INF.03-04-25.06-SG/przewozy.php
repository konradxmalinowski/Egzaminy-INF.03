<?php

$db = new mysqli("localhost", 'root', '', 'przewozy');
if ($db->connect_error) {
    echo "<p>Błąd połączenia z bazą danych</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Firma Przewozowa</title>
</head>

<body>
    <header>
        <h1>Firma przewozowa Półdarmo</h1>
    </header>
    <nav>
        <a href="">kwerenda1</a>
        <a href="">kwerenda2</a>
        <a href="">kwerenda3</a>
        <a href="">kwerenda4</a>
    </nav>
    <main>
        <section class="lewa-sekcja">
            <h2>Zadania do wykonania</h2>
            <table>
                <tr>
                    <th>Zadanie do wykonania</th>
                    <th>Data realizacji</th>
                    <th>Akcja</th>
                </tr>

                <?php
                $zapytanie = "select id_zadania, zadanie, data from zadania;";
                $wynik = $db->query($zapytanie);

                foreach ($wynik as $wiersz) {
                    $zadanie = $wiersz['zadanie'];
                    $data = $wiersz['data'];
                    $id = $wiersz['id_zadania'];

                    echo "<tr>";
                    echo "<td>$zadanie</td>";
                    echo "<td>$data</td>";
                    echo "<td><a href=\"usun.php?id=$id\" >Usuń</a></td>";
                    echo "</tr>";
                }
                ?>
            </table>

            <form action="przewozy.php" method="post">
                <label>Zadanie do wykonania: <input type="text" name="zadanie" id="zadanie"></label>
                <label>Data realizacji: <input type="date" name="data" id="data"></label>
                <button type="submit">Dodaj</button>
            </form>

            <?php

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = $_POST['data'];
                $zadanie = $_POST['zadanie'];
                $zapytanie = "insert into zadania (data, osoba_id, zadanie) VALUES ('$data', 1, '$zadanie');";
                $db->query($zapytanie);
            }

            ?>
        </section>
        <section class="prawa-sekcja">
            <img src="auto.png" alt="auto firmowe">
            <h3>Nasza specjalność</h3>
            <ul>
                <li>Przeprowadzki</li>
                <li>Przewóz mebli</li>
                <li>Przesyłki gabarytowe</li>
                <li>Wynajem pojazdów</li>
                <li>Zakupy towarów</li>
            </ul>
        </section>
    </main>
    <footer>
        <p>Stronę wykonał: Konrad Malinowski</p>
    </footer>
</body>

</html>


<?php
$db->close();
?>