# TEST: SQL — Pytania Egzaminacyjne (INF.03.4)

> **25 pytań SQL** — poziom egzaminu INF.03. Odpowiedzi na końcu każdego pytania.

---

## SCHEMAT BAZ DANYCH DO TESTÓW

### Baza `przepisy`
```sql
rodzaje(idRodzaje PK, rodzaj)
potrawy(idPotrawy PK, nazwa, opis, czas_przygotowania, idRodzaje FK)
skladniki(idSkladniki PK, skladnik, jednostka)
potrawy_skladniki(idPotrawy FK, idSkladniki FK, ilosc)
```

### Baza `pogoda`
```sql
wojewodztwa(idWojewodztwo PK, wojewodztwo)
miasta(idMiasto PK, miasto, idWojewodztwo FK)
miesiace(idMiesiace PK, miesiac, numer_miesiaca)
pomiary(idPomiary PK, temperatura, cisnienie, wilgotnosc, idMiasto FK, idMiesiace FK)
```

---

## CZĘŚĆ 1: DDL — Definicja Danych (5 pytań)

### Pytanie 1
Które polecenie SQL tworzy nową tabelę?

- A) `INSERT TABLE potrawy (...)`
- B) `CREATE TABLE potrawy (...)`
- C) `ADD TABLE potrawy (...)`
- D) `MAKE TABLE potrawy (...)`

**Odpowiedź: B** — `CREATE TABLE` to polecenie DDL (Data Definition Language) do tworzenia tabel.

---

### Pytanie 2
Które polecenie dodaje nową kolumnę `zdjecie VARCHAR(200)` do istniejącej tabeli `potrawy`?

- A) `UPDATE TABLE potrawy ADD zdjecie VARCHAR(200);`
- B) `INSERT INTO potrawy (zdjecie) VARCHAR(200);`
- C) `ALTER TABLE potrawy ADD zdjecie VARCHAR(200);`
- D) `MODIFY TABLE potrawy ADD COLUMN zdjecie VARCHAR(200);`

**Odpowiedź: C** — `ALTER TABLE ... ADD` to poprawna składnia DDL.

---

### Pytanie 3
Co oznacza `AUTO_INCREMENT` w definicji kolumny MySQL?

- A) Kolumna automatycznie się powiększa przy każdym SELECT
- B) Wartość kolumny automatycznie rośnie o 1 przy każdym INSERT
- C) Kolumna automatycznie sumuje wartości
- D) Kolumna automatycznie się indeksuje

**Odpowiedź: B** — `AUTO_INCREMENT` generuje unikalne liczby całkowite rosnące o 1. Używane najczęściej z PRIMARY KEY.

---

### Pytanie 4
Które polecenie usuwa całą tabelę wraz ze strukturą i danymi?

- A) `DELETE TABLE potrawy;`
- B) `REMOVE TABLE potrawy;`
- C) `TRUNCATE potrawy;`
- D) `DROP TABLE potrawy;`

**Odpowiedź: D** — `DROP TABLE` usuwa tabelę wraz ze strukturą. `TRUNCATE` usuwa tylko dane, zostawiając strukturę. `DELETE` usuwa wiersze (z możliwością filtrowania WHERE).

---

### Pytanie 5
Które typy danych MySQL mogą przechowywać tekst? (wybierz najlepszą odpowiedź)

- A) `INT`, `FLOAT`, `DECIMAL`
- B) `VARCHAR`, `TEXT`, `CHAR`
- C) `DATE`, `DATETIME`, `TIMESTAMP`
- D) `BLOB`, `BINARY`, `VARBINARY`

**Odpowiedź: B** — `VARCHAR(n)`, `TEXT`, `CHAR(n)` przechowują tekst. `BLOB` przechowuje dane binarne (np. zdjęcia jako bajty).

---

## CZĘŚĆ 2: DML — Manipulacja Danymi (5 pytań)

### Pytanie 6
Które zapytanie pobiera wszystkie potrawy których czas przygotowania jest mniejszy niż 30 minut?

