# Testowanie, walidacja i optymalizacja stron
> INF.03 - Projektowanie stron | Ściaģawka egzaminacyjna

---

## 1. Testowanie przeglądarek (Cross-browser Testing)

### Główne przeglądarki
| Przeglądarka | Silnik renderowania | Silnik JS | Rynek |
|---|---|---|---|
| **Chrome** | Blink | V8 | ~65% |
| **Safari** | WebKit | JavaScriptCore | ~19% |
| **Edge** | Blink (nowy) / EdgeHTML (stary) | V8 | ~4% |
| **Firefox** | Gecko | SpiderMonkey | ~3% |
| **Opera** | Blink | V8 | ~2% |

### Różnice renderowania - typowe problemy
- **CSS Grid / Flexbox** - różnice w starszych przeglądarkach
- **CSS Variables** - IE 11 nie obsługuje
- **WebP** - IE, starszy Safari nie obsługuje
- **CSS Animations** - różne prefiksy (`-webkit-`, `-moz-`)
- **JavaScript ES6+** - starszy IE nie obsługuje arrow functions, let/const
- **Fetch API** - IE nie obsługuje (potrzebny polyfill)

### Prefiksy CSS (vendor prefixes)
```css
/* Historyczne prefiksy - dziś rzadko potrzebne */
-webkit-transform: rotate(45deg); /* Chrome, Safari, iOS */
-moz-transform: rotate(45deg);    /* Firefox */
-ms-transform: rotate(45deg);     /* Internet Explorer */
-o-transform: rotate(45deg);      /* Opera stara */
transform: rotate(45deg);         /* Standard - zawsze na końcu */
```

---

## 2. Narzędzia DevTools (F12)

### Zakładka Elements (Inspektor)
- Przeglądanie i edycja HTML/CSS w czasie rzeczywistym
- Style obliczone (computed styles)
- Model pudełkowy (box model) - wizualizacja margin/padding/border
- Event listeners - jakie zdarzenia są podpięte do elementu

### Zakładka Console
- Wykonywanie JavaScript
- Wyświetlanie błędów i ostrzeżeń
- `console.log()` - wyświetlanie wartości
- `console.error()` - błędy
- `console.warn()` - ostrzeżenia
- `console.table()` - dane tabelaryczne

### Zakładka Network
- Śledzenie wszystkich żądań HTTP
- Czas ładowania każdego zasobu
- Statusy HTTP (200, 301, 404, 500)
- Podgląd nagłówków żądań/odpowiedzi
- Waterfall chart - kolejność ładowania zasobów
- Filtrowanie: XHR, JS, CSS, Img, Media, Font

### Zakładka Performance
- Nagrywanie wydajności strony
- Czas renderowania, scripting, painting
- FPS (frames per second)
- CPU/Memory usage
- Identyfikacja wąskich gardeł

### Zakładka Lighthouse
- Audyt wydajności, SEO, dostępności, PWA
- Wynik 0-100 w każdej kategorii
- Konkretne zalecenia do poprawy
- Symulacja wolnych połączeń

### Zakładka Application
- LocalStorage, SessionStorage, Cookies
- Cache API (Service Workers)
- IndexedDB

---

## 3. Responsywność

### Breakpoints (punkty przełamania)
```css
/* Bootstrap 5 breakpoints (popularny standard) */
/* xs: 0px   - smartfony pionowo */
/* sm: 576px - smartfony poziomo */
/* md: 768px - tablety */
/* lg: 992px - laptopy */
/* xl: 1200px - duże ekrany */
/* xxl: 1400px - bardzo duże */

/* Przykłady media queries */
@media (max-width: 767px) {
  /* Mobile first - dla małych ekranów */
  .container { padding: 0 15px; }
}

@media (min-width: 768px) and (max-width: 991px) {
  /* Tablety */
  .container { max-width: 720px; }
}

@media (min-width: 992px) {
  /* Desktopy */
  .container { max-width: 960px; }
}
```

### Device Emulation w DevTools
1. Otwórz DevTools (F12)
2. Kliknij ikonę urządzenia (Toggle Device Toolbar) lub Ctrl+Shift+M
3. Wybierz urządzenie z listy lub ustaw własne wymiary
4. Testuj responsywność bez prawdziwego urządzenia

### Real Device Testing
- Połącz telefon z PC przez USB
- Chrome DevTools → Remote Devices
- Możliwe inspekcja strony z telefonu przez DevTools na PC
- Dostęp do localhost: `adb reverse tcp:3000 tcp:3000`

---

## 4. Walidacja HTML

