# SQL Zaawansowany - Egzamin INF.03

> Najczesciej wystepujace kwerendy na prawdziwych egzaminach 2024-2026
> Na podstawie analizy egzaminow: inf_03_2024_*, inf_03_2025_*, inf_03_2026_*

---

## STATYSTYKI Z PRAWDZIWYCH EGZAMINOW

Z analizy kwerendy.txt ze wszystkich egzaminow 2024-2026:

| Typ kwerendy | Czestotliwosc | Przyklad z egzaminu |
|-------------|---------------|---------------------|
| SELECT + WHERE | 100% egzaminow | `SELECT nazwa FROM tabela WHERE id = 7` |
| SELECT + JOIN | 100% egzaminow | JOIN na 2 tabelach |
| SELECT + GROUP BY + AVG | 90% egzaminow | srednio z grupy |
| INSERT INTO | 80% egzaminow | dodanie jednego wiersza |
| JOIN na 3 tabelach | 60% egzaminow | wiele-do-wielu |
| ROUND(AVG()) | 80% egzaminow | srednia zaokraglona do 2 miejscy |
| ORDER BY | 70% egzaminow | sortowanie wynikow |
| ALTER TABLE | 20% egzaminow | dodanie kolumny |

### Wzorzec 4 kwerend (staly schemat egzaminu!)
```
kw1: SELECT proste z WHERE (lub ROUND AVG)
kw2: INSERT INTO ... VALUES
kw3: SELECT z JOIN (2 tabele) + WHERE
kw4: SELECT z JOIN + GROUP BY (lub JOIN 3 tabel)
```

---

## 1. SELECT - PODSTAWY

### Prosta selekcja
```sql
-- Wszystkie kolumny
SELECT * FROM produkty;

-- Wybrane kolumny
SELECT nazwa, cena, kategoria FROM produkty;

-- Z aliasem kolumny
SELECT nazwa AS 'Nazwa produktu', cena AS 'Cena (PLN)' FROM produkty;

-- Bez duplikatow
SELECT DISTINCT kraj FROM miejscowosc;
```

### SELECT z WHERE
```sql
-- Rownosc
SELECT * FROM produkty WHERE id = 7;

-- Porownanie
SELECT * FROM produkty WHERE cena > 100;
SELECT * FROM produkty WHERE cena BETWEEN 50 AND 200;

-- Tekst
SELECT * FROM uzytkownik WHERE imie = 'Jan';

-- Kilka warunkow
SELECT * FROM produkty WHERE cena > 50 AND kategoria_id = 3;
SELECT * FROM produkty WHERE kategoria_id = 1 OR kategoria_id = 2;

-- NULL
SELECT * FROM produkty WHERE opis IS NULL;
SELECT * FROM produkty WHERE opis IS NOT NULL;

-- Lista wartosci
SELECT * FROM produkty WHERE id IN (1, 3, 5, 7);
SELECT * FROM produkty WHERE id NOT IN (2, 4);
```

### SELECT z ORDER BY
```sql
-- Rosnaco (domyslne)
SELECT nazwa, cena FROM produkty ORDER BY cena ASC;
SELECT nazwa, cena FROM produkty ORDER BY cena;

-- Malejaco
SELECT nazwa, cena FROM produkty ORDER BY cena DESC;

-- Wielopoziomowe sortowanie
SELECT nazwa, cena FROM produkty ORDER BY kategoria_id ASC, cena DESC;

-- Z LIMIT
SELECT nazwa, cena FROM produkty ORDER BY cena DESC LIMIT 10;
```

---

## 2. WZORCE EGZAMINACYJNE - DOKLADNE PRZYKLADY

