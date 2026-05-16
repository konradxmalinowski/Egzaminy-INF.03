# Grafika komputerowa na stronach internetowych
> INF.03 - Projektowanie stron | Ściaģawka egzaminacyjna

---

## 1. Grafika rastrowa vs wektorowa

| Cecha | Rastrowa (bitmapowa) | Wektorowa |
|---|---|---|
| Budowa | Siatka pikseli | Krzywe matematyczne (Beziera) |
| Skalowanie | Traci jakość (pikselizacja) | Skaluje bez utraty jakości |
| Rozmiar pliku | Duży (zależy od rozdzielczości) | Mały (zależy od złożoności) |
| Edytowalność | Ograniczona (piksel po pikselu) | Pełna (węzły, ścieżki) |
| Zastosowania | Zdjęcia, fotografie, tekstury | Logo, ikony, ilustracje, mapy |
| Formaty | JPG, PNG, GIF, WebP, BMP | SVG, AI, EPS, PDF |
| Programy | Photoshop, GIMP | Illustrator, Inkscape |

---

## 2. Formaty rastrowe

### JPEG / JPG
- **Kompresja**: stratna (lossy) - usuwa dane niewidoczne dla oka
- **Przezroczystość**: NIE obsługuje
- **Kanały**: RGB (24-bit)
- **Zastosowania**: zdjęcia, fotografie, banery
- **Zalety**: mały rozmiar pliku
- **Wady**: artefakty przy wysokiej kompresji, nie nadaje się do tekstu

### PNG (Portable Network Graphics)
- **Kompresja**: bezstratna (lossless)
- **Przezroczystość**: TAK (kanał alpha - PNG-24 / PNG-32)
- **Typy**: PNG-8 (256 kolorów), PNG-24 (16,7 mln kolorów), PNG-32 (z alpha)
- **Zastosowania**: logo, grafiki z przezroczystością, zrzuty ekranu
- **Wady**: większy rozmiar niż JPEG

### GIF (Graphics Interchange Format)
- **Kompresja**: bezstratna (LZW)
- **Kolory**: maksymalnie **256 kolorów** (8-bit)
- **Animacje**: TAK (GIF animowany)
- **Przezroczystość**: TAK (jedna warstwa, binarna - piksel przezroczysty lub nie)
- **Zastosowania**: proste animacje, ikony z małą liczbą kolorów

### WebP
- **Twórca**: Google (2010)
- **Kompresja**: stratna i bezstratna
- **Przezroczystość**: TAK
- **Animacje**: TAK
- **Zalety**: 25-34% mniejszy rozmiar niż JPEG/PNG przy tej samej jakości
- **Wsparcie**: wszystkie nowoczesne przeglądarki (IE nie obsługuje)

### BMP (Bitmap)
- Brak kompresji - duże pliki
- Zastosowanie: Windows, aplikacje desktopowe
- Rzadko używany na stronach internetowych

### TIFF (Tagged Image File Format)
- Kompresja bezstratna
- Wysoka jakość
- Stosowany w poligrafii i fotografii profesjonalnej
- Nie obsługiwany bezpośrednio przez przeglądarki

### ICO
- Format ikon (favicon)
- Może zawierać wiele rozmiarów (16x16, 32x32, 48x48)
- Stosowany jako `favicon.ico`

---

## 3. Formaty wektorowe

| Format | Opis | Zastosowanie |
|---|---|---|
| SVG | Scalable Vector Graphics (XML) | Web, ikony, animacje CSS |
| AI | Adobe Illustrator (zastrzeżony) | Projektowanie graficzne |
| EPS | Encapsulated PostScript | Poligrafia, druk |
| PDF | Portable Document Format | Dokumenty, druk |
| CDR | CorelDRAW (zastrzeżony) | Projektowanie graficzne |

### SVG na stronach WWW
```html
<!-- Inline SVG -->
<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg">
  <circle cx="50" cy="50" r="40" stroke="black" stroke-width="3" fill="red"/>
</svg>

<!-- SVG jako obraz -->
<img src="logo.svg" alt="Logo firmy">

<!-- SVG jako tło CSS -->
.element {
  background-image: url('icon.svg');
}
```

---

