# 📚 ŚCIĄGAWKA: SQL PODSTAWY (INF.03.4 - Bazy danych)

---

## 1️⃣ CO TO JEST SQL?

**SQL** = Structured Query Language
- Język służący do komunikacji z bazami danych
- Umożliwia: tworzenie, modyfikowanie, usuwanie i pobieranie danych
- Standard: ANSI SQL (MySQL, PostgreSQL, SQL Server różne warianty)

---

## 2️⃣ KATEGORIE POLECEŃ SQL

### DDL (Data Definition Language) - Definicja danych
```sql
CREATE   -- Tworzenie nowych obiektów
ALTER    -- Modyfikacja istniejących
DROP     -- Usunięcie obiektów
TRUNCATE -- Szybkie usunięcie danych z tabeli
```

### DML (Data Manipulation Language) - Manipulacja danymi
```sql
SELECT   -- Pobieranie danych
INSERT   -- Wstawianie nowych wierszy
UPDATE   -- Modyfikacja istniejących wierszy
DELETE   -- Usuwanie wierszy
```

### DCL (Data Control Language) - Kontrola dostępu
```sql
GRANT    -- Nadawanie uprawnień
REVOKE   -- Odbieranie uprawnień
```

### TCL (Transaction Control Language) - Kontrola transakcji
```sql
COMMIT   -- Zatwierdzenie zmian
ROLLBACK -- Cofnięcie zmian
BEGIN    -- Rozpoczęcie transakcji
```

---

## 3️⃣ TYPY DANYCH W BAZIE

### Typ liczbowy
```sql
INT / INTEGER           -- Liczby całkowite (-2147483648 do 2147483647)
BIGINT                  -- Duże liczby całkowite
DECIMAL(10,2)           -- Liczby stałoprzecinkowe (dokładne)
FLOAT / REAL            -- Liczby zmiennoprzecinkowe (przybliżone)
TINYINT                 -- Małe liczby (0-255)
```

### Typ tekstowy
```sql
CHAR(50)                -- Tekst stałej długości (mniej elastyczne)
VARCHAR(255)            -- Tekst zmiennej długości (zalecane)
TEXT                    -- Długie teksty
ENUM('M','K')           -- Enum (ograniczone wartości)
```

### Typ datowy
```sql
DATE                    -- Format: YYYY-MM-DD
TIME                    -- Format: HH:MM:SS
DATETIME / TIMESTAMP    -- Format: YYYY-MM-DD HH:MM:SS
YEAR                    -- Tylko rok
```

### Typ boolowski
```sql
BOOLEAN / BOOL          -- TRUE (1) / FALSE (0)
```

### Typ binarny
```sql
BLOB                    -- Dane binarne (obrazy, pliki)
```

---

## 4️⃣ DDL - TWORZENIE STRUKTURY BAZY

### CREATE DATABASE - Tworzenie bazy danych
```sql
CREATE DATABASE nazwa_bazy;
CREATE DATABASE IF NOT EXISTS nazwa_bazy;
DROP DATABASE nazwa_bazy;
```

### CREATE TABLE - Tworzenie tabeli
```sql
CREATE TABLE pracownicy (
    id INT PRIMARY KEY AUTO_INCREMENT,
    imie VARCHAR(100) NOT NULL,
    nazwisko VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    pensja DECIMAL(10,2),
    data_zatrudnienia DATE,
    aktywny BOOLEAN DEFAULT TRUE
);
```

### Ograniczenia (Constraints)
```sql
PRIMARY KEY     -- Unikalny identyfikator wiersza
FOREIGN KEY     -- Odniesienie do innej tabeli
UNIQUE          -- Wartość musi być unikalna
NOT NULL        -- Wartość obowiązkowa
DEFAULT         -- Wartość domyślna
CHECK           -- Walidacja wartości
```

### Klucz obcy (Foreign Key)
```sql
CREATE TABLE zamowienia (
    id INT PRIMARY KEY AUTO_INCREMENT,
    pracownik_id INT,
    data_zamowienia DATE,
    FOREIGN KEY (pracownik_id) REFERENCES pracownicy(id)
        ON DELETE CASCADE          -- Kasuj zamówienia jeśli usunąć pracownika
        ON UPDATE CASCADE          -- Aktualizuj ID jeśli się zmieni
);
```

