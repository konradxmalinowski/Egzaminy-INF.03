# ĆWICZENIA: SQL (INF.03.4)

> 25 zadań z rozwiązaniami opartych na schematach z egzaminów INF.03
> Bazy: `przepisy`, `pogoda`
> Poziom: od SELECT podstawowego do podzapytań i DDL

---

## SCHEMAT BAZ DANYCH

Przed przystąpieniem do ćwiczeń utwórz bazy i tabele:

### Baza `przepisy`

```sql
CREATE DATABASE IF NOT EXISTS przepisy CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci;
USE przepisy;

CREATE TABLE rodzaje (
    idRodzaje INT PRIMARY KEY AUTO_INCREMENT,
    rodzaj    VARCHAR(50) NOT NULL
);

CREATE TABLE potrawy (
    idPotrawy          INT PRIMARY KEY AUTO_INCREMENT,
    nazwa              VARCHAR(100) NOT NULL,
    opis               TEXT,
    czas_przygotowania INT,
    idRodzaje          INT,
    FOREIGN KEY (idRodzaje) REFERENCES rodzaje(idRodzaje)
);

CREATE TABLE skladniki (
    idSkladniki INT PRIMARY KEY AUTO_INCREMENT,
    skladnik    VARCHAR(100) NOT NULL,
    jednostka   VARCHAR(20)
);

CREATE TABLE potrawy_skladniki (
    idPotrawy   INT,
    idSkladniki INT,
    ilosc       DECIMAL(10, 2),
    PRIMARY KEY (idPotrawy, idSkladniki),
    FOREIGN KEY (idPotrawy)   REFERENCES potrawy(idPotrawy),
    FOREIGN KEY (idSkladniki) REFERENCES skladniki(idSkladniki)
);
```

### Dane testowe — baza `przepisy`

```sql
USE przepisy;

INSERT INTO rodzaje (rodzaj) VALUES
    ('Zupy'),
    ('Dania główne'),
    ('Sałatki'),
    ('Desery'),
    ('Śniadania'),
    ('Przekąski');

INSERT INTO potrawy (nazwa, opis, czas_przygotowania, idRodzaje) VALUES
    ('Barszcz czerwony', 'Klasyczny barszcz na bulionie wołowym', 60, 1),
    ('Żurek', 'Tradycyjny żurek z białą kiełbasą i jajkiem', 45, 1),
    ('Kotlet schabowy', 'Panierowany kotlet z schabu wieprzowego', 30, 2),
    ('Pierogi ruskie', 'Pierogi z nadzieniem ziemniaczano-serowym', 90, 2),
    ('Sałatka grecka', 'Sałatka z feta, oliwkami i pomidorami', 15, 3),
    ('Sałatka Cezar', 'Sałatka z kurczakiem i sosem cezar', 20, 3),
    ('Szarlotka', 'Ciasto jabłkowe z kruszonką', 75, 4),
    ('Naleśniki', 'Cienkie naleśniki z dżemem', 25, 5),
    ('Jajecznica', 'Jajecznica na maśle ze szczypiorkiem', 10, 5),
    ('Bruschetta', 'Grzanka z pomidorami i bazylią', 15, 6),
    ('Rosół', 'Rosół z kurczaka z makaronem', 120, 1),
    ('Bigos', 'Tradycyjny bigos myśliwski', 180, 2);

INSERT INTO skladniki (skladnik, jednostka) VALUES
    ('burak ćwikłowy', 'kg'),
    ('bulion wołowy', 'l'),
    ('kwas buraczany', 'ml'),
    ('mąka pszenna', 'kg'),
    ('jajko', 'szt'),
    ('ziemniak', 'kg'),
    ('twaróg', 'kg'),
    ('schab wieprzowy', 'kg'),
    ('bułka tarta', 'g'),
    ('sałata', 'szt'),
    ('pomidor', 'kg'),
    ('ser feta', 'g'),
    ('oliwki czarne', 'g'),
    ('kurczak', 'kg'),
    ('jabłko', 'kg'),
    ('cukier', 'kg'),
    ('masło', 'g'),
    ('szczypiorek', 'pęczek'),
    ('chleb', 'szt'),
    ('kapusta kiszona', 'kg');

INSERT INTO potrawy_skladniki (idPotrawy, idSkladniki, ilosc) VALUES
    (1, 1, 0.5),
    (1, 2, 1.0),
    (1, 3, 200),
    (2, 4, 0.3),
    (2, 5, 2),
    (3, 8, 0.4),
    (3, 4, 0.1),
    (3, 9, 50),
    (3, 5, 1),
    (4, 4, 0.5),
    (4, 5, 2),
    (4, 6, 0.8),
    (4, 7, 0.3),
    (5, 10, 1),
    (5, 11, 0.3),
    (5, 12, 100),
    (5, 13, 50),
    (6, 10, 1),
    (6, 14, 0.3),
    (7, 15, 1.5),
    (7, 16, 0.2),
    (7, 4, 0.3),
    (8, 4, 0.2),
    (8, 5, 3),
    (8, 17, 30),
    (9, 5, 3),
    (9, 17, 20),
    (9, 18, 1),
    (10, 19, 4),
    (10, 11, 0.2),
    (11, 2, 2.0),
    (11, 14, 0.8),
    (12, 20, 1.0);
```

---

### Baza `pogoda`

