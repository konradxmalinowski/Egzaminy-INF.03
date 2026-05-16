# Hosting, domeny i publikowanie stron
> INF.03 - Projektowanie stron | Ściaģawka egzaminacyjna

---

## 1. Rodzaje hostingu

### Shared Hosting (współdzielony)
- Wiele stron na jednym serwerze fizycznym
- **Zalety**: tani (od ~10 zł/mies.), łatwa obsługa, cPanel
- **Wady**: ograniczone zasoby, brak pełnej kontroli, wolniejszy
- **Dla kogo**: małe strony, blogi, wizytówki

### VPS (Virtual Private Server)
- Serwer fizyczny podzielony na wirtualne maszyny (hypervisor)
- **Zalety**: dedykowane zasoby, pełna kontrola (root), lepsza wydajność
- **Wady**: droższy, wymaga wiedzy technicznej
- **Dla kogo**: średnie strony, sklepy, aplikacje webowe

### Dedicated (dedykowany)
- Cały serwer fizyczny dla jednego klienta
- **Zalety**: maksymalna wydajność, pełna kontrola, bezpieczeństwo
- **Wady**: bardzo drogi (od 500 zł/mies.), wymaga administratora
- **Dla kogo**: duże serwisy, banki, e-commerce

### Cloud Hosting
- Zasoby z chmury obliczeniowej (wiele serwerów)
- Dostawcy: **AWS** (Amazon Web Services), **Google Cloud Platform (GCP)**, **Microsoft Azure**
- **Zalety**: skalowanie w górę/dół, pay-as-you-go, wysoka dostępność
- **Wady**: skomplikowana konfiguracja, koszty zmienne
- **Dla kogo**: aplikacje wymagające skalowalności

### Managed WordPress
- Hosting specjalnie zoptymalizowany pod WordPress
- Dostawcy: WP Engine, Kinsta, Cloudways
- **Zalety**: automatyczne aktualizacje, backupy, wydajność
- **Wady**: wyższy koszt, tylko WordPress

---

## 2. Porównanie hostingów

| Cecha | Shared | VPS | Dedicated | Cloud |
|---|---|---|---|---|
| **Cena** | Niska (~10-100 zł) | Średnia (~50-500 zł) | Wysoka (500+ zł) | Zmienna |
| **Wydajność** | Niska | Dobra | Doskonała | Skalowalna |
| **Kontrola** | Mała | Duża (root) | Pełna | Pełna |
| **Bezpieczeństwo** | Podstawowe | Dobre | Najwyższe | Wysokie |
| **Skalowalność** | Brak | Ograniczona | Wymiana sprzętu | Natychmiastowa |
| **Konfiguracja** | cPanel/Plesk | SSH, terminal | SSH, terminal | Panel + CLI |
| **Dla kogo** | Blogi, wizytówki | Średnie projekty | Duże serwisy | SaaS, startupy |

---

## 3. Domeny

### TLD (Top-Level Domain) - domeny najwyższego poziomu
| Typ | Przykłady | Opis |
|---|---|---|
| **gTLD** (generyczne) | .com, .net, .org, .info | Globalne, dla wszystkich |
| **ccTLD** (krajowe) | .pl, .de, .uk, .fr | Przypisane do krajów |
| **nTLD** (nowe) | .shop, .blog, .app | Nowe tematyczne |
| **Branżowe** | .edu, .gov, .mil | Zastrzeżone dla instytucji |

### Popularne TLD
- **.pl** - Polska
- **.com** - Commercial (globalny standard)
- **.org** - Organizations (fundacje, stowarzyszenia)
- **.net** - Network (infrastruktura internet)
- **.eu** - Unia Europejska
- **.gov** - Rząd USA
- **.edu** - Uczelnie USA

### Rejestracja domeny
1. Sprawdzenie dostępności (np. na nazwa.pl, home.pl, OVH)
2. Wybór rejestratora (NASK dla .pl)
3. Podanie danych właściciela
4. Opłata roczna (od ~40 zł/rok dla .pl)
5. Konfiguracja DNS (wskazanie na serwer)

