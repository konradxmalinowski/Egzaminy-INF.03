# WZORZEC EGZAMINACYJNY INF.03 - Egzamin Praktyczny

> NAJWAZNIEJSZA SCIAGAWKA!
> Na podstawie prawdziwych egzaminow: inf_03_2024_*, inf_03_2025_*, inf_03_2026_*

---

## FORMAT EGZAMINU - CO DOSTAJEMY

### Zawartosc archiwum egzaminacyjnego (staly schemat):
```
egzamin_xxx/
├── baza.sql          <- Import do phpMyAdmin JAKO PIERWSZE!
├── plik_glowny.php   <- Szablon PHP do uzupelnienia
├── styl.css          <- Style CSS do uzupelnienia
├── kwerendy.txt      <- 4 kwerendy SQL do napisania
├── obrazek1.jpg      <- Obrazki uzywane w PHP/CSS
├── obrazek2.jpg
└── kw1.jpg           <- Screenshoty oczekiwanych wynikow kwerend!
    kw2.jpg
    kw3.jpg
    kw4.jpg
```

### Struktura egzaminu (STALY UKLAD):
| Czesc | Zadanie | Punkty |
|-------|---------|--------|
| **SQL** | 4 kwerendy (kw1-kw4) | ok. 40% punktow |
| **PHP** | Uzupelnienie logiki + integracja z baza | ok. 40% punktow |
| **CSS** | Stylowanie elementow (float layout) | ok. 20% punktow |

### Wzorzec 4 kwerend SQL (stale powtarzajacy sie schemat!)
```
kw1: SELECT proste z WHERE  LUB  SELECT ROUND(AVG(kol), 2) FROM ... WHERE
kw2: INSERT INTO tabela (kolumny) VALUES ('wartosci')  LUB  SELECT z JOIN 2 tabele + WHERE
kw3: SELECT z JOIN 2 tabel + WHERE
kw4: SELECT z JOIN + GROUP BY  LUB  SELECT z JOIN 3 tabel
```

---

## KROK PO KROKU - PLAN DZIALANIA NA EGZAMINIE

### KROK 1 (pierwsze 5 minut): Import bazy danych
1. Otworz phpMyAdmin: http://localhost:8888/phpMyAdmin lub http://localhost/phpMyAdmin
2. Kliknij "Nowy" (lewy panel) - stworz nowa baze o nazwie z pliku .php
3. Wejdz do nowej bazy → kliknij "Import" → wybierz plik baza.sql → "Wykonaj"
4. Sprawdz ze tabele sie pojawily w lewym panelu

### KROK 2 (5-15 minut): Kwerendy SQL
1. Obejrzyj screenshoty kw1.jpg, kw2.jpg, kw3.jpg, kw4.jpg - wiesz co ma zwrocic
2. Wejdz do phpMyAdmin → wybrana baza → zakladka "SQL"
3. Napisz kwerende, przetestuj (widac wyniki od razu)
4. Wklej do pliku kwerendy.txt

### KROK 3 (15-50 minut): PHP
1. Otworz plik .php w edytorze (VS Code / Notepad++)
2. Sprawdz czy nazwa bazy w mysqli zgadza sie z importowana baza
3. Uzupelnij logike PHP zgodnie z zadaniem
4. Testuj w przegladarce: http://localhost:8888/nazwaFolderu/plik.php

### KROK 4 (50-65 minut): CSS
1. Otwor plik styl.css
2. Uzupelnij brakujace style (najczesciej float, width, height, background-color)
3. Sprawdz wyglad w przegladarce, porownaj z wzorcem

### KROK 5 (ostatnie 5 minut): Checklista przed oddaniem
- [ ] Kwerendy - czy wszystkie 4 sa w kwerendy.txt?
- [ ] PHP - czy strona sie wyswietla bez bledow (biala strona = blad PHP!)?
- [ ] PHP - czy dane z bazy sa widoczne w tabeli?
- [ ] PHP - czy GET/POST dziala (formularz/linki)?
- [ ] CSS - czy float layout wyglada jak na wzorcu?
- [ ] CSS - czy kolory/fonty sa zgodne z poleceniem?
- [ ] Numer zdajacego - czy wpisany w PHP i/lub CSS?

---

