# PHP + MySQL - Wzorzec Egzaminacyjny INF.03

> NAJWAŻNIEJSZA ściągawka do egzaminu - INF.03.5 Programowanie aplikacji

---

## 1. PEŁNY WZORZEC EGZAMINACYJNY

To jest kompletny szkielet strony PHP jaki musisz napisać na egzaminie.
**Zapamiętaj go na pamięć!**

```php
<?php
// ============================================================
// KROK 1: POŁĄCZENIE Z BAZĄ DANYCH
// ============================================================
$polaczenie = new mysqli("localhost", "root", "", "nazwa_bazy");

// Sprawdzenie błędu połączenia
if ($polaczenie->connect_error) {
    die("Błąd połączenia: " . $polaczenie->connect_error);
}

// Ustawienie kodowania UTF-8 (ważne dla polskich znaków!)
$polaczenie->set_charset("utf8");

// ============================================================
// KROK 2: POBIERANIE DANYCH Z FORMULARZA / URL
// ============================================================
// Pobieranie liczby z GET (np. ?id=5)
$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Pobieranie tekstu z GET
$szukaj = isset($_GET['szukaj']) ? htmlspecialchars($_GET['szukaj']) : "";

// Pobieranie z POST (formularze)
$imie = isset($_POST['imie']) ? htmlspecialchars($_POST['imie']) : "";

// ============================================================
// KROK 3: ZAPYTANIE SQL
// ============================================================
// Jeden wynik z JOIN
$zapytanie = "SELECT pracownicy.imie, pracownicy.nazwisko, dzialy.nazwa AS dzial
              FROM pracownicy
              JOIN dzialy ON dzialy.id = pracownicy.id_dzialu
              WHERE pracownicy.id = $id";
$rezultat = $polaczenie->query($zapytanie);
$wiersz = $rezultat->fetch_assoc();

// ============================================================
// KROK 4: WIELE WYNIKÓW - pętla while
// ============================================================
$zapytanie2 = "SELECT * FROM produkty ORDER BY cena DESC";
$rezultat2  = $polaczenie->query($zapytanie2);

// ============================================================
// KROK 5: ZAMKNIĘCIE POŁĄCZENIA
// ============================================================
// Zamykamy po zakończeniu pracy z bazą (lub na końcu pliku)
$polaczenie->close();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styl.css">
    <title>Egzamin INF.03</title>
</head>
<body>
    <!-- KROK 6: WYŚWIETLANIE JEDNEGO WIERSZA -->
    <p>Imię: <?php echo $wiersz['imie']; ?></p>
    <p>Dział: <?php echo $wiersz['dzial']; ?></p>

    <!-- KROK 7: WYŚWIETLANIE WIELU WIERSZY - tabela -->
    <table>
        <tr>
            <th>Nazwa</th>
            <th>Cena</th>
        </tr>
        <?php while ($wiersz2 = $rezultat2->fetch_assoc()): ?>
        <tr>
            <td><?php echo $wiersz2['nazwa']; ?></td>
            <td><?php echo $wiersz2['cena']; ?> zł</td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
```

---

## 2. MYSQLI OOP VS PROCEDURALNE

Na egzaminie najczęściej wymagany jest **styl OOP** (obiektowy). Ale warto znać oba.

### Styl OOP (obiektowy) - ZALECANY

```php
// Połączenie
$conn = new mysqli("localhost", "root", "", "baza");

// Query
$result = $conn->query("SELECT * FROM tabela");

// Fetch
$row = $result->fetch_assoc();

// Sprawdzenie błędu
if ($conn->connect_error) { die($conn->connect_error); }

// Liczba wierszy
$result->num_rows;

// Zamknięcie
$conn->close();
```

### Styl proceduralny (funkcje)

```php
// Połączenie
$conn = mysqli_connect("localhost", "root", "", "baza");

// Query
$result = mysqli_query($conn, "SELECT * FROM tabela");

// Fetch
$row = mysqli_fetch_assoc($result);

// Sprawdzenie błędu
if (mysqli_connect_error()) { die(mysqli_connect_error()); }

// Liczba wierszy
mysqli_num_rows($result);

// Zamknięcie
mysqli_close($conn);
```

### Tabela porównawcza

