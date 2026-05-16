# 🔍 SCIĄGAWKA: Zajęcia 7 - Testowanie, Publikowanie i Optymalizacja Stron

## TESTOWANIE STRON INTERNETOWYCH

### Co testować?

✅ **Funkcjonalność**
- Czy wszystkie przyciski działają?
- Czy linki prowadzą do właściwych stron?
- Czy formularze się wysyłają?
- Czy menu działa na wszystkich urządzeniach?

✅ **Kompatybilność przeglądarek**
- Chrome, Firefox, Safari, Edge
- Na desktopie i mobilnie
- Różne wersje przeglądarek

✅ **Responsywność**
- Desktop (1920×1080)
- Tablet (768×1024)
- Telefon (375×667, 414×896)
- Czy wygląd jest czytelnymi na każdym urządzeniu?

✅ **Prędkość ładowania**
- Czas całkowitego ładowania < 3s
- Obrazy zoptymalizowane
- Skrypty zminimalizowane

✅ **SEO**
- Meta opisy
- Nagłówki H1, H2, H3
- Przyjazne URL-e
- Sitemap.xml, robots.txt

✅ **Bezpieczeństwo**
- HTTPS (szyfrowanie)
- Walidacja formularzy
- Bez podatności XSS, SQL Injection
- Aktualne biblioteki i wtyczki

✅ **Dostępność (Accessibility)**
- Kontrast kolorów (WCAG AA standard)
- Alt text dla obrazów
- Nawigacja klawiaturą
- Screen reader compatibility

---

## NARZĘDZIA TESTOWANIA

### 🔧 **Google DevTools** (zabudowane w Chrome)
- Inspeksja elementów HTML/CSS
- Console (błędy JavaScript)
- Network (ściąganie plików, szybkość)
- Performance (analiza wydajności)
- Lighthouse (audyt SEO, wydajności)

### 🔧 **Google Lighthouse**
- Automatyczny audyt strony
- Performance, Accessibility, Best Practices, SEO
- Rekomendacje do poprawy

### 🔧 **Google PageSpeed Insights**
- Analiza szybkości ładowania
- Dla desktop i mobile
- Metryki Core Web Vitals

### 🔧 **GTmetrix**
- Szczegółowa analiza wydajności
- Waterfall chart (kolejność ładowania)
- Rekomendacje

### 🔧 **Wave** (Web Accessibility)
- Testowanie dostępności (accessibility)
- Błędy kontrastu, alt text

### 🔧 **Responsively App**
- Testowanie na wielu rozdzielczościach jednocześnie

### 🔧 **BrowserStack**
- Testowanie na rzeczywistych urządzeniach
- Setki kombinacji przeglądarek/systemów

---

## CORE WEB VITALS (metryki Google)

### 🎯 **LCP** (Largest Contentful Paint)
- Ładowanie głównej zawartości
- Cel: < 2,5s

### 🎯 **FID** (First Input Delay)
- Czas odpowiedzi na interakcję
- Cel: < 100ms

### 🎯 **CLS** (Cumulative Layout Shift)
- Stabilność wizualna (layout shift)
- Cel: < 0,1

---

## PUBLIKOWANIE STRONY (Deployment)

### Hosting
- **Shared Hosting** - tani, dla małych stron
- **VPS** - większa kontrola, drożej
- **Cloud** (AWS, Google Cloud, Azure) - skalowalne
- **Managed WordPress** - specjalny dla WP

### Popularne hostingi
- **Bluehost** - WordPress friendly
- **GoDaddy** - domena + hosting
- **Namecheap** - tanie domeny
- **Heroku** - aplikacje internetowe
- **Netlify, Vercel** - static sites, SPA

### Domena
1. Wybierz dostawcę domeny (Namecheap, GoDaddy)
2. Sprawdź dostępność
3. Kup domenę (zwykle $10-15/rok)
4. Skonfiguruj DNS

### FTP/SFTP (przesyłanie plików)
- **FTP Client**: FileZilla (darmowy)
- Łączenie z serwerem: host, login, hasło
- Przesyłanie plików lokalnych na serwer
- Edycja plików na żywo (mniej bezpieczne)

### GIT Deployment (nowoczesne)
```bash
git push origin main  # Przesyłanie do repozytorium
# Hosting automatycznie wdraża zmianę
```

---

## OPTYMALIZACJA STRONY

### 🚀 **Prędkość**

✅ **Optimizacja obrazów**
- Kompresuj do max 100 KB (jeśli możliwe)
- Używaj odpowiedniego formatu (WebP dla nowoczesnych)
- Lazy loading (ładowanie przy scrollowaniu)
- Responsive images (`srcset`)

✅ **Minifikacja kodu**
- CSS: 50% redukcji rozmiaru
- JavaScript: 50% redukcji
- HTML: mniejsza redukcja