### Transfer domeny
- Przeniesienie domeny między rejestratorami
- Wymagany kod **AuthCode / EPP** (od obecnego rejestratora)
- Transfer trwa do 7 dni

### WHOIS
- Publiczna baza danych właścicieli domen
- Zawiera: właściciel, dane kontaktowe, daty (rejestracja, wygaśnięcie), serwery DNS
- Sprawdzanie: `whois domena.pl` lub online (who.is)
- **ICANN** - organizacja zarządzająca domenami globalnymi

---

## 4. DNS (Domain Name System)

### Co to jest DNS?
- System tłumaczący nazwy domen na adresy IP
- "Książka telefoniczna internetu"
- `google.com` → `142.250.74.46`

### Rodzaje rekordów DNS

| Rekord | Opis | Przykład |
|---|---|---|
| **A** | Nazwa -> adres IPv4 | `example.com → 192.168.1.1` |
| **AAAA** | Nazwa -> adres IPv6 | `example.com → 2001:db8::1` |
| **CNAME** | Alias (jedna nazwa -> inna nazwa) | `www.example.com → example.com` |
| **MX** | Serwer poczty dla domeny | `mail.example.com` priorytet 10 |
| **TXT** | Tekst (SPF, DKIM, weryfikacja) | `"v=spf1 include:..."` |
| **NS** | Serwery nazw (nameservery) | `ns1.hostingprovider.com` |
| **PTR** | Odwrotny DNS (IP -> nazwa) | `1.1.168.192.in-addr.arpa` |
| **SOA** | Start of Authority - info o strefie | Dane administratora DNS |

### Przykładowa konfiguracja DNS:
```
; Rekord A - wskazuje na serwer
example.pl.    IN  A       194.0.0.1

; Rekord AAAA - IPv6
example.pl.    IN  AAAA    2001:db8::1

; Subdomena www (CNAME)
www.example.pl. IN CNAME  example.pl.

; Poczta (MX)
example.pl.    IN  MX  10  mail.example.pl.
mail.example.pl. IN A    194.0.0.2

; SPF (ochrona przed spamem)
example.pl.    IN  TXT "v=spf1 mx a ip4:194.0.0.1 ~all"
```

---

## 5. Propagacja DNS

### Co to jest?
- Czas potrzebny na rozpropagowanie zmian DNS po całym świecie
- Serwery DNS caching'ują odpowiedzi przez czas TTL

### TTL (Time To Live)
- Czas przechowywania rekordu w cache (w sekundach)
- Typowe wartości: 300s (5 min), 3600s (1h), 86400s (24h)
- Niska TTL = szybsze propagowanie zmian, więcej zapytań
- Wysoka TTL = wolniejsze propagowanie, mniej zapytań

### Czas propagacji
- Zazwyczaj **15 minut do 48 godzin**
- Czynniki: TTL rekordu, prędkość propagacji ISP

### Sprawdzanie propagacji
- `nslookup example.com` (Windows)
- `dig example.com` (Linux/Mac)
- Online: whatsmydns.net, dnschecker.org

---

## 6. SSL/TLS i HTTPS

### Co to jest SSL/TLS?
- **SSL** (Secure Sockets Layer) - starszy, przestarzały
- **TLS** (Transport Layer Security) - aktualny standard
- Szyfruje komunikację między przeglądarką a serwerem
- **HTTPS** = HTTP + SSL/TLS

### Dlaczego HTTPS jest ważny?
- Bezpieczeństwo danych (hasła, karty płatnicze)
- SEO - Google preferuje HTTPS
- Zaufanie użytkowników (kłódka w pasku adresu)
- Wymagany dla HTTP/2

### Rodzaje certyfikatów SSL
| Typ | Opis | Czas walidacji | Cena |
|---|---|---|---|
| **DV** (Domain Validated) | Weryfikacja domeny | Minuty | Darmowy / tani |
| **OV** (Organization Validated) | Weryfikacja firmy | Dni | Średni |
| **EV** (Extended Validation) | Rozszerzona weryfikacja | Tygodnie | Drogi |
| **Wildcard** | Obejmuje subdomeny (*.example.com) | - | Droższy |