| Operacja               | OOP                               | Proceduralne                          |
|------------------------|-----------------------------------|---------------------------------------|
| Połączenie             | `new mysqli(...)`                 | `mysqli_connect(...)`                 |
| Query                  | `$conn->query($sql)`              | `mysqli_query($conn, $sql)`           |
| Fetch assoc            | `$result->fetch_assoc()`          | `mysqli_fetch_assoc($result)`         |
| Fetch row              | `$result->fetch_row()`            | `mysqli_fetch_row($result)`           |
| Fetch array            | `$result->fetch_array()`          | `mysqli_fetch_array($result)`         |
| Liczba wierszy         | `$result->num_rows`               | `mysqli_num_rows($result)`            |
| Affected rows          | `$conn->affected_rows`            | `mysqli_affected_rows($conn)`         |
| Last insert ID         | `$conn->insert_id`                | `mysqli_insert_id($conn)`             |
| Kodowanie              | `$conn->set_charset("utf8")`      | `mysqli_set_charset($conn, "utf8")`   |
| Zamknięcie             | `$conn->close()`                  | `mysqli_close($conn)`                 |

---

## 3. FETCH - POBIERANIE DANYCH

### fetch_assoc() - tablica asocjacyjna (NAJCZĘSTSZE)

```php
// Zwraca tablicę: ['nazwa_kolumny' => 'wartość']
$wiersz = $rezultat->fetch_assoc();
echo $wiersz['imie'];       // dostęp przez nazwę kolumny
echo $wiersz['nazwisko'];

// W pętli - wiele wierszy
while ($wiersz = $rezultat->fetch_assoc()) {
    echo $wiersz['id'] . " - " . $wiersz['nazwa'] . "<br>";
}
```

### fetch_row() - tablica numeryczna

```php
// Zwraca tablicę: [0 => 'wartość', 1 => 'wartość', ...]
$wiersz = $rezultat->fetch_row();
echo $wiersz[0];            // pierwsza kolumna
echo $wiersz[1];            // druga kolumna

// W pętli
while ($wiersz = $rezultat->fetch_row()) {
    echo $wiersz[0] . " - " . $wiersz[1] . "<br>";
}
```

### fetch_array() - obie tablice naraz

```php
// Zwraca ZARÓWNO asocjacyjną jak i numeryczną (domyślnie MYSQLI_BOTH)
$wiersz = $rezultat->fetch_array();
echo $wiersz['imie'];       // przez nazwę
echo $wiersz[0];            // przez indeks (ta sama wartość!)

// Stałe: MYSQLI_ASSOC, MYSQLI_NUM, MYSQLI_BOTH
$wiersz = $rezultat->fetch_array(MYSQLI_ASSOC);  // tylko asocjacyjna
$wiersz = $rezultat->fetch_array(MYSQLI_NUM);    // tylko numeryczna
```

### fetch_object() - obiekt

```php
// Zwraca obiekt, właściwości = nazwy kolumn
$wiersz = $rezultat->fetch_object();
echo $wiersz->imie;
echo $wiersz->nazwisko;
```

### Pobranie wszystkich wierszy naraz

```php
// fetch_all() - zwraca tablicę wszystkich wierszy
$wszystkie = $rezultat->fetch_all(MYSQLI_ASSOC);

foreach ($wszystkie as $wiersz) {
    echo $wiersz['nazwa'] . "<br>";
}
```

---

## 4. WALIDACJA DANYCH WEJŚCIOWYCH

Nigdy nie ufaj danym od użytkownika! Zawsze waliduj i czyść.

### intval() - bezpieczna liczba całkowita

```php
// Konwertuje na integer - bezpieczne dla ID
$id = intval($_GET['id']);          // "5abc" => 5, "abc" => 0
$id = (int)$_GET['id'];             // skrót - identyczne działanie

// Walidacja zakresu
if ($id < 1 || $id > 1000) {
    die("Nieprawidłowy ID");
}
```

### htmlspecialchars() - bezpieczne wyświetlanie

```php
// Zamienia znaki HTML na encje - zapobiega XSS
$tekst = htmlspecialchars($_GET['q']);
// <script> => &lt;script&gt;
// "  => &quot;
// & => &amp;

// Pełna wersja z flagami
$tekst = htmlspecialchars($_POST['komentarz'], ENT_QUOTES, 'UTF-8');
```

### strip_tags() - usuwa tagi HTML

```php
// Usuwa wszystkie tagi HTML
$czysty = strip_tags($_POST['opis']);

// Pozwala na wybrane tagi
$czysty = strip_tags($_POST['opis'], '<b><i><p>');
```

