# SCIAGAWKA: DIAGRAMY E-R I NORMALIZACJA BAZ DANYCH (INF.03.4)

---

## 1. PODSTAWOWE POJECIA BAZ DANYCH

| Pojecie | Definicja | Przyklad |
|---------|-----------|---------|
| **Encja (Entity)** | Obiekt rzeczywisty, o ktorym przechowujemy dane | Klient, Produkt, Zamowienie |
| **Atrybut** | Wlasciwosc/cecha encji | imie, nazwisko, cena |
| **Relacja** | Powiaznanie miedzy encjami | Klient SKLADA Zamowienie |
| **Tabela** | Fizyczna reprezentacja encji w RDBMS | Tabela `klienci` |
| **Krotka (wiersz)** | Pojedynczy rekord w tabeli | Konkretny klient Jan Kowalski |
| **Kolumna (pole)** | Konkretny atrybut w tabeli | Kolumna `nazwisko` |
| **Klucz glowny (PK)** | Unikalny identyfikator rekordu | `id_klienta = 1` |
| **Klucz obcy (FK)** | Odwolanie do PK innej tabeli | `id_klienta` w tabeli zamowien |
| **Klucz kandydujacy** | Kazdy atrybut mogacy byc kluczem glownym | `PESEL`, `email`, `nr_dowodu` |
| **Klucz naturalny** | Klucz wynikajacy z dziedziny (PESEL) | PESEL, NIP |
| **Klucz zastepczy (surrogate)** | Sztucznie nadany (auto_increment) | `id INT AUTO_INCREMENT` |
| **Klucz zlozony** | PK zbudowany z kilku kolumn | (`id_produktu`, `id_zamowienia`) |
| **Schemat** | Logiczna struktura bazy danych | - |
| **Integralnosc referencyjna** | FK musi wskazywac na istniejacy PK | - |

---

## 2. TYPY DANYCH MYSQL

### Typy liczbowe

| Typ | Zakres | Rozmiar | Zastosowanie |
|-----|--------|---------|-------------|
| `TINYINT` | -128 do 127 (UNSIGNED: 0-255) | 1 B | Flagi, boolean |
| `SMALLINT` | -32768 do 32767 | 2 B | Male liczby |
| `MEDIUMINT` | -8 388 608 do 8 388 607 | 3 B | - |
| `INT` / `INTEGER` | -2 147 483 648 do 2 147 483 647 | 4 B | ID, liczniki |
| `BIGINT` | -9.2×10^18 do 9.2×10^18 | 8 B | Bardzo duze liczby |
| `FLOAT` | Zmiennoprzecinkowy (4B) | 4 B | Przyblizone wartosci |
| `DOUBLE` | Zmiennoprzecinkowy (8B) | 8 B | Wieksze przyblizone |
| `DECIMAL(M,D)` | Dokladna liczba dziesiętna | M+2 B | Ceny, finanse |

> **EGZAMIN:** Do pieniędzy zawsze uzywamy `DECIMAL(10,2)` - NIE `FLOAT`!

### Typy tekstowe

| Typ | Maks. rozmiar | Opis |
|-----|--------------|------|
| `CHAR(n)` | 255 znakow | Stalej dlugosci, szybszy |
| `VARCHAR(n)` | 65 535 znakow | Zmiennej dlugosci, oszczedza miejsce |
| `TINYTEXT` | 255 znakow | Krotki tekst |
| `TEXT` | 65 535 znakow | Dlugie teksty |
| `MEDIUMTEXT` | 16 MB | Bardzo dlugie teksty |
| `LONGTEXT` | 4 GB | Ogromne teksty |
| `ENUM('a','b')` | 65 535 wartosci | Lista dozwolonych wartosci |
| `SET('a','b')` | 64 wartosci | Zbior wartosci |

### Typy daty i czasu

| Typ | Format | Zakres | Opis |
|-----|--------|--------|------|
| `DATE` | YYYY-MM-DD | 1000-01-01 do 9999-12-31 | Tylko data |
| `TIME` | HH:MM:SS | -838:59:59 do 838:59:59 | Tylko czas |
| `DATETIME` | YYYY-MM-DD HH:MM:SS | 1000 do 9999 | Data i czas |
| `TIMESTAMP` | YYYY-MM-DD HH:MM:SS | 1970 do 2038 | Unix timestamp (UTC) |
| `YEAR` | YYYY | 1901 do 2155 | Rok |

