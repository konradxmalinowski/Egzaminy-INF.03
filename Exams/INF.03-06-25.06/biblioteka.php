<?php
$db = new mysqli("localhost", "root", "", "biblioteka");
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styl.css">
    <title>Biblioteka miejska</title>
</head>
<body>
    <header>
        <?php
            for ($i = 1; $i <= 20; $i++) {
                echo "<img src=\"obraz.png\" alt=\"tekst alternatywny dla obraz.png\" />";
            }
        ?>
    </header>
    <section class="section1">
        <h2>Liryka</h2>
        <form action="biblioteka.php" method="post">
            <select name="liryka" id="liryka">
                <?php
                    $zapytanie = "SELECT id, tytul FROM ksiazka WHERE gatunek = 'liryka';";
                    $dane = $db -> query($zapytanie);
                    foreach ($dane as $wiersz) {
                        $id = $wiersz['id'];
                        $tytul = $wiersz['tytul'];
                        echo "<option value=\"$id\">$tytul</option>";
                    }
                ?>
            </select>
            <button type="submit" name="rezerwuj-liryka">Rezerwuj</button>
        </form>

        <?php
            if (isset($_POST['rezerwuj-liryka'])) {
                $id = $_POST['liryka'];
                $zapytanie = "SELECT tytul from ksiazka where id = $id;";
                $dane = $db -> query($zapytanie);
                $wiersz = $dane -> fetch_assoc();
                $ksiazka = $wiersz['tytul'];
                echo "<p>Książka $ksiazka jest zarezerwowana</p>";
                
                $zapytanie = "UPDATE ksiazka SET rezerwacja = 1 WHERE ksiazka.id = $id;";
                $db -> query($zapytanie);
            }
        ?>
    </section>
    <section class="section2">
        <h2>Epika</h2>
        <form action="biblioteka.php" method="post">
            <select name="epika" id="epika">
                 <?php
                    $zapytanie = "SELECT id, tytul FROM ksiazka WHERE gatunek = 'epika';";
                    $dane = $db -> query($zapytanie);
                    foreach ($dane as $wiersz) {
                        $id = $wiersz['id'];
                        $tytul = $wiersz['tytul'];
                        echo "<option value=\"$id\">$tytul</option>";
                    }
                ?>
            </select>
            <button type="submit" name="rezerwuj-epika">Rezerwuj</button>
        </form>

         <?php
            if (isset($_POST['rezerwuj-epika'])) {
                $id = $_POST['epika'];
                $zapytanie = "SELECT tytul from ksiazka where id = $id;";
                $dane = $db -> query($zapytanie);
                $wiersz = $dane -> fetch_assoc();
                $ksiazka = $wiersz['tytul'];
                echo "<p>Książka $ksiazka jest zarezerwowana</p>";
                
                $zapytanie = "UPDATE ksiazka SET rezerwacja = 1 WHERE ksiazka.id = $id;";
                $db -> query($zapytanie);
            }
        ?>
    </section>
    <section class="section3">
        <h2>Dramat</h2>
        <form action="biblioteka.php" method="post">
            <select name="dramat" id="dramat">
                 <?php
                    $zapytanie = "SELECT id, tytul FROM ksiazka WHERE gatunek = 'dramat';";
                    $dane = $db -> query($zapytanie);
                    foreach ($dane as $wiersz) {
                        $id = $wiersz['id'];
                        $tytul = $wiersz['tytul'];
                        echo "<option value=\"$id\">$tytul</option>";
                    }
                ?>
            </select>
            <button type="submit" name="rezerwuj-dramat">Rezerwuj</button>
        </form>

         <?php
            if (isset($_POST['rezerwuj-dramat'])) {
                $id = $_POST['dramat'];
                $zapytanie = "SELECT tytul from ksiazka where id = $id;";
                $dane = $db -> query($zapytanie);
                $wiersz = $dane -> fetch_assoc();
                $ksiazka = $wiersz['tytul'];
                echo "<p>Książka $ksiazka jest zarezerwowana</p>";
                
                $zapytanie = "UPDATE ksiazka SET rezerwacja = 1 WHERE ksiazka.id = $id;";
                $db -> query($zapytanie);
            }
        ?>
    </section>
    <section class="section4">
        <h2>Zaległe książki</h2>
        <ul>
            <?php 
                $zapytanie = "SELECT ksiazka.tytul, wypozyczenia.id_cz, wypozyczenia.data_odd FROM ksiazka JOIN wypozyczenia ON wypozyczenia.id_ks = ksiazka.id order by wypozyczenia.data_odd asc limit 15;";
                $dane = $db -> query($zapytanie);
                foreach ($dane as $wiersz) {
                    $tytul = $wiersz["tytul"];
                    $id_czytelnika = $wiersz["id_cz"];
                    $data_oddania = $wiersz["data_odd"];
                    echo "<li>$tytul $id_czytelnika $data_oddania</li>";
                }
            ?>
        </ul>
    </section>
    <footer>
        <p><strong>Autor: Konrad Malinowski</strong></p>
    </footer>
</body>
</html>

<?php
$db -> close();
?>