### Walidacja emaila

```php
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
if ($email === false) {
    echo "Nieprawidłowy email!";
}
```

### Walidacja liczby

```php
$liczba = filter_var($_POST['wiek'], FILTER_VALIDATE_INT);
$liczba = filter_var($_POST['cena'], FILTER_VALIDATE_FLOAT);
```

### Wzorzec kompletnej walidacji GET

```php
// Bezpieczne pobieranie danych z URL
$id     = isset($_GET['id'])     ? intval($_GET['id'])                  : 0;
$strona = isset($_GET['strona']) ? max(1, intval($_GET['strona']))       : 1;
$szukaj = isset($_GET['q'])      ? htmlspecialchars(trim($_GET['q']))   : "";

if ($id === 0) {
    die("Brak ID produktu");
}
```

---

## 5. WYŚWIETLANIE DANYCH - RÓŻNE METODY

### Metoda 1: Inline PHP (najczęstsza w egzaminie)

```php
<p>Imię: <?php echo $wiersz['imie']; ?></p>
<p>Wiek: <?= $wiersz['wiek']; ?></p>   <!-- <?= to skrót echo -->
```

### Metoda 2: Alternatywna składnia PHP w HTML

```php
<?php if ($wiersz): ?>
    <p><?= htmlspecialchars($wiersz['imie']); ?></p>
<?php endif; ?>

<?php foreach ($wyniki as $w): ?>
    <li><?= $w['nazwa']; ?></li>
<?php endforeach; ?>

<?php while ($w = $rezultat->fetch_assoc()): ?>
    <tr>
        <td><?= $w['id']; ?></td>
        <td><?= $w['nazwa']; ?></td>
    </tr>
<?php endwhile; ?>
```

### Metoda 3: Heredoc

```php
$html = <<<HTML
<div class="karta">
    <h2>$imie</h2>
    <p>Dział: $dzial</p>
</div>
HTML;
echo $html;
// Uwaga: zmienne PHP są interpretowane w heredoc
```

### Metoda 4: Nowdoc (bez interpretacji zmiennych)

```php
$szablon = <<<'HTML'
<p>To jest $literalny tekst - zmienne NIE są interpretowane</p>
HTML;
echo $szablon;
```

---

## 6. SQL W PHP - WZORCE DLA CRUD

### SELECT z JOIN

```php
// Jeden wiersz
$sql = "SELECT p.imie, p.nazwisko, d.nazwa AS dzial
        FROM pracownicy p
        JOIN dzialy d ON d.id = p.id_dzialu
        WHERE p.id = $id";
$rezultat = $polaczenie->query($sql);
$wiersz = $rezultat->fetch_assoc();

// Wiele wierszy z ORDER BY i LIMIT
$sql = "SELECT * FROM produkty
        WHERE kategoria_id = $kat_id
        ORDER BY cena ASC
        LIMIT 10";
$rezultat = $polaczenie->query($sql);
while ($w = $rezultat->fetch_assoc()) {
    echo $w['nazwa'] . " - " . $w['cena'] . " zł<br>";
}
```

### SELECT z GROUP BY

```php
$sql = "SELECT dzial, COUNT(*) AS liczba_pracownikow, AVG(pensja) AS srednia
        FROM pracownicy
        GROUP BY dzial
        HAVING COUNT(*) > 2
        ORDER BY srednia DESC";
$rezultat = $polaczenie->query($sql);
```

### INSERT - dodawanie rekordu

```php
$imie    = htmlspecialchars($_POST['imie']);
$email   = htmlspecialchars($_POST['email']);
$wiek    = intval($_POST['wiek']);

$sql = "INSERT INTO uzytkownicy (imie, email, wiek)
        VALUES ('$imie', '$email', $wiek)";

if ($polaczenie->query($sql)) {
    $nowe_id = $polaczenie->insert_id;  // ID nowego rekordu
    echo "Dodano! ID: " . $nowe_id;
} else {
    echo "Błąd: " . $polaczenie->error;
}
```

### UPDATE - aktualizacja rekordu

```php
$id    = intval($_POST['id']);
$imie  = htmlspecialchars($_POST['imie']);

$sql = "UPDATE uzytkownicy SET imie = '$imie' WHERE id = $id";

if ($polaczenie->query($sql)) {
    echo "Zaktualizowano " . $polaczenie->affected_rows . " rekordów";
} else {
    echo "Błąd: " . $polaczenie->error;
}
```

