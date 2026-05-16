# ŚCIĄGAWKA: phpMyAdmin (INF.03.4)

> phpMyAdmin — graficzny interfejs webowy do zarządzania bazami MySQL/MariaDB

---

## 1. CO TO JEST phpMyAdmin

- Aplikacja webowa napisana w PHP
- Zarządza bazami MySQL/MariaDB przez przeglądarkę
- Licencja GPL (darmowy, otwartoźródłowy)
- Adres domyślny: `http://localhost/phpmyadmin` (XAMPP/MAMP)
- Alternatywy: Adminer (jeden plik PHP), DBeaver (desktopowy), MySQL Workbench

---

## 2. URUCHOMIENIE W XAMPP i MAMP

### XAMPP (Windows/Linux/Mac)
```
1. Uruchom XAMPP Control Panel
2. Kliknij Start przy Apache i MySQL
3. Wejdź na: http://localhost/phpmyadmin/
   lub: http://127.0.0.1/phpmyadmin/
4. Login: root, Hasło: (puste domyślnie)
```

### MAMP (Mac/Windows)
```
1. Uruchom MAMP → Start Servers
2. Wejdź na: http://localhost:8888/phpmyadmin/
   lub kliknij "Open WebStart page" → phpMyAdmin
3. Login: root, Hasło: root (domyślnie)
```

---

## 3. INTERFEJS phpMyAdmin — MAPA

```
+------------------------------------------+
|  phpMyAdmin  [Strona główna] [SQL] [Stan] |
+------------------+-----------------------+
|  PANEL LEWY      |  PANEL GŁÓWNY         |
|                  |                       |
|  [Bazy danych]   |  Zakładki:            |
|  ├─ information  |  [Bazy danych]        |
|  ├─ mysql        |  [SQL]                |
|  ├─ przepisy     |  [Stan]               |
|  │  ├─ potrawy   |  [Konta użytk.]       |
|  │  ├─ rodzaje   |  [Eksportuj]          |
|  │  └─ ...       |  [Importuj]           |
|  └─ pogoda       |  [Ustawienia]         |
|                  |                       |
+------------------+-----------------------+
```

### Zakładki dla wybranej TABELI:
```
[Przeglądaj] [Struktura] [SQL] [Szukaj] [Wstaw] [Eksportuj] [Importuj] [Uprawnienia] [Operacje]
```

---

## 4. TWORZENIE BAZY DANYCH

```
1. Kliknij "Nowa" w lewym panelu (lub zakładka "Bazy danych")
2. Wpisz nazwę bazy: przepisy
3. Kodowanie: utf8mb4_unicode_ci  (obsługuje polskie znaki + emoji)
4. Kliknij "Utwórz"
```

**Wybór kodowania:**
| Kodowanie | Kiedy używać |
|-----------|-------------|
| `utf8mb4_unicode_ci` | Zalecane — polskie znaki + emoji |
| `utf8_general_ci` | Stare projekty — bez emoji |
| `latin2_general_ci` | Stare polskie projekty (unikaj) |

---

## 5. TWORZENIE TABELI KROK PO KROKU

```
1. Wybierz bazę danych w lewym panelu
2. Wpisz nazwę tabeli: rodzaje
3. Wpisz liczbę kolumn: 2
4. Kliknij "Wykonaj"
```

### Wypełnianie kolumn:
```
Kolumna 1:
  Nazwa: idRodzaje
  Typ:   INT
  Długość: (puste)
  AI:    ✓ (AUTO_INCREMENT)
  Index: PRIMARY

Kolumna 2:
  Nazwa: rodzaj
  Typ:   VARCHAR
  Długość: 50
  Null:  NOT NULL
```

### Krok po kroku ustawianie klucza obcego:
```
1. Otwórz tabelę potrawy → zakładka "Struktura"
2. Kliknij "Widok relacji" (lub "Relacje")
3. W kolumnie idRodzaje:
   - Baza: (aktualna baza)
   - Tabela: rodzaje
   - Kolumna: idRodzaje
4. ON DELETE: RESTRICT (lub CASCADE)
5. ON UPDATE: CASCADE
6. Kliknij "Zapisz"
```

**Uwaga:** Klucze obce działają tylko dla tabel InnoDB!

---

## 6. WSTAWIANIE DANYCH

```
1. Wybierz tabelę → zakładka "Wstaw"
2. Wypełnij pola:
   - idRodzaje: (puste — AUTO_INCREMENT)
   - rodzaj: Zupy
3. Kliknij "Wykonaj"
4. Można wstawić kolejny rekord lub zakończyć
```

**Opcja "Wstaw kolejny rekord"** — checkbox na dole formularza

---

## 7. PRZEGLĄDANIE I EDYTOWANIE DANYCH

```
Zakładka "Przeglądaj":
- Wyświetla wszystkie rekordy (domyślnie 25)
- Ikona ołówka (✏) → edytuj wiersz
- Ikona X (🗑) → usuń wiersz
- Zaznacz checkbox → zaznacz wiele → Usuń zaznaczone

Sortowanie: kliknij nazwę kolumny (↑↓)
Filtrowanie: zakładka "Szukaj"
```

