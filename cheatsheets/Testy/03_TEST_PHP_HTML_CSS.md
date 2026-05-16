# TEST: PHP + HTML + CSS — Pytania Egzaminacyjne (INF.03.3 & INF.03.5)

> **35 pytań PHP/HTML/CSS** — poziom egzaminu INF.03. Odpowiedzi po każdym pytaniu.

---

## CZĘŚĆ 1: HTML (10 pytań)

### Pytanie 1
Który znacznik HTML5 reprezentuje główną zawartość strony (tę która jest unikalna na danej stronie)?

- A) `<section>`
- B) `<article>`
- C) `<main>`
- D) `<div>`

**Odpowiedź: C** — `<main>` oznacza główną, unikalną zawartość strony. Powinna być tylko jedna na stronie. `<section>` to sekcja tematyczna, `<article>` to niezależna treść (np. post bloga), `<div>` to kontener bez semantyki.

---

### Pytanie 2
Który atrybut formularza HTML określa adres do którego dane są wysyłane?

- A) `method`
- B) `target`
- C) `action`
- D) `href`

**Odpowiedź: C** — `action="handler.php"` to adres docelowy formularza. `method="GET/POST"` to metoda HTTP. `target` określa gdzie otworzyć odpowiedź. `href` to atrybut linku `<a>`.

---

### Pytanie 3
Jaki typ pola `<input>` automatycznie waliduje format adresu email?

- A) `<input type="text" pattern=".*@.*">`
- B) `<input type="email">`
- C) `<input type="mail">`
- D) `<input type="text" validate="email">`

**Odpowiedź: B** — `type="email"` to wbudowany typ HTML5 który waliduje format email przed wysłaniem formularza.

---

### Pytanie 4
Który tag HTML tworzy listę nieuporządkowaną (z punktorami)?

- A) `<ol>`
- B) `<dl>`
- C) `<ul>`
- D) `<list>`

**Odpowiedź: C** — `<ul>` = unordered list (punktorki). `<ol>` = ordered list (numerowanie). `<dl>` = definition list (terminy i definicje).

---

### Pytanie 5
Co oznacza atrybut `alt` w znaczniku `<img>`?

- A) Alternatywny rozmiar obrazu
- B) Alternatywny tekst wyświetlany gdy obraz się nie ładuje (i dla czytników ekranu)
- C) Animacja alternatywna
- D) Adres alternatywnego serwera obrazów

**Odpowiedź: B** — `alt` to tekst alternatywny dla obrazu. Jest ważny dla dostępności (WCAG) i SEO. Puste `alt=""` dla obrazów dekoracyjnych.

---

### Pytanie 6
Które tagi HTML5 są semantyczne? (wybierz najlepszą odpowiedź)

- A) `<div>`, `<span>`, `<p>`
- B) `<header>`, `<nav>`, `<footer>`, `<article>`, `<section>`, `<aside>`
- C) `<b>`, `<i>`, `<u>`, `<s>`
- D) `<table>`, `<tr>`, `<td>`

**Odpowiedź: B** — Tagi semantyczne opisują znaczenie treści. `<header>` = nagłówek, `<nav>` = nawigacja, `<footer>` = stopka, `<article>` = artykuł, `<section>` = sekcja, `<aside>` = sidebar.

---

### Pytanie 7
Jak prawidłowo osadzić zewnętrzny arkusz CSS w dokumencie HTML?

- A) `<style src="styl.css">`
- B) `<css href="styl.css">`
- C) `<link rel="stylesheet" href="styl.css">`
- D) `<import css="styl.css">`

**Odpowiedź: C** — `<link rel="stylesheet" href="...">` w sekcji `<head>`. To standardowy sposób dołączania zewnętrznego CSS.

---

### Pytanie 8
Który atrybut sprawia, że pole formularza jest wymagane?

- A) `mandatory`
- B) `required`
- C) `validate="true"`
- D) `notempty`

