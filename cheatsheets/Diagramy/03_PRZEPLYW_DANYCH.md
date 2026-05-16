# Przepływ Danych — Diagramy i Protokoły — INF.03 Technik Programista

> Diagramy przepływu danych pokazują, jak informacja przemieszcza się przez system:
> od klienta przez sieć, serwer, PHP, bazę danych i z powrotem.

---

## SPIS TREŚCI

1. [Przepływ HTTP Request/Response](#1-przeplyw-http-requestresponse)
2. [Przepływ PHP + MySQL](#2-przeplyw-php--mysql)
3. [Model OSI 7 warstw](#3-model-osi-7-warstw)
4. [Model TCP/IP 4 warstwy](#4-model-tcpip-4-warstwy)
5. [Przepływ uwierzytelniania](#5-przeplyw-uwierzytelniania)
6. [Życie żądania w WordPress](#6-zycie-zadania-w-wordpress)
7. [Diagram działania DNS](#7-diagram-dzialania-dns)
8. [SSL/TLS Handshake](#8-ssltls-handshake)
9. [Przepływ uploadu pliku PHP](#9-przeplyw-uploadu-pliku-php)
10. [Przepływ formularza POST w PHP](#10-przeplyw-formularza-post-w-php)

---

## 1. PRZEPLYW HTTP REQUEST/RESPONSE

> HTTP (HyperText Transfer Protocol) to protokół komunikacji między przeglądarką
> a serwerem. Działa na zasadzie żądanie-odpowiedź (request-response).

```
PELNY PRZEPŁYW HTTP: Przeglądarka -> Serwer -> Przeglądarka
============================================================

+==================+
|   PRZEGLĄDARKA   |
|   (Chrome, FF)   |
+==================+
        |
        | 1. Użytkownik wpisuje URL:
        |    https://example.com/strona.php?id=5
        |
        v
+==================+
|   RESOLVER DNS   |  <- 2. Zapytanie DNS: "jaki IP ma example.com?"
+==================+
        |
        | 3. Odpowiedź DNS: "93.184.216.34"
        v
+==================+
|   TCP CONNECT    |  <- 4. Nawiązanie połączenia TCP (3-way handshake)
| SYN -> SYN-ACK  |     Klient: SYN
|     -> ACK       |     Serwer: SYN-ACK
+==================+     Klient: ACK
        |
        | 5. Żądanie HTTP GET:
        |
        |    GET /strona.php?id=5 HTTP/1.1
        |    Host: example.com
        |    User-Agent: Mozilla/5.0
        |    Accept: text/html
        |    Accept-Language: pl,en
        |    Cookie: session_id=abc123
        |    Connection: keep-alive
        |
        v
+========================+
|    SERWER APACHE       |  <- 6. Apache odbiera żądanie
+========================+
        |
        | 7. Czy plik .php? -> Przekaż do PHP
        v
+========================+
|    PHP INTERPRETER     |  <- 8. PHP przetwarza strona.php
|                        |
|    $_GET['id'] = 5     |
|    Połącz z MySQL      |
|    Wykonaj SQL         |
|    Generuj HTML        |
+========================+
        |
        | 9. Zapytanie SQL:
        |    SELECT * FROM produkty WHERE id = 5
        v
+========================+
|       MySQL            |  <- 10. MySQL wykonuje zapytanie
+========================+
        |
        | 11. Wynik: {id:5, nazwa:'Laptop', cena:2999}
        v
+========================+
|    PHP INTERPRETER     |  <- 12. PHP buduje HTML z danych
+========================+
        |
        | 13. Odpowiedź HTTP:
        |
        |    HTTP/1.1 200 OK
        |    Content-Type: text/html; charset=UTF-8
        |    Content-Length: 1234
        |    Set-Cookie: session_id=abc123; HttpOnly
        |    Date: Sat, 10 Jan 2026 12:00:00 GMT
        |
        |    <!DOCTYPE html>
        |    <html>...strona HTML...</html>
        |
        v
+==================+
|   PRZEGLĄDARKA   |  <- 14. Przeglądarka renderuje HTML
+==================+     15. Pobiera zasoby: CSS, JS, obrazy
        |                    (osobne żądania HTTP GET)
        v
+==================+
| WYŚWIETLONA STRONA|
+==================+

KODY ODPOWIEDZI HTTP:
=====================
1xx  Informacyjne    100 Continue, 101 Switching Protocols
2xx  Sukces          200 OK, 201 Created, 204 No Content
3xx  Przekierowanie  301 Moved Permanently, 302 Found, 304 Not Modified
4xx  Błąd klienta    400 Bad Request, 401 Unauthorized, 403 Forbidden,
                     404 Not Found, 405 Method Not Allowed, 422 Unprocessable
5xx  Błąd serwera    500 Internal Server Error, 503 Service Unavailable

METODY HTTP:
============
GET     Pobierz zasób (dane w URL, brak body)
POST    Wyślij dane do serwera (dane w body)
PUT     Zaktualizuj/zastąp zasób
PATCH   Częściowa aktualizacja zasobu
DELETE  Usuń zasób
HEAD    Jak GET, ale bez body odpowiedzi
OPTIONS Sprawdź dostępne metody
```

---

## 2. PRZEPLYW PHP + MYSQL

> Szczegółowy diagram kroków od połączenia PHP z MySQL do wyświetlenia danych.

```
PRZEPŁYW PHP + MYSQL — KROK PO KROKU:
=======================================

KROK 1: NAWIĄZANIE POŁĄCZENIA
+============================+
| PHP: mysqli_connect() lub  |
|      new PDO()             |
|                            |
| $conn = mysqli_connect(    |
|   'localhost',             |  <- host
|   'uzytkownik',            |  <- login
|   'haslo',                 |  <- hasło
|   'baza_danych'            |  <- baza
| );                         |
|                            |
| Czy połączenie OK?         |
|   NIE -> die("Błąd...");  |
|   TAK -> kontynuuj         |
+============================+
          |
          | Połączenie TCP do MySQL (port 3306)
          v

KROK 2: WALIDACJA DANYCH WEJŚCIOWYCH
+============================+
| $_GET lub $_POST           |
|                            |
| $id = $_GET['id'];         |
|                            |
| Walidacja:                 |
| - Czy istnieje?            |
|   isset($id)               |
| - Czy jest liczbą?         |
|   is_numeric($id)          |
| - Czy w dozwolonym zakresie?
|   $id > 0 && $id < 1000   |
| - Oczyść z niebezpiecznych:|
|   intval($id)              |
|   htmlspecialchars()       |
|   mysqli_real_escape_string|
+============================+
          |
          v

KROK 3: BUDOWANIE ZAPYTANIA SQL
+============================+
| Metoda 1 - NIEBEZPIECZNA: |
| $sql = "SELECT * FROM     |
|   produkty WHERE id=".$id; |  <- SQL Injection!
|                            |
| Metoda 2 - BEZPIECZNA     |
| (prepared statements):    |
|                            |
| $stmt = $conn->prepare(   |
|   "SELECT * FROM produkty |
|    WHERE id = ?"          |
| );                        |
| $stmt->bind_param("i",$id);|  <- "i" = integer
| $stmt->execute();         |
+============================+
          |
          | Zapytanie SQL wysyłane do MySQL
          v

KROK 4: WYKONANIE ZAPYTANIA W MYSQL
+============================+
| MySQL:                     |
| 1. Parser SQL              |
|    Sprawdza składnię       |
| 2. Optymalizator           |
|    Wybiera plan wykonania  |
|    Używa indeksów?         |
| 3. Executor                |
|    Przeszukuje tabele      |
|    Stosuje WHERE           |
|    Zwraca wiersze          |
+============================+
          |
          | Zbiór wyników (result set)
          v

KROK 5: POBRANIE WYNIKÓW
+============================+
| $result = $stmt->         |
|           get_result();    |
|                            |
| // Jeden rekord:           |
| $row = $result->fetch_assoc();
|                            |
| // Wiele rekordów:         |
| while($row =               |
|   $result->fetch_assoc())  |
| {                          |
|   // $row['kolumna']       |
| }                          |
|                            |
| // Liczba wierszy:         |
| $result->num_rows          |
+============================+
          |
          v

KROK 6: WYŚWIETLENIE DANYCH
+============================+
| // Ochrona przed XSS:      |
| echo htmlspecialchars(     |
|   $row['nazwa']            |
| );                         |
|                            |
| // Lub w szablonie HTML:   |
| ?>                         |
| <h1><?=                    |
|   htmlspecialchars($nazwa) |
| ?></h1>                    |
| <?php                      |
+============================+
          |
          v

KROK 7: ZAMKNIĘCIE POŁĄCZENIA
+============================+
| $conn->close();            |
| // lub automatycznie       |
| // na końcu skryptu PHP    |
+============================+
          |
          v
   HTML wyświetlony
   w przeglądarce

SCHEMAT BŁĘDÓW:
===============
Brak połączenia  -> sprawdź host, login, hasło, czy MySQL działa
Zapytanie puste  -> sprawdź WHERE (indeksy, typy danych)
SQL Error        -> sprawdź składnię, nazwy tabel/kolumn
Brak uprawnień   -> sprawdź GRANT dla użytkownika MySQL
```

---

## 3. MODEL OSI 7 WARSTW

> Model OSI (Open Systems Interconnection) to model referencyjny opisujący
> komunikację sieciową w 7 warstwach. Każda warstwa odpowiada za inne zadania.

```
MODEL OSI — 7 WARSTW:
======================

NADAWCA (Komputer A)              ODBIORCA (Komputer B)
========================          ========================

+========================+        +========================+
|  Warstwa 7             |        |  Warstwa 7             |
|  APLIKACJI             |        |  APLIKACJI             |
|  (Application Layer)   |        |  (Application Layer)   |
|                        |        |                        |
|  Protokoły:            |        |  Protokoły:            |
|  HTTP, HTTPS, FTP,     |        |  HTTP, HTTPS, FTP,     |
|  SMTP, POP3, IMAP,     |        |  SMTP, POP3, IMAP,     |
|  DNS, SSH, Telnet      |        |  DNS, SSH, Telnet      |
|  PDU: Dane (Data)      |        |  PDU: Dane (Data)      |
+========================+        +========================+
          |                                 ^
          v (Enkapsulacja)                  | (Dekapsulacja)
+========================+        +========================+
|  Warstwa 6             |        |  Warstwa 6             |
|  PREZENTACJI           |        |  PREZENTACJI           |
|  (Presentation Layer)  |        |  (Presentation Layer)  |
|                        |        |                        |
|  Kodowanie: ASCII,     |        |  Odkodowanie danych    |
|  Unicode, JPEG, MPEG   |        |                        |
|  Szyfrowanie: SSL/TLS  |        |  Deszyfrowanie         |
|  Kompresja danych      |        |                        |
|  PDU: Dane (Data)      |        |  PDU: Dane (Data)      |
+========================+        +========================+
          |                                 ^
          v                                 |
+========================+        +========================+
|  Warstwa 5             |        |  Warstwa 5             |
|  SESJI                 |        |  SESJI                 |
|  (Session Layer)       |        |  (Session Layer)       |
|                        |        |                        |
|  Zarządzanie sesją     |        |  Zarządzanie sesją     |
|  Protokoły: NetBIOS,   |        |                        |
|  RPC, PPTP, SAP        |        |                        |
|  PDU: Dane (Data)      |        |  PDU: Dane (Data)      |
+========================+        +========================+
          |                                 ^
          v                                 |
+========================+        +========================+
|  Warstwa 4             |        |  Warstwa 4             |
|  TRANSPORTU            |        |  TRANSPORTU            |
|  (Transport Layer)     |        |  (Transport Layer)     |
|                        |        |                        |
|  TCP: niezawodna,      |        |  TCP: potwierdz. odbioru
|  z potwierdzeniem,     |        |  Numery sekwencyjne    |
|  kontrola przepływu    |        |  Sprawdza kompletność  |
|  UDP: szybka, bez      |        |  UDP: brak sprawdzania |
|  potwierdzenia         |        |                        |
|  Porty: 0-65535        |        |  Porty docelowe        |
|  PDU: Segment (TCP)    |        |  PDU: Segment (TCP)    |
|       Datagram (UDP)   |        |       Datagram (UDP)   |
+========================+        +========================+
          |                                 ^
          v                                 |
+========================+        +========================+
|  Warstwa 3             |        |  Warstwa 3             |
|  SIECI                 |        |  SIECI                 |
|  (Network Layer)       |        |  (Network Layer)       |
|                        |        |                        |
|  IP: adresowanie,      |        |  IP: sprawdź adres     |
|  routing (wyznaczanie  |        |  czy to mój pakiet?    |
|  trasy przez sieć)     |        |                        |
|  Protokoły: IPv4, IPv6 |        |  Protokoły: IPv4, IPv6 |
|  ICMP (ping), ARP      |        |  ICMP, ARP             |
|  Urządzenia: Router    |        |  Urządzenia: Router    |
|  PDU: Pakiet (Packet)  |        |  PDU: Pakiet (Packet)  |
+========================+        +========================+
          |                                 ^
          v                                 |
+========================+        +========================+
|  Warstwa 2             |        |  Warstwa 2             |
|  ŁĄCZA DANYCH          |        |  ŁĄCZA DANYCH          |
|  (Data Link Layer)     |        |  (Data Link Layer)     |
|                        |        |                        |
|  MAC: adresowanie      |        |  MAC: sprawdź adres MAC|
|  fizyczne (Ethernet)   |        |  Czy to moje?          |
|  Wykrywanie błędów     |        |  Korekcja błędów       |
|  (CRC, parity)         |        |                        |
|  Protokoły: Ethernet,  |        |  Protokoły: Ethernet   |
|  Wi-Fi (802.11), PPP   |        |  Wi-Fi, PPP            |
|  Urządzenia: Switch,   |        |  Urządzenia: Switch    |
|  Bridge                |        |  Bridge                |
|  PDU: Ramka (Frame)    |        |  PDU: Ramka (Frame)    |
+========================+        +========================+
          |                                 ^
          v                                 |
+========================+        +========================+
|  Warstwa 1             |        |  Warstwa 1             |
|  FIZYCZNA              |        |  FIZYCZNA              |
|  (Physical Layer)      |        |  (Physical Layer)      |
|                        |        |                        |
|  Bity (0/1)            |========|  Bity (0/1)            |
|  Kabel UTP/STP         |  KABEL |  Odbiór sygnału        |
|  Światłowód, WiFi      | /FALE  |  Konwersja sygnał->bit |
|  Sygnały elektryczne/  |        |  Sygnały elektryczne/  |
|  optyczne/radiowe      |        |  optyczne/radiowe      |
|  Urządzenia: Hub,      |        |  Urządzenia: Hub       |
|  Repeater, karta siec. |        |  Repeater              |
|  PDU: Bit              |        |  PDU: Bit              |
+========================+        +========================+

ZAPAMIĘTAJ WARSTWY (mnemotechnika):
  Aplikacji, Prezentacji, Sesji, Transportu, Sieci, Łącza, Fizyczna
  "A Pies Szmigly Tutaj Nie Łazi Faktycznie"

PORTY WAŻNYCH PROTOKOŁÓW:
  20/21  FTP  (transfer plików)
  22     SSH  (bezpieczne połączenie)
  23     Telnet (niezabezpieczone)
  25     SMTP (wysyłanie poczty)
  53     DNS  (rozwiązywanie nazw)
  80     HTTP (strony www)
  110    POP3 (odbieranie poczty)
  143    IMAP (odbieranie poczty)
  443    HTTPS (strony www szyfrowane)
  3306   MySQL (baza danych)
  3389   RDP  (zdalny pulpit Windows)
```

---

## 4. MODEL TCP/IP 4 WARSTWY

> Model TCP/IP to praktyczny model używany w Internecie.
> Upraszcza 7 warstw OSI do 4 warstw.

```
MODEL TCP/IP vs MODEL OSI:
===========================

   MODEL TCP/IP          MODEL OSI (odpowiedniki)
+================+      +========================+
|                |      |  Warstwa 7: Aplikacji  |
| 4. APLIKACJI   |  <-> |  Warstwa 6: Prezentacji|
|   (Application)|      |  Warstwa 5: Sesji      |
+================+      +========================+
         |                         |
         v                         v
+================+      +========================+
| 3. TRANSPORTU  |  <-> |  Warstwa 4: Transportu |
|  (Transport)   |      |                        |
+================+      +========================+
         |                         |
         v                         v
+================+      +========================+
| 2. INTERNETU   |  <-> |  Warstwa 3: Sieci      |
|   (Internet)   |      |                        |
+================+      +========================+
         |                         |
         v                         v
+================+      +========================+
| 1. DOSTĘPU DO  |  <-> |  Warstwa 2: Łącza danych
|   SIECI        |      |  Warstwa 1: Fizyczna   |
| (Network Access)|      +========================+
+================+

SZCZEGÓŁY WARSTW TCP/IP:
=========================

+================================================+
|  WARSTWA 4: APLIKACJI                          |
|  Protokoły: HTTP, HTTPS, FTP, SMTP, DNS, SSH   |
|  Dane: Wiadomości (Messages)                   |
|  Co robi: Dostarcza usługi sieciowe dla        |
|           aplikacji użytkownika                |
+================================================+
                    |
                    | Enkapsulacja: dodanie nagłówka TCP/UDP
                    v
+================================================+
|  WARSTWA 3: TRANSPORTU                         |
|  Protokoły: TCP, UDP                           |
|  Dane: Segmenty (TCP) / Datagramy (UDP)        |
|  Co robi:                                      |
|    TCP: niezawodna dostawa, kontrola przepływu,|
|         numery sekwencyjne, potwierdzenia      |
|    UDP: szybka, bez potwierdzenia, dla video,  |
|         DNS, gier                              |
+================================================+
                    |
                    | Enkapsulacja: dodanie nagłówka IP
                    v
+================================================+
|  WARSTWA 2: INTERNETU                          |
|  Protokoły: IP (IPv4, IPv6), ICMP, ARP, OSPF  |
|  Dane: Pakiety (Packets)                       |
|  Co robi: Adresowanie IP, routing między       |
|           sieciami, fragmentacja pakietów      |
|  Nagłówek IP: adres źródłowy, docelowy, TTL   |
+================================================+
                    |
                    | Enkapsulacja: dodanie nagłówka Ethernet
                    v
+================================================+
|  WARSTWA 1: DOSTĘPU DO SIECI                   |
|  Protokoły: Ethernet, Wi-Fi (802.11), PPP      |
|  Dane: Ramki (Frames) + Bity (Bits)            |
|  Co robi: Fizyczna transmisja danych,          |
|           adresowanie MAC, wykrywanie błędów   |
+================================================+

TCP 3-WAY HANDSHAKE (nawiązanie połączenia):
=============================================

  KLIENT                              SERWER
    |                                    |
    |------ SYN (synchronize) --------->|  Klient inicjuje połączenie
    |                                    |  seq=100
    |<----- SYN-ACK ---------------------|  Serwer akceptuje
    |                                    |  seq=200, ack=101
    |------ ACK (acknowledge) -------->  |  Klient potwierdza
    |                                    |  seq=101, ack=201
    |                                    |
    |======= POŁĄCZENIE NAWIĄZANE =======|
    |                                    |
    |------ Dane (HTTP GET) ----------->|
    |<----- Dane (HTTP Response) --------|
    |                                    |
    |------ FIN ----------------------->|  Zakończenie połączenia
    |<----- FIN-ACK ---------------------|
    |------ ACK ------------------------>|

TCP vs UDP — PORÓWNANIE:
========================
+====================+==================+==================+
|  Cecha             |       TCP        |       UDP        |
+====================+==================+==================+
| Niezawodność       | TAK (ACK)        | NIE              |
| Kolejność danych   | TAK              | NIE              |
| Połączenie         | Wymagane (3-way) | Brak             |
| Szybkość           | Wolniejszy       | Szybszy          |
| Kontrola przepływu | TAK              | NIE              |
| Zastosowanie       | HTTP, FTP, SMTP  | DNS, video, VoIP |
| Narzut             | Większy          | Mniejszy         |
+====================+==================+==================+
```

---

## 5. PRZEPLYW UWIERZYTELNIANIA

> Diagram pokazuje, jak działa logowanie do systemu: od formularza
> przez weryfikację hasła po sesję użytkownika.

```
PRZEPŁYW LOGOWANIA — KOMPLETNY DIAGRAM:
========================================

KROK 1: FORMULARZ LOGOWANIA
+============================+
|    PRZEGLĄDARKA            |
|                            |
| GET /login.php             |
|                            |
| Wyświetla formularz:       |
| <form method="POST">       |
|   Login: [________]        |
|   Hasło: [________]        |
|   [ZALOGUJ SIĘ]            |
| </form>                    |
+============================+
          |
          | Użytkownik wypełnia i klika ZALOGUJ
          v

KROK 2: WYSŁANIE DANYCH
+============================+
|  HTTP POST /login.php      |
|                            |
|  Content-Type:             |
|    application/x-www-form- |
|    urlencoded              |
|                            |
|  Body:                     |
|  login=jan&haslo=tajne123  |
|                            |
|  UWAGA: HTTPS szyfruje     |
|  body! HTTP = widoczne!    |
+============================+
          |
          v

KROK 3: PHP PRZETWARZA (login.php)
+============================+
| 1. Odbierz dane POST       |
|    $login = $_POST['login']|
|    $haslo = $_POST['haslo']|
|                            |
| 2. Walidacja formalna:     |
|    - Czy nie puste?        |
|    - Czy nie za długie?    |
|    - Usuń białe znaki      |
|      trim($login)          |
|                            |
| 3. ZABEZPIECZ przed SQL    |
|    Injection!              |
|    Użyj prepared statements|
+============================+
          |
          v

KROK 4: WERYFIKACJA W BAZIE DANYCH
+============================+
| SQL (prepared statement):  |
| SELECT haslo_hash,         |
|        id_uzytkownika,     |
|        rola                |
| FROM uzytkownicy           |
| WHERE login = ?            |
|                            |
| Wynik:                     |
| $row['haslo_hash'] =       |
|   '$2y$10$abcXYZ...'       |
|   (hash bcrypt)            |
+============================+
          |
          v

KROK 5: WERYFIKACJA HASŁA
+============================+
| PHP weryfikuje hasło:      |
|                            |
| if (password_verify(       |
|   $haslo,                  |
|   $row['haslo_hash']       |
| )) {                       |
|   // Hasło POPRAWNE!       |
| } else {                   |
|   // Hasło BŁĘDNE!         |
| }                          |
|                            |
| NIE PORÓWNUJ HASHA WPROST! |
| Użyj password_verify()     |
+============================+
          |
          +---> HASŁO BŁĘDNE:
          |     Inkrementuj licznik prób
          |     Pokaż błąd: "Błędny login lub hasło"
          |     (nie mów KTÓRY jest błędny!)
          |     Redirect -> /login.php
          |
          +---> HASŁO POPRAWNE:
          v

KROK 6: TWORZENIE SESJI
+============================+
| session_start();           |
| session_regenerate_id(true);|  <- Zapobiega Session Fixation!
|                            |
| $_SESSION['user_id'] =     |
|   $row['id_uzytkownika'];  |
|                            |
| $_SESSION['rola'] =        |
|   $row['rola'];            |
|                            |
| $_SESSION['login'] =       |
|   $login;                  |
|                            |
| $_SESSION['zalogowany'] =  |
|   true;                    |
+============================+
          |
          | HTTP Response z cookie:
          | Set-Cookie: PHPSESSID=xyz789; HttpOnly; Secure
          v

KROK 7: PRZEKIEROWANIE
+============================+
| header("Location: /panel");|
| exit();                    |
+============================+
          |
          v

KROK 8: AUTORYZACJA NA KAŻDEJ STRONIE
+============================+
| Na początku każdej         |
| chronionej strony:         |
|                            |
| session_start();           |
|                            |
| if (!isset(                |
|   $_SESSION['zalogowany']) |
|   || !$_SESSION['zalogowany']
| ) {                        |
|   header("Location:/login");|
|   exit();                  |
| }                          |
|                            |
| // Sprawdź rolę:           |
| if ($_SESSION['rola']      |
|   != 'admin') {            |
|   header("Location:/403"); |
|   exit();                  |
| }                          |
+============================+

SCHEMAT BEZPIECZNE HASŁA:
==========================

Rejestracja:                    Logowanie:
  $hash = password_hash(          password_verify(
    $haslo,                         $haslo_wpisane,
    PASSWORD_BCRYPT,                $hash_z_bazy
    ['cost' => 12]                ) -> true/false
  );
  // Zapisz $hash do DB

NIGDY NIE PRZECHOWUJ HASEŁ W PLAINTEXT!
ZAWSZE używaj password_hash() / password_verify()!
```

---

## 6. ZYCIE ZADANIA W WORDPRESS

```
PRZEPŁYW ŻĄDANIA W WORDPRESS (szczegółowy):
============================================

[PRZEGLĄDARKA]
      |
      | GET /artykul/moj-post/ HTTP/1.1
      v
[APACHE]
      |
      | .htaccess: mod_rewrite
      | RewriteRule ^(.*)$ /index.php [L]
      | Wszystkie żądania -> index.php
      v
[index.php]
      |
      | require('./wp-blog-header.php');
      v
[wp-blog-header.php]
      |
      | require_once('./wp-load.php');
      v
[wp-load.php]
      |
      | Znajdź wp-config.php
      | (sprawdza foldery wyżej)
      | require_once('./wp-config.php');
      v
[wp-config.php]
      |
      | define('DB_NAME', 'baza');
      | define('DB_USER', 'user');
      | define('DB_PASSWORD', 'pass');
      | define('DB_HOST', 'localhost');
      | define('ABSPATH', ...);
      | require_once(ABSPATH.'wp-settings.php');
      v
[wp-settings.php]
      |
      | FAZA INICJALIZACJI:
      | 1. require wp-includes/load.php
      | 2. require wp-includes/functions.php
      | 3. require wp-includes/class-wpdb.php -> $wpdb (połączenie z DB)
      | 4. require wp-includes/default-constants.php
      | 5. require wp-includes/plugin.php (system hooków)
      | 6. do_action('muplugins_loaded')
      | 7. Załaduj aktywne pluginy (z wp_options)
      | 8. do_action('plugins_loaded')
      | 9. Załaduj motyw (functions.php)
      | 10. do_action('setup_theme')
      | 11. do_action('after_setup_theme')
      | 12. do_action('init') <- tutaj rejestruj CPT, taksonomie
      | 13. do_action('wp_loaded')
      v
[Powrót do wp-blog-header.php]
      |
      | wp(); // <- GŁÓWNA PĘTLA WP
      v
[Klasa WP - wp()]
      |
      | 1. $wp->parse_request()
      |    Parsuje URL -> query vars
      |    /artykul/moj-post/ -> post_type=post, name=moj-post
      |
      | 2. $wp->query_posts()
      |    WP_Query: SELECT * FROM wp_posts
      |              WHERE post_name = 'moj-post'
      |              AND post_type = 'post'
      |              AND post_status = 'publish'
      |
      | 3. $wp->handle_404()
      |    Czy znaleziono post? Nie -> 404
      |
      | 4. do_action('wp')
      v
[template-loader.php]
      |
      | Hierarchia szablonów:
      | is_single() -> szukaj single-post-moj-post.php
      |             -> single-post.php
      |             -> single.php
      |             -> singular.php
      |             -> index.php
      |
      | Znaleziono: single.php
      | include(single.php)
      v
[single.php (Motyw)]
      |
      | get_header();       // ładuje header.php
      |
      | if (have_posts()) : // sprawdź czy post istnieje
      |   while (have_posts()) :
      |     the_post();     // załaduj dane posta
      |     the_title();    // wyświetl tytuł
      |     the_content();  // wyświetl treść
      |     comments_template(); // komentarze
      |   endwhile;
      | endif;
      |
      | get_sidebar();      // ładuje sidebar.php
      | get_footer();       // ładuje footer.php
      v
[Wygenerowany HTML -> Przeglądarka]
```

---

## 7. DIAGRAM DZIALANIA DNS

> DNS (Domain Name System) tłumaczy nazwy domenowe (np. example.com)
> na adresy IP (np. 93.184.216.34).

```
PRZEPŁYW DNS — OD URL DO IP:
=============================

SCENARIUSZ: Użytkownik wpisuje https://example.com

KROK 1: Cache przeglądarki
+============================+
| Przeglądarka sprawdza      |
| własny cache DNS           |
|                            |
| Czy znam IP dla            |
| "example.com"?             |
|   TAK -> użyj z cache      |
|   NIE -> zapytaj system    |
+============================+
          |
          | Cache pusty lub wygasły
          v

KROK 2: Cache systemowy (OS)
+============================+
| System operacyjny sprawdza:|
| 1. Plik /etc/hosts         |
|    127.0.0.1  localhost    |
|    (czy example.com tutaj?)|
| 2. Cache DNS systemu       |
|   TAK -> odpowiedź         |
|   NIE -> dalej             |
+============================+
          |
          v

KROK 3: Lokalny resolver DNS (ISP)
+============================+
| Zapytanie do resolver DNS  |
| (serwer DNS od dostawcy    |
| internetu lub 8.8.8.8)     |
|                            |
| Resolver: "Znam example?"  |
|   TAK (cache) -> odpowiedź |
|   NIE -> zapytaj root DNS  |
+============================+
          |
          v

KROK 4: Root DNS Server (.)
+============================+
| 13 serwerów root na świecie|
| (a.root-servers.net itd.)  |
|                            |
| Zapytanie: "example.com?"  |
| Odpowiedź: "Nie wiem, ale  |
| zapytaj TLD dla .com:      |
| 192.5.6.30 (a.gtld-servers)"
+============================+
          |
          v

KROK 5: TLD DNS Server (.com)
+============================+
| Serwer TLD dla .com        |
|                            |
| Zapytanie: "example.com?"  |
| Odpowiedź: "Nie wiem, ale  |
| authoritative DNS to:      |
| ns1.example.com"           |
+============================+
          |
          v

KROK 6: Authoritative DNS (example.com)
+============================+
| Autorytatywny serwer DNS   |
| dla domeny example.com     |
|                            |
| Zapytanie: "example.com?"  |
| Odpowiedź: "93.184.216.34" |
| TTL: 3600 (1 godzina)      |
+============================+
          |
          v

KROK 7: Odpowiedź do przeglądarki
+============================+
| Resolver zapisuje w cache: |
| example.com -> 93.184.216.34
| (przez 3600 sekund)        |
|                            |
| Zwraca IP do przeglądarki  |
+============================+
          |
          v
Przeglądarka łączy się z IP 93.184.216.34:443

WAŻNE TYPY REKORDÓW DNS:
=========================
A       Nazwa -> IPv4 (np. example.com -> 93.184.216.34)
AAAA    Nazwa -> IPv6
CNAME   Alias (np. www.example.com -> example.com)
MX      Mail Exchange (serwer poczty dla domeny)
NS      Name Server (autorytatywny serwer DNS)
TXT     Tekst (SPF, DKIM, weryfikacja własności)
PTR     Odwrotny DNS (IP -> Nazwa)
SOA     Start of Authority (info o strefie)
TTL     Time To Live (czas ważności w cache, sekundy)

SCHEMAT UPROSZCZONY:
=====================
Przeglądarka -> Resolver ISP -> Root DNS -> TLD DNS -> Auth DNS
                                                           |
Przeglądarka <- Resolver ISP <---------------------------+
     IP!            (cache)
```

---

## 8. SSL/TLS HANDSHAKE

> SSL/TLS (Secure Sockets Layer / Transport Layer Security) to protokół
> szyfrowania komunikacji. HTTPS = HTTP + TLS.

```
TLS HANDSHAKE — NAWIĄZANIE BEZPIECZNEGO POŁĄCZENIA:
=====================================================

KLIENT (Przeglądarka)           SERWER (example.com)
         |                              |
         |------ 1. Client Hello ----->|
         |   Wersja TLS: 1.3           |
         |   Obsługiwane szyfry:        |
         |   - AES-256-GCM             |
         |   - ChaCha20-Poly1305       |
         |   Client Random: [32 bajty] |
         |   SNI: example.com          |
         |                              |
         |<----- 2. Server Hello ------|
         |   Wybrana wersja: TLS 1.3   |
         |   Wybrany szyfr: AES-256-GCM|
         |   Server Random: [32 bajty] |
         |                              |
         |<----- 3. Certificate -------|
         |   Certyfikat SSL serwera:   |
         |   - Nazwa: example.com      |
         |   - Klucz publiczny         |
         |   - Podpisany przez CA      |
         |   - Ważny do: 2026-12-31    |
         |                              |
KLIENT WERYFIKUJE CERTYFIKAT:
         |   - Czy podpisany przez     |
         |     zaufane CA?             |
         |   - Czy domena się zgadza?  |
         |   - Czy nie wygasł?         |
         |   - Czy nie na liście CRL?  |
         |                              |
         |<----- 4. Server Key Exch. --|
         |   (TLS 1.3: ECDHE)          |
         |   Klucz tymczasowy Diffie-H.|
         |                              |
         |------ 5. Client Key Exch. ->|
         |   Klucz tymczasowy D-H      |
         |                              |
         |   OBĄ STRONY OBLICZAJĄ:     |
         |   Wspólny sekret (Pre-Master)|
         |   -> Master Secret          |
         |   -> Session Keys           |
         |   (klucze symetryczne AES)  |
         |                              |
         |<----- 6. Finished ----------|
         |   MAC całego handshake      |
         |   Szyfrowane kluczem sesji  |
         |                              |
         |------ 7. Finished --------->|
         |   Klient potwierdza         |
         |                              |
         |============================= |
         |   KANAŁ SZYFROWANY TLS      |
         |============================= |
         |                              |
         |------ HTTP GET ------------>|  (szyfrowane!)
         |<----- HTTP 200 OK ----------|  (szyfrowane!)

KLUCZOWE POJĘCIA:
==================
CA (Certificate Authority) — urząd certyfikacji (Let's Encrypt, Comodo, DigiCert)
Certyfikat SSL — plik z kluczem publicznym i podpisem CA
Klucz publiczny — można udostępniać (szyfrowanie)
Klucz prywatny — SECRET! Tylko serwer go zna (deszyfrowanie)
Diffie-Hellman — protokół wymiany kluczy bez przesyłania ich przez sieć
Symetryczne szyfrowanie — ten sam klucz do szyfrowania i deszyfrowania (AES)
Asymetryczne szyfrowanie — para kluczy (publiczny/prywatny) — RSA, ECC
PFS (Perfect Forward Secrecy) — TLS 1.3: kompromitacja klucza serwera
                                 nie ujawni dawnych sesji

HTTPS vs HTTP:
==============
HTTP:   Dane w plaintext, widoczne dla każdego w sieci
HTTPS:  Dane szyfrowane TLS, bezpieczne
HTTP:   Port 80
HTTPS:  Port 443
```

---

## 9. PRZEPLYW UPLOADU PLIKU PHP

> Diagram pokazuje kompletny proces przesyłania pliku przez formularz HTML,
> jego weryfikację w PHP i zapisanie na serwerze.

```
PRZEPŁYW UPLOADU PLIKU PHP:
=============================

KROK 1: FORMULARZ HTML
+============================+
| <form                      |
|   method="POST"            |
|   action="upload.php"      |
|   enctype=                 |
|   "multipart/form-data">   |  <- WYMAGANE dla plików!
|                            |
|   <input type="file"       |
|     name="plik"            |
|     accept=".jpg,.png,.pdf"|
|   >                        |
|   <input type="submit"     |
|     value="Wyślij plik">   |
| </form>                    |
|                            |
| UWAGA: enctype jest        |
| OBOWIĄZKOWE dla upload!    |
+============================+
          |
          | HTTP POST multipart/form-data
          | Body: --boundary
          |       Content-Disposition: form-data; name="plik";
          |         filename="zdjecie.jpg"
          |       Content-Type: image/jpeg
          |       [bajty pliku]
          v

KROK 2: PHP ODBIERA PLIK ($_FILES)
+============================+
| $_FILES['plik'] zawiera:   |
|                            |
| [name]     = "zdjecie.jpg" | <- oryginalna nazwa (od klienta!)
| [type]     = "image/jpeg"  | <- MIME od klienta (NIE UFAJ!)
| [tmp_name] = "/tmp/php123" | <- ścieżka do pliku tymczasowego
| [error]    = 0             | <- 0 = UPLOAD_ERR_OK
| [size]     = 245678        | <- rozmiar w bajtach
|                            |
| Plik jest w /tmp/          |
| Zostanie usunięty na końcu |
| skryptu!                   |
+============================+
          |
          v

KROK 3: SPRAWDŹ KOD BŁĘDU
+============================+
| switch($_FILES['plik']     |
|        ['error']) {        |
|                            |
|   case UPLOAD_ERR_OK:      |
|     // 0: OK               |
|     break;                 |
|   case UPLOAD_ERR_INI_SIZE:|
|     // 1: za duży (php.ini)|
|     break;                 |
|   case UPLOAD_ERR_FORM_SIZE|
|     // 2: za duży (form)   |
|     break;                 |
|   case UPLOAD_ERR_NO_FILE: |
|     // 4: nie wybrano pliku|
|     break;                 |
| }                          |
+============================+
          |
          v

KROK 4: WALIDACJA ROZMIARU
+============================+
| $max_rozmiar = 5 * 1024    |
|               * 1024;      |
|               // 5MB       |
|                            |
| if ($_FILES['plik']['size']|
|     > $max_rozmiar) {      |
|   die("Plik za duży!");    |
| }                          |
+============================+
          |
          v

KROK 5: WALIDACJA ROZSZERZENIA (whitelist)
+============================+
| $dozwolone = [             |
|   'jpg', 'jpeg',           |
|   'png', 'gif', 'pdf'      |
| ];                         |
|                            |
| $rozszerzenie = strtolower(|
|   pathinfo(                |
|     $_FILES['plik']['name'],
|     PATHINFO_EXTENSION     |
|   )                        |
| );                         |
|                            |
| if (!in_array(             |
|   $rozszerzenie,           |
|   $dozwolone)) {           |
|   die("Niedozwolony typ!") |
| }                          |
|                            |
| WHITELIST (dozwolone)      |
| NIE blacklist (zakazane)!  |
+============================+
          |
          v

KROK 6: WALIDACJA MIME TYPE (bezpieczna)
+============================+
| $finfo = finfo_open(       |
|   FILEINFO_MIME_TYPE       |
| );                         |
| $mime = finfo_file(        |
|   $finfo,                  |
|   $_FILES['plik']['tmp_name']
| );                         |
| finfo_close($finfo);       |
|                            |
| $dozwolone_mime = [        |
|   'image/jpeg',            |
|   'image/png',             |
|   'image/gif',             |
|   'application/pdf'        |
| ];                         |
|                            |
| if (!in_array($mime,       |
|   $dozwolone_mime)) {      |
|   die("Zły typ MIME!");    |
| }                          |
|                            |
| SPRAWDŹ finfo (z pliku)    |
| NIE $_FILES['type']        |
| (od klienta, niezaufane!)  |
+============================+
          |
          v

KROK 7: GENERUJ BEZPIECZNĄ NAZWĘ
+============================+
| // Nie używaj oryginalnej  |
| // nazwy od użytkownika!   |
|                            |
| $nowa_nazwa = uniqid()     |
|   . '_'                    |
|   . bin2hex(random_bytes(8)|
|   . '.'                    |
|   . $rozszerzenie;         |
|                            |
| // Np: 64abc123_ab12cd34   |
| //     ef56gh78.jpg        |
+============================+
          |
          v

KROK 8: PRZENIEŚ PLIK
+============================+
| $katalog = 'uploads/';     |
| $cel = $katalog . $nowa_nazwa;
|                            |
| if (move_uploaded_file(    |
|   $_FILES['plik']['tmp_name'],
|   $cel                     |
| )) {                       |
|   echo "Upload OK!";       |
|   // Zapisz do DB          |
|   // $nazwa_w_db = $nowa_  |
|   //               nazwa;  |
| } else {                   |
|   die("Błąd zapisu!");     |
| }                          |
|                            |
| UŻYWAJ move_uploaded_file()!
| NIE copy() czy rename()!   |
| (move_uploaded_file sprawdza
|  czy plik pochodzi z upload)|
+============================+
```

---

## 10. PRZEPLYW FORMULARZA POST W PHP

```
KOMPLETNY PRZEPŁYW FORMULARZA POST:
=====================================

KROK 1: UŻYTKOWNIK WIDZI FORMULARZ
+============================+
| GET /kontakt.php           |
|                            |
| PHP wyświetla pusty form:  |
| <form method="POST"        |
|       action="kontakt.php">|
|   Imię: <input name="imie">|
|   Email: <input name="email">
|   Wiadom: <textarea...>    |
|   <button>Wyślij</button>  |
| </form>                    |
+============================+
          |
          | Użytkownik wypełnia i klika Wyślij
          v

KROK 2: PRZEGLĄDARKA WYSYŁA POST
+============================+
| HTTP POST /kontakt.php      |
| Content-Type: application/ |
|   x-www-form-urlencoded    |
| Content-Length: 45         |
|                            |
| BODY:                      |
| imie=Jan+Kowalski&         |
| email=jan%40example.com&   |
| wiadomosc=Dzien+dobry      |
|                            |
| (%40 = @, + = spacja)      |
+============================+
          |
          v

KROK 3: PHP SPRAWDZA METODĘ
+============================+
| <?php                      |
| if ($_SERVER['REQUEST_METHOD']
|     === 'POST') {          |
|   // Przetwarzaj formularz |
| } else {                   |
|   // Wyświetl pusty formularz
| }                          |
+============================+
          |
          v

KROK 4: POBIERZ I OCZYŚĆ DANE
+============================+
| $imie = trim(              |
|   $_POST['imie'] ?? ''     |
| );                         |
|                            |
| $email = trim(             |
|   $_POST['email'] ?? ''    |
| );                         |
|                            |
| $wiadomosc = trim(         |
|   $_POST['wiadomosc'] ?? ''|
| );                         |
|                            |
| // ?? '' = jeśli nie istnieje
| //          to pusty string|
+============================+
          |
          v

KROK 5: WALIDACJA SERWERA
+============================+
| $bledy = [];               |
|                            |
| // Czy wymagane pola są?   |
| if (empty($imie)) {        |
|   $bledy[] = "Imię wymagane";
| }                          |
|                            |
| // Czy email prawidłowy?   |
| if (!filter_var($email,    |
|   FILTER_VALIDATE_EMAIL)){ |
|   $bledy[] = "Zły email";  |
| }                          |
|                            |
| // Czy wiadomość nie za krótka?
| if (strlen($wiadomosc)<10){|
|   $bledy[] = "Za krótka";  |
| }                          |
|                            |
| // Długość max:            |
| if (strlen($wiadomosc)>1000){
|   $bledy[] = "Za długa";   |
| }                          |
+============================+
          |
          +---> Są błędy?
          |     TAK: Wyświetl formularz z błędami
          |     Zachowaj wpisane dane (repopulacja)
          |     Zabroń zapisu
          |
          +---> Brak błędów:
          v

KROK 6: PRZETWARZANIE DANYCH
+============================+
| Opcja A: Zapis do bazy:    |
|   $stmt = $conn->prepare(  |
|     "INSERT INTO kontakty  |
|      (imie, email, wiado.) |
|      VALUES (?, ?, ?)"     |
|   );                       |
|   $stmt->bind_param('sss', |
|     $imie, $email,         |
|     $wiadomosc);           |
|   $stmt->execute();        |
|                            |
| Opcja B: Wyślij email:     |
|   mail(                    |
|     'admin@example.com',   |
|     'Wiadomość od '.$imie, |
|     $wiadomosc,            |
|     'From: '.$email        |
|   );                       |
+============================+
          |
          v

KROK 7: PRZEKIEROWANIE (PRG)
+============================+
| PRG = Post/Redirect/Get    |
| Zapobiega podwójnemu       |
| wysłaniu formularza!       |
|                            |
| header(                    |
|   "Location: /dziekujemy.php"
| );                         |
| exit();                    |
|                            |
| BEZ exit() PHP kontynuuje  |
| mimo header()!             |
+============================+
          |
          v

KROK 8: STRONA POTWIERDZENIA
+============================+
| GET /dziekujemy.php        |
|                            |
| "Dziękujemy za wiadomość!" |
| "Odpowiemy w ciągu 24h."  |
|                            |
| Refresh odświeży GET,      |
| NIE ponownie wykona POST!  |
+============================+

OCHRONA PRZED ATAKAMI:
========================
XSS (Cross-Site Scripting):
  Przy wyświetlaniu danych:
  echo htmlspecialchars($imie, ENT_QUOTES, 'UTF-8');

SQL Injection:
  Użyj prepared statements (PDO lub MySQLi).
  NIGDY nie wstawiaj zmiennych wprost do SQL!

CSRF (Cross-Site Request Forgery):
  Dodaj token CSRF do formularza:
  <input type="hidden" name="csrf_token"
         value="<?= $_SESSION['csrf_token'] ?>">
  Przy POST sprawdź czy token się zgadza.

Double Submit:
  Użyj wzorca PRG (Post-Redirect-Get).
  Po sukcesie POST zawsze redirect na GET.

SCHEMAT WZORCA PRG:
===================
  GET /formularz.php    <- Wyświetl formularz
  POST /formularz.php   <- Przetworz dane
  REDIRECT 302 /ok.php  <- Przekieruj po sukcesie
  GET /ok.php           <- Strona potwierdzenia (refresh-safe)
```

---

## TABELA PODSUMOWUJĄCA — PROTOKOŁY I PORTY

```
+==================+========+===========+====================+
| Protokół         | Port   | Warstw.   | Zastosowanie        |
+==================+========+===========+====================+
| HTTP             | 80     | Aplikacji | Strony WWW          |
| HTTPS            | 443    | Aplik.    | Strony WWW (SSL)    |
| FTP              | 21     | Aplikacji | Transfer plików     |
| FTP (data)       | 20     | Aplikacji | Transfer danych FTP |
| SFTP             | 22     | Aplikacji | Bezpieczny FTP      |
| SSH              | 22     | Aplikacji | Bezpieczna pow. cmd |
| Telnet           | 23     | Aplikacji | Pow. cmd (niezabez.)|
| SMTP             | 25     | Aplikacji | Wysyłanie poczty    |
| SMTP (SSL)       | 587    | Aplikacji | Wysyłanie (TLS)     |
| POP3             | 110    | Aplikacji | Odbieranie poczty   |
| IMAP             | 143    | Aplikacji | Odbieranie poczty   |
| DNS              | 53     | Aplikacji | Rozwiązywanie nazw  |
| DHCP             | 67/68  | Aplikacji | Przydzielanie IP    |
| MySQL/MariaDB    | 3306   | Aplikacji | Baza danych         |
| PostgreSQL       | 5432   | Aplikacji | Baza danych         |
| RDP              | 3389   | Aplikacji | Zdalny pulpit       |
| TCP              | -      | Transportu| Niezawodny strumień |
| UDP              | -      | Transportu| Szybki datagram     |
| IP               | -      | Sieci     | Routing pakietów    |
| ICMP             | -      | Sieci     | Diagnostyka (ping)  |
| ARP              | -      | Łącza     | IP -> MAC           |
| Ethernet         | -      | Łącza     | LAN sieć lokalna    |
| Wi-Fi (802.11)   | -      | Łącza     | WLAN sieć bezprz.   |
+==================+========+===========+====================+
```

---

*Plik wygenerowany dla kursu INF.03 — Technik Programista*
*Dotyczy: przepływ danych, protokoły sieciowe, bezpieczeństwo PHP*