### Typy binarne

| Typ | Opis |
|-----|------|
| `BINARY(n)` | Binarne stalej dlugosci |
| `VARBINARY(n)` | Binarne zmiennej dlugosci |
| `BLOB` | Binary Large OBject - pliki, obrazy |
| `JSON` | Typ JSON (MySQL 5.7+) |

### BOOLEAN w MySQL

```sql
-- MySQL nie ma natywnego BOOLEAN, uzywa TINYINT(1)
BOOLEAN  -- alias dla TINYINT(1)
-- 0 = FALSE, 1 = TRUE

CREATE TABLE uzytkownicy (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aktywny BOOLEAN DEFAULT TRUE,
    email_potwierdzony TINYINT(1) DEFAULT 0
);
```

---

## 3. DIAGRAMY ENCJA-RELACJA (E-R)

### Notacja Chena (oryginalna)

```
KLIENT --------< SKLADA >---------- ZAMOWIENIE
  |                                      |
 [Prostokat =                        [Prostokat =
  encja]                              encja]
  
(atrybut)  -- linie do encji
<relacja>  -- romb = zwiazek
[Encja]    -- prostokatki

Symbole multiplicznosci:
1         po jednej stronie = jeden
M lub N   po drugiej stronie = wiele
```

### Notacja UML (class diagram)

```
+------------------+         +---------------------+
|    Klient        |         |    Zamowienie        |
+------------------+         +---------------------+
| - id: INT (PK)   | 1     N | - id: INT (PK)       |
| - imie: VARCHAR  |-------->| - data: DATETIME     |
| - email: VARCHAR |         | - id_klienta: INT FK |
+------------------+         +---------------------+

Multiplicznosci UML:
1    = dokladnie jeden
0..1 = zero lub jeden
1..* = jeden lub wiele (1:N)
0..* = zero lub wiele
*    = wiele
```

### Notacja Crow's Foot (Kurza Lapka) - NAJCZESCIEJ NA EGZAMINIE

```
Symbole na koncach lini:

||    jedno i tylko jedno (one and only one)
|<   jeden lub wiele (one or many) - "crow's foot"
|o   zero lub jeden (zero or one)
o<   zero lub wiele (zero or many)

Przyklad 1:1:
Osoba ||---|| Paszport

Przyklad 1:N (klient moze miec wiele zamowien):
Klient ||---o< Zamowienie

Przyklad M:N:
Student >o---o< Kurs
```

### Pelny przyklad diagramu E-R (sklep internetowy)

```
+------------+     +---------------+     +-----------+
|  KLIENT    |     |   ZAMOWIENIE  |     |  PRODUKT  |
+------------+     +---------------+     +-----------+
| PK id      |1   N| PK id         |M   N| PK id     |
| imie       |-----| FK id_klienta |-----| nazwa     |
| nazwisko   |     | data          |     | cena      |
| email      |     | status        |     | FK id_kat |
| telefon    |     | suma          |     +-----------+
+------------+     +---------------+            |
                          |                     |1
                          | (tabela posrednia)  |
                   +------------------+   +----------+
                   | ZAMOWIENIE_PROD  |   | KATEGORIA|
                   +------------------+   +----------+
                   | FK id_zamowienia |   | PK id    |
                   | FK id_produktu   |   | nazwa    |
                   | ilosc            |   | opis     |
                   | cena_jedn        |   +----------+
                   +------------------+
```

---

## 4. TYPY RELACJI - SZCZEGOLOWO

### Relacja 1:1 (jeden do jednego)

**Opis:** Jeden rekord w tabeli A odpowiada dokladnie jednemu rekordowi w tabeli B.
**Przyklad:** Osoba - Paszport, Pracownik - Samochod_sluzbowy

```sql
CREATE TABLE osoby (
    id INT AUTO_INCREMENT PRIMARY KEY,
    imie VARCHAR(50) NOT NULL,
    nazwisko VARCHAR(50) NOT NULL
);

CREATE TABLE paszporty (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numer VARCHAR(20) UNIQUE NOT NULL,
    data_waznosci DATE,
    id_osoby INT UNIQUE,                    -- UNIQUE = relacja 1:1
    FOREIGN KEY (id_osoby) REFERENCES osoby(id) ON DELETE SET NULL
);

-- Zapytanie laczace:
SELECT o.imie, o.nazwisko, p.numer
FROM osoby o
LEFT JOIN paszporty p ON o.id = p.id_osoby;
```