### W3C Markup Validation Service
- URL: **validator.w3.org**
- Sprawdza poprawność HTML według specyfikacji
- Metody: URL, upload pliku, wklejenie kodu

### Typowe błędy HTML
```html
<!-- BŁĄD: Brak DOCTYPE -->
<!-- Poprawnie: -->
<!DOCTYPE html>

<!-- BŁĄD: Brakujący atrybut alt -->
<img src="foto.jpg">
<!-- Poprawnie: -->
<img src="foto.jpg" alt="Opis zdjęcia">

<!-- BŁĄD: Niezamknięty tag -->
<p>Treść
<!-- Poprawnie: -->
<p>Treść</p>

<!-- BŁĄD: Zagnieżdżenie inline w block (w HTML4) -->
<span><p>tekst</p></span>
<!-- Poprawnie: -->
<p><span>tekst</span></p>

<!-- BŁĄD: Duplikat ID -->
<div id="menu">...</div>
<div id="menu">...</div>
<!-- ID musi być unikalne! -->

<!-- BŁĄD: Nieprawidłowa wartość atrybutu -->
<input type="checkbox" checked="yes">
<!-- Poprawnie: -->
<input type="checkbox" checked>

<!-- BŁĄD: Brak lang w html -->
<html>
<!-- Poprawnie: -->
<html lang="pl">

<!-- BŁĄD: Bezpośredni tekst w <head> -->
<head>Tekst</head>
<!-- Poprawnie: tekst tylko w <body> -->
```

---

## 5. Walidacja CSS

### W3C CSS Validation Service
- URL: **jigsaw.w3.org/css-validator/**
- Sprawdza poprawność CSS
- Metody: URL, upload, wklejenie kodu

### Typowe błędy CSS
```css
/* BŁĄD: Nieznana właściwość */
div { colour: red; }    /* Literówka! */
div { color: red; }     /* Poprawnie */

/* BŁĄD: Nieprawidłowa wartość */
div { width: 100px 50px; }   /* Width przyjmuje jedną wartość */
div { width: 100px; }        /* Poprawnie */

/* BŁĄD: Brak jednostki */
div { margin: 10; }       /* Brak px/em/rem/% */
div { margin: 10px; }     /* Poprawnie */

/* UWAGA: margin: 0 nie wymaga jednostki (zero jest zero) */
div { margin: 0; }        /* Poprawnie */
```

---

## 6. SEO (Search Engine Optimization)

### Meta tagi
```html
<head>
  <!-- Tytuł strony (SEO title) - 50-60 znaków -->
  <title>Sklep z butami - Najlepsze ceny | NazwaSklepu.pl</title>

  <!-- Meta description - 150-160 znaków -->
  <meta name="description" content="Kupuj buty online w najlepszych cenach. Szeroki wybór marek. Darmowa dostawa od 200 zł. Sprawdź teraz!">

  <!-- Słowa kluczowe (mniejsze znaczenie dla SEO) -->
  <meta name="keywords" content="buty, obuwie, sklep z butami">

  <!-- Robots - indeksowanie -->
  <meta name="robots" content="index, follow">     <!-- Domyślne -->
  <meta name="robots" content="noindex, nofollow"> <!-- Nie indeksuj -->
  <meta name="robots" content="noindex, follow">   <!-- Nie indeksuj, ale śledź linki -->

  <!-- Viewport (konieczny dla responsywności) -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Charset -->
  <meta charset="UTF-8">

  <!-- Canonical - unikanie duplikacji treści -->
  <link rel="canonical" href="https://example.com/buty/">
</head>
```

### OpenGraph (og:) - Social Media
```html
<!-- Meta tagi OpenGraph - jak strona wygląda po udostępnieniu -->
<meta property="og:title" content="Sklep z butami - Najlepsze ceny">
<meta property="og:description" content="Kupuj buty online...">
<meta property="og:image" content="https://example.com/share-image.jpg">
<meta property="og:url" content="https://example.com/buty/">
<meta property="og:type" content="website">
<meta property="og:site_name" content="NazwaSklepu.pl">
<meta property="og:locale" content="pl_PL">

<!-- Twitter Cards -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Sklep z butami">
<meta name="twitter:description" content="Kupuj buty online...">
<meta name="twitter:image" content="https://example.com/share.jpg">
```

### Strukturalne dane (Schema.org / JSON-LD)
```html
<!-- Dane strukturalne - pomaga wyszukiwarkom rozumieć treść -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": "Buty sportowe Nike Air Max",
  "description": "Wygodne buty do biegania",
  "price": "299.99",
  "priceCurrency": "PLN",
  "image": "https://example.com/buty.jpg",
  "brand": {
    "@type": "Brand",
    "name": "Nike"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.5",
    "reviewCount": "127"
  }
}
</script>

