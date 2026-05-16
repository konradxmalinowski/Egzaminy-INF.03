# SCIAGAWKA: MYSQL/MARIADB - ZARZADZANIE, UZYTKOWNICY, BACKUP (INF.03.4)

---

## 1. ZARZADZANIE UZYTKOWNIKAMI MYSQL

### Tworzenie uzytkownikow

```sql
-- Podstawowa skladnia:
CREATE USER 'nazwa'@'host' IDENTIFIED BY 'haslo';

-- Uzytkownik tylko z localhost (bezpieczniejszy):
CREATE USER 'jan'@'localhost' IDENTIFIED BY 'Haslo123!';

-- Uzytkownik z dowolnego hosta (produkcja - UWAZAJ!):
CREATE USER 'app_user'@'%' IDENTIFIED BY 'Trudne_Haslo_456!';

-- Uzytkownik z konkretnego IP:
CREATE USER 'developer'@'192.168.1.100' IDENTIFIED BY 'Dev_pass789!';

-- Sprawdzenie uzytkownikow:
SELECT user, host FROM mysql.user;
-- lub:
SHOW GRANTS FOR 'jan'@'localhost';
```

### Usuwanie uzytkownikow

```sql
-- Usuniecie uzytkownika:
DROP USER 'jan'@'localhost';

-- Usuniecie jesli istnieje (MySQL 5.7+):
DROP USER IF EXISTS 'jan'@'localhost';

-- Usuniecie wielu naraz:
DROP USER 'user1'@'localhost', 'user2'@'%';
```

### Modyfikacja uzytkownikow

```sql
-- Zmiana hasla:
ALTER USER 'jan'@'localhost' IDENTIFIED BY 'NoweHaslo123!';

-- Alternatywna metoda (starsza):
SET PASSWORD FOR 'jan'@'localhost' = PASSWORD('NoweHaslo');

-- Zmiana nazwy uzytkownika:
RENAME USER 'stara_nazwa'@'localhost' TO 'nowa_nazwa'@'localhost';

-- Blokowanie konta:
ALTER USER 'jan'@'localhost' ACCOUNT LOCK;

-- Odblokowanie konta:
ALTER USER 'jan'@'localhost' ACCOUNT UNLOCK;

-- Wygasanie hasla:
ALTER USER 'jan'@'localhost' PASSWORD EXPIRE INTERVAL 90 DAY;
ALTER USER 'jan'@'localhost' PASSWORD EXPIRE NEVER;
```

---

## 2. UPRAWNIENIA MYSQL (GRANTS)

### Nadawanie uprawnien

```sql
-- Pelne uprawnienia do konkretnej bazy:
GRANT ALL PRIVILEGES ON sklep.* TO 'jan'@'localhost';

-- Pelne uprawnienia do wszystkich baz (UWAZAJ - admin!):
GRANT ALL PRIVILEGES ON *.* TO 'admin'@'localhost' WITH GRANT OPTION;

-- Tylko odczyt (SELECT):
GRANT SELECT ON sklep.* TO 'raport_user'@'localhost';

-- Kilka uprawnien:
GRANT SELECT, INSERT, UPDATE, DELETE ON sklep.* TO 'app_user'@'localhost';

-- Uprawnienia do konkretnej tabeli:
GRANT SELECT, INSERT ON sklep.produkty TO 'pracownik'@'localhost';

-- Uprawnienia do konkretnej kolumny:
GRANT SELECT (id, nazwa, cena) ON sklep.produkty TO 'czytelnik'@'localhost';
GRANT UPDATE (cena, stock) ON sklep.produkty TO 'magazynier'@'localhost';

-- Odswiezenie uprawnien (WAZNE po kazdym GRANT/REVOKE):
FLUSH PRIVILEGES;
```

### Sprawdzanie uprawnien

```sql
-- Uprawnienia biezacego uzytkownika:
SHOW GRANTS;

-- Uprawnienia konkretnego uzytkownika:
SHOW GRANTS FOR 'jan'@'localhost';

-- Uprawnienia w tabeli systemowej:
SELECT * FROM information_schema.USER_PRIVILEGES
WHERE GRANTEE = "'jan'@'localhost'";
```

### Odbieranie uprawnien