## 4. Modele barw

### RGB (Red, Green, Blue)
- **Mieszanie**: addytywne (dodawanie światła)
- **Zakres**: 0-255 na kanał (256 wartości)
- **Zastosowanie**: monitory, ekrany, web
- **Biel** = R:255, G:255, B:255
- **Czerń** = R:0, G:0, B:0
- **Ilość kolorów**: 256^3 = 16 777 216 kolorów

### CMYK (Cyan, Magenta, Yellow, Key/Black)
- **Mieszanie**: subtraktywne (pochłanianie światła)
- **Zakres**: 0-100%
- **Zastosowanie**: druk
- **Biel** = C:0, M:0, Y:0, K:0
- **Czerń** = C:0, M:0, Y:0, K:100

### HSL (Hue, Saturation, Lightness) / HSB (Hue, Saturation, Brightness)
- **H (odcień)**: 0-360 stopni (koło barw)
- **S (nasycenie)**: 0-100%
- **L (jasność)**: 0-100%
- **Zastosowanie**: edycja koloru - bardziej intuicyjne dla człowieka

### Hex (Hexadecimal)
- Format: `#RRGGBB` lub `#RGB` (skrócony)
- Przykłady: `#FF0000` = czerwony, `#00FF00` = zielony, `#0000FF` = niebieski
- `#FFFFFF` = biały, `#000000` = czarny
- Konwersja: `FF` hex = 255 dziesiętnie

```css
/* Przykłady zapisu kolorów w CSS */
color: rgb(255, 0, 0);        /* Czerwony - RGB */
color: rgba(255, 0, 0, 0.5);  /* Czerwony 50% przezroczystości */
color: hsl(0, 100%, 50%);     /* Czerwony - HSL */
color: hsla(0, 100%, 50%, 0.5);
color: #FF0000;               /* Czerwony - Hex */
color: #F00;                  /* Czerwony - Hex skrócony */
```

---

## 5. Głębia bitowa koloru

| Głębia | Liczba kolorów | Opis |
|---|---|---|
| 1-bit | 2 | Czarno-biały |
| 8-bit | 256 | Paleta (GIF) |
| 16-bit | 65 536 | "High Color" |
| 24-bit | 16 777 216 | "True Color" (RGB: 8+8+8) |
| 32-bit | 16 777 216 + alpha | True Color z kanałem przezroczystości |
| 48-bit | Miliardów | Profesjonalna fotografia |

---

## 6. Rozdzielczość

### DPI (Dots Per Inch) - druk
- **72 DPI** - ekran (standard web)
- **150 DPI** - druk podstawowy
- **300 DPI** - druk wysokiej jakości (standard poligrafii)
- **600 DPI** - druk precyzyjny (etykiety, bilety wizytówki)

### PPI (Pixels Per Inch) - ekrany
- **96 PPI** - standardowy monitor
- **192+ PPI** - Retina/HiDPI (Apple)
- **>400 PPI** - smartfony premium

### Typowe rozdzielczości obrazów dla web
| Rozmiar | Zastosowanie |
|---|---|
| 16x16 px | Favicon |
| 32x32 px | Ikona |
| 200x200 px | Miniatura produktu |
| 800x600 px | Grafika w artykule |
| 1920x1080 px | Pełnoekranowe tło (Full HD) |
| 3840x2160 px | 4K tło |

---

## 7. Optymalizacja grafiki

### Techniki
- **Kompresja stratna**: redukcja jakości (JPEG, WebP lossy)
- **Kompresja bezstratna**: zmniejszenie bez utraty danych (PNG optim, WebP lossless)
- **Konwersja formatu**: JPEG -> WebP (oszczędność ~30%)
- **Lazy loading**: ładowanie obrazów dopiero gdy wchodzą w widok
- **Sprite CSS**: łączenie wielu ikon w jeden plik - mniej requestów HTTP
- **Base64**: kodowanie małych obrazów bezpośrednio w CSS/HTML

### Narzędzia online
- **TinyPNG** - kompresja PNG/JPEG
- **Squoosh** (Google) - konwersja i kompresja
- **ImageOptim** (Mac) - optymalizacja lokalna