<!-- Organization Schema -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Firma XYZ",
  "url": "https://example.com",
  "telephone": "+48 123 456 789",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "ul. Przykładowa 1",
    "addressLocality": "Warszawa",
    "postalCode": "00-001",
    "addressCountry": "PL"
  }
}
</script>
```

### Core Web Vitals (Google)
| Metryka | Co mierzy | Dobra wartość |
|---|---|---|
| **LCP** (Largest Contentful Paint) | Czas ładowania największego elementu | < 2.5 s |
| **FID** (First Input Delay) | Opóźnienie pierwszej interakcji | < 100 ms |
| **CLS** (Cumulative Layout Shift) | Nieoczekiwane przesunięcia layoutu | < 0.1 |
| **INP** (Interaction to Next Paint) | Responsywność (zastępuje FID) | < 200 ms |
| **FCP** (First Contentful Paint) | Pierwszy renderowany element | < 1.8 s |
| **TTFB** (Time to First Byte) | Czas odpowiedzi serwera | < 0.8 s |

---

## 7. Pozycjonowanie SEO

### On-page SEO (czynniki na stronie)
- **Tytuł strony** (title tag) - najważniejszy czynnik on-page
- **Meta description** - wpływa na CTR, nie na pozycję
- **Nagłówki** (H1-H6) - H1 jedno na stronę, z głównym słowem kluczowym
- **Treść** - wartościowa, unikalna, długa
- **Słowa kluczowe** - naturalne użycie w treści
- **URL** - krótkie, opisowe, z słowem kluczowym
- **Alt obrazów** - opisy alternatywne
- **Linki wewnętrzne** - powiązanie stron
- **Szybkość strony** - Core Web Vitals
- **Mobile-friendly** - responsywność
- **HTTPS** - szyfrowanie

### Off-page SEO (czynniki poza stroną)
- **Linki przychodzące (backlinks)** - linki z innych stron
- **Jakość linków** - autorytety (Wikipedia, .gov, .edu)
- **Anchor text** - tekst linku
- **Social signals** - udostępnienia w mediach społecznościowych
- **Brand mentions** - wzmianki o marce
- **Link building** - zdobywanie linków (guest posting, katalogi)

### Słowa kluczowe
- **Long-tail** - długie frazy, mniejsza konkurencja ("buty do biegania dla kobiet")
- **Short-tail** - krótkie frazy, duża konkurencja ("buty")
- **Narzędzia**: Google Search Console, Google Trends, Ahrefs, SEMrush

---

## 8. Wydajność stron (Performance)

### PageSpeed Insights
- URL: **pagespeed.web.dev**
- Analiza wydajności strony
- Wynik 0-100 (Mobile i Desktop)
- Sugestie optymalizacji
- Na bazie Lighthouse

### Minifikacja (Minification)
```html
<!-- Oryginalny CSS -->
.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 15px;
}

/* Minified CSS */
.container{max-width:1200px;margin:0 auto;padding:0 15px;}
```

```javascript
// Oryginalny JS
function calculateSum(a, b) {
  return a + b;
}

// Minified JS
function calculateSum(a,b){return a+b;}

// Uglified (zaciemniony)
function c(a,b){return a+b;}
```

### Narzędzia do minifikacji
- **CSS**: cssnano, CleanCSS
- **JS**: UglifyJS, Terser
- **HTML**: html-minifier
- **Bundlery**: Webpack, Vite, Parcel (automatyczna minifikacja)

### Lazy Loading
```html
<!-- Obrazy -->
<img src="foto.jpg" alt="Opis" loading="lazy">

<!-- Iframe -->
<iframe src="mapa.html" loading="lazy"></iframe>
```

### Inne techniki optymalizacji
- **CDN** (Content Delivery Network) - serwowanie plików z serwerów bliskich użytkownikowi
- **Caching** - pamięć podręczna przeglądarki i serwera
- **Kompresja gzip/Brotli** - kompresja plików przesyłanych przez serwer
- **WebP** - mniejsze obrazy niż JPEG/PNG
- **HTTP/2** - równoległe ładowanie zasobów
- **Critical CSS** - inline najważniejszy CSS w `<head>`
- **Preload** - wczytywanie ważnych zasobów z wyprzedzeniem

```html
<!-- Preload ważnych zasobów -->
<link rel="preload" href="styl.css" as="style">
<link rel="preload" href="hero.jpg" as="image">
<link rel="preload" href="font.woff2" as="font" type="font/woff2" crossorigin>