### ALTER TABLE - Modyfikacja tabeli
```sql
ALTER TABLE pracownicy ADD COLUMN telefon VARCHAR(20);
ALTER TABLE pracownicy DROP COLUMN telefon;
ALTER TABLE pracownicy MODIFY COLUMN imie VARCHAR(150);
ALTER TABLE pracownicy CHANGE COLUMN imie imie_pracownika VARCHAR(100);
```

---

## 5️⃣ DML - MANIPULACJA DANYMI

### SELECT - Pobieranie danych

**Podstawowa składnia:**
```sql
SELECT kolumny
FROM tabela
WHERE warunki
ORDER BY kolumna [ASC|DESC]
LIMIT liczba;
```

**Przykłady:**
```sql
-- Wszystkie kolumny
SELECT * FROM pracownicy;

-- Wybrane kolumny
SELECT imie, nazwisko, pensja FROM pracownicy;

-- Z warunkiem
SELECT * FROM pracownicy WHERE pensja > 3000;

-- Z sortowaniem
SELECT * FROM pracownicy ORDER BY pensja DESC;

-- Z limitowaniem
SELECT * FROM pracownicy LIMIT 10 OFFSET 20;  -- Strona 3 (20-30)

-- DISTINCT - Unikalne wartości
SELECT DISTINCT departament FROM pracownicy;

-- Kombinacja
SELECT * FROM pracownicy 
WHERE aktywny = TRUE 
ORDER BY nazwisko ASC 
LIMIT 50;
```

### INSERT - Wstawianie danych

```sql
-- Wstawianie pełnego wiersza
INSERT INTO pracownicy (imie, nazwisko, email, pensja) 
VALUES ('Jan', 'Kowalski', 'jan@example.com', 3500);

-- Wstawianie wielu wierszy
INSERT INTO pracownicy (imie, nazwisko, email) VALUES 
('Anna', 'Nowak', 'anna@example.com'),
('Piotr', 'Lewandowski', 'piotr@example.com'),
('Maria', 'Krul', 'maria@example.com');

-- Z podrzędu (transfer danych)
INSERT INTO pracownicy_archiwum 
SELECT * FROM pracownicy WHERE pensja < 2000;
```

### UPDATE - Modyfikacja danych

```sql
-- Zmiana jednego pracownika
UPDATE pracownicy 
SET pensja = 4000 
WHERE id = 5;

-- Zmiana wielu kolumn
UPDATE pracownicy 
SET pensja = 3500, aktywny = TRUE 
WHERE departament = 'IT';

-- Zmiana wszystkich (UWAGA!)
UPDATE pracownicy SET aktywny = TRUE;  -- Bez WHERE - zmienia wszystko!

-- Z obliczeniem
UPDATE pracownicy 
SET pensja = pensja * 1.1  -- Podwyżka 10%
WHERE departament = 'IT';
```

### DELETE - Usuwanie danych

```sql
-- Usunięcie jednego wiersza
DELETE FROM pracownicy WHERE id = 5;

-- Usunięcie wielu wierszy
DELETE FROM pracownicy WHERE pensja < 2000;

-- Usunięcie wszystkiego (UWAGA! NIEBEZPIECZNE!)
DELETE FROM pracownicy;

-- TRUNCATE - szybsze czyszczenie (resetuje ID)
TRUNCATE TABLE pracownicy;
```

### AGGREGATE Functions - Funkcje agregujące

```sql
SELECT COUNT(*) AS liczba_pracownikow FROM pracownicy;
SELECT SUM(pensja) AS suma_pensji FROM pracownicy;
SELECT AVG(pensja) AS srednia_pensja FROM pracownicy;
SELECT MAX(pensja) AS max_pensja FROM pracownicy;
SELECT MIN(pensja) AS min_pensja FROM pracownicy;
SELECT CONCAT(imie, ' ', nazwisko) AS pelne_imie FROM pracownicy;
```

