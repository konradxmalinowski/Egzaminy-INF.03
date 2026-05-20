<?php 
$db = new mysqli('localhost', 'root', '', 'zgloszenia');
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styl.css">
    <title>ZGŁOSZENIA</title>
</head>
<body>
    <header><h1>Zgłoszenia wydarzeń</h1></header>
    <main>
        <section class="sekcja-lewa">
            <h2>Personel</h2>
            <form action="index.php" method="post">
                <label><input type="radio" name="typ" id="ratownik" value="ratownik" checked>Ratownik</label>
                <label><input type="radio" name="typ" id="policjant" value="policjant">Policjant</label>
                <button type="submit">Pokaż</button>
            </form>

            <?php 
                $typ;
                if (isset($_POST['typ'])) $typ = $_POST['typ'];
                else $typ = 'policjant';

                echo "<h3>Wybrano opcję: $typ</h3>";

                $zapytanie = "SELECT id, imie, nazwisko FROM personel WHERE status = '$typ';";
                $wynik = $db -> query($zapytanie);
            ?>

            <table>
                <tr>
                    <th>Id</th>
                    <th>Imię</th>
                    <th>Nazwisko</th>
                </tr>

                <?php
                    foreach ($wynik as $wiersz) {
                        $id = intval($wiersz['id']);    
                        $imie = $wiersz['imie'];    
                        $nazwisko = $wiersz['nazwisko'];    
                        echo
                        "
                        <tr>
                        <td>$id</td>    
                        <td>$imie</td>    
                        <td>$nazwisko</td>    
                        </tr>
                        ";
                    }
                ?>
            </table>
        </section>
        <section class="sekcja-prawa">
            <h2>Nowe zgłoszenie</h2>
            <ol>
                <?php
                    $zapytanie = "SELECT personel.id, personel.nazwisko FROM personel LEFT JOIN rejestr ON rejestr.id_personel = personel.id WHERE rejestr.id IS NULL;";
                    $wynik = $db -> query($zapytanie);
                    
                    foreach ($wynik as $wiersz) {
                        $id = intval($wiersz['id']);
                        $nazwisko = $wiersz['nazwisko'];

                        echo "<li>$id $nazwisko</li>";
                    }
                ?>
            </ol>

            <form action="index.php" method="post">
                <label for="id-osoby">Wybierz id osoby z listy: </label>
                <input type="number" name="id-osoby" id="id-osoby">
                <button type="submit">Dodaj zgłoszenie</button>
            </form>

            <?php 
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id-osoby'])) {
                    $id_osoby = intval($_POST['id-osoby']);
                    $zapytanie = "INSERT INTO rejestr (id_personel, id_pojazd, data) VALUES ($id_osoby, 14, CURRENT_DATE());";
                    $db -> query($zapytanie);
                }
            ?>
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