# 📝 ŚCIĄGAWKA: HTML - Znaczniki i Semantyka (INF.03.3)

---

## 1️⃣ STRUKTURA HTML DOKUMENTU

```html
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tytuł strony (widoczny w karcie)</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Zawartość strony -->
    <script src="script.js"></script>
</body>
</html>
```

### Meta znaczniki
```html
<meta charset="UTF-8">                      <!-- Kodowanie znaków -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">  <!-- Responsywność -->
<meta name="description" content="Opis..."> <!-- SEO - opis w wyniku wyszukiwania -->
<meta name="keywords" content="słowa kluczowe"> <!-- SEO - słowa kluczowe -->
<meta name="author" content="Imię Nazwisko"> <!-- Autor -->
<meta name="robots" content="index, follow">  <!-- Dla crawlerów (Google) -->
```

---

## 2️⃣ ZNACZNIKI SEMANTYCZNE (HTML5)

### Struktura logiczna strony

```html
<header>
    <!-- Górna część strony, logo, nawigacja -->
    <nav>
        <ul>
            <li><a href="#home">Strona główna</a></li>
            <li><a href="#about">O nas</a></li>
        </ul>
    </nav>
</header>

<main>
    <!-- Główna zawartość strony (jedna na stronę!) -->
    
    <article>
        <!-- Artykuł, post, wpis na blogu -->
        <h1>Tytuł artykułu</h1>
        <time datetime="2026-05-16">16 maja 2026</time>
        <p>Zawartość artykułu...</p>
    </article>
    
    <aside>
        <!-- Boczny pasek, informacje dodatkowe -->
        <h3>Kategorie</h3>
        <ul>
            <li>Technologia</li>
            <li>Web</li>
        </ul>
    </aside>
</main>

<section>
    <!-- Sekcja z powiązaną zawartością -->
    <h2>Więcej informacji</h2>
    <p>...</p>
</section>

<footer>
    <!-- Dolna część strony, prawa autorskie, linki -->
    <p>&copy; 2026 Moja strona. Wszelkie prawa zastrzeżone.</p>
</footer>
```

---

## 3️⃣ ZNACZNIKI TEKSTOWE

### Nagłówki
```html
<h1>Najważniejszy nagłówek (na stronę tylko 1!)</h1>
<h2>Nagłówek drugiego poziomu</h2>
<h3>Nagłówek trzeciego poziomu</h3>
<h4>Nagłówek czwartego poziomu</h4>
<h5>Nagłówek piątego poziomu</h5>
<h6>Nagłówek szóstego poziomu</h6>
```

### Paragrafy i tekst
```html
<p>Zwykły paragraf tekstu.</p>
<br>  <!-- Twardy podział linii (unikać!) -->
<hr>  <!-- Linia separacyjna -->

<!-- Formatowanie tekstu -->
<strong>Tekst ważny (semantycznie)</strong>  <!-- Bold -->
<b>Tekst pogrubiony (tylko wizualnie)</b>    <!-- Nie używać! -->

<em>Tekst wyróżniony (semantycznie)</em>    <!-- Italic -->
<i>Tekst pochylony (tylko wizualnie)</i>    <!-- Nie używać! -->

<mark>Tekst wyróżniony kolorem</mark>        <!-- Highlight -->
<small>Mały tekst (disclaimer)</small>
<code>kod_programu</code>                     <!-- Kod źródłowy -->
<pre>
    Tekst preformatowany (zachowuje spacje)
    Używany dla kodu i przykładów
</pre>

<blockquote>
    Cytat z innego źródła
    <cite>Autor cytatu</cite>
</blockquote>

<q>Krótki cytat w tekście</q>
```

---

## 4️⃣ LISTY

### Lista nieuporządkowana (bullet points)
```html
<ul>
    <li>Punkt pierwszy</li>
    <li>Punkt drugi</li>
    <li>Punkt trzeci
        <ul>
            <li>Podpunkt 1</li>
            <li>Podpunkt 2</li>
        </ul>
    </li>
</ul>
```

### Lista uporządkowana (numerowana)
```html
<ol>
    <li>Pierwszy krok</li>
    <li>Drugi krok</li>
    <li>Trzeci krok</li>
</ol>

<!-- Z niestandardowym numerowaniem -->
<ol start="5" reversed>
    <li>Punkt 5</li>
    <li>Punkt 4</li>
    <li>Punkt 3</li>
</ol>
```

### Lista definicji
```html
<dl>
    <dt>HTML</dt>
    <dd>HyperText Markup Language - język znaczników</dd>
    
    <dt>CSS</dt>
    <dd>Cascading Style Sheets - arkusz stylów</dd>
</dl>
```

---

## 5️⃣ LINKI