## PELNY WZORZEC PHP - KOMPLETNY PLIK

### Wzorzec 1: Layout z sekcja-lewa / sekcja-prawa (INF.03-2026-01)
```php
<?php 
$db = new mysqli("localhost", "root", "", "nazwa_bazy");
// Sprawdzenie polaczenia (opcjonalne ale profesjonalne)
if ($db->connect_error) {
    die("Blad polaczenia: " . $db->connect_error);
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styl.css">
    <title>Tytul strony</title>
</head>
<body>
    <header>
        <section class="header-lewy">
            <img src="logo.png" alt="Logo">
        </section>
        <section class="header-prawy">
            <h1>Tytul aplikacji</h1>
        </section>
    </header>

    <main>
        <!-- SEKCJA LEWA: tabela z danymi z bazy -->
        <section class="sekcja-lewa">
            <h2>Naglowek sekcji</h2>
            <table>
                <tr>
                    <th>Kolumna 1</th>
                    <th>Kolumna 2</th>
                    <th>Kolumna 3</th>
                </tr>
                <?php 
                    // ZAPYTANIE SQL Z JOIN - najczesciej kw3 z egzaminu
                    $zapytanie = "SELECT t1.kolumna1, t2.kolumna2, t1.kolumna3
                                  FROM tabela1 t1
                                  JOIN tabela2 t2 ON t2.id = t1.id_tabela2
                                  WHERE t1.id_cos = 7";
                    $rezultat = $db->query($zapytanie);
                    
                    // foreach - dla wielu wynikow
                    foreach ($rezultat as $wiersz) {
                        $val1 = $wiersz['kolumna1'];
                        $val2 = $wiersz['kolumna2'];
                        $val3 = intval($wiersz['kolumna3']); // konwersja jesli liczba
                        
                        // Logika warunkowa - np. wybor obrazka
                        $obrazek = "";
                        if ($val3 > 30) {
                            $obrazek = "hot.png";
                        } elseif ($val3 < 15) {
                            $obrazek = "cold.png";
                        } else {
                            $obrazek = "normal.png";
                        }
                        
                        echo "
                        <tr>
                            <td>$val1</td>
                            <td>$val2</td>
                            <td>$val3</td>
                            <td><img src=\"$obrazek\" alt=\"ikona\"></td>
                        </tr>
                        ";
                    }
                ?>
            </table>
        </section>

        <!-- SEKCJA PRAWA: linki + wyniki na podstawie GET -->
        <section class="sekcja-prawa">
            <h2>Wybierz element</h2>
            <a href="index.php?id=1">Element 1</a>
            <a href="index.php?id=2">Element 2</a>
            <a href="index.php?id=3">Element 3</a>

            <?php
                if (isset($_GET['id'])) {
                    $id = intval($_GET['id']); // ZAWSZE intval dla bezpieczenstwa!
                    
                    // ZAPYTANIE SQL - np. kw1 z egzaminu
                    $zapytanie = "SELECT ROUND(AVG(kolumna), 2) AS wynik
                                  FROM tabela
                                  WHERE id_cos = $id";
                    $rezultat = $db->query($zapytanie);
                    $wiersz = $rezultat->fetch_assoc();
                    $wynik = $wiersz['wynik']; // lub floatval()
                    
                    echo "<h3>Wynik: $wynik</h3>";
                }
            ?>
        </section>

        <div class="clear-both"></div>
    </main>

    <footer>
        <p>Numer zdajacego: [TWOJ NUMER]</p>
    </footer>
</body>
</html>

<?php $db->close(); ?>
```