### Lazy Loading HTML5
```html
<!-- Natywne lazy loading (HTML5) -->
<img src="foto.jpg" alt="Opis" loading="lazy">

<!-- Preload ważnych obrazów -->
<link rel="preload" href="hero.jpg" as="image">
```

---

## 8. Programy graficzne

| Program | Typ | Licencja | Zastosowanie |
|---|---|---|---|
| Adobe Photoshop | Rastrowy | Płatny | Profesjonalna obróbka zdjęć |
| GIMP | Rastrowy | Darmowy (GPL) | Alternatywa dla Photoshopa |
| Adobe Illustrator | Wektorowy | Płatny | Profesjonalna grafika wektorowa |
| Inkscape | Wektorowy | Darmowy (GPL) | Alternatywa dla Illustratora |
| Canva | Online | Freemium | Szybkie projekty bez umiejętności |
| Figma | UI/UX | Freemium | Projektowanie interfejsów |
| Paint.NET | Rastrowy | Darmowy | Windows, prosty edytor |

---

## 9. CSS i grafika

### background-image
```css
/* Proste tło */
.element {
  background-image: url('obraz.jpg');
  background-size: cover;       /* Wypełnia cały element */
  background-size: contain;     /* Mieści cały obraz */
  background-position: center;  /* Środkuje obraz */
  background-repeat: no-repeat;
}

/* Gradient jako tło */
.element {
  background-image: linear-gradient(to right, #ff0000, #0000ff);
  background-image: radial-gradient(circle, #ff0000, #0000ff);
}

/* Wiele teł */
.element {
  background-image: url('overlay.png'), url('tlo.jpg');
}
```

### object-fit
```css
/* Kontrola jak obraz wypełnia kontener */
img {
  width: 300px;
  height: 200px;
  object-fit: cover;    /* Przycina - wypełnia bez odkształcenia */
  object-fit: contain;  /* Mieści cały - mogą być paski */
  object-fit: fill;     /* Rozciąga - odkształca */
  object-fit: none;     /* Oryginalny rozmiar */
  object-position: center top; /* Punkt kadrowania */
}
```

### filter (filtry CSS)
```css
img {
  filter: grayscale(100%);   /* Czarno-biały */
  filter: blur(5px);          /* Rozmycie */
  filter: brightness(150%);   /* Jasność */
  filter: contrast(200%);     /* Kontrast */
  filter: sepia(100%);        /* Sepia */
  filter: opacity(50%);       /* Przezroczystość */
  filter: saturate(200%);     /* Nasycenie */
  filter: hue-rotate(90deg);  /* Obrót odcienia */
  /* Łączenie filtrów */
  filter: grayscale(50%) blur(2px);
}
```

### clip-path
```css
/* Wycinanie kształtów */
.element {
  clip-path: circle(50%);                    /* Koło */
  clip-path: ellipse(50% 30% at 50% 50%);   /* Elipsa */
  clip-path: polygon(0 0, 100% 0, 50% 100%); /* Trójkąt */
  clip-path: inset(10px);                    /* Prostokąt z wcięciem */
}
```

---

## 10. Responsywne obrazy

### srcset i sizes
```html
<!-- srcset - różne rozdzielczości -->
<img
  src="obraz-800.jpg"
  srcset="obraz-400.jpg 400w,
          obraz-800.jpg 800w,
          obraz-1200.jpg 1200w"
  sizes="(max-width: 600px) 100vw,
         (max-width: 1200px) 50vw,
         800px"
  alt="Responsywny obraz">

<!-- Retina / HiDPI -->
<img
  src="logo.png"
  srcset="logo@2x.png 2x,
          logo@3x.png 3x"
  alt="Logo">
```

### Element picture
```html
<!-- Różne formaty dla różnych przeglądarek -->
<picture>
  <source srcset="obraz.webp" type="image/webp">
  <source srcset="obraz.jpg" type="image/jpeg">
  <img src="obraz.jpg" alt="Opis">
</picture>

<!-- Art direction - różne kadrowania dla mobile/desktop -->
<picture>
  <source media="(max-width: 600px)" srcset="mobile-crop.jpg">
  <source media="(max-width: 1200px)" srcset="tablet-crop.jpg">
  <img src="desktop.jpg" alt="Opis">
</picture>
```