- A) `SELECT * FROM potrawy WHERE czas_przygotowania < 30;`
- B) `GET * FROM potrawy IF czas_przygotowania < 30;`
- C) `SELECT * FROM potrawy HAVING czas_przygotowania < 30;`
- D) `FETCH * FROM potrawy WHERE czas_przygotowania < 30;`

**Odpowiedź: A** — Poprawna składnia SELECT z klauzulą WHERE.

---

### Pytanie 7
Które zapytanie wstawia nowy rekord do tabeli `rodzaje`?

- A) `ADD INTO rodzaje (rodzaj) VALUES ('Zupy');`
- B) `INSERT rodzaje SET rodzaj = 'Zupy';`
- C) `INSERT INTO rodzaje (rodzaj) VALUES ('Zupy');`
- D) `PUT INTO rodzaje (rodzaj) VALUES ('Zupy');`

**Odpowiedź: C** — Poprawna składnia INSERT INTO ... VALUES.

---

### Pytanie 8
Które zapytanie aktualizuje nazwę potrawy o `idPotrawy = 5`?

- A) `CHANGE potrawy SET nazwa = 'Bigos' WHERE idPotrawy = 5;`
- B) `UPDATE potrawy SET nazwa = 'Bigos' WHERE idPotrawy = 5;`
- C) `MODIFY potrawy SET nazwa = 'Bigos' WHERE idPotrawy = 5;`
- D) `UPDATE potrawy WHERE idPotrawy = 5 SET nazwa = 'Bigos';`

**Odpowiedź: B** — Poprawna składnia UPDATE ... SET ... WHERE.

---

### Pytanie 9
Co zwróci zapytanie `SELECT COUNT(*) FROM potrawy;`?

- A) Wszystkie rekordy z tabeli potrawy
- B) Liczbę kolumn w tabeli potrawy
- C) Liczbę rekordów (wierszy) w tabeli potrawy
- D) Sumę wartości kolumny potrawy

**Odpowiedź: C** — `COUNT(*)` zlicza wszystkie wiersze w tabeli.

---

### Pytanie 10
Które zapytanie wyświetla 5 pierwszych potraw posortowanych alfabetycznie po nazwie?

- A) `SELECT * FROM potrawy ORDER BY nazwa LIMIT 5;`
- B) `SELECT TOP 5 * FROM potrawy ORDER BY nazwa;`
- C) `SELECT * FROM potrawy SORT BY nazwa FETCH 5;`
- D) `SELECT FIRST 5 * FROM potrawy ORDER BY nazwa;`

**Odpowiedź: A** — MySQL używa `LIMIT n`. `TOP n` to składnia SQL Server. `FETCH FIRST` to składnia Oracle/PostgreSQL.

---

## CZĘŚĆ 3: JOINy (5 pytań)

### Pytanie 11
Co zwraca `INNER JOIN` (lub po prostu `JOIN`)?

- A) Wszystkie wiersze z lewej tabeli + pasujące z prawej
- B) Wszystkie wiersze z obu tabel
- C) Tylko wiersze które mają pasujące wartości w obu tabelach
- D) Wiersze z lewej tabeli których nie ma w prawej

**Odpowiedź: C** — `INNER JOIN` zwraca tylko wiersze ze zgodną wartością klucza w obu tabelach.

---

### Pytanie 12
Które zapytanie wyświetla potrawy z ich rodzajami (łącząc tabele)?

- A) `SELECT potrawy.nazwa, rodzaje.rodzaj FROM potrawy, rodzaje;`
- B) `SELECT potrawy.nazwa, rodzaje.rodzaj FROM potrawy JOIN rodzaje ON rodzaje.idRodzaje = potrawy.idRodzaje;`
- C) `SELECT potrawy.nazwa, rodzaje.rodzaj FROM potrawy CONNECT rodzaje ON rodzaje.idRodzaje = potrawy.idRodzaje;`
- D) `SELECT potrawy.nazwa, rodzaje.rodzaj FROM potrawy INNER rodzaje WHERE rodzaje.idRodzaje = potrawy.idRodzaje;`