### Wzorzec 2: Layout aside/main/section (INF.03-2026-10, INF.03-2025)
```php
<?php 
$polaczenie = new mysqli("localhost", "root", "", "nazwa_bazy");

// Pobieranie id z GET (z domyslna wartoscia)
$id = 7; // domyslne id
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styl.css">
    <title>Blog / Aplikacja</title>
</head>
<body>
    <!-- ASIDE: menu nawigacyjne z linkami -->
    <aside>
        <a href="index.php?id=1">Element 1</a><br>
        <a href="index.php?id=2">Element 2</a><br>
        <a href="index.php?id=3">Element 3</a><br>
        <!-- ... -->
        <p>Autor: [IMIE NAZWISKO]</p>
    </aside>

    <!-- MAIN: glowna zawartosc - dane z bazy -->
    <main>
        <h1>
            <?php
                // Zapytanie 1: kategoria / rodzaj
                $sql = "SELECT tabela1.kolumna1, tabela2.kategoria
                        FROM tabela1
                        JOIN tabela2 ON tabela2.id = tabela1.id_tabela2
                        WHERE tabela1.id = $id";
                $wynik = $polaczenie->query($sql);
                $row = $wynik->fetch_assoc();
                echo $row['kategoria'];
            ?>
        </h1>

        <?php
            // Zapytanie 2: szczegoly elementu
            $sql = "SELECT nazwa, pole1, pole2 FROM tabela1 WHERE id = $id";
            $wynik = $polaczenie->query($sql);
            $row = $wynik->fetch_assoc();
            $nazwa = $row['nazwa'];
            $pole1 = intval($row['pole1']);
            $pole2 = $row['pole2'];

            // Konwersja wartosci liczbowej na tekst
            $tekst = "";
            if ($pole1 === 1) $tekst = "latwy";
            elseif ($pole1 === 2) $tekst = "sredni";
            elseif ($pole1 === 3) $tekst = "trudny";

            echo "<h2>$nazwa</h2>";
            echo "<p>Poziom: $tekst | Kalorie: $pole2</p>";
        ?>

        <!-- Zapytanie 3: relacja wiele-do-wielu (aleregy, tagi, autorzy) -->
        <p>Powiazane elementy: 
        <?php
            $sql = "SELECT t1.nazwa, t3.kolumna
                    FROM t1
                    JOIN tabela_posrednia ON tabela_posrednia.id_t1 = t1.id
                    JOIN t3 ON t3.id = tabela_posrednia.id_t3
                    WHERE t1.id = $id";
            $wynik = $polaczenie->query($sql);
            
            $lista = [];
            foreach ($wynik as $row) {
                $lista[] = $row['kolumna'];
            }
            echo implode(", ", $lista);  // lub join(", ", $lista)
        ?>
        </p>
    </main>

    <!-- SECTION: tlo z obrazka -->
    <section style="background-image: url(<?php
        $sql = "SELECT plik FROM tabela1 WHERE id = $id";
        $wynik = $polaczenie->query($sql);
        $row = $wynik->fetch_assoc();
        echo $row['plik'];
    ?>);">
        <h1>Tytul sekcji</h1>
    </section>

    <div class="clear-both"></div>
</body>
</html>

<?php $polaczenie->close(); ?>
```

### Wzorzec 3: Z formularzem POST i przyciskami radio (INF.03-2024)
```php
<?php
$conn = new mysqli('localhost', 'root', '', 'nazwa_bazy');
if ($conn->connect_error) {
    echo "<p>Blad laczenia z baza danych</p>";
    exit;
}
?>
<!-- HTML / head / body ... -->

<?php
// Obsluga formularza POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['opcja'])) {
    $wybranaOpcja = $_POST['opcja'];
    
    // Wybor zapytania na podstawie opcji z formularza
    switch ($wybranaOpcja) {
        case 'wszystkie':
            $zapytanie = "SELECT kolumna1, kolumna2 FROM tabela";
            break;
        case 'filtr1':
            $zapytanie = "SELECT kolumna1, kolumna2 FROM tabela WHERE warunek > prog1";
            break;
        case 'filtr2':
            $zapytanie = "SELECT kolumna1, kolumna2 FROM tabela WHERE warunek > prog2";
            break;
        default:
            $zapytanie = "SELECT kolumna1, kolumna2 FROM tabela";
    }
    
    $wyniki = $conn->query($zapytanie);
    foreach ($wyniki as $row) {
        echo "<tr><td>{$row['kolumna1']}</td><td>{$row['kolumna2']}</td></tr>";
    }
}
$conn->close();
?>
```

---

## PELNY WZORZEC CSS - FLOAT LAYOUT

