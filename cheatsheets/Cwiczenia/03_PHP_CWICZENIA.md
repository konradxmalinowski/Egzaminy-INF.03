# ĆWICZENIA: PHP + MySQL (INF.03.5)

> 12 praktycznych zadań PHP+MySQL opartych na schemacie bazy `przepisy` — dokładnie jak na egzaminie INF.03.

---

## SCHEMAT BAZY DANYCH

```sql
-- Baza: przepisy
CREATE TABLE rodzaje (
    idRodzaje INT PRIMARY KEY AUTO_INCREMENT,
    rodzaj VARCHAR(50) NOT NULL
);

CREATE TABLE potrawy (
    idPotrawy INT PRIMARY KEY AUTO_INCREMENT,
    nazwa VARCHAR(100) NOT NULL,
    opis TEXT,
    czas_przygotowania INT,
    idRodzaje INT,
    FOREIGN KEY (idRodzaje) REFERENCES rodzaje(idRodzaje)
);

CREATE TABLE skladniki (
    idSkladniki INT PRIMARY KEY AUTO_INCREMENT,
    skladnik VARCHAR(100) NOT NULL,
    jednostka VARCHAR(20)
);

CREATE TABLE potrawy_skladniki (
    idPotrawy INT,
    idSkladniki INT,
    ilosc DECIMAL(10,2),
    PRIMARY KEY (idPotrawy, idSkladniki),
    FOREIGN KEY (idPotrawy) REFERENCES potrawy(idPotrawy),
    FOREIGN KEY (idSkladniki) REFERENCES skladniki(idSkladniki)
);
```

**Dane testowe:**
```sql
INSERT INTO rodzaje (rodzaj) VALUES ('Zupy'), ('Sałatki'), ('Dania główne'), ('Desery');
INSERT INTO potrawy (nazwa, opis, czas_przygotowania, idRodzaje) VALUES
('Barszcz czerwony', 'Klasyczna polska zupa', 60, 1),
('Sałatka grecka', 'Świeże warzywa z serem feta', 15, 2),
('Kotlet schabowy', 'Tradycyjny kotlet', 30, 3),
('Szarlotka', 'Ciasto jabłkowe', 90, 4);
INSERT INTO skladniki (skladnik, jednostka) VALUES ('Buraki', 'kg'), ('Ogórek', 'szt'), ('Ser feta', 'g');
INSERT INTO potrawy_skladniki VALUES (1, 1, 0.5), (2, 2, 2), (2, 3, 100);
```

---

## ZADANIE 1: Lista wszystkich potraw (wzorzec podstawowy)

**Cel:** Połączyć się z bazą i wyświetlić wszystkie potrawy w tabeli HTML.

```php
<?php
// Połączenie z bazą
$polaczenie = new mysqli("localhost", "root", "", "przepisy");

// Sprawdź błąd połączenia
if ($polaczenie->connect_error) {
    die("Błąd połączenia: " . $polaczenie->connect_error);
}

// Zapytanie
$zapytanie = "SELECT idPotrawy, nazwa, czas_przygotowania FROM potrawy ORDER BY nazwa";
$rezultat = $polaczenie->query($zapytanie);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Lista potraw</title>
</head>
<body>
<h1>Lista potraw</h1>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nazwa</th>
        <th>Czas (min)</th>
    </tr>
    <?php while ($wiersz = $rezultat->fetch_assoc()): ?>
    <tr>
        <td><?= $wiersz['idPotrawy'] ?></td>
        <td><?= htmlspecialchars($wiersz['nazwa']) ?></td>
        <td><?= $wiersz['czas_przygotowania'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
<?php $polaczenie->close(); ?>
```

**Co sprawdza egzaminator:** Połączenie MySQLi OOP, pętla while z fetch_assoc(), htmlspecialchars().

---

## ZADANIE 2: Pojedyncza potrawa po ID z URL (WZORZEC EGZAMINACYJNY)

**Cel:** Pobrać parametr `?id=` z URL i wyświetlić jedną potrawę z JOIN.