```sql
-- Odebranie konkretnych uprawnien:
REVOKE INSERT, UPDATE ON sklep.* FROM 'app_user'@'localhost';

-- Odebranie wszystkich uprawnien do bazy:
REVOKE ALL PRIVILEGES ON sklep.* FROM 'jan'@'localhost';

-- Odebranie wszystkich uprawnien globalnych:
REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'jan'@'localhost';

FLUSH PRIVILEGES;
```

### Tabela uprawnien MySQL

| Uprawnienie | Opis | Poziom |
|-------------|------|--------|
| `ALL PRIVILEGES` | Wszystkie uprawnienia (nie wlacza GRANT OPTION) | Global, DB, Table |
| `SELECT` | Odczyt danych (SELECT) | Global, DB, Table, Column |
| `INSERT` | Wstawianie danych | Global, DB, Table, Column |
| `UPDATE` | Modyfikacja danych | Global, DB, Table, Column |
| `DELETE` | Usuwanie danych | Global, DB, Table |
| `CREATE` | Tworzenie tabel i baz | Global, DB, Table |
| `DROP` | Usuwanie tabel i baz | Global, DB, Table |
| `ALTER` | Modyfikacja struktury tabel | Global, DB, Table |
| `INDEX` | Tworzenie i usuwanie indeksow | Global, DB, Table |
| `CREATE VIEW` | Tworzenie widokow | Global, DB |
| `SHOW VIEW` | Wyswietlanie widokow | Global, DB |
| `CREATE ROUTINE` | Tworzenie procedur i funkcji | Global, DB |
| `ALTER ROUTINE` | Modyfikacja procedur | Global, DB |
| `EXECUTE` | Wykonywanie procedur | Global, DB |
| `TRIGGER` | Tworzenie i usuwanie triggery | Global, DB, Table |
| `EVENT` | Tworzenie zdarzen | Global, DB |
| `REFERENCES` | Tworzenie kluczy obcych | Global, DB, Table, Column |
| `LOCK TABLES` | Blokowanie tabel | Global, DB |
| `RELOAD` | FLUSH PRIVILEGES, LOGS | Global |
| `SUPER` | Uprawnienia administratora | Global |
| `GRANT OPTION` | Mozliwosc nadawania uprawnien | Global, DB, Table |
| `REPLICATION SLAVE` | Replikacja | Global |
| `FILE` | Import/eksport plikow | Global |

### Typowe zestawy uprawnien

```sql
-- Uzytkownik aplikacji webowej (CRUD):
GRANT SELECT, INSERT, UPDATE, DELETE ON baza_app.* TO 'webapp'@'localhost';

-- Administrator bazy (bez dostępu do other baz):
GRANT ALL PRIVILEGES ON moja_baza.* TO 'dba'@'localhost';

-- Uzytkownik raportowy (tylko odczyt):
GRANT SELECT ON baza_prod.* TO 'raporty'@'10.0.0.5';

-- Deweloper (wszystko oprocz DROP):
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, ALTER, INDEX ON dev_db.* TO 'developer'@'localhost';
```

---

## 3. BACKUP I RESTORE

### mysqldump - Eksport (backup)

```bash
# Podstawowy backup jednej bazy:
mysqldump -u root -p nazwa_bazy > backup.sql

# Backup z haslem w linii (UWAZAJ - haslo widoczne w historii!):
mysqldump -u root -p"haslo" nazwa_bazy > backup.sql

# Backup wielu baz:
mysqldump -u root -p --databases baza1 baza2 baza3 > multi_backup.sql

# Backup wszystkich baz:
mysqldump -u root -p --all-databases > full_backup.sql

# Backup tylko struktury (bez danych):
mysqldump -u root -p --no-data nazwa_bazy > struktura.sql

# Backup tylko danych (bez struktury):
mysqldump -u root -p --no-create-info nazwa_bazy > dane.sql

# Backup konkretnej tabeli:
mysqldump -u root -p nazwa_bazy nazwa_tabeli > tabela.sql

# Backup z kompresja:
mysqldump -u root -p nazwa_bazy | gzip > backup_$(date +%Y%m%d).sql.gz

# Backup z opcjami:
mysqldump -u root -p \
    --single-transaction \       # Transakcja (spójnosc dla InnoDB)
    --routines \                 # Wlacza procedury i funkcje
    --triggers \                 # Wlacza triggery
    --events \                   # Wlacza zdarzenia
    --add-drop-table \           # DROP TABLE IF EXISTS przed CREATE
    nazwa_bazy > pelny_backup.sql
```

