# ĆWICZENIA: HTML i CSS (INF.03.3)

> Zbiór 20 praktycznych zadań z rozwiązaniami przygotowujących do egzaminu INF.03.
> Zadania 1–10 dotyczą HTML, zadania 11–20 dotyczą CSS.

---

## Wzorzec strony egzaminacyjnej

Poniższy szkielet jest punktem wyjścia dla większości zadań egzaminacyjnych.
Zapamiętaj go na pamięć — pojawia się w każdym arkuszu z makietą.

```html
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Strona</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
    <header>...</header>
    <nav>...</nav>
    <aside style="float:left; width:25%">...</aside>
    <main style="float:left; width:50%">...</main>
    <section style="float:left; width:25%">...</section>
    <div class="clear-both"></div>
    <footer>...</footer>
</body>
</html>
```

**Kluczowe zasady wzorca:**
- `float:left` na `aside`, `main`, `section` — układ 3-kolumnowy 25/50/25
- `<div class="clear-both">` lub `<div style="clear:both">` po kolumnach — obowiązkowe!
- `<link rel="stylesheet" href="styl.css">` — plik CSS zawsze nazywa się `styl.css`
- `lang="pl"` — język polski, wymagany przez egzaminator
- `charset="UTF-8"` — polskie znaki działają poprawnie

---

## ZADANIA HTML (1–10)

---

### Zadanie 1: Semantyczna struktura strony z nawigacją

**Treść:** Stwórz pełną semantyczną strukturę strony internetowej zawierającą: nagłówek z tytułem strony, nawigację z linkami do 3 podstron (Strona główna, O nas, Kontakt), główną zawartość z akapitem powitalnym oraz stopkę z informacją o prawach autorskich. Użyj wyłącznie semantycznych znaczników HTML5.

**Wskazówka:** Użyj tagów `<header>`, `<nav>`, `<main>`, `<footer>`. Linki nawigacyjne umieść w liście `<ul>` wewnątrz `<nav>`. Semantyczne znaczniki pomagają robotom wyszukiwarek i czytnikom ekranowym.

**Rozwiązanie HTML:**

```html
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moja strona — Strona główna</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>

    <header>
        <h1>Moja strona internetowa</h1>
        <p>Witaj na mojej stronie!</p>
    </header>

    <nav>
        <ul>
            <li><a href="index.html">Strona główna</a></li>
            <li><a href="o-nas.html">O nas</a></li>
            <li><a href="kontakt.html">Kontakt</a></li>
        </ul>
    </nav>

    <main>
        <h2>Witaj na stronie głównej</h2>
        <p>
            Tutaj znajdziesz informacje o naszej firmie. Zapraszamy do zapoznania
            się z naszą ofertą i skontaktowania się z nami.
        </p>
    </main>

    <footer>
        <p>&copy; 2025 Moja strona internetowa. Wszelkie prawa zastrzeżone.</p>
    </footer>

</body>
</html>
```

**Rozwiązanie CSS:**

```css
/* Reset i podstawy */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    color: #333;
}

header {
    background-color: #2c3e50;
    color: white;
    padding: 20px;
    text-align: center;
}

nav {
    background-color: #34495e;
    padding: 10px 20px;
}

nav ul {
    list-style: none;
    display: flex;
    gap: 20px;
}

nav a {
    color: white;
    text-decoration: none;
}

nav a:hover {
    text-decoration: underline;
}

main {
    padding: 20px;
    min-height: 300px;
}

footer {
    background-color: #2c3e50;
    color: white;
    text-align: center;
    padding: 15px;
}
```

**Co sprawdza:** Znajomość semantycznych tagów HTML5, prawidłową strukturę dokumentu, dostępność (accessibility).

---

### Zadanie 2: Formularz kontaktowy z walidacją HTML5

**Treść:** Stwórz formularz kontaktowy zawierający: pole imię (wymagane, minimum 3 znaki), pole adres e-mail (typ email, wymagane), pole wiadomość jako textarea (wymagane, minimum 10 znaków), oraz przycisk "Wyślij wiadomość". Formularz powinien wysyłać dane metodą POST do pliku `kontakt.php`.

**Wskazówka:** Atrybuty `required`, `minlength`, `type="email"` zapewniają walidację po stronie przeglądarki. Każde pole powinno mieć powiązany `<label>` z atrybutem `for` odpowiadającym `id` pola.

**Rozwiązanie HTML:**

```html
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Formularz kontaktowy</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>

<main>
    <h1>Skontaktuj się z nami</h1>

    <form action="kontakt.php" method="POST">

        <div class="pole-formularza">
            <label for="imie">Imię i nazwisko:</label>
            <input
                type="text"
                id="imie"
                name="imie"
                required
                minlength="3"
                maxlength="100"
                placeholder="Wpisz swoje imię i nazwisko"
            >
        </div>

        <div class="pole-formularza">
            <label for="email">Adres e-mail:</label>
            <input
                type="email"
                id="email"
                name="email"
                required
                placeholder="przyklad@domena.pl"
            >
        </div>

        <div class="pole-formularza">
            <label for="wiadomosc">Wiadomość:</label>
            <textarea
                id="wiadomosc"
                name="wiadomosc"
                required
                minlength="10"
                rows="6"
                placeholder="Wpisz swoją wiadomość..."
            ></textarea>
        </div>

        <div class="pole-formularza">
            <button type="submit">Wyślij wiadomość</button>
        </div>

    </form>
</main>

</body>
</html>
```

**Rozwiązanie CSS:**

```css
.pole-formularza {
    margin-bottom: 15px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #333;
}

input[type="text"],
input[type="email"],
textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    font-family: inherit;
}

textarea {
    resize: vertical;
}

button[type="submit"] {
    background-color: #3498db;
    color: white;
    padding: 12px 30px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
}

button[type="submit"]:hover {
    background-color: #2980b9;
}
```

**Co sprawdza:** Budowę formularzy HTML5, atrybuty walidacji, powiązanie label z polem przez `for`/`id`, metodę POST.

---

### Zadanie 3: Tabela z wynikami uczniów (colspan i rowspan)

**Treść:** Stwórz tabelę HTML prezentującą wyniki uczniów. Tabela powinna zawierać nagłówki: Imię, Przedmiot, Ocena, Data. Dodaj wiersz z oceną obejmującą dwa wiersze (rowspan=2 dla imienia ucznia) oraz komórkę nagłówkową obejmującą dwie kolumny (colspan=2).

**Wskazówka:** `<thead>` zawiera wiersz nagłówkowy z `<th>`. `<tbody>` zawiera dane. `rowspan="2"` powoduje, że komórka zajmuje 2 wiersze w pionie. `colspan="2"` rozciąga komórkę przez 2 kolumny.

**Rozwiązanie HTML:**