### Z egzaminu 2026-01-07 (Pogoda)
```sql
-- kw1: AVG z ROUND - typowe!
SELECT ROUND(AVG(temperatura), 2) FROM pomiary WHERE id_miesiac = 7;

-- kw2: INSERT INTO
INSERT INTO miejscowosc (kraj, nazwa) VALUES ('Ukraina', 'Kijow');

-- kw3: JOIN 2 tabel + WHERE
SELECT miejscowosc.nazwa, miejscowosc.kraj, pomiary.temperatura
FROM miejscowosc
JOIN pomiary ON pomiary.id_miejscowosc = miejscowosc.id
WHERE pomiary.id_miesiac = 7;

-- kw4: JOIN + GROUP BY bez HAVING
SELECT miesiace.nazwa, AVG(pomiary.temperatura)
FROM miesiace
JOIN pomiary ON pomiary.id_miesiac = miesiace.id
GROUP BY miesiace.nazwa;
```

### Z egzaminu 2026-01-10 (Przepisy)
```sql
-- kw1: SELECT z WHERE + kilka kolumn
SELECT nazwa, trudnosc, kalorie FROM potrawy WHERE idPotrawy = 7;

-- kw2: JOIN 2 tabel + WHERE
SELECT potrawy.nazwa, rodzaje.rodzaj
FROM potrawy
JOIN rodzaje ON rodzaje.idRodzaje = potrawy.idRodzaje
WHERE potrawy.idPotrawy = 7;

-- kw3: JOIN 3 TABEL (tabela posrednia many-to-many) - TRUDNE!
SELECT potrawy.nazwa, alergeny.alergen
FROM potrawy
JOIN lista_alergenow ON lista_alergenow.idPotrawy = potrawy.idPotrawy
JOIN alergeny ON alergeny.idAlergeny = lista_alergenow.idAlergeny
WHERE potrawy.idPotrawy = 7;

-- kw4: SELECT kilku kolumn z WHERE
SELECT przepis, plik FROM potrawy WHERE idPotrawy = 7;
```

### Z egzaminu 2024-06-03 (Rzeki)
```sql
-- kw1: Prosta selekcja
SELECT nazwa, rzeka, stanAlarmowy FROM wodowskazy;

-- kw2: JOIN z warunkiem daty
SELECT nazwa, rzeka, stanOstrzegawczy, stanAlarmowy, stanWody
FROM wodowskazy
JOIN pomiary ON pomiary.wodowskazy_id = wodowskazy.id
WHERE dataPomiaru = '2022-05-05';

-- kw3: JOIN z wieloma warunkami (porownanie kolumn!)
SELECT nazwa, rzeka, stanOstrzegawczy, stanAlarmowy, stanWody
FROM wodowskazy
JOIN pomiary ON pomiary.wodowskazy_id = wodowskazy.id
WHERE dataPomiaru = '2022-05-05' AND stanWody > stanOstrzegawczy;

-- kw4: GROUP BY z agregacja
SELECT dataPomiaru, AVG(stanWody)
FROM pomiary
GROUP BY dataPomiaru;
-- lub GROUP BY 1 (skrot: grupuj po pierwszej kolumnie z SELECT)
```

---

## 3. JOIN - WSZYSTKIE TYPY

### Wizualizacja JOIN
```
Tabela A    Tabela B
  1           1     ← pasuje
  2           3     ← pasuje
  3           5     ← B nie ma w A
  4               ← A nie ma w B
```

| Typ JOIN | Co zwraca |
|----------|-----------|
| `INNER JOIN` | Tylko pasujace wiersze (przeciecie) |
| `LEFT JOIN` | Wszystkie z lewej + pasujace z prawej (NULL jesli brak) |
| `RIGHT JOIN` | Wszystkie z prawej + pasujace z lewej (NULL jesli brak) |
| `FULL OUTER JOIN` | Wszystkie z obu tabel (MySQL nie wspiera - uzyj UNION) |
| `CROSS JOIN` | Iloczyn kartezjanski (kazdy z kazdym) |