```sql
CREATE DATABASE IF NOT EXISTS pogoda CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci;
USE pogoda;

CREATE TABLE wojewodztwa (
    idWojewodztwo INT PRIMARY KEY AUTO_INCREMENT,
    wojewodztwo   VARCHAR(50) NOT NULL
);

CREATE TABLE miasta (
    idMiasto      INT PRIMARY KEY AUTO_INCREMENT,
    miasto        VARCHAR(50) NOT NULL,
    idWojewodztwo INT,
    FOREIGN KEY (idWojewodztwo) REFERENCES wojewodztwa(idWojewodztwo)
);

CREATE TABLE miesiace (
    idMiesiace     INT PRIMARY KEY AUTO_INCREMENT,
    miesiac        VARCHAR(20) NOT NULL,
    numer_miesiaca INT
);

CREATE TABLE pomiary (
    idPomiary   INT PRIMARY KEY AUTO_INCREMENT,
    temperatura DECIMAL(5, 2),
    cisnienie   INT,
    wilgotnosc  INT,
    idMiasto    INT,
    idMiesiace  INT,
    FOREIGN KEY (idMiasto)   REFERENCES miasta(idMiasto),
    FOREIGN KEY (idMiesiace) REFERENCES miesiace(idMiesiace)
);
```

### Dane testowe — baza `pogoda`

```sql
USE pogoda;

INSERT INTO wojewodztwa (wojewodztwo) VALUES
    ('Małopolskie'),
    ('Mazowieckie'),
    ('Śląskie'),
    ('Wielkopolskie'),
    ('Pomorskie');

INSERT INTO miasta (miasto, idWojewodztwo) VALUES
    ('Kraków', 1),
    ('Tarnów', 1),
    ('Warszawa', 2),
    ('Radom', 2),
    ('Katowice', 3),
    ('Gliwice', 3),
    ('Poznań', 4),
    ('Kalisz', 4),
    ('Gdańsk', 5),
    ('Gdynia', 5);

INSERT INTO miesiace (miesiac, numer_miesiaca) VALUES
    ('Styczeń', 1), ('Luty', 2), ('Marzec', 3),
    ('Kwiecień', 4), ('Maj', 5), ('Czerwiec', 6),
    ('Lipiec', 7), ('Sierpień', 8), ('Wrzesień', 9),
    ('Październik', 10), ('Listopad', 11), ('Grudzień', 12);

INSERT INTO pomiary (temperatura, cisnienie, wilgotnosc, idMiasto, idMiesiace) VALUES
    (-2.50, 1013, 80, 1, 1), (0.30, 1010, 75, 1, 2), (5.80, 1008, 70, 1, 3),
    (12.40, 1012, 65, 1, 4), (17.60, 1015, 60, 1, 5), (21.30, 1014, 58, 1, 6),
    (23.80, 1011, 62, 1, 7), (23.10, 1012, 63, 1, 8), (17.90, 1016, 67, 1, 9),
    (11.20, 1018, 72, 1, 10), (4.50, 1015, 78, 1, 11), (-1.20, 1017, 82, 1, 12),
    (-3.10, 1011, 82, 3, 1), (0.80, 1009, 78, 3, 2), (6.20, 1007, 72, 3, 3),
    (13.50, 1011, 66, 3, 4), (18.90, 1014, 61, 3, 5), (22.10, 1013, 59, 3, 6),
    (25.30, 1010, 63, 3, 7), (24.70, 1011, 64, 3, 8), (19.10, 1015, 68, 3, 9),
    (12.80, 1017, 73, 3, 10), (5.20, 1014, 79, 3, 11), (-0.50, 1016, 83, 3, 12),
    (8.50, 1014, 75, 5, 6), (19.20, 1013, 62, 5, 7), (10.30, 1015, 69, 7, 5),
    (22.40, 1012, 61, 7, 7), (14.10, 1016, 70, 9, 8), (20.50, 1011, 68, 9, 7);
```

---

## POZIOM 1 — SELECT podstawowy

---

### Zadanie 1: Wyświetl wszystkie potrawy

**Treść:** Wyświetl wszystkie rekordy z tabeli `potrawy`. Pokaż wszystkie kolumny.

**Wskazówka:** Użyj `SELECT *` — gwiazdka wybiera wszystkie kolumny.

**Rozwiązanie:**
```sql
USE przepisy;

SELECT * FROM potrawy;
```

**Wyjaśnienie:**
`SELECT *` pobiera wszystkie kolumny z tabeli `potrawy`. `*` to skrót od "wszystkie kolumny". Na egzaminie często lepiej wymienić kolumny z nazwy (czytelniejszy kod), ale `SELECT *` jest dopuszczalne gdy potrzebujemy wszystkiego.

---

### Zadanie 2: Wyświetl potrawy o czasie przygotowania krótszym niż 30 minut

**Treść:** Wyświetl `idPotrawy`, `nazwa` i `czas_przygotowania` dla potraw, których czas przygotowania jest mniejszy niż 30 minut.

**Wskazówka:** Użyj klauzuli `WHERE` z operatorem `<` (mniejszy niż).

**Rozwiązanie:**
```sql
USE przepisy;

SELECT idPotrawy, nazwa, czas_przygotowania
FROM potrawy
WHERE czas_przygotowania < 30;
```

**Wyjaśnienie:**
`WHERE czas_przygotowania < 30` filtruje wiersze — pozostaną tylko te, gdzie wartość w kolumnie `czas_przygotowania` jest mniejsza niż 30. Operatory porównania w SQL: `=`, `<`, `>`, `<=`, `>=`, `<>` (różne od).

---

### Zadanie 3: Wyświetl składniki posortowane alfabetycznie

**Treść:** Wyświetl `idSkladniki`, `skladnik` i `jednostka` ze wszystkich składników. Posortuj wyniki alfabetycznie według nazwy składnika.

**Wskazówka:** Użyj `ORDER BY` z `ASC` (rosnąco, domyślne). Dla porządku malejącego — `DESC`.

**Rozwiązanie:**
```sql
USE przepisy;

SELECT idSkladniki, skladnik, jednostka
FROM skladniki
ORDER BY skladnik ASC;
```