```html
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Wyniki uczniów</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>

<main>
    <h1>Wyniki uczniów — I semestr 2025</h1>

    <table>
        <thead>
            <tr>
                <th>Imię i nazwisko</th>
                <th>Przedmiot</th>
                <th>Ocena</th>
                <th>Data wystawienia</th>
            </tr>
        </thead>
        <tbody>
            <!-- Jan Kowalski — rowspan: jedno pole imienia na 2 wiersze -->
            <tr>
                <td rowspan="2">Jan Kowalski</td>
                <td>Matematyka</td>
                <td>5</td>
                <td>2025-03-15</td>
            </tr>
            <tr>
                <!-- brak komórki z imieniem — zajęta przez rowspan -->
                <td>Informatyka</td>
                <td>6</td>
                <td>2025-03-16</td>
            </tr>

            <!-- Wiersz z colspan -->
            <tr>
                <td colspan="2">Anna Nowak — Fizyka (egzamin poprawkowy)</td>
                <td>4</td>
                <td>2025-04-01</td>
            </tr>

            <tr>
                <td>Piotr Wiśniewski</td>
                <td>Język polski</td>
                <td>3</td>
                <td>2025-03-20</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">Łączna liczba ocen: 4</td>
            </tr>
        </tfoot>
    </table>
</main>

</body>
</html>
```

**Rozwiązanie CSS:**

```css
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    border: 1px solid #ccc;
    padding: 10px 14px;
    text-align: left;
}

thead th {
    background-color: #2c3e50;
    color: white;
    font-weight: bold;
}

tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

tbody tr:hover {
    background-color: #d6eaf8;
}

tfoot td {
    background-color: #ecf0f1;
    font-style: italic;
}
```

**Co sprawdza:** Budowę tabeli HTML, użycie `colspan`/`rowspan`, `<thead>/<tbody>/<tfoot>`, stylowanie tabel.

---

### Zadanie 4: Lista nawigacyjna pozioma

**Treść:** Stwórz nawigację strony przy użyciu listy nieuporządkowanej `<ul>` z elementami `<li>` i linkami `<a>`. Za pomocą CSS spraw, żeby lista wyświetlała się poziomo (w jednej linii), a nie pionowo. Aktywny link powinien mieć inny kolor tła.

**Wskazówka:** Domyślnie `<li>` jest elementem blokowym. Żeby wyświetlić je poziomo, użyj `display: inline-block` lub `display: flex` na `<ul>`. Usuń wypunktowanie za pomocą `list-style: none`.

**Rozwiązanie HTML:**

```html
<nav>
    <ul class="nav-lista">
        <li><a href="index.html" class="aktywny">Strona główna</a></li>
        <li><a href="oferta.html">Oferta</a></li>
        <li><a href="galeria.html">Galeria</a></li>
        <li><a href="blog.html">Blog</a></li>
        <li><a href="kontakt.html">Kontakt</a></li>
    </ul>
</nav>
```

**Rozwiązanie CSS:**

```css
/* Metoda 1: flexbox (nowoczesna) */
.nav-lista {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    background-color: #2c3e50;
}

.nav-lista li a {
    display: block;
    padding: 14px 20px;
    color: white;
    text-decoration: none;
    transition: background-color 0.2s;
}

.nav-lista li a:hover {
    background-color: #34495e;
}

.nav-lista li a.aktywny {
    background-color: #e74c3c;
    font-weight: bold;
}

/* Metoda 2: inline-block (starsza, sprawdza egzaminator) */
/*
.nav-lista li {
    display: inline-block;
}
*/
```

**Co sprawdza:** Transformację listy pionowej na poziomą, flexbox lub inline-block, stylowanie linków nawigacyjnych.

---

### Zadanie 5: Obraz responsywny z atrybutem srcset

**Treść:** Wstaw na stronę obraz, który ładuje różne wersje w zależności od szerokości ekranu: dla urządzeń mobilnych (max 480px) — zdjęcie-mobile.jpg, dla tabletów (max 768px) — zdjecie-tablet.jpg, dla desktopów (min 1200px) — zdjecie-desktop.jpg. Dodaj tekst alternatywny i podpis pod zdjęciem.

**Wskazówka:** Atrybut `srcset` zawiera listę plików z szerokościami. Atrybut `sizes` informuje przeglądarkę o rozmiarze obrazu w zależności od szerokości widocznego obszaru. Element `<figure>` z `<figcaption>` to semantyczny sposób na obraz z podpisem.

**Rozwiązanie HTML:**

```html
<figure>
    <img
        src="zdjecie-desktop.jpg"
        srcset="
            zdjecie-mobile.jpg  480w,
            zdjecie-tablet.jpg  768w,
            zdjecie-desktop.jpg 1200w
        "
        sizes="
            (max-width: 480px) 480px,
            (max-width: 768px) 768px,
            1200px
        "
        alt="Piękny widok na miasto o zachodzie słońca"
        width="800"
        height="450"
        loading="lazy"
    >
    <figcaption>Widok na miasto — fot. Jan Kowalski, 2025</figcaption>
</figure>
```

**Rozwiązanie CSS:**

```css
figure {
    margin: 20px 0;
    text-align: center;
}

figure img {
    max-width: 100%;
    height: auto;
    display: block;
    margin: 0 auto;
    border-radius: 6px;
}

figcaption {
    font-size: 14px;
    color: #666;
    margin-top: 8px;
    font-style: italic;
}
```

**Co sprawdza:** Responsywność obrazów, atrybut `srcset`, `sizes`, `alt`, `loading="lazy"`, semantyczny element `<figure>`.

---

### Zadanie 6: Formularz logowania z opcją "Zapamiętaj mnie"

**Treść:** Stwórz formularz logowania z polami: adres e-mail (type=email, required), hasło (type=password, required, minlength=8), checkbox "Zapamiętaj mnie" oraz link "Zapomniałem hasła" obok przycisku logowania. Formularz wysyła dane metodą POST do `login.php`.

**Wskazówka:** Pole `type="password"` automatycznie maskuje wpisywane znaki. Checkbox `<input type="checkbox">` nie wymaga `required`. Link "Zapomniałem hasła" to zwykły `<a href>` umieszczony obok przycisku.

**Rozwiązanie HTML:**

```html
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>

<div class="kontener-logowania">
    <h1>Zaloguj się</h1>

    <form action="login.php" method="POST" class="formularz-logowania">

        <div class="pole-formularza">
            <label for="email">Adres e-mail:</label>
            <input
                type="email"
                id="email"
                name="email"
                required
                autocomplete="email"
                placeholder="twoj@email.pl"
            >
        </div>

        <div class="pole-formularza">
            <label for="haslo">Hasło:</label>
            <input
                type="password"
                id="haslo"
                name="haslo"
                required
                minlength="8"
                autocomplete="current-password"
                placeholder="Minimum 8 znaków"
            >
        </div>

        <div class="pole-checkbox">
            <input type="checkbox" id="zapamietaj" name="zapamietaj" value="1">
            <label for="zapamietaj">Zapamiętaj mnie na tym urządzeniu</label>
        </div>

        <div class="akcje-formularza">
            <button type="submit">Zaloguj się</button>
            <a href="resetuj-haslo.php" class="link-zapomnielem">Zapomniałem hasła</a>
        </div>

    </form>
</div>

</body>
</html>
```

**Rozwiązanie CSS:**