**Odpowiedź: B** — Poprawna składnia JOIN z klauzulą ON określającą klucz łączenia.

---

### Pytanie 13
Co zwraca `LEFT JOIN` gdy dla wiersza z lewej tabeli nie ma pasującego wiersza w prawej?

- A) Wiersz jest pomijany
- B) Wiersz z lewej tabeli z wartościami NULL dla kolumn prawej tabeli
- C) Wiersz z prawej tabeli z wartościami NULL dla kolumn lewej tabeli
- D) Błąd SQL

**Odpowiedź: B** — `LEFT JOIN` zawsze zwraca wszystkie wiersze z lewej tabeli. Dla brakujących dopasowań wartości z prawej tabeli są `NULL`.

---

### Pytanie 14
Które zapytanie łączy 3 tabele: pomiary → miasta → województwa?

- A) `SELECT p.temperatura, m.miasto, w.wojewodztwo FROM pomiary p JOIN miasta m JOIN wojewodztwa w;`
- B) `SELECT p.temperatura, m.miasto, w.wojewodztwo FROM pomiary p JOIN miasta m ON m.idMiasto = p.idMiasto JOIN wojewodztwa w ON w.idWojewodztwo = m.idWojewodztwo;`
- C) `SELECT p.temperatura, m.miasto, w.wojewodztwo FROM pomiary p, miasta m, wojewodztwa w WHERE m.idMiasto = p.idMiasto AND w.idWojewodztwo = m.idWojewodztwo;`
- D) Odpowiedź B i C są poprawne

**Odpowiedź: D** — Oba zapytania (B i C) są poprawne, choć składnia B z JOIN...ON jest nowocześniejsza i czytelniejsza.

---

### Pytanie 15
Które zapytanie wyświetla wszystkie potrawy NAWET TE BEZ składników?

- A) `SELECT p.nazwa, s.skladnik FROM potrawy p INNER JOIN potrawy_skladniki ps ON ps.idPotrawy = p.idPotrawy;`
- B) `SELECT p.nazwa, s.skladnik FROM potrawy p LEFT JOIN potrawy_skladniki ps ON ps.idPotrawy = p.idPotrawy LEFT JOIN skladniki s ON s.idSkladniki = ps.idSkladniki;`
- C) `SELECT p.nazwa, s.skladnik FROM potrawy p RIGHT JOIN skladniki s ON s.idSkladniki = p.idPotrawy;`
- D) `SELECT p.nazwa, s.skladnik FROM potrawy p FULL JOIN skladniki s;`

**Odpowiedź: B** — `LEFT JOIN` z potrawy zapewnia, że wszystkie potrawy są uwzględnione, nawet bez składników (NULL).

---

## CZĘŚĆ 4: GROUP BY i Agregacja (5 pytań)

### Pytanie 16
Co robi klauzula `GROUP BY`?

- A) Sortuje wyniki według podanej kolumny
- B) Grupuje wiersze o tej samej wartości w kolumnie, umożliwiając agregację
- C) Filtruje wiersze przed wyświetleniem
- D) Łączy tabele według podanej kolumny

**Odpowiedź: B** — `GROUP BY` scala wiersze z identyczną wartością kolumny w grupy, co umożliwia użycie funkcji agregujących (COUNT, SUM, AVG, MAX, MIN).

---

### Pytanie 17
Które zapytanie oblicza średnią temperaturę dla każdego miasta?

- A) `SELECT idMiasto, AVERAGE(temperatura) FROM pomiary GROUP BY idMiasto;`
- B) `SELECT idMiasto, AVG(temperatura) FROM pomiary GROUP BY idMiasto;`
- C) `SELECT idMiasto, AVG(temperatura) FROM pomiary ORDER BY idMiasto;`
- D) `SELECT AVG(temperatura) FROM pomiary WHERE GROUP BY idMiasto;`

**Odpowiedź: B** — `AVG()` to poprawna funkcja agregująca. Wymaga `GROUP BY idMiasto`.

---