### Relacja 1:N (jeden do wielu)

**Opis:** Jeden rekord w tabeli A odpowiada wielu rekordom w tabeli B.
**Przyklad:** Klient - Zamowienia, Kategoria - Produkty, Autor - Ksiazki

```sql
CREATE TABLE klienci (
    id INT AUTO_INCREMENT PRIMARY KEY,
    imie VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE zamowienia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('nowe','w_realizacji','zrealizowane','anulowane') DEFAULT 'nowe',
    id_klienta INT NOT NULL,
    FOREIGN KEY (id_klienta) REFERENCES klienci(id) ON DELETE RESTRICT
);

-- Klient moze miec wiele zamowien:
-- klienci.id (1) -----< zamowienia.id_klienta (N)

SELECT k.imie, COUNT(z.id) AS liczba_zamowien
FROM klienci k
LEFT JOIN zamowienia z ON k.id = z.id_klienta
GROUP BY k.id;
```

### Relacja M:N (wiele do wielu)

**Opis:** Wiele rekordow z tabeli A odpowiada wielu rekordom z tabeli B.
**Przyklad:** Studenci - Kursy, Produkty - Zamowienia, Aktorzy - Filmy

**Implementacja zawsze wymaga tabeli posredniej (junction table / tabela laczaca)!**

```sql
CREATE TABLE studenci (
    id INT AUTO_INCREMENT PRIMARY KEY,
    imie VARCHAR(50) NOT NULL,
    indeks VARCHAR(10) UNIQUE NOT NULL
);

CREATE TABLE kursy (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nazwa VARCHAR(100) NOT NULL,
    ects TINYINT
);

-- Tabela posrednia (junction table):
CREATE TABLE zapisy (
    id_studenta INT,
    id_kursu INT,
    data_zapisu DATE DEFAULT (CURRENT_DATE),
    ocena DECIMAL(3,1),
    PRIMARY KEY (id_studenta, id_kursu),        -- klucz zlozony
    FOREIGN KEY (id_studenta) REFERENCES studenci(id) ON DELETE CASCADE,
    FOREIGN KEY (id_kursu) REFERENCES kursy(id) ON DELETE CASCADE
);

-- Zapytanie: studenci na kursie "Bazy danych":
SELECT s.imie, s.indeks, z.ocena
FROM studenci s
JOIN zapisy z ON s.id = z.id_studenta
JOIN kursy k ON z.id_kursu = k.id
WHERE k.nazwa = 'Bazy danych';
```

---

## 5. KLUCZE OBCE - OPCJE ON DELETE i ON UPDATE

```sql
FOREIGN KEY (kolumna) REFERENCES tabela(id)
    ON DELETE {opcja}
    ON UPDATE {opcja}
```

| Opcja | ON DELETE | ON UPDATE |
|-------|-----------|-----------|
| `RESTRICT` | Blokuje usunięcie rodzica jesli ma dzieci | Blokuje zmiane PK |
| `NO ACTION` | Jak RESTRICT (sprawdzany po transakcji) | Jak RESTRICT |
| `CASCADE` | Usunięcie rodzica usuwa tez dzieci | Zmiana PK propaguje do FK |
| `SET NULL` | Ustawia FK na NULL (musi byc nullable) | Ustawia FK na NULL |
| `SET DEFAULT` | Ustawia FK na domyslna wartosc | Ustawia FK na default |

### Przyklady uzycia

```sql
-- CASCADE: usuniecie klienta usuwa jego zamowienia
FOREIGN KEY (id_klienta) REFERENCES klienci(id) ON DELETE CASCADE

-- SET NULL: usuniecie kategorii nie usuwa produktow, tylko zeruje id_kategorii
FOREIGN KEY (id_kategorii) REFERENCES kategorie(id) ON DELETE SET NULL

-- RESTRICT (domyslne): nie mozna usunac klienta jesli ma zamowienia
FOREIGN KEY (id_klienta) REFERENCES klienci(id) ON DELETE RESTRICT
```