```css
.kontener-logowania {
    max-width: 400px;
    margin: 50px auto;
    padding: 30px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.pole-formularza {
    margin-bottom: 20px;
}

.pole-formularza label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.pole-formularza input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

.pole-checkbox {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 20px;
}

.pole-checkbox input[type="checkbox"] {
    width: 18px;
    height: 18px;
    cursor: pointer;
}

.akcje-formularza {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

button[type="submit"] {
    background-color: #27ae60;
    color: white;
    padding: 12px 25px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

.link-zapomnielem {
    color: #3498db;
    font-size: 14px;
}
```

**Co sprawdza:** Typy pól formularza (password, checkbox), atrybuty bezpieczeństwa, układ formularza, linkowanie.

---

### Zadanie 7: Lista nieuporządkowana z ikonkami

**Treść:** Stwórz listę nieuporządkowaną z 5 elementami, gdzie zamiast standardowych kropek wyświetlone są niestandardowe ikonki — strzałki (►) dodane za pomocą pseudoelementu `::before` z właściwością `content`. Elementy listy powinny mieć odstępy i ładny wygląd.

**Wskazówka:** Ustaw `list-style: none` żeby usunąć domyślne punktory. Następnie dodaj `li::before { content: "►"; }` by wstawić własny symbol. Można też użyć `list-style-image: url(ikona.png)` dla obrazkowych ikonek.

**Rozwiązanie HTML:**

```html
<section>
    <h2>Nasze usługi</h2>
    <ul class="lista-ikonek">
        <li>Projektowanie stron internetowych</li>
        <li>Tworzenie aplikacji mobilnych</li>
        <li>Optymalizacja SEO</li>
        <li>Marketing w mediach społecznościowych</li>
        <li>Hosting i utrzymanie serwisów</li>
    </ul>
</section>
```

**Rozwiązanie CSS:**

```css
.lista-ikonek {
    list-style: none;
    padding: 0;
    margin: 0;
}

.lista-ikonek li {
    padding: 10px 0 10px 30px;
    position: relative;
    border-bottom: 1px solid #eee;
    font-size: 16px;
}

/* Ikonka za pomocą ::before */
.lista-ikonek li::before {
    content: "►";
    color: #e74c3c;
    font-size: 12px;
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
}

.lista-ikonek li:hover {
    color: #e74c3c;
    padding-left: 35px;
    transition: padding-left 0.2s;
}

/* Alternatywnie: list-style-image */
/*
.lista-ikonek {
    list-style-image: url('strzalka.png');
}
*/
```

**Co sprawdza:** Pseudoelementy `::before`/`::after`, właściwość `content`, pozycjonowanie absolutne, `list-style`.

---

### Zadanie 8: Osadzenie wideo HTML5

**Treść:** Osadź na stronie wideo w formacie MP4 z następującymi wymaganiami: widoczne przyciski odtwarzania (controls), brak automatycznego odtwarzania, miniaturka (poster) wyświetlana przed odtworzeniem, tekst zastępczy dla starszych przeglądarek. Dodaj możliwość pobierania pliku.

**Wskazówka:** Element `<video>` przyjmuje atrybuty: `controls`, `autoplay`, `muted`, `poster`, `loop`. Tekst między tagami `<video>` a `</video>` wyświetla się w przeglądarkach bez wsparcia HTML5. Atrybut `preload="metadata"` ładuje tylko metadane.

**Rozwiązanie HTML:**

```html
<section class="sekcja-wideo">
    <h2>Prezentacja produktu</h2>

    <video
        width="800"
        height="450"
        controls
        poster="miniaturka-wideo.jpg"
        preload="metadata"
    >
        <!-- Główny format MP4 -->
        <source src="film.mp4" type="video/mp4">
        <!-- Alternatywny format WebM -->
        <source src="film.webm" type="video/webm">
        <!-- Tekst dla starszych przeglądarek -->
        <p>
            Twoja przeglądarka nie obsługuje odtwarzania wideo HTML5.
            <a href="film.mp4">Pobierz film (MP4)</a>
        </p>
    </video>

    <p class="opis-wideo">
        Obejrzyj prezentację naszego najnowszego produktu.
        <a href="film.mp4" download="prezentacja-produktu.mp4">Pobierz wideo</a>
    </p>
</section>
```

**Rozwiązanie CSS:**

```css
.sekcja-wideo {
    padding: 20px;
    text-align: center;
}

.sekcja-wideo video {
    max-width: 100%;
    height: auto;
    display: block;
    margin: 0 auto;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.opis-wideo {
    margin-top: 10px;
    color: #555;
    font-size: 14px;
}

.opis-wideo a {
    color: #3498db;
    font-weight: bold;
}
```

**Co sprawdza:** Atrybuty elementu `<video>`, wielokrotne źródła `<source>`, fallback content, responsywność mediów.

---

### Zadanie 9: Dostępna nawigacja z atrybutami ARIA

**Treść:** Stwórz nawigację strony z pełną obsługą dostępności (accessibility) przy użyciu atrybutów ARIA. Nawigacja powinna zawierać: `role="navigation"`, `aria-label` opisujący cel nawigacji, `aria-current="page"` dla aktualnej strony, oraz strukturę `<ul>/<li>/<a>`.

**Wskazówka:** ARIA (Accessible Rich Internet Applications) to zestaw atrybutów HTML poprawiających dostępność dla czytników ekranowych. `aria-current="page"` informuje czytnik, że to jest bieżąca strona. `aria-label` nadaje etykietę elementowi bez widocznego tekstu.

**Rozwiązanie HTML:**

```html
<!-- Nawigacja główna -->
<nav role="navigation" aria-label="Nawigacja główna">
    <ul>
        <li>
            <a href="index.html" aria-current="page">Strona główna</a>
        </li>
        <li>
            <a href="o-nas.html">O nas</a>
        </li>
        <li>
            <a href="oferta.html">Oferta</a>
        </li>
        <li>
            <a href="kontakt.html">Kontakt</a>
        </li>
    </ul>
</nav>

<!-- Nawigacja pomocnicza (breadcrumb) -->
<nav aria-label="Ścieżka nawigacyjna (breadcrumb)">
    <ol>
        <li><a href="/">Strona główna</a></li>
        <li><a href="/oferta/">Oferta</a></li>
        <li aria-current="page">Szczegóły produktu</li>
    </ol>
</nav>

<!-- Przycisk menu mobilnego z ARIA -->
<button
    aria-expanded="false"
    aria-controls="menu-mobilne"
    aria-label="Otwórz menu nawigacji"
    class="btn-menu"
>
    ☰
</button>

<ul id="menu-mobilne" aria-hidden="true">
    <li><a href="index.html">Strona główna</a></li>
    <li><a href="kontakt.html">Kontakt</a></li>
</ul>
```

**Rozwiązanie CSS:**

