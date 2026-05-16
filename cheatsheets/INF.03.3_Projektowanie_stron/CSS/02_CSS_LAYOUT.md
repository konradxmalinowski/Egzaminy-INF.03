# CSS Layout - Float, Flexbox, Grid, Pozycjonowanie

> Ściągawka do egzaminu INF.03 - INF.03.3 Projektowanie stron WWW

---

## 1. FLOAT LAYOUT (WAŻNE - używane w egzaminach!)

Float to starszy mechanizm layoutu, ale **nadal pojawia się w zadaniach egzaminacyjnych INF.03**.
Zdający musi umieć zbudować układ kolumnowy (aside + main + section) przy użyciu float.

### Podstawowe właściwości float

| Właściwość     | Wartość       | Opis                                      |
|----------------|---------------|-------------------------------------------|
| `float`        | `left`        | Element "płynie" do lewej                 |
| `float`        | `right`       | Element "płynie" do prawej                |
| `float`        | `none`        | Brak float (domyślnie)                    |
| `clear`        | `left`        | Blokuje float z lewej strony              |
| `clear`        | `right`       | Blokuje float z prawej strony             |
| `clear`        | `both`        | Blokuje float z obu stron (najczęstsze)   |

### Typowy layout egzaminacyjny - 3 kolumny

```css
/* WZORZEC Z EGZAMINU - zapamiętaj! */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: Arial, sans-serif;
}

header {
    background-color: #333;
    color: white;
    padding: 10px;
}

aside {
    float: left;
    width: 20%;
    background-color: #f0f0f0;
    padding: 10px;
    min-height: 400px;
}

main {
    float: left;
    width: 60%;
    padding: 10px;
    min-height: 400px;
}

section {
    float: left;
    width: 20%;
    background-color: #e0e0e0;
    padding: 10px;
    min-height: 400px;
}

footer {
    clear: both;        /* <-- KLUCZOWE! Bez tego footer "wejdzie" pod kolumny */
    background-color: #333;
    color: white;
    padding: 10px;
    text-align: center;
}
```

### HTML do powyższego layoutu

```html
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styl.css">
    <title>Layout z float</title>
</head>
<body>
    <header>Nagłówek strony</header>
    <aside>Lewy panel</aside>
    <main>Główna treść</main>
    <section>Prawy panel</section>
    <footer>Stopka strony</footer>
</body>
</html>
```

### Clearfix - rozwiązanie problemu zwijania rodzica

Gdy dzieci mają `float`, rodzic "nie widzi" ich wysokości i zwija się do zera.

```css
/* Metoda 1 - pseudo-element (najlepsza) */
.clearfix::after {
    content: "";
    display: table;
    clear: both;
}

/* Metoda 2 - dodatkowy element HTML */
/* W HTML dodaj: <div class="clear-both"></div> */
.clear-both {
    clear: both;
}

/* Metoda 3 - overflow (stara metoda) */
.container {
    overflow: hidden;
}
```

### Layout 2-kolumnowy z float

```css
.lewy {
    float: left;
    width: 30%;
}

.prawy {
    float: right;
    width: 68%;       /* margin między kolumnami = 2% */
}

.stopka {
    clear: both;
}
```

---

## 2. FLEXBOX (nowoczesny layout)

Flexbox działa na osi głównej (main axis) i poprzecznej (cross axis).

### Właściwości kontenera (rodzica)

```css
.kontener {
    display: flex;

    /* Kierunek osi głównej */
    flex-direction: row;            /* → (domyślnie) */
    flex-direction: row-reverse;    /* ← */
    flex-direction: column;         /* ↓ */
    flex-direction: column-reverse; /* ↑ */

    /* Zawijanie elementów */
    flex-wrap: nowrap;              /* domyślnie - bez zawijania */
    flex-wrap: wrap;                /* zawija do nowych wierszy */
    flex-wrap: wrap-reverse;        /* zawija w górę */

    /* Skrót: direction + wrap */
    flex-flow: row wrap;

    /* Wyrównanie wzdłuż osi głównej */
    justify-content: flex-start;    /* elementy na początku */
    justify-content: flex-end;      /* elementy na końcu */
    justify-content: center;        /* elementy pośrodku */
    justify-content: space-between; /* równe odstępy między */
    justify-content: space-around;  /* odstępy wokół każdego */
    justify-content: space-evenly;  /* identyczne odstępy */

    /* Wyrównanie wzdłuż osi poprzecznej */
    align-items: stretch;           /* rozciąga (domyślnie) */
    align-items: flex-start;        /* przy początku osi */
    align-items: flex-end;          /* przy końcu osi */
    align-items: center;            /* pośrodku osi */
    align-items: baseline;          /* według linii bazowej tekstu */

    /* Wyrównanie wielu wierszy */
    align-content: flex-start;
    align-content: center;
    align-content: space-between;

    /* Odstępy (nowoczesne) */
    gap: 10px;                      /* gap między wierszami i kolumnami */
    gap: 10px 20px;                 /* row-gap column-gap */
    row-gap: 10px;
    column-gap: 20px;
}
```