### INNER JOIN (najczestszy na egzaminie)
```sql
-- JOIN 2 tabel
SELECT produkty.nazwa, kategorie.nazwa AS kategoria
FROM produkty
JOIN kategorie ON kategorie.id = produkty.id_kategorii;

-- JOIN 2 tabel z WHERE
SELECT produkty.nazwa, kategorie.nazwa
FROM produkty
INNER JOIN kategorie ON kategorie.id = produkty.id_kategorii
WHERE produkty.cena > 100;

-- Skrot: aliasy tabel
SELECT p.nazwa, k.nazwa AS kategoria
FROM produkty p
JOIN kategorie k ON k.id = p.id_kategorii;
```

### LEFT JOIN
```sql
-- Wszyscy klienci, nawet bez zamowien
SELECT klienci.imie, klienci.nazwisko, zamowienia.data
FROM klienci
LEFT JOIN zamowienia ON zamowienia.klient_id = klienci.id;

-- Znajdz klientow BEZ zamowien
SELECT klienci.imie, klienci.nazwisko
FROM klienci
LEFT JOIN zamowienia ON zamowienia.klient_id = klienci.id
WHERE zamowienia.id IS NULL;
```

### JOIN 3 tabel (relacja wiele-do-wielu)
```sql
-- Schemat: ksiazki ↔ ksiazki_autorzy ↔ autorzy
SELECT ksiazki.tytul, autorzy.nazwisko
FROM ksiazki
JOIN ksiazki_autorzy ON ksiazki_autorzy.ksiazka_id = ksiazki.id
JOIN autorzy ON autorzy.id = ksiazki_autorzy.autor_id;

-- Z filtrowaniem
SELECT ksiazki.tytul, autorzy.nazwisko, autorzy.kraj
FROM ksiazki
JOIN ksiazki_autorzy ON ksiazki_autorzy.ksiazka_id = ksiazki.id
JOIN autorzy ON autorzy.id = ksiazki_autorzy.autor_id
WHERE ksiazki.id = 7;
```

### Typowy biad z JOIN - brak aliasu
```sql
-- ZLE - niejednoznaczna kolumna 'nazwa'
SELECT nazwa, nazwa FROM produkty JOIN kategorie ON ...;  -- ERROR!

-- DOBRZE - z aliasami tabel lub kolumn
SELECT produkty.nazwa AS produkt, kategorie.nazwa AS kategoria
FROM produkty
JOIN kategorie ON kategorie.id = produkty.id_kategorii;
```

---

## 4. GROUP BY i HAVING

### GROUP BY z funkcjami agregujacymi
```sql
-- Srednia cena per kategoria
SELECT kategoria_id, AVG(cena) AS srednia_cena
FROM produkty
GROUP BY kategoria_id;

-- Z JOIN (czesciej na egzaminie)
SELECT kategorie.nazwa, AVG(produkty.cena) AS srednia_cena
FROM produkty
JOIN kategorie ON kategorie.id = produkty.id_kategorii
GROUP BY kategorie.nazwa;

-- Liczba produktow w kategorii
SELECT kategorie.nazwa, COUNT(produkty.id) AS liczba_produktow
FROM kategorie
LEFT JOIN produkty ON produkty.id_kategorii = kategorie.id
GROUP BY kategorie.nazwa;

-- Sortowanie po agregacie
SELECT kategorie.nazwa, AVG(produkty.cena) AS srednia_cena
FROM produkty
JOIN kategorie ON kategorie.id = produkty.id_kategorii
GROUP BY kategorie.nazwa
ORDER BY srednia_cena DESC;
```

### HAVING vs WHERE - kluczowa roznica!
```sql
-- WHERE: filtruje PRZED grupowaniem (na wierszach)
SELECT kategoria_id, AVG(cena)
FROM produkty
WHERE cena > 10          -- tylko produkty drozniejze niz 10
GROUP BY kategoria_id;

-- HAVING: filtruje PO grupowaniu (na grupach)
SELECT kategoria_id, AVG(cena) AS srednia
FROM produkty
GROUP BY kategoria_id
HAVING AVG(cena) > 50;   -- tylko kategorie ze srednia > 50

-- Razem WHERE i HAVING
SELECT kategoria_id, AVG(cena) AS srednia
FROM produkty
WHERE aktywny = 1                -- najpierw filtruj wiersze
GROUP BY kategoria_id
HAVING AVG(cena) > 50            -- potem filtruj grupy
ORDER BY srednia DESC;
```

