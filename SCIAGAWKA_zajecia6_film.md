# 🔍 SCIĄGAWKA: Zajęcia 6 - Film na Stronach Internetowych

## Czym jest wideo cyfrowe?
- **Definicja**: Sekwencja obrazów wyświetlanych w szybkim tempie (klatki/sekundę = FPS)
- **Standardy**: 24 FPS (film), 25/30 FPS (TV), 60 FPS (gry)

---

## FORMATY WIDEO

### POJEMNIKI (Containers)

🔹 **MP4** ⭐ (MPEG-4)
- Najpopularniejszy format
- Obsługiwany wszędzie
- Rozszerzenie: `.mp4`
- Kodeki: H.264, H.265 (video) + AAC (audio)

🔹 **WebM**
- Open source Google
- Mały rozmiar
- Codec: VP8/VP9 (video) + Vorbis/Opus (audio)
- Web, streaming

🔹 **OGG (Theora)**
- Otwarty format
- Rzadki, starszy format
- Codec: Theora (video) + Vorbis (audio)

🔹 **AVI** (Audio Video Interleave)
- Starszy format Windows
- Duży rozmiar, słaba kompresja
- Mało używany dzisiaj

🔹 **MOV** (QuickTime)
- Apple standard
- Profesjonalna edycja
- Duży rozmiar

🔹 **FLV** (Flash Video)
- Starszy format (Flash)
- Rzadko używany dzisiaj

---

## KODEKI VIDEO

### Kodeki obrazu (Video Codecs)

🔹 **H.264 (AVC)** ⭐
- Najbardziej rozpowszechniany
- Dobra kompresja, szybkie dekodowanie
- Obsługiwany wszędzie
- Patent (możliwe opłaty)

🔹 **H.265 (HEVC)**
- Nowszy niż H.264
- ~50% mniejszy rozmiar przy tej samej jakości
- Wymaga więcej mocy CPU do dekodowania
- Brak uniwersalnej obsługi

🔹 **VP8/VP9** (Google)
- Open source
- VP9 = alternatywa dla H.265
- WebM container

🔹 **AV1** (Alliance for Open Media)
- Najnowszy, najlepszy codec
- 30% lepszy niż H.265
- Wolne kodowanie (processing)
- Mała obsługa przeglądarek (na razie)

### Kodeki audio
- **AAC** (Advanced Audio Codec) - najlepszy
- **MP3** - kompatybilność
- **Vorbis** - otwarty
- **Opus** - nowoczesny

---

## WŁAŚCIWOŚCI WIDEO

### Bitrate (przepustowość)
- **Wyższy bitrate** = lepsza jakość, większy plik
- Typowe: 500 kbps - 5 Mbps (streaming)
- Studio: 20+ Mbps

### Rozdzielczość
- **720p** (1280×720) - HD
- **1080p** (1920×1080) - Full HD
- **1440p** (2560×1440) - 2K
- **2160p** (3840×2160) - 4K

### Frame rate (FPS)
- **24 FPS** - film kinowy
- **25/30 FPS** - telewizja
- **60 FPS** - gry, wysoka płynność

---

## HTML5 VIDEO

### Podstawowy kod

```html
<video width="320" height="240" controls>
  <source src="video.mp4" type="video/mp4">
  <source src="video.webm" type="video/webm">
  Twoja przeglądarka nie obsługuje video.
</video>
```

### Atrybuty video
- `width`, `height` - rozmiar
- `controls` - przyciski odtwarzania
- `autoplay` - automatyczne odtwarzanie (ograniczone)
- `muted` - wyciszone (wymagane do autoplay w Chrome)
- `loop` - pętla
- `poster="image.jpg"` - obraz przed odtwarzaniem
- `preload="auto/metadata/none"` - wczytywanie
- `playsinline` - odtwarzanie inline (mobile)

### Obsługiwane typy

```html
<source src="movie.mp4" type="video/mp4; codecs='avc1.42E01E, mp4a.40.2'">
<source src="movie.webm" type="video/webm">
```

---

## OSADZANIE VIDEO

### Z YouTube

```html
<iframe width="560" height="315" 
  src="https://www.youtube.com/embed/dQw4w9WgXcQ">
</iframe>
```

### Z Vimeo

```html
<iframe src="https://player.vimeo.com/video/123456789"
  width="640" height="360"></iframe>
```

### Z własnym serwerem

```html
<video controls width="100%">
  <source src="/videos/myvideo.mp4" type="video/mp4">
</video>
```

---

## KOMPRESJA WIDEO

### Przed osadzeniem w HTML
1. **Zmniejsz rozdzielczość** (1920×1080 wystarczy)
2. **Zmień bitrate** (2-5 Mbps dla HD)
3. **Skróć czas** (zbyt długie wideo)
4. **Konwertuj** na H.264 + AAC w MP4

### Narzędzia
- **FFmpeg** - konsolowy, najpotężniejszy
- **HandBrake** - GUI, prosty
- **Adobe Media Encoder** - profesjonalny
- **Online converters** - szybkie, proste

---

## STREAMING VIDEO

### LIVE Streaming
- **YouTube Live** - najpopularniejszy
- **Twitch** - gry, entertainment
- **Facebook Live** - społeczność

### On-demand Streaming
- **YouTube** - bezpłatny, reklamy
- **Vimeo** - premium
- **Własny serwer** - pełna kontrola

### Protokoły Streaming
- **RTMP** - streaming na żywo (Adobe)
- **HLS** - HTTP Live Streaming (Apple)
- **DASH** - Dynamic Adaptive Streaming (standard)

---

## OPTYMALIZACJA WIDEO

✅ **Wybór formatu**: MP4 (wszędzie) + WebM (mały rozmiar)
✅ **Bitrate**: 2-5 Mbps dla HD (balans jakość/rozmiar)
✅ **Rozdzielczość**: Max 1920×1080 (1080p)
✅ **Codec**: H.264 (kompatybilność)
✅ **Thumbnail**: Dodaj poster (przed odtwarzaniem)
✅ **Fallback**: Zawsze dodaj źródło tekstowe (dostępność)
✅ **Preload**: Ustaw "metadata" (szybsze czytanie info)

---

## DOSTĘPNOŚĆ VIDEO

```html
<video controls width="640" height="360" poster="thumbnail.jpg">
  <source src="video.mp4" type="video/mp4">
  <source src="video.webm" type="video/webm">
  <track kind="subtitles" src="subs_pl.vtt" srclang="pl" label="Polski">
  <track kind="subtitles" src="subs_en.vtt" srclang="en" label="English">
  Twoja przeglądarka nie obsługuje video HTML5.
</video>
```

---

## PODSUMOWANIE DO EGZAMINU

✅ **Formaty**: MP4 (wszędobylski), WebM (web), MOV (Apple)
✅ **Kodeki**: H.264 (najpopularniejszy), H.265 (nowszy), VP9 (otwarty)
✅ **Właściwości**: Bitrate, rozdzielczość, FPS
✅ **HTML5 video**: `<video controls><source src="..."></video>`
✅ **Osadzanie**: YouTube iframe, Vimeo iframe, własny serwer
✅ **Kompresja**: FFmpeg, HandBrake, Online converters
✅ **Streaming**: Live (YouTube, Twitch), On-demand (Vimeo, własny)
✅ **Optymalizacja**: MP4 + WebM, bitrate 2-5 Mbps, rozdzielczość max 1080p
✅ **Dostępność**: Napisy (track tag), poster, fallback tekstowy