### Właściwości elementów flex (dzieci)

```css
.element {
    /* Wzrost - jak bardzo element może rosnąć */
    flex-grow: 0;               /* domyślnie - nie rośnie */
    flex-grow: 1;               /* rośnie proporcjonalnie */
    flex-grow: 2;               /* rośnie 2x szybciej niż flex-grow: 1 */

    /* Kurczenie - jak bardzo element może się kurczyć */
    flex-shrink: 1;             /* domyślnie - kurczy się proporcjonalnie */
    flex-shrink: 0;             /* nie kurczy się nigdy */

    /* Podstawowy rozmiar przed wzrostem/kurczeniem */
    flex-basis: auto;           /* domyślnie - rozmiar z width/height */
    flex-basis: 200px;          /* min. 200px */
    flex-basis: 30%;            /* 30% kontenera */
    flex-basis: 0;              /* zaczyna od 0, rośnie z flex-grow */

    /* Skrót: grow shrink basis */
    flex: 1;                    /* flex: 1 1 0% */
    flex: 1 1 auto;
    flex: 0 0 200px;            /* stały rozmiar 200px */
    flex: auto;                 /* flex: 1 1 auto */
    flex: none;                 /* flex: 0 0 auto */

    /* Kolejność wyświetlania */
    order: 0;                   /* domyślnie */
    order: -1;                  /* przesuwa na początek */
    order: 2;                   /* przesuwa za elementy z order: 1 */

    /* Wyrównanie indywidualne (nadpisuje align-items) */
    align-self: auto;
    align-self: flex-start;
    align-self: flex-end;
    align-self: center;
    align-self: stretch;
}
```

### Przykłady praktyczne - Flexbox

```css
/* Navbar poziomy */
nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background: #333;
}

/* Kafelki kart - automatyczne zawijanie */
.karty {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.karta {
    flex: 0 0 calc(33.333% - 20px); /* 3 kolumny */
}

/* Idealne wycentrowanie elementu */
.wycentruj {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

/* Sidebar layout z flex */
.strona {
    display: flex;
    min-height: 100vh;
}

.sidebar {
    flex: 0 0 250px;    /* stały sidebar 250px */
}

.tresc {
    flex: 1;            /* reszta przestrzeni */
}
```

---

## 3. CSS GRID

Grid działa w dwóch wymiarach jednocześnie (wiersze I kolumny).

### Właściwości kontenera Grid

```css
.siatka {
    display: grid;

    /* Definiowanie kolumn */
    grid-template-columns: 200px 1fr 200px;        /* 3 kolumny */
    grid-template-columns: repeat(3, 1fr);          /* 3 równe kolumny */
    grid-template-columns: repeat(4, minmax(200px, 1fr)); /* elastyczne */
    grid-template-columns: auto 1fr auto;           /* auto = szerokość treści */

    /* Definiowanie wierszy */
    grid-template-rows: 80px 1fr 60px;
    grid-template-rows: auto;                       /* auto-dopasowanie */
    grid-auto-rows: minmax(100px, auto);            /* dla dynamicznych wierszy */

    /* Odstępy */
    gap: 20px;
    gap: 10px 20px;     /* row-gap column-gap */
    row-gap: 10px;
    column-gap: 20px;

    /* Wyrównanie komórek w obszarze */
    justify-items: start | end | center | stretch;
    align-items: start | end | center | stretch;

    /* Wyrównanie całej siatki w kontenerze */
    justify-content: start | end | center | space-between;
    align-content: start | end | center | space-between;
}
```

### Jednostka fr i funkcje

```css
/* fr = fraction (ułamek dostępnej przestrzeni) */
grid-template-columns: 1fr 2fr 1fr;
/* kolumna 1: 25%, kolumna 2: 50%, kolumna 3: 25% */

/* repeat(ilość, rozmiar) */
grid-template-columns: repeat(12, 1fr);         /* 12-kolumnowa siatka */
grid-template-columns: repeat(auto-fill, 200px); /* tyle ile się mieści */
grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* responsywny! */

/* minmax(min, max) */
grid-template-columns: minmax(100px, 300px) 1fr;
```

### Rozmieszczanie elementów (dzieci)