### Typowe GROUP BY na egzaminie
```sql
-- Srednia temperatura per miesiac (INF.03-2026)
SELECT miesiace.nazwa, AVG(pomiary.temperatura)
FROM miesiace
JOIN pomiary ON pomiary.id_miesiac = miesiace.id
GROUP BY miesiace.nazwa;

-- Sredni stan wody per dzien (INF.03-2024)
SELECT dataPomiaru, AVG(stanWody)
FROM pomiary
GROUP BY dataPomiaru;

-- Suma sprzedazy per klient
SELECT klienci.nazwisko, SUM(zamowienia.kwota) AS suma
FROM klienci
JOIN zamowienia ON zamowienia.klient_id = klienci.id
GROUP BY klienci.id, klienci.nazwisko
ORDER BY suma DESC;
```

---

## 5. FUNKCJE AGREGUJACE

### Wszystkie funkcje agregujace
```sql
-- COUNT - liczba wierszy
SELECT COUNT(*) FROM produkty;              -- liczy wszystkie wiersze
SELECT COUNT(opis) FROM produkty;           -- liczy wiersze gdzie opis IS NOT NULL
SELECT COUNT(DISTINCT kategoria_id) FROM produkty;  -- unikalne kategorie

-- SUM - suma
SELECT SUM(cena) FROM produkty;
SELECT SUM(ilosc * cena) AS wartosc FROM pozycje_zamowienia;

-- AVG - srednia
SELECT AVG(cena) FROM produkty;
SELECT AVG(temperatura) FROM pomiary WHERE id_miesiac = 7;

-- MAX i MIN
SELECT MAX(cena) AS najdrozszy, MIN(cena) AS najtanszy FROM produkty;
SELECT MAX(data) AS ostatnie_zamowienie FROM zamowienia;

-- ROUND - zaokraglenie (czeste na egzaminie!)
SELECT ROUND(AVG(temperatura), 2) FROM pomiary;      -- 2 miejsca po przecinku
SELECT ROUND(SUM(cena), 0) FROM produkty;            -- zaokragl do calych
SELECT ROUND(AVG(cena)) FROM produkty;               -- domyslnie 0 miejsc
```

### Kombinacje funkcji agregujacych
```sql
-- Statystyki per kategoria
SELECT
    kategoria_id,
    COUNT(*) AS liczba,
    MIN(cena) AS min_cena,
    MAX(cena) AS max_cena,
    ROUND(AVG(cena), 2) AS avg_cena,
    SUM(cena) AS suma_cen
FROM produkty
GROUP BY kategoria_id;
```

---

## 6. LIKE i REGEXP

### LIKE - wzorce tekstowe
```sql
-- % - dowolna liczba dowolnych znakow
SELECT * FROM produkty WHERE nazwa LIKE 'Tele%';       -- zaczyna sie od "Tele"
SELECT * FROM produkty WHERE nazwa LIKE '%owy';        -- konczy sie na "owy"
SELECT * FROM produkty WHERE nazwa LIKE '%sam%';       -- zawiera "sam"
SELECT * FROM produkty WHERE email LIKE '%@gmail.com'; -- konta Gmail

-- _ - dokladnie jeden dowolny znak
SELECT * FROM produkty WHERE kod LIKE 'PL___';         -- PL + 3 znaki
SELECT * FROM produkty WHERE telefon LIKE '48_________'; -- 48 + 9 cyfr

-- Kombinacje
SELECT * FROM klienci WHERE nazwisko LIKE 'K_w%';      -- K, dowolny znak, w, cokolwiek

-- NOT LIKE
SELECT * FROM produkty WHERE nazwa NOT LIKE '%stary%';
```

