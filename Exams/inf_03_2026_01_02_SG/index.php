<?php
$db = new mysqli('localhost', 'root', '', "bazar");
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styl.css">
    <title>Zdrowy bazarek</title>
</head>
<body>
    <header>
        <h1>Zdrowy bazarek</h1>
    </header>
    <nav>
        <?php
            $zapytanie = "SELECT nazwa, plik FROM towar LIMIT 10;";
            $rezultat = $db -> query($zapytanie);
            foreach ($rezultat as $wiersz) {
                $nazwa = $wiersz['nazwa'];
                $plik = $wiersz['plik'];

                echo "<img src=\"$plik\" alt=\"$nazwa\" >";
            }
        ?>
    </nav>
    <main>
        <aside>
            <img src="market.png" alt="bazarek">
        </aside>
        <section>
            <p>Wybierz owoc lub warzywo i podaj jego wage: </p>
            <form action="index.php" method="post">
                <select name="owoc" id="owoc">
                    <?php
                        $zapytanie = "SELECT id, nazwa FROM towar";
                        $rezultat = $db -> query($zapytanie);
                        foreach ($rezultat as $wiersz) {
                            $id = $wiersz['id'];
                            $nazwa = $wiersz['nazwa'];

                            echo "<option value=\"$id\">$nazwa</option>";
                        }
                    ?>
                </select>
                <input type="number" name="liczbakg" id="liczbakg">
                <button type="submit">Zamów</button>
            </form>

            <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $id = intval($_POST['owoc']);
                    $liczba_kg = intval($_POST['liczbakg']);

                    $zapytanie = "SELECT rodzaj, nazwa, cena FROM towar WHERE id = $id";
                    $rezultat = $db -> query($zapytanie);
                    $wiersz = $rezultat -> fetch_assoc();
                    $rodzaj = $wiersz['rodzaj'];
                    $nazwa = $wiersz['nazwa'];
                    $cena = floatval($wiersz['cena']);

                    $podsumowanie = $liczba_kg * $cena;

                    echo "<p>$rodzaj $nazwa wartość $podsumowanie zł</p>";

                    $zapytanie = "INSERT INTO zamowienie (id_towar, id_sklep, liczba_kg) VALUES ($id, 2, $liczba_kg)";
                    $db -> query($zapytanie);
                }
            ?>
        </section>
    </main>
    <footer>
        <p>Stronę opracował: Konrad Malinowski</p>
    </footer>
</body>
</html>

<?php
$db -> close();
?>