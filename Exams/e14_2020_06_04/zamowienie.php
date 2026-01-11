<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="styl.css" />
    <title>Sklep</title>
</head>

<body>
    <header>
        <h1>Ozdoby - sklep</h1>
    </header>
    <section class="lewy">
        <h2>OZDOBY</h2>
        <a href="galeria.html">Galeria</a>
        <a href="zamowienie.php">Zamówienie</a>
    </section>
    <section class="srodkowy">
        <p>Dodaj użytkownika</p>
        <form action="./zamowienie.php" method="post">
            <label>Imię: <input type="text" id="imie" name="imie"></label>
            <label>Nazwisko: <input type="text" id="nazwisko" name="nazwisko"></label>
            <label>e-mail: <input type="email" id="email" name="email"></label>
            <button type="submit">WYŚLIJ</button>
        </form>
    </section>
    <section class="prawy">
        <img src="animacja.gif" alt="animacja" />
    </section>
    <footer>
        <h3>Autor strony: Konrad Malinowski</h3>
    </footer>
</body>

</html>


<?php
if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $conn = mysqli_connect('localhost', 'root', '', 'sklep');
    if (!$conn) {
        echo "<p>Błąd połączenia z bazą danych</p>";
        exit;
    }

    $ostatnieID = 1;
    $wynik = mysqli_query($conn, "SELECT max(id) as id from zamowienia");
    if (mysqli_num_rows($wynik) > 0) {
        $dane = mysqli_fetch_assoc($wynik);
        $ostatnieID = (int) $dane['id'];
        $ostatnieID++;
    }

    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $email = $_POST['email'];

    $sql = "INSERT INTO `zamowienia` (`id`, `imie`, `nazwisko`, `adres_email`, `liczba_choinek`, `liczba_mikolajow`, `liczba_reniferow`, `info`) VALUES ('$ostatnieID', '$imie', '$nazwisko', '$email', NULL, NULL, NULL, NULL);";
    mysqli_query($conn, $sql);

    mysqli_close($conn);
}
?>