### REGEXP - wyrazenia regularne (zaawansowane)
```sql
-- Zaczyna sie od cyfry
SELECT * FROM produkty WHERE nazwa REGEXP '^[0-9]';

-- Zawiera tylko litery
SELECT * FROM produkty WHERE kod REGEXP '^[A-Za-z]+$';

-- Walidacja emaila (uproszczone)
SELECT * FROM uzytkownik WHERE email REGEXP '^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$';
```

---

## 7. FUNKCJE DATY I CZASU

### Funkcje daty (MySQL)
```sql
-- Aktualna data i czas
SELECT NOW();                    -- 2024-06-15 14:30:45
SELECT CURDATE();                -- 2024-06-15
SELECT CURTIME();                -- 14:30:45

-- Czesci daty
SELECT YEAR(data_urodzenia) FROM klienci;     -- 1990
SELECT MONTH(data) FROM zamowienia;           -- 6
SELECT DAY(data) FROM zamowienia;             -- 15
SELECT DAYNAME(data) FROM zamowienia;         -- Saturday

-- Roznica dat
SELECT DATEDIFF('2024-12-31', '2024-06-15');  -- 199 (dni)
SELECT TIMESTAMPDIFF(YEAR, data_urodzenia, CURDATE()) AS wiek FROM klienci;

-- Formatowanie
SELECT DATE_FORMAT(data, '%d.%m.%Y') FROM zamowienia;  -- 15.06.2024
SELECT DATE_FORMAT(data, '%Y-%m') AS miesiac FROM zamowienia;

-- Dodawanie/odejmowanie czasu
SELECT DATE_ADD(data, INTERVAL 30 DAY) FROM zamowienia;   -- + 30 dni
SELECT DATE_SUB(data, INTERVAL 1 YEAR) FROM zamowienia;   -- - 1 rok
```

### Typowe zapytania z datami
```sql
-- Zamowienia z biezacego roku
SELECT * FROM zamowienia WHERE YEAR(data) = YEAR(CURDATE());

-- Zamowienia z ostatnich 30 dni
SELECT * FROM zamowienia WHERE data >= DATE_SUB(CURDATE(), INTERVAL 30 DAY);

-- Wiek klientow
SELECT imie, nazwisko,
       TIMESTAMPDIFF(YEAR, data_urodzenia, CURDATE()) AS wiek
FROM klienci
WHERE TIMESTAMPDIFF(YEAR, data_urodzenia, CURDATE()) >= 18;
```

---

## 8. FUNKCJE TEKSTOWE (STRING)

```sql
-- Laczenie tekstow
SELECT CONCAT(imie, ' ', nazwisko) AS pelne_imie FROM klienci;
SELECT CONCAT_WS(', ', miasto, ulica, numer) AS adres FROM adresy;  -- WS = with separator

-- Dlugosc tekstu
SELECT LENGTH('Hello');          -- 5 (bajty)
SELECT CHAR_LENGTH('Hello');     -- 5 (znaki, lepsze dla UTF-8)

-- Zmiana wielkosci liter
SELECT UPPER('hello world');     -- HELLO WORLD
SELECT LOWER('HELLO WORLD');     -- hello world

-- Wycinanie fragmentu
SELECT SUBSTRING('Hello World', 7, 5);  -- World (od poz. 7, 5 znakow)
SELECT LEFT('Hello World', 5);          -- Hello
SELECT RIGHT('Hello World', 5);         -- World

-- Usuwanie spacji
SELECT TRIM('  hello  ');        -- 'hello'
SELECT LTRIM('  hello  ');       -- 'hello  '
SELECT RTRIM('  hello  ');       -- '  hello'

-- Zamiana
SELECT REPLACE('Hello World', 'World', 'MySQL');  -- Hello MySQL

-- Pozycja
SELECT LOCATE('World', 'Hello World');  -- 7

-- Uzupelnianie
SELECT LPAD('5', 3, '0');  -- 005
SELECT RPAD('5', 3, '0');  -- 500
```

