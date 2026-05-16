# 📚 ŚCIĄGAWKI DO EGZAMINU INF.03 — TECHNIK PROGRAMISTA

> **38 plików · ~30 000 linii · wszystkie sekcje + ćwiczenia + testy + diagramy**

Komprehensywna kolekcja ściaģawek przygotowujących do egzaminu zawodowego  
**INF.03 – Tworzenie i administrowanie stronami i aplikacjami internetowymi oraz bazami danych**

---

## ⚡ ZACZNIJ TUTAJ: Wzorzec egzaminacyjny

> **[WZORZEC_EGZAMINACYJNY.md](./WZORZEC_EGZAMINACYJNY.md)** ← przeczytaj jako pierwszy!

Oparty na analizie prawdziwych egzaminów 2024–2026. Zawiera:
- Kompletny wzorzec pliku PHP z połączeniem MySQL
- Float layout CSS (dokładnie jak w egzaminie)
- 4 typowe kwerendy SQL z egzaminów
- Checklistę przed oddaniem pracy
- 7 najczęstszych błędów zdających + rozwiązania
- Techniki debugowania (blank page, błąd SQL)

---

## 📂 MAPA ŚCIAĢAWEK

### 🔴 INF.03.1 – Bezpieczeństwo i Higiena Pracy
| Plik | Zawartość |
|------|-----------|
| [SCIAGAWKA_BHP_Rozszerzona.md](./INF.03.1_BHP/SCIAGAWKA_BHP_Rozszerzona.md) | Prawo BHP, organy nadzoru (PIP/PIS/UDT), obowiązki pracownika, zagrożenia biurowe, ergonomia, RKO krok po kroku, środki ochrony PPE |

### 🟠 INF.03.2 – Podstawy Informatyki
| Plik | Zawartość |
|------|-----------|
| [01_SIECI_SYSTEMY.md](./INF.03.2_Podstawy_informatyki/01_SIECI_SYSTEMY.md) | Topologie sieci, model OSI (7 warstw), TCP/IP (4 warstwy), protokoły z portami, IPv4/maski, WiFi 802.11, systemy liczbowe z konwersjami krok po kroku, kod U2, operacje logiczne AND/OR/XOR, cyberbezpieczeństwo (malware + ataki), parametry sprzętu, RODO, WCAG 2.0 |

### 🟡 INF.03.3 – Projektowanie Stron Internetowych
| Plik | Zawartość |
|------|-----------|
| [HTML/01_HTML_TAGS.md](./INF.03.3_Projektowanie_stron/HTML/01_HTML_TAGS.md) | Semantyczne znaczniki HTML5, formularze (wszystkie typy input), tabele, media, atrybuty ARIA, dostępność |
| [CSS/01_CSS_SELEKTORY.md](./INF.03.3_Projektowanie_stron/CSS/01_CSS_SELEKTORY.md) | Selektory (element/klasa/ID/atrybut/pseudo), box model, kolory, typografia, transformacje, animacje |
| [CSS/02_CSS_LAYOUT.md](./INF.03.3_Projektowanie_stron/CSS/02_CSS_LAYOUT.md) | **Float layout (wzorzec z egzaminu!)**, clearfix, Flexbox (pełna ściąga), Grid, pozycjonowanie, responsive/media queries |
| [JavaScript/01_JS_BASICS.md](./INF.03.3_Projektowanie_stron/JavaScript/01_JS_BASICS.md) | Zmienne, pętle, funkcje, tablice, DOM API, eventy, fetch API, async/await |
| [JavaScript/02_JQUERY.md](./INF.03.3_Projektowanie_stron/JavaScript/02_JQUERY.md) | Selektory jQuery, metody DOM, eventy, AJAX, animacje, traversal, walidacja formularzy |
| [Grafika/01_GRAFIKA.md](./INF.03.3_Projektowanie_stron/Grafika/01_GRAFIKA.md) | Rastrowa vs wektorowa, formaty (JPEG/PNG/GIF/WebP/SVG), modele barw (RGB/CMYK/HSL/Hex), głębia bitowa, optymalizacja, programy graficzne, CSS background |
| [Multimedia/01_VIDEO_AUDIO.md](./INF.03.3_Projektowanie_stron/Multimedia/01_VIDEO_AUDIO.md) | Formaty wideo/audio, kodeki vs kontenery, HTML5 `<video>`/`<audio>`, responsive video, YouTube embed, Canvas |
| [Hosting/01_HOSTING_DOMENY.md](./INF.03.3_Projektowanie_stron/Hosting/01_HOSTING_DOMENY.md) | Rodzaje hostingu (shared/VPS/cloud), domeny i TLD, rekordy DNS, SSL/Let's Encrypt, Apache vs Nginx, .htaccess, FTP/SFTP, XAMPP/MAMP |
| [Testowanie/01_TESTOWANIE_WALIDACJA.md](./INF.03.3_Projektowanie_stron/Testowanie/01_TESTOWANIE_WALIDACJA.md) | DevTools (F12), walidacja HTML/CSS (W3C), SEO (meta, OpenGraph, Core Web Vitals), WCAG 2.0 (A/AA/AAA), PageSpeed, Lighthouse |