### Pytanie 18
Jaka jest różnica między `WHERE` a `HAVING`?

- A) `WHERE` działa po GROUP BY, `HAVING` przed
- B) `WHERE` filtruje kolumny, `HAVING` filtruje wiersze
- C) `WHERE` filtruje wiersze PRZED grupowaniem, `HAVING` filtruje grupy PO grupowaniu
- D) Są identyczne, `HAVING` to nowsza wersja `WHERE`

**Odpowiedź: C** — `WHERE` działa na surowych wierszach (przed GROUP BY). `HAVING` filtruje wyniki grup (po GROUP BY). Np. `HAVING AVG(temperatura) > 15` filtruje tylko te miasta których średnia > 15.

---

### Pytanie 19
Co zwraca zapytanie: `SELECT rodzaje.rodzaj, COUNT(*) AS liczba FROM potrawy JOIN rodzaje ON rodzaje.idRodzaje = potrawy.idRodzaje GROUP BY rodzaje.rodzaj;`?

- A) Listę wszystkich potraw z ich rodzajami
- B) Liczbę rodzajów potraw
- C) Dla każdego rodzaju — jego nazwę i liczbę potraw w tym rodzaju
- D) Potrawy posortowane według rodzaju

**Odpowiedź: C** — Zapytanie grupuje po rodzaju i zlicza potrawy w każdej grupie. `AS liczba` nadaje aliasem kolumnie COUNT(*).

---

### Pytanie 20
Które zapytanie wyświetla TYLKO te województwa których średnia temperatura jest wyższa niż 10 stopni?

- A) `SELECT w.wojewodztwo, AVG(p.temperatura) FROM pomiary p JOIN miasta m ON m.idMiasto = p.idMiasto JOIN wojewodztwa w ON w.idWojewodztwo = m.idWojewodztwo GROUP BY w.wojewodztwo WHERE AVG(p.temperatura) > 10;`
- B) `SELECT w.wojewodztwo, AVG(p.temperatura) FROM pomiary p JOIN miasta m ON m.idMiasto = p.idMiasto JOIN wojewodztwa w ON w.idWojewodztwo = m.idWojewodztwo WHERE AVG(p.temperatura) > 10;`
- C) `SELECT w.wojewodztwo, AVG(p.temperatura) FROM pomiary p JOIN miasta m ON m.idMiasto = p.idMiasto JOIN wojewodztwa w ON w.idWojewodztwo = m.idWojewodztwo GROUP BY w.wojewodztwo HAVING AVG(p.temperatura) > 10;`
- D) `SELECT w.wojewodztwo, AVG(p.temperatura) FROM pomiary p JOIN miasta m ON m.idMiasto = p.idMiasto JOIN wojewodztwa w ON w.idWojewodztwo = m.idWojewodztwo HAVING AVG(p.temperatura) > 10;`

**Odpowiedź: C** — Filtrowanie po agregacji wymaga `HAVING`. `WHERE` nie może używać funkcji agregujących.

---

## CZĘŚĆ 5: Wzorce Egzaminacyjne i Zaawansowane (5 pytań)

### Pytanie 21
Które zapytanie odpowiada wzorcowi z egzaminu INF.03 (pobranie potrawy o id=7 z JOIN)?

- A) `SELECT potrawy.nazwa, rodzaje.rodzaj FROM potrawy, rodzaje WHERE idPotrawy = 7;`
- B) `SELECT potrawy.nazwa, rodzaje.rodzaj FROM potrawy JOIN rodzaje ON rodzaje.idRodzaje = potrawy.idRodzaje WHERE potrawy.idPotrawy = 7;`
- C) `SELECT * FROM potrawy WHERE id = 7 JOIN rodzaje;`
- D) `SELECT potrawy.nazwa, rodzaje.rodzaj FROM potrawy CONNECT rodzaje WHERE potrawy.idPotrawy = 7;`

**Odpowiedź: B** — To dokładny wzorzec z egzaminu 2026-01-10. SELECT z JOIN...ON i WHERE po obu klauzulach.