### GROUP BY - Grupowanie

```sql
SELECT departament, COUNT(*) AS liczba, AVG(pensja) AS srednia
FROM pracownicy
GROUP BY departament
HAVING COUNT(*) > 3  -- Tylko grupy z >3 osobami
ORDER BY srednia DESC;
```

---

## 6️⃣ JOINS - POŁĄCZENIA TABEL

### INNER JOIN (JOIN) - Tylko wspólne rekordy
```sql
SELECT p.imie, p.nazwisko, z.nazwa_zamowienia
FROM pracownicy p
INNER JOIN zamowienia z ON p.id = z.pracownik_id;
```

### LEFT JOIN - Wszystkie z lewej tabeli + pasujące z prawej
```sql
SELECT p.imie, p.nazwisko, z.nazwa_zamowienia
FROM pracownicy p
LEFT JOIN zamowienia z ON p.id = z.pracownik_id;
-- Pracownicy bez zamówień będą mieć NULL w kolumnie zamowienia
```

### RIGHT JOIN - Wszystkie z prawej tabeli + pasujące z lewej
```sql
SELECT p.imie, p.nazwisko, z.nazwa_zamowienia
FROM pracownicy p
RIGHT JOIN zamowienia z ON p.id = z.pracownik_id;
```

### FULL OUTER JOIN - Wszystkie rekordy z obu tabel
```sql
SELECT p.imie, p.nazwisko, z.nazwa_zamowienia
FROM pracownicy p
FULL OUTER JOIN zamowienia z ON p.id = z.pracownik_id;
-- Uwaga: MySQL nie obsługuje FULL OUTER JOIN! Użyj UNION
```

### CROSS JOIN - Iloczyn kartezjański
```sql
SELECT p.imie, d.nazwa
FROM pracownicy p
CROSS JOIN departamenty d;
-- Każdy pracownik - każdy departament (wszystkie kombinacje)
```

### Wizualna pomoc JOINów
```
INNER JOIN  - Część wspólna     [◀ ▶]
LEFT JOIN   - Lewa + wspólna    [◀▶ ]
RIGHT JOIN  - Prawa + wspólna   [ ◀▶]
FULL JOIN   - Wszystko          [◀▶▶]
```

---

## 7️⃣ PODZAPYTANIA (SUBQUERIES)

### Podzapytanie w WHERE
```sql
-- Pracownicy zarabiający więcej niż średnia
SELECT * FROM pracownicy
WHERE pensja > (SELECT AVG(pensja) FROM pracownicy);

-- Pracownicy z tego samego departamentu co Jan
SELECT * FROM pracownicy
WHERE departament = (SELECT departament FROM pracownicy WHERE imie = 'Jan');
```

### Podzapytanie w FROM
```sql
SELECT departament, srednia_pensja
FROM (
    SELECT departament, AVG(pensja) AS srednia_pensja
    FROM pracownicy
    GROUP BY departament
) AS dept_salaries
WHERE srednia_pensja > 3500;
```

### Podzapytanie w SELECT
```sql
SELECT 
    imie, 
    (SELECT COUNT(*) FROM zamowienia WHERE pracownik_id = pracownicy.id) AS liczba_zamowien
FROM pracownicy;
```

### EXISTS - Sprawdzanie istnienia
```sql
SELECT * FROM pracownicy p
WHERE EXISTS (SELECT 1 FROM zamowienia z WHERE z.pracownik_id = p.id);
-- Tylko pracownicy, którzy mają zamówienia
```

### IN / NOT IN
```sql
SELECT * FROM pracownicy 
WHERE id IN (1, 3, 5, 7);

SELECT * FROM pracownicy 
WHERE id NOT IN (SELECT pracownik_id FROM zamowienia);
-- Pracownicy bez żadnych zamówień
```

---

## 8️⃣ OPERATORY

### Operatory porównania
```sql
=     -- Równość
!=, <> -- Nierówność
>     -- Większe
<     -- Mniejsze
>=    -- Większe lub równe
<=    -- Mniejsze lub równe
```