### 🟢 INF.03.4 – Projektowanie i Administrowanie Bazami Danych
| Plik | Zawartość |
|------|-----------|
| [SQL/01_SQL_BASICS.md](./INF.03.4_Bazy_danych/SQL/01_SQL_BASICS.md) | DDL/DML/DCL/TCL, typy danych, CREATE/ALTER/DROP, SELECT/INSERT/UPDATE/DELETE, JOINy, GROUP BY, widoki, indeksy, transakcje |
| [SQL/02_SQL_ZAAWANSOWANY.md](./INF.03.4_Bazy_danych/SQL/02_SQL_ZAAWANSOWANY.md) | **Wzorce z prawdziwych egzaminów 2024–2026**, 20+ przykładów, LIKE/REGEXP, funkcje daty/stringów, CASE WHEN, podzapytania, ALTER TABLE, mnemotechnika |
| [02_ER_NORMALIZACJA.md](./INF.03.4_Bazy_danych/02_ER_NORMALIZACJA.md) | Pojęcia baz danych, typy danych MySQL, notacje E-R (Chen/UML/Crow's Foot), relacje 1:1/1:N/M:N z SQL, normalizacja 1NF→3NF z przykładami tabel |
| [03_MYSQL_ZARZADZANIE.md](./INF.03.4_Bazy_danych/03_MYSQL_ZARZADZANIE.md) | CREATE/GRANT/REVOKE użytkownicy, mysqldump (backup), phpMyAdmin krok po kroku, EXPLAIN/indeksy/ANALYZE, MariaDB vs MySQL, InnoDB vs MyISAM, triggery, procedury |
| [MariaDB/01_MARIADB.md](./INF.03.4_Bazy_danych/MariaDB/01_MARIADB.md) | Historia MariaDB, różnice vs MySQL, silniki (InnoDB/MyISAM/Aria), window functions, typy INET6/UUID, konfiguracja, backup mariabackup, replikacja Galera |
| [MySQL/01_MYSQL_QUICK.md](./INF.03.4_Bazy_danych/MySQL/01_MYSQL_QUICK.md) | Szybka referencja MySQL: wszystkie typy danych, DDL/DML/JOINy, funkcje daty/stringów, procedury, triggery, EXPLAIN, typowe błędy z rozwiązaniami |
| [PhpMyAdmin/01_PHPMYADMIN.md](./INF.03.4_Bazy_danych/PhpMyAdmin/01_PHPMYADMIN.md) | Interfejs phpMyAdmin, tworzenie baz/tabel, import/eksport (.sql/.csv), relacje, zarządzanie użytkownikami, optymalizacja, typowe problemy |

### 🔵 INF.03.5 – Programowanie Aplikacji Internetowych
| Plik | Zawartość |
|------|-----------|
| [PHP/01_PHP_BASICS.md](./INF.03.5_Programowanie_aplikacji/PHP/01_PHP_BASICS.md) | Syntax, zmienne, tablice, pętle, funkcje, formularze GET/POST, sesje, cookies, podstawy MySQLi |
| [PHP/02_PHP_MYSQL_EGZAMIN.md](./INF.03.5_Programowanie_aplikacji/PHP/02_PHP_MYSQL_EGZAMIN.md) | **Kompletny wzorzec egzaminacyjny PHP+MySQL**, MySQLi OOP vs proceduralne, fetch_assoc/fetch_row, walidacja, CRUD w PHP, 7 typowych błędów z rozwiązaniami |
| [JavaScript/01_JS_APLIKACJE.md](./INF.03.5_Programowanie_aplikacji/JavaScript/01_JS_APLIKACJE.md) | JS w aplikacjach: Fetch API + PHP backend, LocalStorage, FormData, walidacja, AJAX, XSS/CSRF ochrona, debugging, wzorce projektowe |

### 🟤 CMS – WordPress i Joomla
| Plik | Zawartość |
|------|-----------|
| [CMS/00_CMS_INTRO.md](./CMS/00_CMS_INTRO.md) | Porównanie CMS-ów (WordPress/Joomla/Drupal/Magento), zalety, wady, kiedy używać |
| [CMS/WordPress/SCIAGAWKA_WordPress.md](./CMS/WordPress/SCIAGAWKA_WordPress.md) | Instalacja, panel admina, wpisy/strony/media, wtyczki, motywy, użytkownicy, bezpieczeństwo |
| [CMS/Joomla/SCIAGAWKA_Joomla.md](./CMS/Joomla/SCIAGAWKA_Joomla.md) | Instalacja, komponenty, moduły, szablony, zarządzanie użytkownikami |

### ⚪ INF.03.6 – Język Obcy Zawodowy
| Plik | Zawartość |
|------|-----------|
| [01_IT_SLOWNICTWO.md](./INF.03.6_Język_obcy/01_IT_SLOWNICTWO.md) | 6 kategorii słownictwa EN/PL (bazy danych, frontend, backend, sieć, bezpieczeństwo, programowanie), kody HTTP, błędy MySQL/PHP, skróty IT |

### ⚪ INF.03.7 – Kompetencje Personalne i Społeczne
| Plik | Zawartość |
|------|-----------|
| [01_KOMPETENCJE.md](./INF.03.7_Kompetencje/01_KOMPETENCJE.md) | Etyka zawodowa, zarządzanie czasem (Pomodoro, macierz Eisenhowera), kreatywność (SCAMPER), stres i burnout, certyfikaty IT, komunikacja (model FUKO), negocjacje (BATNA), 5 WHY, model Belbina, etapy Tuckmana |

### ⚪ INF.03.8 – Organizacja Pracy Małych Zespołów
| Plik | Zawartość |
|------|-----------|
| [01_ORGANIZACJA_PRACY.md](./INF.03.8_Organizacja/01_ORGANIZACJA_PRACY.md) | Role w projekcie IT, Waterfall/Scrum/Kanban/Agile z tabelami, Manifest Agile, Jira/Trello/GitHub Projects, Git workflow, Diagram Gantta, dokumentacja (SRS/TDD/README), ceremonie Scrum |

---

## 📐 DIAGRAMY ASCII

| Plik | Zawartość |
|------|-----------|
| [Diagramy/01_ER_DIAGRAMY.md](./Diagramy/01_ER_DIAGRAMY.md) | Diagramy E-R baz `przepisy`, `pogoda`, e-sklep, szkoła w ASCII — Crow's Foot, Chen, UML |
| [Diagramy/02_ARCHITEKTURA_CMS.md](./Diagramy/02_ARCHITEKTURA_CMS.md) | Architektura WordPress/Joomla, model MVC, struktura folderów, schemat tabel WP/Joomla |
| [Diagramy/03_PRZEPLYW_DANYCH.md](./Diagramy/03_PRZEPLYW_DANYCH.md) | HTTP request flow, PHP+MySQL pipeline, OSI/TCP-IP, DNS, SSL handshake, upload pliku |

---

## 📝 ĆWICZENIA PRAKTYCZNE

| Plik | Zawartość |
|------|-----------|
| [Cwiczenia/01_SQL_CWICZENIA.md](./Cwiczenia/01_SQL_CWICZENIA.md) | 25 zadań SQL z rozwiązaniami — SELECT/JOIN/GROUP BY/INSERT/ALTER na bazach `przepisy` i `pogoda` |
| [Cwiczenia/02_HTML_CSS_CWICZENIA.md](./Cwiczenia/02_HTML_CSS_CWICZENIA.md) | 20 zadań HTML/CSS z rozwiązaniami — float layout, responsive, animacje, formularze, Grid |
| [Cwiczenia/03_PHP_CWICZENIA.md](./Cwiczenia/03_PHP_CWICZENIA.md) | 12 zadań PHP+MySQL — lista, szczegóły, formularze, sesja, upload, paginacja, JSON API |

---

## 🧪 TESTY EGZAMINACYJNE

| Plik | Zawartość |
|------|-----------|
| [Testy/01_TEST_PYTANIA.md](./Testy/01_TEST_PYTANIA.md) | **60 pytań A/B/C/D** ze wszystkich działów INF.03 z wyjaśnieniami |
| [Testy/02_TEST_SQL.md](./Testy/02_TEST_SQL.md) | 25 pytań SQL — DDL, DML, JOINy, GROUP BY, wzorce egzaminacyjne |
| [Testy/03_TEST_PHP_HTML_CSS.md](./Testy/03_TEST_PHP_HTML_CSS.md) | 35 pytań PHP/HTML/CSS — formularze, sesje, MySQLi, selektory, float layout |

---

## 🎯 CO NAJCZĘŚCIEJ NA EGZAMINIE

Na podstawie analizy egzaminów INF.03 z lat 2024–2026:

### SQL (zawsze 4 kwerendy)
```sql
-- Wzorzec 1: SELECT z WHERE (zawsze!)
SELECT kolumna1, kolumna2 FROM tabela WHERE id = 7;

-- Wzorzec 2: JOIN z warunkiem (bardzo często!)
SELECT t1.pole, t2.pole FROM tabela1 t1
JOIN tabela2 t2 ON t2.id = t1.id_t2
WHERE t1.id = 7;

-- Wzorzec 3: GROUP BY z AVG/COUNT (często!)
SELECT t2.nazwa, AVG(t1.wartosc) FROM tabela1 t1
JOIN tabela2 t2 ON t2.id = t1.id_t2
GROUP BY t2.nazwa;

-- Wzorzec 4: INSERT lub ALTER TABLE (często!)
INSERT INTO tabela (pole1, pole2) VALUES ('wartość', 123);
-- lub:
ALTER TABLE tabela ADD kolumna VARCHAR(200);
```

### PHP (zawsze to samo połączenie!)
```php
<?php
$polaczenie = new mysqli("localhost", "root", "", "nazwa_bazy");
$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

$zapytanie = "SELECT t1.pole, t2.pole FROM t1 JOIN t2 ON t2.id = t1.id_t2 WHERE t1.id = $id";
$rezultat = $polaczenie->query($zapytanie);
$wiersz = $rezultat->fetch_assoc();
echo $wiersz['pole'];

$polaczenie->close();
?>
```

### CSS (float layout!)
```css
aside, main, section { float: left; }
.clear-both { clear: both; }
```

---

## 📅 PLAN NAUKI (20 dni do 100%)

| Dni | Temat | Pliki |
|-----|-------|-------|
| 1–2 | **BHP + Podstawy** | INF.03.1, INF.03.2 |
| 3–5 | **HTML + CSS** | HTML, CSS selektory, CSS layout |
| 6–8 | **SQL podstawy + JOIN** | SQL basics, SQL zaawansowany |
| 9–11 | **PHP + MySQL** | PHP basics, **PHP egzamin** ⭐ |
| 12–14 | **Bazy danych zaawansowane** | E-R, normalizacja, MySQL zarządzanie |
| 15–16 | **CMS** | WordPress, Joomla |
| 17 | **JavaScript + jQuery** | JS basics, jQuery |
| 18 | **Grafika + Multimedia + Hosting** | Grafika, Video/Audio, Hosting |
| 19 | **Pozostałe** | INF.03.6, 3.7, 3.8 |
| 20 | **POWTÓRKA** | **WZORZEC EGZAMINACYJNY** ⭐ |

---

## ✅ CHECKSLISTA PRZED EGZAMINEM

### SQL
- [ ] Umiem pisać SELECT z WHERE i JOIN jednocześnie
- [ ] Umiem GROUP BY z AVG(), COUNT(), SUM()
- [ ] Umiem ALTER TABLE ADD COLUMN
- [ ] Umiem INSERT INTO z VALUES

### PHP + MySQL
- [ ] Umiem połączyć się z bazą (`new mysqli()`)
- [ ] Umiem pobrać parametr z URL (`$_GET['id']`)
- [ ] Umiem wykonać query i pobrać wynik (`fetch_assoc()`)
- [ ] Umiem wyświetlić dane w HTML (`echo $wiersz['pole']`)
- [ ] Umiem iterować po wielu wynikach (`foreach`)

### CSS
- [ ] Umiem float layout (aside + main + section obok siebie)
- [ ] Umiem `clear: both` na elementach po float
- [ ] Umiem background-image z URL
- [ ] Umiem selektory: element, klasa, ID, pseudo (:hover)

### HTML
- [ ] Umiem tagi semantyczne: header, nav, main, aside, section, footer
- [ ] Umiem formularz z action i method

---

**25 plików · ~12 400 linii · Powodzenia na egzaminie! 🎓**