**Wyjaśnienie:**
`ORDER BY skladnik ASC` sortuje wyniki rosnąco według kolumny `skladnik`. `ASC` (ascending) jest domyślne i można je pominąć. Gdybyśmy chcieli od Z do A: `ORDER BY skladnik DESC`. Można sortować po wielu kolumnach: `ORDER BY kolumna1 ASC, kolumna2 DESC`.

---

### Zadanie 4: Wyświetl 5 pierwszych pomiarów temperatury

**Treść:** Wyświetl `idPomiary` i `temperatura` z tabeli `pomiary`. Pokaż tylko pierwsze 5 rekordów.

**Wskazówka:** Użyj `LIMIT` na końcu zapytania, aby ograniczyć liczbę zwróconych wierszy.

**Rozwiązanie:**
```sql
USE pogoda;

SELECT idPomiary, temperatura
FROM pomiary
LIMIT 5;
```

**Wyjaśnienie:**
`LIMIT 5` ogranicza wynik do maksymalnie 5 wierszy. Można też pominąć wiersze: `LIMIT 10, 5` — pomija pierwsze 10 i zwraca kolejne 5 (strona 2). Przydatne przy paginacji. Na egzaminie: `LIMIT` zawsze na końcu zapytania (za `ORDER BY`, `WHERE`, itp.).

---

### Zadanie 5: Wyświetl unikalne rodzaje potraw

**Treść:** Wyświetl listę unikalnych wartości z kolumny `rodzaj` w tabeli `rodzaje`. Nie pokazuj duplikatów.

**Wskazówka:** Użyj `DISTINCT` zaraz po `SELECT`, aby usunąć powtarzające się wartości.

**Rozwiązanie:**
```sql
USE przepisy;

SELECT DISTINCT rodzaj
FROM rodzaje
ORDER BY rodzaj;
```

**Wyjaśnienie:**
`DISTINCT` eliminuje duplikaty z wyników. W tabeli `rodzaje` każdy rodzaj powinien być unikalny (bo to tabela słownikowa), ale `DISTINCT` jest szczególnie przydatne np. gdy pytamy o unikalne województwa z tabeli `pomiary` (gdzie mogą się powtarzać). Przykład: `SELECT DISTINCT idMiasto FROM pomiary` — pokaże tylko te miasta, dla których istnieją pomiary.

---

## POZIOM 2 — JOIN

---

### Zadanie 6: Wyświetl nazwy potraw z ich rodzajami

**Treść:** Wyświetl `nazwa` potrawy oraz odpowiadający jej `rodzaj`. Użyj złączenia tabel `potrawy` i `rodzaje`.

**Wskazówka:** Klucz obcy `idRodzaje` łączy obie tabele. Użyj `JOIN ... ON ...`.

**Rozwiązanie:**
```sql
USE przepisy;

SELECT p.nazwa, r.rodzaj
FROM potrawy AS p
JOIN rodzaje AS r ON p.idRodzaje = r.idRodzaje
ORDER BY r.rodzaj, p.nazwa;
```

**Wyjaśnienie:**
`JOIN` (czyli `INNER JOIN`) łączy wiersze z dwóch tabel na podstawie warunku `ON`. Tutaj: `p.idRodzaje = r.idRodzaje` — złącz wiersz z `potrawy` z odpowiednim wierszem z `rodzaje`, gdzie wartości `idRodzaje` są równe. Aliasy `AS p` i `AS r` skracają nazwy tabel — zamiast `potrawy.nazwa` piszemy `p.nazwa`.

---

### Zadanie 7: Wyświetl miasto z nazwą województwa

**Treść:** Wyświetl `miasto` i odpowiadające mu `wojewodztwo`. Posortuj po nazwie województwa, a w ramach województwa po nazwie miasta.

**Wskazówka:** Tabele `miasta` i `wojewodztwa` łączy kolumna `idWojewodztwo`.

**Rozwiązanie:**
```sql
USE pogoda;

SELECT m.miasto, w.wojewodztwo
FROM miasta AS m
JOIN wojewodztwa AS w ON m.idWojewodztwo = w.idWojewodztwo
ORDER BY w.wojewodztwo ASC, m.miasto ASC;
```

**Wyjaśnienie:**
Zasada działania taka sama jak w Zadaniu 6 — `JOIN` po kluczu obcym. `ORDER BY w.wojewodztwo ASC, m.miasto ASC` sortuje najpierw według województwa, a gdy województwa są takie same — według nazwy miasta. Wielopoziomowe sortowanie jest bardzo przydatne na egzaminie.

---

### Zadanie 8: Wyświetl pomiary z miastem i miesiącem

**Treść:** Wyświetl `temperatura`, `cisnienie`, `wilgotnosc`, nazwę `miasto` i nazwę `miesiac` dla wszystkich pomiarów. Posortuj według numeru miesiąca.

**Wskazówka:** Tabela `pomiary` ma dwa klucze obce: `idMiasto` i `idMiesiace`. Potrzebujesz dwóch złączeń (`JOIN`).

**Rozwiązanie:**
```sql
USE pogoda;

SELECT p.temperatura,
       p.cisnienie,
       p.wilgotnosc,
       m.miasto,
       mies.miesiac
FROM pomiary AS p
JOIN miasta    AS m    ON p.idMiasto  = m.idMiasto
JOIN miesiace  AS mies ON p.idMiesiace = mies.idMiesiace
ORDER BY mies.numer_miesiaca ASC;
```

**Wyjaśnienie:**
Każdy kolejny `JOIN` dodaje nową tabelę do złączenia. Kolejność: zacznij od tabeli z danymi (`pomiary`), potem dołączaj tabele słownikowe. Aliasy `mies` zamiast `miesiace` — unikamy konfliktu z innymi skrótami. Sortowanie po `numer_miesiaca` (liczba) zamiast `miesiac` (tekst) — inaczej marzec byłby przed lutym (sortowanie alfabetyczne).

---

### Zadanie 9: Wyświetl potrawy z ich składnikami