```php
<?php
$polaczenie = new mysqli("localhost", "root", "", "przepisy");

// Pobierz id z URL — intval() zabezpiecza przed SQL Injection
$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Zapytanie z JOIN — wzorzec egzaminacyjny!
$zapytanie = "SELECT potrawy.nazwa, potrawy.opis, potrawy.czas_przygotowania, 
              rodzaje.rodzaj 
              FROM potrawy 
              JOIN rodzaje ON rodzaje.idRodzaje = potrawy.idRodzaje 
              WHERE potrawy.idPotrawy = $id";

$rezultat = $polaczenie->query($zapytanie);
$wiersz = $rezultat->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pl">
<head><meta charset="UTF-8"><title>Potrawa</title></head>
<body>
<?php if ($wiersz): ?>
    <h1><?= htmlspecialchars($wiersz['nazwa']) ?></h1>
    <p><strong>Rodzaj:</strong> <?= htmlspecialchars($wiersz['rodzaj']) ?></p>
    <p><strong>Opis:</strong> <?= htmlspecialchars($wiersz['opis']) ?></p>
    <p><strong>Czas:</strong> <?= $wiersz['czas_przygotowania'] ?> minut</p>
<?php else: ?>
    <p>Nie znaleziono potrawy o id: <?= $id ?></p>
<?php endif; ?>
</body>
</html>
<?php $polaczenie->close(); ?>
```

**URL testowy:** `index.php?id=1`, `index.php?id=3`  
**Co sprawdza egzaminator:** `intval()`, JOIN z ON, `fetch_assoc()`, wyświetlenie w HTML.

---

## ZADANIE 3: Nawigacja między potrawami (lista linków)

**Cel:** Wyświetlić listę potraw jako linki — po kliknięciu wyświetlić szczegóły.

**Plik: lista.php**
```php
<?php
$polaczenie = new mysqli("localhost", "root", "", "przepisy");
$rezultat = $polaczenie->query("SELECT idPotrawy, nazwa FROM potrawy ORDER BY nazwa");
?>
<ul>
<?php while ($wiersz = $rezultat->fetch_assoc()): ?>
    <li>
        <a href="szczegoly.php?id=<?= $wiersz['idPotrawy'] ?>">
            <?= htmlspecialchars($wiersz['nazwa']) ?>
        </a>
    </li>
<?php endwhile; ?>
</ul>
<?php $polaczenie->close(); ?>
```

**Plik: szczegoly.php** — kod z Zadania 2 powyżej.

---

## ZADANIE 4: Lista rozwijalna `<select>` z danych z bazy

**Cel:** Wypełnić `<select>` rodzajami potraw poranymi z bazy.

```php
<?php
$polaczenie = new mysqli("localhost", "root", "", "przepisy");
$rodzaje = $polaczenie->query("SELECT idRodzaje, rodzaj FROM rodzaje ORDER BY rodzaj");
?>
<form method="GET" action="">
    <label for="rodzaj">Wybierz rodzaj:</label>
    <select name="idRodzaje" id="rodzaj">
        <option value="">-- wszystkie --</option>
        <?php while ($r = $rodzaje->fetch_assoc()): ?>
        <option value="<?= $r['idRodzaje'] ?>" 
            <?= (isset($_GET['idRodzaje']) && $_GET['idRodzaje'] == $r['idRodzaje']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($r['rodzaj']) ?>
        </option>
        <?php endwhile; ?>
    </select>
    <button type="submit">Filtruj</button>
</form>

<?php
// Wyświetl potrawy po filtracji
if (isset($_GET['idRodzaje']) && intval($_GET['idRodzaje']) > 0) {
    $idRodzaje = intval($_GET['idRodzaje']);
    $potrawy = $polaczenie->query(
        "SELECT nazwa FROM potrawy WHERE idRodzaje = $idRodzaje ORDER BY nazwa"
    );
    echo "<ul>";
    while ($p = $potrawy->fetch_assoc()) {
        echo "<li>" . htmlspecialchars($p['nazwa']) . "</li>";
    }
    echo "</ul>";
}
$polaczenie->close();
?>
```

---

## ZADANIE 5: Formularz dodawania potrawy (INSERT)

**Cel:** Formularz POST → walidacja → INSERT do bazy.