### Restore (Przywracanie z backupu)

```bash
# Import do bazy (baza musi istniecs!):
mysql -u root -p nazwa_bazy < backup.sql

# Tworzenie bazy i import:
mysql -u root -p -e "CREATE DATABASE nowa_baza CHARACTER SET utf8mb4;"
mysql -u root -p nowa_baza < backup.sql

# Import skompresowanego pliku:
gunzip < backup.sql.gz | mysql -u root -p nazwa_bazy

# Import z postepem (duze pliki):
pv backup.sql | mysql -u root -p nazwa_bazy

# Import przez heredoc (w MySQL shell):
mysql -u root -p
  > USE nazwa_bazy;
  > SOURCE /sciezka/do/backup.sql;
  > EXIT;
```

### Backup automatyczny (cron)

```bash
# Crontab: backup codziennie o 2:00 w nocy
0 2 * * * mysqldump -u root -p"haslo" --all-databases | gzip > /backups/backup_$(date +\%Y\%m\%d).sql.gz

# Usuwanie backupow starszych niz 30 dni:
0 3 * * * find /backups -name "*.sql.gz" -mtime +30 -delete
```

---

## 4. PHPYMYADMIN - PANEL ADMINISTRACYJNY

### Dostep

```
URL:     http://localhost/phpmyadmin  (MAMP/XAMPP)
         http://localhost:8080/phpmyadmin
Login:   root (domyslnie)
Haslo:   (puste domyslnie lub "root")
```

### Glowne funkcje panelu

#### Zarzadzanie bazami

| Akcja | Gdzie w phpMyAdmin |
|-------|-------------------|
| Tworzenie bazy | Glowna strona → "Nowa" lub SQL: `CREATE DATABASE` |
| Usuniecie bazy | Wybierz baze → Operacje → Usun baze |
| Zmiana collation | Operacje → Sortowanie (utf8mb4_unicode_ci) |

#### Tworzenie tabel przez phpMyAdmin

1. Wybierz baze z lewego panelu
2. Kliknij "Nowa" (lub wpisz nazwe tabeli)
3. Podaj nazwe tabeli i liczbe kolumn
4. Dla kazdej kolumny ustaw:
   - Nazwa kolumny
   - Typ danych (INT, VARCHAR, TEXT itd.)
   - Dlugosc (np. 255 dla VARCHAR)
   - Domyslna wartosc
   - Null / Not Null
   - A_I (Auto Increment) - zaznacz dla PK
   - Indeks: PRIMARY (dla klucza glownego)
5. Kliknij "Zapisz"

#### Tworzenie relacji (FK) przez phpMyAdmin

1. Wybierz tabele
2. Zakladka "Struktura"
3. Na dole: "Widok relacji"
4. Dla kolumny FK wybierz:
   - Tabela referencyjna
   - Kolumna referencyjna
   - ON DELETE: CASCADE / SET NULL / RESTRICT
   - ON UPDATE: CASCADE / SET NULL / RESTRICT
5. Zapisz

> **Warunek:** Silnik tabeli musi byc **InnoDB** (nie MyISAM)!

#### Import i Eksport

**Eksport (backup przez phpMyAdmin):**
1. Wybierz baze lub tabele
2. Zakladka "Eksport"
3. Metoda: Szybka lub Niestandardowa
4. Format: SQL (domyslnie), CSV, Excel, XML
5. Opcje SQL:
   - Dodaj DROP TABLE: zaznacz
   - Dodaj CREATE DATABASE: zaznacz
   - Kompresja: None / gzip / zip
6. Kliknij "Uruchom"

**Import:**
1. Wybierz baze docelowa
2. Zakladka "Import"
3. Wybierz plik (.sql, .sql.gz, .zip)
4. Format: SQL (auto-detect)
5. Kodowanie: UTF-8
6. Kliknij "Uruchom"