**Treść:** Wyświetl `nazwa` potrawy, `skladnik` i `ilosc` oraz `jednostka`. Użyj tabeli pośredniej `potrawy_skladniki`.

**Wskazówka:** Potrzebujesz trzech tabel: `potrawy`, `potrawy_skladniki`, `skladniki`. Złącz je przez dwa `JOIN`.

**Rozwiązanie:**
```sql
USE przepisy;

SELECT pot.nazwa         AS potrawa,
       sk.skladnik,
       ps.ilosc,
       sk.jednostka
FROM potrawy AS pot
JOIN potrawy_skladniki AS ps ON pot.idPotrawy   = ps.idPotrawy
JOIN skladniki         AS sk ON ps.idSkladniki  = sk.idSkladniki
ORDER BY pot.nazwa, sk.skladnik;
```

**Wyjaśnienie:**
Tabela `potrawy_skladniki` to tabela pośrednia (asocjacyjna) — realizuje relację wiele-do-wielu między `potrawy` a `skladniki`. Jedna potrawa może mieć wiele składników, jeden składnik może być w wielu potrawach. `AS potrawa` w SELECT tworzy alias dla kolumny w wynikach (ładniejszy nagłówek).

---

### Zadanie 10: Wyświetl pomiary z miastem, województwem i miesiącem (3 JOINy)

**Treść:** Wyświetl `temperatura`, `miasto`, `wojewodztwo` i `miesiac` dla wszystkich pomiarów. Potrzebujesz złączyć 4 tabele.

**Wskazówka:** Łańcuch: `pomiary` → `miasta` → `wojewodztwa` oraz `pomiary` → `miesiace`.

**Rozwiązanie:**
```sql
USE pogoda;

SELECT p.temperatura,
       mia.miasto,
       woj.wojewodztwo,
       mies.miesiac
FROM pomiary AS p
JOIN miasta       AS mia  ON p.idMiasto    = mia.idMiasto
JOIN wojewodztwa  AS woj  ON mia.idWojewodztwo = woj.idWojewodztwo
JOIN miesiace     AS mies ON p.idMiesiace  = mies.idMiesiace
ORDER BY woj.wojewodztwo, mia.miasto, mies.numer_miesiaca;
```

**Wyjaśnienie:**
Można złączyć dowolną liczbę tabel — każdy `JOIN` jest niezależny. Zauważ że `JOIN` na `wojewodztwa` nie jest bezpośrednio z `pomiary` — idzie przez `miasta` (łańcuch: pomiary → miasta → wojewodztwa). Porządkowanie: najpierw woj → miasto → numer miesiąca — wyniki są logicznie pogrupowane.

---

## POZIOM 3 — GROUP BY i agregacja

---

### Zadanie 11: Policz liczbę potraw w każdym rodzaju

**Treść:** Dla każdego rodzaju potrawy wyświetl `rodzaj` i liczbę potraw (`liczba_potraw`). Posortuj malejąco według liczby potraw.

**Wskazówka:** Użyj `GROUP BY` i funkcji agregującej `COUNT()`.

**Rozwiązanie:**
```sql
USE przepisy;

SELECT r.rodzaj,
       COUNT(p.idPotrawy) AS liczba_potraw
FROM rodzaje AS r
LEFT JOIN potrawy AS p ON r.idRodzaje = p.idRodzaje
GROUP BY r.idRodzaje, r.rodzaj
ORDER BY liczba_potraw DESC;
```

**Wyjaśnienie:**
`GROUP BY` grupuje wyniki — wszystkie wiersze z tym samym `rodzaj` tworzą jedną grupę. `COUNT(p.idPotrawy)` zlicza niepuste wartości `idPotrawy` w każdej grupie. Użycie `LEFT JOIN` zamiast zwykłego `JOIN` gwarantuje że zobaczymy też rodzaje bez żadnej potrawy (z liczbą 0). W `GROUP BY` wymieniamy wszystkie kolumny z `SELECT` które NIE są funkcjami agregującymi.

---

### Zadanie 12: Oblicz średnią temperaturę dla każdego miasta

**Treść:** Wyświetl `miasto` i średnią temperaturę (`srednia_temperatura`) zaokrągloną do 2 miejsc po przecinku. Posortuj malejąco według średniej temperatury.

**Wskazówka:** Użyj `AVG()` do obliczenia średniej i `ROUND()` do zaokrąglenia.

**Rozwiązanie:**
```sql
USE pogoda;

SELECT m.miasto,
       ROUND(AVG(p.temperatura), 2) AS srednia_temperatura
FROM pomiary AS p
JOIN miasta AS m ON p.idMiasto = m.idMiasto
GROUP BY m.idMiasto, m.miasto
ORDER BY srednia_temperatura DESC;
```

**Wyjaśnienie:**
`AVG(p.temperatura)` oblicza średnią arytmetyczną wartości w kolumnie `temperatura` dla każdej grupy (każdego miasta). `ROUND(wartosc, 2)` zaokrągla do 2 miejsc po przecinku. Wzorzec `ROUND(AVG(kolumna), N)` jest klasycznym wzorcem egzaminacyjnym — zapamiętaj go!

---

### Zadanie 13: Znajdź maksymalną i minimalną temperaturę

**Treść:** Wyświetl `miasto` oraz jego `max_temperatura` i `min_temperatura` dla wszystkich miast. Posortuj po mieście.

**Wskazówka:** Użyj `MAX()` i `MIN()` jako funkcji agregujących w tym samym zapytaniu.

**Rozwiązanie:**
```sql
USE pogoda;

SELECT m.miasto,
       MAX(p.temperatura) AS max_temperatura,
       MIN(p.temperatura) AS min_temperatura,
       MAX(p.temperatura) - MIN(p.temperatura) AS roznica_temperatur
FROM pomiary AS p
JOIN miasta AS m ON p.idMiasto = m.idMiasto
GROUP BY m.idMiasto, m.miasto
ORDER BY m.miasto ASC;
```