---

## 6. NORMALIZACJA BAZ DANYCH

**Cel normalizacji:** Eliminacja nadmiarowosci danych i anomalii (wstawiania, aktualizacji, usuwania).

### Anomalie w nienormalizowanej bazie

| Anomalia | Opis | Przyklad |
|----------|------|---------|
| **Wstawiania** | Nie mozna dodac danych bez innych | Nie mozna dodac kursu bez studenta |
| **Aktualizacji** | Zmiana danych wymaga aktualizacji wielu wierszy | Zmiana nazwy kursu w 100 wierszach |
| **Usuwania** | Usuniecie danych powoduje utrate innych | Usuniecie studenta usuwa info o kursie |

---

### 1NF - Pierwsza Postac Normalna (1st Normal Form)

**Kryterium:** Kazda komorka zawiera atomiczna (niepodzielna) wartosc.

**Reguly 1NF:**
- Brak powielanych kolumn (kurs1, kurs2, kurs3 - ZLE)
- Kazda komorka = jedna wartosc (nie lista wartosci)
- Kazdy wiersz jest unikalny (istnieje klucz glowny)
- Kolejnosc wierszy i kolumn nie ma znaczenia

#### PRZED normalizacja (naruszenie 1NF):

| id_studenta | imie | kursy |
|-------------|------|-------|
| 1 | Anna | Matematyka, Fizyka, Chemia |
| 2 | Piotr | Matematyka, Informatyka |

**Problemy:**
- Kolumna `kursy` zawiera wiele wartosci (liste)

#### PO normalizacji do 1NF:

| id_studenta | imie | kurs |
|-------------|------|------|
| 1 | Anna | Matematyka |
| 1 | Anna | Fizyka |
| 1 | Anna | Chemia |
| 2 | Piotr | Matematyka |
| 2 | Piotr | Informatyka |

**Teraz kazda komorka jest atomiczna.** Ale mamy nadmiarowosc (imie powtarza sie).

---

### 2NF - Druga Postac Normalna (2nd Normal Form)

**Kryterium:** Jest w 1NF + kazdy atrybut niekluczowy jest w pelni zalezy od CALEGO klucza glownego.

**Dotyczy tylko tabel z kluczem zlozonym!**

**Reguly 2NF:**
- Spelnione warunki 1NF
- Brak czesciowych zaleznosci funkcyjnych (atrybut zalezy od CZESCI klucza)

#### PRZED normalizacja (naruszenie 2NF):

Tabela `zapisy`:

| id_studenta (PK) | id_kursu (PK) | imie_studenta | nazwa_kursu | ocena |
|------------------|---------------|---------------|-------------|-------|
| 1 | 10 | Anna | Matematyka | 5.0 |
| 1 | 11 | Anna | Fizyka | 4.0 |
| 2 | 10 | Piotr | Matematyka | 3.5 |

**Problem:** `imie_studenta` zalezy tylko od `id_studenta` (nie od calego PK).
`nazwa_kursu` zalezy tylko od `id_kursu`.

#### PO normalizacji do 2NF:

Tabela `studenci`:

| id_studenta (PK) | imie |
|------------------|------|
| 1 | Anna |
| 2 | Piotr |

Tabela `kursy`:

| id_kursu (PK) | nazwa |
|---------------|-------|
| 10 | Matematyka |
| 11 | Fizyka |

Tabela `zapisy`:

| id_studenta (PK, FK) | id_kursu (PK, FK) | ocena |
|----------------------|-------------------|-------|
| 1 | 10 | 5.0 |
| 1 | 11 | 4.0 |
| 2 | 10 | 3.5 |

---

### 3NF - Trzecia Postac Normalna (3rd Normal Form)

**Kryterium:** Jest w 2NF + brak tranzytywnych zaleznosci funkcyjnych.

**Zaleznosc tranzytywna:** A → B → C (C zalezy od B, a B zalezy od A - nie od PK bezposrednio)

#### PRZED normalizacja (naruszenie 3NF):

Tabela `pracownicy`:

| id_prac (PK) | imie | id_dzialu | nazwa_dzialu | tel_dzialu |
|--------------|------|-----------|--------------|------------|
| 1 | Anna | 3 | Ksiegowosc | 555-001 |
| 2 | Piotr | 3 | Ksiegowosc | 555-001 |
| 3 | Maria | 1 | IT | 555-002 |

