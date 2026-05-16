# ŚCIĄGAWKA: MySQL — Szybka Referencja (INF.03.4)

> Egzamin INF.03 — Technik Programista | Bazy danych
> Dotyczy MySQL 5.7 / 8.0 i MariaDB 10.x (kompatybilne)

---

## Spis treści

1. [Typy danych MySQL](#1-typy-danych-mysql)
2. [Ograniczenia (Constraints)](#2-ograniczenia-constraints)
3. [DDL — CREATE TABLE](#3-ddl--create-table)
4. [DDL — ALTER TABLE](#4-ddl--alter-table)
5. [DML — SELECT](#5-dml--select)
6. [DML — INSERT](#6-dml--insert)
7. [DML — UPDATE z JOIN](#7-dml--update-z-join)
8. [DML — DELETE, TRUNCATE, DROP](#8-dml--delete-truncate-drop)
9. [JOINy](#9-jointy)
10. [GROUP BY, HAVING, ORDER BY, LIMIT](#10-group-by-having-order-by-limit)
11. [Funkcje agregujące](#11-funkcje-agregujące)
12. [Funkcje daty](#12-funkcje-daty)
13. [Funkcje stringów](#13-funkcje-stringów)
14. [Funkcje matematyczne](#14-funkcje-matematyczne)
15. [Podzapytania](#15-podzapytania)
16. [Widoki (VIEW)](#16-widoki-view)
17. [Indeksy](#17-indeksy)
18. [Transakcje i ACID](#18-transakcje-i-acid)
19. [Procedury i funkcje składowane](#19-procedury-i-funkcje-składowane)
20. [Triggery](#20-triggery)
21. [Użytkownicy i uprawnienia](#21-użytkownicy-i-uprawnienia)
22. [Zmienne systemowe](#22-zmienne-systemowe)
23. [EXPLAIN — analiza zapytań](#23-explain--analiza-zapytań)
24. [Typowe błędy MySQL](#24-typowe-błędy-mysql)
25. [Anti-patterns — czego unikać](#25-anti-patterns--czego-unikać)

---

## 1. Typy danych MySQL

### Typy numeryczne całkowite

| Typ | Bajty | Zakres (ze znakiem) | Zakres (bez znaku UNSIGNED) |
|-----|-------|--------------------|-----------------------------|
| TINYINT | 1 | -128 do 127 | 0 do 255 |
| SMALLINT | 2 | -32 768 do 32 767 | 0 do 65 535 |
| MEDIUMINT | 3 | -8 388 608 do 8 388 607 | 0 do 16 777 215 |
| INT / INTEGER | 4 | -2 147 483 648 do 2 147 483 647 | 0 do 4 294 967 295 |
| BIGINT | 8 | -9.2×10^18 do 9.2×10^18 | 0 do 1.8×10^19 |

```sql
-- Przykłady
CREATE TABLE typy_numeryczne (
    wiek TINYINT UNSIGNED,           -- 0-255 (np. wiek osoby)
    ilosc SMALLINT UNSIGNED,         -- 0-65535 (np. ilość produktów)
    id_uzytkownika INT UNSIGNED,     -- 0-4294967295 (typowe ID)
    ilosc_klikniecs BIGINT UNSIGNED  -- duże liczniki
);
```

### Typy numeryczne zmiennoprzecinkowe

| Typ | Bajty | Precyzja | Uwagi |
|-----|-------|----------|-------|
| FLOAT | 4 | ~7 cyfr znaczących | Przybliżony, unika przy finansach |
| DOUBLE | 8 | ~15 cyfr znaczących | Przybliżony, unika przy finansach |
| DECIMAL(M,D) | Zmienna | Dokładny | M cyfr łącznie, D po przecinku |
| NUMERIC(M,D) | Zmienna | Dokładny | Alias DECIMAL |

```sql
-- DECIMAL dla wartości finansowych
cena DECIMAL(10, 2)    -- maks 10 cyfr, 2 po przecinku (np. 99999999.99)
vat DECIMAL(5, 4)      -- np. 0.2300 (23%)
temperatura FLOAT      -- przybliżona wartość pomiarowa

-- Przykład
CREATE TABLE produkty (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nazwa VARCHAR(200),
    cena DECIMAL(10, 2) NOT NULL,
    cena_zakupu DECIMAL(10, 2),
    waga FLOAT  -- kilogramy, przybliżona wartość
);
```

### Typy tekstowe

| Typ | Maks. rozmiar | Cechy |
|-----|--------------|-------|
| CHAR(n) | 255 znaków | Stała długość, szybszy dostęp, wypełniany spacjami |
| VARCHAR(n) | 65 535 bajtów | Zmienna długość, oszczędza miejsce |
| TINYTEXT | 255 bajtów | Małe teksty |
| TEXT | 65 535 bajtów (~64 KB) | Standardowe teksty |
| MEDIUMTEXT | 16 777 215 bajtów (~16 MB) | Duże teksty |
| LONGTEXT | 4 294 967 295 bajtów (~4 GB) | Bardzo duże teksty |

```sql
-- Kiedy używać CHAR vs VARCHAR
kod_pocztowy CHAR(6)        -- zawsze 6 znaków: "00-001"
kraj_kod CHAR(2)            -- zawsze 2: "PL", "DE"
imie VARCHAR(50)            -- zmienne długości
email VARCHAR(255)          -- maks. 255 znaków (standard RFC)
opis TEXT                   -- długi opis produktu
tytul_artykulu VARCHAR(500) -- tytuł artykułu
tresc_artykulu LONGTEXT     -- pełna treść artykułu/książki
```

### Typy binarne

| Typ | Maks. rozmiar | Cechy |
|-----|--------------|-------|
| BINARY(n) | 255 bajtów | Stała długość, binarny odpowiednik CHAR |
| VARBINARY(n) | 65 535 bajtów | Zmienna długość, binarny odpowiednik VARCHAR |
| TINYBLOB | 255 bajtów | Małe dane binarne |
| BLOB | 65 535 bajtów | Dane binarne (Binary Large Object) |
| MEDIUMBLOB | 16 MB | Obrazy, pliki audio |
| LONGBLOB | 4 GB | Duże pliki, filmy |

```sql
-- Przykłady
hash_md5 BINARY(16)          -- 16 bajtów = hash MD5
hash_sha256 BINARY(32)       -- 32 bajty = hash SHA-256
miniatura BLOB               -- mała grafika
plik_pdf LONGBLOB            -- plik PDF
uuid_bin BINARY(16)          -- UUID w postaci binarnej
```

### Typy daty i czasu

| Typ | Format | Zakres | Rozmiar |
|-----|--------|--------|---------|
| DATE | YYYY-MM-DD | 1000-01-01 do 9999-12-31 | 3 bajty |
| TIME | HH:MM:SS | -838:59:59 do 838:59:59 | 3 bajty |
| DATETIME | YYYY-MM-DD HH:MM:SS | 1000-01-01 00:00:00 do 9999-12-31 23:59:59 | 8 bajtów |
| TIMESTAMP | YYYY-MM-DD HH:MM:SS | 1970-01-01 00:00:01 do 2038-01-19 03:14:07 | 4 bajty |
| YEAR | YYYY | 1901 do 2155 | 1 bajt |

```sql
-- Ważne różnice: DATETIME vs TIMESTAMP
-- TIMESTAMP: konwertowany do UTC przy zapisie, z powrotem przy odczycie
-- DATETIME: zapisywany tak jak jest (bez konwersji strefy czasowej)
-- TIMESTAMP: problem roku 2038! (32-bit Unix timestamp)

CREATE TABLE zdarzenia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tytul VARCHAR(200),
    data_urodzin DATE,                     -- tylko data
    czas_trwania TIME,                     -- czas trwania
    data_i_czas DATETIME,                  -- dokładna data i czas
    data_modyfikacji TIMESTAMP             -- automatyczna aktualizacja
        DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,
    rok_produkcji YEAR                     -- rok
);
```

### Typy specjalne

```sql
-- ENUM — lista dozwolonych wartości (przechowywana jako liczba)
status ENUM('aktywny', 'nieaktywny', 'oczekujacy', 'zablokowany')
plec ENUM('M', 'K', 'N')

-- SET — zestaw wartości (można wybrać wiele)
uprawnienia SET('czytaj', 'pisz', 'usun', 'admin')
dni_pracy SET('Pon', 'Wt', 'Sr', 'Czw', 'Pt', 'Sob', 'Nd')

-- JSON (MySQL 5.7.8+, MariaDB jako LONGTEXT)
dane_dodatkowe JSON

-- GEOMETRY (dane przestrzenne)
lokalizacja POINT
obszar POLYGON
trasa LINESTRING
```

---

## 2. Ograniczenia (Constraints)

### Przegląd ograniczeń

| Ograniczenie | Opis | Przykład |
|-------------|------|----------|
| PRIMARY KEY | Unikalny identyfikator wiersza, NOT NULL | `id INT PRIMARY KEY` |
| FOREIGN KEY | Klucz obcy — relacja między tabelami | `FOREIGN KEY (col) REFERENCES ...` |
| UNIQUE | Wartość unikalna w kolumnie | `email VARCHAR(255) UNIQUE` |
| NOT NULL | Wartość wymagana | `imie VARCHAR(50) NOT NULL` |
| DEFAULT | Wartość domyślna | `status VARCHAR(20) DEFAULT 'aktywny'` |
| CHECK | Walidacja wartości (MySQL 8.0.16+) | `CHECK (wiek >= 0 AND wiek <= 150)` |
| AUTO_INCREMENT | Automatyczna inkrementacja (dla INT PK) | `id INT AUTO_INCREMENT` |

```sql
-- Przykłady wszystkich ograniczeń
CREATE TABLE pracownicy (
    -- PRIMARY KEY + AUTO_INCREMENT
    id INT AUTO_INCREMENT PRIMARY KEY,

    -- NOT NULL
    imie VARCHAR(50) NOT NULL,
    nazwisko VARCHAR(50) NOT NULL,

    -- UNIQUE
    email VARCHAR(255) NOT NULL UNIQUE,
    pesel CHAR(11) UNIQUE,

    -- DEFAULT
    data_zatrudnienia DATE DEFAULT (CURRENT_DATE),
    aktywny TINYINT(1) DEFAULT 1,
    pensja DECIMAL(10,2) DEFAULT 0.00,

    -- CHECK (MySQL 8.0.16+)
    wiek TINYINT UNSIGNED CHECK (wiek >= 18 AND wiek <= 70),
    pensja_min DECIMAL(10,2) CHECK (pensja_min >= 0),

    -- FOREIGN KEY
    dzial_id INT,
    FOREIGN KEY (dzial_id) REFERENCES dzialy(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

-- Ograniczenia na poziomie tabeli (named constraints)
CREATE TABLE zamowienia (
    id INT AUTO_INCREMENT,
    klient_id INT NOT NULL,
    produkt_id INT NOT NULL,
    ilosc INT NOT NULL,
    cena DECIMAL(10,2) NOT NULL,

    -- Named primary key
    CONSTRAINT pk_zamowienia PRIMARY KEY (id),

    -- Named foreign keys
    CONSTRAINT fk_zam_klient FOREIGN KEY (klient_id)
        REFERENCES klienci(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_zam_produkt FOREIGN KEY (produkt_id)
        REFERENCES produkty(id) ON DELETE RESTRICT ON UPDATE CASCADE,

    -- Named unique
    CONSTRAINT uq_zam_uniq UNIQUE (klient_id, produkt_id, data_zamowienia),

    -- Named check
    CONSTRAINT chk_ilosc CHECK (ilosc > 0),
    CONSTRAINT chk_cena CHECK (cena > 0)
);
```

### Opcje FOREIGN KEY

```sql
-- ON DELETE / ON UPDATE opcje:
-- RESTRICT  — zabrania usunięcia/modyfikacji rodzica jeśli są dzieci (DEFAULT)
-- CASCADE   — usuwa/aktualizuje dzieci razem z rodzicem
-- SET NULL  — ustawia FK na NULL przy usunięciu/modyfikacji rodzica
-- NO ACTION — jak RESTRICT (sprawdzanie po transakcji)
-- SET DEFAULT — ustawia domyślną wartość (rzadko używane)

-- Przykład kaskadowego usuwania
CREATE TABLE komentarze (
    id INT AUTO_INCREMENT PRIMARY KEY,
    artykul_id INT NOT NULL,
    tresc TEXT NOT NULL,
    FOREIGN KEY (artykul_id) REFERENCES artykuly(id) ON DELETE CASCADE
    -- Usunięcie artykułu automatycznie usunie wszystkie jego komentarze
);
```

---

## 3. DDL — CREATE TABLE

### Kompletny przykład

```sql
-- Tworzenie bazy danych
CREATE DATABASE IF NOT EXISTS sklep_online
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE sklep_online;

-- Tabela nadrzędna (bez FK)
CREATE TABLE kategorie (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nazwa VARCHAR(100) NOT NULL,
    opis TEXT,
    rodzic_id INT UNSIGNED DEFAULT NULL,
    kolejnosc SMALLINT UNSIGNED DEFAULT 0,
    aktywna TINYINT(1) NOT NULL DEFAULT 1,
    slug VARCHAR(150) NOT NULL UNIQUE,
    data_dodania TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (rodzic_id) REFERENCES kategorie(id) ON DELETE SET NULL
) ENGINE = InnoDB
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci
  COMMENT = 'Kategorie produktów';

-- Tabela z wieloma ograniczeniami
CREATE TABLE produkty (
    id INT UNSIGNED AUTO_INCREMENT,
    sku VARCHAR(50) NOT NULL,
    nazwa VARCHAR(200) NOT NULL,
    opis_krotki VARCHAR(500),
    opis_pelny LONGTEXT,
    cena DECIMAL(10, 2) NOT NULL,
    cena_promocyjna DECIMAL(10, 2),
    ilosc_magazyn SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    kategoria_id INT UNSIGNED,
    waga DECIMAL(8, 3),
    aktywny TINYINT(1) NOT NULL DEFAULT 1,
    wyrozniony TINYINT(1) NOT NULL DEFAULT 0,
    meta_tytul VARCHAR(200),
    meta_opis VARCHAR(500),
    data_dodania TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    data_modyfikacji TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY uq_sku (sku),
    INDEX idx_kategoria (kategoria_id),
    INDEX idx_cena (cena),
    INDEX idx_aktywny_wyrozniony (aktywny, wyrozniony),
    FULLTEXT INDEX ft_nazwa_opis (nazwa, opis_krotki),

    CONSTRAINT fk_produkt_kategoria
        FOREIGN KEY (kategoria_id)
        REFERENCES kategorie(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,

    CONSTRAINT chk_cena_dodatnia CHECK (cena > 0),
    CONSTRAINT chk_cena_promo CHECK (
        cena_promocyjna IS NULL OR cena_promocyjna < cena
    ),
    CONSTRAINT chk_ilosc_nieujemna CHECK (ilosc_magazyn >= 0)

) ENGINE = InnoDB
  AUTO_INCREMENT = 1000
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci
  COMMENT = 'Produkty sklepu internetowego';
```

---

## 4. DDL — ALTER TABLE

### Dodawanie elementów

```sql
-- Dodaj kolumnę
ALTER TABLE produkty ADD COLUMN obrazek_url VARCHAR(500);
ALTER TABLE produkty ADD COLUMN waga_netto DECIMAL(8,3) AFTER waga;
ALTER TABLE produkty ADD COLUMN id_zewnetrzny INT FIRST;

-- Dodaj kolumny masowo
ALTER TABLE produkty
    ADD COLUMN ocena_srednia DECIMAL(3,2) DEFAULT 0.00,
    ADD COLUMN liczba_ocen INT UNSIGNED DEFAULT 0,
    ADD COLUMN data_publikacji DATE;

-- Dodaj indeks
ALTER TABLE produkty ADD INDEX idx_ocena (ocena_srednia);
ALTER TABLE produkty ADD UNIQUE INDEX uq_id_zewnetrzny (id_zewnetrzny);
ALTER TABLE produkty ADD FULLTEXT INDEX ft_opis (opis_pelny);

-- Dodaj klucz obcy
ALTER TABLE produkty
    ADD CONSTRAINT fk_produkt_dostawca
    FOREIGN KEY (dostawca_id) REFERENCES dostawcy(id)
    ON DELETE SET NULL ON UPDATE CASCADE;

-- Dodaj PRIMARY KEY
ALTER TABLE tabela ADD PRIMARY KEY (id);
```

### Modyfikacja kolumn

```sql
-- MODIFY — zmień typ/właściwości kolumny (zachowaj nazwę)
ALTER TABLE produkty MODIFY COLUMN opis_krotki VARCHAR(1000);
ALTER TABLE produkty MODIFY COLUMN aktywny TINYINT(1) NOT NULL DEFAULT 0;

-- CHANGE — zmień nazwę I typ kolumny
ALTER TABLE produkty CHANGE COLUMN opis_krotki krotki_opis VARCHAR(800);
ALTER TABLE produkty CHANGE COLUMN aktywny jest_aktywny TINYINT(1) DEFAULT 1;

-- Zmień wartość domyślną
ALTER TABLE produkty ALTER COLUMN aktywny SET DEFAULT 0;
ALTER TABLE produkty ALTER COLUMN aktywny DROP DEFAULT;
```

### Usuwanie elementów

```sql
-- Usuń kolumnę
ALTER TABLE produkty DROP COLUMN obrazek_url;
ALTER TABLE produkty DROP COLUMN ocena_srednia, DROP COLUMN liczba_ocen;

-- Usuń indeks
ALTER TABLE produkty DROP INDEX idx_ocena;
ALTER TABLE produkty DROP INDEX uq_id_zewnetrzny;

-- Usuń klucz obcy
ALTER TABLE produkty DROP FOREIGN KEY fk_produkt_dostawca;

-- Usuń PRIMARY KEY
ALTER TABLE produkty DROP PRIMARY KEY;
```

### Zmiana nazwy i innych właściwości

```sql
-- Zmień nazwę tabeli
ALTER TABLE produkty RENAME TO artykuly;
-- lub:
RENAME TABLE produkty TO artykuly;
RENAME TABLE produkty TO artykuly, klienci TO uzytkownicy;

-- Zmień silnik tabeli
ALTER TABLE produkty ENGINE = InnoDB;
ALTER TABLE stare_logi ENGINE = Archive;

-- Zmień kodowanie tabeli
ALTER TABLE produkty
    CONVERT TO CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

-- Dodaj AUTO_INCREMENT wartość startową
ALTER TABLE produkty AUTO_INCREMENT = 10000;
```

---

## 5. DML — SELECT

### Pełna składnia SELECT

```sql
SELECT [DISTINCT | ALL]
    kolumna1 [AS alias1],
    kolumna2 [AS alias2],
    wyrazenie [AS alias3],
    funkcja(kolumna) [AS alias4],
    *
FROM tabela1 [AS t1]
    [JOIN tabela2 AS t2 ON t1.id = t2.t1_id]
    [LEFT JOIN tabela3 AS t3 ON t1.id = t3.t1_id]
WHERE warunek1 [AND|OR warunek2]
GROUP BY kolumna1 [, kolumna2]
HAVING warunek_agregatu
ORDER BY kolumna1 [ASC|DESC] [, kolumna2 [ASC|DESC]]
LIMIT liczba [OFFSET przesuniecie];

-- Kolejność przetwarzania (ważne na egzaminie!):
-- 1. FROM        (wybierz tabele)
-- 2. JOIN        (połącz tabele)
-- 3. WHERE       (filtruj wiersze)
-- 4. GROUP BY    (grupuj)
-- 5. HAVING      (filtruj grupy)
-- 6. SELECT      (wybierz kolumny)
-- 7. DISTINCT    (usuń duplikaty)
-- 8. ORDER BY    (sortuj)
-- 9. LIMIT       (ogranicz wyniki)
```

### Przykłady SELECT

```sql
-- Podstawowy SELECT
SELECT id, imie, nazwisko, email FROM klienci;

-- SELECT z aliasami
SELECT
    p.id AS produkt_id,
    p.nazwa AS nazwa_produktu,
    p.cena AS cena_brutto,
    p.cena * 0.77 AS cena_netto,
    k.nazwa AS kategoria
FROM produkty p
JOIN kategorie k ON p.kategoria_id = k.id;

-- DISTINCT — unikalne wartości
SELECT DISTINCT dzial FROM pracownicy;
SELECT DISTINCT kraj, miasto FROM adresy ORDER BY kraj, miasto;

-- Warunki WHERE
SELECT * FROM produkty
WHERE cena BETWEEN 100 AND 500
  AND kategoria_id IN (1, 2, 5)
  AND nazwa LIKE '%laptop%'
  AND aktywny = 1;

-- IS NULL / IS NOT NULL
SELECT * FROM klienci WHERE telefon IS NULL;
SELECT * FROM zamowienia WHERE data_realizacji IS NOT NULL;

-- CASE WHEN
SELECT
    id,
    nazwa,
    cena,
    CASE
        WHEN cena < 50 THEN 'Tani'
        WHEN cena BETWEEN 50 AND 200 THEN 'Średni'
        WHEN cena > 200 THEN 'Drogi'
        ELSE 'Nieznana cena'
    END AS kategoria_cenowa
FROM produkty;

-- COALESCE — pierwsza wartość nie-NULL
SELECT
    id,
    COALESCE(imie_firmy, CONCAT(imie, ' ', nazwisko)) AS nazwa_klienta,
    COALESCE(telefon_kom, telefon_stac, email) AS kontakt
FROM klienci;

-- IFNULL — jeśli NULL to wartość domyślna
SELECT id, nazwa, IFNULL(opis, 'Brak opisu') AS opis FROM produkty;
```

---

## 6. DML — INSERT

### Formy INSERT

```sql
-- Wstawianie pojedynczego wiersza (z nazwami kolumn)
INSERT INTO klienci (imie, nazwisko, email, telefon)
VALUES ('Jan', 'Kowalski', 'jan@example.com', '600100200');

-- Wstawianie bez nazw kolumn (kolejność musi zgadzać się z tabelą)
INSERT INTO kategorie VALUES (NULL, 'Elektronika', NULL, NULL, 0, 1, 'elektronika', NOW());

-- Wstawianie wielu wierszy naraz (szybsze niż pojedyncze INSERT)
INSERT INTO produkty (nazwa, cena, kategoria_id) VALUES
    ('Laptop Dell', 2999.99, 1),
    ('Mysz Logitech', 89.99, 2),
    ('Klawiatura Corsair', 249.99, 2),
    ('Monitor LG 24"', 799.99, 1),
    ('Słuchawki Sony', 399.99, 3);

-- INSERT ... SELECT — kopiowanie danych z innej tabeli
INSERT INTO produkty_archiwum (id, nazwa, cena, data_archiwizacji)
SELECT id, nazwa, cena, NOW()
FROM produkty
WHERE aktywny = 0;

-- INSERT IGNORE — pomiń wiersze z błędami (np. duplikat UNIQUE)
INSERT IGNORE INTO klienci (imie, email) VALUES
    ('Piotr', 'piotr@example.com'),  -- nowy
    ('Jan', 'jan@example.com');       -- duplikat email → pominięty bez błędu

-- INSERT ... ON DUPLICATE KEY UPDATE — upsert (wstaw lub zaktualizuj)
INSERT INTO statystyki (data, produkt_id, liczba_wyswietlen)
VALUES ('2026-05-16', 42, 1)
ON DUPLICATE KEY UPDATE
    liczba_wyswietlen = liczba_wyswietlen + 1,
    ostatnia_aktualizacja = NOW();

-- REPLACE INTO — usuń + wstaw jeśli duplikat (alternatywa dla ON DUPLICATE)
REPLACE INTO konfiguracja (klucz, wartosc)
VALUES ('motyw', 'ciemny');
-- Jeśli istnieje → usuwa stary wiersz i wstawia nowy

-- INSERT z RETURNING (MariaDB 10.5+)
INSERT INTO zamowienia (klient_id, suma)
VALUES (5, 299.99)
RETURNING id, data_zamowienia;
```

---

## 7. DML — UPDATE z JOIN

### Formy UPDATE

```sql
-- Podstawowy UPDATE
UPDATE produkty
SET cena = 199.99, aktywny = 1
WHERE id = 42;

-- UPDATE wielu kolumn
UPDATE klienci
SET
    telefon = '601234567',
    data_modyfikacji = NOW(),
    aktywny = 1
WHERE email = 'jan@example.com';

-- UPDATE z JOIN — aktualizuj na podstawie danych z innej tabeli
UPDATE produkty p
JOIN kategorie k ON p.kategoria_id = k.id
SET p.cena = p.cena * 1.10  -- podwyżka o 10%
WHERE k.nazwa = 'Elektronika';

-- UPDATE z podzapytaniem
UPDATE pracownicy
SET pensja = pensja * 1.15
WHERE dzial_id = (
    SELECT id FROM dzialy WHERE nazwa = 'IT'
);

-- UPDATE wielu tabel jednocześnie
UPDATE klienci k
JOIN zamowienia z ON k.id = z.klient_id
SET
    k.liczba_zamowien = k.liczba_zamowien + 1,
    z.status = 'przetworzone'
WHERE z.id = 1234;

-- UPDATE z LIMIT (ogranicz liczbę aktualizowanych wierszy)
UPDATE logi
SET przetworzone = 1
WHERE przetworzone = 0
ORDER BY data_dodania ASC
LIMIT 100;

-- UPDATE z CASE WHEN
UPDATE pracownicy
SET pensja = CASE
    WHEN staz_lat < 2 THEN pensja * 1.05
    WHEN staz_lat BETWEEN 2 AND 5 THEN pensja * 1.10
    WHEN staz_lat > 5 THEN pensja * 1.15
    ELSE pensja
END
WHERE dzial_id = 3;
```

---

## 8. DML — DELETE, TRUNCATE, DROP

### Porównanie DELETE vs TRUNCATE vs DROP

| Cecha | DELETE | TRUNCATE | DROP |
|-------|--------|----------|------|
| Usuwa | Wiersze (z filtrem) | Wszystkie wiersze | Całą tabelę |
| WHERE | TAK | NIE | NIE |
| Transakcja | TAK (można rollback) | NIE (auto-commit) | NIE |
| Triggery DELETE | Wyzwalane | NIE | NIE |
| AUTO_INCREMENT | Zachowany | Reset do 1 | — |
| Szybkość | Wolniejszy | Bardzo szybki | Natychmiastowy |
| Możliwość cofnięcia | TAK (ROLLBACK) | NIE | NIE |

```sql
-- DELETE — usuwa konkretne wiersze
DELETE FROM produkty WHERE aktywny = 0;
DELETE FROM logi WHERE data < '2024-01-01';
DELETE FROM klienci WHERE id = 42;

-- DELETE z JOIN
DELETE p
FROM produkty p
JOIN kategorie k ON p.kategoria_id = k.id
WHERE k.aktywna = 0;

-- DELETE z podzapytaniem
DELETE FROM zamowienia
WHERE klient_id IN (
    SELECT id FROM klienci WHERE aktywny = 0
);

-- DELETE z LIMIT (bezpieczniejsze usuwanie dużych zbiorów)
DELETE FROM logi_archiwum
WHERE data < '2023-01-01'
ORDER BY data ASC
LIMIT 10000;

-- TRUNCATE — usuwa wszystkie wiersze, reset AUTO_INCREMENT
TRUNCATE TABLE logi_temp;
TRUNCATE TABLE sesje;

-- DROP TABLE — usuwa tabelę całkowicie
DROP TABLE IF EXISTS tabela_tymczasowa;
DROP TABLE klienci;  -- UWAGA: nieodwracalne!

-- DROP DATABASE
DROP DATABASE IF EXISTS testowa_baza;
```

---

## 9. JOINy

### Diagram ASCII — typy JOINów

```
INNER JOIN           LEFT JOIN           RIGHT JOIN          FULL OUTER JOIN
   A ∩ B              A + A∩B              A∩B + B            A + A∩B + B

  +--+--+           +--+--+            +--+--+             +--+--+
  |  |##|           |##|##|            |  |##|             |##|##|
  |  |##|           |##|##|            |  |##|             |##|##|
  +--+--+           +--+--+            +--+--+             +--+--+
     ^^ tylko           ^^ A i          ^^tylko B i           ^^ wszystko
     część             wspólne           wspólne
     wspólna
```

### INNER JOIN

```sql
-- INNER JOIN — tylko wiersze z dopasowaniem w OBU tabelach
SELECT
    z.id AS zamowienie_id,
    k.imie,
    k.nazwisko,
    p.nazwa AS produkt,
    z.ilosc,
    z.cena * z.ilosc AS wartosc
FROM zamowienia z
INNER JOIN klienci k ON z.klient_id = k.id
INNER JOIN produkty p ON z.produkt_id = p.id
WHERE z.status = 'nowe'
ORDER BY z.data_zamowienia DESC;

-- INNER JOIN = JOIN (to samo)
SELECT * FROM a JOIN b ON a.id = b.a_id;
```

### LEFT JOIN

```sql
-- LEFT JOIN — wszystkie wiersze z lewej tabeli + dopasowane z prawej
-- Jeśli brak dopasowania → NULL po prawej stronie

-- Klienci, którzy NIE złożyli żadnego zamówienia
SELECT k.imie, k.nazwisko, k.email
FROM klienci k
LEFT JOIN zamowienia z ON k.id = z.klient_id
WHERE z.id IS NULL;

-- Wszystkie produkty z liczbą zamówień (0 jeśli brak)
SELECT
    p.nazwa,
    COUNT(z.id) AS liczba_zamowien
FROM produkty p
LEFT JOIN zamowienia_produkty z ON p.id = z.produkt_id
GROUP BY p.id, p.nazwa
ORDER BY liczba_zamowien DESC;
```

### RIGHT JOIN

```sql
-- RIGHT JOIN — wszystkie wiersze z prawej tabeli + dopasowane z lewej
-- Rzadziej używany (można zastąpić LEFT JOIN ze zamienionymi tabelami)

SELECT k.imie, z.id AS zamowienie
FROM zamowienia z
RIGHT JOIN klienci k ON z.klient_id = k.id;

-- Równoważne LEFT JOIN
SELECT k.imie, z.id AS zamowienie
FROM klienci k
LEFT JOIN zamowienia z ON k.id = z.klient_id;
```

### FULL OUTER JOIN

```sql
-- MySQL/MariaDB NIE obsługuje FULL OUTER JOIN bezpośrednio
-- Symulacja przez UNION LEFT + RIGHT:

SELECT k.imie, z.id AS zamowienie_id
FROM klienci k
LEFT JOIN zamowienia z ON k.id = z.klient_id

UNION

SELECT k.imie, z.id AS zamowienie_id
FROM klienci k
RIGHT JOIN zamowienia z ON k.id = z.klient_id
WHERE k.id IS NULL;
```

### CROSS JOIN i SELF JOIN

```sql
-- CROSS JOIN — iloczyn kartezjański (każdy z każdym)
-- OSTROŻNIE: 100 wierszy × 100 wierszy = 10 000 wierszy!
SELECT r.nazwa AS rozmiar, k.nazwa AS kolor
FROM rozmiary r
CROSS JOIN kolory k;
-- Wynik: wszystkie kombinacje rozmiarów i kolorów

-- SELF JOIN — tabela dołączona do samej siebie
-- Przykład: pracownicy i ich menedżerowie (hierarchia)
SELECT
    p.imie AS pracownik,
    m.imie AS menedzer
FROM pracownicy p
LEFT JOIN pracownicy m ON p.menedzer_id = m.id;

-- Przykład: kategorie z podkategoriami (drzewo)
SELECT
    rodzic.nazwa AS kategoria_glowna,
    dziecko.nazwa AS podkategoria
FROM kategorie dziecko
JOIN kategorie rodzic ON dziecko.rodzic_id = rodzic.id;
```

### JOIN z wieloma warunkami

```sql
-- JOIN z wieloma warunkami ON
SELECT *
FROM zamowienia z
JOIN cenniki c ON z.produkt_id = c.produkt_id
    AND z.data_zamowienia BETWEEN c.data_od AND c.data_do
    AND z.region = c.region;

-- JOIN z USING (gdy nazwy kolumn są identyczne)
SELECT k.imie, z.id
FROM klienci k
JOIN zamowienia z USING (klient_id);
-- Zamiast: ON k.klient_id = z.klient_id
```

---

## 10. GROUP BY, HAVING, ORDER BY, LIMIT

```sql
-- GROUP BY — grupowanie wierszy
SELECT
    kategoria_id,
    COUNT(*) AS liczba_produktow,
    AVG(cena) AS srednia_cena,
    MIN(cena) AS najtanszy,
    MAX(cena) AS najdrozszy,
    SUM(cena) AS suma_cen
FROM produkty
WHERE aktywny = 1
GROUP BY kategoria_id;

-- GROUP BY z wieloma kolumnami
SELECT
    dzial,
    stanowisko,
    COUNT(*) AS liczba,
    AVG(pensja) AS srednia_pensja
FROM pracownicy
GROUP BY dzial, stanowisko
ORDER BY dzial, srednia_pensja DESC;

-- HAVING — filtr dla grup (nie dla wierszy!)
-- Różnica: WHERE filtruje PRZED grupowaniem, HAVING DOPO grupowaniu
SELECT
    klient_id,
    COUNT(*) AS liczba_zamowien,
    SUM(wartosc) AS suma_zakupow
FROM zamowienia
WHERE status != 'anulowane'        -- filtr PRZED grupowaniem
GROUP BY klient_id
HAVING suma_zakupow > 1000         -- filtr NA GRUPACH
   AND liczba_zamowien >= 3
ORDER BY suma_zakupow DESC;

-- ORDER BY — sortowanie
SELECT * FROM produkty
ORDER BY cena ASC,           -- rosnąco (domyślne)
         nazwa DESC;         -- malejąco

-- ORDER BY z wyrażeniem
SELECT id, imie, nazwisko
FROM pracownicy
ORDER BY CONCAT(nazwisko, ' ', imie) ASC;

-- ORDER BY z FIELD() — własna kolejność
SELECT * FROM zamowienia
ORDER BY FIELD(status, 'pilne', 'nowe', 'w_realizacji', 'zrealizowane', 'anulowane');

-- LIMIT — ograniczenie liczby wyników
SELECT * FROM produkty LIMIT 10;           -- pierwsze 10
SELECT * FROM produkty LIMIT 10 OFFSET 20; -- 10 wyników, pomijając pierwsze 20
SELECT * FROM produkty LIMIT 20, 10;       -- skrót: LIMIT offset, count

-- Paginacja (strona 3, 10 wyników na stronę)
SELECT * FROM produkty
ORDER BY id
LIMIT 10 OFFSET 20;
-- strona 1: OFFSET 0, strona 2: OFFSET 10, strona 3: OFFSET 20
```

---

## 11. Funkcje agregujące

```sql
-- COUNT — liczba wierszy
SELECT COUNT(*) FROM produkty;                     -- wszystkie wiersze
SELECT COUNT(telefon) FROM klienci;               -- tylko NOT NULL
SELECT COUNT(DISTINCT kategoria_id) FROM produkty; -- unikalne wartości

-- SUM — suma wartości
SELECT SUM(cena * ilosc) AS przychod FROM zamowienia;
SELECT SUM(ilosc_magazyn) AS stan_magazynu FROM produkty WHERE aktywny = 1;

-- AVG — średnia (ignoruje NULL)
SELECT AVG(pensja) AS srednia_pensja FROM pracownicy;
SELECT AVG(ocena) AS srednia_ocen FROM recenzje WHERE produkt_id = 42;

-- MIN i MAX
SELECT MIN(cena) AS najnizsa, MAX(cena) AS najwyzsza FROM produkty;
SELECT MIN(data_zamowienia) AS pierwsze, MAX(data_zamowienia) AS ostatnie FROM zamowienia;

-- GROUP_CONCAT — złączenie wartości grupy w jeden string
SELECT
    kategoria_id,
    GROUP_CONCAT(nazwa ORDER BY nazwa ASC SEPARATOR ', ') AS produkty
FROM produkty
GROUP BY kategoria_id;
-- Wynik: kategoria_id=1, produkty='Kabel HDMI, Laptop Dell, Monitor LG'

-- GROUP_CONCAT z DISTINCT i LIMIT
SELECT
    klient_id,
    GROUP_CONCAT(DISTINCT status ORDER BY status SEPARATOR ' | ') AS statusy
FROM zamowienia
GROUP BY klient_id;

-- Funkcje z filtrowaniem NULL
SELECT
    COUNT(*) AS wszystkie,
    COUNT(telefon) AS z_telefonem,
    COUNT(*) - COUNT(telefon) AS bez_telefonu
FROM klienci;

-- ROLLUP — dodaje podsumowanie do GROUP BY
SELECT
    dzial,
    stanowisko,
    COUNT(*) AS liczba,
    SUM(pensja) AS suma_pensji
FROM pracownicy
GROUP BY dzial, stanowisko WITH ROLLUP;
-- Dodaje wiersze z NULL dla sum częściowych i totalnych
```

---

## 12. Funkcje daty

```sql
-- Aktualna data i czas
SELECT NOW();              -- 2026-05-16 14:30:45 (datetime z serwera)
SELECT CURRENT_TIMESTAMP;  -- alias dla NOW()
SELECT CURDATE();          -- 2026-05-16 (tylko data)
SELECT CURTIME();          -- 14:30:45 (tylko czas)
SELECT UTC_TIMESTAMP();    -- aktualna data/czas UTC

-- Wyciąganie części daty
SELECT YEAR('2026-05-16');      -- 2026
SELECT MONTH('2026-05-16');     -- 5
SELECT DAY('2026-05-16');       -- 16
SELECT HOUR('14:30:45');        -- 14
SELECT MINUTE('14:30:45');      -- 30
SELECT SECOND('14:30:45');      -- 45
SELECT DAYOFWEEK('2026-05-16'); -- 7 (1=Nd, 2=Pon, ..., 7=Sob)
SELECT DAYOFYEAR('2026-05-16'); -- 136 (numer dnia w roku)
SELECT WEEK('2026-05-16');      -- 20 (numer tygodnia)
SELECT QUARTER('2026-05-16');   -- 2 (kwartał)

-- Formatowanie daty — DATE_FORMAT()
SELECT DATE_FORMAT(NOW(), '%d.%m.%Y');           -- 16.05.2026
SELECT DATE_FORMAT(NOW(), '%d/%m/%Y %H:%i:%s');  -- 16/05/2026 14:30:45
SELECT DATE_FORMAT(NOW(), '%Y-%m-%d');           -- 2026-05-16
SELECT DATE_FORMAT(NOW(), '%W, %d %M %Y');       -- Saturday, 16 May 2026

-- Kody formatu DATE_FORMAT:
-- %Y — rok 4-cyfrowy          %y — rok 2-cyfrowy
-- %m — miesiąc 01-12          %c — miesiąc 1-12
-- %d — dzień 01-31            %e — dzień 1-31
-- %H — godzina 00-23          %h — godzina 01-12
-- %i — minuty 00-59           %s — sekundy 00-59
-- %W — nazwa dnia (angielska) %M — nazwa miesiąca (angielska)
-- %p — AM/PM

-- Obliczanie różnicy dat
SELECT DATEDIFF('2026-12-31', '2026-05-16');   -- 229 dni
SELECT TIMEDIFF('18:00:00', '09:30:00');       -- 08:30:00

-- Dodawanie/odejmowanie dat — DATE_ADD() / DATE_SUB()
SELECT DATE_ADD('2026-05-16', INTERVAL 30 DAY);   -- 2026-06-15
SELECT DATE_ADD('2026-05-16', INTERVAL 3 MONTH);  -- 2026-08-16
SELECT DATE_ADD('2026-05-16', INTERVAL 1 YEAR);   -- 2027-05-16
SELECT DATE_SUB('2026-05-16', INTERVAL 7 DAY);    -- 2026-05-09
SELECT DATE_SUB(NOW(), INTERVAL 1 HOUR);          -- godzinę temu

-- Aliasy DATE_ADD / DATE_SUB
SELECT '2026-05-16' + INTERVAL 30 DAY;   -- to samo co DATE_ADD
SELECT '2026-05-16' - INTERVAL 30 DAY;   -- to samo co DATE_SUB

-- Konwersja typów daty
SELECT STR_TO_DATE('16.05.2026', '%d.%m.%Y');     -- 2026-05-16
SELECT STR_TO_DATE('16/05/2026 14:30', '%d/%m/%Y %H:%i');

-- TIMESTAMPDIFF — różnica w wybranej jednostce
SELECT TIMESTAMPDIFF(YEAR, '1990-03-15', CURDATE()) AS wiek;
SELECT TIMESTAMPDIFF(MONTH, '2026-01-01', '2026-05-16') AS miesiecy;
SELECT TIMESTAMPDIFF(SECOND, '2026-05-16 14:00:00', NOW()) AS sekund;

-- UNIX_TIMESTAMP — konwersja na timestamp Unix (sekundy od 1970)
SELECT UNIX_TIMESTAMP('2026-05-16');
SELECT FROM_UNIXTIME(1747353600);  -- konwersja z powrotem na datetime

-- LAST_DAY — ostatni dzień miesiąca
SELECT LAST_DAY('2026-02-01');  -- 2026-02-28

-- Przykłady praktyczne
-- Zamówienia z ostatnich 30 dni
SELECT * FROM zamowienia
WHERE data_zamowienia >= DATE_SUB(NOW(), INTERVAL 30 DAY);

-- Urodziny w tym miesiącu
SELECT imie, nazwisko, data_urodzin
FROM klienci
WHERE MONTH(data_urodzin) = MONTH(CURDATE());

-- Wiek klienta
SELECT imie, TIMESTAMPDIFF(YEAR, data_urodzin, CURDATE()) AS wiek
FROM klienci;
```

---

## 13. Funkcje stringów

```sql
-- Łączenie stringów
SELECT CONCAT('Jan', ' ', 'Kowalski');              -- Jan Kowalski
SELECT CONCAT_WS(' ', 'Jan', 'Adam', 'Kowalski');   -- Jan Adam Kowalski (separator)
SELECT CONCAT_WS(', ', imie, nazwisko) FROM klienci; -- Kowalski, Jan

-- Długość stringa
SELECT LENGTH('Kowalski');       -- 8 (bajty)
SELECT CHAR_LENGTH('Kowalski');  -- 8 (znaki, ważne dla UTF-8)
-- Dla polskich znaków CHAR_LENGTH != LENGTH!
SELECT LENGTH('ą');              -- 2 (2 bajty w UTF-8)
SELECT CHAR_LENGTH('ą');         -- 1 (1 znak)

-- Wielkie/małe litery
SELECT UPPER('jan kowalski');   -- JAN KOWALSKI
SELECT LOWER('JAN KOWALSKI');   -- jan kowalski
SELECT UCASE('tekst');          -- TEKST (alias UPPER)
SELECT LCASE('TEKST');          -- tekst (alias LOWER)

-- Wyciąganie podciągów
SELECT SUBSTRING('Jan Kowalski', 5);        -- Kowalski (od pozycji 5)
SELECT SUBSTRING('Jan Kowalski', 1, 3);     -- Jan (od 1, długość 3)
SELECT SUBSTR('Jan Kowalski', -8);          -- Kowalski (od końca)
SELECT LEFT('Jan Kowalski', 3);             -- Jan
SELECT RIGHT('Jan Kowalski', 8);            -- Kowalski
SELECT MID('Jan Kowalski', 5, 3);           -- Kow

-- Wyszukiwanie w stringu
SELECT LOCATE('Kow', 'Jan Kowalski');       -- 5 (pozycja pierwszego wystąpienia)
SELECT INSTR('Jan Kowalski', 'Kow');        -- 5 (alias)
SELECT POSITION('Kow' IN 'Jan Kowalski');   -- 5

-- Zastępowanie
SELECT REPLACE('Jan Kowalski', 'Jan', 'Piotr');  -- Piotr Kowalski
SELECT REPLACE(email, '@example.com', '@nowa.pl') FROM klienci;

-- Usuwanie białych znaków
SELECT TRIM('  Jan Kowalski  ');     -- 'Jan Kowalski'
SELECT LTRIM('  Jan Kowalski  ');    -- 'Jan Kowalski  '
SELECT RTRIM('  Jan Kowalski  ');    -- '  Jan Kowalski'
SELECT TRIM(BOTH 'x' FROM 'xxJanxx'); -- 'Jan' (usuwa 'x' z obu stron)

-- Uzupełnianie stringów
SELECT LPAD('42', 5, '0');       -- 00042 (uzupełnij od lewej)
SELECT RPAD('Jan', 10, '.');     -- Jan....... (uzupełnij od prawej)

-- Odwracanie stringa
SELECT REVERSE('abcdef');        -- fedcba

-- Powtarzanie
SELECT REPEAT('ab', 3);         -- ababab

-- LIKE — dopasowanie wzorca (case-insensitive domyślnie)
SELECT * FROM produkty WHERE nazwa LIKE 'Lap%';      -- zaczyna od 'Lap'
SELECT * FROM produkty WHERE nazwa LIKE '%USB%';     -- zawiera 'USB'
SELECT * FROM produkty WHERE nazwa LIKE '_Phone';    -- dowolny znak + 'Phone'
SELECT * FROM produkty WHERE nazwa LIKE '%[_]%';     -- zawiera podkreślenie
SELECT * FROM produkty WHERE nazwa NOT LIKE '%stary%'; -- nie zawiera 'stary'

-- REGEXP — wyrażenia regularne
SELECT * FROM klienci WHERE email REGEXP '^[a-z]+@[a-z]+\\.pl$';
SELECT * FROM klienci WHERE telefon REGEXP '^[0-9]{9}$';
SELECT * FROM produkty WHERE nazwa REGEXP '^(Laptop|Tablet|Telefon)';

-- STRCMP — porównanie stringów
SELECT STRCMP('abc', 'abc');  -- 0 (równe)
SELECT STRCMP('abc', 'abd');  -- -1 (mniejsze)
SELECT STRCMP('abd', 'abc');  -- 1 (większe)

-- FORMAT — formatowanie liczby jako string
SELECT FORMAT(1234567.891, 2);     -- 1,234,567.89
SELECT FORMAT(1234567.891, 2, 'pl_PL'); -- format lokalny (MariaDB)
```

---

## 14. Funkcje matematyczne

```sql
-- Zaokrąglanie
SELECT ROUND(3.14159, 2);    -- 3.14 (zaokrągl do 2 miejsc)
SELECT ROUND(3.145, 2);      -- 3.15 (standard zaokrąglania)
SELECT ROUND(3.5);           -- 4 (do liczby całkowitej)
SELECT CEIL(3.1);            -- 4 (zaokrąglenie w górę)
SELECT CEILING(3.1);         -- 4 (alias CEIL)
SELECT FLOOR(3.9);           -- 3 (zaokrąglenie w dół)
SELECT TRUNCATE(3.14159, 2); -- 3.14 (obcięcie bez zaokrąglenia)

-- Wartość bezwzględna
SELECT ABS(-42);             -- 42
SELECT ABS(-3.14);           -- 3.14

-- Reszta z dzielenia
SELECT MOD(17, 5);           -- 2 (17 = 3×5 + 2)
SELECT 17 MOD 5;             -- 2 (operator)
SELECT 17 % 5;               -- 2 (operator)

-- Potęga i pierwiastek
SELECT POWER(2, 10);         -- 1024
SELECT POW(2, 10);           -- 1024 (alias)
SELECT SQRT(144);            -- 12

-- Logarytmy i e
SELECT EXP(1);               -- 2.7182818... (e^1)
SELECT LOG(EXP(1));          -- 1 (ln)
SELECT LOG2(8);              -- 3
SELECT LOG10(1000);          -- 3

-- Trygonometria (kąty w radianach)
SELECT SIN(PI()/2);          -- 1
SELECT COS(0);               -- 1
SELECT TAN(PI()/4);          -- 1
SELECT PI();                 -- 3.14159265...
SELECT RADIANS(180);         -- 3.14159... (stopnie → radiany)
SELECT DEGREES(PI());        -- 180 (radiany → stopnie)

-- Losowe liczby
SELECT RAND();               -- losowa liczba 0 <= x < 1
SELECT RAND(42);             -- losowa z ziarnem (reprodukowalna)
SELECT FLOOR(RAND() * 100);  -- losowa liczba całkowita 0-99
SELECT FLOOR(1 + RAND() * 6); -- losowa liczba 1-6 (kości)

-- Min/Max bez agregacji (dla wartości w tym samym wierszu)
SELECT LEAST(10, 5, 8, 3);   -- 3 (minimum z listy)
SELECT GREATEST(10, 5, 8, 3); -- 10 (maximum z listy)

-- Przykłady praktyczne
-- Oblicz podatek VAT
SELECT
    nazwa,
    cena_netto,
    ROUND(cena_netto * 0.23, 2) AS vat,
    ROUND(cena_netto * 1.23, 2) AS cena_brutto
FROM produkty;

-- Losowa kolejność
SELECT * FROM produkty ORDER BY RAND() LIMIT 5;
-- Pobierz 5 losowych produktów (nieefektywne dla dużych tabel!)

-- Sprawdź parzyste/nieparzyste ID
SELECT id, imie FROM klienci WHERE MOD(id, 2) = 0;  -- parzyste ID
SELECT id, imie FROM klienci WHERE id % 2 = 1;       -- nieparzyste ID
```

---

## 15. Podzapytania

### Podzapytanie w WHERE

```sql
-- Produkty droższe niż średnia cena
SELECT nazwa, cena
FROM produkty
WHERE cena > (SELECT AVG(cena) FROM produkty);

-- Klienci, którzy złożyli zamówienia
SELECT imie, nazwisko
FROM klienci
WHERE id IN (SELECT DISTINCT klient_id FROM zamowienia);

-- Klienci, którzy NIE złożyli zamówień
SELECT imie, nazwisko
FROM klienci
WHERE id NOT IN (SELECT DISTINCT klient_id FROM zamowienia WHERE klient_id IS NOT NULL);

-- EXISTS — sprawdź czy podzapytanie zwraca jakikolwiek wiersz
-- Szybsze niż IN dla dużych zbiorów!
SELECT k.imie, k.nazwisko
FROM klienci k
WHERE EXISTS (
    SELECT 1 FROM zamowienia z
    WHERE z.klient_id = k.id AND z.status = 'nowe'
);

-- NOT EXISTS
SELECT p.nazwa
FROM produkty p
WHERE NOT EXISTS (
    SELECT 1 FROM zamowienia_produkty zp
    WHERE zp.produkt_id = p.id
);
-- Produkty, które nigdy nie były zamówione
```

### Podzapytanie w FROM (derived table)

```sql
-- Podzapytanie jako tymczasowa tabela (musi mieć alias!)
SELECT kategoria_id, avg_cena
FROM (
    SELECT kategoria_id, AVG(cena) AS avg_cena
    FROM produkty
    GROUP BY kategoria_id
) AS srednie_kategorie
WHERE avg_cena > 500;

-- Paginacja z podzapytaniem
SELECT *
FROM (
    SELECT *, ROW_NUMBER() OVER (ORDER BY id) AS nr
    FROM produkty
) AS paged
WHERE nr BETWEEN 21 AND 30;
```

### CTE (Common Table Expressions) — WITH

```sql
-- CTE — czytelniejsze podzapytania (MySQL 8.0+, MariaDB 10.2+)
WITH drogi_produkty AS (
    SELECT id, nazwa, cena
    FROM produkty
    WHERE cena > 1000
),
kategorie_aktywne AS (
    SELECT id, nazwa
    FROM kategorie
    WHERE aktywna = 1
)
SELECT dp.nazwa, dp.cena, ka.nazwa AS kategoria
FROM drogi_produkty dp
JOIN kategorie_aktywne ka ON dp.kategoria_id = ka.id;

-- Rekurencyjne CTE (hierarchia)
WITH RECURSIVE hierarchia AS (
    -- Baza rekurencji: korzeń drzewa
    SELECT id, nazwa, rodzic_id, 0 AS poziom
    FROM kategorie
    WHERE rodzic_id IS NULL

    UNION ALL

    -- Krok rekurencyjny
    SELECT k.id, k.nazwa, k.rodzic_id, h.poziom + 1
    FROM kategorie k
    JOIN hierarchia h ON k.rodzic_id = h.id
)
SELECT REPEAT('  ', poziom), id, nazwa, poziom
FROM hierarchia
ORDER BY id;
```

### Podzapytania skorelowane

```sql
-- Dla każdego klienta znajdź jego ostatnie zamówienie
SELECT
    k.imie,
    k.nazwisko,
    (SELECT MAX(data_zamowienia)
     FROM zamowienia z
     WHERE z.klient_id = k.id) AS ostatnie_zamowienie
FROM klienci k;

-- Dla każdego produktu — jego pozycja cenowa w kategorii
SELECT
    p1.nazwa,
    p1.cena,
    (SELECT COUNT(*) FROM produkty p2
     WHERE p2.kategoria_id = p1.kategoria_id
     AND p2.cena > p1.cena) + 1 AS pozycja_w_kategorii
FROM produkty p1
ORDER BY p1.kategoria_id, pozycja_w_kategorii;
```

---

## 16. Widoki (VIEW)

```sql
-- Tworzenie widoku
CREATE VIEW aktywne_produkty AS
SELECT
    p.id,
    p.nazwa,
    p.cena,
    k.nazwa AS kategoria
FROM produkty p
JOIN kategorie k ON p.kategoria_id = k.id
WHERE p.aktywny = 1;

-- Korzystanie z widoku (jak normalna tabela)
SELECT * FROM aktywne_produkty WHERE cena < 500;
SELECT COUNT(*) FROM aktywne_produkty;

-- Tworzenie lub zastępowanie widoku
CREATE OR REPLACE VIEW aktywne_produkty AS
SELECT
    p.id,
    p.nazwa,
    p.cena,
    p.cena_promocyjna,
    COALESCE(p.cena_promocyjna, p.cena) AS cena_finalna,
    k.nazwa AS kategoria
FROM produkty p
JOIN kategorie k ON p.kategoria_id = k.id
WHERE p.aktywny = 1;

-- Modyfikacja widoku
ALTER VIEW aktywne_produkty AS
SELECT p.id, p.nazwa, p.cena, k.nazwa AS kategoria
FROM produkty p
JOIN kategorie k ON p.kategoria_id = k.id
WHERE p.aktywny = 1 AND k.aktywna = 1;

-- Usunięcie widoku
DROP VIEW IF EXISTS aktywne_produkty;

-- Lista widoków
SHOW TABLES;  -- widoki wyświetlane razem z tabelami
SHOW FULL TABLES WHERE Table_type = 'VIEW';

-- Definicja widoku
SHOW CREATE VIEW aktywne_produkty;

-- Updatable views — widoki, przez które można modyfikować dane
-- Warunki: bez GROUP BY, DISTINCT, UNION, podzapytań, funkcji agregujących
CREATE VIEW klienci_aktywni AS
SELECT id, imie, nazwisko, email FROM klienci WHERE aktywny = 1;

-- Można robić INSERT/UPDATE/DELETE przez ten widok
UPDATE klienci_aktywni SET email = 'nowy@email.pl' WHERE id = 5;
```

---

## 17. Indeksy

### Tworzenie indeksów

```sql
-- Indeks zwykły (B-Tree)
CREATE INDEX idx_nazwisko ON klienci(nazwisko);
CREATE INDEX idx_cena ON produkty(cena);

-- Indeks złożony (wielokolumnowy)
CREATE INDEX idx_aktywny_kategoria ON produkty(aktywny, kategoria_id);
-- Kolejność kolumn ma znaczenie! Zaczyna od lewej strony.

-- Indeks unikalny
CREATE UNIQUE INDEX uq_email ON klienci(email);

-- Indeks FULLTEXT (dla wyszukiwania pełnotekstowego)
CREATE FULLTEXT INDEX ft_nazwa_opis ON produkty(nazwa, opis_krotki);

-- Indeks podczas tworzenia tabeli
CREATE TABLE klienci (
    id INT AUTO_INCREMENT PRIMARY KEY,           -- automatyczny indeks PK
    email VARCHAR(255) UNIQUE,                   -- automatyczny indeks UNIQUE
    INDEX idx_nazwisko (nazwisko),               -- indeks zwykły
    INDEX idx_data_rejestracji (data_rejestracji)
);

-- Dodanie indeksu przez ALTER TABLE
ALTER TABLE produkty ADD INDEX idx_cena (cena);
ALTER TABLE produkty ADD UNIQUE INDEX uq_sku (sku);
ALTER TABLE produkty ADD FULLTEXT INDEX ft_produkty (nazwa, opis_krotki);

-- Usunięcie indeksu
DROP INDEX idx_cena ON produkty;
ALTER TABLE produkty DROP INDEX idx_cena;

-- Lista indeksów
SHOW INDEX FROM produkty;
SHOW INDEXES FROM produkty;
```

### Typy indeksów

| Typ | Algorytm | Zastosowanie |
|-----|----------|-------------|
| PRIMARY | B-Tree | Klucz główny, unikalny identyfikator |
| UNIQUE | B-Tree | Unikalność wartości (np. email) |
| INDEX / KEY | B-Tree | Przyspieszenie wyszukiwania i sortowania |
| FULLTEXT | Specjalny | Wyszukiwanie tekstowe (MATCH ... AGAINST) |
| SPATIAL | R-Tree | Dane geograficzne/przestrzenne |
| HASH | Hash | Tylko silnik MEMORY, szybkie równościowe porównania |

### EXPLAIN — analiza zapytania

```sql
-- Analiza zapytania przed wykonaniem
EXPLAIN SELECT * FROM produkty WHERE kategoria_id = 5;

-- Szczegółowa analiza (MySQL 8.0 / MariaDB 10.5+)
EXPLAIN FORMAT=JSON SELECT * FROM produkty WHERE kategoria_id = 5;

-- EXPLAIN ANALYZE — wykonaj i zmierz (MariaDB 10.8+)
EXPLAIN ANALYZE SELECT * FROM produkty WHERE kategoria_id = 5;
```

---

## 18. Transakcje i ACID

### Właściwości ACID

| Właściwość | Znaczenie |
|-----------|-----------|
| **A**tomicity (Atomowość) | Wszystkie operacje w transakcji wykonują się albo żadna. Zero połowicznych zmian. |
| **C**onsistency (Spójność) | Po transakcji baza jest w spójnym stanie. Ograniczenia nie są naruszone. |
| **I**solation (Izolacja) | Transakcje nie widzą się nawzajem w trakcie wykonywania. |
| **D**urability (Trwałość) | Po COMMIT dane są zapisane na stałe, nawet po awarii serwera. |

### Polecenia transakcji

```sql
-- Rozpoczęcie transakcji
START TRANSACTION;
-- lub:
BEGIN;

-- Zatwierdzenie transakcji (zapisuje zmiany)
COMMIT;

-- Wycofanie transakcji (odwraca wszystkie zmiany od START TRANSACTION)
ROLLBACK;

-- SAVEPOINT — punkt zapisu w transakcji
SAVEPOINT sp1;
ROLLBACK TO SAVEPOINT sp1;  -- cofnij do punktu, nie do początku
RELEASE SAVEPOINT sp1;       -- usuń savepoint

-- Automatyczne zatwierdzanie (domyślnie włączone)
SHOW VARIABLES LIKE 'autocommit';  -- 1 = włączony
SET autocommit = 0;  -- wyłącz autocommit dla sesji
SET autocommit = 1;  -- włącz ponownie
```

### Przykład transakcji — przelew bankowy

```sql
START TRANSACTION;

-- Sprawdź saldo
SELECT saldo FROM konta WHERE id = 1 FOR UPDATE;  -- blokada wiersza!

-- Pobierz środki z konta nadawcy
UPDATE konta SET saldo = saldo - 500.00 WHERE id = 1;

-- Sprawdź czy saldo jest nieujemne
-- (w aplikacji sprawdzamy wynik, tu symulacja)

-- Dodaj środki na konto odbiorcy
UPDATE konta SET saldo = saldo + 500.00 WHERE id = 2;

-- Zapisz historię przelewu
INSERT INTO historia_przelewow (konto_z, konto_do, kwota, opis)
VALUES (1, 2, 500.00, 'Przelew za fakturę');

-- Zatwierdź jeśli wszystko OK
COMMIT;

-- W przypadku błędu:
-- ROLLBACK;
```

### Poziomy izolacji

```sql
-- Wyświetl aktualny poziom izolacji
SELECT @@transaction_isolation;  -- MySQL 8.0+
SELECT @@tx_isolation;           -- starsze wersje

-- Ustaw poziom izolacji
SET SESSION TRANSACTION ISOLATION LEVEL READ COMMITTED;
SET GLOBAL TRANSACTION ISOLATION LEVEL REPEATABLE READ;

-- Poziomy (od najsłabszego do najsilniejszego):
-- READ UNCOMMITTED — widzi niecommitowane zmiany innych (Dirty Read)
-- READ COMMITTED   — widzi tylko commitowane (brak Dirty Read)
-- REPEATABLE READ  — te same wyniki przez całą transakcję (domyślny InnoDB)
-- SERIALIZABLE     — pełna izolacja, blokuje wszystko (najwolniejszy)
```

---

## 19. Procedury i funkcje składowane

### CREATE PROCEDURE

```sql
DELIMITER //

-- Prosta procedura bez parametrów
CREATE PROCEDURE pokaz_produkty()
BEGIN
    SELECT id, nazwa, cena FROM produkty WHERE aktywny = 1;
END //

-- Procedura z parametrami IN
CREATE PROCEDURE znajdz_produkty_w_kategorii(
    IN p_kategoria_id INT,
    IN p_max_cena DECIMAL(10,2)
)
BEGIN
    SELECT id, nazwa, cena
    FROM produkty
    WHERE kategoria_id = p_kategoria_id
      AND cena <= p_max_cena
      AND aktywny = 1
    ORDER BY cena ASC;
END //

-- Procedura z parametrem OUT
CREATE PROCEDURE policz_zamowienia(
    IN p_klient_id INT,
    OUT p_liczba INT,
    OUT p_suma DECIMAL(12,2)
)
BEGIN
    SELECT COUNT(*), SUM(wartosc)
    INTO p_liczba, p_suma
    FROM zamowienia
    WHERE klient_id = p_klient_id;
END //

-- Procedura z obsługą błędów i zmiennymi
CREATE PROCEDURE dodaj_produkt(
    IN p_nazwa VARCHAR(200),
    IN p_cena DECIMAL(10,2),
    IN p_kategoria_id INT,
    OUT p_nowe_id INT
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SET p_nowe_id = -1;
    END;

    START TRANSACTION;

    INSERT INTO produkty (nazwa, cena, kategoria_id)
    VALUES (p_nazwa, p_cena, p_kategoria_id);

    SET p_nowe_id = LAST_INSERT_ID();

    COMMIT;
END //

-- Procedura z IF, WHILE, LOOP
CREATE PROCEDURE generuj_logi(IN ile INT)
BEGIN
    DECLARE i INT DEFAULT 1;

    WHILE i <= ile DO
        INSERT INTO logi (komunikat, data)
        VALUES (CONCAT('Log numer ', i), NOW());
        SET i = i + 1;
    END WHILE;
END //

DELIMITER ;

-- Wywołanie procedury
CALL pokaz_produkty();
CALL znajdz_produkty_w_kategorii(1, 500.00);

CALL policz_zamowienia(5, @liczba, @suma);
SELECT @liczba, @suma;

CALL dodaj_produkt('Nowy produkt', 299.99, 2, @id);
SELECT @id;

-- Lista procedur
SHOW PROCEDURE STATUS WHERE Db = 'sklep';
SHOW CREATE PROCEDURE pokaz_produkty;

-- Usunięcie procedury
DROP PROCEDURE IF EXISTS pokaz_produkty;
```

### CREATE FUNCTION

```sql
DELIMITER //

-- Funkcja zwracająca wartość
CREATE FUNCTION oblicz_vat(
    cena_netto DECIMAL(10,2),
    stawka_vat DECIMAL(5,4)
)
RETURNS DECIMAL(10,2)
DETERMINISTIC    -- te same parametry = ten sam wynik
READS SQL DATA
BEGIN
    RETURN ROUND(cena_netto * stawka_vat, 2);
END //

-- Funkcja z logiką
CREATE FUNCTION kategoria_cenowa(cena DECIMAL(10,2))
RETURNS VARCHAR(20)
DETERMINISTIC
NO SQL
BEGIN
    DECLARE wynik VARCHAR(20);

    IF cena < 50 THEN
        SET wynik = 'Ekonomiczny';
    ELSEIF cena < 200 THEN
        SET wynik = 'Sredni';
    ELSEIF cena < 1000 THEN
        SET wynik = 'Premium';
    ELSE
        SET wynik = 'Luksusowy';
    END IF;

    RETURN wynik;
END //

DELIMITER ;

-- Użycie funkcji
SELECT oblicz_vat(100.00, 0.23);  -- 23.00
SELECT nazwa, cena, kategoria_cenowa(cena) AS segment FROM produkty;

-- Usunięcie funkcji
DROP FUNCTION IF EXISTS oblicz_vat;
```

---

## 20. Triggery

### 6 typów triggerów

| Typ | Kiedy wyzwalany |
|-----|----------------|
| BEFORE INSERT | Przed wstawieniem wiersza |
| AFTER INSERT | Po wstawieniu wiersza |
| BEFORE UPDATE | Przed aktualizacją wiersza |
| AFTER UPDATE | Po aktualizacji wiersza |
| BEFORE DELETE | Przed usunięciem wiersza |
| AFTER DELETE | Po usunięciu wiersza |

### Referencje OLD i NEW

| Operacja | OLD | NEW |
|----------|-----|-----|
| INSERT | Niedostępny | Nowe wartości |
| UPDATE | Stare wartości | Nowe wartości |
| DELETE | Stare wartości | Niedostępny |

### Przykłady triggerów

```sql
DELIMITER //

-- BEFORE INSERT — walidacja i modyfikacja przed zapisem
CREATE TRIGGER before_produkt_insert
BEFORE INSERT ON produkty
FOR EACH ROW
BEGIN
    -- Wymuś małe litery dla SKU
    SET NEW.sku = UPPER(NEW.sku);
    -- Ustaw datę jeśli pusta
    IF NEW.data_dodania IS NULL THEN
        SET NEW.data_dodania = NOW();
    END IF;
    -- Walidacja ceny
    IF NEW.cena <= 0 THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Cena musi być większa od zera';
    END IF;
END //

-- AFTER INSERT — logowanie nowych rekordów
CREATE TRIGGER after_produkt_insert
AFTER INSERT ON produkty
FOR EACH ROW
BEGIN
    INSERT INTO audit_log (tabela, operacja, rekord_id, nowa_wartosc, data_operacji)
    VALUES (
        'produkty',
        'INSERT',
        NEW.id,
        CONCAT('nazwa=', NEW.nazwa, ', cena=', NEW.cena),
        NOW()
    );
END //

-- BEFORE UPDATE — śledzenie zmian
CREATE TRIGGER before_produkt_update
BEFORE UPDATE ON produkty
FOR EACH ROW
BEGIN
    -- Automatycznie ustaw datę modyfikacji
    SET NEW.data_modyfikacji = NOW();

    -- Zapobegnij zmniejszeniu ceny o więcej niż 50%
    IF NEW.cena < OLD.cena * 0.5 THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Nie można zmniejszyć ceny o więcej niż 50%';
    END IF;
END //

-- AFTER UPDATE — logowanie zmian cen
CREATE TRIGGER after_cena_update
AFTER UPDATE ON produkty
FOR EACH ROW
BEGIN
    IF OLD.cena != NEW.cena THEN
        INSERT INTO historia_cen (produkt_id, cena_stara, cena_nowa, data_zmiany)
        VALUES (OLD.id, OLD.cena, NEW.cena, NOW());
    END IF;
END //

-- BEFORE DELETE — archiwizacja przed usunięciem
CREATE TRIGGER before_klient_delete
BEFORE DELETE ON klienci
FOR EACH ROW
BEGIN
    INSERT INTO klienci_archiwum (id, imie, nazwisko, email, data_usuniecia)
    VALUES (OLD.id, OLD.imie, OLD.nazwisko, OLD.email, NOW());
END //

-- AFTER DELETE — czyszczenie po usunięciu
CREATE TRIGGER after_kategoria_delete
AFTER DELETE ON kategorie
FOR EACH ROW
BEGIN
    -- Ustaw produkty z tej kategorii bez kategorii
    UPDATE produkty SET kategoria_id = NULL
    WHERE kategoria_id = OLD.id;
END //

DELIMITER ;

-- Lista triggerów
SHOW TRIGGERS FROM sklep;
SHOW TRIGGERS FROM sklep LIKE 'produkty%';
SHOW CREATE TRIGGER before_produkt_insert;

-- Usunięcie triggera
DROP TRIGGER IF EXISTS before_produkt_insert;
```

---

## 21. Użytkownicy i uprawnienia

```sql
-- Tworzenie użytkowników
CREATE USER 'jan'@'localhost' IDENTIFIED BY 'Haslo123!';
CREATE USER 'webapp'@'%' IDENTIFIED BY 'WebPass456!';
CREATE USER 'reporter'@'192.168.1.%' IDENTIFIED BY 'ReportPass789!';

-- Nadawanie uprawnień
GRANT ALL PRIVILEGES ON sklep.* TO 'jan'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON sklep.* TO 'webapp'@'%';
GRANT SELECT ON sklep.* TO 'reporter'@'192.168.1.%';
GRANT SELECT ON sklep.produkty TO 'katalog'@'localhost';

-- Odśwież tablice uprawnień
FLUSH PRIVILEGES;

-- Wyświetl uprawnienia
SHOW GRANTS;
SHOW GRANTS FOR 'jan'@'localhost';

-- Odbierz uprawnienia
REVOKE INSERT, UPDATE ON sklep.* FROM 'webapp'@'%';
REVOKE ALL PRIVILEGES ON sklep.* FROM 'stary_user'@'localhost';

-- Zmień hasło
ALTER USER 'jan'@'localhost' IDENTIFIED BY 'NoweHaslo999!';
SET PASSWORD FOR 'jan'@'localhost' = 'NoweHaslo999!';

-- Usuń użytkownika
DROP USER IF EXISTS 'stary_user'@'localhost';

-- Lista użytkowników
SELECT User, Host FROM mysql.user ORDER BY User;
```

---

## 22. Zmienne systemowe

```sql
-- Wersja serwera
SELECT @@VERSION;              -- np. 8.0.35 lub 10.11.4-MariaDB
SELECT @@GLOBAL.VERSION;

-- Katalog danych
SELECT @@DATADIR;              -- np. /var/lib/mysql/

-- Maksymalna liczba połączeń
SELECT @@MAX_CONNECTIONS;      -- domyślnie 151

-- Tryb SQL
SELECT @@SQL_MODE;             -- aktualny tryb (STRICT_TRANS_TABLES itp.)

-- Kodowanie
SELECT @@CHARACTER_SET_SERVER;  -- utf8mb4
SELECT @@COLLATION_SERVER;      -- utf8mb4_unicode_ci

-- Strefy czasowe
SELECT @@TIME_ZONE;             -- SYSTEM lub konkretna strefa
SELECT @@GLOBAL.TIME_ZONE;

-- Inne zmienne
SELECT @@HOSTNAME;              -- nazwa hosta serwera
SELECT @@PORT;                  -- port (domyślnie 3306)
SELECT @@HAVE_SSL;              -- czy SSL jest dostępny
SELECT @@INNODB_BUFFER_POOL_SIZE; -- rozmiar bufora InnoDB

-- Wyszukiwanie zmiennych
SHOW VARIABLES LIKE 'max%';
SHOW VARIABLES LIKE '%innodb%';
SHOW VARIABLES LIKE 'character%';

-- Zmiana zmiennych
SET GLOBAL max_connections = 200;
SET SESSION sql_mode = 'STRICT_TRANS_TABLES';
SET @@SESSION.time_zone = '+01:00';
```

---

## 23. EXPLAIN — analiza zapytań

```sql
-- Podstawowy EXPLAIN
EXPLAIN SELECT * FROM produkty WHERE kategoria_id = 5;

-- Przykład wyników EXPLAIN:
-- +----+-------------+----------+------+---------------+---------------+---------+-------+------+-------+
-- | id | select_type | table    | type | possible_keys | key           | key_len | ref   | rows | Extra |
-- +----+-------------+----------+------+---------------+---------------+---------+-------+------+-------+
-- |  1 | SIMPLE      | produkty | ref  | idx_kategoria | idx_kategoria | 5       | const |   23 |       |
-- +----+-------------+----------+------+---------------+---------------+---------+-------+------+-------+
```

### Kolumna `type` — od najlepszego do najgorszego

| Typ | Znaczenie | Wydajność |
|-----|-----------|-----------|
| `system` | Tabela ma 0 lub 1 wiersz | Najlepsza |
| `const` | Dopasowanie przez PK lub UNIQUE (1 wiersz) | Najlepsza |
| `eq_ref` | JOIN przez PK lub UNIQUE | Bardzo dobra |
| `ref` | Dopasowanie przez indeks (nie-unikalny) | Dobra |
| `range` | Zakres na indeksie (BETWEEN, >, <, IN) | Dobra |
| `index` | Pełne skanowanie indeksu | Słaba |
| `ALL` | Pełne skanowanie tabeli (Full Table Scan) | Najgorsza |

```sql
-- Sprawdź zapytanie bez indeksu
EXPLAIN SELECT * FROM produkty WHERE YEAR(data_dodania) = 2026;
-- type: ALL — pełne skanowanie! Unikaj funkcji na kolumnach w WHERE

-- Lepsze zapytanie
EXPLAIN SELECT * FROM produkty
WHERE data_dodania >= '2026-01-01' AND data_dodania < '2027-01-01';
-- type: range — używa indeksu na data_dodania

-- EXPLAIN FORMAT=JSON — szczegółowe informacje
EXPLAIN FORMAT=JSON SELECT * FROM produkty p
JOIN kategorie k ON p.kategoria_id = k.id
WHERE p.aktywny = 1;
```

---

## 24. Typowe błędy MySQL

### ERROR 1064 — błąd składni

```
ERROR 1064 (42000): You have an error in your SQL syntax;
check the manual that corresponds to your MySQL server version
```

```sql
-- Przyczyny:
-- 1. Literówka w nazwie komendy
SELEC * FROM tabela;  -- błąd: brakuje T w SELECT

-- 2. Użycie zarezerwowanego słowa bez cudzysłowu
CREATE TABLE order (id INT);  -- błąd: ORDER jest słowem kluczowym
CREATE TABLE `order` (id INT);  -- OK: backtick `

-- 3. Brak przecinka lub średnika
INSERT INTO t (a b) VALUES (1, 2);  -- błąd: brak przecinka między a i b

-- 4. Niezgodne cudzysłowy
SELECT * FROM tabela WHERE imie = 'Jan";  -- mieszanie ' i "
```

### ERROR 1045 — odmowa dostępu

```
ERROR 1045 (28000): Access denied for user 'jan'@'localhost' (using password: YES)
```

```sql
-- Przyczyny i rozwiązania:
-- 1. Złe hasło → zresetuj hasło
ALTER USER 'jan'@'localhost' IDENTIFIED BY 'NoweHaslo';
FLUSH PRIVILEGES;

-- 2. Zły host — użytkownik istnieje dla 'localhost', próbujesz z '127.0.0.1'
SELECT User, Host FROM mysql.user WHERE User = 'jan';
-- Utwórz duplikat dla innego hosta jeśli potrzeba:
CREATE USER 'jan'@'127.0.0.1' IDENTIFIED BY 'Haslo';
```

### ERROR 1215 — nie można dodać klucza obcego

```
ERROR 1215 (HY000): Cannot add foreign key constraint
```

```sql
-- Przyczyny:
-- 1. Różne typy danych kolumn
-- Rodzic: id INT, Dziecko: klient_id SMALLINT → błąd
-- Rozwiązanie: oba muszą być INT UNSIGNED (identyczny typ!)

-- 2. Brak indeksu na kolumnie referencyjnej (rodzic)
-- Kolumna w tabeli nadrzędnej musi być PK lub UNIQUE lub INDEX

-- 3. Silnik MyISAM nie obsługuje FK
-- Upewnij się że obie tabele to ENGINE=InnoDB

-- Diagnostyka:
SHOW ENGINE INNODB STATUS\G  -- szukaj LATEST FOREIGN KEY ERROR
```

### ERROR 1366 — nieprawidłowy typ danych

```
ERROR 1366 (HY000): Incorrect integer value: 'abc' for column 'id'
```

```sql
-- Próba wstawienia stringa do kolumny INT
INSERT INTO tabela (id) VALUES ('abc');  -- błąd

-- Rozwiązanie: popraw dane lub zmień typ kolumny
-- Jeśli jesteś pewien że chcesz wymusić konwersję:
SET sql_mode = '';  -- wyłącz strict mode (niezalecane!)
```

### ERROR 2002 — brak połączenia z serwerem

```
ERROR 2002 (HY000): Can't connect to local MySQL server through socket
```

```bash
# Przyczyny i rozwiązania:
# 1. Serwer nie jest uruchomiony
sudo systemctl start mariadb
sudo systemctl status mariadb

# 2. Zły socket
mysql -u root -p --socket=/var/run/mysqld/mysqld.sock

# 3. Problem z MAMP/XAMPP — sprawdź panel
# Upewnij się że MySQL/MariaDB jest uruchomiony w panelu XAMPP/MAMP
```

---

## 25. Anti-patterns — czego unikać

### SELECT * — zawsze podawaj konkretne kolumny

```sql
-- ZLE: SELECT *
SELECT * FROM klienci JOIN zamowienia ON klienci.id = zamowienia.klient_id;
-- Pobiera WSZYSTKIE kolumny, w tym niepotrzebne duże pola (TEXT, BLOB)
-- Uniemożliwia użycie covering index
-- Zwiększa transfer danych

-- DOBRZE: konkretne kolumny
SELECT klienci.id, klienci.imie, zamowienia.data_zamowienia, zamowienia.wartosc
FROM klienci JOIN zamowienia ON klienci.id = zamowienia.klient_id;
```

### Problem N+1 zapytań

```sql
-- ZLE: N+1 (pętla + zapytanie dla każdego elementu)
-- W aplikacji:
-- SELECT * FROM zamowienia;  -- 1 zapytanie, 100 wyników
-- Potem dla każdego: SELECT * FROM klienci WHERE id = ?  -- 100 zapytań!
-- Łącznie: 101 zapytań

-- DOBRZE: jeden JOIN
SELECT z.id, z.wartosc, k.imie, k.email
FROM zamowienia z
JOIN klienci k ON z.klient_id = k.id;
-- 1 zapytanie zamiast 101!
```

### Brak indeksów na kolumnach używanych w WHERE/JOIN

```sql
-- ZLE: zapytanie bez indeksu na często filtrowanej kolumnie
SELECT * FROM zamowienia WHERE status = 'nowe';
-- status bez indeksu → Full Table Scan dla miliona rekordów

-- DOBRZE: dodaj indeks
CREATE INDEX idx_status ON zamowienia(status);
-- Teraz szuka w indeksie (range/ref zamiast ALL)
```

### Funkcje na kolumnach w WHERE uniemożliwiają indeksy

```sql
-- ZLE: funkcja na kolumnie z indeksem
SELECT * FROM zamowienia WHERE YEAR(data_zamowienia) = 2026;
-- MySQL nie może użyć indeksu na data_zamowienia!

-- DOBRZE: przekształć warunek
SELECT * FROM zamowienia
WHERE data_zamowienia >= '2026-01-01'
  AND data_zamowienia < '2027-01-01';

-- ZLE:
SELECT * FROM klienci WHERE LOWER(email) = 'jan@example.com';
-- DOBRZE: przechowuj email zawsze w lower, lub ustaw case-insensitive collation
SELECT * FROM klienci WHERE email = 'jan@example.com';
```

### Brak transakcji przy operacjach zależnych

```sql
-- ZLE: operacje bez transakcji
UPDATE konta SET saldo = saldo - 500 WHERE id = 1;
-- Jeśli tu nastąpi awaria → pieniądze zniknęły bez dotarcia do odbiorcy!
UPDATE konta SET saldo = saldo + 500 WHERE id = 2;

-- DOBRZE: transakcja gwarantuje atomowość
START TRANSACTION;
UPDATE konta SET saldo = saldo - 500 WHERE id = 1;
UPDATE konta SET saldo = saldo + 500 WHERE id = 2;
COMMIT;
```

### Przechowywanie haseł jako zwykły tekst

```php
// ZLE: hasło w bazie jako plain text
INSERT INTO uzytkownicy (login, haslo) VALUES ('jan', 'mojehaslo');

// DOBRZE: zawsze hashuj hasło (PHP)
$hash = password_hash('mojehaslo', PASSWORD_BCRYPT);
// INSERT INTO uzytkownicy (login, haslo) VALUES ('jan', '$2y$10$...');

// Weryfikacja
$ok = password_verify('mojehaslo', $hash_z_bazy);
```

### Zbyt wiele indeksów

```sql
-- ZLE: indeks na każdej kolumnie
CREATE INDEX idx1 ON tabela(kol1);
CREATE INDEX idx2 ON tabela(kol2);
CREATE INDEX idx3 ON tabela(kol3);
-- ... 20 indeksów na tabeli

-- Problem: każdy INSERT/UPDATE/DELETE musi aktualizować WSZYSTKIE indeksy
-- Indeksy zajmują miejsce na dysku
-- Optymalizator musi wybrać spośród wielu → wolniejsze planowanie

-- DOBRZE: indeksuj tylko kolumny używane w WHERE, JOIN, ORDER BY, GROUP BY
-- Używaj indeksów złożonych dla często łączonych warunków
```

### Używanie LIKE z wiodącym wildcard

```sql
-- ZLE: LIKE z % na początku = Full Table Scan!
SELECT * FROM produkty WHERE nazwa LIKE '%Phone%';
-- Nie może użyć indeksu B-Tree na nazwa

-- DOBRZE dla wyszukiwania pełnotekstowego:
ALTER TABLE produkty ADD FULLTEXT INDEX ft_nazwa (nazwa);

SELECT * FROM produkty
WHERE MATCH(nazwa) AGAINST('Phone' IN BOOLEAN MODE);
-- Używa indeksu FULLTEXT

-- Lub: LIKE z % tylko na końcu (może używać indeksu)
SELECT * FROM produkty WHERE nazwa LIKE 'iPhone%';
```
