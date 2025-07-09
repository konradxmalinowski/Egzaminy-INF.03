<?php

define('HOST', 'localhost');
define('USER_NAME', 'root');
define('USER_PASS', '');
define('DB_NAME', 'psy');

$conn = mysqli_connect(HOST, USER_NAME, USER_PASS, DB_NAME);

if (!$conn) {
    echo '<p>Nie połączono z bazą danych</p>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum o psach</title>
    <link rel="stylesheet" href="styl4.css">
</head>

<body>
    <header>
        <h1>Forum wielbicieli psów</h1>
    </header>
    <section class="blok-lewy">
        <img src="./obraz.jpg" alt="foksterier">
    </section>

    <section class="pierwszy-blok-prawy">
        <h2>Zapisz się</h2>
        <form action="logowanie.php" method="POST">
            <label>login: <input type="text" name="login" id="login"></label>
            <label>hasło: <input type="password" name="haslo1" id="haslo1"></label>
            <label>powtórz hasło: <input type="password" name="haslo2" id="haslo2"></label>
            <button type="submit">Zapisz</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['login']) || !isset($_POST['haslo1']) || !isset($_POST['haslo2'])) {
                echo '<p>wypełnij wszystkie pola</p>';
                exit;
            }

            if ($_POST['haslo1'] !== $_POST['haslo2']) {
                echo "<p>hasła nie są takie same, konto nie zostało dodane</p>";
                exit;
            }
            $login = trim($_POST['login']);
            $haslo = trim($_POST['haslo1']);

            $wynik = mysqli_query($conn, 'SELECT login from uzytkownicy');
            $loginy = $wynik->fetch_assoc();
            $jestZnaleziony = false;

            foreach ($loginy as $login_tab) {
                if ($login_tab === $login) {
                    $jestZnaleziony = true;
                    break;
                }
            }

            if ($jestZnaleziony) {
                echo '<p>login występuje w bazie danych, konto nie zostało dodane</p>';
                exit;
            }

            $hasloHash = sha1($haslo);

            $zapytanie = "INSERT INTO uzytkownicy(login, haslo) VALUES('$login', '$hasloHash') ";
            $wynik = mysqli_query($conn, $zapytanie);


            if (!$wynik) {
                echo 'error';
                exit;
            }

            if ($wynik) {
                echo '<p>Konto zostało dodane</p>';
            }

        }
        ?>
    </section>
    <section class="drugi-blok-prawy">
        <h2>Zapraszamy wszystkich</h2>
        <ol>
            <li>wielbicieli psów</li>
            <li>weterynarzy</li>
            <li>tych, co chcą kupić psa</li>
            <li>tych, co lubią psy</li>
        </ol>
        <a href="./regulamin.html">Przeczytaj regulamin forum</a>
    </section>

    <footer>
        Stronę wykonał
    </footer>

</body>

</html>

<?php
mysqli_close($conn);

?>