### Wzorzec 1: Header dwukolumnowy + Main dwukolumnowy (INF.03-2026-01)
```css
/* Reset i font */
body {
    font-family: Georgia, serif;     /* lub Arial, Bookman, Garamond */
    text-align: center;
    margin: 0;
}

/* HEADER: dwie sekcje obok siebie */
.header-lewy, .header-prawy {
    background-color: #388E3C;       /* kolor z polecenia */
    color: white;
    height: 100px;
    float: left;
}

.header-lewy {
    width: 20%;
}

.header-prawy {
    width: 80%;
}

/* Czyszczenie float po headerze */
main {
    clear: both;
}

/* MAIN: dwie sekcje obok siebie */
.sekcja-lewa, .sekcja-prawa {
    background-color: #DCE775;
    width: 50%;
    height: 600px;
    float: left;
}

/* Czyszczenie float */
.clear-both {
    clear: both;
}

/* FOOTER */
footer {
    background-color: #388E3C;
    color: white;
    padding: 10px;
}

/* TABELA */
table {
    width: 80%;
    margin: auto;
    border: 2px dashed #388E3C;
    border-collapse: collapse;
}

th, td {
    padding: 5px;
    border: 1px solid #388E3C;
}

table img {
    height: 70px;
}

/* LINKI */
a {
    color: #388E3C;
    margin: 20px;
    font-style: italic;
    font-size: 200%;
    text-decoration: none;
}

a:hover {
    background-color: #388E3C;
    color: #DCE775;
}
```

### Wzorzec 2: Aside + Main + Section (INF.03-2026-10, INF.03-2025)
```css
/* Global */
* {
    font-family: Garamond, serif;
    text-align: center;
    box-sizing: border-box;
}

/* ASIDE: menu boczne (waska kolumna po lewej) */
aside {
    background-color: #3A3C3E;
    color: white;
    width: 10%;
    height: 600px;
    float: left;           /* FLOAT LEFT - kluczowe! */
}

/* MAIN: tresc glowna (srodkowa kolumna) */
main {
    background-color: ghostwhite;
    width: 45%;
    height: 600px;
    float: left;           /* FLOAT LEFT */
    overflow: auto;        /* scroll jesli tresc za dluga */
}

/* SECTION: tlo z obrazka (prawa kolumna) */
section {
    background-size: cover;
    background-position: center;
    color: white;
    width: 45%;
    height: 600px;
    float: left;           /* FLOAT LEFT */
}

/* Czyszczenie floatow */
.clear-both {
    clear: both;
}

/* Naglowki */
h1 {
    background-color: rgba(211, 211, 211, 0.3);  /* polprzezroczyste tlo */
    padding: 20px 0;
    margin: 0;
    font-size: 2em;
}

h2 {
    font-size: 2em;
    font-variant: small-caps;
}

/* LINKI w aside */
a {
    color: Gainsboro;
    font-size: 120%;
    font-style: italic;
    display: block;        /* kazdy link w nowej linii */
    text-decoration: none;
}

a:hover {
    color: white;
    text-decoration: underline;
}

/* Lista (li text-align: left!) */
li {
    text-align: left;
}
```

### Wzorzec 3: Header + 3 sekcje (INF.03-2025-01)
```css
body {
    font-family: Bookman, serif;
}

header, footer {
    background-color: indigo;
    color: white;
    padding: 10px;
    text-align: center;
}

footer {
    clear: both;           /* czysci float pod sekcjami */
}

/* Trzy kolumny */
.lewy-blok, .prawy-blok, .srodkowy-blok {
    float: left;
}

.lewy-blok, .prawy-blok {
    background-color: lavender;
    height: 500px;
}

.lewy-blok {
    width: 25%;
}

.srodkowy-blok {
    background-color: ghostwhite;
    width: 40%;
    height: 500px;
}

.prawy-blok {
    width: 35%;
}

/* Tabela */
table, th, td {
    border-collapse: collapse;
    border: 1px solid indigo;
}

th, td {
    padding: 3px;
}
```

---

## 4 TYPOWE KWERENDY SQL Z EGZAMINU

### Kwerenda 1 - SELECT z WHERE lub ROUND(AVG)
```sql
-- Wariant A: proste SELECT z WHERE
SELECT nazwa, pole1, pole2 FROM tabela WHERE id = 7;

-- Wariant B: srednia zaokraglona (BARDZO czeste!)
SELECT ROUND(AVG(temperatura), 2) FROM pomiary WHERE id_miesiac = 7;

-- Wariant C: SELECT z LIKE
SELECT data FROM imieniny WHERE imiona LIKE '%Karol%';
```

