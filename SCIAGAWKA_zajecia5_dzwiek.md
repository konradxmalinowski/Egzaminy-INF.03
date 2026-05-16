# 🔍 SCIĄGAWKA: Zajęcia 5 - Dźwięk i Muzyka

## Czym jest dźwięk?
- **Definicja**: Fale akustyczne rozchodzące się w ośrodku (powietrze, woda)
- **Częstotliwość**: Ilość wahań na sekundę (Hz)
- **Słyszalność człowieka**: 20 Hz - 20 kHz

---

## KONWERSJA DŹWIĘKU: ANALOG ↔ CYFROWY

### PRÓBKOWANIE (Sampling)
- **Definicja**: Pomiar amplitudy dźwięku w określonych odstępach czasu
- **Częstotliwość próbkowania**: Liczba pomiarów na sekundę (Hz)
- **Twierdzenie Nyquista**: Aby zarejestrować dźwięk do 20 kHz, potrzeba min. 44,1 kHz próbkowania
  - 44,1 kHz = CD jakość
  - 48 kHz = profesjonalny standard
  - 96 kHz lub 192 kHz = studio mastering

### KWANTYZACJA
- **Definicja**: Zaokrąglanie amplitudy do dyskretnych poziomów
- **Bit Depth** (głębia bitowa):
  - 8-bit = 256 poziomów (telefoniczna jakość)
  - 16-bit = 65 536 poziomów (CD)
  - 24-bit = 16,7 mln poziomów (profesjonalny)

### KODOWANIE
- Zamiana wartości amplitudy na bajty (0 i 1)

---

## FORMATY DŹWIĘKU

### NIEKOMPRESOWANE (PCM)

🔹 **WAV** (Waveform Audio File Format)
- Bez kompresji, wysoka jakość
- Duży rozmiar pliku
- Standard w profesjonalnym audio

🔹 **AIFF** (Audio Interchange File Format)
- Apple/Mac standard
- Podobny do WAV

### KOMPRESJA BEZSTRATNA

🔹 **FLAC** (Free Lossless Audio Codec)
- Bezstratna (żaden dźwięk się nie utraca)
- Zmniejsza rozmiar ~ 50% vs WAV
- Dla audiofili i producentów

🔹 **ALAC** (Apple Lossless Audio Codec)
- Apple standard
- Podobna do FLAC

### KOMPRESJA STRATNA (streaming)

🔹 **MP3** ⭐
- Najbardziej popularne
- Usuwa detale niesłyszalne dla ucha ludzkiego
- Rozmiar: ~10% vs WAV
- Jakość: zależy od bitrate (128-320 kbps)
- Zastosowanie: streaming, przenośne urządzenia

🔹 **AAC** (Advanced Audio Codec)
- Standard Apple iTunes
- Lepsza jakość niż MP3 przy tym samym bitrate
- Bitrate: 128-256 kbps

🔹 **OGG Vorbis**
- Otwarty format, wysokiej jakości kompresji
- Web, streaming

🔹 **OPUS**
- Nowoczesny format
- Doskonały dla web audio, VoIP
- Niska latencja, wysoka jakość

---

## AUDACITY - EDYTOR DŹWIĘKU

### Co to?
- **Darmowe, otwartoźródłowe** oprogramowanie
- Nagrywanie, edytowanie, miksowanie dźwięku
- Dostępne na: Windows, Mac, Linux

### Główne funkcje

✅ **Nagrywanie**
- Bezpośrednio z mikrofonu
- Wielościeżkowe nagrywanie

✅ **Edytowanie**
- Wycinanie, kopowanie, wklejanie fragmentów
- Zmiana głośności (amplifikacja)
- Zmiana szybkości odtwarzania
- Zmiana tonacji bez zmiany tempa

✅ **Efekty**
- Normalizacja (wyrównanie głośności)
- Redukcja szumów
- Echo, reverb, chorus
- Equalizacja (EQ)
- Kompresja dynamiki

✅ **Miksowanie**
- Wiele ścieżek audio
- Przejścia między ścieżkami (fade in/out)
- Stereo/Mono konwersja

✅ **Export**
- MP3, WAV, FLAC, OGG, AIFF
- Zmiana bitrate, sample rate

### Interfejs Audacity
- **Timeline** (linia czasu) - wizualizacja dźwięku
- **Ścieżki** - każda ścieżka audio oddzielnie
- **Pasek narzędzi** - selekcja, przesuwanie, powiększanie
- **Menu efektów** - wszystkie efekty dostępne

---

## STEREO vs MONO

### MONO
- Jeden kanał audio
- Wszyscy słuchacze słyszą identycznie
- Mniejszy rozmiar (50% vs stereo)
- Dla: mowy, podcasty

### STEREO
- Dwa kanały (lewy, prawy)
- Przestrzenność dźwięku
- Dla: muzyka, filmy
- Większy rozmiar

---

## DŹWIĘK NA STRONACH INTERNETOWYCH

### HTML5 Audio Tag

```html
<audio controls>
  <source src="audio.mp3" type="audio/mpeg">
  <source src="audio.ogg" type="audio/ogg">
  Twoja przeglądarka nie obsługuje audio.
</audio>
```

### Atrybuty
- `controls` - przyciski odtwarzania
- `autoplay` - automatyczne odtwarzanie (nie zawsze działa)
- `loop` - pętla odtwarzania
- `muted` - wyciszone na start
- `preload="auto/none/metadata"` - wczytywanie w tle

### Format Selection
- MP3: Kompatybilność (wszystkie przeglądarki)
- OPUS: Najlepiej dla streaming (mały rozmiar)
- Zawsze dodawaj fallback

---

## BITRATE (Przepustowość)

Wyższy bitrate = lepsza jakość, większy plik

| Bitrate | Jakość | Zastosowanie |
|---------|--------|-------------|
| 64 kbps | Niska (telefon) | VoIP, audiobook |
| 128 kbps | Normalna | Streaming, radio |
| 192 kbps | Dobra | Streaming musik |
| 256 kbps | Bardzo dobra | Premium (Spotify) |
| 320 kbps | Maksymalna MP3 | Audiofil |

---

## PODSUMOWANIE DO EGZAMINU

✅ **Próbkowanie** - 44,1 kHz (CD), 48 kHz (pro), min. 40 kHz (Nyquist)
✅ **Kwantyzacja** - 16-bit (CD), 24-bit (studio)
✅ **Formaty**: WAV (niekompresowany), MP3 (streaming), FLAC (bezstratny)
✅ **Audacity** - darmowy edytor: nagrywanie, efekty, export
✅ **Stereo vs Mono** - stereo = 2 kanały, mono = 1 kanał
✅ **HTML5 audio** - `<audio controls src="..."></audio>`
✅ **Bitrate** - wyższy = lepsza jakość, większy plik
✅ **Kompresja stratna** - MP3 usuwa niesłyszalne detale
