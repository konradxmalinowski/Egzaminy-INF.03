# Multimedia - wideo i audio na stronach internetowych
> INF.03 - Projektowanie stron | Ściaģawka egzaminacyjna

---

## 1. Formaty wideo

| Format | Kontener | Kodek (domyślny) | Wsparcie | Zastosowanie |
|---|---|---|---|---|
| MP4 | .mp4 | H.264 (AVC) | Wszystkie przeglądarki | Standard web, wideo ogólne |
| WebM | .webm | VP8 / VP9 | Chrome, Firefox, Edge | Alternatywa open-source dla MP4 |
| OGV / OGG | .ogv | Theora | Firefox, Chrome | Starszy open-source |
| AVI | .avi | DivX, XviD, H.264 | Przez plugin | Desktop, nie zalecany dla web |
| MOV | .mov | H.264, ProRes | Safari (natywnie) | Apple, edycja wideo |
| MKV | .mkv | H.264, H.265 | Przez plugin | Multimedia ogólne, nie dla web |

### Hierarchia kompatybilności dla web:
```
1. MP4 / H.264  → najbardziej kompatybilny (zawsze jako fallback)
2. WebM / VP9   → nowoczesne przeglądarki, mniejszy plik
3. OGV / Theora → przestarzały, ale uzupełnia kompatybilność
```

---

## 2. Formaty audio

| Format | Kompresja | Jakość | Zastosowanie |
|---|---|---|---|
| MP3 | Stratna | Dobra | Standard audio web, muzyka |
| AAC | Stratna | Lepsza niż MP3 | Apple, YouTube, streaming |
| OGG / Vorbis | Stratna | Porównywalna z MP3 | Open-source, Firefox |
| WAV | Bezstratna | Doskonała | Studio, brak kompresji, duże pliki |
| FLAC | Bezstratna | Doskonała | Audiofil, archiwizacja |
| WebM Audio | Stratna | Dobra | Powiązany z formatem WebM |
| Opus | Stratna | Najlepsza | VoIP, strumieniowanie real-time |

### Kompatybilność audio w przeglądarkach:
| Format | Chrome | Firefox | Safari | Edge |
|---|---|---|---|---|
| MP3 | TAK | TAK | TAK | TAK |
| OGG | TAK | TAK | NIE | TAK |
| WAV | TAK | TAK | TAK | TAK |
| AAC | TAK | TAK | TAK | TAK |

---

## 3. Kodeki vs kontenery - różnica

### Kontener (format pliku)
- Opakowanie przechowujące strumienie danych
- Przechowuje wideo + audio + napisy + metadane
- Przykłady: MP4, WebM, AVI, MKV, MOV

### Kodek (koder/dekoder)
- Algorytm kompresji/dekompresji danych
- Przykłady: H.264, H.265 (HEVC), VP9, AV1, MP3, AAC

### Przykłady kombinacji:
```
MP4 (kontener) + H.264 (kodek wideo) + AAC (kodek audio)
WebM (kontener) + VP9 (kodek wideo) + Vorbis (kodek audio)
MKV (kontener) + H.265 (kodek wideo) + FLAC (kodek audio)
```

### Popularne kodeki wideo:
| Kodek | Wydajność | Licencja | Uwagi |
|---|---|---|---|
| H.264 (AVC) | Standard | Patenty (płatna) | Dominujący na web |
| H.265 (HEVC) | 2x lepszy niż H.264 | Patenty (droga) | 4K, streaming |
| VP9 | ~H.265 | Darmowy (Google) | YouTube, WebM |
| AV1 | Najlepszy | Darmowy | Następca VP9 i H.265 |

---

## 4. Parametry wideo

### Rozdzielczość
| Nazwa | Rozdzielczość | Stosunek | Zastosowanie |
|---|---|---|---|
| SD | 480x360 | 4:3 | Stary standard |
| 480p | 854x480 | 16:9 | Podstawowa jakość |
| 720p (HD) | 1280x720 | 16:9 | HD, dobra jakość |
| 1080p (Full HD) | 1920x1080 | 16:9 | Standard |
| 1440p (2K) | 2560x1440 | 16:9 | Gaming, pro |
| 2160p (4K / UHD) | 3840x2160 | 16:9 | Premium |
| 4320p (8K) | 7680x4320 | 16:9 | Najwyższa jakość |