#### Zarzadzanie uzytkownikami w phpMyAdmin

1. Glowna strona → "Konta uzytkownikow"
2. Dodaj nowego uzytkownika: wpisz dane, wybierz przywileje
3. Edycja: kliknij "Edytuj przywileje" przy uzytkowniku
4. Przywileje globalne vs. przywileje dla bazy

#### Wykonywanie SQL

1. Wybierz baze
2. Zakladka "SQL"
3. Wpisz zapytanie
4. Kliknij "Uruchom"

---

## 5. OPTYMALIZACJA MYSQL

### EXPLAIN - analiza zapytan

```sql
-- Analiza planu wykonania zapytania:
EXPLAIN SELECT * FROM produkty WHERE kategoria_id = 5;

-- Wynik EXPLAIN:
+----+-------------+----------+------+---------------+------+---------+------+--------+-------------+
| id | select_type | table    | type | possible_keys | key  | key_len | ref  | rows   | Extra       |
+----+-------------+----------+------+---------------+------+---------+------+--------+-------------+
|  1 | SIMPLE      | produkty | ALL  | NULL          | NULL | NULL    | NULL |  50000 | Using where |
+----+-------------+----------+------+---------------+------+---------+------+--------+-------------+
-- type=ALL = full table scan = ZLE! Potrzeba indeksu

-- Po dodaniu indeksu:
EXPLAIN SELECT * FROM produkty WHERE kategoria_id = 5;
-- type=ref = uzycie indeksu = DOBRZE!

-- EXPLAIN EXTENDED (wiecej informacji):
EXPLAIN EXTENDED SELECT ...;
SHOW WARNINGS;

-- EXPLAIN FORMAT=JSON (MySQL 5.6+):
EXPLAIN FORMAT=JSON SELECT ...;
```

### Typy w kolumnie `type` EXPLAIN (od najlepszego)

| Type | Opis | Ocena |
|------|------|-------|
| `system` | Tabela z 1 wierszem | Najlepszy |
| `const` | Dokladnie 1 wynik (PK lub UNIQUE = stala) | Doskonaly |
| `eq_ref` | JOIN z unikalnym kluczem | Bardzo dobry |
| `ref` | Indeks niezunikalny | Dobry |
| `range` | Skan zakresu indeksu (BETWEEN, >, <) | OK |
| `index` | Pelny skan indeksu | Akceptowalny |
| `ALL` | Pelny skan tabeli (full table scan) | Najgorszy! |

### Indeksy - kiedy i jak stosowac

```sql
-- Tworzenie indeksu:
CREATE INDEX idx_nazwa ON tabela(kolumna);
CREATE INDEX idx_zlozony ON tabela(kolumna1, kolumna2);  -- indeks zlozony
CREATE UNIQUE INDEX idx_email ON klienci(email);

-- Tworzenie indeksu przy tworzeniu tabeli:
CREATE TABLE produkty (
    id INT AUTO_INCREMENT PRIMARY KEY,          -- PRIMARY KEY = automatyczny indeks
    nazwa VARCHAR(200) NOT NULL,
    cena DECIMAL(10,2),
    id_kategorii INT,
    INDEX idx_cena (cena),                      -- indeks dla filtrow ceny
    INDEX idx_kategoria (id_kategorii),         -- indeks FK
    FULLTEXT idx_szukaj (nazwa)                 -- full-text search
);

-- Wyswietlenie indeksow:
SHOW INDEX FROM produkty;

-- Usuniecie indeksu:
DROP INDEX idx_nazwa ON produkty;
ALTER TABLE produkty DROP INDEX idx_nazwa;

-- Kiedy indeksy SĄ przydatne:
-- - Kolumny w WHERE, JOIN, ORDER BY, GROUP BY
-- - Kolumny FK
-- - Kolumny czesto przeszukiwane

-- Kiedy indeksy NIE SA przydatne:
-- - Tabele z malą liczba wierszy
-- - Kolumny rzadko uzywane w filtrach
-- - Kolumny z malą kardynalnoscia (np. plec M/K)
-- - Intensywny INSERT/UPDATE/DELETE (indeksy spowalniaja zapis!)
```

### ANALYZE TABLE i OPTIMIZE TABLE