### Let's Encrypt
- Darmowy urząd certyfikacji (CA)
- Certyfikaty ważne **90 dni** (automatyczne odnawianie)
- Obsługiwany przez większość hostingów
- Instalacja przez Certbot lub panel hostingowy

### Self-signed certyfikat
- Podpisany przez samego właściciela (nie CA)
- Przeglądarka wyświetla ostrzeżenie
- Stosowany na środowiskach lokalnych/deweloperskich

### Instalacja SSL (Let's Encrypt)
```bash
# Certbot na Ubuntu
sudo apt install certbot python3-certbot-apache
sudo certbot --apache -d example.com -d www.example.com

# Automatyczne odnawianie
sudo certbot renew --dry-run
```

---

## 7. Serwery WWW: Apache vs Nginx

| Cecha | Apache | Nginx |
|---|---|---|
| **Model** | Proces/wątek na połączenie | Asynchroniczny (event-driven) |
| **Wydajność** | Dobra przy małej liczbie połączeń | Doskonała przy dużej liczbie |
| **Statyczne pliki** | Wolniejszy | Znacznie szybszy |
| **PHP** | mod_php (wbudowany) | PHP-FPM (zewnętrzny) |
| **Konfiguracja** | .htaccess (per-katalog) | Centralny plik konfiguracji |
| **Popularność** | ~31% rynku | ~32% rynku |
| **Zastosowanie** | Shared hosting, prostota | High-traffic, proxy |

### Apache - .htaccess
```apache
# Przekierowanie HTTP na HTTPS
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Przekierowanie www na non-www
RewriteCond %{HTTP_HOST} ^www\.(.*)$ [NC]
RewriteRule ^(.*)$ https://%1/$1 [R=301,L]

# Przekierowanie 301 (stałe)
Redirect 301 /stara-strona.html /nowa-strona.html

# Przekierowanie 302 (tymczasowe)
Redirect 302 /strona-w-remoncie /strona-glowna

# Blokowanie dostępu do katalogu
Options -Indexes

# Blokowanie konkretnych IP
Deny from 192.168.1.100

# Kompresja gzip
<IfModule mod_deflate.c>
  AddOutputFilterByType DEFLATE text/html text/css text/javascript application/javascript
</IfModule>

# Cache dla obrazów
<IfModule mod_expires.c>
  ExpiresActive On
  ExpiresByType image/jpeg "access plus 1 year"
  ExpiresByType image/png "access plus 1 year"
  ExpiresByType text/css "access plus 1 month"
</IfModule>

# Ukrycie rozszerzenia .php
RewriteRule ^([^\.]+)$ $1.php [NC,L]

# Niestandardowe strony błędów
ErrorDocument 404 /404.html
ErrorDocument 500 /500.html

# Ochrona pliku .htaccess
<Files .htaccess>
  order allow,deny
  deny from all
</Files>
```

---

## 8. FTP / SFTP / SCP

### FTP (File Transfer Protocol)
- Port: **21**
- Brak szyfrowania (hasła w plaintext)
- Tryby: Active (serwer łączy się z klientem), Passive (klient inicjuje oba połączenia)
- **Nie zalecany** - podatny na podsłuch

### SFTP (SSH File Transfer Protocol)
- Port: **22** (przez SSH)
- Pełne szyfrowanie
- **Zalecany** zamiast FTP
- Nie jest to "FTP przez SSL" (to FTPS)

### SCP (Secure Copy Protocol)
- Port: 22 (przez SSH)
- Prosty transfer plików
- Komenda: `scp plik.html user@serwer.pl:/var/www/html/`

### Programy klientów FTP
| Program | Platforma | Cena |
|---|---|---|
| **FileZilla** | Windows/Mac/Linux | Darmowy |
| **WinSCP** | Windows | Darmowy |
| **Cyberduck** | Mac/Windows | Darmowy |
| Total Commander | Windows | Płatny |