**Wyjaśnienie:**
Możesz użyć wielu funkcji agregujących w jednym zapytaniu. `MAX() - MIN()` oblicza amplitudę temperatury — to dobry przykład na arytmetykę na wynikach funkcji agregujących. Funkcje agregujące w SQL: `COUNT()`, `SUM()`, `AVG()`, `MAX()`, `MIN()`.

---

### Zadanie 14: Policz ile składników ma każda potrawa

**Treść:** Wyświetl `nazwa` potrawy i `liczba_skladnikow`. Posortuj malejąco — potrawy z największą liczbą składników na górze.

**Wskazówka:** Tabela pośrednia `potrawy_skladniki` przechowuje powiązania. Policz wiersze dla każdej potrawy.

**Rozwiązanie:**
```sql
USE przepisy;

SELECT p.nazwa,
       COUNT(ps.idSkladniki) AS liczba_skladnikow
FROM potrawy AS p
JOIN potrawy_skladniki AS ps ON p.idPotrawy = ps.idPotrawy
GROUP BY p.idPotrawy, p.nazwa
ORDER BY liczba_skladnikow DESC;
```

**Wyjaśnienie:**
Grupujemy po `p.idPotrawy` (i `p.nazwa` dla poprawności) — każda potrawa to jedna grupa. `COUNT(ps.idSkladniki)` zlicza rekordy w tabeli `potrawy_skladniki` dla danej potrawy, co odpowiada liczbie składników. Pamiętaj: `COUNT(*)` zlicza wszystkie wiersze w grupie (nawet NULL), `COUNT(kolumna)` pomija NULL.

---

### Zadanie 15: Wyświetl miasta gdzie średnia temperatura > 15 stopni

**Treść:** Wyświetl `miasto` i `srednia_temperatura` (zaokrągloną do 1 miejsca po przecinku) tylko dla miast, gdzie średnia roczna temperatura przekracza 15°C.

**Wskazówka:** Do filtrowania wyników `GROUP BY` używamy `HAVING`, a NIE `WHERE`. `WHERE` filtruje przed grupowaniem, `HAVING` po grupowaniu.

**Rozwiązanie:**
```sql
USE pogoda;

SELECT m.miasto,
       ROUND(AVG(p.temperatura), 1) AS srednia_temperatura
FROM pomiary AS p
JOIN miasta AS m ON p.idMiasto = m.idMiasto
GROUP BY m.idMiasto, m.miasto
HAVING AVG(p.temperatura) > 15
ORDER BY srednia_temperatura DESC;
```

**Wyjaśnienie:**
Kluczowa różnica: `WHERE` działa na pojedyncze wiersze PRZED grupowaniem. `HAVING` działa na grupy PO pogrupowaniu. Zasada: jeśli filtr zawiera funkcję agregującą (`AVG`, `COUNT`, `SUM`, `MAX`, `MIN`) — użyj `HAVING`. Możesz też łączyć: `WHERE` (filtr wierszy) + `GROUP BY` + `HAVING` (filtr grup).

---

## POZIOM 4 — Wzorce egzaminacyjne

---

### Zadanie 16: SELECT z JOIN + WHERE — potrawa o id=7

**Treść:** Wyświetl pełne informacje o potrawie o `idPotrawy = 7`: jej `nazwa`, `opis`, `czas_przygotowania` oraz `rodzaj`. To klasyczny wzorzec z egzaminów — pokaż szczegóły konkretnego rekordu z dołączonymi danymi słownikowymi.

**Wskazówka:** Połącz `JOIN` z `WHERE`. Filtruj po `idPotrawy` z tabeli `potrawy`.

**Rozwiązanie:**
```sql
USE przepisy;

SELECT p.idPotrawy,
       p.nazwa,
       p.opis,
       p.czas_przygotowania,
       r.rodzaj
FROM potrawy  AS p
JOIN rodzaje  AS r ON p.idRodzaje = r.idRodzaje
WHERE p.idPotrawy = 7;
```

**Wyjaśnienie:**
To jest wzorzec "pobierz szczegóły z JOIN" — bardzo typowy na egzaminie. `WHERE p.idPotrawy = 7` ogranicza wynik do jednego wiersza (zakładając że `idPotrawy` jest kluczem głównym). Kolejność klauzul w SELECT: `SELECT` → `FROM` → `JOIN` → `WHERE` → `GROUP BY` → `HAVING` → `ORDER BY` → `LIMIT`.

---

### Zadanie 17: SELECT z ROUND(AVG()) + GROUP BY — wzorzec pogodowy

**Treść:** Dla każdego miesiąca oblicz: `miesiac`, `srednia_temperatura`, `srednie_cisnienie` i `srednia_wilgotnosc`. Zaokrąglij temperaturę do 1 miejsca, ciśnienie do 0, wilgotność do 0. Posortuj według numeru miesiąca.

**Wskazówka:** To rozbudowany wzorzec z kilkoma `ROUND(AVG(...))` — typowy dla zadań z bazy pogodowej.

**Rozwiązanie:**
```sql
USE pogoda;

SELECT mies.miesiac,
       ROUND(AVG(p.temperatura), 1) AS srednia_temperatura,
       ROUND(AVG(p.cisnienie),   0) AS srednie_cisnienie,
       ROUND(AVG(p.wilgotnosc),  0) AS srednia_wilgotnosc
FROM pomiary AS p
JOIN miesiace AS mies ON p.idMiesiace = mies.idMiesiace
GROUP BY mies.idMiesiace, mies.miesiac, mies.numer_miesiaca
ORDER BY mies.numer_miesiaca ASC;
```