### DELETE - usuwanie rekordu

```php
$id = intval($_GET['id']);
$sql = "DELETE FROM uzytkownicy WHERE id = $id";

if ($polaczenie->query($sql)) {
    echo "Usunięto rekord";
} else {
    echo "Błąd: " . $polaczenie->error;
}
```

### Sprawdzenie liczby wyników

```php
$rezultat = $polaczenie->query($sql);

if ($rezultat->num_rows > 0) {
    // Są wyniki
    while ($w = $rezultat->fetch_assoc()) {
        echo $w['nazwa'];
    }
} else {
    echo "Brak wyników";
}
```

---

## 7. PLIKI CSS I OBRAZY - LINKOWANIE W PHP

### Linkowanie CSS z PHP

```php
<!-- Plik w tym samym folderze -->
<link rel="stylesheet" href="styl.css">

<!-- Plik w podfolderze css/ -->
<link rel="stylesheet" href="css/styl.css">

<!-- Plik o jeden poziom wyżej -->
<link rel="stylesheet" href="../styl.css">

<!-- Dynamicznie w PHP (np. różne skórki) -->
<?php $skora = "niebieski"; ?>
<link rel="stylesheet" href="css/<?php echo $skora; ?>.css">
```

### Linkowanie obrazów w PHP

```php
<!-- Statyczny obrazek -->
<img src="obrazki/logo.png" alt="Logo">

<!-- Dynamiczny obrazek z bazy danych -->
<?php while ($w = $rezultat->fetch_assoc()): ?>
    <img src="obrazki/<?= $w['zdjecie']; ?>" alt="<?= $w['nazwa']; ?>">
<?php endwhile; ?>

<!-- Z pełną ścieżką przez $_SERVER -->
<?php $base = "http://" . $_SERVER['HTTP_HOST'] . "/"; ?>
<img src="<?= $base; ?>obrazki/foto.jpg" alt="Foto">
```

---

## 8. TYPOWE BŁĘDY I JAK ICH UNIKAĆ

### Błąd 1: Zapomnienie o intval() przy GET

```php
// ZLE - podatne na SQL Injection!
$id = $_GET['id'];
$sql = "SELECT * FROM tabela WHERE id = $id";

// DOBRZE
$id = intval($_GET['id']);
$sql = "SELECT * FROM tabela WHERE id = $id";
```

### Błąd 2: Brak isset() przed $_GET/$_POST

```php
// ZLE - Notice: Undefined index
$id = $_GET['id'];

// DOBRZE
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// LUB PHP 7+
$id = intval($_GET['id'] ?? 0);
```

### Błąd 3: Zapomnienie o fetch_assoc() w pętli

```php
// ZLE - nieskończona pętla lub błąd
while ($rezultat) { ... }

// DOBRZE
while ($wiersz = $rezultat->fetch_assoc()) { ... }
```

### Błąd 4: Polskie znaki - brak set_charset

```php
// Po połączeniu ZAWSZE dodaj:
$polaczenie->set_charset("utf8");
// LUB w query:
$polaczenie->query("SET NAMES 'utf8'");
```

### Błąd 5: NULL z bazy danych

```php
// Sprawdzaj NULL przed użyciem
$telefon = $wiersz['telefon'] ?? "Brak";
$telefon = $wiersz['telefon'] !== null ? $wiersz['telefon'] : "Brak";

// Lub w HTML
<td><?= $wiersz['telefon'] ?? '-'; ?></td>
```

### Błąd 6: Brak sprawdzenia błędu query

```php
// Sprawdzaj czy query zwróciło coś
$rezultat = $polaczenie->query($sql);

if (!$rezultat) {
    die("Błąd SQL: " . $polaczenie->error);
}
```

### Błąd 7: Cudzysłowy w SQL

```php
// Wartości tekstowe muszą być w cudzysłowach w SQL!
$sql = "SELECT * FROM tabela WHERE imie = '$imie'";
//                                        ^     ^  cudzysłowy!

// Liczby - bez cudzysłowów
$sql = "SELECT * FROM tabela WHERE id = $id";
```

---

## 9. MYSQLI PREPARED STATEMENTS (bezpieczniejsze)

Na egzaminie rzadziej wymagane, ale warto znać.