### FileZilla - podstawowe użycie:
```
Host: ftp.example.com lub sftp://ftp.example.com
Użytkownik: login@example.com
Hasło: ****
Port: 21 (FTP) lub 22 (SFTP)
```

---

## 9. cPanel i Plesk

### cPanel
- Najpopularniejszy panel zarządzania hostingiem
- Interfejs graficzny dla shared hosting
- Główne funkcje:
  - **File Manager** - zarządzanie plikami
  - **MySQL Databases** - bazy danych
  - **phpMyAdmin** - interfejs MySQL
  - **Email Accounts** - konta email
  - **SSL/TLS** - certyfikaty
  - **Subdomains** - subdomeny
  - **Backups** - kopie zapasowe
  - **Softaculous** - instalacja CMS (WordPress, Joomla)
  - **Cronjobs** - zadania automatyczne
  - **Error Logs** - logi błędów

### Plesk
- Alternatywa dla cPanel
- Obsługuje Windows i Linux
- Bardziej rozbudowany dla zaawansowanych użytkowników

---

## 10. Pakiety lokalne (localhost)

### XAMPP
- **X** = Cross-platform (Windows, Linux, Mac)
- **A** = Apache
- **M** = MariaDB (MySQL)
- **P** = PHP
- **P** = Perl
- Folder stron: `C:\xampp\htdocs\`
- phpMyAdmin: `http://localhost/phpmyadmin`

### MAMP
- **M** = macOS (też Windows)
- **A** = Apache
- **M** = MySQL/MariaDB
- **P** = PHP
- Folder stron: `/Applications/MAMP/htdocs/`
- phpMyAdmin: `http://localhost:8888/phpmyadmin`
- Port domyślny: **8888** (Apache), **8889** (MySQL)

### WAMP
- **W** = Windows
- **A** = Apache
- **M** = MySQL
- **P** = PHP
- Folder stron: `C:\wamp64\www\`

### Laragon
- Nowoczesna alternatywa dla XAMPP na Windows
- Szybszy start, lepsza integracja
- Obsługuje wiele wersji PHP

---

## 11. Etapy publikacji strony

### Środowiska
```
Development (dev)  →  Staging  →  Production
   Lokalne           Testowe      Produkcyjny
   localhost         staging.     www.example.com
                     example.com
```

### Workflow publikacji
1. **Development** - praca lokalna (localhost)
2. **Commit do Git** - wersjonowanie kodu
3. **Push do repozytorium** - GitHub/GitLab
4. **Testy na staging** - środowisko zbliżone do produkcji
5. **Code review** - sprawdzenie kodu przez zespół
6. **Deploy na produkcję** - FTP, SSH, CI/CD pipeline
7. **Monitoring** - sprawdzenie czy wszystko działa

### Deployment przez FTP
```
1. Zbuduj projekt (npm run build)
2. Połącz się z serwerem przez FileZilla/SFTP
3. Prześlij pliki do katalogu public_html/ lub www/
4. Sprawdź stronę w przeglądarce
```

---

## 12. Robots.txt i Sitemap.xml

### robots.txt
- Plik tekstowy w katalogu głównym
- Instrukcje dla robotów (crawlerów) wyszukiwarek
- URL: `https://example.com/robots.txt`

```
# robots.txt - przykład

# Zablokuj wszystkich robotów
User-agent: *
Disallow: /

# Zezwól wszystkim robotom na wszystko
User-agent: *
Allow: /

# Zablokuj konkretne katalogi
User-agent: *
Disallow: /admin/
Disallow: /private/
Disallow: /tmp/

# Tylko Google może indeksować
User-agent: Googlebot
Allow: /
User-agent: *
Disallow: /

# Wskaż sitemap
Sitemap: https://example.com/sitemap.xml
```

### sitemap.xml
- Mapa strony dla robotów wyszukiwarek
- XML zawierający listę URL-i strony
- URL: `https://example.com/sitemap.xml`