---

## 9. CASE WHEN

### CASE WHEN w SELECT
```sql
-- Klasyfikacja produktow wg ceny
SELECT nazwa, cena,
    CASE
        WHEN cena < 50 THEN 'Tani'
        WHEN cena BETWEEN 50 AND 200 THEN 'Sredni'
        WHEN cena > 200 THEN 'Drogi'
        ELSE 'Nieznany'
    END AS kategoria_cenowa
FROM produkty;

-- Z egzaminu (trudnosc potrawy jako tekst)
-- PHP robi to w kodzie, ale mozna tez w SQL:
SELECT nazwa,
    CASE trudnosc
        WHEN 1 THEN 'latwe'
        WHEN 2 THEN 'srednie'
        WHEN 3 THEN 'trudne'
        ELSE 'nieznane'
    END AS poziom_trudnosci
FROM potrawy;

-- CASE w WHERE
SELECT * FROM produkty
WHERE CASE WHEN kategoria_id = 1 THEN cena > 100 ELSE cena > 50 END;
```

---

## 10. PODZAPYTANIA (SUBQUERIES)

### Niekorelowane (wynik niezalezny od zewnetrznego zapytania)
```sql
-- Produkty drozsze niz srednia
SELECT nazwa, cena FROM produkty
WHERE cena > (SELECT AVG(cena) FROM produkty);

-- Klienci z zamowieniami (IN)
SELECT imie, nazwisko FROM klienci
WHERE id IN (SELECT klient_id FROM zamowienia);

-- Klienci BEZ zamowien (NOT IN)
SELECT imie, nazwisko FROM klienci
WHERE id NOT IN (SELECT klient_id FROM zamowienia);

-- Najdrozszy produkt w kazdej kategorii
SELECT * FROM produkty
WHERE cena = (SELECT MAX(cena) FROM produkty p2 WHERE p2.kategoria_id = produkty.kategoria_id);
```

### Podzapytania w FROM (derived tables)
```sql
-- Srednia sprzedaz per miesiac, potem srednia z tych srednich
SELECT AVG(miesiac_suma) AS srednia_miesiacna
FROM (
    SELECT MONTH(data) AS miesiac, SUM(kwota) AS miesiac_suma
    FROM zamowienia
    GROUP BY MONTH(data)
) AS sumy_miesiac;
```

---

## 11. ALTER TABLE

### Dodawanie kolumn
```sql
-- ADD COLUMN
ALTER TABLE produkty ADD COLUMN opis TEXT;
ALTER TABLE produkty ADD COLUMN opis TEXT AFTER nazwa;
ALTER TABLE produkty ADD COLUMN opis TEXT FIRST;
ALTER TABLE produkty ADD COLUMN aktywny TINYINT(1) DEFAULT 1 NOT NULL;
ALTER TABLE produkty ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP;
```

### Modyfikowanie kolumn
```sql
-- MODIFY - zmiana typu/atrybutow kolumny
ALTER TABLE produkty MODIFY COLUMN cena DECIMAL(10, 2) NOT NULL;
ALTER TABLE produkty MODIFY COLUMN nazwa VARCHAR(500);

-- CHANGE - zmiana nazwy + typ
ALTER TABLE produkty CHANGE COLUMN stara_nazwa nowa_nazwa VARCHAR(255);

-- Zmiana samej nazwy (MySQL 8.0+)
ALTER TABLE produkty RENAME COLUMN stara_nazwa TO nowa_nazwa;
```

### Usuwanie kolumn
```sql
ALTER TABLE produkty DROP COLUMN opis;
ALTER TABLE produkty DROP COLUMN opis, DROP COLUMN stary_kod;  -- wiele na raz
```