```css
nav[aria-label="Nawigacja główna"] ul {
    list-style: none;
    display: flex;
    gap: 0;
    margin: 0;
    padding: 0;
    background-color: #2c3e50;
}

nav[aria-label="Nawigacja główna"] a {
    display: block;
    padding: 15px 20px;
    color: white;
    text-decoration: none;
}

/* Styl dla aktywnej strony */
nav[aria-label="Nawigacja główna"] a[aria-current="page"] {
    background-color: #e74c3c;
    font-weight: bold;
}

nav[aria-label="Nawigacja główna"] a:hover:not([aria-current="page"]) {
    background-color: #34495e;
}

/* Fokus widoczny dla klawiatury */
a:focus {
    outline: 3px solid #f39c12;
    outline-offset: 2px;
}
```

**Co sprawdza:** Atrybuty ARIA, dostępność dla czytników ekranowych, `aria-current`, `aria-label`, nawigacja klawiaturą.

---

### Zadanie 10: Meta tagi SEO i Open Graph

**Treść:** Dodaj do dokumentu HTML kompletny zestaw meta tagów potrzebnych do dobrego pozycjonowania SEO i poprawnego wyświetlania w mediach społecznościowych. Powinny znaleźć się: opis strony, słowa kluczowe, viewport, og:title, og:description, og:image, og:url oraz rel="canonical".

**Wskazówka:** Meta tagi umieszcza się w sekcji `<head>`. Tagi Open Graph (`og:`) kontrolują wygląd linku w social mediach (Facebook, Twitter). `viewport` jest kluczowy dla wyświetlania na urządzeniach mobilnych. `rel="canonical"` zapobiega duplikatom treści.

**Rozwiązanie HTML:**

```html
<!DOCTYPE html>
<html lang="pl">
<head>
    <!-- Kodowanie znaków — ZAWSZE pierwsze! -->
    <meta charset="UTF-8">

    <!-- Viewport — kluczowy dla RWD i mobilnych -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tytuł strony -->
    <title>Sklep z elektroniką — Najlepsze ceny | MojSklep.pl</title>

    <!-- Meta SEO -->
    <meta name="description" content="Sklep internetowy z elektroniką. Smartfony, laptopy, tablety w najlepszych cenach. Darmowa dostawa od 200 zł.">
    <meta name="keywords" content="sklep elektroniczny, smartfony, laptopy, tablety, elektronika">
    <meta name="author" content="Jan Kowalski">
    <meta name="robots" content="index, follow">

    <!-- Canonical — zapobiega duplikatom -->
    <link rel="canonical" href="https://mojsklep.pl/elektronika/">

    <!-- Open Graph — wygląd w social mediach -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="Sklep z elektroniką — MojSklep.pl">
    <meta property="og:description" content="Najlepsze ceny na smartfony, laptopy i tablety. Darmowa dostawa!">
    <meta property="og:image" content="https://mojsklep.pl/img/og-elektronika.jpg">
    <meta property="og:url" content="https://mojsklep.pl/elektronika/">
    <meta property="og:locale" content="pl_PL">
    <meta property="og:site_name" content="MojSklep.pl">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Sklep z elektroniką — MojSklep.pl">
    <meta name="twitter:image" content="https://mojsklep.pl/img/og-elektronika.jpg">

    <!-- Favicon -->
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <!-- Arkusz stylów -->
    <link rel="stylesheet" href="styl.css">
</head>
<body>
    <!-- Treść strony -->
</body>
</html>
```

**Rozwiązanie CSS:**

```css
/* Meta tagi nie wpływają na wygląd — brak CSS dla tego zadania */
/* Pamiętaj o <link rel="stylesheet" href="styl.css"> w <head> */
```

**Co sprawdza:** Znajomość meta tagów SEO, Open Graph, viewport, kolejność i struktura `<head>`.

---

## ZADANIA CSS (11–20)

---

### Zadanie 11: Layout float 25/50/25 — wzorzec egzaminacyjny

**Treść:** Zaimplementuj dokładnie taki układ 3-kolumnowy jaki pojawia się na egzaminie INF.03: lewa kolumna (aside) 25% szerokości, środkowa kolumna (main) 50%, prawa kolumna (section) 25%. Wszystkie kolumny wyrównane do lewej z `float:left`. Po kolumnach wymagany clearfix.

**Wskazówka:** To jest najważniejsze zadanie CSS na egzaminie. Trzy elementy mają `float:left` i szerokości sumujące się do 100%. Po nich MUSI być `<div class="clear-both">` z `clear:both` żeby footer nie wskoczył pod kolumny.

**Rozwiązanie HTML:**

```html
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Layout 3-kolumnowy</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>

    <header>
        <h1>Nagłówek strony</h1>
    </header>

    <nav>
        <a href="#">Link 1</a>
        <a href="#">Link 2</a>
        <a href="#">Link 3</a>
    </nav>

    <aside>
        <h2>Lewa kolumna</h2>
        <p>Menu boczne, reklamy, linki.</p>
    </aside>

    <main>
        <h2>Główna treść</h2>
        <p>Tu jest główna zawartość strony — artykuły, produkty, informacje.</p>
    </main>

    <section>
        <h2>Prawa kolumna</h2>
        <p>Aktualności, widgety, reklamy.</p>
    </section>

    <!-- OBOWIĄZKOWY CLEARFIX! -->
    <div class="clear-both"></div>

    <footer>
        <p>Stopka strony &copy; 2025</p>
    </footer>

</body>
</html>
```

**Rozwiązanie CSS:**

```css
/* === WZORZEC EGZAMINACYJNY === */

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: Arial, sans-serif;
}

header {
    background-color: #2c3e50;
    color: white;
    padding: 15px 20px;
    text-align: center;
}

nav {
    background-color: #34495e;
    padding: 10px 20px;
    text-align: center;
}

nav a {
    color: white;
    text-decoration: none;
    margin: 0 15px;
    padding: 5px 10px;
}

/* KLUCZOWE: float:left na trzech kolumnach */
aside {
    float: left;
    width: 25%;
    background-color: #ecf0f1;
    padding: 15px;
    min-height: 300px;
}

main {
    float: left;
    width: 50%;
    background-color: #ffffff;
    padding: 15px;
    min-height: 300px;
}

section {
    float: left;
    width: 25%;
    background-color: #ecf0f1;
    padding: 15px;
    min-height: 300px;
}

/* KLUCZOWE: clearfix — bez tego footer "wskoczy" pod kolumny */
.clear-both {
    clear: both;
}

footer {
    background-color: #2c3e50;
    color: white;
    text-align: center;
    padding: 15px;
}
```

**Co sprawdza:** Float layout — najważniejszy wzorzec egzaminacyjny. Clearfix po float. Szerokości sumujące się do 100%.

---

### Zadanie 12: Responsywny navbar (desktop + mobile)

**Treść:** Stwórz nawigację która na desktopie wyświetla linki poziomo (w jednej linii), a na urządzeniach mobilnych (max-width: 768px) przełącza się na układ pionowy. Na mobile dodaj przycisk "hamburger" ☰ widoczny tylko na małych ekranach.

**Wskazówka:** Używaj `@media (max-width: 768px)` do nadpisania stylów desktopowych. Na desktopie `display: flex` na liście, na mobile `display: block` i `flex-direction: column`. Przycisk hamburger ukryj na desktopie `display: none`.

**Rozwiązanie HTML:**

