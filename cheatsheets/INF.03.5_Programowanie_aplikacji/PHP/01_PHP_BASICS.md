# 🔧 ŚCIĄGAWKA: PHP Podstawy (INF.03.5)

## 1️⃣ Hello WORLD

```php
<?php
    echo "Hello, World!";
?>
```

## 2️⃣ ZMIENNE I TYPY DANYCH

```php
<?php
    // Zmienne zaczynają się od $
    $imie = "Jan";
    $wiek = 30;
    $pensja = 3500.50;
    $aktywny = true;
    $dane = null;
    
    // Array
    $kolory = array("Czerwony", "Zielony", "Niebieski");
    $kolory = ["Czerwony", "Zielony", "Niebieski"]; // Nowoczesnie
    
    // Asocjacyjny array
    $osoba = [
        "imie" => "Jan",
        "wiek" => 30,
        "email" => "jan@example.com"
    ];
    
    // Type juggling
    $a = "5" + 3;  // 8 (konwersja string -> int)
    $b = "10" . 5; // "105" (konkatenacja)
?>
```

## 3️⃣ ECHO I PRINT

```php
<?php
    echo "Hello"; // Brak spacji na końcu
    echo "Hello ", "World"; // Wiele argumentów
    
    print "Hello"; // Tylko 1 argument (rzadko używane)
    
    // String interpolation
    $imie = "Jan";
    echo "Cześć, $imie!";        // Cześć, Jan!
    echo "Cześć, {$imie}!";      // Bardziej bezpieczne
    echo 'Cześć, $imie!';        // Cześć, $imie! (single quote - dosłownie)
?>
```

## 4️⃣ OPERATORY

```php
<?php
    // Arytmetyczne
    10 + 5; 10 - 5; 10 * 5; 10 / 5; 10 % 3; 2 ** 3;
    
    // String
    $a = "Hello " . "World"; // "Hello World"
    
    // Porównanie
    ==, !=, ===, !==, <, >, <=, >=
    
    // Logiczne
    &&, ||, !, and, or, xor
    
    // Ternary
    $status = $wiek >= 18 ? "Dorosły" : "Niepełnoletni";
    
    // Null coalescing
    $imie = $_GET['imie'] ?? "Gość";  // Domyślna wartość
?>
```

## 5️⃣ INSTRUKCJE STERUJĄCE

```php
<?php
    // If-else
    if ($wiek >= 18) {
        echo "Dorosły";
    } else if ($wiek >= 13) {
        echo "Nastolatek";
    } else {
        echo "Dziecko";
    }
    
    // Switch
    switch ($dzien) {
        case "Poniedziałek":
            echo "Start tygodnia";
            break;
        case "Piątek":
            echo "Koniec tygodnia";
            break;
        default:
            echo "Zwykły dzień";
    }
?>
```

## 6️⃣ PĘTLE

```php
<?php
    // For
    for ($i = 0; $i < 10; $i++) {
        echo $i;
    }
    
    // While
    while ($i < 10) {
        echo $i;
        $i++;
    }
    
    // Do-while
    do {
        echo $i;
        $i++;
    } while ($i < 10);
    
    // Foreach
    $kolory = ["Czerwony", "Zielony", "Niebieski"];
    foreach ($kolory as $kolor) {
        echo $kolor;
    }
    
    // Foreach z kluczem
    $osoba = ["imie" => "Jan", "wiek" => 30];
    foreach ($osoba as $klucz => $wartosc) {
        echo "$klucz: $wartosc";
    }
?>
```

## 7️⃣ FUNKCJE

```php
<?php
    // Definicja
    function add($a, $b) {
        return $a + $b;
    }
    
    echo add(5, 3); // 8
    
    // Parametry domyślne
    function greet($name = "Gość") {
        return "Cześć, $name!";
    }
    
    echo greet();      // Cześć, Gość!
    echo greet("Jan"); // Cześć, Jan!
    
    // Type hints
    function multiply(int $a, int $b): int {
        return $a * $b;
    }
    
    // Funkcje wbudowane
    strlen($string);
    strpos($haystack, $needle);
    str_replace($search, $replace, $string);
    substr($string, 0, 5);
    strtoupper($string);
    strtolower($string);
    trim($string);
    explode(",", $string); // String -> Array
    implode(",", $array);  // Array -> String
?>
```

## 8️⃣ FORMULARZE (GET/POST)