```css
.element {
    /* Kolumna: od linii / do linii */
    grid-column: 1 / 3;             /* od linii 1 do 3 (2 kolumny) */
    grid-column: 1 / -1;            /* od początku do końca (cała szerokość) */
    grid-column: span 2;            /* zajmuje 2 kolumny (od aktualnej pozycji) */

    /* Wiersz: od linii / do linii */
    grid-row: 1 / 3;
    grid-row: span 2;

    /* Skrót: row-start / column-start / row-end / column-end */
    grid-area: 1 / 1 / 3 / 4;

    /* Wyrównanie indywidualne */
    justify-self: start | end | center | stretch;
    align-self: start | end | center | stretch;
}
```

### Named Grid Areas (nazywane obszary)

```css
/* Layout strony z named areas */
.strona {
    display: grid;
    grid-template-columns: 200px 1fr 150px;
    grid-template-rows: auto 1fr auto;
    grid-template-areas:
        "header  header  header"
        "sidebar content reklama"
        "footer  footer  footer";
    min-height: 100vh;
    gap: 10px;
}

.naglowek { grid-area: header; }
.pasek    { grid-area: sidebar; }
.tresc    { grid-area: content; }
.reklama  { grid-area: reklama; }
.stopka   { grid-area: footer; }
```

### Przykład - galeria zdjęć

```css
.galeria {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 15px;
}

.galeria img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

/* Wyróżnione zdjęcie zajmuje 2 kolumny i 2 wiersze */
.galeria .wyroznienie {
    grid-column: span 2;
    grid-row: span 2;
}
```

---

## 4. POZYCJONOWANIE (position)

### Wartości właściwości position

| Wartość    | Opis                                                          | Odniesienie       |
|------------|---------------------------------------------------------------|-------------------|
| `static`   | Domyślne - w normalnym przepływie dokumentu                   | brak              |
| `relative` | Przesuwa względem swojej normalnej pozycji                    | własna pozycja    |
| `absolute` | Wyrwany z przepływu, pozycjonowany względem rodzica           | pozycjonowany rodzic |
| `fixed`    | Wyrwany z przepływu, stały względem okna przeglądarki         | okno (viewport)   |
| `sticky`   | Zachowuje się jak `relative`, "klei się" po scrollowaniu      | okno + przepływ   |

```css
/* RELATIVE - przesuwa względem normalnej pozycji */
.box {
    position: relative;
    top: 20px;      /* przesuwa w dół o 20px */
    left: 30px;     /* przesuwa w prawo o 30px */
}

/* ABSOLUTE - pozycjonowany względem najbliższego
   rodzica z position: relative/absolute/fixed */
.rodzic {
    position: relative;     /* tworzy kontekst dla absolute */
}

.dziecko {
    position: absolute;
    top: 0;
    right: 0;       /* prawy górny róg rodzica */
}

/* FIXED - zawsze widoczny, niezależnie od scrollowania */
.naglowek-sticky {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 100;
}

/* STICKY - "klei się" po osiągnięciu progu */
nav {
    position: sticky;
    top: 0;         /* klei się gdy dojdzie do góry okna */
    z-index: 50;
}
```

### z-index - kolejność warstw

```css
/* Wyższy z-index = "bliżej" użytkownika */
.tlo        { z-index: 0; }
.tresc      { z-index: 10; }
.modal      { z-index: 100; }
.tooltip    { z-index: 200; }
.naglowek   { z-index: 50; }

/* UWAGA: z-index działa tylko na elementach z position != static */
```

### Wyśrodkowanie z position: absolute

```css
/* Klasyczne centrowanie absolutne */
.wycentrowany {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
```

---

## 5. RESPONSIVE DESIGN

### Media queries - breakpointy

```css
/* Mobile-first: piszemy style dla mobile, potem nadpisujemy dla większych */
/* DOMYŚLNIE: mobile (< 480px) */

/* Small - telefony poziomo */
@media (min-width: 480px) {
    /* style dla >= 480px */
}

/* Medium - tablety */
@media (min-width: 768px) {
    /* style dla >= 768px */
}

/* Large - małe laptopy */
@media (min-width: 1024px) {
    /* style dla >= 1024px */
}

/* Extra Large - duże monitory */
@media (min-width: 1280px) {
    /* style dla >= 1280px */
}

/* Desktop-first: piszemy style dla desktopa, potem dla mniejszych */
@media (max-width: 1024px) { /* ... */ }
@media (max-width: 768px)  { /* ... */ }
@media (max-width: 480px)  { /* ... */ }
```

### Przykład responsive - float do flex