**Wyjaśnienie:**
Wzorzec do zapamiętania: `ROUND(AVG(kolumna), N) AS alias` dla każdej mierzonej wartości. Grupujemy po `mies.idMiesiace` (klucz), dodajemy `mies.miesiac` i `mies.numer_miesiaca` do GROUP BY bo je używamy w SELECT/ORDER BY. Sortowanie po `numer_miesiaca` (liczba) = poprawna kolejność miesięcy.

---

### Zadanie 18: INSERT — wstaw nowy rodzaj potrawy

**Treść:** Wstaw do tabeli `rodzaje` nowy rekord z `rodzaj = 'Napoje'`. Sprawdź poprawność wstawienia.

**Wskazówka:** Użyj `INSERT INTO ... VALUES ...`. Kolumnę `idRodzaje` pomiń — jest AUTO_INCREMENT.

**Rozwiązanie:**
```sql
USE przepisy;

-- Wstawienie nowego rekordu
INSERT INTO rodzaje (rodzaj)
VALUES ('Napoje');

-- Sprawdzenie (opcjonalne, ale dobre na egzaminie)
SELECT * FROM rodzaje
ORDER BY idRodzaje;

-- Można też sprawdzić id ostatnio wstawionego rekordu:
SELECT LAST_INSERT_ID();
```

**Wyjaśnienie:**
`INSERT INTO tabela (kolumna1, kolumna2) VALUES (wartosc1, wartosc2)` — wymieniamy kolumny (pomijamy AUTO_INCREMENT) i odpowiadające wartości. Można wstawić wiele wierszy naraz: `VALUES ('Napoje'), ('Koktajle'), ('Soki')`. `LAST_INSERT_ID()` zwraca id ostatnio wstawionego rekordu (przydatne gdy chcemy od razu powiązać z innymi tabelami).

---

### Zadanie 19: ALTER TABLE — dodaj kolumnę do tabeli potrawy

**Treść:** Dodaj do tabeli `potrawy` nową kolumnę `trudnosc` typu `VARCHAR(20)`, która może przyjmować wartości: 'łatwa', 'średnia', 'trudna'. Kolumna ma mieć wartość domyślną `'średnia'`.

**Wskazówka:** Użyj `ALTER TABLE ... ADD COLUMN ...`. Możesz też dodać `DEFAULT`.

**Rozwiązanie:**
```sql
USE przepisy;

-- Dodanie kolumny
ALTER TABLE potrawy
ADD COLUMN trudnosc VARCHAR(20) DEFAULT 'średnia';

-- Sprawdzenie struktury tabeli
DESCRIBE potrawy;
-- lub:
SHOW COLUMNS FROM potrawy;

-- Sprawdzenie czy kolumna ma domyślną wartość:
SELECT idPotrawy, nazwa, trudnosc FROM potrawy LIMIT 5;
```

**Wyjaśnienie:**
`ALTER TABLE` modyfikuje istniejącą tabelę. `ADD COLUMN` dodaje kolumnę. `DEFAULT 'średnia'` oznacza że istniejące rekordy dostaną tę wartość, a nowe rekordy bez podania `trudnosc` też ją dostaną. Inne operacje ALTER: `DROP COLUMN kolumna` (usuń), `MODIFY COLUMN kolumna TYP` (zmień typ), `RENAME TO nowa_nazwa` (zmień nazwę tabeli), `ADD PRIMARY KEY (kolumna)`, `ADD FOREIGN KEY`.

---

### Zadanie 20: UPDATE — zmień opis potrawy o id=1

**Treść:** Zaktualizuj opis potrawy o `idPotrawy = 1`. Zmień `opis` na `'Klasyczny barszcz czerwony na wywarze z warzyw i buraków, podawany z uszkami lub krokietem'` oraz `czas_przygotowania` na `75`.

**Wskazówka:** Użyj `UPDATE ... SET ... WHERE ...`. ZAWSZE używaj `WHERE` przy UPDATE — bez niego zaktualizujesz WSZYSTKIE wiersze!

**Rozwiązanie:**
```sql
USE przepisy;

-- Przed zmianą — sprawdź stan
SELECT idPotrawy, nazwa, opis, czas_przygotowania
FROM potrawy
WHERE idPotrawy = 1;

-- Aktualizacja
UPDATE potrawy
SET opis               = 'Klasyczny barszcz czerwony na wywarze z warzyw i buraków, podawany z uszkami lub krokietem',
    czas_przygotowania = 75
WHERE idPotrawy = 1;

-- Po zmianie — weryfikacja
SELECT idPotrawy, nazwa, opis, czas_przygotowania
FROM potrawy
WHERE idPotrawy = 1;
```

**Wyjaśnienie:**
`UPDATE tabela SET kolumna1 = wartosc1, kolumna2 = wartosc2 WHERE warunek` — można aktualizować wiele kolumn jednocześnie oddzielając przecinkami. KRYTYCZNE: klauzula `WHERE` jest obowiązkowa w praktyce — bez niej zmieniasz KAŻDY wiersz w tabeli! Na egzaminie zawsze sprawdzaj stan przed i po operacji `UPDATE`.

---

## POZIOM 5 — Zaawansowane

---

### Zadanie 21: Podzapytanie — potrawy których czas > średni czas

**Treść:** Wyświetl `nazwa` i `czas_przygotowania` potraw, których czas przygotowania jest dłuższy niż średni czas przygotowania wszystkich potraw. Wyświetl też samą wartość średnią.

**Wskazówka:** Użyj podzapytania (subquery) w klauzuli `WHERE`. Podzapytanie w nawiasach oblicza średnią.

