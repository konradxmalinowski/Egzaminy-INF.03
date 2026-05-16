# Diagramy E-R (Entity-Relationship) — INF.03 Technik Programista

> Diagramy encja-relacja (E-R) opisują strukturę bazy danych: jakie tabele istnieją,
> jakie mają kolumny i jak są ze sobą powiązane przez klucze obce (FK).

---

## SPIS TREŚCI

1. [Legenda notacji](#1-legenda-notacji)
2. [Notacja Crow's Foot w ASCII](#2-notacja-crows-foot-w-ascii)
3. [Notacja Chena w ASCII](#3-notacja-chena-w-ascii)
4. [Schemat bazy PRZEPISY (egzamin 2026-01-10)](#4-schemat-bazy-przepisy)
5. [Schemat bazy POGODA (egzamin 2026-01-07)](#5-schemat-bazy-pogoda)
6. [Schemat bazy E-SKLEP](#6-schemat-bazy-e-sklep)
7. [Schemat bazy SZKOLA](#7-schemat-bazy-szkola)
8. [Jak czytać relacje z SQL](#8-jak-czytac-relacje-z-sql)
9. [Typy relacji — podsumowanie](#9-typy-relacji-podsumowanie)

---

## 1. LEGENDA NOTACJI

```
SYMBOLE UŻYWANE W DIAGRAMACH:
+------------------+    Ramka tabeli (encja)
|    NAZWA         |    Nazwa tabeli (wielkie litery)
+------------------+    Separator nagłówka
| PK kolumna TYPE  |    PK = Primary Key (klucz główny)
| FK kolumna TYPE  |    FK = Foreign Key (klucz obcy)
|    kolumna TYPE  |    zwykła kolumna
+------------------+    Zamknięcie ramki

TYPY DANYCH:
INT         liczba całkowita
VARCHAR(n)  tekst do n znaków
TEXT        długi tekst
DATE        data (RRRR-MM-DD)
DATETIME    data i czas
DECIMAL     liczba dziesiętna
TINYINT     mała liczba (0/1 dla bool)
FLOAT       liczba zmiennoprzecinkowa

LINIE RELACJI:
--------    linia relacji (zwykła)
========    linia relacji (podkreślona/silna)
-->         strzałka kierunkowa
|           pionowa część linii
+           punkt połączenia

LICZNOŚCI (Crow's Foot):
||          jeden (exactly one)
|<          jeden lub wiele (one-to-many, strona "wiele")
>|          wiele lub jeden (strona "jeden")
><          wiele do wielu
|o          zero lub jeden (opcjonalny jeden)
o<          zero lub wiele (opcjonalny wiele)
```

---

## 2. NOTACJA CROW'S FOOT W ASCII

> Crow's Foot (kurza łapka) — najpopularniejsza notacja E-R używana w egzaminach.
> Końcówki linii relacji pokazują liczność po każdej stronie.

```
SYMBOLE CROW'S FOOT:
====================

Strona JEDEN (wymagany):
        |
    ----||----      jeden i tylko jeden

Strona JEDEN (opcjonalny):
        o
    ----|o----      zero lub jeden

Strona WIELE (wymagany):
       \|/
    ----|<----      jeden lub wiele (co najmniej jeden)
        |

Strona WIELE (opcjonalny):
        o
       \|/
    ----|o<---      zero lub wiele

===========================================================================
PRZYKŁADY RELACJI:
===========================================================================

RELACJA 1:1 (jeden do jednego)
-----------------------------------------------------------------------
Każdy PRACOWNIK ma dokładnie jedno STANOWISKO,
każde STANOWISKO należy do dokładnie jednego PRACOWNIKA.

+------------------+          +--------------------+
|    PRACOWNIK     |          |     STANOWISKO     |
+------------------+          +--------------------+
| PK id_prac   INT |----------| PK id_stan     INT |
|    imie  VARCHAR |  1    1  | FK id_prac     INT |
|    nazwisko  VAR |          |    nazwa   VARCHAR |
+------------------+          +--------------------+

Zapis: ||------||  (jeden do jednego)

RELACJA 1:N (jeden do wielu)
-----------------------------------------------------------------------
Jeden DZIAŁ ma wielu PRACOWNIKÓW,
każdy PRACOWNIK należy do jednego DZIAŁU.

+------------------+          +--------------------+
|      DZIAL       |          |    PRACOWNIK       |
+------------------+          +--------------------+
| PK id_dzial  INT |>--------<| PK id_prac     INT |
|    nazwa VARCHAR |  1    N  | FK id_dzial    INT |
|    miejsce   VAR |          |    imie    VARCHAR |
+------------------+          |    nazwisko    VAR |
                               +--------------------+

Zapis:  ||------<  (jeden do wielu)
Czytamy: jeden DZIAL ma wiele PRACOWNIKOW
         każdy PRACOWNIK należy do jednego DZIALU

RELACJA M:N (wiele do wielu)
-----------------------------------------------------------------------
Jeden STUDENT zapisany jest na wiele KURSÓW,
jeden KURS ma wielu STUDENTÓW.
Relacja M:N wymaga tabeli pośredniej (asocjacyjnej/łączącej)!

+------------------+    +--------------------+    +------------------+
|     STUDENT      |    |  STUDENT_KURS      |    |      KURS        |
+------------------+    | (tabela łącząca)   |    +------------------+
| PK id_stud   INT |<---| PK,FK id_stud  INT |    | PK id_kurs   INT |
|    imie  VARCHAR |    | PK,FK id_kurs  INT |--->|    nazwa VARCHAR |
|    nazwisko  VAR |    |    data_zapisu DATE|    |    godziny   INT |
+------------------+    +--------------------+    +------------------+
        M                                                  N
Zapis: >------< (wiele do wielu przez tabelę łączącą)
```

---

## 3. NOTACJA CHENA W ASCII

> Notacja Chena — historyczna, używana w teorii. Prostokąty = encje,
> elipsy = atrybuty, romby = relacje.

```
SYMBOLE NOTACJI CHENA:
======================

  [ENCJA]         — prostokąt = encja (tabela)
  (atrybut)       — elipsa = atrybut (kolumna)
  <RELACJA>       — romb = relacja między encjami
  (PK_atrybut)    — atrybut podkreślony = klucz główny (oznaczamy jako PK)

PRZYKŁAD — baza SZKOŁA w notacji Chena:

         (idUcznia)   (imie)   (nazwisko)
              |          |          |
              +----------+----------+
                         |
                    [  UCZEN  ]
                         |
                    < UCZĘSZCZA >
                    1           N
                    |           |
               [ KLASA ]    (idKlasy)
                    |
              (nazwa_klasy)

PRZYKŁAD — relacja M:N w notacji Chena:

    [STUDENT]---<ZAPISANY_NA>---[KURS]
         1               N

    Relacja M:N z atrybutem własnym relacji:
    [STUDENT]---<ZAPISANY_NA>---[KURS]
                     |
                (data_zapisu)

===========================================================================
PORÓWNANIE NOTACJI:
===========================================================================

                Chen            Crow's Foot       UML
Encja:        [BOX]            +-------+         +---------+
                               | TABELA|         | Tabela  |
                               +-------+         +---------+
Relacja:      <romb>           linia z końcówkami linia z końcówkami
Atrybut:      (elipsa)        kolumna w tabeli   atrybut w klasie
PK:           podkreślony      "PK" prefix        <<PK>> lub podkr.
FK:           brak wprost      "FK" prefix        <<FK>> lub zależność
```

---

## 4. SCHEMAT BAZY PRZEPISY

> Z egzaminu INF.03 z dnia 2026-01-10.
> Baza danych do przechowywania przepisów kulinarnych.

### 4.1 Tabele i kolumny

```
+====================+     +====================+
|      POTRAWY       |     |      RODZAJE       |
+====================+     +====================+
| PK idPotrawy  INT  |     | PK idRodzaje  INT  |
|    nazwa  VARCHAR  |     |    rodzaj VARCHAR  |
|    opis       TEXT |     +====================+
| FK idRodzaje  INT  |
+====================+

+====================+     +==========================+
|     SKLADNIKI      |     |   POTRAWY_SKLADNIKI      |
+====================+     |   (tabela łącząca M:N)   |
| PK idSkladniki INT |     +==========================+
|    skladnik VARCHAR|     | PK,FK idPotrawy    INT   |
+====================+     | PK,FK idSkladniki  INT   |
                           +==========================+
```

### 4.2 Pełny diagram E-R z relacjami

```
+====================+                    +====================+
|      RODZAJE       |                    |     SKLADNIKI      |
+====================+                    +====================+
| PK idRodzaje  INT  |                    | PK idSkladniki INT |
|    rodzaj VARCHAR  |                    |    skladnik VARCHAR|
+====================+                    +====================+
          | 1                                        | N
          |                                          |
          | N                                        |
+====================+          +==========================+
|      POTRAWY       |          |   POTRAWY_SKLADNIKI      |
+====================+   1   N  +==========================+
| PK idPotrawy  INT  |----------| PK,FK idPotrawy    INT   |
|    nazwa  VARCHAR  |          | PK,FK idSkladniki  INT   |
|    opis       TEXT |          +==========================+
| FK idRodzaje  INT  |
+====================+

OPIS RELACJI:
  RODZAJE  (1) -----> (N) POTRAWY
  Jeden rodzaj (np. "Zupy") może mieć wiele potraw.
  Każda potrawa należy do jednego rodzaju.
  Implementacja: FK idRodzaje w tabeli POTRAWY.

  POTRAWY  (N) <-----> (N) SKLADNIKI
  Jedna potrawa ma wiele składników.
  Jeden składnik może być w wielu potrawach.
  Implementacja: tabela pośrednia POTRAWY_SKLADNIKI z kluczem złożonym.
```

### 4.3 SQL — CREATE TABLE dla bazy PRZEPISY

```sql
-- Tabela bez zależności — tworzona pierwsza
CREATE TABLE rodzaje (
    idRodzaje INT PRIMARY KEY AUTO_INCREMENT,
    rodzaj    VARCHAR(50) NOT NULL
);

-- Tabela bez zależności — tworzona pierwsza
CREATE TABLE skladniki (
    idSkladniki INT PRIMARY KEY AUTO_INCREMENT,
    skladnik    VARCHAR(100) NOT NULL
);

-- Tabela zależna od RODZAJE
CREATE TABLE potrawy (
    idPotrawy INT PRIMARY KEY AUTO_INCREMENT,
    nazwa     VARCHAR(100) NOT NULL,
    opis      TEXT,
    idRodzaje INT NOT NULL,
    FOREIGN KEY (idRodzaje) REFERENCES rodzaje(idRodzaje)
);

-- Tabela łącząca M:N — tworzona ostatnia
CREATE TABLE potrawy_skladniki (
    idPotrawy   INT NOT NULL,
    idSkladniki INT NOT NULL,
    PRIMARY KEY (idPotrawy, idSkladniki),           -- klucz złożony
    FOREIGN KEY (idPotrawy)   REFERENCES potrawy(idPotrawy),
    FOREIGN KEY (idSkladniki) REFERENCES skladniki(idSkladniki)
);
```

### 4.4 Kolejność tworzenia i usuwania tabel

```
TWORZENIE (od niezależnych do zależnych):
  1. rodzaje          (brak FK)
  2. skladniki        (brak FK)
  3. potrawy          (FK -> rodzaje)
  4. potrawy_skladniki (FK -> potrawy, skladniki)

USUWANIE (odwrotna kolejność — najpierw zależne):
  1. DROP TABLE potrawy_skladniki;
  2. DROP TABLE potrawy;
  3. DROP TABLE skladniki;
  4. DROP TABLE rodzaje;

UWAGA: Nie można usunąć tabeli, na którą wskazuje FK z innej tabeli!
```

---

## 5. SCHEMAT BAZY POGODA

> Z egzaminu INF.03 z dnia 2026-01-07.
> Baza danych do przechowywania pomiarów meteorologicznych.

### 5.1 Tabele i kolumny

```
+========================+     +======================+
|        POMIARY         |     |       MIASTA         |
+========================+     +======================+
| PK idPomiary      INT  |     | PK idMiasto     INT  |
|    temperatura  FLOAT  |     |    miasto   VARCHAR  |
|    cisnienie    FLOAT  |     | FK idWojewodztwo INT |
| FK idMiasto       INT  |     +======================+
| FK idMiesiace     INT  |
+========================+     +======================+
                               |   WOJEWODZTWA        |
+======================+       +======================+
|       MIESIACE       |       | PK idWojewodztwo INT |
+======================+       |    wojewodztwo   VAR |
| PK idMiesiace   INT  |       +======================+
|    miesiac  VARCHAR  |
+======================+
```

### 5.2 Pełny diagram E-R z relacjami

```
+======================+                    +======================+
|    WOJEWODZTWA       |                    |       MIESIACE       |
+======================+                    +======================+
| PK idWojewodztwo INT |                    | PK idMiesiace   INT  |
|    wojewodztwo   VAR |                    |    miesiac  VARCHAR  |
+======================+                    +======================+
          | 1                                          | 1
          |                                            |
          | N                                          | N
+======================+          +========================+
|        MIASTA        |          |        POMIARY         |
+======================+  1    N  +========================+
| PK idMiasto     INT  |----------| PK idPomiary      INT  |
|    miasto   VARCHAR  |          |    temperatura  FLOAT  |
| FK idWojewodztwo INT |          |    cisnienie    FLOAT  |
+======================+          | FK idMiasto       INT  |
                                  | FK idMiesiace     INT  |
                                  +========================+

OPIS RELACJI:
  WOJEWODZTWA (1) -----> (N) MIASTA
  Jedno województwo zawiera wiele miast.
  Każde miasto należy do jednego województwa.

  MIASTA (1) -----> (N) POMIARY
  W jednym mieście wykonano wiele pomiarów.
  Każdy pomiar dotyczy jednego miasta.

  MIESIACE (1) -----> (N) POMIARY
  W jednym miesiącu wykonano wiele pomiarów.
  Każdy pomiar dotyczy jednego miesiąca.

UWAGA: Tabela POMIARY ma DWA klucze obce (idMiasto i idMiesiace).
       Jest "centrum" schematu — łączy ze sobą 3 pozostałe tabele.
```

### 5.3 SQL — CREATE TABLE dla bazy POGODA

```sql
CREATE TABLE wojewodztwa (
    idWojewodztwo INT PRIMARY KEY AUTO_INCREMENT,
    wojewodztwo   VARCHAR(50) NOT NULL
);

CREATE TABLE miesiace (
    idMiesiace INT PRIMARY KEY AUTO_INCREMENT,
    miesiac    VARCHAR(20) NOT NULL
);

CREATE TABLE miasta (
    idMiasto      INT PRIMARY KEY AUTO_INCREMENT,
    miasto        VARCHAR(100) NOT NULL,
    idWojewodztwo INT NOT NULL,
    FOREIGN KEY (idWojewodztwo) REFERENCES wojewodztwa(idWojewodztwo)
);

CREATE TABLE pomiary (
    idPomiary   INT PRIMARY KEY AUTO_INCREMENT,
    temperatura FLOAT,
    cisnienie   FLOAT,
    idMiasto    INT NOT NULL,
    idMiesiace  INT NOT NULL,
    FOREIGN KEY (idMiasto)   REFERENCES miasta(idMiasto),
    FOREIGN KEY (idMiesiace) REFERENCES miesiace(idMiesiace)
);
```

### 5.4 Diagram hierarchii geograficznej

```
HIERARCHIA:
===========
[WOJEWODZTWA]
      |
      | 1:N (jedno województwo -> wiele miast)
      v
  [MIASTA]
      |
      | 1:N (jedno miasto -> wiele pomiarów)
      v
  [POMIARY] <----- [MIESIACE]
                   1:N (jeden miesiąc -> wiele pomiarów)

Przykładowe dane:
WOJEWODZTWA: Mazowieckie, Małopolskie, Śląskie
MIASTA:      Warszawa (Maz.), Kraków (Mał.), Katowice (Śl.)
MIESIACE:    Styczeń, Luty, Marzec, ...
POMIARY:     Warszawa/Styczeń: 2.5°C, 1013 hPa
             Kraków/Luty: -3.1°C, 1020 hPa
```

---

## 6. SCHEMAT BAZY E-SKLEP

> Przykładowy schemat typowego sklepu internetowego — często pojawia się
> na egzaminach jako zadanie projektowe.

### 6.1 Diagram E-R

```
+===================+         +===================+
|     KATEGORIE     |         |      KLIENCI      |
+===================+         +===================+
| PK id_kat    INT  |         | PK id_kli    INT  |
|    nazwa VARCHAR  |         |    imie  VARCHAR  |
|    opis      TEXT |         |    nazwisko  VAR  |
+===================+         |    email VARCHAR  |
        | 1                   |    telefon   VAR  |
        |                     |    adres    TEXT  |
        | N                   +===================+
+===================+                 | 1
|     PRODUKTY      |                 |
+===================+                 | N
| PK id_prod   INT  |         +===================+
|    nazwa VARCHAR  |         |     ZAMOWIENIA    |
|    opis      TEXT |         +===================+
|    cena  DECIMAL  |         | PK id_zam    INT  |
|    stan_mag  INT  |         | FK id_kli    INT  |
| FK id_kat    INT  |         |    data_zam  DATE |
+===================+         |    status VARCHAR |
        | N                   |    suma  DECIMAL  |
        |                     +===================+
        |                             | N
        +-----------------------------+
        |        N               N   |
+=========================+
|   ZAMOWIENIA_PRODUKTY   |
|   (tabela łącząca M:N)  |
+=========================+
| PK,FK id_zam      INT   |
| PK,FK id_prod     INT   |
|       ilosc       INT   |
|       cena_jedn DECIMAL |
+=========================+

OPIS WSZYSTKICH RELACJI:
========================
  KATEGORIE  (1:N)  PRODUKTY
    Jedna kategoria zawiera wiele produktów.
    Każdy produkt należy do jednej kategorii.

  KLIENCI    (1:N)  ZAMOWIENIA
    Jeden klient składa wiele zamówień.
    Każde zamówienie należy do jednego klienta.

  ZAMOWIENIA (M:N)  PRODUKTY
    Jedno zamówienie zawiera wiele produktów.
    Jeden produkt może być w wielu zamówieniach.
    -> Tabela pośrednia: ZAMOWIENIA_PRODUKTY
```

### 6.2 SQL — CREATE TABLE dla E-SKLEP

```sql
CREATE TABLE kategorie (
    id_kat INT PRIMARY KEY AUTO_INCREMENT,
    nazwa  VARCHAR(100) NOT NULL,
    opis   TEXT
);

CREATE TABLE klienci (
    id_kli   INT PRIMARY KEY AUTO_INCREMENT,
    imie     VARCHAR(50) NOT NULL,
    nazwisko VARCHAR(50) NOT NULL,
    email    VARCHAR(100) UNIQUE NOT NULL,
    telefon  VARCHAR(20),
    adres    TEXT
);

CREATE TABLE produkty (
    id_prod  INT PRIMARY KEY AUTO_INCREMENT,
    nazwa    VARCHAR(200) NOT NULL,
    opis     TEXT,
    cena     DECIMAL(10,2) NOT NULL,
    stan_mag INT DEFAULT 0,
    id_kat   INT NOT NULL,
    FOREIGN KEY (id_kat) REFERENCES kategorie(id_kat)
);

CREATE TABLE zamowienia (
    id_zam   INT PRIMARY KEY AUTO_INCREMENT,
    id_kli   INT NOT NULL,
    data_zam DATE NOT NULL,
    status   VARCHAR(30) DEFAULT 'nowe',
    suma     DECIMAL(10,2),
    FOREIGN KEY (id_kli) REFERENCES klienci(id_kli)
);

CREATE TABLE zamowienia_produkty (
    id_zam    INT NOT NULL,
    id_prod   INT NOT NULL,
    ilosc     INT NOT NULL DEFAULT 1,
    cena_jedn DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (id_zam, id_prod),
    FOREIGN KEY (id_zam)  REFERENCES zamowienia(id_zam),
    FOREIGN KEY (id_prod) REFERENCES produkty(id_prod)
);
```

---

## 7. SCHEMAT BAZY SZKOLA

> Przykładowy schemat systemu szkolnego — typowe zadanie egzaminacyjne.

### 7.1 Diagram E-R

```
+===================+         +===================+
|   NAUCZYCIELE     |         |      KLASY        |
+===================+         +===================+
| PK id_nau    INT  |         | PK id_kla    INT  |
|    imie  VARCHAR  |         |    nazwa VARCHAR  |
|    nazwisko  VAR  |         |    rok_szk   INT  |
|    przedmiot VAR  |         | FK id_nau    INT  |---> wychowawca
+===================+         +===================+
        | 1                           | 1
        |                             |
        | N                           | N
+===================+         +===================+
|    PRZEDMIOTY     |         |     UCZNIOWIE     |
+===================+         +===================+
| PK id_prz    INT  |         | PK id_ucz    INT  |
|    nazwa VARCHAR  |         |    imie  VARCHAR  |
| FK id_nau    INT  |         |    nazwisko  VAR  |
+===================+         |    data_ur   DATE |
        | N                   | FK id_kla    INT  |
        |                     +===================+
        |         N                   | N
        +-----------+                 |
                    |                 |
              +===================+   |
              |       OCENY       |   |
              +===================+   |
              | PK id_oc     INT  |   |
              | FK id_ucz    INT  |<--+
              | FK id_prz    INT  |
              |    ocena TINYINT  |
              |    data_wys  DATE |
              +===================+

OPIS RELACJI:
=============
  NAUCZYCIELE (1:N) KLASY
    Jeden nauczyciel jest wychowawcą jednej lub wielu klas.

  NAUCZYCIELE (1:N) PRZEDMIOTY
    Jeden nauczyciel uczy jednego lub wielu przedmiotów.

  KLASY (1:N) UCZNIOWIE
    Do jednej klasy należy wielu uczniów.
    Każdy uczeń należy do jednej klasy.

  UCZNIOWIE (M:N) PRZEDMIOTY — przez OCENY
    Jeden uczeń ma oceny z wielu przedmiotów.
    Z jednego przedmiotu oceny ma wielu uczniów.
    -> Tabela OCENY łączy uczniów z przedmiotami.
```

### 7.2 SQL — CREATE TABLE dla SZKOLA

```sql
CREATE TABLE nauczyciele (
    id_nau    INT PRIMARY KEY AUTO_INCREMENT,
    imie      VARCHAR(50) NOT NULL,
    nazwisko  VARCHAR(50) NOT NULL,
    przedmiot VARCHAR(50)
);

CREATE TABLE klasy (
    id_kla  INT PRIMARY KEY AUTO_INCREMENT,
    nazwa   VARCHAR(10) NOT NULL,
    rok_szk INT,
    id_nau  INT,                    -- wychowawca klasy
    FOREIGN KEY (id_nau) REFERENCES nauczyciele(id_nau)
);

CREATE TABLE przedmioty (
    id_prz INT PRIMARY KEY AUTO_INCREMENT,
    nazwa  VARCHAR(100) NOT NULL,
    id_nau INT NOT NULL,
    FOREIGN KEY (id_nau) REFERENCES nauczyciele(id_nau)
);

CREATE TABLE uczniowie (
    id_ucz   INT PRIMARY KEY AUTO_INCREMENT,
    imie     VARCHAR(50) NOT NULL,
    nazwisko VARCHAR(50) NOT NULL,
    data_ur  DATE,
    id_kla   INT NOT NULL,
    FOREIGN KEY (id_kla) REFERENCES klasy(id_kla)
);

CREATE TABLE oceny (
    id_oc  INT PRIMARY KEY AUTO_INCREMENT,
    id_ucz INT NOT NULL,
    id_prz INT NOT NULL,
    ocena  TINYINT NOT NULL CHECK (ocena BETWEEN 1 AND 6),
    data_wys DATE NOT NULL,
    FOREIGN KEY (id_ucz) REFERENCES uczniowie(id_ucz),
    FOREIGN KEY (id_prz) REFERENCES przedmioty(id_prz)
);
```

---

## 8. JAK CZYTAĆ RELACJE Z SQL

> Na egzaminie często trzeba rozpoznać typ relacji na podstawie kodu SQL.

### 8.1 Jak rozpoznać relację 1:N

```
WSKAZÓWKA: Szukaj FOREIGN KEY w definicji tabeli.
Tabela z FK jest po stronie "N" (wielu).
Tabela, do której FK wskazuje, jest po stronie "1".

PRZYKŁAD:
---------
CREATE TABLE zamowienia (
    id_zam INT PRIMARY KEY,
    id_kli INT,
    FOREIGN KEY (id_kli) REFERENCES klienci(id_kli)  -- FK wskazuje na KLIENCI
);

Odczyt:
  - ZAMOWIENIA ma FK -> KLIENCI
  - Jedno zamówienie -> jeden klient (strona FK = strona N)
  - Jeden klient -> wiele zamówień (strona referenced = strona 1)
  - Relacja: KLIENCI (1) -----> (N) ZAMOWIENIA

SCHEMAT CZYTANIA:
[tabela_z_FK] N -----> 1 [tabela_referenced]
```

### 8.2 Jak rozpoznać relację M:N

```
WSKAZÓWKA: Szukaj tabeli z kluczem złożonym (PRIMARY KEY z 2+ kolumn)
           gdzie obie kolumny PK są jednocześnie FK.

PRZYKŁAD:
---------
CREATE TABLE zamowienia_produkty (
    id_zam  INT,
    id_prod INT,
    PRIMARY KEY (id_zam, id_prod),              -- klucz złożony!
    FOREIGN KEY (id_zam)  REFERENCES zamowienia(id_zam),
    FOREIGN KEY (id_prod) REFERENCES produkty(id_prod)
);

Odczyt:
  - Tabela ma 2 FK: do ZAMOWIENIA i do PRODUKTY
  - Obie FK razem tworzą PK (klucz złożony)
  - To jest tabela pośrednia/łącząca
  - Relacja: ZAMOWIENIA (N) <-----> (N) PRODUKTY
```

### 8.3 Jak rozpoznać relację 1:1

```
WSKAZÓWKA: Tabela z FK ma UNIQUE na kolumnie FK.

PRZYKŁAD:
---------
CREATE TABLE szczegoly_pracownika (
    id_szcz INT PRIMARY KEY,
    id_prac INT UNIQUE,              -- UNIQUE gwarantuje 1:1 !
    pesel   VARCHAR(11),
    FOREIGN KEY (id_prac) REFERENCES pracownicy(id_prac)
);

Odczyt:
  - FK id_prac jest UNIQUE
  - Znaczy: jeden id_prac może wystąpić tylko raz w tej tabeli
  - Relacja: PRACOWNICY (1) -----> (1) SZCZEGOLY_PRACOWNIKA
```

### 8.4 Tabela decyzyjna — rozpoznawanie relacji

```
+------------------------------------------+-------------------+
| Co widzę w SQL                           | Typ relacji       |
+------------------------------------------+-------------------+
| Tabela A ma FK -> tabela B               | A.N --- B.1       |
| Tabela A ma FK UNIQUE -> tabela B        | A.1 --- B.1       |
| Tabela C ma PK(FK_A, FK_B)              | A.N --- B.N       |
|   + FK(FK_A)->A + FK(FK_B)->B            | (C = tabela łącz.)|
+------------------------------------------+-------------------+
```

---

## 9. TYPY RELACJI — PODSUMOWANIE

### 9.1 Szybka ściągawka

```
TYPY RELACJI W BAZACH DANYCH:
==============================

1:1  Jeden do jednego
     Przykład: Pracownik - Stanowisko, Człowiek - Paszport
     SQL: FK z UNIQUE w tabeli zależnej
     Crow's Foot: ||------||

1:N  Jeden do wielu (najczęściej!)
     Przykład: Dział - Pracownicy, Kategoria - Produkty, Klient - Zamówienia
     SQL: FK w tabeli "wiele" bez UNIQUE
     Crow's Foot: ||------<

M:N  Wiele do wielu
     Przykład: Student - Kurs, Zamówienie - Produkt, Potrawa - Składnik
     SQL: tabela pośrednia z FK do obu tabel
     Crow's Foot: >-------<  (przez tabelę łączącą)
```

### 9.2 Diagram wszystkich typów porównawczo

```
RELACJA 1:1
===========
+----------+  1    1  +----------+
| OSOBA    |----------| PASZPORT |
+----------+          +----------+
| PK id    |          | PK id    |
| imie     |          | FK id_os |UNIQUE
+----------+          | numer    |
                      +----------+

RELACJA 1:N
===========
+----------+  1    N  +----------+
| KATEGORIA|>--------<| PRODUKTY |
+----------+          +----------+
| PK id    |          | PK id    |
| nazwa    |          | FK id_kat|
+----------+          | nazwa    |
                      | cena     |
                      +----------+

RELACJA M:N (z tabelą łączącą)
================================
+----------+          +------------------+          +----------+
| STUDENT  |  1    N  |  STUDENT_KURS    |  N    1  |  KURS    |
+----------+>--------<+------------------+>--------<+----------+
| PK id    |          | PK,FK id_stud    |          | PK id    |
| imie     |          | PK,FK id_kurs    |          | nazwa    |
+----------+          | data_zapisu      |          +----------+
                      +------------------+

REGULA: Jeśli M:N -> ZAWSZE potrzebujesz tabeli pośredniej!
        Bez tabeli pośredniej M:N nie można zrealizować w SQL.
```

### 9.3 Integralność referencyjna

```
INTEGRALNOSC REFERENCYJNA:
==========================
Zasada: Wartość FK musi istnieć w tabeli referenced (lub być NULL).

NARUSZENIE:
  Tabela ZAMOWIENIA: idKlienta = 999
  Tabela KLIENCI: nie ma klienta o id = 999
  -> BLAD! Naruszenie integralności referencyjnej.

OPCJE ON DELETE / ON UPDATE:
  RESTRICT  — zabroń usunięcia rekordu, na który wskazuje FK (domyślne)
  CASCADE   — usuń/zaktualizuj rekordy zależne automatycznie
  SET NULL  — ustaw FK na NULL przy usunięciu referenced
  NO ACTION — jak RESTRICT, sprawdzane na koncu transakcji

PRZYKŁAD:
  FOREIGN KEY (id_kli) REFERENCES klienci(id_kli)
      ON DELETE CASCADE      -- usuń zamówienia gdy usunięto klienta
      ON UPDATE CASCADE      -- zmień FK gdy zmienił się PK klienta
```

---

*Plik wygenerowany dla kursu INF.03 — Technik Programista*
*Dotyczy: egzaminy 2026-01-07, 2026-01-10 oraz materiał ogólny*