### Kwerenda 2 - INSERT INTO lub SELECT z JOIN
```sql
-- Wariant A: INSERT (czeste!)
INSERT INTO miejscowosc (kraj, nazwa) VALUES ('Ukraina', 'Kijow');
INSERT INTO imieniny (zyczenia) VALUES ('Wszystkiego najlepszego!');

-- Wariant B: ALTER TABLE ADD
ALTER TABLE imieniny ADD zyczenia VARCHAR(500);
```

### Kwerenda 3 - SELECT z JOIN 2 tabel + WHERE
```sql
-- Schemat: ZAWSZE tabela1.kolumna, tabela2.kolumna
-- JOIN ON: najpierw nowa tabela, potem bazowa
SELECT miejscowosc.nazwa, miejscowosc.kraj, pomiary.temperatura
FROM miejscowosc
JOIN pomiary ON pomiary.id_miejscowosc = miejscowosc.id
WHERE pomiary.id_miesiac = 7;

-- Z warunkiem porownujacym dwie kolumny!
SELECT nazwa, rzeka, stanOstrzegawczy, stanAlarmowy, stanWody
FROM wodowskazy
JOIN pomiary ON pomiary.wodowskazy_id = wodowskazy.id
WHERE dataPomiaru = '2022-05-05' AND stanWody > stanOstrzegawczy;
```

### Kwerenda 4 - JOIN + GROUP BY lub JOIN 3 tabel
```sql
-- Wariant A: GROUP BY z AVG (czeste!)
SELECT miesiace.nazwa, AVG(pomiary.temperatura)
FROM miesiace
JOIN pomiary ON pomiary.id_miesiac = miesiace.id
GROUP BY miesiace.nazwa;

-- Wariant B: 3 tabele przez tabele posrednia (many-to-many)
SELECT potrawy.nazwa, alergeny.alergen
FROM potrawy
JOIN lista_alergenow ON lista_alergenow.idPotrawy = potrawy.idPotrawy
JOIN alergeny ON alergeny.idAlergeny = lista_alergenow.idAlergeny
WHERE potrawy.idPotrawy = 7;
```

---

## CHECKLISTA PRZED ODDANIEM

### SQL (kwerendy.txt)
- [ ] kw1 zwraca to co widac na kw1.jpg
- [ ] kw2 dziala (nie daje ERROR w phpMyAdmin)
- [ ] kw3 zwraca to co na kw3.jpg (sprawdz czy JOIN i WHERE sie zgadzaja)
- [ ] kw4 dziala, GROUP BY jest jezeli potrzebne
- [ ] Wszystkie kwerendy zapisane do kwerendy.txt

### PHP
- [ ] Nazwa bazy w mysqli ZGADZA SIE z zaimportowana baza
- [ ] Strona laduje sie bez bledu (nie ma pustej bialej strony)
- [ ] Tabela z danymi z bazy jest wypelniona
- [ ] Linki/przyciski zmieniaja dane na stronie
- [ ] Logika warunkowa (if/switch) dziala poprawnie
- [ ] Numer zdajacego wpisany w stopce lub komentarzu

### CSS
- [ ] Kolory zgodne z poleceniem / wzorcem
- [ ] Float dziala - elementy sa obok siebie (nie pod soba)
- [ ] Width procentowy sumuje sie do 100% dla elementow w tej samej linii
- [ ] clear: both po elementach z float
- [ ] Font-family zgodny z poleceniem (Georgia, Garamond, Bookman...)

---

## NAJCZESTSZE BLEDY ZDAJACYCH

### Blad 1: Zla nazwa bazy danych
```php
// ZLE - nie zgadza sie z importowanym SQL
$db = new mysqli("localhost", "root", "", "baza");

// DOBRZE - sprawdz jaka baze importowales!
$db = new mysqli("localhost", "root", "", "pogoda");  // lub "przepisy", "kalendarz" etc.
```
**Jak sprawdzic?** Otwierz plik .sql i sprawdz linijke: `CREATE DATABASE IF NOT EXISTS nazwa;`