### FPS (Frames Per Second - klatki na sekundę)
- **24 FPS** - standard filmowy (kinowe wrażenie)
- **25 FPS** - standard europejski (PAL)
- **30 FPS** - standard telewizyjny (NTSC)
- **60 FPS** - płynna animacja, gaming, sport
- **120 FPS** - super slow-motion

### Bitrate
- Ilość danych na sekundę wideo
- **Niski bitrate** = mniejszy plik, gorsza jakość
- **Wysoki bitrate** = większy plik, lepsza jakość
- Dla 1080p/H.264: 4-8 Mbps (streaming), 15-40 Mbps (local)

---

## 5. HTML5 element `<video>`

### Podstawowa składnia
```html
<video src="film.mp4" controls></video>
```

### Pełna składnia z atrybutami
```html
<video
  width="800"
  height="450"
  controls
  autoplay
  muted
  loop
  preload="metadata"
  poster="miniatura.jpg">

  <!-- Wiele formatów - fallback -->
  <source src="film.mp4" type="video/mp4">
  <source src="film.webm" type="video/webm">
  <source src="film.ogv" type="video/ogg">

  <!-- Napisy (subtitles) -->
  <track src="napisy-pl.vtt" kind="subtitles" srclang="pl" label="Polski">
  <track src="napisy-en.vtt" kind="subtitles" srclang="en" label="English">

  <!-- Komunikat dla przeglądarek bez obsługi HTML5 -->
  <p>Twoja przeglądarka nie obsługuje elementu video.</p>
</video>
```

### Atrybuty `<video>` - tabela
| Atrybut | Wartości | Opis |
|---|---|---|
| `controls` | (brak wartości) | Wyświetla kontrolki odtwarzacza |
| `autoplay` | (brak wartości) | Automatyczne odtwarzanie |
| `muted` | (brak wartości) | Wyciszenie (wymagane dla autoplay w Chrome) |
| `loop` | (brak wartości) | Zapętlenie wideo |
| `preload` | `auto`, `metadata`, `none` | Jak ładować plik przed odtworzeniem |
| `poster` | URL | Miniatura wyświetlana przed odtworzeniem |
| `width` | px | Szerokość odtwarzacza |
| `height` | px | Wysokość odtwarzacza |
| `playsinline` | (brak wartości) | iOS: odtwarzanie w miejscu (nie fullscreen) |

### Uwaga o autoplay:
- Przeglądarki **blokują autoplay z dźwiękiem**
- Autoplay działa tylko z `muted` lub po interakcji użytkownika

---

## 6. HTML5 element `<audio>`

### Podstawowa składnia
```html
<audio src="muzyka.mp3" controls></audio>
```

### Pełna składnia
```html
<audio controls autoplay muted loop preload="auto">
  <source src="muzyka.mp3" type="audio/mpeg">
  <source src="muzyka.ogg" type="audio/ogg">
  <source src="muzyka.wav" type="audio/wav">
  <p>Twoja przeglądarka nie obsługuje elementu audio.</p>
</audio>
```

### Atrybuty `<audio>`
| Atrybut | Opis |
|---|---|
| `controls` | Wyświetla kontrolki (play, pause, głośność) |
| `autoplay` | Automatyczne odtwarzanie |
| `muted` | Wyciszenie |
| `loop` | Zapętlenie |
| `preload` | `auto` / `metadata` / `none` |

### Typy MIME dla audio/video
```
audio/mpeg      → .mp3
audio/ogg       → .ogg
audio/wav       → .wav
audio/aac       → .aac
video/mp4       → .mp4
video/webm      → .webm
video/ogg       → .ogv
```

---

## 7. Osadzanie YouTube i Vimeo przez iframe