---

### Pytanie 22
Które zapytanie odpowiada wzorcowi z egzaminu INF.03 (średnia z ROUND i GROUP BY)?

- A) `SELECT miasto, AVG(temperatura) FROM pomiary GROUP BY miasto;`
- B) `SELECT m.miasto, ROUND(AVG(p.temperatura), 1) AS srednia FROM pomiary p JOIN miasta m ON m.idMiasto = p.idMiasto GROUP BY m.miasto;`
- C) `SELECT m.miasto, MEAN(p.temperatura) FROM pomiary p JOIN miasta m ON m.idMiasto = p.idMiasto GROUP BY m.miasto;`
- D) `SELECT m.miasto, AVG(ROUND(p.temperatura, 1)) FROM pomiary p JOIN miasta m ON m.idMiasto = p.idMiasto GROUP BY m.miasto;`

**Odpowiedź: B** — Wzorzec z egzaminu 2026-01-07. `ROUND(AVG(...), 1)` zaokrągla do 1 miejsca po przecinku.

---

### Pytanie 23
Co robi klauzula `LIKE '%zupa%'` w SQL?

- A) Szuka dokładnego tekstu "zupa"
- B) Szuka tekstu który zaczyna się od "zupa"
- C) Szuka tekstu który zawiera "zupa" gdziekolwiek
- D) Szuka tekstu który nie zawiera "zupa"

**Odpowiedź: C** — `%` to wildcard pasujący do dowolnej liczby znaków (0 lub więcej). `'%zupa%'` = zawiera "zupa". `'zupa%'` = zaczyna się od "zupa". `'%zupa'` = kończy się na "zupa".

---

### Pytanie 24
Które zapytanie jest podzapytaniem (subquery) zwracającym potrawy droższe od średniej?

- A) `SELECT * FROM potrawy WHERE czas_przygotowania > AVG(czas_przygotowania);`
- B) `SELECT * FROM potrawy WHERE czas_przygotowania > (SELECT AVG(czas_przygotowania) FROM potrawy);`
- C) `SELECT * FROM potrawy HAVING czas_przygotowania > AVG(czas_przygotowania);`
- D) `SELECT * FROM potrawy INNER JOIN (SELECT AVG(czas_przygotowania) FROM potrawy) AS avg_t;`

**Odpowiedź: B** — Podzapytanie w WHERE. Wewnętrzne `SELECT AVG(...)` oblicza średnią, zewnętrzne zapytanie filtruje wiersze powyżej tej średniej.

---

### Pytanie 25
Jaka jest kolejność klauzul w zapytaniu SELECT?

- A) `SELECT → FROM → JOIN → WHERE → GROUP BY → HAVING → ORDER BY → LIMIT`
- B) `FROM → SELECT → WHERE → JOIN → GROUP BY → ORDER BY → HAVING → LIMIT`
- C) `SELECT → WHERE → FROM → JOIN → GROUP BY → HAVING → ORDER BY → LIMIT`
- D) `SELECT → FROM → WHERE → JOIN → GROUP BY → ORDER BY → HAVING → LIMIT`

**Odpowiedź: A** — Mnemotechnika: **S**abała **F**oto **J**ego **W**uje **G**łośno **H**ałasowali **O**grodzie **L**ato

```
SELECT
FROM
JOIN ... ON
WHERE
GROUP BY
HAVING
ORDER BY
LIMIT
```

---

## PODSUMOWANIE WYNIKÓW

| Wynik | Ocena |
|-------|-------|
| 23-25 | Celujący — gotowy na egzamin! |
| 20-22 | Bardzo dobry — powtórz JOINy i GROUP BY |
| 15-19 | Dobry — powtórz składnię SELECT i wzorce |
| 10-14 | Dostateczny — wróć do 01_SQL_BASICS.md |
| 0-9   | Niedostateczny — zacznij od podstaw |

---

**Powodzenia! Wróć do: [02_SQL_ZAAWANSOWANY.md](../SQL/02_SQL_ZAAWANSOWANY.md)**