### Klucze i indeksy
```sql
-- Dodanie klucza obcego
ALTER TABLE produkty
ADD CONSTRAINT fk_kategoria
FOREIGN KEY (kategoria_id) REFERENCES kategorie(id);

-- Dodanie indeksu
ALTER TABLE produkty ADD INDEX idx_nazwa (nazwa);
ALTER TABLE produkty ADD UNIQUE INDEX idx_kod (kod);

-- Usuniecie
ALTER TABLE produkty DROP FOREIGN KEY fk_kategoria;
ALTER TABLE produkty DROP INDEX idx_nazwa;
```

---

## 12. CREATE TABLE

```sql
-- Pelny przyklad z kluczami i ograniczeniami
CREATE TABLE produkty (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nazwa       VARCHAR(255) NOT NULL,
    opis        TEXT,
    cena        DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    ilosc       INT UNSIGNED NOT NULL DEFAULT 0,
    kategoria_id INT NOT NULL,
    aktywny     TINYINT(1) NOT NULL DEFAULT 1,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_kategoria (kategoria_id),
    CONSTRAINT fk_produkt_kategoria
        FOREIGN KEY (kategoria_id)
        REFERENCES kategorie(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

### Typy danych MySQL
| Typ | Opis | Przyklad |
|-----|------|---------|
| `INT` | Liczba calkowita | id, wiek, ilosc |
| `TINYINT(1)` | 0 lub 1 (boolean) | aktywny, widoczny |
| `DECIMAL(10,2)` | Liczba z przecinkiem | cena, podatek |
| `FLOAT` / `DOUBLE` | Zmiennoprzecinkowa | temperatura, waga |
| `VARCHAR(255)` | Krotki tekst | nazwa, email |
| `TEXT` | Dlugi tekst | opis, tresc |
| `DATE` | Data YYYY-MM-DD | data_urodzenia |
| `DATETIME` | Data i czas | data_zamowienia |
| `TIMESTAMP` | Data/czas + auto-update | created_at |
| `ENUM` | Lista wartosci | `ENUM('M','K')` |

---

## 13. INSERT INTO

### Podstawowy INSERT
```sql
-- Z nazwami kolumn (zalecane)
INSERT INTO miejscowosc (kraj, nazwa) VALUES ('Ukraina', 'Kijow');
INSERT INTO produkty (nazwa, cena, kategoria_id) VALUES ('Laptop', 2999.99, 1);

-- Wiele wierszy naraz
INSERT INTO produkty (nazwa, cena, kategoria_id) VALUES
    ('Laptop', 2999.99, 1),
    ('Myszka', 89.99, 2),
    ('Klawiatura', 149.99, 2);
```

### INSERT INTO ... SELECT
```sql
-- Kopiowanie danych z jednej tabeli do drugiej
INSERT INTO archiwum_zamowien (id, klient_id, kwota, data)
SELECT id, klient_id, kwota, data
FROM zamowienia
WHERE YEAR(data) < 2023;

-- Wstawianie z transformacja
INSERT INTO raporty_miesiac (rok, miesiac, suma)
SELECT YEAR(data), MONTH(data), SUM(kwota)
FROM zamowienia
GROUP BY YEAR(data), MONTH(data);
```

---

## 14. UPDATE

### Podstawowy UPDATE
```sql
-- Jeden wiersz (ZAWSZE uzywaj WHERE!)
UPDATE produkty SET cena = 999.99 WHERE id = 1;
UPDATE produkty SET cena = 999.99, nazwa = 'Nowa nazwa' WHERE id = 1;

-- Wiele wierszy
UPDATE produkty SET aktywny = 0 WHERE kategoria_id = 5;

-- Z wyrazeniem
UPDATE produkty SET cena = cena * 1.1;              -- podwyz o 10%
UPDATE produkty SET cena = cena * 0.9 WHERE kategoria_id = 3;  -- rabat 10%
```

### UPDATE z JOIN
```sql
-- Zaktualizuj cene na podstawie danych z innej tabeli
UPDATE produkty
JOIN kategorie ON kategorie.id = produkty.kategoria_id
SET produkty.cena = produkty.cena * kategorie.mnoznik_ceny
WHERE kategorie.id = 3;
```

---

## 15. DELETE

### Podstawowy DELETE
```sql
-- Jeden wiersz (ZAWSZE uzywaj WHERE!)
DELETE FROM produkty WHERE id = 7;