```html
<nav class="navbar">
    <div class="navbar-logo">
        <a href="/">MojaStrona</a>
    </div>

    <button class="hamburger" aria-label="Menu">☰</button>

    <ul class="navbar-menu">
        <li><a href="index.html" class="aktywny">Strona główna</a></li>
        <li><a href="o-nas.html">O nas</a></li>
        <li><a href="oferta.html">Oferta</a></li>
        <li><a href="galeria.html">Galeria</a></li>
        <li><a href="kontakt.html">Kontakt</a></li>
    </ul>
</nav>
```

**Rozwiązanie CSS:**

```css
/* === DESKTOP (domyślne style) === */
.navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: #2c3e50;
    padding: 0 20px;
}

.navbar-logo a {
    color: white;
    text-decoration: none;
    font-size: 22px;
    font-weight: bold;
    padding: 15px 0;
    display: block;
}

/* Na desktopie menu jest poziome */
.navbar-menu {
    list-style: none;
    display: flex;
    gap: 0;
    margin: 0;
    padding: 0;
}

.navbar-menu li a {
    display: block;
    color: white;
    text-decoration: none;
    padding: 15px 18px;
    transition: background-color 0.2s;
}

.navbar-menu li a:hover,
.navbar-menu li a.aktywny {
    background-color: #e74c3c;
}

/* Hamburger ukryty na desktopie */
.hamburger {
    display: none;
    background: none;
    border: none;
    color: white;
    font-size: 26px;
    cursor: pointer;
}

/* === MOBILE (max-width: 768px) === */
@media (max-width: 768px) {

    .navbar {
        flex-wrap: wrap;
    }

    /* Hamburger widoczny na mobile */
    .hamburger {
        display: block;
    }

    /* Menu zajmuje pełną szerokość i staje się pionowe */
    .navbar-menu {
        display: none;      /* domyślnie ukryte, JS je pokazuje */
        flex-direction: column;
        width: 100%;
        background-color: #34495e;
    }

    .navbar-menu.aktywne {
        display: flex;      /* klasa dodawana przez JavaScript */
    }

    .navbar-menu li a {
        padding: 14px 20px;
        border-bottom: 1px solid #2c3e50;
    }
}
```

**Co sprawdza:** Media queries, responsywny design, flexbox, ukrywanie/pokazywanie elementów.

---

### Zadanie 13: Karta produktu z efektem hover

**Treść:** Zaprojektuj kartę produktu (card) zawierającą: zdjęcie produktu, tytuł, krótki opis, cenę i przycisk "Dodaj do koszyka". Karta powinna mieć zaokrąglone rogi, cień oraz efekt uniesienia przy najechaniu myszą (transform: scale + box-shadow).

**Wskazówka:** `border-radius` zaokrągla narożniki, `box-shadow` dodaje cień. `transition` sprawia, że efekt hover jest płynny. `transform: scale(1.05)` powiększa element o 5% przy najechaniu.

**Rozwiązanie HTML:**

```html
<div class="siatka-produktow">

    <article class="karta-produktu">
        <div class="karta-zdjecie">
            <img src="laptop.jpg" alt="Laptop Dell XPS 15">
            <span class="badge-promocja">-20%</span>
        </div>
        <div class="karta-tresc">
            <h3 class="karta-tytul">Laptop Dell XPS 15</h3>
            <p class="karta-opis">Wydajny laptop do pracy i rozrywki. Intel Core i7, 16GB RAM, SSD 512GB.</p>
            <div class="karta-cena">
                <span class="cena-stara">3 499 zł</span>
                <span class="cena-aktualna">2 799 zł</span>
            </div>
            <button class="btn-koszyk">Dodaj do koszyka</button>
        </div>
    </article>

    <!-- Kolejne karty produktów... -->

</div>
```

**Rozwiązanie CSS:**

```css
.siatka-produktow {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    padding: 20px;
}

.karta-produktu {
    width: 280px;
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    overflow: hidden;
    background-color: white;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    /* Płynne przejście dla hover */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* Efekt hover — uniesienie karty */
.karta-produktu:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
}

.karta-zdjecie {
    position: relative;
    overflow: hidden;
}

.karta-zdjecie img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    display: block;
}

.badge-promocja {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #e74c3c;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 13px;
    font-weight: bold;
}

.karta-tresc {
    padding: 15px;
}

.karta-tytul {
    font-size: 18px;
    margin-bottom: 8px;
    color: #333;
}

.karta-opis {
    font-size: 14px;
    color: #666;
    margin-bottom: 12px;
    line-height: 1.5;
}

.karta-cena {
    margin-bottom: 15px;
}

.cena-stara {
    color: #999;
    text-decoration: line-through;
    font-size: 14px;
    margin-right: 8px;
}

.cena-aktualna {
    color: #e74c3c;
    font-size: 22px;
    font-weight: bold;
}

.btn-koszyk {
    width: 100%;
    padding: 12px;
    background-color: #27ae60;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 15px;
    cursor: pointer;
    transition: background-color 0.2s;
}

.btn-koszyk:hover {
    background-color: #1e8449;
}
```

**Co sprawdza:** `border-radius`, `box-shadow`, `transform`, `transition`, pozycjonowanie badge, `object-fit`.

---

### Zadanie 14: Tło z obrazem i ciemną nakładką

**Treść:** Stwórz sekcję z tłem ustawionym jako zdjęcie. Zdjęcie powinno pokrywać całą sekcję (`background-size: cover`), być wyśrodkowane (`background-position: center`), nie powtarzać się, i mieć na sobie ciemną nakładkę (overlay) dzięki której tekst jest czytelny.

**Wskazówka:** Nakładkę ciemną można osiągnąć dwoma sposobami: (1) wielokrotne tło CSS z `linear-gradient` + `url()`, (2) pseudoelement `::before` z `position: absolute` i `background: rgba(0,0,0,0.5)`. Sposób 1 jest prostszy.

**Rozwiązanie HTML:**

```html
<section class="hero">
    <div class="hero-tresc">
        <h1>Witaj na naszej stronie</h1>
        <p>Tworzymy nowoczesne strony internetowe dla Twojego biznesu.</p>
        <a href="kontakt.html" class="btn-hero">Skontaktuj się</a>
    </div>
</section>
```

**Rozwiązanie CSS:**

```css
/* Metoda 1: Gradient jako nakładka (gradient + obraz) */
.hero {
    /* Ciemna nakładka + zdjęcie w tle */
    background-image:
        linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
        url('tlo-hero.jpg');
    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat;
    background-attachment: fixed; /* efekt paralaksy */

    min-height: 500px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: white;
}

.hero-tresc {
    max-width: 700px;
    padding: 20px;
}

.hero-tresc h1 {
    font-size: 48px;
    margin-bottom: 20px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
}

.hero-tresc p {
    font-size: 20px;
    margin-bottom: 30px;
    opacity: 0.9;
}

.btn-hero {
    display: inline-block;
    padding: 15px 40px;
    background-color: #e74c3c;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-size: 18px;
    transition: background-color 0.3s;
}

.btn-hero:hover {
    background-color: #c0392b;
}

/* Metoda 2: Pseudoelement ::before jako nakładka */
/*
.hero {
    position: relative;
    background-image: url('tlo-hero.jpg');
    background-size: cover;
    background-position: center;
}

.hero::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
}

.hero-tresc {
    position: relative;
    z-index: 1;
}
*/
```