---

## 8. WYKONYWANIE ZAPYTAŃ SQL

```
Zakładka "SQL" (dla bazy lub tabeli):
1. Wpisz zapytanie SQL
2. Kliknij "Wykonaj"
```

### Przykłady zapytań:
```sql
-- Pobierz wszystkie potrawy
SELECT * FROM potrawy;

-- Pobierz potrawę z rodzajem
SELECT potrawy.nazwa, rodzaje.rodzaj 
FROM potrawy 
JOIN rodzaje ON rodzaje.idRodzaje = potrawy.idRodzaje 
WHERE potrawy.idPotrawy = 7;

-- Wstaw nowy rodzaj
INSERT INTO rodzaje (rodzaj) VALUES ('Zupy');

-- Dodaj kolumnę
ALTER TABLE potrawy ADD zdjecie VARCHAR(200);
```

**Historia zapytań:** phpMyAdmin zapamiętuje ostatnie zapytania (zakładka SQL → Historia)

---

## 9. IMPORT DANYCH

### Import pliku .sql (pełna baza):
```
1. Wybierz bazę danych w lewym panelu
2. Zakładka "Importuj"
3. Wybierz plik: baza.sql
4. Format: SQL (automatyczne wykrycie)
5. Kodowanie: utf-8
6. Kliknij "Wykonaj"
```

### Import z CSV:
```
1. Wybierz tabelę → zakładka "Importuj"
2. Wybierz plik: dane.csv
3. Format: CSV
4. Separator kolumn: , (przecinek)
5. Separator tekstu: " (cudzysłów)
6. Kliknij "Wykonaj"
```

**Częsty problem:** plik .sql większy niż `upload_max_filesize` w php.ini  
**Rozwiązanie:** Zmień w php.ini: `upload_max_filesize = 128M` i `post_max_size = 128M`

---

## 10. EKSPORT DANYCH

### Szybki eksport (cała baza):
```
1. Wybierz bazę danych
2. Zakładka "Eksportuj"
3. Metoda: Szybka
4. Format: SQL
5. Kliknij "Wykonaj"
→ Pobierze plik baza.sql
```

### Eksport z opcjami (własny):
```
1. Metoda: Własna
2. Wybierz tabele (można odznaczyć)
3. Opcje OUTPUT:
   - Kompresja: bez kompresji / gzip / bzip2
4. Opcje FORMAT (SQL):
   - Struktura: ✓ (CREATE TABLE)
   - Dane: ✓ (INSERT INTO)
   - Tylko struktura (bez danych)
   - Tylko dane (bez struktury)
5. Kliknij "Wykonaj"
```

### Eksport do CSV:
```
Format: CSV
Separator: , lub ;
Nagłówki kolumn: ✓
```

### Eksport do Excel:
```
Format: Microsoft Excel 2007 (xlsx)
```

---

## 11. ZARZĄDZANIE UŻYTKOWNIKAMI

### Dodawanie użytkownika:
```
1. Kliknij "Konta użytkowników" (na stronie głównej)
2. Kliknij "Dodaj konto użytkownika"
3. Wypełnij:
   - Nazwa użytkownika: webuser
   - Nazwa hosta: localhost
   - Hasło: ****
   - Powtórz hasło: ****
4. Uprawnienia globalne:
   - SELECT, INSERT, UPDATE, DELETE (dla zwykłego użytkownika)
   - Wszystkie uprawnienia (dla admina)
5. Kliknij "Wykonaj"
```

### Uprawnienia do konkretnej bazy:
```
1. Kliknij użytkownika → "Edytuj uprawnienia"
2. Sekcja "Uprawnienia specyficzne dla bazy"
3. Wybierz bazę z listy
4. Zaznacz uprawnienia: SELECT, INSERT, UPDATE, DELETE
5. Kliknij "Wykonaj"
```

### SQL odpowiednik operacji phpMyAdmin:
```sql
CREATE USER 'webuser'@'localhost' IDENTIFIED BY 'haslo';
GRANT SELECT, INSERT, UPDATE, DELETE ON przepisy.* TO 'webuser'@'localhost';
FLUSH PRIVILEGES;
```

---

## 12. DESIGNER — GRAFICZNY EDYTOR RELACJI

```
1. Wybierz bazę danych
2. Zakładka "Designer" (może być ukryta → "Więcej")
3. Wyświetla tabele jako bloki
4. Łącz tabele przeciągając kolumny
5. Zapisz relacje
```

**Warunek:** Tabele muszą być InnoDB (widać w "Operacje" → "Silnik tabeli")

---

## 13. OPTYMALIZACJA TABEL

```
1. Wybierz tabelę → zakładka "Operacje"

Dostępne operacje:
- ANALYZE TABLE  → aktualizuje statystyki indeksów
- OPTIMIZE TABLE → defragmentuje tabelę, odzyskuje miejsce
- CHECK TABLE    → sprawdza błędy w tabeli
- REPAIR TABLE   → naprawia uszkodzoną tabelę (tylko MyISAM)
```