**Problem:** `nazwa_dzialu` i `tel_dzialu` zaleza od `id_dzialu` (nie od `id_prac`).
Zaleznosc: `id_prac` → `id_dzialu` → `nazwa_dzialu` (tranzytywna!)

#### PO normalizacji do 3NF:

Tabela `pracownicy`:

| id_prac (PK) | imie | id_dzialu (FK) |
|--------------|------|----------------|
| 1 | Anna | 3 |
| 2 | Piotr | 3 |
| 3 | Maria | 1 |

Tabela `dzialy`:

| id_dzialu (PK) | nazwa | telefon |
|----------------|-------|---------|
| 1 | IT | 555-002 |
| 3 | Ksiegowosc | 555-001 |

---

### BCNF - Postac Normalna Boyce'a-Codda (3.5NF)

**Kryterium:** Jest w 3NF + dla kazdej zaleznosci funkcyjnej X → Y, X jest superkluczem.

**BCNF jest silniejsza od 3NF** - eliminuje anomalie w tabelach z kilkoma kandydujacymi kluczami.

#### Kiedy 3NF != BCNF (rzadki przypadek):

Tabela `egzaminy` (student moze byc egzaminowany przez wielu prowadzacych, ale z jednego przedmiotu jeden prowadzacy):

| student (PK) | przedmiot (PK) | prowadzacy |
|--------------|----------------|------------|
| Anna | Matematyka | Prof. Nowak |
| Anna | Fizyka | Dr. Kowal |
| Piotr | Matematyka | Prof. Nowak |

Zaleznosci:
- (student, przedmiot) → prowadzacy (OK)
- prowadzacy → przedmiot (prowadzacy prowadzi tylko jeden przedmiot!)

Naruszenie BCNF: `prowadzacy → przedmiot`, ale `prowadzacy` nie jest superkluczem.

---

### Podsumowanie postaci normalnych

| Postac | Kryterium kluczowe | Co eliminuje |
|--------|-------------------|-------------|
| **1NF** | Atomicznosc wartosci, unikalny PK | Grupy powtarzajace sie, listy w komorkach |
| **2NF** | 1NF + brak czesciowych zaleznosci | Zaleznosci od czesci klucza zlozonego |
| **3NF** | 2NF + brak zaleznosci tranzytywnych | Zaleznosci X → Y → Z |
| **BCNF** | 3NF + kazda lewa strona to superklucz | Anomalie w kluczach kandydujacych |

---

## 7. DENORMALIZACJA

**Denormalizacja** = swiadome wprowadzenie nadmiarowosci dla poprawy wydajnosci.

### Kiedy stosowac denormalizacje?

- System read-heavy (duzo odczytow, malo zapisow)
- Zapytania z wieloma JOIN sa zbyt wolne
- Raportowanie i hurtownie danych (OLAP)
- Dane historyczne (snapshotted prices)

### Techniki denormalizacji

```sql
-- 1. Przechowywanie obliczonej wartosci
ALTER TABLE zamowienia ADD COLUMN suma_zamowienia DECIMAL(10,2);
-- Trzeba recznie aktualizowac przy każdej zmianie!

-- 2. Kopiowanie atrybutu z innej tabeli
ALTER TABLE zamowienia ADD COLUMN imie_klienta VARCHAR(100);
-- Historyczna cena produktu w chwili zamowienia:
ALTER TABLE pozycje_zamowienia ADD COLUMN cena_w_chwili_zakupu DECIMAL(10,2);

-- 3. Tabela agregacyjna (materialized view)
CREATE TABLE statystyki_sprzedazy (
    rok YEAR,
    miesiac TINYINT,
    liczba_zamowien INT,
    laczna_sprzedaz DECIMAL(12,2),
    PRIMARY KEY (rok, miesiac)
);
```

### Zalety vs Wady denormalizacji

| Zalety | Wady |
|--------|------|
| Szybsze zapytania SELECT | Trudniejsza aktualizacja danych |
| Mniej JOIN | Ryzyko niespojnosci danych |
| Prostsze zapytania | Wiecej miejsca na dysku |
| Lepsza wydajnosc raportow | Trudniejsze utrzymanie |