```php
<?php
$polaczenie = new mysqli("localhost", "root", "", "przepisy");
$bledy = [];
$sukces = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Walidacja
    $nazwa = trim($_POST['nazwa'] ?? '');
    $opis = trim($_POST['opis'] ?? '');
    $czas = intval($_POST['czas_przygotowania'] ?? 0);
    $idRodzaje = intval($_POST['idRodzaje'] ?? 0);

    if (empty($nazwa)) {
        $bledy[] = "Nazwa jest wymagana";
    } elseif (strlen($nazwa) < 3) {
        $bledy[] = "Nazwa musi mieć min 3 znaki";
    }
    if ($czas <= 0) {
        $bledy[] = "Czas przygotowania musi być większy od 0";
    }
    if ($idRodzaje <= 0) {
        $bledy[] = "Wybierz rodzaj potrawy";
    }

    // Jeśli brak błędów — zapisz
    if (empty($bledy)) {
        $nazwaE = $polaczenie->real_escape_string($nazwa);
        $opisE = $polaczenie->real_escape_string($opis);
        $sql = "INSERT INTO potrawy (nazwa, opis, czas_przygotowania, idRodzaje) 
                VALUES ('$nazwaE', '$opisE', $czas, $idRodzaje)";
        if ($polaczenie->query($sql)) {
            $sukces = true;
        }
    }
}

$rodzaje = $polaczenie->query("SELECT idRodzaje, rodzaj FROM rodzaje ORDER BY rodzaj");
?>
<!DOCTYPE html>
<html lang="pl">
<head><meta charset="UTF-8"><title>Dodaj potrawę</title></head>
<body>
<h1>Dodaj potrawę</h1>

<?php if ($sukces): ?>
    <p style="color:green">Potrawa dodana pomyślnie!</p>
<?php endif; ?>

<?php foreach ($bledy as $blad): ?>
    <p style="color:red"><?= htmlspecialchars($blad) ?></p>
<?php endforeach; ?>

<form method="POST">
    <label>Nazwa: <input type="text" name="nazwa" value="<?= htmlspecialchars($_POST['nazwa'] ?? '') ?>" required></label><br>
    <label>Opis: <textarea name="opis"><?= htmlspecialchars($_POST['opis'] ?? '') ?></textarea></label><br>
    <label>Czas (min): <input type="number" name="czas_przygotowania" value="<?= intval($_POST['czas_przygotowania'] ?? '') ?>" min="1"></label><br>
    <label>Rodzaj:
        <select name="idRodzaje">
            <?php while ($r = $rodzaje->fetch_assoc()): ?>
            <option value="<?= $r['idRodzaje'] ?>"><?= htmlspecialchars($r['rodzaj']) ?></option>
            <?php endwhile; ?>
        </select>
    </label><br>
    <button type="submit">Dodaj</button>
</form>
</body>
</html>
<?php $polaczenie->close(); ?>
```

---

## ZADANIE 6: Wyszukiwanie potraw (LIKE)

**Cel:** Formularz szukaj → zapytanie z LIKE → wyniki.

```php
<?php
$polaczenie = new mysqli("localhost", "root", "", "przepisy");
$szukana = '';
$wyniki = null;

if (isset($_GET['szukaj'])) {
    $szukana = trim($_GET['szukaj']);
    if (!empty($szukana)) {
        $szukanaE = $polaczenie->real_escape_string($szukana);
        $wyniki = $polaczenie->query(
            "SELECT potrawy.nazwa, rodzaje.rodzaj 
             FROM potrawy 
             JOIN rodzaje ON rodzaje.idRodzaje = potrawy.idRodzaje 
             WHERE potrawy.nazwa LIKE '%$szukanaE%' 
             ORDER BY potrawy.nazwa"
        );
    }
}
?>
<form method="GET">
    <input type="text" name="szukaj" value="<?= htmlspecialchars($szukana) ?>" placeholder="Szukaj potrawy...">
    <button type="submit">Szukaj</button>
</form>

<?php if ($wyniki !== null): ?>
    <p>Znaleziono: <?= $wyniki->num_rows ?> wyników</p>
    <?php if ($wyniki->num_rows > 0): ?>
    <ul>
        <?php while ($w = $wyniki->fetch_assoc()): ?>
        <li><?= htmlspecialchars($w['nazwa']) ?> — <em><?= htmlspecialchars($w['rodzaj']) ?></em></li>
        <?php endwhile; ?>
    </ul>
    <?php endif; ?>
<?php endif; ?>
<?php $polaczenie->close(); ?>
```

---

## ZADANIE 7: Usuwanie rekordu z potwierdzeniem

**Cel:** Link usuń → potwierdzenie → DELETE z bazy.

```php
<?php
$polaczenie = new mysqli("localhost", "root", "", "przepisy");

// Obsłuż usunięcie
if (isset($_GET['usun']) && intval($_GET['usun']) > 0) {
    $id = intval($_GET['usun']);
    $polaczenie->query("DELETE FROM potrawy WHERE idPotrawy = $id");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$potrawy = $polaczenie->query("SELECT idPotrawy, nazwa FROM potrawy ORDER BY nazwa");
?>
<table border="1">
    <tr><th>Nazwa</th><th>Akcja</th></tr>
    <?php while ($w = $potrawy->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($w['nazwa']) ?></td>
        <td>
            <a href="?usun=<?= $w['idPotrawy'] ?>" 
               onclick="return confirm('Usunąć <?= addslashes($w['nazwa']) ?>?')">
               Usuń
            </a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<?php $polaczenie->close(); ?>
```

---

