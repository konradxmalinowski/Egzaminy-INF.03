<?php
include('baza.php');
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Firma przewozowa</title>
</head>

<body>
    <header>
        <h1>Firma przewozowa Póldarmo</h1>
    </header>
    <nav>
        <a href="kw1.png">kwerenda1</a>
        <a href="kw2.png">kwerenda2</a>
        <a href="kw3.png">kwerenda3</a>
        <a href="kw4.png">kwerenda4</a>
    </nav>
    <main>
        <section class="sekcja-lewa">
            <h2>Zadania do wykonania</h2>
            <table>
                <tr>
                    <th>Zadanie do wykonania</th>
                    <th>Data realizacji</th>
                    <th>Akcja</th>
                </tr>

                <?php
                    $zapytanie = "SELECT id_zadania, zadanie, data FROM zadania;";
                    $wynik = $baza -> query($zapytanie);
                    foreach ($wynik as $wiersz) {
                        $id = intval($wiersz['id_zadania']);
                        $zadanie = $wiersz['zadanie'];
                        $data = $wiersz['data'];

                        echo "
                        <tr>
                            <td>$zadanie</td>
                            <td>$data</td>
                            <td><a href=\"usun.php?id=$id\">Usuń</a></td>
                        </tr>
                        ";
                    }
                ?> 
            </table>

            <form action="przewozy.php" method="post">
                <label for="zadanie">Zadanie do wykonania</label>
                <input type="text" name="zadanie" id="zadanie"> <br>
                <label for="data">Data realizacji: </label>
                <input type="date" name="data" id="data">
                <button type="submit">Dodaj</button>
            </form>

            <?php

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $zadanie = $_POST['zadanie'];
                    $data = $_POST['data'];

                    $zapytanie = "INSERT INTO zadania (zadanie, data, osoba_id) VALUES ('$zadanie', '$data', 1)";
                    $baza -> query($zapytanie);
                }
                
            ?>
        </section>
        <section class="sekcja-prawa">
            <img src="auto.png" alt="auto firmowe">
            <h3>Nasza spacjalność</h3>
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
$baza -> close();
?>