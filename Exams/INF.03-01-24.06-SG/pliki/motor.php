<?php
$db = new mysqli("localhost", "root", "", "motory");                
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styl.css">
    <title>Motocykle</title>
</head>

<body>
    <img src="./motor.png" alt="motocykl" id="motocykl">
    <header>
        <h1>Motocykle - moja pasja</h1>
    </header>
    <section class="sekcja-lewa">
        <h2>Gdzie pojechać?</h2>
        <dl>
            <?php
               $zapytanie = "SELECT wycieczki.nazwa, wycieczki.opis, wycieczki.poczatek, zdjecia.zrodlo FROM wycieczki JOIN zdjecia ON zdjecia.id = wycieczki.zdjecia_id";
               $rezultat = $db -> query($zapytanie);
               foreach ($rezultat as $wiersz) {
                    $nazwa = $wiersz['nazwa'];
                    $poczatek = $wiersz['poczatek'];
                    $zrodlo = $wiersz['zrodlo'];
                    $opis = $wiersz['opis'];

                    echo "<dt>$nazwa rozpoczyna się w $poczatek, <a href=\"$zrodlo\">zobacz zdjęcie</a></dt>";
                    echo "<dd>$opis</dd>";
               }
            ?>
        </dl>
    </section>
    <section class="sekcja-prawa sekcja-prawa-1">
        <h2>Co kupić?</h2>
        <ol>
            <li>Honda CBR125R</li>
            <li>Yamaha YBR125</li>
            <li>Honda VFR800i</li>
            <li>Honda CBR1100XX</li>
            <li>BMW R1200GS LC</li>
        </ol>
    </section>
    <section class="sekcja-prawa sekcja-prawa-2">
        <h2>Statystyki</h2>
        <p>
            Wpisanych wycieczek: 
            <?php
            $zapytanie = "SELECT COUNT(wycieczki.id) as ilosc FROM wycieczki;";
            $rezultat = $db -> query($zapytanie);
            $ilosc = $rezultat -> fetch_assoc();
            echo $ilosc['ilosc'];
            ?>
        </p>
        
        <p>Uzytkowników forum: 200</p>
        <p>Przesłanych zdjęć: 1300</p>
    </section>
    <footer>
        <p>Stronę wykonał: Konrad Malinowski</p>
    </footer>
</body>

</html>

<?php
$db -> close();
?>