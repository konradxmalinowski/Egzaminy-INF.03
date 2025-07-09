<?php

$conn = new mysqli('localhost', 'root', '', 'portal');

if (!$conn) {
    echo "<p>Błąd połączenia z bazą danych</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styl5.css">
    <title>Portal społecznościowy</title>
</head>

<body>
    <header>
        <section>
            <h2>Nasze osiedle</h2>
        </section>
        <section>

            <h5>
                Liczba użytkowników portalu:
                <?php
                $wynik = mysqli_query($conn, 'SELECT count(*) as ilosc FROM dane');
                if ($wynik && mysqli_num_rows($wynik) > 0) {
                    $dane = mysqli_fetch_assoc($wynik);
                    echo $dane['ilosc'];
                }
                ?>
            </h5>
        </section>
        <div></div>
    </header>
    <section class="lewy-block">
        <h3>Logowanie</h3>
        <form action="./uzytkownicy.php" method="post">
            <label><span>login</span> <input type="text" name="login" id="login"></label>
            <label><span>Hasło</span> <input type="password" name="haslo" id="haslo"></label>
            <button type="submit">Zaloguj</button>
        </form>

        <?php

        ?>
    </section>
    <section class="prawy-blok">
        <h3>Wizytówka</h3>

        <article class="wizytowka">
            <?php
            if ($_SERVER["REQUEST_METHOD"] === 'POST') {
                if (!isset($_POST['login']) || !isset($_POST['haslo'])) {
                    exit;
                }

                $login = $_POST['login'];
                $wynik = mysqli_query($conn, "SELECT haslo from uzytkownicy where login = '$login'");
                if (mysqli_num_rows($wynik) === 0) {
                    echo '<p>login nie istnieje</p>';
                    exit;
                }
                $hasloBaza = mysqli_fetch_row($wynik);
                $hasloHash = sha1($_POST['haslo']);

                if (trim($hasloBaza[0]) != trim($hasloHash)) {
                    echo '<p>hasło nieprawidłowe</p>';
                    exit;
                }

                $wynik = mysqli_query($conn, "select login, rok_urodz, przyjaciol, hobby, zdjecie FROM uzytkownicy inner join dane on dane.id = uzytkownicy.id where login = '$login'");
                if (!$wynik || mysqli_num_rows($wynik) === 0) {
                    exit;
                }

                $dane = mysqli_fetch_assoc($wynik);
                $zdjecie = $dane['zdjecie'];
                $wiek = (int) date('Y') - $dane['rok_urodz'];
                $hobby = $dane['hobby'];
                $przyjaciol = $dane['przyjaciol'];

                echo "
                    <img src='$zdjecie' alt='osoba'/>
                    <h4>$login ($wiek)</h4>
                    <p>Hobby: $hobby</p>
                    <h1>
                    <img src='./icon-on.png' alt='serce'/>
                    $przyjaciol
                    </h1>
                    <button onClick=\"window.location.href='dane.html';\">Więcej informacji</button>
                    ";

            }
            ?>
        </article>
    </section>
    <footer>
        Stronę wykonał
    </footer>
</body>

</html>

<?php
mysqli_close($conn);

?>