### YouTube
```html
<!-- Podstawowe osadzenie -->
<iframe
  width="560"
  height="315"
  src="https://www.youtube.com/embed/VIDEO_ID"
  title="Tytuł wideo"
  frameborder="0"
  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
  allowfullscreen>
</iframe>

<!-- Parametry URL YouTube -->
<!-- ?autoplay=1     → automatyczne odtwarzanie -->
<!-- ?mute=1         → wyciszenie -->
<!-- ?loop=1         → zapętlenie -->
<!-- ?controls=0     → ukrycie kontrolek -->
<!-- ?start=30       → start od 30 sekundy -->
<!-- ?rel=0          → nie pokazuj powiązanych filmów -->
<iframe src="https://www.youtube.com/embed/VIDEO_ID?autoplay=1&mute=1&loop=1&rel=0"></iframe>
```

### Vimeo
```html
<iframe
  src="https://player.vimeo.com/video/VIDEO_ID?autoplay=1&loop=1&muted=1"
  width="640"
  height="360"
  frameborder="0"
  allow="autoplay; fullscreen; picture-in-picture"
  allowfullscreen>
</iframe>
```

### Różnica: własne wideo vs YouTube/Vimeo
| Aspekt | Własne wideo | YouTube/Vimeo |
|---|---|---|
| Hosting | Na własnym serwerze | Na platformie |
| Koszty transferu | Własne | Platformy |
| Kontrola | Pełna | Ograniczona |
| Reklamy | Brak | Mogą się pojawić |
| Analityka | Własna | Platformy |
| Reklama | Nie | Tak (YouTube) |

---

## 8. CSS dla mediów

### Responsywne wideo (zachowanie proporcji)
```css
/* Metoda 1: aspect-ratio (nowoczesna) */
.video-container {
  width: 100%;
  aspect-ratio: 16 / 9;
}

.video-container iframe,
.video-container video {
  width: 100%;
  height: 100%;
}

/* Metoda 2: padding-top (klasyczna) */
.video-wrapper {
  position: relative;
  width: 100%;
  padding-top: 56.25%; /* 9/16 * 100% = 56.25% dla 16:9 */
}

.video-wrapper iframe {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}
```

### Video jako tło (background video)
```html
<div class="hero">
  <video class="bg-video" autoplay muted loop playsinline>
    <source src="tlo.mp4" type="video/mp4">
  </video>
  <div class="hero-content">
    <h1>Nagłówek na tle wideo</h1>
  </div>
</div>
```

```css
.hero {
  position: relative;
  height: 100vh;
  overflow: hidden;
}

.bg-video {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  min-width: 100%;
  min-height: 100%;
  width: auto;
  height: auto;
  z-index: -1;
  object-fit: cover;
}

.hero-content {
  position: relative;
  z-index: 1;
  color: white;
  text-align: center;
}
```

### Responsywny obraz zastępczy dla wideo (poster)
```css
video {
  max-width: 100%;
  height: auto;
}
```

---

## 9. Kompresja i optymalizacja wideo dla web

### Zalecenia
- **Format**: MP4 (H.264) + WebM (VP9) jako fallback
- **Rozdzielczość**: nie większa niż potrzebna
- **Bitrate**: dostosowany do rozdzielczości i przeznaczenia
- **Długość**: jak najkrótsza (szczególnie dla tła)
- **Dźwięk**: wyłącz jeśli niepotrzebny (zaoszczędza miejsce)

### Popularne narzędzia
- **FFmpeg** - konwersja z wiersza poleceń:
```bash
# Konwersja do MP4
ffmpeg -i input.avi -c:v libx264 -crf 23 output.mp4

# Konwersja do WebM
ffmpeg -i input.mp4 -c:v libvpx-vp9 -crf 30 output.webm

# Zmiana rozdzielczości
ffmpeg -i input.mp4 -vf scale=1280:720 output.mp4
```
- **HandBrake** - GUI do konwersji wideo
- **Adobe Premiere / DaVinci Resolve** - profesjonalna edycja