-- Wiele wierszy
DELETE FROM produkty WHERE aktywny = 0;
DELETE FROM zamowienia WHERE YEAR(data) < 2020;
```

### DELETE z JOIN
```sql
-- Usun produkty z nieaktywnych kategorii
DELETE produkty
FROM produkty
JOIN kategorie ON kategorie.id = produkty.kategoria_id
WHERE kategorie.aktywna = 0;
```

### Usuwanie wszystkich danych
```sql
DELETE FROM tabela;            -- powolne, resetuje auto_increment? NIE
TRUNCATE TABLE tabela;         -- szybkie, resetuje auto_increment, nie mozna WHERE
```

---

## 16. SZYBKA SCIAGA - KOLEJNOSC KLAUZUL SQL

```sql
SELECT   -- co wybrac
FROM     -- z jakiej tabeli
JOIN     -- dolacz inne tabele
ON       -- warunek laczenia
WHERE    -- filtruj wiersze (przed GROUP BY)
GROUP BY -- grupuj
HAVING   -- filtruj grupy (po GROUP BY)
ORDER BY -- sortuj
LIMIT    -- ogranicz liczbe wynikow
OFFSET   -- pominij pierwsze N wierszy
```

Pamietaj: **S**elect **F**rom **J**oin **W**here **G**roup **H**aving **O**rder **L**imit
= **SF JW GHOL**

---

## 17. NAJCZESTSZE BLEDY NA EGZAMINIE

```sql
-- BLAD 1: Brak WHERE w UPDATE/DELETE
UPDATE produkty SET cena = 0;    -- ZLE! Zmienia WSZYSTKIE produkty!
UPDATE produkty SET cena = 0 WHERE id = 5;  -- DOBRZE

-- BLAD 2: Niejednoznaczna kolumna (bez nazwy tabeli)
SELECT nazwa FROM produkty JOIN kategorie ON ...;
-- ZLE jesli obie tabele maja kolumne 'nazwa'!
SELECT produkty.nazwa, kategorie.nazwa AS kat FROM produkty JOIN kategorie ON ...;

-- BLAD 3: SELECT w GROUP BY - kolumny spoza agregacji
SELECT nazwa, kategoria_id, AVG(cena)   -- ZLE! 'nazwa' nie jest w GROUP BY
FROM produkty GROUP BY kategoria_id;

SELECT kategoria_id, AVG(cena)          -- DOBRZE
FROM produkty GROUP BY kategoria_id;

-- BLAD 4: WHERE zamiast HAVING dla agregatow
SELECT kategoria_id, AVG(cena) FROM produkty
WHERE AVG(cena) > 100             -- ZLE! Aggregate w WHERE
GROUP BY kategoria_id;

SELECT kategoria_id, AVG(cena) FROM produkty
GROUP BY kategoria_id
HAVING AVG(cena) > 100;           -- DOBRZE!

-- BLAD 5: Bledna kolejnosc ON klucze w JOIN
-- Zawsze: JOIN tabelaB ON tabelaB.klucz_obcy = tabelaA.klucz_glowny
JOIN pomiary ON pomiary.id_miejscowosc = miejscowosc.id   -- DOBRZE (jak w egzaminie)

-- BLAD 6: Apostrof zamiast cudzyslow w wartosciach
WHERE nazwa = "Laptop"   -- dziala w MySQL ale lepiej:
WHERE nazwa = 'Laptop'   -- standard SQL
```

---

*Opracowanie do egzaminu INF.03 - SQL Zaawansowany (INF.03.4)*
*Na podstawie analizy kwerendy z egzaminow 2024-2026*