```sql
-- Aktualizacja statystyk tabeli (MySQL uzywa do planowania zapytan):
ANALYZE TABLE produkty;
ANALYZE TABLE klienci, zamowienia, produkty;

-- Defragmentacja i optymalizacja tabeli InnoDB:
OPTIMIZE TABLE produkty;

-- Sprawdzenie tabeli na bledy:
CHECK TABLE produkty;

-- Naprawa tabeli (glownie MyISAM):
REPAIR TABLE produkty;
```

### Slow Query Log - wykrywanie wolnych zapytan

```sql
-- Wlaczenie slow query log:
SET GLOBAL slow_query_log = 'ON';
SET GLOBAL long_query_time = 1;     -- zapytania > 1 sekunda
SET GLOBAL slow_query_log_file = '/var/log/mysql/slow.log';

-- Sprawdzenie konfiguracji:
SHOW VARIABLES LIKE 'slow_query%';
SHOW VARIABLES LIKE 'long_query_time';
```

---

## 6. KONFIGURACJA MYSQL (my.cnf / my.ini)

### Lokalizacja pliku konfiguracyjnego

```
Linux:   /etc/mysql/mysql.conf.d/mysqld.cnf
         /etc/my.cnf
macOS (MAMP): /Applications/MAMP/conf/mysql/my.cnf
Windows: C:\ProgramData\MySQL\MySQL Server X.X\my.ini
         C:\MAMP\conf\mysql\my.cnf
```

### Kluczowe parametry my.cnf

```ini
[mysqld]
# === PODSTAWOWE ===
port            = 3306          # Port MySQL
datadir         = /var/lib/mysql # Katalog danych
socket          = /var/run/mysqld/mysqld.sock

# === KODOWANIE (WAZNE!) ===
character-set-server  = utf8mb4
collation-server      = utf8mb4_unicode_ci
character_set_client  = utf8mb4

# === BUFOR InnoDB ===
innodb_buffer_pool_size = 256M  # 50-80% dostepnej RAM
innodb_log_file_size    = 64M

# === POLACZENIA ===
max_connections         = 151   # Max jednoczesnych polaczen
wait_timeout            = 28800 # Timeout w sekundach
connect_timeout         = 10

# === LOGI ===
general_log             = 0     # 0=off, 1=on (loguje wszystko - wolne!)
general_log_file        = /var/log/mysql/general.log
slow_query_log          = 1
slow_query_log_file     = /var/log/mysql/slow.log
long_query_time         = 2

# === ROZMIARY ===
max_allowed_packet      = 64M   # Maks rozmiar pakietu (wazne dla duzych BLOB)
tmp_table_size          = 32M
max_heap_table_size     = 32M

[client]
port                    = 3306
default-character-set   = utf8mb4
```

### Sprawdzanie konfiguracji z poziomu MySQL

```sql
-- Wszystkie zmienne:
SHOW VARIABLES;

-- Konkretna zmienna:
SHOW VARIABLES LIKE 'character%';
SHOW VARIABLES LIKE 'max_connections';
SHOW VARIABLES LIKE 'innodb%';

-- Zmiana zmiennej dynamicznie (bez restartu):
SET GLOBAL max_connections = 200;
SET GLOBAL innodb_buffer_pool_size = 536870912;  -- 512MB w bajtach

-- Sprawdzenie statusu:
SHOW STATUS;
SHOW STATUS LIKE 'Threads_connected';
SHOW STATUS LIKE 'Slow_queries';
```

---

## 7. MARIADB VS MYSQL - ROZNICE

### Historia

- **MySQL**: Stworzony 1995 przez Michael Widenius. Kupiony przez Sun (2008), potem Oracle (2010).
- **MariaDB**: Fork MySQL stworzony w 2009 przez Michaela Wideniusa po przejęciu przez Oracle. Nazwa pochodzi od corki Marii.

### Kompatybilnosc

- MariaDB jest w **wiekszosci kompatybilna z MySQL**
- Wiekszosc kodu SQL dziala tak samo
- Mariadb dala kompatybilnosc drop-in replacement dla wielu wersji

### Kluczowe roznice