**Odpowiedź: B** — `required` to atrybut HTML5 który wymaga wypełnienia pola przed wysłaniem formularza.

---

### Pytanie 9
Co oznacza `<!DOCTYPE html>` na początku dokumentu HTML?

- A) Deklaracja języka dokumentu
- B) Deklaracja wersji HTML (HTML5) — mówi przeglądarce jak interpretować dokument
- C) Komentarz HTML
- D) Import biblioteki HTML5

**Odpowiedź: B** — `<!DOCTYPE html>` to deklaracja typu dokumentu dla HTML5. Zapewnia że przeglądarka renderuje stronę w trybie standardowym (nie quirks mode).

---

### Pytanie 10
Który znacznik tworzy nagłówek najwyższego poziomu?

- A) `<header>`
- B) `<title>`
- C) `<h1>`
- D) `<heading>`

**Odpowiedź: C** — `<h1>` do `<h6>` to nagłówki sekcji (hierarchia: h1 najważniejszy). `<header>` to semantyczny blok strony. `<title>` to tytuł zakładki przeglądarki.

---

## CZĘŚĆ 2: CSS (12 pytań)

### Pytanie 11
Który selektor CSS ma najwyższą specyficzność?

- A) `p { color: red; }`
- B) `.klasa { color: red; }`
- C) `#id { color: red; }`
- D) `* { color: red; }`

**Odpowiedź: C** — Specyficzność: `#id` (100) > `.klasa` (10) > `element` (1) > `*` (0). Inline style (1000) > `!important`.

---

### Pytanie 12
Co robi właściwość CSS `float: left`?

- A) Tekst jest wyrównany do lewej
- B) Element jest usuwany z normalnego przepływu i przesuwany do lewej strony kontenera
- C) Element jest pozycjonowany absolutnie po lewej stronie
- D) Element jest niewidoczny

**Odpowiedź: B** — `float: left` wyrywa element z normalnego przepływu dokumentu i przesuwa go do lewej strony. Inne elementy opływają go z prawej. Wzorzec z egzaminu INF.03: `aside, main, section { float: left; }`.

---

### Pytanie 13
Jak wyczyścić float (clearfix)?

- A) `overflow: hidden`
- B) `clear: both`
- C) `float: none`
- D) Odpowiedzi A i B są poprawne

**Odpowiedź: D** — `clear: both` na elemencie po elementach z float. `overflow: hidden` na kontenerze (tworzy BFC). Oba są poprawnymi sposobami czyszczenia float.

---

### Pytanie 14
Co to jest box model CSS?

- A) Model opisujący kolory elementów
- B) Model opisujący przestrzeń elementu: content + padding + border + margin
- C) Model opisujący pozycjonowanie elementów
- D) Model opisujący fonty

**Odpowiedź: B** — Box model: `content` (treść) → `padding` (wewnętrzny odstęp) → `border` (obramowanie) → `margin` (zewnętrzny odstęp).

---

### Pytanie 15
Która właściwość CSS sprawia że elementy Flex są ułożone w kolumnie (pionowo)?

- A) `flex-direction: vertical`
- B) `flex-direction: column`
- C) `flex-wrap: column`
- D) `align-items: column`

**Odpowiedź: B** — `flex-direction: column` układa elementy pionowo. `flex-direction: row` (domyślne) = poziomo.

---

### Pytanie 16
Co zwraca selektor `div > p`?

- A) Wszystkie `<p>` wewnątrz `<div>` (na dowolnym poziomie zagłębienia)
- B) Tylko bezpośrednie dzieci `<p>` elementu `<div>`
- C) `<div>` który jest dzieckiem `<p>`
- D) `<div>` i `<p>` na tym samym poziomie

**Odpowiedź: B** — `>` to selektor bezpośredniego dziecka. `div p` (spacja) = wszystkie potomki. `div > p` = tylko bezpośrednie dzieci.

---

### Pytanie 17
Jak ustawić media query dla urządzeń mobilnych (ekran do 768px)?