**Co sprawdza:** `background-image`, `background-size: cover`, `background-position`, wielokrotne tło, nakładka.

---

### Zadanie 15: Stylowanie tabeli z naprzemiennymi wierszami

**Treść:** Ostyluj tabelę HTML tak, żeby miała: naprzemienne kolory wierszy (parzyste wiersze szare, nieparzyste białe), efekt podświetlenia wiersza przy najechaniu myszą, zaznaczony nagłówek tabeli, i scalone obramowanie `border-collapse: collapse`.

**Wskazówka:** Selektor `:nth-child(even)` lub `:nth-child(2n)` wybiera parzyste wiersze. `:nth-child(odd)` wybiera nieparzyste. `border-collapse: collapse` scala obramowania komórek w jedno. `tr:hover` zmienia tło wiersza.

**Rozwiązanie HTML:**

```html
<table class="tabela-danych">
    <thead>
        <tr>
            <th>ID</th>
            <th>Imię i nazwisko</th>
            <th>E-mail</th>
            <th>Rola</th>
            <th>Data rejestracji</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Jan Kowalski</td>
            <td>jan@example.pl</td>
            <td>Administrator</td>
            <td>2024-01-15</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Anna Nowak</td>
            <td>anna@example.pl</td>
            <td>Redaktor</td>
            <td>2024-02-20</td>
        </tr>
        <tr>
            <td>3</td>
            <td>Piotr Wiśniewski</td>
            <td>piotr@example.pl</td>
            <td>Użytkownik</td>
            <td>2024-03-10</td>
        </tr>
        <tr>
            <td>4</td>
            <td>Maria Wójcik</td>
            <td>maria@example.pl</td>
            <td>Redaktor</td>
            <td>2024-04-05</td>
        </tr>
    </tbody>
</table>
```

**Rozwiązanie CSS:**

```css
.tabela-danych {
    width: 100%;
    border-collapse: collapse;   /* KLUCZOWE: scala obramowania */
    margin: 20px 0;
    font-size: 15px;
    font-family: Arial, sans-serif;
}

/* Nagłówek tabeli */
.tabela-danych thead th {
    background-color: #2c3e50;
    color: white;
    padding: 12px 15px;
    text-align: left;
    font-weight: bold;
    border: 1px solid #1a252f;
}

/* Wszystkie komórki danych */
.tabela-danych tbody td {
    padding: 10px 15px;
    border: 1px solid #ddd;
    color: #333;
}

/* Naprzemienne kolory wierszy */
.tabela-danych tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

.tabela-danych tbody tr:nth-child(odd) {
    background-color: #ffffff;
}

/* Hover na wierszu */
.tabela-danych tbody tr:hover {
    background-color: #d6eaf8;
    cursor: pointer;
}

/* Stopka tabeli */
.tabela-danych tfoot td {
    background-color: #ecf0f1;
    font-style: italic;
    padding: 10px 15px;
    border: 1px solid #ddd;
}
```

**Co sprawdza:** `border-collapse`, `:nth-child()`, `tr:hover`, stylowanie `thead/tbody/tfoot` osobno.

---

### Zadanie 16: Animacja CSS — pulsujący przycisk CTA

**Treść:** Stwórz przycisk Call-To-Action z animacją CSS: pulsowanie (powiększanie i zmniejszanie w kółko) oraz delikatna zmiana koloru. Użyj `@keyframes` i właściwości `animation`. Animacja powinna być nieskończona i płynna.

**Wskazówka:** `@keyframes nazwa { 0% {...} 50% {...} 100% {...} }` definiuje klatki animacji. `animation: nazwa czas timing-function delay iteration-count direction` stosuje animację. `animation-iteration-count: infinite` powtarza w nieskończoność.

**Rozwiązanie HTML:**

```html
<div class="baner-promocja">
    <h2>Wyjątkowa oferta!</h2>
    <p>Tylko przez 24 godziny — 50% zniżki na wszystkie produkty</p>
    <button class="btn-pulsujacy">KLIKNIJ TERAZ</button>
</div>
```

**Rozwiązanie CSS:**

```css
/* Definicja animacji pulsowania */
@keyframes pulsowanie {
    0% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(231, 76, 60, 0.7);
    }
    50% {
        transform: scale(1.08);
        box-shadow: 0 0 0 10px rgba(231, 76, 60, 0);
    }
    100% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(231, 76, 60, 0);
    }
}

/* Animacja zmiany koloru tła */
@keyframes zmiana-koloru {
    0%   { background-color: #e74c3c; }
    50%  { background-color: #c0392b; }
    100% { background-color: #e74c3c; }
}

.baner-promocja {
    text-align: center;
    padding: 40px;
    background-color: #fdf2f2;
    border: 2px solid #e74c3c;
    border-radius: 10px;
    margin: 20px;
}

.btn-pulsujacy {
    padding: 18px 50px;
    background-color: #e74c3c;
    color: white;
    border: none;
    border-radius: 50px;
    font-size: 20px;
    font-weight: bold;
    letter-spacing: 2px;
    cursor: pointer;

    /* Stosowanie animacji */
    animation: pulsowanie 1.5s ease-in-out infinite;
}

.btn-pulsujacy:hover {
    /* Zatrzymaj animację na hover, zastąp zwykłym stylem */
    animation: none;
    background-color: #c0392b;
    transform: scale(1.1);
    transition: all 0.2s;
}
```

**Co sprawdza:** `@keyframes`, `animation`, `animation-iteration-count: infinite`, `transform: scale()`.

---

### Zadanie 17: Formularz ze stylami stanu (focus, error, valid)

**Treść:** Ostyluj formularz tak żeby pola miały: widoczny pierścień focusu przy zaznaczeniu klawiaturą (outline niebieski), czerwone obramowanie dla pól z błędem (klasa `.error`), zielone obramowanie dla pól poprawnie wypełnionych (klasa `.valid`), i komunikaty błędów pod polami.

**Wskazówka:** `:focus` pseudo-klasa aktywuje się gdy pole jest zaznaczone. Klasy `.error` i `.valid` dodajemy przez JavaScript po walidacji. `outline` jest lepsze niż `border` dla focusu bo nie przesuwa elementów. Użyj `outline-offset` żeby fokus był nieco odsunięty.

**Rozwiązanie HTML:**

```html
<form class="formularz-walidowany" action="przetworz.php" method="POST">

    <div class="pole-formularza">
        <label for="nazwa">Nazwa użytkownika:</label>
        <input type="text" id="nazwa" name="nazwa" class="error" value="ab">
        <span class="komunikat-bledu">Nazwa musi mieć minimum 3 znaki.</span>
    </div>

    <div class="pole-formularza">
        <label for="email">Adres e-mail:</label>
        <input type="email" id="email" name="email" class="valid" value="jan@example.pl">
        <span class="komunikat-sukcesu">Adres e-mail jest poprawny.</span>
    </div>

    <div class="pole-formularza">
        <label for="haslo">Hasło:</label>
        <input type="password" id="haslo" name="haslo" placeholder="Minimum 8 znaków">
    </div>

    <button type="submit">Zarejestruj się</button>
</form>
```