```css
/* Mobile: elementy w kolumnie */
aside, main, section {
    width: 100%;
    float: none;
    display: block;
}

/* Tablet i wyżej: layout z float */
@media (min-width: 768px) {
    aside {
        float: left;
        width: 25%;
    }

    main {
        float: left;
        width: 50%;
    }

    section {
        float: left;
        width: 25%;
    }

    footer {
        clear: both;
    }
}
```

### Jednostki CSS

| Jednostka | Typ      | Opis                                          | Przykład          |
|-----------|----------|-----------------------------------------------|-------------------|
| `px`      | absolutna| Piksele ekranu                                | `font-size: 16px` |
| `%`       | względna | Procent rodzica                               | `width: 50%`      |
| `em`      | względna | Względem font-size elementu (kaskaduje!)      | `padding: 1.5em`  |
| `rem`     | względna | Względem font-size roota (html) - STABILNA    | `font-size: 1rem` |
| `vw`      | viewport | 1% szerokości okna                            | `width: 100vw`    |
| `vh`      | viewport | 1% wysokości okna                             | `height: 100vh`   |
| `vmin`    | viewport | 1% mniejszego wymiaru okna                    | `font-size: 5vmin`|
| `vmax`    | viewport | 1% większego wymiaru okna                     | `width: 50vmax`   |

### Fluid Typography z clamp()

```css
/* clamp(min, preferowana, max) */
h1 {
    font-size: clamp(1.5rem, 4vw, 3rem);
    /* min: 1.5rem, preferowana: 4vw, max: 3rem */
}

p {
    font-size: clamp(1rem, 2.5vw, 1.25rem);
}

.kontener {
    width: clamp(320px, 90%, 1200px);
    margin: 0 auto;
}
```

---

## 6. DODATKOWE TECHNIKI LAYOUTU

### Wyśrodkowanie bloku (classic)

```css
/* Wyśrodkowanie bloku w poziomie */
.kontener {
    max-width: 1200px;
    margin: 0 auto;         /* auto z obu stron = wyśrodkowanie */
}

/* Wyśrodkowanie tekstu */
.tekst {
    text-align: center;
}
```

### Box-sizing (ważne dla layoutu!)

```css
/* Domyślnie width nie uwzględnia padding i border */
/* box-sizing: content-box - width = tylko treść */
/* box-sizing: border-box  - width = treść + padding + border */

/* ZAWSZE UŻYWAJ TEGO RESETU! */
*, *::before, *::after {
    box-sizing: border-box;
}
```

### Display podstawowe wartości

```css
.element {
    display: block;         /* blokowy - zajmuje całą szerokość */
    display: inline;        /* liniowy - nie można ustawić width/height */
    display: inline-block;  /* liniowy ALE można ustawić wymiary */
    display: none;          /* ukrywa element (nie zajmuje miejsca) */
    display: flex;          /* flexbox */
    display: grid;          /* grid */
}
```

---

## 7. PODSUMOWANIE DO EGZAMINU

### Najczęstsze zadania layoutowe w INF.03

1. **Layout 3-kolumnowy** - aside (20%) + main (60%) + section (20%) z `float: left` i `clear: both` na footer
2. **Navbar poziomy** - `float: left` na `li`, lub `display: inline-block`
3. **Wyśrodkowanie bloku** - `margin: 0 auto` + `max-width`
4. **Responsywny layout** - `@media` queries zmieniające float na block

### Schemat szybkiego pisania layoutu egzaminacyjnego

```css
/* 1. Reset */
* { box-sizing: border-box; margin: 0; padding: 0; }

/* 2. Float na kolumny */
aside  { float: left; width: 20%; }
main   { float: left; width: 60%; }
section{ float: left; width: 20%; }

/* 3. Clear na footer */
footer { clear: both; }
```

### Pułapki do unikania

- Zapomnienie o `clear: both` na footer powoduje że stopka "wchodzi" pod kolumny
- Szerokości kolumn muszą sumować sie do 100% (uwzgledniając padding i margin)
- `box-sizing: border-box` rozwiązuje problemy z szerokościami
- `z-index` działa tylko gdy element ma `position` != `static`
- `float` powinien mieć zadeklarowany `width`, inaczej może zachowywać się nieoczekiwanie

### Szybkie porównanie technik

| Technika   | Zastosowanie                        | Oś      | Wsparcie     |
|------------|-------------------------------------|---------|--------------|
| Float      | Stary standard, egzaminy INF.03     | 1D      | Wszędzie     |
| Flexbox    | Nawigacja, karty, wyrównanie        | 1D      | IE 11+       |
| Grid       | Kompleksowy layout strony           | 2D      | Nowoczesne   |
| Position   | Overlays, sticky header, tooltips   | -       | Wszędzie     |