| Cecha | MySQL | MariaDB |
|-------|-------|---------|
| Licencja | GPL (Community) + proprietary (Enterprise) | GPL (zawsze open source) |
| Wersjonowanie | 8.0, 8.4, 9.x | 10.x, 11.x |
| JSON | Natywny typ JSON | JSON jako alias LONGTEXT (MariaDB 10.x), natywny od 11.x |
| Virtual columns | Tak | Tak (wczesniej wprowadzone) |
| Window Functions | Od 8.0 | Od 10.2 |
| Sekwencje | Nie | Tak (CREATE SEQUENCE) |
| IGNORE INDEX | Tak | Tak |
| Silnik ARIA | Nie | Tak (zastepnik MyISAM) |
| Silnik ColumnStore | Nie | Tak (analityczny) |
| Performance | InnoDB zoptymalizowane przez Oracle | Wlasne optymalizacje |
| SHOW ENGINE INNODB STATUS | Bardziej szczegolow | Standardowy |

### Sprawdzenie wersji

```sql
SELECT VERSION();
-- MySQL:   "8.0.35"
-- MariaDB: "10.11.4-MariaDB"
```

---

## 8. SILNIKI TABEL (STORAGE ENGINES)

### InnoDB vs MyISAM vs ARIA

| Cecha | InnoDB | MyISAM | ARIA (MariaDB) |
|-------|--------|--------|----------------|
| **Transakcje** | TAK (ACID) | NIE | Czesciowo |
| **Klucze obce (FK)** | TAK | NIE | NIE |
| **Row locking** | TAK | NIE (table lock) | TAK |
| **FULLTEXT search** | TAK (od MySQL 5.6) | TAK | TAK |
| **Crash recovery** | TAK | NIE | TAK |
| **Cache** | Buffer Pool | Key Cache | Pagecache |
| **Pliki** | .ibd | .MYD, .MYI, .frm | .MAD, .MAI |
| **Szybkosc READ** | Dobra | Bardzo dobra | Dobra |
| **Szybkosc WRITE** | Dobra | Wolniejsza (lock tabeli) | Dobra |
| **Kiedy uzywac** | Domyslnie, relacje, FK | Legacy, archiwum | MariaDB zamiast MyISAM |

### Zmiana silnika tabeli

```sql
-- Sprawdzenie silnika:
SHOW TABLE STATUS LIKE 'produkty';
-- lub:
SELECT ENGINE FROM information_schema.TABLES
WHERE TABLE_NAME = 'produkty' AND TABLE_SCHEMA = 'baza';

-- Zmiana silnika:
ALTER TABLE produkty ENGINE = InnoDB;
ALTER TABLE stara_tabela ENGINE = MyISAM;

-- Tworzenie z silnikiem:
CREATE TABLE nowa_tabela (
    id INT PRIMARY KEY
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
```

### Inne silniki

| Silnik | Opis |
|--------|------|
| `MEMORY` | Tabela w pamieci RAM (dane tracone po restarcie) |
| `CSV` | Dane w pliku CSV |
| `ARCHIVE` | Kompresja danych, tylko SELECT/INSERT |
| `BLACKHOLE` | Dane sa ignorowane (replikacja) |
| `FEDERATED` | Dostep do zdalnych tabel MySQL |

---

## 9. PROCEDURY SKLADOWANE (STORED PROCEDURES)

### Tworzenie procedury

```sql
-- Zmiana delimitera (konieczne, bo ; konczyloby procedure przedwczesnie):
DELIMITER //

CREATE PROCEDURE DodajKlienta(
    IN p_imie VARCHAR(50),
    IN p_nazwisko VARCHAR(50),
    IN p_email VARCHAR(100),
    OUT p_id INT
)
BEGIN
    INSERT INTO klienci (imie, nazwisko, email)
    VALUES (p_imie, p_nazwisko, p_email);
    
    SET p_id = LAST_INSERT_ID();
END //

DELIMITER ;

-- Wywolanie procedury:
CALL DodajKlienta('Jan', 'Kowalski', 'jan@example.com', @nowe_id);
SELECT @nowe_id;
```

### Procedura z blokadami i warunkami