**Rozwiązanie:**
```sql
USE przepisy;

-- Najpierw sprawdź jaka jest średnia (opcjonalnie):
SELECT AVG(czas_przygotowania) AS srednia FROM potrawy;

-- Główne zapytanie z podzapytaniem:
SELECT nazwa,
       czas_przygotowania,
       (SELECT ROUND(AVG(czas_przygotowania), 0) FROM potrawy) AS srednia_wszystkich
FROM potrawy
WHERE czas_przygotowania > (SELECT AVG(czas_przygotowania) FROM potrawy)
ORDER BY czas_przygotowania DESC;
```

**Wyjaśnienie:**
Podzapytanie `(SELECT AVG(czas_przygotowania) FROM potrawy)` jest wykonywane osobno i zwraca jedną wartość (skalar). Główne zapytanie porównuje każdy wiersz z tą wartością. Podzapytania mogą być: w `WHERE`, `HAVING`, `SELECT`, `FROM`. W podzapytaniu w `SELECT` — można wyświetlić wynik agregacji obok każdego wiersza (bez GROUP BY).

---

### Zadanie 22: LEFT JOIN — potrawy bez składników

**Treść:** Wyświetl `nazwa` potraw, które NIE mają żadnych składników przypisanych w tabeli `potrawy_skladniki`.

**Wskazówka:** `LEFT JOIN` zwraca WSZYSTKIE wiersze z lewej tabeli, nawet gdy nie ma dopasowania w prawej. Gdy nie ma dopasowania — wartości z prawej tabeli są NULL. Filtruj po `IS NULL`.

**Rozwiązanie:**
```sql
USE przepisy;

SELECT p.nazwa
FROM potrawy AS p
LEFT JOIN potrawy_skladniki AS ps ON p.idPotrawy = ps.idPotrawy
WHERE ps.idPotrawy IS NULL
ORDER BY p.nazwa;
```

**Wyjaśnienie:**
Wzorzec "znajdź sieroty" (orphan records): `LEFT JOIN` + `WHERE prawa_tabela.klucz IS NULL`. `LEFT JOIN` dołącza wszystkie wiersze z `potrawy`, nawet te bez powiązań w `potrawy_skladniki`. Dla potraw bez składników, `ps.idPotrawy` będzie `NULL`. Dlatego `WHERE ps.idPotrawy IS NULL` zostawia tylko te potrawy. Alternatywa: `WHERE p.idPotrawy NOT IN (SELECT idPotrawy FROM potrawy_skladniki)`.

---

### Zadanie 23: LIKE — składniki zawierające "mąk"

**Treść:** Wyświetl wszystkie składniki, których nazwa zawiera ciąg znaków `'mąk'` (np. mąka pszenna, mąka ziemniaczana). Wyszukiwanie ma być niezależne od pozycji w nazwie.

**Wskazówka:** Operator `LIKE` z `%` (dowolny ciąg znaków). `%mąk%` — mąk może być gdziekolwiek w nazwie.

**Rozwiązanie:**
```sql
USE przepisy;

-- Składniki zawierające 'mąk' gdziekolwiek
SELECT idSkladniki, skladnik, jednostka
FROM skladniki
WHERE skladnik LIKE '%mąk%'
ORDER BY skladnik;

-- Inne wzorce LIKE:
-- WHERE skladnik LIKE 'mąk%'   → zaczyna się od 'mąk'
-- WHERE skladnik LIKE '%mąka'  → kończy się na 'mąka'
-- WHERE skladnik LIKE 'mąk_'   → 'mąk' + dokładnie jeden znak
-- WHERE skladnik NOT LIKE '%mąk%' → NIE zawiera 'mąk'
```

**Wyjaśnienie:**
Operator `LIKE` służy do dopasowywania wzorców tekstowych. Znaki specjalne: `%` — zastępuje dowolną liczbę dowolnych znaków (zero lub więcej), `_` — zastępuje dokładnie jeden dowolny znak. Rozróżnienie wielkości liter zależy od collation bazy. Na MAMP z `utf8mb4_polish_ci` — wyszukiwanie jest case-insensitive (nie rozróżnia wielkości).

---

### Zadanie 24: COUNT(*) z aliasem kolumny

**Treść:** Policz całkowitą liczbę potraw w bazie, liczbę rodzajów, i liczbę składników. Wyświetl wyniki w jednym wierszu z nazwami kolumn: `liczba_potraw`, `liczba_rodzajow`, `liczba_skladnikow`.

**Wskazówka:** Można użyć podzapytań w `SELECT` lub COUNT z kilku tabel jednocześnie.

**Rozwiązanie:**
```sql
USE przepisy;

-- Metoda 1: Podzapytania w SELECT
SELECT
    (SELECT COUNT(*) FROM potrawy)    AS liczba_potraw,
    (SELECT COUNT(*) FROM rodzaje)    AS liczba_rodzajow,
    (SELECT COUNT(*) FROM skladniki)  AS liczba_skladnikow;

-- Metoda 2: Osobne zapytania (jeśli pytanie dotyczy jednej tabeli)
SELECT COUNT(*) AS liczba_potraw FROM potrawy;

-- Metoda 3: COUNT z warunkiem (tylko potrawy szybkie)
SELECT
    COUNT(*)                                     AS wszystkie_potrawy,
    COUNT(CASE WHEN czas_przygotowania < 30 THEN 1 END) AS szybkie_potrawy,
    COUNT(CASE WHEN czas_przygotowania >= 60 THEN 1 END) AS dlugie_potrawy
FROM potrawy;
```

**Wyjaśnienie:**
`COUNT(*)` zlicza wszystkie wiersze (łącznie z NULL). `COUNT(kolumna)` pomija NULL. `AS alias` nadaje nazwę kolumnie w wynikach — niezbędne gdy kolumna jest wynikiem funkcji lub wyrażenia. `CASE WHEN ... THEN ... END` w COUNT pozwala zliczać wiersze spełniające warunek — zaawansowany ale użyteczny wzorzec.

---

### Zadanie 25: CREATE TABLE — stwórz tabelę `opinie` z FK do potrawy