<!-- DNS prefetch dla zewnętrznych domen -->
<link rel="dns-prefetch" href="//fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
```

---

## 9. Dostępność WCAG 2.0 / 2.1

### Co to jest WCAG?
- **Web Content Accessibility Guidelines**
- Wytyczne dostępności treści internetowych
- Opracowane przez W3C
- Standard prawny w wielu krajach

### Zasady POUR
| Zasada | Opis |
|---|---|
| **P - Perceivable (Postrzegalny)** | Informacje muszą być dostępne dla zmysłów użytkownika |
| **O - Operable (Funkcjonalny)** | Interfejs musi być obsługiwalny (też klawiaturą) |
| **U - Understandable (Zrozumiały)** | Treść i działanie muszą być zrozumiałe |
| **R - Robust (Solidny)** | Treść musi działać z różnymi technologiami asystującymi |

### Poziomy zgodności
| Poziom | Opis | Wymaganie |
|---|---|---|
| **A** (minimalne) | Podstawowe wymagania dostępności | Absolutne minimum |
| **AA** (standardowe) | Standardowy poziom dla większości stron | Zazwyczaj wymagany prawnie |
| **AAA** (najwyższy) | Najwyższy poziom dostępności | Trudny do osiągnięcia na wszystkich stronach |

### Kluczowe wymagania WCAG - praktyczne przykłady

#### Perceivable (Postrzegalny)
```html
<!-- Alt dla obrazów -->
<img src="logo.png" alt="Logo firmy ABC">
<img src="dekoracja.png" alt="">  <!-- Dekoracyjny = pusty alt -->

<!-- Transkrypt/napisy dla mediów -->
<video controls>
  <source src="film.mp4" type="video/mp4">
  <track src="napisy.vtt" kind="subtitles" srclang="pl" label="Polski">
</video>