**Rozwiązanie CSS:**

```css
.formularz-walidowany {
    max-width: 450px;
    margin: 30px auto;
    padding: 25px;
}

.pole-formularza {
    margin-bottom: 20px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 6px;
    color: #333;
}

/* Bazowy styl pola */
input[type="text"],
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 10px 12px;
    border: 2px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    transition: border-color 0.2s, outline 0.2s;
    outline: none;     /* Usuń domyślny outline */
}

/* FOCUS — widoczny pierścień focusu */
input:focus {
    border-color: #3498db;
    outline: 3px solid rgba(52, 152, 219, 0.3);
    outline-offset: 2px;
}

/* ERROR — czerwone obramowanie */
input.error {
    border-color: #e74c3c;
    background-color: #fef9f9;
}

input.error:focus {
    outline-color: rgba(231, 76, 60, 0.3);
}

/* VALID — zielone obramowanie */
input.valid {
    border-color: #27ae60;
    background-color: #f9fef9;
}

input.valid:focus {
    outline-color: rgba(39, 174, 96, 0.3);
}

/* Komunikaty */
.komunikat-bledu {
    display: block;
    color: #e74c3c;
    font-size: 13px;
    margin-top: 5px;
}

.komunikat-sukcesu {
    display: block;
    color: #27ae60;
    font-size: 13px;
    margin-top: 5px;
}

button[type="submit"] {
    width: 100%;
    padding: 14px;
    background-color: #3498db;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
}
```

**Co sprawdza:** Pseudo-klasa `:focus`, stany formularza, dostępność (outline), klasy dla stanu błędu/sukcesu.

---

### Zadanie 18: CSS Grid — siatka 3-kolumnowa z elementem na 2 kolumny

**Treść:** Stwórz siatkę layoutu za pomocą CSS Grid z 3 kolumnami równej szerokości. Jeden z elementów (np. wyróżniony artykuł) powinien zajmować 2 kolumny (grid-column: span 2). Dodaj odstępy między elementami i wyrównanie.

**Wskazówka:** `display: grid` na kontenerze. `grid-template-columns: repeat(3, 1fr)` tworzy 3 równe kolumny. `grid-column: span 2` na elemencie dziecku sprawia, że zajmuje 2 kolumny. `gap` ustawia odstępy.

**Rozwiązanie HTML:**

```html
<section class="siatka-artykulow">

    <!-- Ten artykuł zajmuje 2 kolumny -->
    <article class="karta wyrozniany">
        <h2>Wyróżniony artykuł</h2>
        <p>Ten element zajmuje dwie kolumny siatki (grid-column: span 2). Używamy go do wyróżnienia ważnej treści.</p>
    </article>

    <article class="karta">
        <h2>Artykuł 2</h2>
        <p>Normalny artykuł zajmujący jedną kolumnę siatki.</p>
    </article>

    <article class="karta">
        <h2>Artykuł 3</h2>
        <p>Kolejny artykuł w siatce CSS Grid.</p>
    </article>

    <article class="karta">
        <h2>Artykuł 4</h2>
        <p>Czwarty artykuł w siatce.</p>
    </article>

    <!-- Ten zajmuje pełną szerokość (3 kolumny) -->
    <article class="karta pelna-szerokosc">
        <h2>Baner na pełną szerokość</h2>
        <p>Ten element zajmuje wszystkie 3 kolumny.</p>
    </article>

</section>
```

**Rozwiązanie CSS:**

```css
.siatka-artykulow {
    display: grid;
    grid-template-columns: repeat(3, 1fr);  /* 3 kolumny równej szerokości */
    gap: 20px;                               /* odstępy między elementami */
    padding: 20px;
}

.karta {
    background-color: white;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

/* Element zajmujący 2 kolumny */
.wyrozniany {
    grid-column: span 2;
    background-color: #eaf4fb;
    border-color: #3498db;
}

/* Element zajmujący pełną szerokość (wszystkie 3 kolumny) */
.pelna-szerokosc {
    grid-column: span 3;
    background-color: #fef9e7;
    border-color: #f39c12;
    text-align: center;
}

/* Responsywność: na mobile 1 kolumna */
@media (max-width: 768px) {
    .siatka-artykulow {
        grid-template-columns: 1fr;
    }

    .wyrozniany,
    .pelna-szerokosc {
        grid-column: span 1;   /* na mobile reset do 1 kolumny */
    }
}
```

**Co sprawdza:** CSS Grid, `grid-template-columns`, `repeat()`, `1fr`, `grid-column: span`, responsywność gridu.

---

### Zadanie 19: Pozycjonowanie (fixed, sticky, absolute)

**Treść:** Stwórz stronę demonstrującą trzy typy pozycjonowania: (1) nagłówek `fixed` — zawsze widoczny na górze ekranu przy scrollowaniu, (2) sidebar `sticky` — przyklejający się do góry przy przewijaniu, (3) badge `absolute` na ikonie — napis "Nowe" w rogu zdjęcia.

**Wskazówka:** `position: fixed` zawsze na ekranie (offset od okna), `position: sticky` przyklejony do rodzica (wymaga `top`), `position: absolute` względem najbliższego przodka z `position: relative`. Element z `absolute` jest wyjęty z normalnego przepływu.

**Rozwiązanie HTML:**

```html
<!-- Fixed header -->
<header class="header-fixed">
    <h1>MojaStrona</h1>
    <nav>
        <a href="#">Strona główna</a>
        <a href="#">O nas</a>
        <a href="#">Kontakt</a>
    </nav>
</header>

<!-- Główna treść z marginem-top = wysokość headera -->
<div class="layout">

    <!-- Sticky sidebar -->
    <aside class="sidebar-sticky">
        <h3>Menu boczne</h3>
        <ul>
            <li><a href="#">Kategoria 1</a></li>
            <li><a href="#">Kategoria 2</a></li>
            <li><a href="#">Kategoria 3</a></li>
        </ul>
    </aside>

    <!-- Treść główna -->
    <main class="tresc-glowna">
        <!-- Zdjęcie z absolutnym badge -->
        <div class="zdjecie-z-badge">
            <img src="produkt.jpg" alt="Nowy produkt">
            <span class="badge-nowe">NOWE</span>
        </div>

        <h2>Tytuł artykułu</h2>
        <p>Długi tekst artykułu... (wiele akapitów żeby pokazać scrollowanie)</p>
    </main>

</div>
```

**Rozwiązanie CSS:**

