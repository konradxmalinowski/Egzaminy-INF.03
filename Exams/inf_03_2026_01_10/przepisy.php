<?php 
$polaczenie = new mysqli("localhost", "root", "", "przepisy"); 
$id;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
    } else {
        $id = 7;
    }
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styl.css">
    <title>Blog kulinarny</title>
</head>
<body>
    <aside>
        <a href="przepisy.php?id=1">Sernik</a><br>
        <a href="przepisy.php?id=2">Salatka</a><br>
        <a href="przepisy.php?id=3">Pankejki</a><br>
        <a href="przepisy.php?id=4">Nugesty</a><br>
        <a href="przepisy.php?id=5">Łosoś</a><br>
        <a href="przepisy.php?id=6">Kociołek</a><br>
        <a href="przepisy.php?id=7">Jagniecina</a><br>
        <a href="przepisy.php?id=8">Hamburgery</a><br>
        <a href="przepisy.php?id=9">Eklerki</a><br>
        <a href="przepisy.php?id=10">Churros</a><br>
        <p>Autor: Konrad Malinowski</p>
    </aside>
    <main>
        <h1>
            <?php
                $zapytanie = "SELECT potrawy.nazwa, rodzaje.rodzaj FROM potrawy JOIN rodzaje on rodzaje.idRodzaje = potrawy.idRodzaje WHERE potrawy.idPotrawy = $id";
                $rezulat = $polaczenie -> query($zapytanie);
                $wiersz = $rezulat -> fetch_assoc();
                $rodzaj = $wiersz['rodzaj'];
                echo $rodzaj;
            ?>
        </h1>

        <?php
            $zapytanie = "SELECT nazwa, trudnosc, kalorie FROM potrawy WHERE idPotrawy = $id;";
            $rezulat = $polaczenie -> query($zapytanie);
            $wiersz = $rezulat -> fetch_assoc();
            $nazwa = $wiersz['nazwa'];
            $trudnosc = intval($wiersz['trudnosc']);
            $kalorie = $wiersz['kalorie'];

            $trudnosc_tekst = "";
            if ($trudnosc === 1) $trudnosc_tekst = "łatwe";
            else if ($trudnosc === 2) $trudnosc_tekst = "średnie";
            else if ($trudnosc === 3) $trudnosc_tekst = "trudne";

            echo "
            <h2>$nazwa</h2>
            <p>Trudność: $trudnosc_tekst, Kalorie: $kalorie</p>
            ";
        ?>

        <img src="separator.png" alt="przepis">
        <p>Alergeny: 
        <?php
            $zapytanie = "SELECT potrawy.nazwa, alergeny.alergen FROM potrawy JOIN lista_alergenow ON lista_alergenow.idPotrawy = potrawy.idPotrawy JOIN alergeny ON alergeny.idAlergeny = lista_alergenow.idAlergeny WHERE potrawy.idPotrawy = $id";
            $rezultat = $polaczenie -> query($zapytanie);
            
            $alergeny = array();
            foreach ($rezultat as $wiersz) {
                $alergeny[] = $wiersz['alergen'];
            }

            echo join(", ", $alergeny);
        ?>
        </p>

        <h2>Skladniki</h2>
        <ul>
            <li>Lorem 1 kg</li>
            <li>Ipsum 2 szt.</li>
            <li>Dolor 200 g</li>
            <li>Sit amet (szczypta)</li>
        </ul>

        <p>
            <?php
                $zapytanie = "SELECT przepis, plik FROM potrawy WHERE idPotrawy = $id;";
                $rezulat = $polaczenie -> query($zapytanie);
                $wiersz = $rezulat -> fetch_assoc();
                $przepis = $wiersz['przepis'];
                $plik = $wiersz['plik'];

                echo $przepis;
            ?>
        </p>
    </main>
    <section style="background-image: url(<?php echo $plik ?>);">
        <h1>Blog kulinarny</h1>
    </section>

    <div class="clear-both"></div>
</body>
</html>

<?php 
$polaczenie -> close();
?>