**Treść:** Stwórz tabelę `opinie` w bazie `przepisy`. Tabela ma zawierać: unikalny identyfikator, ocenę (1-5), treść opinii (do 500 znaków), datę dodania (automatycznie ustawioną na bieżący moment), oraz klucz obcy do tabeli `potrawy`.

**Wskazówka:** Użyj `CREATE TABLE`, `AUTO_INCREMENT`, `DEFAULT CURRENT_TIMESTAMP`, `FOREIGN KEY`.

**Rozwiązanie:**
```sql
USE przepisy;

CREATE TABLE opinie (
    idOpinia   INT          NOT NULL AUTO_INCREMENT,
    ocena      TINYINT      NOT NULL,
    tresc      VARCHAR(500),
    data_dodania DATETIME   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    idPotrawy  INT          NOT NULL,

    PRIMARY KEY (idOpinia),
    CONSTRAINT fk_opinia_potrawa
        FOREIGN KEY (idPotrawy) REFERENCES potrawy(idPotrawy)
            ON DELETE CASCADE
            ON UPDATE CASCADE,
    CONSTRAINT chk_ocena CHECK (ocena BETWEEN 1 AND 5)
);

-- Sprawdzenie struktury
DESCRIBE opinie;

-- Wstaw przykładowe opinie (test FK)
INSERT INTO opinie (ocena, tresc, idPotrawy) VALUES
    (5, 'Przepyszny barszcz, dokładnie taki jak u babci!', 1),
    (4, 'Dobry kotlet, ale trochę za dużo bułki tartej.',  3),
    (3, 'Naleśniki były ok, ale nadzienie mogło być lepsze.', 8);

-- Sprawdź
SELECT o.idOpinia, p.nazwa, o.ocena, o.tresc, o.data_dodania
FROM opinie AS o
JOIN potrawy AS p ON o.idPotrawy = p.idPotrawy;
```

**Wyjaśnienie:**
`TINYINT` — liczba całkowita 1-127 (wydajniejsze niż INT dla małych wartości). `DEFAULT CURRENT_TIMESTAMP` — automatycznie wpisuje datę i godzinę wstawienia rekordu (bez potrzeby podawania w INSERT). `CONSTRAINT fk_... FOREIGN KEY` — klucz obcy z nazwanym ograniczeniem (łatwiej usunąć/zmodyfikować). `ON DELETE CASCADE` — gdy usuniesz potrawę, wszystkie jej opinie też znikną. `CHECK (ocena BETWEEN 1 AND 5)` — ograniczenie wartości do zakresu 1-5 (MySQL 8.0+).

---

## PODSUMOWANIE — Wzorce egzaminacyjne SQL

### Kolejność klauzul SELECT (zawsze w tej kolejności!)

```sql
SELECT    kolumny / funkcje agregujące / *
FROM      tabela_glowna AS alias
JOIN      tabela2 AS alias2 ON warunek_zlaczenia
WHERE     filtr_wierszy (przed GROUP BY)
GROUP BY  kolumny_grupowania
HAVING    filtr_grup (po GROUP BY, dla agregacji)
ORDER BY  kolumna ASC|DESC
LIMIT     liczba_wierszy;
```

### Najczęstsze wzorce na egzaminie

```sql
-- 1. Dane z rodzajem (JOIN + ORDER BY)
SELECT p.nazwa, r.rodzaj
FROM potrawy p JOIN rodzaje r ON p.idRodzaje = r.idRodzaje;

-- 2. Średnia zaokrąglona (ROUND + AVG + GROUP BY)
SELECT miasto, ROUND(AVG(temperatura), 2) AS srednia
FROM pomiary p JOIN miasta m ON p.idMiasto = m.idMiasto
GROUP BY m.idMiasto, m.miasto;

-- 3. Filtr agregatu (HAVING)
SELECT miasto, ROUND(AVG(temperatura), 1) AS srednia
FROM pomiary p JOIN miasta m ON p.idMiasto = m.idMiasto
GROUP BY m.idMiasto, m.miasto
HAVING AVG(temperatura) > 15;

-- 4. Wstawienie rekordu (INSERT)
INSERT INTO rodzaje (rodzaj) VALUES ('Napoje');

-- 5. Aktualizacja rekordu (UPDATE z WHERE!)
UPDATE potrawy SET opis = 'nowy opis' WHERE idPotrawy = 1;

-- 6. Usunięcie rekordu (DELETE z WHERE!)
DELETE FROM opinie WHERE idOpinia = 5;

-- 7. Podzapytanie (subquery)
SELECT nazwa FROM potrawy
WHERE czas_przygotowania > (SELECT AVG(czas_przygotowania) FROM potrawy);
```

### Typy danych — przypomnienie

| Typ              | Opis                                  | Przykład użycia           |
|------------------|---------------------------------------|---------------------------|
| `INT`            | Liczba całkowita                      | id, wiek, rok             |
| `TINYINT`        | Mała liczba całkowita (0-255)         | ocena, flaga              |
| `DECIMAL(10, 2)` | Liczba z przecinkiem, precyzyjna      | cena, ilosc, temperatura  |
| `FLOAT` / `DOUBLE` | Liczba zmiennoprzecinkowa           | pomiary naukowe           |
| `VARCHAR(n)`     | Tekst o zmiennej długości (max n)     | imie, nazwa               |
| `TEXT`           | Długi tekst (do 65535 znaków)        | opis, tresc               |
| `DATETIME`       | Data i godzina                        | data_dodania              |
| `DATE`           | Tylko data                            | data_urodzenia            |
| `BOOLEAN`        | Prawda/Fałsz (alias dla TINYINT(1))   | aktywny, widoczny         |

---

*Ćwiczenia: INF.03.4 — Bazy Danych | SQL | Technik Programista | 25 zadań z rozwiązaniami*
