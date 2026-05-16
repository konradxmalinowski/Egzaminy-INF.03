# 🎨 ŚCIĄGAWKA: CSS - Selektory i Właściwości (INF.03.3)

---

## 1️⃣ RODZAJE SELEKTORÓW

### Selektor uniwersalny
```css
* {
    margin: 0;
    padding: 0;
}
```

### Selektor elementu
```css
h1 { color: blue; }
p { font-size: 14px; }
```

### Selektor klasy
```css
.btn { background: blue; }
.btn-primary { color: white; }
```

### Selektor ID
```css
#header { position: fixed; }
```

### Selektor atrybutu
```css
input[type="email"] { border: 1px solid red; }
a[href^="https"] { color: green; }  /* Zaczyna się na https */
a[href$=".pdf"] { color: red; }     /* Kończy się na .pdf */
img[alt*="logo"] { width: 100px; }  /* Zawiera "logo" */
```

### Selektor potomka
```css
div > p { color: red; }  /* Bezpośrednie dzieci */
div p { color: blue; }   /* Wszystkie p w div */
```

### Selektor siostry
```css
h1 + p { margin-top: 0; }     /* Następny element */
h1 ~ p { font-size: 14px; }   /* Wszystkie siostry */
```

### Kombinacje selektorów
```css
.header .nav a { color: white; }
#main article p.intro { font-size: 16px; }
button.btn:hover { background: darkblue; }
```

---

## 2️⃣ PSEUDO-KLASY I PSEUDO-ELEMENTY

### Pseudo-klasy (stan elementu)
```css
a:link { color: blue; }        /* Link nieodwiedzony */
a:visited { color: purple; }   /* Link odwiedzony */
a:hover { color: red; }        /* Najechanie myszą */
a:active { color: orange; }    /* Klik */
a:focus { outline: 2px blue; } /* Focus (klawiatura) */

button:disabled { opacity: 0.5; }
input:checked { border: 2px green; }

li:first-child { font-weight: bold; }
li:last-child { margin-bottom: 0; }
li:nth-child(2n) { background: #f0f0f0; }  /* Co drugi element */
li:nth-of-type(3) { color: red; }
```

### Pseudo-elementy (dodatkowe elementy)
```css
p::before { content: "▶ "; }       /* Przed zawartością */
p::after { content: " ✓"; }        /* Po zawartości */
p::first-line { font-weight: bold; }
p::first-letter { font-size: 2em; }
input::placeholder { color: gray; }
```

---

## 3️⃣ BOX MODEL

```css
div {
    /* Z zewnątrz na wewnątrz */
    margin: 20px;           /* Przestrzeń na zewnątrz */
    border: 2px solid black; /* Obramowanie */
    padding: 10px;          /* Przestrzeń wewnątrz */
    width: 300px;           /* Szerokość zawartości */
    height: 200px;          /* Wysokość zawartości */
    
    /* Shorthand */
    margin: 20px 10px;      /* top/bottom, left/right */
    margin: 10px 20px 10px 20px;  /* top, right, bottom, left */
    
    /* Box sizing */
    box-sizing: border-box; /* Szerokość zawiera border i padding */
}
```

---

## 4️⃣ DISPLAY PROPERTIES

```css
/* Block */
div { display: block; }           /* Pełna szerokość, nowy wiersz */

/* Inline */
span { display: inline; }         /* Szerokość zawartości, bez nowego wiersza */

/* Inline-block */
button { display: inline-block; } /* Inline, ale z box model */

/* Flexbox */
.container { 
    display: flex;
    justify-content: center;        /* Wyrównanie poziome */
    align-items: center;            /* Wyrównanie pionowe */
    flex-direction: row;            /* row, column */
    gap: 10px;                      /* Przestrzeń między elementami */
    flex-wrap: wrap;                /* Zawinięcie na następny wiersz */
}

/* Grid */
.grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;  /* 3 równe kolumny */
    grid-gap: 10px;
}

/* None */
.hidden { display: none; }  /* Całkowicie ukryte */
```

---

## 5️⃣ POZYCJONOWANIE

```css
div {
    position: static;      /* Normalne (domyślne) */
    position: relative;    /* Względem normalnej pozycji */
    position: absolute;    /* Względem rodzica (z position != static) */
    position: fixed;       /* Względem viewport'u */
    position: sticky;      /* Lepka - fixed gdy scrolluj */
    
    top: 10px;
    left: 20px;
    z-index: 100;  /* Warstwa (wyżej = na wierzchu) */
}
```

---

## 6️⃣ KOLORY I TŁO

```css
div {
    /* Kolory */
    color: red;                     /* Tekst */
    background-color: blue;         /* Tło */
    border-color: green;
    
    /* Formaty koloru */
    color: red;                     /* Nazwa */
    color: #FF0000;                 /* Hex */
    color: rgb(255, 0, 0);          /* RGB */
    color: rgba(255, 0, 0, 0.5);    /* RGBA (z przezroczystością) */
    color: hsl(0, 100%, 50%);       /* HSL */
    
    /* Tło */
    background-image: url('bg.jpg');
    background-size: cover;         /* Wypełnij całe tło */
    background-position: center;
    background-repeat: no-repeat;
    
    /* Gradient */
    background: linear-gradient(to right, red, blue);
    background: radial-gradient(circle, yellow, red);
    
    /* Opacity */
    opacity: 0.5;  /* 50% przezroczystości */
}
```

---

## 7️⃣ TYPOGRAPHY

