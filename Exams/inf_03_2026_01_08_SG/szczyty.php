<?php
$polaczenie = new mysqli('localhost', 'root', '', 'korona');
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styl.css">
    <title>Korona gór polskich</title>
</head>
<body>
    <header>
        <section class="header-lewy">
            <img src="logo.png" alt="Logo">
        </section>
        <section class="header-prawy">
            <h1>Korona Gór Polskich</h1>
        </section>
    </header>
    <main>
        <?php 
            if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
                $id = $_GET['id'];
                $zapytanie = "SELECT szczyty.plik, szczyty.nazwa, szczyty.wysokosc, szczyty.pasmo, opis.opis FROM szczyty JOIN opis on opis.szczyty_id = szczyty.id where szczyty.id = $id";
                $rezultat = $polaczenie -> query($zapytanie);
                $wiersz = $rezultat -> fetch_assoc();

                $plik = $wiersz['plik'];
                $nazwa = $wiersz['nazwa'];
                $wysokosc = $wiersz['wysokosc'];
                $pasmo = $wiersz['pasmo'];
                $opis = $wiersz['opis'];

                echo "
                <img src=\"$plik\" alt=\"szczyt\">
                <h2>$nazwa</h2>
                <h3>Wysokość: $wysokosc metrów n.p.m</h3>
                <h3>Pasmo górskie: $pasmo</h3>
                <p>$opis</p>
                ";

            }
        ?>
    </main>
    <section class="blok-sekcji">
         <?php
            $zapytanie = "SELECT plik, nazwa FROM szczyty LIMIT 10";
            $rezultat = $polaczenie -> query($zapytanie);
            foreach($rezultat as $wiersz) {
                $plik = $wiersz['plik'];
                $nazwa = $wiersz['nazwa'];
                echo "<img src=\"$plik\" alt=\"$nazwa\" class=\"miniatury\">";
            }
        ?>
    </section>
    <footer>
        <section class="footer-lewy">
            <h3>Kontakt</h3>
            <ul>
                <li>Zadzwoń do nas: 111 222 333</li>
                <li><a href="mailto:korona@gory.pl">Napisz do nas</a></li>
            </ul>
        </section>
        <section class="footer-prawy">
            <h3>&copy; Wykonane przez: Konrad Malinowski</h3>
        </section>
    </footer>
</body>
</html>

<?php
$polaczenie -> close();
?>