```css
/* 1. FIXED HEADER — zawsze na górze */
.header-fixed {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background-color: #2c3e50;
    color: white;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 1000;           /* nad innymi elementami */
    box-shadow: 0 2px 10px rgba(0,0,0,0.3);
}

/* Margines góry — żeby treść nie chowała się pod fixed header */
body {
    margin-top: 70px;
}

/* 2. STICKY SIDEBAR — przykleja się przy scrollowaniu */
.layout {
    display: flex;
    gap: 20px;
    padding: 20px;
}

.sidebar-sticky {
    width: 250px;
    flex-shrink: 0;
    position: sticky;
    top: 80px;               /* 70px header + 10px odstęp */
    height: fit-content;     /* nie rozciąga się ponad treść */
    background-color: #ecf0f1;
    padding: 15px;
    border-radius: 8px;
}

.tresc-glowna {
    flex: 1;
}

/* 3. ABSOLUTE BADGE na zdjęciu */
.zdjecie-z-badge {
    position: relative;      /* rodzic dla absolute */
    display: inline-block;
}

.zdjecie-z-badge img {
    display: block;
    max-width: 100%;
    border-radius: 8px;
}

.badge-nowe {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #e74c3c;
    color: white;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: bold;
    letter-spacing: 1px;
}
```

**Co sprawdza:** Trzy typy pozycjonowania CSS, `z-index`, `top/left/right/bottom`, rodzic `relative` + dziecko `absolute`.

---

### Zadanie 20: CSS Variables — zmienne CSS w całym pliku

**Treść:** Stwórz arkusz CSS używający zmiennych CSS (Custom Properties). Zdefiniuj co najmniej: `--primary-color`, `--secondary-color`, `--border-radius`, `--shadow` i `--font-size-base` w `:root`. Użyj tych zmiennych do ostylowania headera, przycisków, kart i formularza.

**Wskazówka:** Zmienne CSS definiuje się w `:root { --nazwa: wartość; }`. Używa się ich przez `var(--nazwa)`. Zmienne można nadpisać lokalnie dla danego elementu. Pozwalają zmienić cały motyw kolorystyczny jedną zmianą w `:root`.

**Rozwiązanie HTML:**

```html
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>CSS Variables</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>

    <header class="header-glowny">
        <h1>MojaStrona</h1>
    </header>

    <main class="kontener">
        <div class="karta">
            <h2>Tytuł karty</h2>
            <p>Treść karty z użyciem zmiennych CSS.</p>
            <button class="btn-primary">Przycisk główny</button>
            <button class="btn-secondary">Przycisk drugorzędny</button>
        </div>

        <form class="formularz-zmienne">
            <label for="pole">Pole tekstowe:</label>
            <input type="text" id="pole" name="pole" placeholder="Wpisz tekst...">
            <button type="submit" class="btn-primary">Wyślij</button>
        </form>
    </main>

    <footer class="footer-glowny">
        <p>&copy; 2025 MojaStrona</p>
    </footer>

</body>
</html>
```

**Rozwiązanie CSS:**

```css
/* === DEFINICJA ZMIENNYCH CSS === */
:root {
    /* Kolory */
    --primary-color: #3498db;
    --primary-dark: #2980b9;
    --secondary-color: #2c3e50;
    --accent-color: #e74c3c;
    --success-color: #27ae60;
    --background-color: #f4f6f9;
    --text-color: #333333;
    --text-muted: #666666;
    --border-color: #dddddd;
    --white: #ffffff;

    /* Geometria */
    --border-radius: 8px;
    --border-radius-large: 16px;
    --border-radius-pill: 50px;

    /* Cienie */
    --shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    --shadow-hover: 0 6px 20px rgba(0, 0, 0, 0.15);

    /* Typografia */
    --font-family: Arial, Helvetica, sans-serif;
    --font-size-base: 16px;
    --font-size-small: 14px;
    --font-size-large: 20px;
    --line-height: 1.6;

    /* Odstępy */
    --padding-small: 8px 12px;
    --padding-medium: 12px 20px;
    --padding-large: 20px 30px;
}

/* Użycie zmiennych w stylach */

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: var(--font-family);
    font-size: var(--font-size-base);
    color: var(--text-color);
    background-color: var(--background-color);
    line-height: var(--line-height);
}

.header-glowny {
    background-color: var(--secondary-color);
    color: var(--white);
    padding: var(--padding-large);
    text-align: center;
}

.kontener {
    max-width: 900px;
    margin: 30px auto;
    padding: 0 20px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.karta {
    background-color: var(--white);
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    padding: var(--padding-large);
}

.karta:hover {
    box-shadow: var(--shadow-hover);
}

/* Przyciski używają zmiennych */
.btn-primary {
    background-color: var(--primary-color);
    color: var(--white);
    padding: var(--padding-medium);
    border: none;
    border-radius: var(--border-radius);
    font-size: var(--font-size-base);
    cursor: pointer;
    transition: background-color 0.2s;
    margin-right: 8px;
}

.btn-primary:hover {
    background-color: var(--primary-dark);
}

.btn-secondary {
    background-color: transparent;
    color: var(--primary-color);
    padding: var(--padding-medium);
    border: 2px solid var(--primary-color);
    border-radius: var(--border-radius);
    font-size: var(--font-size-base);
    cursor: pointer;
    transition: all 0.2s;
}

.btn-secondary:hover {
    background-color: var(--primary-color);
    color: var(--white);
}

/* Formularz */
.formularz-zmienne {
    background-color: var(--white);
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    padding: var(--padding-large);
}

.formularz-zmienne label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: var(--text-color);
}

.formularz-zmienne input {
    width: 100%;
    padding: var(--padding-medium);
    border: 2px solid var(--border-color);
    border-radius: var(--border-radius);
    font-size: var(--font-size-base);
    margin-bottom: 15px;
    transition: border-color 0.2s;
}

.formularz-zmienne input:focus {
    border-color: var(--primary-color);
    outline: none;
}

.footer-glowny {
    background-color: var(--secondary-color);
    color: var(--white);
    text-align: center;
    padding: var(--padding-medium);
    margin-top: 30px;
}

/* Przykład nadpisania zmiennej lokalnie */
.karta.ciemny-motyw {
    --primary-color: #9b59b6;   /* fioletowy dla tej karty */
    --background-color: #2c3e50;
    --text-color: white;
    background-color: var(--background-color);
    color: var(--text-color);
}
```

**Co sprawdza:** CSS Custom Properties (`var()`), `:root`, dziedziczenie zmiennych, lokalne nadpisywanie, zmiana motywu.

---

## Podsumowanie — Kluczowe wzorce egzaminacyjne

| Temat | Kluczowy kod |
|-------|-------------|
| Float layout | `float:left; width:25/50/25%` + `clear:both` |
| Link w nav | `<a href="strona.html">tekst</a>` |
| Formularz POST | `<form action="plik.php" method="POST">` |
| Input required | `<input type="text" required minlength="3">` |
| Label-input | `<label for="id">` + `<input id="id">` |
| Media query | `@media (max-width: 768px) { ... }` |
| CSS Variable | `:root { --kolor: #333; }` → `color: var(--kolor)` |
| Hover efekt | `element:hover { transform: scale(1.05); }` |
| Animacja | `@keyframes nazwa { }` + `animation: nazwa 1s infinite` |
| ARIA | `aria-label=""` + `aria-current="page"` |