```css
p {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 16px;              /* px, em, rem, % */
    font-weight: bold;            /* normal, bold, 100-900 */
    font-style: italic;           /* normal, italic */
    line-height: 1.5;             /* Wysokość linii */
    letter-spacing: 2px;          /* Odstęp między literami */
    word-spacing: 5px;            /* Odstęp między słowami */
    text-align: center;           /* left, right, center, justify */
    text-decoration: underline;   /* underline, overline, line-through */
    text-transform: uppercase;    /* uppercase, lowercase, capitalize */
    text-shadow: 2px 2px 4px gray;
    
    /* Web fonts */
    @import url('https://fonts.googleapis.com/css2?family=Roboto');
    font-family: 'Roboto', sans-serif;
}
```

---

## 8️⃣ RESPONSYWNOŚĆ

### Media queries
```css
/* Desktop first */
.container {
    width: 1200px;
}

@media (max-width: 1024px) {
    .container { width: 768px; }
}

@media (max-width: 768px) {
    .container { width: 100%; }
    .sidebar { display: none; }
}

@media (max-width: 480px) {
    body { font-size: 14px; }
    .container { padding: 10px; }
}
```

### Breakpoints standardowe
```
xs: < 480px   (mobile)
sm: 480-768px (tablet portrait)
md: 768-1024px (tablet landscape)
lg: > 1024px  (desktop)
```

### Jednostki responsywne
```css
div {
    width: 50%;          /* % szerokości rodzica */
    width: 100vw;        /* 100% viewport width */
    width: 50vw;         /* 50% viewport width */
    font-size: 2rem;     /* Względem root (html) font-size */
    font-size: 1.5em;    /* Względem rodzica font-size */
}
```

---

## 9️⃣ TRANSFORMACJE I ANIMACJE

### Transform
```css
div {
    transform: translateX(50px);      /* Przesunięcie */
    transform: rotate(45deg);         /* Obrót */
    transform: scale(1.5);            /* Skalowanie */
    transform: skew(10deg);           /* Pochylenie */
    transform: translate(50px, 100px) rotate(45deg) scale(2);
}
```

### Transition
```css
button {
    background: blue;
    transition: background 0.3s ease-in-out;  /* Płynna zmiana */
}

button:hover {
    background: darkblue;
}
```

### Animation
```css
@keyframes slide {
    from { transform: translateX(0); }
    to { transform: translateX(100px); }
}

.box {
    animation: slide 2s infinite;  /* Nazwa, czas, powtórzenia */
}
```

---

## 🔟 SHADOWS I EFFECTS

```css
div {
    /* Box shadow */
    box-shadow: 2px 2px 5px rgba(0,0,0,0.3);
    box-shadow: 0 0 10px rgba(0,0,0,0.5), inset 0 0 5px rgba(255,255,255,0.5);
    
    /* Text shadow */
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    
    /* Filter */
    filter: blur(5px);
    filter: brightness(0.8);
    filter: contrast(1.2);
    filter: grayscale(100%);
    filter: drop-shadow(2px 2px 4px black);
}
```

---

## 1️⃣1️⃣ WIDOCZNOŚĆ I PRZEPEŁNIENIE

```css
div {
    /* Overflow */
    overflow: visible;    /* Domyślnie - wychodzi poza kontener */
    overflow: hidden;     /* Ukryj co wychodzi */
    overflow: scroll;     /* Zawsze pokaż scroll */
    overflow: auto;       /* Scroll tylko gdy potrzeba */
    
    overflow-x: hidden;   /* Tylko X */
    overflow-y: auto;     /* Tylko Y */
    
    /* Clip */
    clip-path: circle(50%);
    clip-path: polygon(0% 0%, 100% 0%, 100% 75%, 0% 100%);
    
    /* Widoczność */
    visibility: visible;  /* Widoczny */
    visibility: hidden;   /* Ukryty ale zajmuje miejsce */
    
    /* Opacity */
    opacity: 0;          /* Przezroczysty */
}
```

---

## 1️⃣2️⃣ FLEXBOX ZAAWANSOWANY

```css
.container {
    display: flex;
    
    /* Kierunek */
    flex-direction: row;        /* row, column, row-reverse, column-reverse */
    
    /* Wyrównanie główna oś */
    justify-content: center;    /* flex-start, flex-end, center, space-between, space-around, space-evenly */
    
    /* Wyrównanie poprzeczna oś */
    align-items: center;        /* flex-start, flex-end, center, stretch */
    
    /* Zawinięcie */
    flex-wrap: wrap;            /* nowrap, wrap, wrap-reverse */
    
    /* Wyrównanie całych linii (gdy wrap) */
    align-content: center;      /* Jak justify-content ale dla linii */
    
    /* Przestrzeń */
    gap: 10px;                  /* Między itemami */
    gap: 10px 20px;            /* row-gap, column-gap */
}

.item {
    flex: 1;                    /* Zajmij równą przestrzeń */
    flex: 2;                    /* Zajmij 2x więcej niż flex: 1 */
    flex-grow: 1;              /* Rosnij gdy jest wolne miejsce */
    flex-shrink: 1;            /* Kurczaj się gdy brak miejsca */
    flex-basis: 100px;         /* Domyślny rozmiar */
}
```

---

## 1️⃣3️⃣ PODSUMOWANIE DO EGZAMINU

| Właściwość | Zastosowanie |
|-----------|--------------|
| **display** | Block, inline, flex, grid, none |
| **position** | Pozycjonowanie: static, relative, absolute, fixed |
| **width/height** | Wymiary |
| **margin/padding** | Przestrzeń (zewnątrz/wewnątrz) |
| **color/background** | Kolory |
| **font-size/font-family** | Czcionka |
| **flex/grid** | Układy |
| **transform** | Transformacje 2D/3D |
| **transition** | Płynne przejścia |
| **media** | Responsywność |

---

**Powodzenia na egzaminie! 🎓**
