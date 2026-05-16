# ŚCIĄGAWKA: MariaDB (INF.03.4)

> Egzamin INF.03 — Technik Programista | Bazy danych
> Ostatnia aktualizacja: 2026

---

## Spis treści

1. [Co to jest MariaDB — historia](#1-co-to-jest-mariadb--historia)
2. [MariaDB vs MySQL — porównanie](#2-mariadb-vs-mysql--porównanie)
3. [Silniki tabel MariaDB](#3-silniki-tabel-mariadb)
4. [Tabela porównawcza silników](#4-tabela-porównawcza-silników)
5. [Specyficzne funkcje MariaDB](#5-specyficzne-funkcje-mariadb)
6. [Typy danych specyficzne dla MariaDB](#6-typy-danych-specyficzne-dla-mariadb)
7. [Instalacja MariaDB](#7-instalacja-mariadb)
8. [Konfiguracja my.cnf / my.ini](#8-konfiguracja-mycnf--myini)
9. [Zarządzanie użytkownikami](#9-zarządzanie-użytkownikami)
10. [Backup i restore](#10-backup-i-restore)
11. [Replikacja w MariaDB](#11-replikacja-w-mariadb)
12. [Polecenia CLI MariaDB vs MySQL](#12-polecenia-cli-mariadb-vs-mysql)
13. [Best practices bezpieczeństwa](#13-best-practices-bezpieczeństwa)
14. [Porównanie wersji MariaDB](#14-porównanie-wersji-mariadb)
15. [XAMPP i MAMP — wersje i sprawdzanie](#15-xampp-i-mamp--wersje-i-sprawdzanie)

---

## 1. Co to jest MariaDB — historia

### Geneza i historia

**MariaDB** to wolnodostępny, otwartoźródłowy relacyjny system zarządzania bazami danych (RDBMS).
Jest **forkiem MySQL**, stworzonym w **2009 roku** przez **Michaela "Monty" Wideniusa** — jednego z
oryginalnych twórców MySQL.

### Dlaczego powstał MariaDB?

| Powód | Opis |
|-------|------|
| Przejęcie Sun Microsystems przez Oracle (2010) | Oracle kupił Sun (właściciela MySQL). Społeczność Open Source obawiała się zamknięcia projektu lub ograniczenia licencji |
| Obawy o licencję GPL | MySQL ma dualną licencję (GPL + komercyjna Oracle). MariaDB jest w 100% GPL |
| Kierunek rozwoju | Monty chciał rozwijać projekt szybciej i z większą wolnością |
| Przejrzystość | MariaDB Foundation zarządza projektem jako organizacja non-profit |

### Kluczowe daty

```
2009 — Monty Widenius tworzy MariaDB (fork MySQL 5.1)
2010 — Oracle przejmuje Sun Microsystems + MySQL
2012 — MariaDB Foundation zostaje założona
2013 — Fedora, Arch Linux, OpenSUSE przechodzą na MariaDB jako domyślny RDBMS
2014 — Red Hat Enterprise Linux 7 domyślnie używa MariaDB
2015 — MariaDB 10.1 — szyfrowanie tabel, Galera Cluster wbudowany
2018 — MariaDB 10.3 — SEQUENCE, PL/SQL kompatybilność
2022 — MariaDB 10.9, MariaDB Corporation na giełdzie
2023 — MariaDB 11.0 — pierwsza wersja z nowym numerowaniem
```

### Nazwa MariaDB

Nazwa pochodzi od córki Monty Wideniusa — **Marii** (tak jak MySQL pochodzi od imienia My,
starszej córki Monty'ego).

---

## 2. MariaDB vs MySQL — porównanie

### Tabela porównawcza

| Cecha | MariaDB | MySQL |
|-------|---------|-------|
| Właściciel | MariaDB Foundation (non-profit) | Oracle Corporation |
| Licencja | GPL v2 (w 100% open source) | GPL + Commercial (dualna) |
| Pierwsza wersja | 2009 (fork MySQL 5.1) | 1995 |
| Obecna stabilna wersja | 11.x (2023+) | 8.0, 8.4, 9.0 |
| Kompatybilność binarna | Wysoka (drop-in replacement do MySQL 5.x) | — |
| Domyślny silnik | InnoDB | InnoDB |
| Sekwencje (SEQUENCE) | TAK (10.3+) | NIE (tylko AUTO_INCREMENT) |
| Window Functions | TAK (10.2+) | TAK (8.0+) |
| Typy INET6, UUID | TAK (natywne) | NIE (jako string) |
| Galera Cluster | Wbudowany (multi-master) | Opcjonalny (zewnętrzny) |
| Silnik Aria | TAK (zastępca MyISAM) | NIE |
| Spider engine (sharding) | TAK | NIE (oficjalnie) |
| JSON | TAK (jako alias LONGTEXT) | TAK (natywny typ binarny) |
| Szyfrowanie tabel | TAK (wbudowane) | TAK (wbudowane) |
| CONNECT engine | TAK | NIE |
| Virtual Columns | TAK (5.2+) | TAK (5.7+ jako Generated Columns) |
| Invisible Columns | TAK (10.3+) | TAK (8.0+) |
| Systemy temporalne | TAK (10.3.4+ System-Versioned Tables) | NIE |
| Kompilator | GCC / Clang | GCC / Clang / MSVC |

### Kompatybilność składni

Większość zapytań SQL napisanych dla MySQL działa w MariaDB bez modyfikacji.
Są jednak różnice:

```sql
-- MariaDB: natywna obsługa sekwencji
CREATE SEQUENCE seq_id START WITH 1 INCREMENT BY 1;
SELECT NEXT VALUE FOR seq_id;

-- MySQL: brak sekwencji, tylko AUTO_INCREMENT
-- Nie ma odpowiednika

-- MariaDB: DO ... END w SELECT
SELECT (DO SLEEP(1));  -- różne zachowanie

-- MariaDB: LIMIT w UPDATE/DELETE obsługiwany inaczej
DELETE FROM tabela ORDER BY id LIMIT 10;  -- działa w obu

-- MariaDB: RETURNING (10.5+)
INSERT INTO produkty (nazwa) VALUES ('Laptop') RETURNING id;
-- MySQL: brak RETURNING
```

### Kiedy używać MariaDB, a kiedy MySQL?

- **MariaDB** — gdy zależy ci na 100% open source, zaawansowanych funkcjach (sekwencje, Spider),
  lub gdy systemy operacyjne (Linux) dostarczają MariaDB jako domyślny pakiet
- **MySQL** — gdy aplikacja wymaga certyfikowanej kompatybilności z Oracle, lub używasz
  MySQL Workbench z pełną integracją

---

## 3. Silniki tabel MariaDB

Silnik (Storage Engine) to komponent odpowiedzialny za fizyczne przechowywanie danych.
MariaDB obsługuje wiele silników jednocześnie — każda tabela może używać innego.

### Przegląd silników

```sql
-- Wyświetl dostępne silniki
SHOW ENGINES;

-- Sprawdź silnik konkretnej tabeli
SHOW TABLE STATUS LIKE 'nazwa_tabeli'\G

-- Zmień silnik tabeli
ALTER TABLE nazwa_tabeli ENGINE = InnoDB;
```

### InnoDB

- **Domyślny silnik** w MariaDB i MySQL
- Transakcyjny — obsługuje ACID
- Obsługuje **klucze obce (Foreign Keys)**
- Blokowanie na poziomie **wiersza (row-level locking)**
- Plik danych: `.ibd` (lub tablespace `ibdata`)
- **MVCC** (Multi-Version Concurrency Control) — wiele wersji wiersza jednocześnie
- Crash recovery — automatyczne odtwarzanie po awarii

```sql
CREATE TABLE zamowienia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    klient_id INT NOT NULL,
    data_zamowienia DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (klient_id) REFERENCES klienci(id) ON DELETE CASCADE
) ENGINE = InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### MyISAM

- **Stary domyślny silnik** (przed InnoDB)
- **Nie obsługuje transakcji**
- **Nie obsługuje kluczy obcych**
- Blokowanie na poziomie **tabeli (table-level locking)**
- Szybki odczyt, wolny zapis współbieżny
- Obsługuje **FULL-TEXT search** (MySQL 5.5 i starsze)
- Pliki: `.MYD` (dane), `.MYI` (indeksy), `.frm` (struktura)
- W MariaDB **zastąpiony przez Aria** dla tabel systemowych

```sql
CREATE TABLE logi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tresc TEXT,
    data DATETIME
) ENGINE = MyISAM;
```

### Aria (specyficzny dla MariaDB)

- Następca MyISAM, **stworzony przez Monty Program** (twórcy MariaDB)
- Crash-safe — odporny na awarie (w przeciwieństwie do MyISAM)
- **Nie obsługuje transakcji** (może, ale domyślnie nie)
- Blokowanie na poziomie tabeli lub strony
- Używany przez MariaDB dla **tabel systemowych wewnętrznych**
- Obsługuje FULL-TEXT search
- Pliki: `.MAD`, `.MAI`

```sql
CREATE TABLE bufor_temp (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dane VARCHAR(500)
) ENGINE = Aria TRANSACTIONAL = 0;
```

### Memory (HEAP)

- Dane przechowywane **w pamięci RAM**
- Bardzo szybki odczyt i zapis
- Dane **tracone po restarcie serwera**
- Blokowanie na poziomie tabeli
- Obsługuje indeksy HASH i B-TREE
- Idealne do tabel tymczasowych, cache

```sql
CREATE TABLE cache_sesji (
    session_id VARCHAR(64) PRIMARY KEY,
    dane TEXT,
    wygasa DATETIME
) ENGINE = MEMORY;
```

### CSV

- Dane przechowywane jako **pliki CSV**
- Brak indeksów
- Wszystkie kolumny muszą być NOT NULL
- Idealne do wymiany danych z arkuszami kalkulacyjnymi
- Plik: `.CSV`, `.CSM`

```sql
CREATE TABLE eksport_csv (
    id INT NOT NULL,
    nazwa VARCHAR(100) NOT NULL,
    cena DECIMAL(10,2) NOT NULL
) ENGINE = CSV;
```

### Archive

- Zoptymalizowany do **przechowywania dużych ilości danych historycznych**
- Bardzo dobre kompresja (zlib)
- Obsługuje tylko **INSERT i SELECT** (brak UPDATE/DELETE)
- Brak indeksów (poza AUTO_INCREMENT)
- Idealne do logów i archiwów

```sql
CREATE TABLE logi_archiwum (
    id INT AUTO_INCREMENT PRIMARY KEY,
    zdarzenie VARCHAR(255),
    data DATETIME
) ENGINE = Archive;
```

### CONNECT (specyficzny dla MariaDB)

- Umożliwia **dostęp do zewnętrznych źródeł danych** jako tabele MariaDB
- Obsługuje pliki tekstowe, XML, JSON, Excel, ODBC, JDBC, inne bazy danych
- Dane nie są przechowywane lokalnie — są odczytywane na żywo

```sql
-- Tabela mapowana na plik tekstowy
CREATE TABLE zewnetrzny_plik (
    id INT,
    nazwa VARCHAR(100)
) ENGINE = CONNECT
  TABLE_TYPE = 'CSV'
  FILE_NAME = '/tmp/dane.csv'
  SEP_CHAR = ',';
```

### Spider (specyficzny dla MariaDB)

- Silnik do **shardingu** (poziome partycjonowanie danych)
- Dane rozłożone między wiele serwerów MariaDB
- Spider działa jako proxy i agreguje wyniki

```sql
-- Przykład konfiguracji Spider
CREATE TABLE sharded_table (
    id INT PRIMARY KEY,
    dane VARCHAR(100)
) ENGINE = Spider
  COMMENT = 'wrapper "mariadb", host "192.168.1.10", port "3306", database "db1", table "tabela1"';
```

---

## 4. Tabela porównawcza silników

| Cecha | InnoDB | MyISAM | Aria | Memory | CSV | Archive |
|-------|--------|--------|------|--------|-----|---------|
| Transakcje | TAK | NIE | Opcjonalnie | NIE | NIE | NIE |
| Klucze obce (FK) | TAK | NIE | NIE | NIE | NIE | NIE |
| ACID | TAK | NIE | Częściowo | NIE | NIE | NIE |
| Blokowanie | Wiersz | Tabela | Tabela/Strona | Tabela | Tabela | Wiersz |
| Full-text search | TAK (5.6+) | TAK | TAK | NIE | NIE | NIE |
| Crash-safe | TAK | NIE | TAK | NIE | NIE | NIE |
| Dane po restarcie | TAK | TAK | TAK | NIE | TAK | TAK |
| Kompresja | TAK | TAK | TAK | NIE | NIE | TAK (zlib) |
| Replikacja | TAK | TAK | TAK | Ograniczona | TAK | TAK |
| AUTO_INCREMENT | TAK | TAK | TAK | TAK | NIE | TAK |
| Wydajność INSERT | Dobra | Dobra | Dobra | Bardzo dobra | Dobra | Dobra |
| Wydajność SELECT | Dobra | Bardzo dobra | Dobra | Bardzo dobra | Słaba | Słaba |
| Pliki | .ibd | .MYD .MYI | .MAD .MAI | RAM | .CSV .CSM | .arz |
| Kiedy używać | Produkcja | Tylko odczyt | Tabele sys. | Cache/Temp | Eksport | Logi/Archiwum |

---

## 5. Specyficzne funkcje MariaDB

### SEQUENCE — sekwencje (MariaDB 10.3+)

Sekwencje to obiekty bazy danych generujące unikalne liczby (alternatywa dla AUTO_INCREMENT).

```sql
-- Tworzenie sekwencji
CREATE SEQUENCE seq_zamowienie
    START WITH 1000
    INCREMENT BY 1
    MINVALUE 1000
    MAXVALUE 9999999
    NOCYCLE;

-- Pobieranie kolejnej wartości
SELECT NEXT VALUE FOR seq_zamowienie;
-- lub
SELECT NEXTVAL(seq_zamowienie);

-- Podgląd aktualnej wartości (bez inkrementacji)
SELECT LASTVAL(seq_zamowienie);

-- Użycie w INSERT
INSERT INTO zamowienia (id, klient)
VALUES (NEXT VALUE FOR seq_zamowienie, 'Jan Kowalski');

-- Restart sekwencji
ALTER SEQUENCE seq_zamowienie RESTART WITH 1;

-- Usunięcie sekwencji
DROP SEQUENCE seq_zamowienie;

-- Lista sekwencji
SHOW CREATE SEQUENCE seq_zamowienie;
```

### Funkcje JSON

MariaDB przechowuje JSON jako tekst (LONGTEXT), ale oferuje funkcje do pracy z nim.

```sql
-- JSON_COMPACT() — minimalizuje JSON (usuwa białe znaki)
SELECT JSON_COMPACT('{ "imie" : "Jan" , "wiek" : 30 }');
-- Wynik: {"imie":"Jan","wiek":30}

-- JSON_DETAILED() — formatuje JSON z wcięciami
SELECT JSON_DETAILED('{"imie":"Jan","wiek":30}');
-- Wynik:
-- {
--     "imie": "Jan",
--     "wiek": 30
-- }

-- JSON_VALUE() — pobierz wartość
SELECT JSON_VALUE('{"imie":"Jan","wiek":30}', '$.imie');
-- Wynik: Jan

-- JSON_OBJECT() — utwórz obiekt JSON
SELECT JSON_OBJECT('imie', 'Jan', 'wiek', 30);
-- Wynik: {"imie": "Jan", "wiek": 30}

-- JSON_ARRAY() — utwórz tablicę JSON
SELECT JSON_ARRAY(1, 2, 3, 'cztery');
-- Wynik: [1, 2, 3, "cztery"]

-- JSON_EXTRACT() — wyciągnij wartość
SELECT JSON_EXTRACT('{"dane": {"wiek": 25}}', '$.dane.wiek');
-- Wynik: 25

-- JSON_SET() — ustaw wartość
SELECT JSON_SET('{"imie":"Jan"}', '$.wiek', 30);
-- Wynik: {"imie": "Jan", "wiek": 30}

-- JSON_VALID() — sprawdź czy poprawny JSON
SELECT JSON_VALID('{"klucz": "wartość"}');  -- 1
SELECT JSON_VALID('niepoprawny');            -- 0

-- Przechowywanie JSON w tabeli
CREATE TABLE konfiguracja (
    id INT AUTO_INCREMENT PRIMARY KEY,
    klucz VARCHAR(100),
    wartosci JSON
);

INSERT INTO konfiguracja (klucz, wartosci)
VALUES ('ustawienia', '{"motyw":"ciemny","jezyk":"pl","czcionka":14}');

SELECT JSON_VALUE(wartosci, '$.motyw') AS motyw
FROM konfiguracja WHERE klucz = 'ustawienia';
```

### Window Functions (MariaDB 10.2+)

Funkcje okienkowe wykonują obliczenia na zestawie wierszy powiązanych z bieżącym wierszem.

```sql
-- ROW_NUMBER() — numer wiersza w partycji
SELECT
    imie,
    dzial,
    pensja,
    ROW_NUMBER() OVER (PARTITION BY dzial ORDER BY pensja DESC) AS miejsce_w_dziale
FROM pracownicy;

-- RANK() — ranga z przerwami przy remisach
SELECT
    imie,
    pensja,
    RANK() OVER (ORDER BY pensja DESC) AS ranga
FROM pracownicy;
-- Przy dwóch takich samych wartościach: 1, 2, 2, 4 (brak 3)

-- DENSE_RANK() — ranga bez przerw
SELECT
    imie,
    pensja,
    DENSE_RANK() OVER (ORDER BY pensja DESC) AS ranga
FROM pracownicy;
-- Przy dwóch takich samych wartościach: 1, 2, 2, 3 (brak przerwy)

-- LAG() i LEAD() — dostęp do poprzedniego/następnego wiersza
SELECT
    data_sprzedazy,
    kwota,
    LAG(kwota, 1, 0) OVER (ORDER BY data_sprzedazy) AS poprzednia_kwota,
    LEAD(kwota, 1, 0) OVER (ORDER BY data_sprzedazy) AS nastepna_kwota
FROM sprzedaz;

-- SUM() jako window function
SELECT
    imie,
    dzial,
    pensja,
    SUM(pensja) OVER (PARTITION BY dzial) AS suma_w_dziale,
    pensja / SUM(pensja) OVER (PARTITION BY dzial) * 100 AS procent_dzialu
FROM pracownicy;

-- FIRST_VALUE() i LAST_VALUE()
SELECT
    imie,
    pensja,
    FIRST_VALUE(imie) OVER (ORDER BY pensja DESC) AS najlepiej_zarabiajacy
FROM pracownicy;

-- NTILE() — podział na N równych grup (np. kwartyle)
SELECT
    imie,
    pensja,
    NTILE(4) OVER (ORDER BY pensja) AS kwartal
FROM pracownicy;
```

### WITH TIES w ORDER BY

```sql
-- Zwróć top 3 + wszystkie remisy na 3. miejscu
SELECT imie, pensja
FROM pracownicy
ORDER BY pensja DESC
LIMIT 3 WITH TIES;
-- Jeśli 3 osoby mają tę samą pensję na 3. miejscu, zwróci wszystkie 3

-- MySQL nie obsługuje WITH TIES
-- MariaDB 10.5.0+ obsługuje WITH TIES
```

### Podpowiedzi indeksów (Index Hints)

```sql
-- USE INDEX — zasugeruj użycie konkretnego indeksu
SELECT * FROM produkty
USE INDEX (idx_cena)
WHERE cena > 100;

-- IGNORE INDEX — pomiń konkretny indeks
SELECT * FROM produkty
IGNORE INDEX (idx_kategoria)
WHERE kategoria = 'Elektronika';

-- FORCE INDEX — wymusz użycie konkretnego indeksu
SELECT * FROM produkty
FORCE INDEX (idx_nazwa)
WHERE nazwa LIKE 'Lap%';

-- Dla JOIN
SELECT p.*, k.nazwa AS kategoria
FROM produkty p
FORCE INDEX (idx_kategoria_id)
JOIN kategorie k ON p.kategoria_id = k.id;
```

### System-Versioned Tables (Temporal Tables) — MariaDB 10.3.4+

```sql
-- Tworzenie tabeli z historią wersji
CREATE TABLE pracownicy (
    id INT PRIMARY KEY AUTO_INCREMENT,
    imie VARCHAR(100),
    pensja DECIMAL(10,2)
) WITH SYSTEM VERSIONING;

-- Automatycznie dodawane kolumny: row_start, row_end (TIMESTAMP)

-- Podgląd historii wiersza
SELECT * FROM pracownicy
FOR SYSTEM_TIME ALL
WHERE id = 1;

-- Stan tabeli w określonym momencie
SELECT * FROM pracownicy
FOR SYSTEM_TIME AS OF '2025-01-01 12:00:00';

-- Stan między datami
SELECT * FROM pracownicy
FOR SYSTEM_TIME BETWEEN '2025-01-01' AND '2025-06-01';
```

---

## 6. Typy danych specyficzne dla MariaDB

### INET6 — adresy IPv6 (MariaDB 10.5+)

Natywny typ danych do przechowywania adresów IPv6 (i IPv4 jako IPv4-mapped IPv6).

```sql
-- Tworzenie tabeli z INET6
CREATE TABLE polaczenia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    adres_ip INET6,
    czas DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Wstawianie adresów
INSERT INTO polaczenia (adres_ip) VALUES
    ('192.168.1.1'),          -- IPv4 (automatycznie konwertowany)
    ('2001:db8::1'),          -- IPv6
    ('::1'),                  -- localhost IPv6
    ('::ffff:192.168.1.1');   -- IPv4-mapped IPv6

-- Pobieranie
SELECT adres_ip FROM polaczenia;

-- Funkcje dla INET6
SELECT INET6_NTOA(adres_ip) FROM polaczenia;  -- binarne → tekstowe
SELECT INET6_ATON('2001:db8::1');             -- tekstowe → binarne

-- Porównywanie
SELECT * FROM polaczenia
WHERE adres_ip = '192.168.1.1';

-- Sprawdzenie czy IPv4 czy IPv6
SELECT adres_ip,
    IS_IPV4_MAPPED(adres_ip) AS jest_ipv4
FROM polaczenia;
```

### UUID — identyfikatory UUID (MariaDB 10.7+)

```sql
-- UUID jako natywny typ danych (nie VARCHAR)
CREATE TABLE dokumenty (
    id UUID PRIMARY KEY DEFAULT UUID(),
    tytul VARCHAR(200),
    tresc TEXT
);

-- UUID przechowywany binarnie (16 bajtów) — wydajniejszy niż VARCHAR(36)
INSERT INTO dokumenty (tytul, tresc)
VALUES ('Umowa', 'Treść umowy...');
-- id zostanie automatycznie wypełnione przez DEFAULT UUID()

-- Wstawianie z ręcznym UUID
INSERT INTO dokumenty (id, tytul)
VALUES (UUID(), 'Faktura');

-- Funkcje UUID
SELECT UUID();              -- generuje nowy UUID v1
SELECT UUID_SHORT();        -- krótszy unikalny identyfikator (64-bit INT)
SELECT SYS_GUID();          -- alias dla UUID() w MariaDB

-- Konwersja UUID
SELECT UUID_TO_BIN('6ccd780c-baba-1026-9564-5b8c656024db');
SELECT BIN_TO_UUID(UUID_TO_BIN(UUID()));
```

### Inne specyficzne typy

```sql
-- MEDIUMINT — 3 bajty, zakres -8388608 do 8388607
CREATE TABLE kategorie (
    id MEDIUMINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nazwa VARCHAR(100)
);

-- ROW — typ złożony (MariaDB 10.3+, używany w procedurach)
DELIMITER //
CREATE PROCEDURE przyklad_row()
BEGIN
    DECLARE rekord ROW(id INT, imie VARCHAR(100));
    SET rekord.id = 1;
    SET rekord.imie = 'Jan';
    SELECT rekord.id, rekord.imie;
END //
DELIMITER ;
```

---

## 7. Instalacja MariaDB

### Linux — Ubuntu/Debian (APT)

```bash
# Aktualizacja listy pakietów
sudo apt update

# Instalacja MariaDB
sudo apt install mariadb-server mariadb-client

# Uruchomienie usługi
sudo systemctl start mariadb
sudo systemctl enable mariadb  # uruchamiaj przy starcie systemu

# Sprawdzenie statusu
sudo systemctl status mariadb

# Bezpieczna konfiguracja po instalacji
sudo mysql_secure_installation
# Pytania:
# - Set root password? → Yes, podaj hasło
# - Remove anonymous users? → Yes
# - Disallow root login remotely? → Yes
# - Remove test database? → Yes
# - Reload privilege tables? → Yes

# Logowanie
mysql -u root -p
# lub (nowszy klient MariaDB)
mariadb -u root -p
```

### Linux — CentOS/RHEL/Rocky Linux (YUM/DNF)

```bash
# CentOS 7 / RHEL 7 (yum)
sudo yum install mariadb-server mariadb

# CentOS 8+ / RHEL 8+ (dnf)
sudo dnf install mariadb-server mariadb

# Uruchomienie
sudo systemctl start mariadb
sudo systemctl enable mariadb

# Bezpieczna konfiguracja
sudo mysql_secure_installation
```

### Windows — instalacja manualna

```
1. Pobierz instalator z https://mariadb.org/download/
2. Uruchom instalator MSI
3. Wybierz komponenty (Server, Client, HeidiSQL)
4. Ustaw hasło root
5. Port: 3306 (domyślny)
6. Zaznacz "Install as service"
7. Kliknij "Install"

Usługa: "MariaDB" w services.msc
Klient CLI: C:\Program Files\MariaDB 11.x\bin\mariadb.exe
```

### XAMPP

```
XAMPP instaluje MariaDB (nie MySQL!) od wersji XAMPP 8.x
- Lokalizacja: /Applications/XAMPP/xamppfiles/var/mysql/ (macOS)
                C:\xampp\mysql\ (Windows)
- Konfiguracja: /Applications/XAMPP/xamppfiles/etc/my.cnf (macOS)
                 C:\xampp\mysql\bin\my.ini (Windows)
- Uruchamianie: Panel XAMPP → przycisk "Start" przy MySQL
- Klient CLI: /Applications/XAMPP/xamppfiles/bin/mysql
- phpMyAdmin: http://localhost/phpmyadmin
```

### MAMP

```
MAMP domyślnie używa MySQL (w wersji MAMP) lub MariaDB (MAMP PRO)
- Lokalizacja danych: /Applications/MAMP/db/mysql/ (macOS)
- Konfiguracja: /Applications/MAMP/conf/my.cnf
- Port: 8889 (domyślny MAMP, różny od standardowego 3306)
- Uruchamianie: Aplikacja MAMP → "Start Servers"
- Klient CLI: /Applications/MAMP/Library/bin/mysql
- phpMyAdmin: http://localhost:8888/phpmyadmin
```

---

## 8. Konfiguracja my.cnf / my.ini

Główny plik konfiguracyjny MariaDB. Lokalizacja zależy od systemu.

### Lokalizacje pliku konfiguracyjnego

| System | Ścieżka |
|--------|---------|
| Linux (główna) | `/etc/mysql/my.cnf` lub `/etc/my.cnf` |
| Linux (dodatkowa) | `/etc/mysql/mariadb.conf.d/*.cnf` |
| Windows | `C:\Program Files\MariaDB\data\my.ini` |
| XAMPP macOS | `/Applications/XAMPP/xamppfiles/etc/my.cnf` |
| MAMP macOS | `/Applications/MAMP/conf/my.cnf` |

### Przykładowy my.cnf z komentarzami

```ini
[mysqld]
# =============================================
# PODSTAWOWE USTAWIENIA
# =============================================

# Port nasłuchiwania
port = 3306

# Adres IP do nasłuchiwania (0.0.0.0 = wszystkie interfejsy)
bind-address = 127.0.0.1

# Katalog danych
datadir = /var/lib/mysql

# Socket (Linux/macOS)
socket = /var/run/mysqld/mysqld.sock

# =============================================
# PAMIĘĆ I WYDAJNOŚĆ
# =============================================

# Bufor InnoDB — ustaw na 70-80% RAM dla serwera dedykowanego
innodb_buffer_pool_size = 512M

# Liczba instancji buforu (dla >1GB buffer_pool)
innodb_buffer_pool_instances = 4

# Bufor dla zapytań (cache wyników)
# UWAGA: deprecated w MySQL 8.0, nadal w MariaDB
query_cache_size = 64M
query_cache_type = 1

# Maksymalna liczba połączeń
max_connections = 151

# Bufor dla każdego wątku
thread_stack = 256K
thread_cache_size = 8

# =============================================
# LOGI
# =============================================

# Ogólny log zapytań (wyłącz na produkcji!)
general_log = 0
general_log_file = /var/log/mysql/mysql.log

# Log wolnych zapytań
slow_query_log = 1
slow_query_log_file = /var/log/mysql/slow.log
long_query_time = 2  # zapytania trwające dłużej niż 2 sekundy

# Log błędów
log_error = /var/log/mysql/error.log

# Log binarny (potrzebny do replikacji)
log_bin = /var/log/mysql/mariadb-bin
binlog_format = ROW  # ROW, STATEMENT, MIXED
expire_logs_days = 7

# =============================================
# INNODB
# =============================================

# Tryb flush (0=raz/sekunde, 1=każdy COMMIT, 2=raz/sekunde do OS)
innodb_flush_log_at_trx_commit = 1  # najbezpieczniejszy

# Tryb flush dla pliku danych
innodb_flush_method = O_DIRECT

# Oddzielne pliki .ibd dla każdej tabeli
innodb_file_per_table = 1

# Rozmiar logu redo
innodb_log_file_size = 256M

# Timeout dla blokad
innodb_lock_wait_timeout = 50

# =============================================
# KODOWANIE ZNAKÓW
# =============================================

character-set-server = utf8mb4
collation-server = utf8mb4_unicode_ci
init_connect = 'SET NAMES utf8mb4'

# =============================================
# BEZPIECZEŃSTWO
# =============================================

# Wyłącz LOCAL INFILE (bezpieczeństwo)
local_infile = 0

# Maksymalny rozmiar pakietu (dla dużych BLOB/TEXT)
max_allowed_packet = 64M

[client]
port = 3306
socket = /var/run/mysqld/mysqld.sock
default-character-set = utf8mb4

[mysql]
no-auto-rehash
default-character-set = utf8mb4
```

### Sprawdzanie zmiennych konfiguracyjnych

```sql
-- Wyświetl wszystkie zmienne
SHOW VARIABLES;

-- Szukaj konkretnej zmiennej
SHOW VARIABLES LIKE 'max_connections';
SHOW VARIABLES LIKE '%innodb%';
SHOW VARIABLES LIKE 'character%';

-- Zmień zmienną w czasie działania (bez restartu)
SET GLOBAL max_connections = 200;
SET GLOBAL slow_query_log = 1;

-- Wyświetl status serwera
SHOW STATUS;
SHOW STATUS LIKE 'Threads_connected';
SHOW STATUS LIKE 'Innodb_buffer_pool%';
```

---

## 9. Zarządzanie użytkownikami

### Tworzenie użytkowników

```sql
-- Utwórz użytkownika lokalnego (tylko z localhost)
CREATE USER 'jan'@'localhost' IDENTIFIED BY 'MocneHaslo123!';

-- Utwórz użytkownika zdalnego (z dowolnego hosta)
CREATE USER 'aplikacja'@'%' IDENTIFIED BY 'HasloAplikacji456!';

-- Utwórz użytkownika z konkretnego IP
CREATE USER 'admin'@'192.168.1.100' IDENTIFIED BY 'AdminHaslo789!';

-- Utwórz użytkownika z limitem połączeń
CREATE USER 'ograniczony'@'localhost'
    IDENTIFIED BY 'Haslo!'
    MAX_CONNECTIONS_PER_HOUR 100
    MAX_QUERIES_PER_HOUR 1000
    MAX_UPDATES_PER_HOUR 500;
```

### GRANT — nadawanie uprawnień

```sql
-- Wszystkie uprawnienia do konkretnej bazy
GRANT ALL PRIVILEGES ON sklep.* TO 'jan'@'localhost';

-- Uprawnienia do odczytu i zapisu
GRANT SELECT, INSERT, UPDATE, DELETE ON sklep.* TO 'aplikacja'@'%';

-- Tylko odczyt (SELECT)
GRANT SELECT ON sklep.* TO 'raportowanie'@'localhost';

-- Uprawnienia do konkretnej tabeli
GRANT SELECT, INSERT ON sklep.produkty TO 'magazynier'@'localhost';

-- Uprawnienia do konkretnej kolumny
GRANT SELECT (imie, nazwisko, email) ON sklep.klienci TO 'kontakt'@'localhost';

-- Uprawnienia globalne (wszystkie bazy)
GRANT ALL PRIVILEGES ON *.* TO 'superadmin'@'localhost' WITH GRANT OPTION;
-- WITH GRANT OPTION = może nadawać uprawnienia innym

-- Uprawnienia do procedur
GRANT EXECUTE ON PROCEDURE sklep.oblicz_rabat TO 'jan'@'localhost';

-- Odśwież uprawnienia (wymagane po zmianach)
FLUSH PRIVILEGES;
```

### REVOKE — odbieranie uprawnień

```sql
-- Odbierz konkretne uprawnienia
REVOKE INSERT, UPDATE ON sklep.* FROM 'aplikacja'@'%';

-- Odbierz wszystkie uprawnienia
REVOKE ALL PRIVILEGES ON sklep.* FROM 'jan'@'localhost';

-- Odbierz GRANT OPTION
REVOKE GRANT OPTION ON *.* FROM 'superadmin'@'localhost';
```

### Zarządzanie hasłami

```sql
-- Zmień hasło użytkownika
ALTER USER 'jan'@'localhost' IDENTIFIED BY 'NoweHaslo999!';

-- Zmień własne hasło
SET PASSWORD = PASSWORD('NoweHaslo999!');

-- Zmień hasło innego użytkownika (starszy sposób)
SET PASSWORD FOR 'jan'@'localhost' = PASSWORD('NoweHaslo999!');
```

### Wyświetlanie i usuwanie użytkowników

```sql
-- Lista użytkowników
SELECT User, Host, Password FROM mysql.user;
-- lub
SELECT User, Host FROM mysql.user ORDER BY User;

-- Sprawdź uprawnienia użytkownika
SHOW GRANTS FOR 'jan'@'localhost';
SHOW GRANTS;  -- własne uprawnienia

-- Usuń użytkownika
DROP USER 'jan'@'localhost';

-- Usuń jeśli istnieje (bez błędu)
DROP USER IF EXISTS 'stary_uzytkownik'@'localhost';
```

### Przykład: typowe role użytkowników dla aplikacji

```sql
-- 1. Użytkownik aplikacji webowej
CREATE USER 'webapp'@'localhost' IDENTIFIED BY 'WebAppPass123!';
GRANT SELECT, INSERT, UPDATE, DELETE ON sklep.* TO 'webapp'@'localhost';

-- 2. Użytkownik do backupów
CREATE USER 'backup_user'@'localhost' IDENTIFIED BY 'BackupPass456!';
GRANT SELECT, LOCK TABLES, SHOW VIEW, EVENT, TRIGGER ON *.* TO 'backup_user'@'localhost';

-- 3. Tylko do odczytu (raporty)
CREATE USER 'reporter'@'192.168.1.0/255.255.255.0' IDENTIFIED BY 'ReportPass789!';
GRANT SELECT ON sklep.* TO 'reporter'@'192.168.1.0/255.255.255.0';

-- 4. Administrator bazy (nie systemu)
CREATE USER 'dba'@'localhost' IDENTIFIED BY 'DbaPass000!';
GRANT ALL PRIVILEGES ON sklep.* TO 'dba'@'localhost' WITH GRANT OPTION;

FLUSH PRIVILEGES;
```

---

## 10. Backup i restore

### mysqldump / mariadb-dump

Od MariaDB 10.4 dostępna jest komenda `mariadb-dump` (alias `mysqldump`).

```bash
# Backup całej bazy danych
mysqldump -u root -p nazwa_bazy > backup_2026-05-16.sql

# Backup z timestamp w nazwie pliku
mysqldump -u root -p sklep > sklep_$(date +%Y%m%d_%H%M%S).sql

# Backup tylko struktury (bez danych)
mysqldump -u root -p --no-data sklep > struktura.sql

# Backup tylko danych (bez struktury)
mysqldump -u root -p --no-create-info sklep > dane.sql

# Backup konkretnych tabel
mysqldump -u root -p sklep produkty klienci zamowienia > wybrane_tabele.sql

# Backup wszystkich baz danych
mysqldump -u root -p --all-databases > wszystkie_bazy.sql

# Backup z kompresją
mysqldump -u root -p sklep | gzip > backup.sql.gz

# Backup z opcjami dla spójności (InnoDB)
mysqldump -u root -p \
    --single-transaction \     # spójny snapshot InnoDB bez locka
    --quick \                  # pobierz wiersze jeden po jednym (mało RAM)
    --lock-tables=false \      # nie blokuj tabel (z --single-transaction)
    --routines \               # dołącz procedury i funkcje
    --triggers \               # dołącz triggery
    --events \                 # dołącz zdarzenia (events)
    sklep > pelny_backup.sql

# Przywróć backup
mysql -u root -p nazwa_bazy < backup.sql

# Przywróć skompresowany backup
gunzip < backup.sql.gz | mysql -u root -p nazwa_bazy

# Przywróć z tworzeniem bazy
mysql -u root -p < wszystkie_bazy.sql
```

### mariabackup (Percona XtraBackup fork)

Narzędzie do fizycznych backupów (kopie plików danych). Idealne dla dużych baz.

```bash
# Instalacja
sudo apt install mariadb-backup

# Pełny backup (hot backup — bez zatrzymywania serwera)
mariabackup --backup \
    --target-dir=/backup/pelny/ \
    --user=backup_user \
    --password=BackupPass456!

# Przygotowanie backupu (prepare — stosuje logi redo)
mariabackup --prepare \
    --target-dir=/backup/pelny/

# Przywracanie (serwer musi być zatrzymany)
sudo systemctl stop mariadb
mariabackup --copy-back \
    --target-dir=/backup/pelny/ \
    --datadir=/var/lib/mysql/
sudo chown -R mysql:mysql /var/lib/mysql/
sudo systemctl start mariadb

# Inkrementalny backup
mariabackup --backup \
    --target-dir=/backup/inkrement_1/ \
    --incremental-basedir=/backup/pelny/ \
    --user=backup_user \
    --password=BackupPass456!
```

### Automatyczny backup (cron)

```bash
# Edytuj crontab
crontab -e

# Backup codziennie o 2:00
0 2 * * * mysqldump -u backup_user -pBackupPass456 --single-transaction --all-databases | gzip > /backup/db_$(date +\%Y\%m\%d).sql.gz

# Usuń backupy starsze niż 30 dni
0 3 * * * find /backup/ -name "*.sql.gz" -mtime +30 -delete
```

---

## 11. Replikacja w MariaDB

### Master-Slave (klasyczna replikacja)

```
Topologia:
  [Master] --binlog--> [Slave 1]
                   \-> [Slave 2]

- Master: obsługuje zapisy
- Slave: obsługuje odczyty (load balancing)
- Replikacja asynchroniczna (może być opóźnienie)
```

```sql
-- === KONFIGURACJA MASTERA ===

-- W my.cnf mastera:
-- [mysqld]
-- server-id = 1
-- log_bin = /var/log/mysql/mysql-bin.log
-- binlog_format = ROW

-- Utwórz użytkownika replikacji
CREATE USER 'replikacja'@'%' IDENTIFIED BY 'ReplPass!';
GRANT REPLICATION SLAVE ON *.* TO 'replikacja'@'%';
FLUSH PRIVILEGES;

-- Sprawdź pozycję binlogu
SHOW MASTER STATUS;
-- Wynik: File = mysql-bin.000001, Position = 154

-- === KONFIGURACJA SLAVE ===

-- W my.cnf slave'a:
-- [mysqld]
-- server-id = 2
-- relay-log = /var/log/mysql/relay-bin

-- Skonfiguruj slave
CHANGE MASTER TO
    MASTER_HOST = '192.168.1.10',
    MASTER_USER = 'replikacja',
    MASTER_PASSWORD = 'ReplPass!',
    MASTER_LOG_FILE = 'mysql-bin.000001',
    MASTER_LOG_POS = 154;

-- Uruchom replikację
START SLAVE;

-- Sprawdź status replikacji
SHOW SLAVE STATUS\G
-- Ważne pola:
-- Slave_IO_Running: Yes
-- Slave_SQL_Running: Yes
-- Seconds_Behind_Master: 0 (brak opóźnienia)
```

### Galera Cluster (Multi-Master)

```
Topologia:
  [Node 1] <--wsrep--> [Node 2] <--wsrep--> [Node 3]

- Każdy węzeł może przyjmować zapisy
- Synchroniczna replikacja (bez opóźnień)
- Minimum 3 węzły (dla kworum)
- Protokół wsrep (Write-Set Replication)
```

```ini
# Konfiguracja w my.cnf (każdy węzeł)
[mysqld]
# Galera Provider
wsrep_on = ON
wsrep_provider = /usr/lib/galera/libgalera_smm.so

# Adres klastra (adresy wszystkich węzłów)
wsrep_cluster_address = gcomm://192.168.1.10,192.168.1.11,192.168.1.12

# Nazwa klastra
wsrep_cluster_name = MojKlaster

# Adres tego węzła
wsrep_node_address = 192.168.1.10

# Nazwa węzła
wsrep_node_name = node1

# Format replikacji (wymagany ROW)
binlog_format = ROW
default_storage_engine = InnoDB
innodb_autoinc_lock_mode = 2
```

```bash
# Uruchomienie nowego klastra (tylko na pierwszym węźle)
galera_new_cluster
# lub
mysqld --wsrep-new-cluster

# Sprawdzenie statusu klastra
mysql -u root -p -e "SHOW STATUS LIKE 'wsrep%';"
# Ważne: wsrep_cluster_size, wsrep_ready
```

---

## 12. Polecenia CLI MariaDB vs MySQL

### Klient wiersza poleceń

```bash
# MySQL (stary sposób — działa też z MariaDB)
mysql -u root -p
mysql -u root -p nazwa_bazy
mysql -u uzytkownik -p -h host -P 3306

# MariaDB (nowa komenda od MariaDB 10.4+)
mariadb -u root -p
mariadb -u root -p nazwa_bazy

# Wykonaj zapytanie bez wchodzenia do konsoli
mysql -u root -p -e "SHOW DATABASES;"
mariadb -u root -p -e "SELECT VERSION();"

# Import pliku SQL
mysql -u root -p nazwa_bazy < plik.sql
mariadb -u root -p nazwa_bazy < plik.sql

# Eksport (mysqldump / mariadb-dump)
mysqldump -u root -p nazwa_bazy > backup.sql
mariadb-dump -u root -p nazwa_bazy > backup.sql  # od MariaDB 10.5+
```

### Przydatne komendy wewnątrz konsoli

```sql
-- Wyświetl bazy danych
SHOW DATABASES;

-- Wybierz bazę
USE nazwa_bazy;

-- Wyświetl tabele
SHOW TABLES;

-- Struktura tabeli
DESCRIBE tabela;
DESC tabela;
SHOW CREATE TABLE tabela;
SHOW COLUMNS FROM tabela;

-- Wyświetl procesy
SHOW PROCESSLIST;
SHOW FULL PROCESSLIST;

-- Zakończ proces
KILL 12345;  -- numer procesu z SHOW PROCESSLIST

-- Status serwera
SHOW STATUS;
SHOW GLOBAL STATUS;

-- Wersja
SELECT VERSION();
SELECT @@VERSION;
SELECT @@GLOBAL.VERSION;

-- Zmienne
SHOW VARIABLES LIKE 'max%';
SET SESSION max_connections = 200;
SET GLOBAL max_connections = 200;

-- Historia zapytań (MariaDB)
\s  -- skrót dla STATUS
\r  -- reconnect
\q  -- quit
\! polecenie_systemowe  -- wykonaj polecenie systemowe
```

### Narzędzia administracyjne

| Narzędzie | MySQL | MariaDB |
|-----------|-------|---------|
| Klient CLI | `mysql` | `mariadb` (alias `mysql`) |
| Dump | `mysqldump` | `mariadb-dump` (alias `mysqldump`) |
| Admin | `mysqladmin` | `mariadb-admin` |
| Import | `mysqlimport` | `mariadb-import` |
| Check | `mysqlcheck` | `mariadb-check` |
| Backup | `mysqldump` | `mariabackup` (nowy) |
| Upgrade | `mysql_upgrade` | `mariadb-upgrade` |

---

## 13. Best practices bezpieczeństwa MariaDB

### Podstawowe zasady

```sql
-- 1. ZAWSZE ustaw hasło dla root
ALTER USER 'root'@'localhost' IDENTIFIED BY 'BardzoMocneHaslo!2026';

-- 2. Usuń anonimowych użytkowników
DELETE FROM mysql.user WHERE User = '';
FLUSH PRIVILEGES;

-- 3. Usuń testową bazę danych
DROP DATABASE IF EXISTS test;

-- 4. Wyłącz zdalne logowanie root
DELETE FROM mysql.user WHERE User = 'root' AND Host != 'localhost';
FLUSH PRIVILEGES;

-- 5. Zasada minimalnych uprawnień (Principle of Least Privilege)
-- Aplikacja webowa NIE potrzebuje ALL PRIVILEGES
-- Daj tylko to, czego potrzebuje:
GRANT SELECT, INSERT, UPDATE, DELETE ON sklep.* TO 'webapp'@'localhost';

-- 6. Ogranicz dostęp sieciowy — bind do localhost
-- W my.cnf: bind-address = 127.0.0.1

-- 7. Używaj SSL/TLS dla połączeń zdalnych
GRANT ALL ON baza.* TO 'user'@'%' REQUIRE SSL;
```

### Sprawdzanie bezpieczeństwa

```sql
-- Sprawdź użytkowników bez haseł
SELECT User, Host, Password FROM mysql.user WHERE Password = '';

-- Sprawdź użytkowników z dostępem z dowolnego hosta
SELECT User, Host FROM mysql.user WHERE Host = '%';

-- Sprawdź uprawnienia
SELECT * FROM information_schema.USER_PRIVILEGES;
SELECT * FROM information_schema.SCHEMA_PRIVILEGES;
SELECT * FROM information_schema.TABLE_PRIVILEGES;

-- Sprawdź czy plugin auth jest bezpieczny
SELECT User, Host, plugin FROM mysql.user;
-- MariaDB używa: mysql_native_password lub ed25519 (bezpieczniejszy)
```

### Konfiguracja bezpieczeństwa (my.cnf)

```ini
[mysqld]
# Wyłącz LOCAL INFILE (zapobiega atakowi odczytu plików)
local_infile = 0

# Wyłącz LOAD DATA INFILE zdalnie
secure_file_priv = /var/lib/mysql-files/

# Ogranicz dostęp sieciowy
bind-address = 127.0.0.1

# Wyłącz symbol linki (symlink attacks)
symbolic-links = 0

# Ustaw umask dla plików danych
# umask = 0640

# Wyłącz stare protokoły uwierzytelniania
# old_passwords = 0
```

---

## 14. Porównanie wersji MariaDB

### Główne wersje i nowości

| Wersja | Rok | Kluczowe nowości |
|--------|-----|-----------------|
| 5.5 | 2012 | Podstawowy fork MySQL 5.5, silnik Aria |
| 10.0 | 2014 | CONNECT engine, replikacja równoległa, global transaction ID |
| 10.1 | 2015 | Galera Cluster wbudowany, szyfrowanie tabel/logów, kompresja InnoDB |
| 10.2 | 2017 | Window functions, CTE (WITH), CHECK constraints, JSON functions |
| 10.3 | 2018 | SEQUENCE, System-Versioned Tables (temporal), PL/SQL kompatybilność |
| 10.4 | 2019 | Ulepszone auth (mysql.global_priv), Instant ADD COLUMN, komendy mariadb-* |
| 10.5 | 2020 | INET6, mariadb-dump, RETURNING, ulepszone EXPLAIN |
| 10.6 | 2021 | Invisible columns, UUID type (planowany), ulepszony InnoDB |
| 10.7 | 2022 | UUID natywny typ, ulepszenia JSON, kompresja |
| 10.8 | 2022 | UUID_TO_BIN ulepszenia, uuid_short() |
| 10.9 | 2022 | Ulepszenia replikacji, nowe opcje szyfrowania |
| 10.10 | 2022 | Ulepszenia wydajności, nowe opcje konfiguracji |
| 10.11 LTS | 2023 | Long Term Support, stabilność, bug fixes |
| 11.0 | 2023 | Nowe numerowanie wersji, porzucenie starych cech |
| 11.1 | 2023 | Ulepszenia optymalizatora, nowe funkcje |
| 11.2 | 2024 | Nowe funkcje JSON, ulepszenia replikacji |
| 11.4 LTS | 2024 | Long Term Support |

### Wersje LTS (Long Term Support)

- **MariaDB 10.6 LTS** — wsparcie do 2026
- **MariaDB 10.11 LTS** — wsparcie do 2028
- **MariaDB 11.4 LTS** — wsparcie do 2029

### Sprawdzanie wersji

```sql
-- Sprawdź wersję MariaDB / MySQL
SELECT VERSION();
-- Wynik np.: 10.11.4-MariaDB lub 8.0.35

SELECT @@VERSION;
SELECT @@GLOBAL.version;

-- Szczegółowe informacje o wersji
SHOW VARIABLES LIKE 'version%';
-- version: 10.11.4-MariaDB
-- version_comment: mariadb.org binary distribution
-- version_compile_os: Linux
```

---

## 15. XAMPP i MAMP — wersje i sprawdzanie

### XAMPP

```
XAMPP (X-Apache-MySQL-PHP-Perl) od wersji 8.x używa MariaDB zamiast MySQL.

Lokalizacje:
- Windows:   C:\xampp\mysql\
- Linux:     /opt/lampp/
- macOS:     /Applications/XAMPP/xamppfiles/

Domyślna wersja MariaDB w XAMPP:
- XAMPP 8.0.x → MariaDB 10.4.x
- XAMPP 8.1.x → MariaDB 10.4.x
- XAMPP 8.2.x → MariaDB 10.4.x

Port: 3306 (domyślny)
Root bez hasła (domyślnie) → NIEBEZPIECZNE na produkcji!
```

### MAMP

```
MAMP (macOS/Windows) — Mac-Apache-MySQL-PHP
MAMP (bezpłatny): MySQL
MAMP PRO: możliwość wyboru MariaDB lub MySQL

Lokalizacje (macOS):
- Dane:        /Applications/MAMP/db/mysql/
- Konfiguracja: /Applications/MAMP/conf/my.cnf
- Binaria:     /Applications/MAMP/Library/bin/

Port domyślny: 8889 (MySQL) — INNY niż standardowy 3306!
phpMyAdmin: http://localhost:8888/phpmyadmin
```

### Sprawdzanie wersji

```sql
-- Sprawdź wersję z poziomu SQL
SELECT VERSION();

-- Przykładowe wyniki:
-- MySQL:   8.0.35
-- MariaDB: 10.11.4-MariaDB
-- MAMP:    8.0.35 (MySQL)
-- XAMPP:   10.4.32-MariaDB

-- Sprawdź pełne informacje
SHOW VARIABLES LIKE 'version%';
```

```bash
# Z linii poleceń
mysql --version
mariadb --version

# XAMPP (Windows)
C:\xampp\mysql\bin\mysql --version

# XAMPP (macOS)
/Applications/XAMPP/xamppfiles/bin/mysql --version

# MAMP (macOS)
/Applications/MAMP/Library/bin/mysql --version
```

### Uruchamianie MariaDB/MySQL z CLI w XAMPP/MAMP

```bash
# XAMPP (macOS) — dodaj do PATH lub użyj pełnej ścieżki
/Applications/XAMPP/xamppfiles/bin/mysql -u root

# MAMP (macOS) — port 8889!
/Applications/MAMP/Library/bin/mysql -u root -p --port=8889

# XAMPP (Windows)
C:\xampp\mysql\bin\mysql.exe -u root

# Lub dodaj do PATH systemu Windows:
# C:\xampp\mysql\bin
```

### Typowe problemy z XAMPP/MAMP

| Problem | Rozwiązanie |
|---------|-------------|
| Port zajęty (3306) | Zmień port w my.cnf lub zatrzymaj inną instancję MySQL |
| MAMP używa portu 8889 | Podaj `--port=8889` w CLI lub zmień w ustawieniach MAMP |
| Brak hasła root XAMPP | Ustaw przez phpMyAdmin lub mysql -u root -e "ALTER USER..." |
| "Can't connect to MySQL server" | Sprawdź czy usługa działa, sprawdź port, sprawdź bind-address |
| Konflikt XAMPP i MAMP | Nie uruchamiaj obu jednocześnie — konflikt portów |

---

## Podsumowanie — Kluczowe informacje na egzamin

| Temat | Ważna informacja |
|-------|-----------------|
| Fork | MariaDB = fork MySQL 5.1, stworzony przez Monty Wideniusa w 2009 |
| Licencja | MariaDB — w 100% GPL; MySQL — GPL + komercyjna (Oracle) |
| Silnik domyślny | InnoDB (w MariaDB i MySQL) |
| Aria | Silnik MariaDB — crash-safe zastępca MyISAM dla tabel systemowych |
| Transakcje | Tylko InnoDB (i Aria opcjonalnie) obsługują transakcje |
| FK | Tylko InnoDB obsługuje klucze obce w MariaDB |
| SEQUENCE | MariaDB 10.3+, MySQL nie ma |
| Window Functions | MariaDB 10.2+, MySQL 8.0+ |
| INET6 | MariaDB 10.5+ — natywny typ dla IPv6 |
| UUID | MariaDB 10.7+ — natywny typ UUID |
| Galera | Wbudowany w MariaDB, zewnętrzny w MySQL |
| Spider | Sharding — tylko MariaDB |
| CONNECT | Zewnętrzne źródła danych — tylko MariaDB |
| Wersja | `SELECT VERSION();` lub `SELECT @@VERSION;` |
| Klient | `mariadb` (nowy) lub `mysql` (kompatybilny) |
| MAMP port | 8889 (domyślny MAMP, nie 3306!) |