### Blad 2: Biala strona (blank page)
Powody: blad skladniowy PHP - brakujacy srednik, niezamkniety cudzyslow, zle nawiasy
```php
// Jak debugowac - wlacz wyswietlanie bledow:
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Dodaj te 2 linie NA SAMYM POCZATKU pliku PHP (przed <html>)
```

### Blad 3: Zly klucz w fetch_assoc
```php
// ZLE - klucz nie zgadza sie z nazwa kolumny w SQL
$zapytanie = "SELECT ROUND(AVG(temperatura), 2) FROM pomiary WHERE id_miesiac = 7";
$wiersz['temperatura'];  // ZLE! Kolumna sie zwie 'ROUND(AVG(temperatura), 2)'

// DOBRZE - uzyj aliasu AS w SQL
$zapytanie = "SELECT ROUND(AVG(temperatura), 2) AS srednia FROM pomiary WHERE id_miesiac = 7";
$wiersz['srednia'];  // DOBRZE!
```

### Blad 4: Float nie dziala - elementy ida pod soba
```css
/* ZLE - brak float lub zle procenty */
.sekcja-lewa { width: 50%; }
.sekcja-prawa { width: 50%; }

/* DOBRZE */
.sekcja-lewa, .sekcja-prawa {
    float: left;     /* OBOWIAZKOWO! */
    width: 50%;
}
```

### Blad 5: Zly JOIN - brak danych w tabeli
```sql
-- ZLE - odwrocona kolejnosc klucza
JOIN pomiary ON miejscowosc.id = pomiary.id_miejscowosc  -- moze nie dzialac

-- DOBRZE - zgodnie z konwencja egzaminow (nowa_tabela.FK = stara_tabela.PK)
JOIN pomiary ON pomiary.id_miejscowosc = miejscowosc.id  -- DOBRZE
```

### Blad 6: intval() - pomijanie konwersji
```php
// ZLE - $id moze byc stringiem z GET
$id = $_GET['id'];
$sql = "SELECT * FROM tabela WHERE id = $id";  // podatne na SQL Injection!

// DOBRZE - zawsze konwertuj na int!
$id = intval($_GET['id']);
$sql = "SELECT * FROM tabela WHERE id = $id";  // bezpieczne
```

### Blad 7: Brak cudzyslow wokol wartosci tekstowej w SQL
```sql
-- ZLE
INSERT INTO miejscowosc (kraj, nazwa) VALUES (Ukraina, Kijow);  -- ERROR!

-- DOBRZE
INSERT INTO miejscowosc (kraj, nazwa) VALUES ('Ukraina', 'Kijow');
```

---

## TECHNIKI DEBUGOWANIA

### Technika 1: Sprawdzenie polaczenia z baza
```php
<?php
$db = new mysqli("localhost", "root", "", "nazwa_bazy");
if ($db->connect_error) {
    die("BLAD POLACZENIA: " . $db->connect_error);
}
echo "Polaczenie OK!";
?>
```
Jesli widzisz "Polaczenie OK!" - baza dziala. Jesli blad - sprawdz nazwe bazy.

### Technika 2: Sprawdzenie czy zapytanie SQL dziala
```php
<?php
$zapytanie = "SELECT * FROM tabela WHERE id = 7";
$wynik = $db->query($zapytanie);
if (!$wynik) {
    echo "BLAD SQL: " . $db->error;
} else {
    echo "Wynik OK, liczba wierszy: " . $wynik->num_rows;
}
?>
```

### Technika 3: Drukowanie zawartosci tablicy (debug)
```php
<?php
$wiersz = $wynik->fetch_assoc();
echo "<pre>";
print_r($wiersz);  // pokazuje wszystkie klucze i wartosci
echo "</pre>";
?>
```
Uzyj tego gdy nie wiesz jak sie nazywa kolumna w fetch_assoc().

### Technika 4: Blank page - co robic
1. Sprawdz logi Apache: /Applications/MAMP/logs/php_error.log
2. Wlacz display_errors w PHP (patrz Blad 2 powyzej)
3. Sprawdz czy plik .php ma poprawne rozszerzenie (nie .txt!)
4. Sprawdz czy MAMP jest uruchomiony (zielone ikony)
5. Sprawdz URL: http://localhost:8888/FOLDER/plik.php