```html
<!-- Prosty link -->
<a href="https://example.com">Link do strony</a>

<!-- Link z atrybutami -->
<a href="./strona.html" 
   title="Opis tooltipa"
   target="_blank"              <!-- Otwórz w nowej karcie -->
   rel="noopener noreferrer">   <!-- Bezpieczeństwo -->
   Link na nową kartę
</a>

<!-- Link wewnętrzny (na tej samej stronie) -->
<a href="#sekcja-2">Przejdź do sekcji 2</a>

<!-- Kotwa (link docelowy) -->
<h2 id="sekcja-2">Sekcja 2</h2>

<!-- Link email -->
<a href="mailto:kontakt@example.com">Wyślij email</a>

<!-- Link phone -->
<a href="tel:+48123456789">Zadzwoń</a>

<!-- Link download -->
<a href="plik.pdf" download>Pobierz PDF</a>
```

---

## 6️⃣ OBRAZY

```html
<!-- Obraz bazowy -->
<img src="sciezka/obraz.jpg" 
     alt="Opis dla niewidzących (WAŻNE!)"
     title="Tooltip">

<!-- Obraz responsywny -->
<img src="obraz.jpg"
     srcset="obraz-small.jpg 480w,
             obraz-medium.jpg 768w,
             obraz-large.jpg 1200w"
     sizes="(max-width: 480px) 100vw,
            (max-width: 768px) 80vw,
            60vw"
     alt="Opis">

<!-- Obraz z figurą (semantyka) -->
<figure>
    <img src="obraz.jpg" alt="Opis">
    <figcaption>Opis obrazu pod obrazem</figcaption>
</figure>

<!-- SVG (wektorowe) -->
<svg width="100" height="100">
    <circle cx="50" cy="50" r="40" fill="blue" />
</svg>
```

---

## 7️⃣ FORMULARZE

```html
<form action="handler.php" method="POST" enctype="multipart/form-data">
    
    <!-- Tekst -->
    <label for="imie">Imię:</label>
    <input type="text" 
           id="imie" 
           name="imie" 
           required 
           placeholder="Wpisz swoje imię">
    
    <!-- Email -->
    <input type="email" name="email" required>
    
    <!-- Hasło -->
    <input type="password" name="haslo" required>
    
    <!-- Liczba -->
    <input type="number" name="wiek" min="0" max="120">
    
    <!-- Data -->
    <input type="date" name="data_urodzenia">
    
    <!-- Color picker -->
    <input type="color" name="kolor" value="#ff0000">
    
    <!-- Range slider -->
    <input type="range" name="poziom" min="0" max="100" value="50">
    
    <!-- Checkbox (wiele opcji) -->
    <label><input type="checkbox" name="zgoda" value="1"> Akceptuję regulamin</label>
    
    <!-- Radio buttons (jedna opcja) -->
    <label><input type="radio" name="plec" value="M"> Mężczyzna</label>
    <label><input type="radio" name="plec" value="K"> Kobieta</label>
    
    <!-- Select dropdown -->
    <select name="kraj" required>
        <option value="">-- Wybierz kraj --</option>
        <option value="PL">Polska</option>
        <option value="DE">Niemcy</option>
        <option value="FR">Francja</option>
    </select>
    
    <!-- Textarea (tekst wielolinijkowy) -->
    <textarea name="wiadomosc" 
              rows="5" 
              cols="40"
              placeholder="Wpisz wiadomość..."></textarea>
    
    <!-- Button submit -->
    <button type="submit">Wyślij formularz</button>
    <button type="reset">Wyczyść</button>
    <button type="button">Zwykły guzik</button>
    
</form>
```

### Atrybuty formularzy
```html
<!-- Validacja HTML5 -->
required              <!-- Pole obowiązkowe -->
min="0" max="100"    <!-- Zakres wartości -->
pattern="[0-9]{3}"   <!-- Regex: dokładnie 3 cyfry -->
placeholder="..."    <!-- Placeholder tekst -->
autocomplete="off"   <!-- Wyłącz autouzupełnianie -->
disabled             <!-- Wyłącz pole -->
readonly             <!-- Pole tylko do odczytu -->
maxlength="50"       <!-- Maksymalna długość tekstu -->
```

---

## 8️⃣ TABELE

```html
<table border="1">
    <thead>
        <tr>
            <th>Imię</th>
            <th>Nazwisko</th>
            <th>Wiek</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Jan</td>
            <td>Kowalski</td>
            <td>30</td>
        </tr>
        <tr>
            <td>Anna</td>
            <td>Nowak</td>
            <td>25</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2">Razem:</td>
            <td>2 osoby</td>
        </tr>
    </tfoot>
</table>

<!-- Atrybuty -->
<table>
    <tr>
        <td colspan="2">Łącze 2 kolumny</td>
    </tr>
    <tr>
        <td rowspan="2">Łącze 2 wiersze</td>
        <td>Komórka 1</td>
    </tr>
    <tr>
        <td>Komórka 2</td>
    </tr>
</table>
```

---

## 9️⃣ MEDIA

### Audio
```html
<audio controls>
    <source src="plik.mp3" type="audio/mpeg">
    <source src="plik.ogg" type="audio/ogg">
    Twoja przeglądarka nie obsługuje audio!
</audio>
```