---

## 10. Multimedia w CMS (WordPress)

### Biblioteka mediów (Media Library)
- Przechowuje: obrazy, wideo, audio, dokumenty (PDF)
- Lokalizacja na serwerze: `/wp-content/uploads/YYYY/MM/`
- WordPress automatycznie tworzy różne rozmiary obrazów
- Obsługuje metadane: alt, tytuł, opis, podpis

### Dodawanie mediów do treści
```
Gutenberg: Bloki -> Media -> Video, Audio, Image
Klasyczny edytor: Dodaj media -> Wgraj/Wybierz plik
```

### Osadzanie zewnętrzne w WordPress
- WordPress automatycznie przekształca URL YouTube/Vimeo na embed
- Wklej sam link YouTube w akapicie → automatycznie staje się playerem

### Formaty obsługiwane przez WordPress
- **Obrazy**: jpg, jpeg, png, gif, webp, svg (przez plugin), ico
- **Wideo**: mp4, m4v, mov, wmv, avi, mpg, ogv, 3gp, 3g2
- **Audio**: mp3, m4a, ogg, wav, flac

---

## 11. Canvas i animacje (podstawy)

### Element canvas
```html
<canvas id="mojCanvas" width="500" height="300"></canvas>
```

```javascript
// Pobranie kontekstu
const canvas = document.getElementById('mojCanvas');
const ctx = canvas.getContext('2d');

// Rysowanie prostokąta
ctx.fillStyle = '#FF0000';
ctx.fillRect(10, 10, 100, 80);  // x, y, width, height

// Rysowanie okręgu
ctx.beginPath();
ctx.arc(200, 150, 50, 0, Math.PI * 2); // x, y, radius, start, end
ctx.fillStyle = 'blue';
ctx.fill();
ctx.strokeStyle = 'black';
ctx.stroke();

// Tekst
ctx.font = '30px Arial';
ctx.fillStyle = 'black';
ctx.fillText('Witaj!', 50, 200);

// Linia
ctx.beginPath();
ctx.moveTo(0, 0);
ctx.lineTo(500, 300);
ctx.stroke();

// Obraz na canvas
const img = new Image();
img.src = 'foto.jpg';
img.onload = () => {
  ctx.drawImage(img, 0, 0, 200, 150);
};
```

### Animacja na canvas (requestAnimationFrame)
```javascript
let x = 0;

function animate() {
  ctx.clearRect(0, 0, canvas.width, canvas.height); // Wyczyść canvas
  ctx.fillRect(x, 50, 50, 50);                       // Narysuj prostokąt
  x += 2;                                             // Przesuń
  if (x > canvas.width) x = 0;                       // Reset

  requestAnimationFrame(animate); // Następna klatka
}
animate();
```

---

## PODSUMOWANIE DO EGZAMINU

### Najważniejsze fakty:
1. **MP4 / H.264** = najbardziej kompatybilny format wideo dla web
2. **WebM / VP9** = open-source, alternatywa dla MP4
3. **MP3** = standard audio dla web (stratna kompresja)
4. **WAV** = bezstratny audio, duże pliki
5. **Kodek** = algorytm kompresji (H.264, VP9, MP3)
6. **Kontener** = opakowanie pliku (MP4, WebM, AVI)
7. `<video controls autoplay muted loop poster="img.jpg">` - kluczowe atrybuty
8. `<source src="film.mp4" type="video/mp4">` - fallback dla różnych formatów
9. **autoplay wymaga muted** w nowoczesnych przeglądarkach
10. **YouTube embed**: `youtube.com/embed/VIDEO_ID` (nie watch?v=)
11. `padding-top: 56.25%` = responsywne 16:9 (klasyczna metoda)
12. `aspect-ratio: 16/9` = nowoczesna metoda responsywnego wideo
13. `<track>` = napisy VTT dla elementu video
14. **WordPress Media Library**: `/wp-content/uploads/`
15. `requestAnimationFrame()` = płynna animacja na canvas (60 FPS)