✅ **Cache**
- Browser cache (przechowywanie u użytkownika)
- Server cache (przechowywanie na serwerze)
- CDN cache (rozpowszechnianie globalne)

✅ **Content Delivery Network (CDN)**
- CloudFlare, Akamai, AWS CloudFront
- Pliki serwowane z lokalnych serwerów na świecie

✅ **GZIP kompresja**
- Aktywuj na serwerze
- Zmniejsza transfer ~ 80%

---

### 🔍 **SEO**

✅ **On-page SEO**
- Słowo kluczowe w: tytule, meta opisie, H1
- Naturalne słowa kluczowe w tekście
- Wewnętrzne linki (internal linking)
- Meta tag `description` (max 160 znaków)

✅ **Struktura**
- Logiczna hierarchia nagłówków (H1, H2, H3)
- Przyjazne URL-e (`/blog/artykul` nie `/blog?id=123`)
- Sitemap.xml dla Google
- robots.txt (co indeksować)

✅ **Off-page SEO**
- Backlinki (linki z innych stron)
- Media społeczne (social signals)
- Mentions (wzmianki o stronie)

✅ **Mobile SEO**
- Mobile-first indexing (Google priorytet)
- Responsive design
- Szybkość na mobile < 3s

✅ **Narzędzia SEO**
- Google Search Console (status indeksacji)
- Google Analytics (analiza ruchu)
- SEMrush, Ahrefs (analiza konkurentów)

---

### 🔒 **Bezpieczeństwo**

✅ **HTTPS**
- Szyfrowanie komunikacji (SSL/TLS)
- Certyfikat SSL (Let's Encrypt - darmowy)
- Obowiązkowy dla e-commerce, logowania

✅ **Walidacja formularzy**
- Klient: JavaScript validation
- Serwer: obowiązkowa walidacja (ważna!)
- Czyszczenie danych (sanitization)

✅ **Bezpieczne hasła**
- Hashing (bcrypt, ARGON2)
- Salt (unikatowy dla każdego hasła)
- Nigdy nie przechowuj plain text!

✅ **Aktualizacje**
- CMS (WordPress, Joomla) - regularnie
- Wtyczki - regularnie
- Biblioteki (jQuery, Bootstrap) - regularnie
- Serwer (PHP, Apache) - regularnie

✅ **WAF (Web Application Firewall)**
- CloudFlare, Sucuri
- Blokowanie ataków

---

## PUBLIKOWANIE: CHECKLIST

| Aspekt | Zadanie | Status |
|--------|---------|--------|
| **Konfiguracja** | Ustaw domenę, hosting, DNS | ☐ |
| **Zawartość** | Sprawdź całą treść | ☐ |
| **Linki** | Testuj wszystkie linki | ☐ |
| **Formularze** | Testuj wysyłanie danych | ☐ |
| **Responsywność** | Desktop, tablet, mobile | ☐ |
| **Prędkość** | PageSpeed > 90 | ☐ |
| **SEO** | Meta, H1, sitemap.xml | ☐ |
| **SSL** | Zainstaluj HTTPS | ☐ |
| **Backup** | Skonfiguruj kopie zapasowe | ☐ |
| **Monitoring** | Ustaw uptime monitoring | ☐ |

---

## POST-PUBLIKOWANIE

### 📊 **Monitoring**
- Google Analytics - mierzenie ruchu
- Google Search Console - indeksacja
- Uptime Monitoring (UptimeRobot) - czy strona żyje?
- Error logging (Sentry) - błędy aplikacji

### 📈 **Ciągła optymalizacja**
- A/B testing (test różnych wersji)
- Heat mapping (gdzie klikają użytkownicy)
- User feedback
- Regularne aktualizacje treści

---

## PODSUMOWANIE DO EGZAMINU

✅ **Testowanie**: Funkcjonalność, kompatybilność, responsywność, prędkość, SEO, bezpieczeństwo
✅ **Narzędzia**: DevTools, Lighthouse, PageSpeed, GTmetrix, Wave
✅ **Core Web Vitals**: LCP (<2,5s), FID (<100ms), CLS (<0,1)
✅ **Hosting**: Shared, VPS, Cloud
✅ **Deployment**: FTP (FileZilla), GIT, Managed hosting
✅ **Optymalizacja**: Obrazy, minifikacja, cache, CDN, GZIP
✅ **SEO**: On-page (słowa kluczowe, H1), Off-page (backlinki), Mobile
✅ **Bezpieczeństwo**: HTTPS, walidacja, hashing, aktualizacje
✅ **Monitoring**: Analytics, Search Console, Error logging
✅ **Checklist**: 10 punktów przed publikacją

**Kluczowy porządek**:
1. Testuj lokalnie (localhost)
2. Optymalizuj (prędkość, SEO, bezpieczeństwo)
3. Publikuj na hosting
4. Monitoruj i poprawiaj