```sql
DELIMITER //

CREATE PROCEDURE AktualizujStanMagazynu(
    IN p_id_produktu INT,
    IN p_ilosc INT
)
BEGIN
    DECLARE v_aktualny_stan INT;
    
    SELECT stock INTO v_aktualny_stan
    FROM produkty
    WHERE id = p_id_produktu;
    
    IF v_aktualny_stan >= p_ilosc THEN
        UPDATE produkty
        SET stock = stock - p_ilosc
        WHERE id = p_id_produktu;
        SELECT 'Sukces - stan zaktualizowany' AS wynik;
    ELSE
        SELECT 'Blad - niewystarczajacy stan magazynowy' AS wynik;
    END IF;
END //

DELIMITER ;

-- Zarzadzanie procedurami:
SHOW PROCEDURE STATUS WHERE Db = 'sklep';
SHOW CREATE PROCEDURE DodajKlienta;
DROP PROCEDURE IF EXISTS DodajKlienta;
```

---

## 10. TRIGGERY (WYZWALACZE)

### Typy triggery

| Typ | Kiedy sie uruchamia |
|-----|---------------------|
| `BEFORE INSERT` | Przed wstawieniem wiersza |
| `AFTER INSERT` | Po wstawieniu wiersza |
| `BEFORE UPDATE` | Przed aktualizacja wiersza |
| `AFTER UPDATE` | Po aktualizacji wiersza |
| `BEFORE DELETE` | Przed usunieciem wiersza |
| `AFTER DELETE` | Po usunieciu wiersza |

### Przyklady triggery

```sql
-- Trigger: loguj każdą zmiane ceny produktu
DELIMITER //

CREATE TRIGGER log_zmiana_ceny
    AFTER UPDATE ON produkty
    FOR EACH ROW
BEGIN
    IF OLD.cena != NEW.cena THEN
        INSERT INTO log_cen (id_produktu, stara_cena, nowa_cena, data_zmiany)
        VALUES (OLD.id, OLD.cena, NEW.cena, NOW());
    END IF;
END //

DELIMITER ;

-- Trigger: aktualizuj liczbe produktow w kategorii
DELIMITER //

CREATE TRIGGER update_count_after_insert
    AFTER INSERT ON produkty
    FOR EACH ROW
BEGIN
    UPDATE kategorie
    SET liczba_produktow = liczba_produktow + 1
    WHERE id = NEW.id_kategorii;
END //

CREATE TRIGGER update_count_after_delete
    AFTER DELETE ON produkty
    FOR EACH ROW
BEGIN
    UPDATE kategorie
    SET liczba_produktow = liczba_produktow - 1
    WHERE id = OLD.id_kategorii;
END //

DELIMITER ;

-- Zarzadzanie triggerami:
SHOW TRIGGERS FROM sklep;
SHOW TRIGGERS LIKE 'log%';
DROP TRIGGER IF EXISTS log_zmiana_ceny;
```

### OLD i NEW w triggerach

```sql
-- OLD.kolumna = wartosc PRZED zmiana (dostepne w UPDATE i DELETE)
-- NEW.kolumna = wartosc PO zmianie (dostepne w INSERT i UPDATE)

-- Przyklad: walidacja przed insertem (BEFORE INSERT):
DELIMITER //
CREATE TRIGGER sprawdz_cene
    BEFORE INSERT ON produkty
    FOR EACH ROW
BEGIN
    IF NEW.cena < 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Cena nie moze byc ujemna!';
    END IF;
END //
DELIMITER ;
```

---

## 11. WIDOKI (VIEWS)

```sql
-- Tworzenie widoku:
CREATE VIEW v_produkty_z_kategoria AS
    SELECT p.id, p.nazwa, p.cena, k.nazwa AS kategoria
    FROM produkty p
    LEFT JOIN kategorie k ON p.id_kategorii = k.id;

-- Uzycie widoku jak tabeli:
SELECT * FROM v_produkty_z_kategoria WHERE cena > 100;

-- Aktualizacja widoku:
CREATE OR REPLACE VIEW v_produkty_z_kategoria AS ...;

-- Usuniecie widoku:
DROP VIEW IF EXISTS v_produkty_z_kategoria;

-- Wyswietlenie widokow:
SHOW FULL TABLES WHERE Table_type = 'VIEW';
SHOW CREATE VIEW v_produkty_z_kategoria;
```