- A) `@screen (max-width: 768px) { ... }`
- B) `@responsive mobile { ... }`
- C) `@media (max-width: 768px) { ... }`
- D) `@media screen[768px] { ... }`

**Odpowiedź: C** — Poprawna składnia media query CSS. `max-width: 768px` = reguła aktywna gdy szerokość ekranu ≤ 768px.

---

### Pytanie 18
Który pseudoselektor CSS zmienia styl gdy mysz jest nad elementem?

- A) `:focus`
- B) `:active`
- C) `:hover`
- D) `:visited`

**Odpowiedź: C** — `:hover` = mysz nad elementem. `:focus` = element ma fokus (np. kliknięty tab). `:active` = element jest klikany. `:visited` = link odwiedzony.

---

### Pytanie 19
Co robi `position: absolute`?

- A) Element jest nieruchomy podczas scrollowania
- B) Element jest pozycjonowany względem najbliższego rodzica z `position` innym niż `static`
- C) Element jest pozycjonowany względem okna przeglądarki
- D) Element wraca do swojej naturalnej pozycji

**Odpowiedź: B** — `absolute` = względem rodzica z position != static. `fixed` = względem viewport (okna). `sticky` = przykleja się podczas scrollowania. `relative` = względem własnej normalnej pozycji.

---

### Pytanie 20
Które jednostki CSS są relatywne (zależą od kontekstu)?

- A) `px`, `cm`, `mm`
- B) `em`, `rem`, `%`, `vw`, `vh`
- C) `pt`, `pc`, `in`
- D) Wszystkie powyższe

**Odpowiedź: B** — `em` = względem font-size rodzica. `rem` = względem font-size elementu root (html). `%` = względem rodzica. `vw/vh` = względem viewport. `px` = piksele ekranu (stałe).

---

### Pytanie 21
Co to jest `z-index`?

- A) Indeks elementu w DOM
- B) Kolejność nakładania elementów (który element jest "wyżej" / przykrywa inne)
- C) Numer wiersza w Grid CSS
- D) Poziom zagłębienia w Flexbox

**Odpowiedź: B** — `z-index` kontroluje kolejność warstw (oś Z). Wyższy `z-index` = element jest "wyżej" (przykrywa inne). Działa tylko na elementach z `position` innym niż `static`.

---

### Pytanie 22
Który układ CSS jest opisany w egzaminach INF.03 jako "float layout"?

- A) `display: flex` na kontenerze
- B) `display: grid` na kontenerze
- C) `float: left` na aside, main, section + `clear: both` po nich
- D) `position: absolute` na każdej sekcji

**Odpowiedź: C** — Wzorzec egzaminacyjny: `aside, main, section { float: left; }`. CSS float to stary standard używany w egzaminach INF.03 2024-2026.

---

## CZĘŚĆ 3: PHP (13 pytań)

### Pytanie 23
Jak połączyć się z bazą MySQL w PHP (wzorzec egzaminacyjny)?

- A) `$conn = mysql_connect("localhost", "root", "");`
- B) `$conn = new mysqli("localhost", "root", "", "nazwa_bazy");`
- C) `$conn = PDO::connect("mysql:host=localhost");`
- D) `$conn = db_connect("localhost", "root", "", "nazwa_bazy");`

**Odpowiedź: B** — `new mysqli()` to obiektowy styl MySQLi. To wzorzec z egzaminów INF.03 2024-2026. `mysql_connect()` jest przestarzałe (usunięte w PHP 7).

---

### Pytanie 24
Jak pobrać wartość z parametru URL `?id=7` w PHP?

- A) `$id = $_URL['id'];`
- B) `$id = GET('id');`
- C) `$id = $_GET['id'];`
- D) `$id = $_REQUEST['id'];`

**Odpowiedź: C** — `$_GET['id']` pobiera parametr z URL. Egzamin wymaga też zabezpieczenia: `$id = isset($_GET['id']) ? intval($_GET['id']) : 1;`