## ZADANIE 8: Sesja — logowanie i ochrona strony

**Cel:** Formularz logowania → sesja → ochrona podstrony.

**Plik: login.php**
```php
<?php
session_start();

// Jeśli już zalogowany — przekieruj
if (isset($_SESSION['zalogowany'])) {
    header("Location: panel.php");
    exit;
}

$blad = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $haslo = $_POST['haslo'] ?? '';
    
    // Sprawdź dane (tutaj na sztywno — na egzaminie może być z bazy)
    if ($email === 'admin@test.pl' && $haslo === 'admin123') {
        $_SESSION['zalogowany'] = true;
        $_SESSION['email'] = $email;
        header("Location: panel.php");
        exit;
    } else {
        $blad = "Błędny email lub hasło";
    }
}
?>
<form method="POST">
    <?php if ($blad): ?><p style="color:red"><?= $blad ?></p><?php endif; ?>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="haslo" placeholder="Hasło" required><br>
    <button type="submit">Zaloguj</button>
</form>
```

**Plik: panel.php**
```php
<?php
session_start();

// Ochrona strony — sprawdź sesję
if (!isset($_SESSION['zalogowany'])) {
    header("Location: login.php");
    exit;
}
?>
<p>Witaj, <?= htmlspecialchars($_SESSION['email']) ?>!</p>
<a href="logout.php">Wyloguj</a>
```

**Plik: logout.php**
```php
<?php
session_start();
session_destroy();
header("Location: login.php");
exit;
?>
```

---

## ZADANIE 9: Upload zdjęcia do potrawy

**Cel:** Formularz z plikiem → walidacja → move_uploaded_file.

```php
<?php
$polaczenie = new mysqli("localhost", "root", "", "przepisy");
$komunikat = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['zdjecie'])) {
    $plik = $_FILES['zdjecie'];
    $dozwoloneTypy = ['image/jpeg', 'image/png', 'image/gif'];
    $maxRozmiar = 2 * 1024 * 1024; // 2 MB

    if ($plik['error'] !== UPLOAD_ERR_OK) {
        $komunikat = "Błąd uploadu: " . $plik['error'];
    } elseif (!in_array($plik['type'], $dozwoloneTypy)) {
        $komunikat = "Dozwolone tylko: JPG, PNG, GIF";
    } elseif ($plik['size'] > $maxRozmiar) {
        $komunikat = "Plik za duży (max 2 MB)";
    } else {
        // Bezpieczna nazwa pliku
        $rozszerzenie = pathinfo($plik['name'], PATHINFO_EXTENSION);
        $nowaNazwa = uniqid('zdjecie_') . '.' . $rozszerzenie;
        $docelowy = 'uploads/' . $nowaNazwa;
        
        if (!is_dir('uploads')) mkdir('uploads', 0755);
        
        if (move_uploaded_file($plik['tmp_name'], $docelowy)) {
            $komunikat = "Plik zapisany: $nowaNazwa";
        } else {
            $komunikat = "Błąd zapisu pliku";
        }
    }
}
?>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="zdjecie" accept="image/*" required>
    <button type="submit">Wyślij</button>
</form>
<?php if ($komunikat): ?>
    <p><?= htmlspecialchars($komunikat) ?></p>
<?php endif; ?>
```

---

## ZADANIE 10: Paginacja (stronicowanie)

**Cel:** Wyświetlić 3 potrawy na stronie z linkami Poprzednia/Następna.

```php
<?php
$polaczenie = new mysqli("localhost", "root", "", "przepisy");

$naStrone = 3;
$strona = isset($_GET['strona']) ? max(1, intval($_GET['strona'])) : 1;
$offset = ($strona - 1) * $naStrone;

// Policz wszystkie rekordy
$liczbRekordow = $polaczenie->query("SELECT COUNT(*) AS ile FROM potrawy")->fetch_assoc()['ile'];
$liczbStron = ceil($liczbRekordow / $naStrone);

// Pobierz rekordy dla bieżącej strony
$potrawy = $polaczenie->query(
    "SELECT nazwa, czas_przygotowania FROM potrawy ORDER BY nazwa LIMIT $naStrone OFFSET $offset"
);
?>
<ul>
<?php while ($w = $potrawy->fetch_assoc()): ?>
    <li><?= htmlspecialchars($w['nazwa']) ?> (<?= $w['czas_przygotowania'] ?> min)</li>
<?php endwhile; ?>
</ul>

<nav>
    <?php if ($strona > 1): ?>
        <a href="?strona=<?= $strona - 1 ?>">← Poprzednia</a>
    <?php endif; ?>
    
    Strona <?= $strona ?> z <?= $liczbStron ?>
    
    <?php if ($strona < $liczbStron): ?>
        <a href="?strona=<?= $strona + 1 ?>">Następna →</a>
    <?php endif; ?>
</nav>
<?php $polaczenie->close(); ?>
```