### Operatory logiczne
```sql
AND   -- Muszą być spełnione oba warunki
OR    -- Co najmniej jeden warunek
NOT   -- Negacja warunku
```

### Operatory tekstowe
```sql
LIKE '%Jan%'      -- Zawiera "Jan"
LIKE 'Jan%'       -- Zaczyna się na "Jan"
LIKE '%Jan'       -- Kończy się na "Jan"
LIKE '_an'        -- Jedno znaku, potem "an"
REGEXP '^Jan.*k$' -- Wyrażenie regularne
```

### Operatory zakresowe
```sql
BETWEEN 2000 AND 5000   -- Od 2000 do 5000
NOT BETWEEN 2000 AND 5000
IN (1, 2, 3)
NOT IN (1, 2, 3)
```

### NULL
```sql
IS NULL          -- Czy wartość jest pusta
IS NOT NULL      -- Czy wartość nie jest pusta
IFNULL(col, 0)   -- Zastępowanie NULL wartością
COALESCE(col1, col2, 0) -- Pierwszy nie-NULL
```

---

## 9️⃣ WIDOKI (VIEWS)

```sql
-- Tworzenie widoku
CREATE VIEW pracownicy_it AS
SELECT imie, nazwisko, pensja
FROM pracownicy
WHERE departament = 'IT';

-- Używanie widoku (jak normalnej tabeli)
SELECT * FROM pracownicy_it;

-- Usunięcie widoku
DROP VIEW pracownicy_it;

-- Aktualizowanie widoku
ALTER VIEW pracownicy_it AS
SELECT imie, nazwisko, pensja, email
FROM pracownicy
WHERE departament = 'IT' AND aktywny = TRUE;
```

---

## 🔟 INDEKSY

```sql
-- Tworzenie indeksu (przyspieszenie wyszukiwania)
CREATE INDEX idx_email ON pracownicy(email);
CREATE UNIQUE INDEX idx_pesel ON pracownicy(pesel);
CREATE INDEX idx_nazwisko_imie ON pracownicy(nazwisko, imie);

-- Usunięcie indeksu
DROP INDEX idx_email ON pracownicy;

-- Lista indeksów
SHOW INDEX FROM pracownicy;

-- Wskazówka: Indeksuj kolumny używane w WHERE i JOIN
```

---

## 1️⃣1️⃣ TRANSAKCJE (TRANSACTIONS)

### ACID Właściwości
- **A**tomicity - Wszystko lub nic
- **C**onsistency - Spójność danych
- **I**solation - Odizolowanie
- **D**urability - Trwałość

```sql
START TRANSACTION;  -- lub BEGIN

UPDATE pracownicy SET pensja = pensja - 1000 WHERE id = 1;
UPDATE pracownicy SET pensja = pensja + 1000 WHERE id = 2;

-- Jeśli coś poszło nie tak:
ROLLBACK;  -- Cofnij wszystkie zmiany

-- Jeśli OK:
COMMIT;    -- Zatwierdź zmiany
```

### Savepoints
```sql
BEGIN;
INSERT INTO pracownicy VALUES (...);
SAVEPOINT punkt1;

INSERT INTO pracownicy VALUES (...);
ROLLBACK TO punkt1;  -- Cofnij do punktu1

COMMIT;
```

---

## 1️⃣2️⃣ PODSUMOWANIE DO EGZAMINU

| Polecenie | Zadanie | Kategoria |
|-----------|---------|-----------|
| **CREATE** | Tworzenie nowych obiektów | DDL |
| **SELECT** | Pobieranie danych | DML |
| **INSERT** | Dodawanie danych | DML |
| **UPDATE** | Modyfikacja danych | DML |
| **DELETE** | Usuwanie danych | DML |
| **ALTER** | Zmiana struktury | DDL |
| **DROP** | Usunięcie obiektu | DDL |
| **TRUNCATE** | Szybkie czyszczenie | DDL |
| **JOIN** | Łączenie tabel | DML |
| **GROUP BY** | Grupowanie wyników | DML |
| **ORDER BY** | Sortowanie | DML |
| **LIMIT** | Ograniczenie wierszy | DML |

---

**Powodzenia na egzaminie! 🎓**