---

### Pytanie 25
Co robi `intval($_GET['id'])`?

- A) Sprawdza czy id jest całkowite
- B) Konwertuje wartość na liczbę całkowitą (int) — zapobiega SQL Injection
- C) Waliduje czy id istnieje w bazie
- D) Zwraca wartość jako string

**Odpowiedź: B** — `intval()` konwertuje na `int`. Jeśli ktoś poda `?id=1; DROP TABLE`, `intval()` zwróci `1`. To podstawowe zabezpieczenie przed SQL Injection przy parametrach numerycznych.

---

### Pytanie 26
Jak pobrać jeden wiersz z wyniku zapytania SQL w PHP (MySQLi OOP)?

- A) `$wiersz = $result->fetch_one();`
- B) `$wiersz = $result->fetch_assoc();`
- C) `$wiersz = $result->get_row();`
- D) `$wiersz = mysql_fetch_array($result);`

**Odpowiedź: B** — `fetch_assoc()` zwraca wiersz jako tablicę asocjacyjną (klucze = nazwy kolumn). `mysql_fetch_array()` to stara, przestarzała funkcja.

---

### Pytanie 27
Jak wyświetlić wszystkie wiersze z zapytania w PHP?

- A) `echo $result->fetch_all();`
- B) `for ($result) { echo $wiersz['pole']; }`
- C) `while ($wiersz = $result->fetch_assoc()) { echo $wiersz['pole']; }`
- D) `foreach ($result as $wiersz) { echo $wiersz['pole']; }`

**Odpowiedź: C** — Pętla `while` z `fetch_assoc()` iteruje po wierszach wyniku. Gdy nie ma więcej wierszy, `fetch_assoc()` zwraca `null` i pętla się kończy.

---

### Pytanie 28
Co robi `htmlspecialchars($tekst)` w PHP?

- A) Usuwa tagi HTML z tekstu
- B) Konwertuje znaki specjalne HTML na encje (np. `<` → `&lt;`) — zapobiega XSS
- C) Koduje tekst do Base64
- D) Szyfruje tekst

**Odpowiedź: B** — `htmlspecialchars()` konwertuje `<`, `>`, `"`, `'`, `&` na bezpieczne encje HTML. Chroni przed atakami Cross-Site Scripting (XSS) gdy wyświetlamy dane użytkownika.

---

### Pytanie 29
Jak uruchomić sesję PHP?

- A) `session_start()` — musi być wywołana PRZED jakimkolwiek outputem HTML
- B) `start_session()` gdziekolwiek w pliku
- C) `session_init()` na początku pliku
- D) Sesje uruchamiają się automatycznie w PHP

**Odpowiedź: A** — `session_start()` MUSI być wywołana przed jakimkolwiek outputem (przed `echo`, przed `<!DOCTYPE html>`). Wysyła nagłówek HTTP `Set-Cookie`.

---

### Pytanie 30
Co to jest `$_POST`?

- A) Tablica globalna przechowująca zmienne z URL (query string)
- B) Tablica globalna przechowująca dane wysłane metodą POST przez formularz
- C) Tablica globalna przechowująca dane sesji
- D) Obiekt odpowiedzi HTTP

**Odpowiedź: B** — `$_POST` zawiera dane z formularza z `method="POST"`. `$_GET` = dane z URL (`?klucz=wartość`). `$_SESSION` = dane sesji. `$_FILES` = uploadowane pliki.

---

### Pytanie 31
Jak sprawdzić czy formularz został wysłany metodą POST?

- A) `if ($_POST['submit']) { ... }`
- B) `if (isset($_POST)) { ... }`
- C) `if ($_SERVER['REQUEST_METHOD'] === 'POST') { ... }`
- D) `if (POST) { ... }`