```php
<!-- HTML -->
<form action="handler.php" method="POST">
    <input type="text" name="imie" required>
    <input type="email" name="email" required>
    <button type="submit">Wyślij</button>
</form>

<?php
    // handler.php
    
    // GET - z URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];  // ?id=123
    }
    
    // POST - z formularza
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['imie'])) {
            $imie = $_POST['imie'];
        }
        
        // Walidacja
        if (empty($_POST['imie'])) {
            echo "Imię jest wymagane!";
        } else if (strlen($_POST['imie']) < 3) {
            echo "Imię musi mieć min 3 znaki!";
        } else {
            // OK - przetwarzaj dane
            $imie = htmlspecialchars($_POST['imie']); // Bezpieczeństwo!
            echo "Cześć, $imie!";
        }
    }
    
    // FILES - upload pliku
    if (isset($_FILES['zdjecie'])) {
        $file = $_FILES['zdjecie'];
        $name = $file['name'];
        $tmp = $file['tmp_name'];
        $error = $file['error'];
        $size = $file['size'];
        
        if ($error === 0 && $size < 5000000) { // < 5MB
            move_uploaded_file($tmp, "uploads/$name");
        }
    }
?>
```

## 9️⃣ SESJE (SESSIONS)

```php
<?php
    // Start sesji
    session_start();
    
    // Ustawianie zmiennej sesji
    $_SESSION['user_id'] = 123;
    $_SESSION['username'] = "jan_kowalski";
    
    // Pobieranie
    echo $_SESSION['username'];
    
    // Sprawdzanie
    if (isset($_SESSION['user_id'])) {
        echo "Zalogowany";
    } else {
        echo "Niezalogowany";
    }
    
    // Usuwanie
    unset($_SESSION['user_id']);
    
    // Usunięcie wszystkich
    session_destroy();
?>
```

## 🔟 CIASTECZKA (COOKIES)

```php
<?php
    // Ustawianie (PRZED jakikolwiek output!)
    setcookie("username", "jan", time() + 3600); // +1 godzina
    setcookie("theme", "dark", time() + 86400, "/"); // +1 dzień
    
    // Pobieranie
    echo $_COOKIE['username'];
    
    // Sprawdzanie
    if (isset($_COOKIE['theme'])) {
        echo "Motyw: " . $_COOKIE['theme'];
    }
    
    // Usuwanie
    setcookie("username", "", time() - 3600);
?>
```

## 1️⃣1️⃣ BAZY DANYCH (MySQLi)

```php
<?php
    // Połączenie
    $conn = new mysqli("localhost", "root", "password", "moja_baza");
    
    // Sprawdzenie błędu
    if ($conn->connect_error) {
        die("Błąd połączenia: " . $conn->connect_error);
    }
    
    // Query
    $sql = "SELECT * FROM pracownicy WHERE pensja > 3000";
    $result = $conn->query($sql);
    
    // Pobieranie wyników
    while ($row = $result->fetch_assoc()) {
        echo $row['imie'] . " - " . $row['pensja'];
    }
    
    // Insert bezpiecznie (prepared statements!)
    $imie = $_POST['imie'];
    $stmt = $conn->prepare("INSERT INTO pracownicy (imie, pensja) VALUES (?, ?)");
    $stmt->bind_param("si", $imie, 3500);
    $stmt->execute();
    
    // Close
    $conn->close();
?>
```

## 1️⃣2️⃣ BEZPIECZEŃSTWO

```php
<?php
    // Escapowanie (zapobieganie XSS)
    $imie = htmlspecialchars($_POST['imie']);
    echo $imie;
    
    // Prepared statements (zapobieganie SQL Injection)
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $_POST['email']);
    
    // Hashing hasła
    $haslo = password_hash($_POST['haslo'], PASSWORD_BCRYPT);
    
    // Weryfikacja hasła
    if (password_verify($_POST['haslo'], $haslo_z_bazy)) {
        echo "Hasło poprawne!";
    }
    
    // Walidacja email
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        echo "Email jest prawidłowy";
    }
?>
```

## 1️⃣3️⃣ PODSUMOWANIE

- **Echo** - output do HTML
- **Variables** - $zmienna
- **Arrays** - [], foreach
- **Functions** - reusable kod
- **Forms** - $_GET, $_POST
- **Sessions** - $_SESSION
- **Cookies** - $_COOKIE
- **DB** - MySQLi z prepared statements
- **Security** - htmlspecialchars, password_hash, filter_var

---

**Powodzenia! 🎓**