---

## 14. ZMIANA SILNIKA TABELI

```
1. Wybierz tabelę → zakładka "Operacje"
2. Sekcja "Opcje tabeli"
3. "Silnik pamięci masowej": zmień z MyISAM na InnoDB
4. Kliknij "Wykonaj"
```

**Dlaczego InnoDB?** Tylko InnoDB obsługuje klucze obce i transakcje.

---

## 15. KONFIGURACJA phpMyAdmin

Plik konfiguracyjny: `config.inc.php` (w folderze phpMyAdmin)

### Typowe ustawienia:
```php
// Hasło blowfish do szyfrowania ciasteczek
$cfg['blowfish_secret'] = 'losowy_ciag_znakow_min_32_znaki';

// Automatyczne logowanie (tylko localhost!)
$cfg['Servers'][$i]['auth_type'] = 'config';
$cfg['Servers'][$i]['user'] = 'root';
$cfg['Servers'][$i']['password'] = '';

// Ukryj systemowe bazy (information_schema, mysql)
$cfg['Servers'][$i]['hide_db'] = '^(information_schema|mysql|performance_schema|sys)$';

// Limit wierszy
$cfg['MaxRows'] = 50;

// Limit importu
$cfg['UploadDir'] = '';    // folder do uploadu dużych plików
```

---

## 16. TYPOWE PROBLEMY I ROZWIĄZANIA

### Problem: Blank page / biała strona
```
Przyczyna: Błąd PHP w phpMyAdmin
Rozwiązanie:
1. Sprawdź logi PHP: /var/log/apache2/error.log
2. Włącz display_errors w php.ini: display_errors = On
3. Sprawdź wersję PHP (phpMyAdmin wymaga min PHP 7.4)
```

### Problem: "Brak uprawnień" / Access denied
```
Rozwiązanie:
1. Zaloguj się jako root
2. SQL: GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost';
3. SQL: FLUSH PRIVILEGES;
4. Lub zresetuj hasło root MySQL
```

### Problem: "Max packet size exceeded"
```
Przyczyna: Plik .sql za duży
Rozwiązanie w php.ini (plik MAMP/XAMPP):
  upload_max_filesize = 128M
  post_max_size = 128M
  memory_limit = 256M
  max_execution_time = 300
Restart Apache po zmianach.
```

### Problem: Timeout podczas importu
```
php.ini:
  max_execution_time = 600
  max_input_time = 600
Lub użyj konsoli: mysql -u root -p baza < plik.sql
```

### Problem: Polskie znaki nie działają
```
1. Baza danych → kodowanie: utf8mb4_unicode_ci
2. Tabela → kodowanie: utf8mb4_unicode_ci
3. Plik PHP: header('Content-Type: text/html; charset=UTF-8');
4. W PHP: $conn->set_charset('utf8mb4');
```

---

## 17. SKRÓTY KLAWIATUROWE phpMyAdmin

| Skrót | Akcja |
|-------|-------|
| `Ctrl+Enter` | Wykonaj zapytanie SQL |
| `F3` | Szukaj następny |
| `Ctrl+Z` | Cofnij w edytorze SQL |

---

## 18. phpMyAdmin vs KONSOLA MySQL

| Operacja | phpMyAdmin | Konsola MySQL |
|----------|-----------|--------------|
| Tworzenie bazy | Kliknij "Nowa" | `CREATE DATABASE nazwa;` |
| Import .sql | Zakładka Importuj | `mysql -u root -p baza < plik.sql` |
| Eksport | Zakładka Eksportuj | `mysqldump -u root -p baza > plik.sql` |
| Szybkość | Wolniejszy | Szybszy |
| Duże pliki | Problematyczny (limit) | Brak limitu |
| Wizualizacja | Tak | Nie |

---

## 19. PHPYADMIN W KONTEKŚCIE EGZAMINU INF.03

Na egzaminie możesz otrzymać zadanie:
1. **Utwórz bazę danych** — Nowa → nazwa → utf8mb4 → Utwórz
2. **Utwórz tabelę z PK** — Struktura → PRIMARY + AUTO_INCREMENT
3. **Importuj dane** — Importuj → wybierz plik .sql → Wykonaj
4. **Wykonaj zapytanie** — Zakładka SQL → wpisz → Wykonaj
5. **Eksportuj bazę** — Eksportuj → Szybka → SQL → Wykonaj

### Kolejność tworzenia bazy na egzaminie:
```
1. Utwórz bazę danych (nazwa + utf8mb4)
2. Wybierz bazę
3. Utwórz tabele (najpierw te bez FK, potem z FK)
4. Ustaw relacje w "Widok relacji"
5. Wstaw przykładowe dane ("Wstaw")
6. Przetestuj zapytanie w zakładce "SQL"
```

---

**Wróć do: [03_MYSQL_ZARZADZANIE.md](../03_MYSQL_ZARZADZANIE.md)**