### Video
```html
<video width="320" height="240" controls>
    <source src="film.mp4" type="video/mp4">
    <source src="film.ogg" type="video/ogg">
    Twoja przeglądarka nie obsługuje video!
</video>
```

### Iframe (osadzanie)
```html
<iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" 
        width="560" 
        height="315">
</iframe>

<iframe src="mapa.html" style="width:100%; height:500px;"></iframe>
```

---

## 🔟 ATRYBUTY GLOBALNE

```html
<!-- Dostępne dla wszystkich elementów -->
id="unikalna-id"           <!-- Unikalny identyfikator (dla CSS i JS) -->
class="klasa1 klasa2"      <!-- Klasy CSS -->
style="color: red;"        <!-- Inline CSS (unikać!) -->
title="Tooltip"            <!-- Tekst tooltipa -->
lang="pl"                  <!-- Język (dla dostępności) -->
dir="ltr"                  <!-- Kierunek tekstu (left-to-right) -->
data-custom="wartość"      <!-- Własne atrybuty danych -->
hidden                     <!-- Ukryj element -->
contenteditable="true"     <!-- Edytowalne w przeglądarce -->
draggable="true"           <!-- Przeciągalne -->
```

---

## 1️⃣1️⃣ DOSTĘPNOŚĆ (ACCESSIBILITY)

### WCAG 2.0 - Web Content Accessibility Guidelines

```html
<!-- Alternatywne teksty (dla niewidzących) -->
<img src="obraz.jpg" alt="Krótki opis obrazu">
<img src="logo.svg" alt="" role="presentation">  <!-- Czysto dekoracyjne -->

<!-- Powiązanie label z input (dla czytników ekranu) -->
<label for="email">Email:</label>
<input type="email" id="email" name="email">

<!-- Headingi w logicznej kolejności -->
<h1>Główny tytuł</h1>
<h2>Sekcja 2</h2>
<h2>Sekcja 3</h2>
<!-- Nie rób: h1, h3, h5 (brakuje logiki) -->

<!-- ARIA (Accessible Rich Internet Applications) -->
<button aria-label="Zamknij okno">✕</button>
<div role="navigation" aria-label="Menu główne">...</div>
<span aria-hidden="true">Decorative icon</span>
```

### Kolory i kontrast
```html
<!-- Minimum kontrast 4.5:1 dla tekstu zwykłego -->
<!-- Dla dużego tekstu 3:1 -->
<!-- Nigdy nie polegaj TYLKO na kolorze -->
<p style="color: red;">❌ Błąd (niewystarczający kontrast)</p>
<p style="color: darkred;">✅ Lepiej</p>
```

---

## 1️⃣2️⃣ BEST PRACTICES

### ✅ DOBRZE
```html
<!-- Semantic HTML -->
<header>...</header>
<main>...</main>
<article>...</article>
<footer>...</footer>

<!-- Znaczniki semantyczne zamiast div -->
<strong>ważne</strong>  <!-- Zamiast <b> -->
<em>wyróżnione</em>     <!-- Zamiast <i> -->

<!-- Prawidłowa hierarchia heading'ów -->
<!-- H1 > H2 > H3... -->

<!-- Alt text dla obrazów -->
<img src="logo.png" alt="Logo firmy XYZ">

<!-- Label dla formularzy -->
<label for="email">Email:</label>
<input id="email" type="email">
```

### ❌ ŹRÓDŁO PROBLEMÓW
```html
<!-- Brak semantic HTML -->
<div class="header">...</div>  <!-- Zamiast <header> -->

<!-- Twardą pozycjonowanie -->
<br><br><br>  <!-- Dla przestrzeni - użyj CSS! -->

<!-- Słabej dostępności -->
<img src="photo.jpg">  <!-- Brak alt text -->
<button onclick="...">Klik</button>  <!-- Bez dostępności -->

<!-- Zagnieżdżone tabelę (anti-pattern) -->
<!-- NIE rób tego! -->
```

---

## 1️⃣3️⃣ PODSUMOWANIE DO EGZAMINU

| Element | Znaczenie | Semantyka |
|---------|-----------|-----------|
| `<header>` | Górna część | Zawsze na górze |
| `<nav>` | Nawigacja | Linki do sekcji |
| `<main>` | Główna zawartość | Jedna na stronę! |
| `<article>` | Artykuł/wpis | Niezależna zawartość |
| `<section>` | Sekcja | Powiązana zawartość |
| `<aside>` | Boczny pasek | Dodatkowe info |
| `<footer>` | Dolna część | Zawsze na dole |
| `<h1>-<h6>` | Nagłówki | Hierarchia logiczna |
| `<strong>` | Ważny | Semantycznie |
| `<em>` | Wyróżniony | Semantycznie |
| `<img>` | Obraz | Zawsze alt text! |

---

**Powodzenia na egzaminie! 🎓**