---

## ZADANIE 11: PHP zwraca JSON dla JavaScript (AJAX)

**Cel:** PHP jako mini API — zwraca dane w formacie JSON.

**Plik: api_potrawy.php**
```php
<?php
header('Content-Type: application/json; charset=utf-8');

$polaczenie = new mysqli("localhost", "root", "", "przepisy");

if ($polaczenie->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Błąd połączenia']);
    exit;
}

$wynik = $polaczenie->query(
    "SELECT potrawy.idPotrawy, potrawy.nazwa, rodzaje.rodzaj, potrawy.czas_przygotowania
     FROM potrawy 
     JOIN rodzaje ON rodzaje.idRodzaje = potrawy.idRodzaje 
     ORDER BY potrawy.nazwa"
);

$dane = [];
while ($wiersz = $wynik->fetch_assoc()) {
    $dane[] = $wiersz;
}

echo json_encode($dane, JSON_UNESCAPED_UNICODE);
$polaczenie->close();
?>
```

**Plik: index.html** (klient JavaScript)
```html
<button id="zaladuj">Załaduj potrawy</button>
<ul id="lista"></ul>

<script>
document.getElementById('zaladuj').addEventListener('click', function() {
    fetch('api_potrawy.php')
        .then(response => response.json())
        .then(data => {
            const lista = document.getElementById('lista');
            lista.innerHTML = '';
            data.forEach(p => {
                lista.innerHTML += `<li>${p.nazwa} — ${p.rodzaj}</li>`;
            });
        })
        .catch(error => console.error('Błąd:', error));
});
</script>
```

---

## ZADANIE 12: Edycja rekordu (UPDATE)

**Cel:** Pobierz rekord do formularza, obsłuż UPDATE.

```php
<?php
$polaczenie = new mysqli("localhost", "root", "", "przepisy");
$komunikat = '';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) die("Brak id");

// Obsłuż zapis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nazwa = $polaczenie->real_escape_string(trim($_POST['nazwa']));
    $czas = intval($_POST['czas_przygotowania']);
    
    if (!empty($nazwa) && $czas > 0) {
        $polaczenie->query("UPDATE potrawy SET nazwa='$nazwa', czas_przygotowania=$czas WHERE idPotrawy=$id");
        $komunikat = "Zapisano zmiany!";
    } else {
        $komunikat = "Wypełnij wszystkie pola!";
    }
}

// Pobierz aktualny rekord
$wiersz = $polaczenie->query("SELECT * FROM potrawy WHERE idPotrawy=$id")->fetch_assoc();
if (!$wiersz) die("Nie znaleziono potrawy");
?>
<h1>Edytuj: <?= htmlspecialchars($wiersz['nazwa']) ?></h1>
<?php if ($komunikat): ?><p><?= $komunikat ?></p><?php endif; ?>

<form method="POST">
    <label>Nazwa: 
        <input type="text" name="nazwa" 
               value="<?= htmlspecialchars($wiersz['nazwa']) ?>" required>
    </label><br>
    <label>Czas (min): 
        <input type="number" name="czas_przygotowania" 
               value="<?= $wiersz['czas_przygotowania'] ?>" min="1">
    </label><br>
    <button type="submit">Zapisz</button>
    <a href="lista.php">Anuluj</a>
</form>
<?php $polaczenie->close(); ?>
```

---

## PODSUMOWANIE — CHECKLIST PHP

- [ ] `new mysqli("localhost", "root", "", "baza")` — połączenie
- [ ] `$id = isset($_GET['id']) ? intval($_GET['id']) : 1;` — parametr z URL
- [ ] `JOIN ... ON` w zapytaniu SQL
- [ ] `fetch_assoc()` — jeden wiersz
- [ ] `while ($w = $result->fetch_assoc())` — wiele wierszy
- [ ] `htmlspecialchars()` — ochrona przed XSS
- [ ] `$_SERVER['REQUEST_METHOD'] === 'POST'` — sprawdzenie metody
- [ ] `session_start()` przed jakimkolwiek output
- [ ] `enctype="multipart/form-data"` dla uploadu pliku
- [ ] `$polaczenie->close()` — zamknięcie połączenia

---

**Powodzenia! Wróć do: [02_PHP_MYSQL_EGZAMIN.md](../../INF.03.5_Programowanie_aplikacji/PHP/02_PHP_MYSQL_EGZAMIN.md)**