<!-- Kontrast kolorów - minimum 4.5:1 dla tekstu normalnego -->
/* Dobry kontrast */
body { color: #333333; background: #ffffff; } /* kontrast 12.6:1 */

/* Zły kontrast */
body { color: #888888; background: #ffffff; } /* kontrast 3.5:1 - zbyt mały */
```

#### Operable (Funkcjonalny)
```html
<!-- Nawigacja klawiaturą - focus visible -->
<style>
  :focus {
    outline: 3px solid #005fcc;
    outline-offset: 2px;
  }
  /* NIGDY nie usuwaj :focus bez alternatywy! */
</style>

<!-- Skip navigation link - pomijanie nawigacji -->
<a href="#main-content" class="skip-link">Przejdź do treści</a>
<nav>...</nav>
<main id="main-content">...</main>

<!-- Odpowiednie etykiety dla interaktywnych elementów -->
<button type="button">Zamknij</button>  <!-- Nie: <div onclick="..."> -->
```

#### Understandable (Zrozumiały)
```html
<!-- Język strony -->
<html lang="pl">

<!-- Etykiety formularzy -->
<label for="email">Adres e-mail:</label>
<input type="email" id="email" name="email">

<!-- Komunikaty błędów -->
<input type="email" aria-describedby="email-error">
<p id="email-error" role="alert">Podaj prawidłowy adres e-mail.</p>

<!-- Aria labels dla elementów bez widocznego tekstu -->
<button aria-label="Zamknij modal"><svg>...</svg></button>
```

#### Robust (Solidny)
```html
<!-- Semantyczny HTML -->
<header>...</header>
<nav>...</nav>
<main>...</main>
<article>...</article>
<aside>...</aside>
<footer>...</footer>

<!-- ARIA role gdy semantyczny HTML niedostępny -->
<div role="navigation" aria-label="Nawigacja główna">...</div>
<div role="main">...</div>
<div role="button" tabindex="0">Kliknij</div>
```

### Atrybuty ARIA (Accessible Rich Internet Applications)
```html
<!-- role - określa rolę elementu -->
<div role="alert">Błąd: Hasło jest za krótkie!</div>
<div role="dialog" aria-labelledby="dialog-title">
  <h2 id="dialog-title">Tytuł dialogu</h2>
</div>

<!-- aria-label - niewidoczna etykieta -->
<button aria-label="Zamknij okno">X</button>

<!-- aria-labelledby - etykieta przez ID -->
<div aria-labelledby="sekcja-title">
  <h2 id="sekcja-title">Moja sekcja</h2>
</div>

<!-- aria-describedby - dodatkowy opis -->
<input aria-describedby="wskazowka">
<p id="wskazowka">Podaj min. 8 znaków.</p>

<!-- aria-hidden - ukrycie przed screen readerami -->
<span aria-hidden="true">★</span>

<!-- aria-expanded - stan rozwinięcia -->
<button aria-expanded="false" aria-controls="menu">Menu</button>
<ul id="menu" hidden>...</ul>

<!-- aria-live - dynamicznie aktualizowane regiony -->
<div aria-live="polite">Ładowanie wyników...</div>
<div aria-live="assertive">Błąd! Spróbuj ponownie.</div>
```

---

## 10. Narzędzia testowania

### Testowanie kompatybilności
| Narzędzie | Opis |
|---|---|
| **BrowserStack** | Testowanie na prawdziwych urządzeniach/przeglądarkach w chmurze |
| **CrossBrowserTesting** | Podobne do BrowserStack |
| **Sauce Labs** | Automatyczne testy na wielu platformach |
| **LambdaTest** | Cross-browser testing |

### Testowanie automatyczne
| Narzędzie | Opis |
|---|---|
| **Selenium** | Automatyzacja przeglądarki, testy end-to-end |
| **Playwright** | Nowoczesny Selenium, Google/Microsoft |
| **Cypress** | E2E testing, popularny frontend |
| **Jest** | Unit testing dla JavaScript |
| **Puppeteer** | Headless Chrome automation (Google) |

### Audyty wydajności i dostępności
| Narzędzie | Opis |
|---|---|
| **Lighthouse** | Wbudowany w Chrome DevTools, PageSpeed Insights |
| **axe** | Testowanie dostępności (rozszerzenie, CLI) |
| **WAVE** | Wave.webaim.org - walidacja dostępności |
| **GTmetrix** | Analiza wydajności |
| **WebPageTest** | Zaawansowana analiza wydajności |

### Walidacja kodu
| Narzędzie | URL |
|---|---|
| **HTML** | validator.w3.org |
| **CSS** | jigsaw.w3.org/css-validator |
| **Links** | validator.w3.org/checklink |
| **JSON** | jsonlint.com |
| **RSS/Atom** | validator.w3.org/feed |

### Selenium - przykład testu
```python
from selenium import webdriver
from selenium.webdriver.common.by import By

# Inicjalizacja przeglądarki
driver = webdriver.Chrome()

# Otwórz stronę
driver.get("https://example.com")

# Znajdź element i kliknij
button = driver.find_element(By.ID, "submit-button")
button.click()

# Sprawdź tytuł strony
assert "Sukces" in driver.title

# Zamknij przeglądarkę
driver.quit()
```

---

## PODSUMOWANIE DO EGZAMINU

### Najważniejsze fakty:
1. **Chrome** = Blink + V8; **Firefox** = Gecko + SpiderMonkey; **Safari** = WebKit
2. **DevTools F12** = Elements, Console, Network, Performance, Lighthouse
3. **validator.w3.org** = walidacja HTML; **jigsaw.w3.org/css-validator** = CSS
4. **Meta title** = 50-60 znaków (kluczowe dla SEO)
5. **Meta description** = 150-160 znaków (wpływa na CTR)
6. **og:title, og:image, og:description** = OpenGraph dla social media
7. **LCP** < 2.5s, **FID** < 100ms, **CLS** < 0.1 (Core Web Vitals)
8. **On-page SEO**: tytuł, nagłówki, treść, URL, alt; **Off-page**: backlinks
9. **WCAG 2.0** poziomy: **A** (minimum), **AA** (standard), **AAA** (max)
10. **POUR** = Perceivable, Operable, Understandable, Robust
11. `alt=""` = pusty alt dla obrazów dekoracyjnych
12. `lang="pl"` = wymagane na `<html>` dla dostępności
13. `:focus` = nigdy nie usuwaj bez alternatywy (dostępność klawiaturą)
14. `aria-label`, `aria-labelledby`, `aria-hidden`, `role` = atrybuty ARIA
15. `loading="lazy"` = lazy loading obrazów HTML5
16. **Lighthouse** = audyt wydajności/SEO/dostępności (wbudowany w Chrome)
17. **BrowserStack** = testowanie na prawdziwych urządzeniach w chmurze
18. **Selenium/Playwright/Cypress** = automatyczne testy E2E
19. Kontrast tekstu: minimum **4.5:1** (AA), 7:1 (AAA) dla tekstu normalnego
20. **Skip navigation link** = pomijanie nawigacji (dla klawiaturzystów/czytników ekranu)