---

## 11. Ikony na stronach WWW

### Font Awesome
```html
<!-- Podłączenie przez CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- Użycie ikon -->
<i class="fas fa-home"></i>       <!-- Solid -->
<i class="far fa-envelope"></i>   <!-- Regular -->
<i class="fab fa-facebook"></i>   <!-- Brand -->

<!-- Rozmiar i kolor -->
<i class="fas fa-star fa-2x" style="color: gold;"></i>
```

### Material Icons (Google)
```html
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<i class="material-icons">home</i>
<i class="material-icons">email</i>
```

### SVG sprite
```html
<!-- Definicja sprite (ukryta) -->
<svg style="display:none">
  <defs>
    <symbol id="icon-home" viewBox="0 0 24 24">
      <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
    </symbol>
  </defs>
</svg>

<!-- Użycie ikony ze sprite -->
<svg width="24" height="24">
  <use href="#icon-home"/>
</svg>
```

---

## 12. Animacje CSS

### @keyframes
```css
/* Definicja animacji */
@keyframes slideIn {
  from {
    opacity: 0;
    transform: translateX(-100px);
  }
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

/* Przykład z etapami */
@keyframes pulse {
  0%   { transform: scale(1); }
  50%  { transform: scale(1.2); }
  100% { transform: scale(1); }
}

/* Zastosowanie */
.element {
  animation-name: slideIn;
  animation-duration: 0.5s;
  animation-timing-function: ease-in-out;
  animation-delay: 0.2s;
  animation-iteration-count: 1;       /* lub infinite */
  animation-direction: normal;        /* lub reverse, alternate */
  animation-fill-mode: forwards;      /* zatrzymuje na końcu */

  /* Skrót */
  animation: slideIn 0.5s ease-in-out 0.2s 1 normal forwards;
}
```

### transition
```css
/* Płynne przejścia między stanami */
.button {
  background-color: blue;
  transition: background-color 0.3s ease,
              transform 0.2s ease-in-out;
}

.button:hover {
  background-color: darkblue;
  transform: scale(1.05);
}

/* Skrót: property duration timing-function delay */
transition: all 0.3s ease;
```

### transform
```css
/* Transformacje 2D */
.element {
  transform: translateX(50px);          /* Przesunięcie X */
  transform: translateY(-20px);         /* Przesunięcie Y */
  transform: translate(50px, -20px);    /* Przesunięcie X i Y */
  transform: rotate(45deg);             /* Obrót */
  transform: scale(1.5);                /* Skalowanie */
  transform: scaleX(2);                 /* Skalowanie X */
  transform: skew(15deg, 5deg);         /* Pochylenie */

  /* Łączenie transformacji */
  transform: translateX(50px) rotate(30deg) scale(1.2);
}

/* Transformacje 3D */
.element {
  transform: rotateX(45deg);
  transform: rotateY(45deg);
  transform: perspective(500px) rotateY(45deg);
}
```

---

## PODSUMOWANIE DO EGZAMINU

### Najważniejsze fakty:
1. **JPEG** = stratna kompresja, zdjęcia, brak przezroczystości
2. **PNG** = bezstratna, przezroczystość (kanał alpha), logo, ikony
3. **GIF** = 256 kolorów, animacje, przezroczystość binarna
4. **WebP** = nowoczesny format Google, lepszy od JPEG i PNG
5. **SVG** = wektorowy XML, skaluje bez utraty, web i ikony
6. **RGB** = ekrany (addytywne), **CMYK** = druk (subtraktywne)
7. **24-bit** = True Color = 16,7 mln kolorów (8 bitów na kanał RGB)
8. **32-bit** = True Color + kanał alpha (przezroczystość)
9. **300 DPI** = standard druku wysokiej jakości
10. `loading="lazy"` = natywne lazy loading w HTML5
11. `<picture>` + `<source>` = responsywne obrazy, różne formaty
12. `object-fit: cover` = obraz wypełnia kontener bez odkształcenia
13. `filter: grayscale(100%)` = czarno-biały przez CSS
14. `@keyframes` = definicja animacji CSS
15. `transition` = płynne przejście między stanami CSS