```php
// Przygotowanie zapytania - ? to placeholder
$stmt = $polaczenie->prepare(
    "SELECT imie, email FROM uzytkownicy WHERE id = ? AND aktywny = ?"
);

// Bindowanie parametrów: i=integer, s=string, d=double, b=blob
$stmt->bind_param("ii", $id, $aktywny);

// Wykonanie
$stmt->execute();

// Pobranie wyników
$rezultat = $stmt->get_result();
while ($w = $rezultat->fetch_assoc()) {
    echo $w['imie'];
}

$stmt->close();
```

---

## 10. KOMPLETNY PRZYKŁAD EGZAMINACYJNY

Strona wyświetlająca szczegóły produktu po kliknięciu z listy:

```php
<?php
$polaczenie = new mysqli("localhost", "root", "", "sklep");
if ($polaczenie->connect_error) {
    die("Błąd: " . $polaczenie->connect_error);
}
$polaczenie->set_charset("utf8");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Szczegóły produktu z kategorią
    $sql = "SELECT produkty.nazwa, produkty.cena, produkty.opis,
                   kategorie.nazwa AS kategoria
            FROM produkty
            JOIN kategorie ON kategorie.id = produkty.id_kategorii
            WHERE produkty.id = $id";
    $rez   = $polaczenie->query($sql);
    $prod  = $rez ? $rez->fetch_assoc() : null;
}

// Wszystkie produkty do listy
$sql_lista = "SELECT id, nazwa, cena FROM produkty ORDER BY nazwa";
$rez_lista = $polaczenie->query($sql_lista);

$polaczenie->close();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styl.css">
    <title>Sklep</title>
</head>
<body>
    <aside>
        <h2>Produkty</h2>
        <ul>
        <?php while ($p = $rez_lista->fetch_assoc()): ?>
            <li>
                <a href="?id=<?= $p['id']; ?>">
                    <?= htmlspecialchars($p['nazwa']); ?>
                    - <?= $p['cena']; ?> zł
                </a>
            </li>
        <?php endwhile; ?>
        </ul>
    </aside>

    <main>
        <?php if ($prod): ?>
            <h1><?= htmlspecialchars($prod['nazwa']); ?></h1>
            <p>Kategoria: <?= htmlspecialchars($prod['kategoria']); ?></p>
            <p>Cena: <strong><?= $prod['cena']; ?> zł</strong></p>
            <p><?= htmlspecialchars($prod['opis']); ?></p>
        <?php else: ?>
            <p>Wybierz produkt z listy.</p>
        <?php endif; ?>
    </main>
</body>
</html>
```

---

## PODSUMOWANIE DO EGZAMINU

### Kolejność kroków - zapamiętaj!

1. `new mysqli(host, user, pass, db)` - połączenie
2. Sprawdź `connect_error`
3. `set_charset("utf8")` - polskie znaki
4. `isset()` + `intval()` / `htmlspecialchars()` - walidacja GET/POST
5. Napisz SQL (z JOIN jeśli potrzebny)
6. `$conn->query($sql)` - wykonaj query
7. `fetch_assoc()` lub `while + fetch_assoc()` - pobierz dane
8. Wyświetl dane w HTML z `<?= ?>`
9. `$conn->close()` - zamknij połączenie

### Wzorzec do przepisania na egzaminie

```php
<?php
$conn = new mysqli("localhost", "root", "", "NAZWA_BAZY");
if ($conn->connect_error) { die("Błąd: " . $conn->connect_error); }
$conn->set_charset("utf8");

$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

$sql = "SELECT t1.pole1, t2.pole2
        FROM tabela1 t1
        JOIN tabela2 t2 ON t2.id = t1.id_tabela2
        WHERE t1.id = $id";
$rez = $conn->query($sql);
$w   = $rez->fetch_assoc();

$conn->close();
?>
```

### Najczęstsze błędy punktowe na egzaminie

| Problem                              | Rozwiązanie                                 |
|--------------------------------------|---------------------------------------------|
| Połączenie nie działa                | Sprawdź nazwę bazy, hasło (puste = "")      |
| Brak polskich znaków                 | `set_charset("utf8")` po połączeniu         |
| Notice: Undefined index              | `isset()` przed każdym `$_GET`/`$_POST`     |
| Wiersz NULL (brak danych)            | Sprawdź WHERE clause i ID                   |
| Wyświetla tablicę, nie wartość       | `$wiersz['kolumna']` - podaj nazwę kolumny  |
| HTML nie renderuje się               | Użyj `echo`, nie `print_r` / `var_dump`     |