---

## 8. PELNY PRZYKLAD SQL - BAZA SKLEPU (3NF)

```sql
-- Tworzenie bazy danych
CREATE DATABASE sklep
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE sklep;

-- Tabela kategorii
CREATE TABLE kategorie (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nazwa VARCHAR(100) NOT NULL,
    opis TEXT
);

-- Tabela klientow
CREATE TABLE klienci (
    id INT AUTO_INCREMENT PRIMARY KEY,
    imie VARCHAR(50) NOT NULL,
    nazwisko VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telefon VARCHAR(15),
    data_rejestracji DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabela produktow (FK do kategorii)
CREATE TABLE produkty (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nazwa VARCHAR(200) NOT NULL,
    opis TEXT,
    cena DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    id_kategorii INT,
    FOREIGN KEY (id_kategorii) REFERENCES kategorie(id) ON DELETE SET NULL
);

-- Tabela zamowien (FK do klientow)
CREATE TABLE zamowienia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_klienta INT NOT NULL,
    data DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('nowe','platnosc','wysylka','zrealizowane','anulowane') DEFAULT 'nowe',
    adres_dostawy VARCHAR(255),
    FOREIGN KEY (id_klienta) REFERENCES klienci(id) ON DELETE RESTRICT
);

-- Tabela posrednia zamowienia-produkty (M:N)
CREATE TABLE pozycje_zamowienia (
    id_zamowienia INT,
    id_produktu INT,
    ilosc INT NOT NULL DEFAULT 1,
    cena_jednostkowa DECIMAL(10,2) NOT NULL,    -- denormalizacja: historyczna cena!
    PRIMARY KEY (id_zamowienia, id_produktu),
    FOREIGN KEY (id_zamowienia) REFERENCES zamowienia(id) ON DELETE CASCADE,
    FOREIGN KEY (id_produktu) REFERENCES produkty(id) ON DELETE RESTRICT
);
```

---

## 9. PODSUMOWANIE DO EGZAMINU

### Klucze - szybkie przypomnienie

- **PK** = unikalny, NOT NULL, jedna tabela moze miec jeden PK (ale zlozony z wielu kolumn)
- **FK** = wskazuje na PK innej tabeli, moze byc NULL, moze sie powtarzac
- **UNIQUE** = unikalny, moze byc NULL (w MySQL null != null)
- **INDEX** = przyspiesza wyszukiwanie, nie gwarantuje unikalnosci

### Notacje diagramow E-R

- **Chen**: prostokaty (encje), romby (relacje), elipsy (atrybuty)
- **Crow's Foot**: ||---o< (linia z symbolami kardynalnosci na koncach)
- **UML**: klasy z atrybutami, linie z multiplicznoscia (1, 0..*, 1..*)

### Typy relacji - mnemoniki

- **1:1** = par malzenski (jedna osoba - jeden dowod)
- **1:N** = mama i dzieci (jedna mama, wiele dzieci)
- **M:N** = studenci i kursy (zawsze tabela posrednia!)

### Normalizacja - skrocone zasady

```
1NF: Jedna wartosc w jednej komorce (atomicznosc)
2NF: Atrybut zalezy od CALEGO PK (nie jego czesci)
3NF: Atrybut zalezy od PK BEZPOSREDNIO (nie przez inny atrybut)
BCNF: Kazda zaleznosc musi miec superklucz po lewej stronie
```

### Typy danych - najwazniejsze

| Zastosowanie | Typ |
|-------------|-----|
| ID (klucz glowny) | INT AUTO_INCREMENT |
| Cena, kwota | DECIMAL(10,2) |
| Krotki tekst | VARCHAR(255) |
| Dlugi tekst | TEXT |
| Data urodzenia | DATE |
| Data i godzina | DATETIME |
| Flaga tak/nie | BOOLEAN / TINYINT(1) |
| Lista opcji | ENUM('a','b','c') |

### Kardynalnosc (Crow's Foot)

```
||    = dokladnie jeden (one)
|<    = jeden lub wiele (one or many)
|o    = zero lub jeden (zero or one)
o<    = zero lub wiele (zero or many)

Klient ||---o< Zamowienie
  (jeden klient, zero lub wiele zamowien)
```