**Odpowiedź: C** — `$_SERVER['REQUEST_METHOD']` sprawdza metodę HTTP. Opcja B jest niepoprawna bo `$_POST` zawsze istnieje (jako pusta tablica gdy GET). Opcja A zadziała tylko jeśli przycisk submit ma name="submit".

---

### Pytanie 32
Co powinno być w atrybucie `enctype` formularza wysyłającego pliki?

- A) `enctype="text/plain"`
- B) `enctype="application/json"`
- C) `enctype="multipart/form-data"`
- D) Nie trzeba ustawiać enctype

**Odpowiedź: C** — `enctype="multipart/form-data"` jest wymagane dla formularzy wysyłających pliki (`<input type="file">`). Bez tego `$_FILES` będzie puste.

---

### Pytanie 33
Jak zamknąć połączenie z bazą danych w PHP MySQLi OOP?

- A) `$conn->disconnect();`
- B) `mysqli_close($conn);`
- C) `$conn->close();`
- D) `unset($conn);`

**Odpowiedź: C** — `$conn->close()` to metoda obiektowa MySQLi. Dobre praktyki: zawsze zamykaj połączenie po użyciu.

---

### Pytanie 34
Który kod PHP jest podatny na SQL Injection?

- A) `$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?"); $stmt->bind_param("i", $id);`
- B) `$id = intval($_GET['id']); $sql = "SELECT * FROM users WHERE id = $id";`
- C) `$id = $_GET['id']; $sql = "SELECT * FROM users WHERE id = '$id'";`
- D) Opcje A i B są bezpieczne

**Odpowiedź: C** — Bezpośrednie wstawienie `$_GET['id']` bez sanityzacji to podatność SQL Injection. Opcja A (prepared statements) = najbezpieczniejsza. Opcja B (intval) = bezpieczna dla liczb. Opcja C = niebezpieczna.

---

### Pytanie 35
Jak PHP zwraca JSON dla JavaScript (AJAX)?

- A) `echo json($dane);`
- B) `header('Content-Type: application/json'); echo json_encode($dane);`
- C) `return JSON.stringify($dane);`
- D) `print_r(json_encode($dane));`

**Odpowiedź: B** — `json_encode()` konwertuje tablicę PHP na JSON string. `header()` ustawia prawidłowy Content-Type. To wzorzec PHP API dla AJAX.

---

## PODSUMOWANIE WYNIKÓW

| Wynik | Ocena |
|-------|-------|
| 32-35 | Celujący — gotowy na egzamin! |
| 28-31 | Bardzo dobry — powtórz bezpieczeństwo PHP |
| 21-27 | Dobry — powtórz wzorce MySQL i CSS float |
| 14-20 | Dostateczny — wróć do 01_PHP_BASICS.md i 01_CSS_SELEKTORY.md |
| 0-13  | Niedostateczny — zacznij od podstaw HTML/CSS/PHP |

---

## KLUCZOWE WZORCE DO ZAPAMIĘTANIA

### PHP + MySQL (egzamin!)
```php
<?php
$polaczenie = new mysqli("localhost", "root", "", "nazwa_bazy");
$id = isset($_GET['id']) ? intval($_GET['id']) : 1;
$zapytanie = "SELECT t1.pole, t2.pole FROM t1 JOIN t2 ON t2.id = t1.id_t2 WHERE t1.id = $id";
$rezultat = $polaczenie->query($zapytanie);
$wiersz = $rezultat->fetch_assoc();
echo $wiersz['pole'];
$polaczenie->close();
?>
```

### CSS Float Layout (egzamin!)
```css
aside, main, section { float: left; }
.clear-both { clear: both; }
```

### SQL wzorzec (egzamin!)
```sql
SELECT t1.pole, t2.pole
FROM tabela1 t1
JOIN tabela2 t2 ON t2.id = t1.id_t2
WHERE t1.id = 7;
```

---

**Powodzenia! Wróć do: [WZORZEC_EGZAMINACYJNY.md](../WZORZEC_EGZAMINACYJNY.md)**