### Technika 5: Szybkie sprawdzenie czy PHP dziala (30 sekund)
```php
<?php
// Wklej NA POCZATKU pliku tymczasowo:
echo "PHP dziala, data: " . date('Y-m-d H:i:s');
$db = new mysqli("localhost", "root", "", "nazwa_bazy");
echo " | DB: " . ($db->connect_error ? "BLAD: ".$db->connect_error : "OK");
exit; // usun ta linie po sprawdzeniu!
?>
```

---

## SZYBKIE REFERENCJE PHP

### Najwazniejsze funkcje PHP na egzaminie
```php
// Konwersja typow
intval($zmienna)        // na int (dla id z GET/POST)
floatval($zmienna)      // na float (dla cen, temperatur)
strval($zmienna)        // na string

// Sprawdzenie zmiennych
isset($_GET['id'])       // czy istnieje GET id
isset($_POST['opcja'])   // czy istnieje POST opcja
$_SERVER['REQUEST_METHOD'] === 'POST'  // czy metoda POST

// Operacje na tablicach
implode(", ", $tablica)  // laczy tablice w string
join(", ", $tablica)     // alias implode
$tablica[] = $element;   // dodanie elementu do tablicy

// Data
date('Y-m-d')           // aktualna data
date('m-d')             // miesiac-dzien (dla imienin)
date('w')               // dzien tygodnia (0=niedziela)

// Stringi
substr($str, $start, $len)  // wycinanie tekstu
strlen($str)                // dlugosc stringa

// Wyswietlanie
echo "<p>$zmienna</p>";          // wyswietl zmienną
echo "<img src=\"$plik\" alt=\"foto\">"; // uwaga na escaping cudzysłowów!
printf("Wynik: %.2f", $liczba); // formatowanie liczby
```

### Polaczenie z baza - dwa sposoby uzywane na egzaminach
```php
// Sposob 1 (strzalkowy - czestszy na egzaminach 2025-2026)
$db = new mysqli("localhost", "root", "", "baza");
$wynik = $db->query("SELECT * FROM tabela");
foreach ($wynik as $row) { echo $row['kolumna']; }
$db->close();

// Sposob 2 (pelny z blokada bledow - czestszy na 2024)
$conn = new mysqli("localhost", "root", "", "baza");
if ($conn->connect_error) { die("Blad: " . $conn->connect_error); }
$result = $conn->query("SELECT * FROM tabela");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) { echo $row['kolumna']; }
}
$conn->close();
```

---

## SZYBKA SCIAGA - WARTOSCI CSS Z EGZAMINOW

### Najczesciej uzywane wlasciwosci CSS na egzaminie
```css
/* Layout */
float: left;               /* elementy obok siebie */
clear: both;               /* koniec floatow */
width: 50%;                /* szerokosc procentowa */
height: 600px;             /* stala wysokosc */
overflow: auto;            /* scroll przy za dlugiej tresci */

/* Kolory tla i tekstu */
background-color: #388E3C;         /* zielony */
background-color: #DCE775;         /* zoltozielony */
background-color: indigo;          /* indygo (nazwy CSS) */
background-color: lavender;        /* lawenda */
background-color: rgba(0,0,0,0.3); /* przezroczyste tlo */
color: white;

/* Tlo z obrazka */
background-image: url(obrazek.jpg);
background-size: cover;
background-position: center;

/* Tekst */
font-family: Georgia, serif;
font-family: Garamond, serif;
font-family: Bookman, serif;
text-align: center;
font-style: italic;
font-variant: small-caps;
font-size: 150%;
font-size: 2em;

/* Odstepy */
margin: auto;              /* wycentrowanie bloku */
padding: 10px;
margin: 20px;

/* Tabele */
border-collapse: collapse;
border: 2px dashed #388E3C;
border: 1px solid indigo;

/* Hover na linkach */
a:hover {
    background-color: kolor;
    color: inny_kolor;
}
```

---

*Opracowanie na podstawie egzaminow INF.03 z lat 2024-2026*
*Wzorce PHP i CSS z egzaminow: inf_03_2026_01_07, inf_03_2026_01_10, inf_03_2025_01_03, inf_03_2024_06_03*