```xml
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

  <url>
    <loc>https://example.com/</loc>
    <lastmod>2024-01-15</lastmod>
    <changefreq>daily</changefreq>
    <priority>1.0</priority>
  </url>

  <url>
    <loc>https://example.com/o-nas/</loc>
    <lastmod>2024-01-10</lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.8</priority>
  </url>

  <url>
    <loc>https://example.com/kontakt/</loc>
    <lastmod>2024-01-05</lastmod>
    <changefreq>yearly</changefreq>
    <priority>0.5</priority>
  </url>

</urlset>
```

### changefreq wartości:
`always | hourly | daily | weekly | monthly | yearly | never`

### priority: 0.0 - 1.0 (domyślnie 0.5)

---

## 13. .htaccess - zaawansowane reguły

### Przekierowania
```apache
# 301 - Stałe przekierowanie (SEO juice przeniesiony)
Redirect 301 /stara-strona.html /nowa-strona.html

# 302 - Tymczasowe przekierowanie
Redirect 302 /promo /oferta-specjalna

# RewriteRule (przez mod_rewrite)
RewriteEngine On

# Wymuszenie HTTPS (301)
RewriteCond %{HTTPS} !=on
RewriteRule ^.*$ https://%{SERVER_NAME}%{REQUEST_URI} [R=301,L]

# Usunięcie www (canonical)
RewriteCond %{HTTP_HOST} ^www\.(.*)$ [NC]
RewriteRule ^(.*)$ https://%1/$1 [R=301,L]

# Piękne URL-e (friendly URLs)
RewriteRule ^artykul/([0-9]+)/?$ artykul.php?id=$1 [L,QSA]
```

### Kompresja gzip
```apache
<IfModule mod_deflate.c>
  AddOutputFilterByType DEFLATE text/plain
  AddOutputFilterByType DEFLATE text/html
  AddOutputFilterByType DEFLATE text/xml
  AddOutputFilterByType DEFLATE text/css
  AddOutputFilterByType DEFLATE application/xml
  AddOutputFilterByType DEFLATE application/javascript
  AddOutputFilterByType DEFLATE application/x-javascript
</IfModule>
```

### Blokowanie dostępu
```apache
# Blokuj dostęp do katalogu
<Directory "/var/www/html/private">
  Deny from all
</Directory>

# Blokuj konkretne IP
<RequireAll>
  Require all granted
  Require not ip 192.168.1.100
</RequireAll>

# Chroń konkretne pliki
<FilesMatch "\.(env|log|sql|bak)$">
  Order allow,deny
  Deny from all
</FilesMatch>

# Wyłącz listowanie katalogów
Options -Indexes
```

---

## PODSUMOWANIE DO EGZAMINU

### Najważniejsze fakty:
1. **Shared** = tani, współdzielony, cPanel, mała kontrola
2. **VPS** = wirtualny serwer, root access, dedykowane zasoby
3. **Dedicated** = cały serwer, najdroższy, pełna kontrola
4. **Cloud** = AWS/GCP/Azure, skalowanie, pay-as-you-go
5. **TLD** = .pl (kraj), .com (globalny), .org (organizacje)
6. **Rekord A** = domena → IPv4; **AAAA** = domena → IPv6
7. **CNAME** = alias (www → example.com)
8. **MX** = serwer poczty; **TXT** = SPF, DKIM
9. **Propagacja DNS** = do 48 godzin; TTL = czas cache
10. **HTTPS** = HTTP + TLS; Let's Encrypt = darmowy certyfikat
11. **Apache** = .htaccess, mod_php; **Nginx** = szybszy, event-driven
12. **SFTP port 22** (bezpieczny); **FTP port 21** (niezabezpieczony)
13. **XAMPP** = localhost; folder = `htdocs/`; phpMyAdmin = `localhost/phpmyadmin`
14. **robots.txt** = instrukcje dla crawlerów; `Disallow: /admin/`
15. **301** = stałe przekierowanie (SEO); **302** = tymczasowe
16. `RewriteRule` = mod_rewrite Apache, przyjazne URL-e
17. **cPanel** = panel hostingowy, File Manager, MySQL, Softaculous