---

## 12. TRANSAKCJE

```sql
-- Transakcja podstawowa:
START TRANSACTION;
-- lub:
BEGIN;

INSERT INTO klienci (imie, email) VALUES ('Jan', 'jan@test.com');
UPDATE konta SET saldo = saldo - 100 WHERE id = 1;
UPDATE konta SET saldo = saldo + 100 WHERE id = 2;

-- Zatwierdzenie (zapisuje zmiany trwale):
COMMIT;

-- Cofniecie (anuluje wszystkie zmiany od START TRANSACTION):
ROLLBACK;

-- Savepoint (punkt powrotu w transakcji):
START TRANSACTION;
  INSERT INTO ...; 
  SAVEPOINT punkt1;
  UPDATE ...;       -- jesli ta operacja sie nie powiedzie:
  ROLLBACK TO SAVEPOINT punkt1;  -- cofamy tylko do punktu
COMMIT;

-- Wlasnosci ACID:
-- A - Atomicity    (Atomarnosc):    wszystko albo nic
-- C - Consistency  (Spojnosc):      dane zawsze w poprawnym stanie
-- I - Isolation    (Izolacja):      transakcje nie widza sie nawzajem
-- D - Durability   (Trwalosc):      zatwierdzone zmiany sa trwale
```

---

## 13. PODSUMOWANIE DO EGZAMINU

### Zarzadzanie uzytkownikami - flow

```sql
-- 1. Utworz uzytkownika:
CREATE USER 'user'@'localhost' IDENTIFIED BY 'HasloTrudne1!';

-- 2. Nadaj uprawnienia:
GRANT SELECT, INSERT, UPDATE, DELETE ON baza.* TO 'user'@'localhost';

-- 3. Odswierz uprawnienia:
FLUSH PRIVILEGES;

-- 4. Sprawdz:
SHOW GRANTS FOR 'user'@'localhost';

-- 5. Cofnij jesli potrzeba:
REVOKE DELETE ON baza.* FROM 'user'@'localhost';
FLUSH PRIVILEGES;

-- 6. Usun jesli potrzeba:
DROP USER 'user'@'localhost';
```

### Backup - komendy do zapamietania

```bash
# EKSPORT:
mysqldump -u root -p baza > backup.sql
mysqldump -u root -p --all-databases > all.sql

# IMPORT:
mysql -u root -p baza < backup.sql
```

### InnoDB vs MyISAM - najwazniejsze

| | InnoDB | MyISAM |
|-|--------|--------|
| Transakcje | TAK | NIE |
| Klucze obce | TAK | NIE |
| Domyslny? | Tak (MySQL 5.5+) | Kiedys domyslny |

### Silniki tabel

- InnoDB = transakcje + FK = **domyslny, polecany**
- MyISAM = szybki odczyt, brak FK = **legacy**
- ARIA (MariaDB) = lepsza wersja MyISAM w MariaDB
- MEMORY = tabele tymczasowe w RAM

### EXPLAIN - co sprawdzac

- `type = ALL` = brak indeksu = problem
- `type = ref` lub `const` = indeks uzyty = dobrze
- Kolumna `rows` = ile wierszy sprawdza MySQL

### Porty MySQL/MariaDB

- Domyslny port: **3306**
- phpMyAdmin: http://localhost/phpmyadmin
- Dostep SSH tunneling: `ssh -L 3306:localhost:3306 uzytkownik@serwer`

### Kluczowe polecenia administracyjne

```sql
SHOW DATABASES;                  -- Lista baz
SHOW TABLES;                     -- Lista tabel
SHOW TABLE STATUS;               -- Status tabel (silnik, wiersze itd.)
SHOW COLUMNS FROM tabela;        -- Struktura tabeli
DESCRIBE tabela;                 -- Alias dla SHOW COLUMNS
SHOW INDEX FROM tabela;          -- Indeksy tabeli
SHOW PROCESSLIST;                -- Aktywne polaczenia/zapytania
SHOW VARIABLES LIKE 'char%';    -- Zmienne konfiguracyjne
SHOW STATUS;                     -- Statystyki serwera
SHOW GRANTS FOR 'user'@'host';  -- Uprawnienia uzytkownika
```
