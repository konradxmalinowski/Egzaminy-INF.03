# SCIAGAWKA: SIECI KOMPUTEROWE, SYSTEMY LICZBOWE, CYBERBEZPIECZENSTWO (INF.03.2)

---

## 1. TOPOLOGIE SIECI

**Topologia** = fizyczny lub logiczny sposob polaczenia urzadzen w sieci.

| Topologia | Opis | Zalety | Wady |
|-----------|------|--------|------|
| **Gwiazda (Star)** | Wszystkie urzadzenia podlaczone do centralnego hub/switch | Awaria jednego kabla nie psuje sieci; latwe zarzadzanie | Awaria centrum = awaria calej sieci |
| **Magistrala (Bus)** | Wspolny kabel (backbone), do ktorego podlaczone sa wszystkie urzadzenia | Prosta, tania | Awaria kabla = brak sieci; kolizje |
| **Pierscien (Ring)** | Dane kraza w jednym kierunku po petli | Brak kolizji, przewidywalny czas dostepu | Awaria jednego wezla blokuje siec |
| **Siatka (Mesh)** | Kazde urzadzenie polaczone z wieloma innymi | Wysoka niezawodnosc, redundancja | Droga, skomplikowana |
| **Drzewo (Tree)** | Hierarchia: korzen → galezie → liscie | Skalowalna, porzadkuje strukture | Awaria korzenia = awaria drzewa |
| **Hybryda** | Polaczenie kilku topologii (np. gwiazda + magistrala) | Elastycznosc | Zlozona konfiguracja |

> **EGZAMIN:** Najczesciej stosowana w LAN: **gwiazda** (switch centralny). W internecie: **siatka** (redundancja).

---

## 2. MODEL OSI (7 WARSTW)

```
7. Aplikacji       (Application)   - HTTP, FTP, SMTP, DNS
6. Prezentacji     (Presentation)  - SSL/TLS, kodowanie, kompresja
5. Sesji           (Session)       - zarzadzanie sesjami, synchronizacja
4. Transportowa    (Transport)     - TCP, UDP, segmentacja, porty
3. Sieciowa        (Network)       - IP, routing, pakiety
2. Lacza danych    (Data Link)     - MAC, ramki, Ethernet, WiFi
1. Fizyczna        (Physical)      - bity, kable, sygnaly elektryczne
```

**Mnemonik (od dolu):** "Przez Lata Nikt Tego Pewnie Ani Nie" (Physical, Data Link, Network, Transport, Session, Presentation, Application)

| Warstwa | Nr | Jednostka danych | Urzadzenia |
|---------|----|-----------------|------------|
| Aplikacji | 7 | Dane | Komputer, serwer |
| Prezentacji | 6 | Dane | - |
| Sesji | 5 | Dane | - |
| Transportowa | 4 | Segment (TCP) / Datagram (UDP) | - |
| Sieciowa | 3 | Pakiet | Router |
| Lacza danych | 2 | Ramka (Frame) | Switch, Bridge |
| Fizyczna | 1 | Bit | Hub, kabel, repeater |

---

## 3. MODEL TCP/IP (4 WARSTWY)

```
4. Aplikacji       - HTTP, HTTPS, FTP, SMTP, POP3, IMAP, DNS, DHCP
3. Transportowa    - TCP (niezawodny), UDP (szybki)
2. Internetowa     - IP, ICMP, ARP
1. Dostepu do sieci - Ethernet, WiFi (802.11), MAC
```

### Odpowiednik OSI → TCP/IP

| OSI | TCP/IP |
|-----|--------|
| 7 + 6 + 5 | Aplikacji |
| 4 | Transportowa |
| 3 | Internetowa |
| 2 + 1 | Dostepu do sieci |

### TCP vs UDP

| Cecha | TCP | UDP |
|-------|-----|-----|
| Polaczenie | Tak (3-way handshake) | Nie |
| Niezawodnosc | Tak (potwierdzenia) | Nie |
| Kolejnosc | Gwarantowana | Brak gwarancji |
| Szybkosc | Wolniejszy | Szybszy |
| Zastosowanie | HTTP, FTP, email | DNS, streaming, gry |

---

## 4. PROTOKOLY I PORTY

| Protokol | Port | Opis | TCP/UDP |
|----------|------|------|---------|
| HTTP | 80 | Strony WWW (nieszyfrowane) | TCP |
| HTTPS | 443 | Strony WWW (szyfrowane SSL/TLS) | TCP |
| FTP | 20/21 | Transfer plikow (21=sterowanie, 20=dane) | TCP |
| FTPS | 990 | FTP z szyfrowaniem | TCP |
| SFTP | 22 | FTP przez SSH | TCP |
| SSH | 22 | Bezpieczna powloka zdalna | TCP |
| Telnet | 23 | Zdalna powloka (nieszyfrowana) | TCP |
| SMTP | 25 | Wysylanie emaili | TCP |
| SMTP (auth) | 587 | Wysylanie emaili (autentykacja) | TCP |
| POP3 | 110 | Odbieranie emaili (usuwa z serwera) | TCP |
| POP3S | 995 | POP3 szyfrowane | TCP |
| IMAP | 143 | Odbieranie emaili (zostawia na serwerze) | TCP |
| IMAPS | 993 | IMAP szyfrowane | TCP |
| DNS | 53 | Tlumaczenie nazw na IP | TCP/UDP |
| DHCP | 67/68 | Automatyczne przydzielanie IP | UDP |
| RDP | 3389 | Pulpit zdalny (Windows) | TCP |
| MySQL | 3306 | Baza danych MySQL | TCP |
| HTTPS Alt | 8080 | Alternatywny port HTTP | TCP |

> **EGZAMIN:** POP3 **usuwa** maile z serwera. IMAP **synchronizuje** (zostawia na serwerze). SMTP **wysyla**.

---

## 5. ADRESOWANIE IP

### IPv4 - Budowa adresu

```
Adres IP: 192.168.1.100
Format:   4 oktety, kazdy 0-255, oddzielone kropkami
Binarnie: 11000000.10101000.00000001.01100100
```

### Klasy adresow IPv4

| Klasa | Zakres | Maska domyslna | Liczba sieci | Liczba hostow |
|-------|--------|----------------|--------------|---------------|
| A | 1.0.0.0 - 126.255.255.255 | 255.0.0.0 (/8) | 126 | 16 777 214 |
| B | 128.0.0.0 - 191.255.255.255 | 255.255.0.0 (/16) | 16 384 | 65 534 |
| C | 192.0.0.0 - 223.255.255.255 | 255.255.255.0 (/24) | 2 097 152 | 254 |
| D | 224.0.0.0 - 239.255.255.255 | - | Multicast | - |
| E | 240.0.0.0 - 255.255.255.255 | - | Zarezerwowane | - |

### Prywatne zakresy IP (RFC 1918)

| Zakres | CIDR | Klasa |
|--------|------|-------|
| 10.0.0.0 - 10.255.255.255 | 10.0.0.0/8 | A |
| 172.16.0.0 - 172.31.255.255 | 172.16.0.0/12 | B |
| 192.168.0.0 - 192.168.255.255 | 192.168.0.0/16 | C |

### Specjalne adresy

| Adres | Znaczenie |
|-------|-----------|
| 127.0.0.1 | Loopback (localhost) - sam komputer |
| 0.0.0.0 | Adres nieokreslony / cala siec |
| 255.255.255.255 | Broadcast lokalny |
| 192.168.1.255 | Broadcast dla sieci 192.168.1.0/24 |

### Maska podsieci - notacja CIDR

```
/8  = 255.0.0.0       = 11111111.00000000.00000000.00000000
/16 = 255.255.0.0     = 11111111.11111111.00000000.00000000
/24 = 255.255.255.0   = 11111111.11111111.11111111.00000000
/25 = 255.255.255.128 = 11111111.11111111.11111111.10000000
/26 = 255.255.255.192 = 11111111.11111111.11111111.11000000
/27 = 255.255.255.224 = 11111111.11111111.11111111.11100000
/28 = 255.255.255.240 = 11111111.11111111.11111111.11110000
/30 = 255.255.255.252 = 11111111.11111111.11111111.11111100
```

**Liczba hostow w podsieci:** `2^(32 - prefix) - 2` (odejmujemy adres sieci i broadcast)

Przyklad: /24 = 2^(32-24) - 2 = 2^8 - 2 = 256 - 2 = **254 hosty**

### IPv6 - podstawy

```
Format: 8 grup po 4 cyfry hex, oddzielone dwukropkami
Przyklad: 2001:0db8:85a3:0000:0000:8a2e:0370:7334
Skrocony: 2001:db8:85a3::8a2e:370:7334
Dlugosc: 128 bitow (vs 32 bity IPv4)
Loopback: ::1
```

---

## 6. SIECI BEZPRZEWODOWE - STANDARDY WIFI

| Standard | Pasmo | Maks. predkosc | Rok | Nazwa |
|----------|-------|----------------|-----|-------|
| 802.11a | 5 GHz | 54 Mbps | 1999 | WiFi 1 |
| 802.11b | 2.4 GHz | 11 Mbps | 1999 | WiFi 2 |
| 802.11g | 2.4 GHz | 54 Mbps | 2003 | WiFi 3 |
| 802.11n | 2.4/5 GHz | 600 Mbps | 2009 | WiFi 4 |
| 802.11ac | 5 GHz | 6.9 Gbps | 2013 | WiFi 5 |
| 802.11ax | 2.4/5/6 GHz | 9.6 Gbps | 2019 | WiFi 6 |
| 802.11be | 2.4/5/6 GHz | 46 Gbps | 2024 | WiFi 7 |

### Szyfrowanie WiFi

| Standard | Bezpieczenstwo | Uwagi |
|----------|----------------|-------|
| WEP | Bardzo slabe | Przestarzaly, nie uzywac |
| WPA | Slabe | Zastapiony przez WPA2 |
| WPA2 (AES) | Dobre | Standard domowy |
| WPA3 | Bardzo dobre | Najnowszy standard |

---

## 7. SYSTEMY LICZBOWE

### Podstawy

| System | Podstawa | Cyfry | Prefiks |
|--------|----------|-------|---------|
| Dwojkowy (binarny) | 2 | 0, 1 | 0b |
| Osemkowy (oktalny) | 8 | 0-7 | 0o |
| Dziesietny (decymalny) | 10 | 0-9 | - |
| Szesnastkowy (heksadecymalny) | 16 | 0-9, A-F | 0x |

### Tabela wartosci hex

| Dec | Hex | Bin | Dec | Hex | Bin |
|-----|-----|-----|-----|-----|-----|
| 0 | 0 | 0000 | 8 | 8 | 1000 |
| 1 | 1 | 0001 | 9 | 9 | 1001 |
| 2 | 2 | 0010 | 10 | A | 1010 |
| 3 | 3 | 0011 | 11 | B | 1011 |
| 4 | 4 | 0100 | 12 | C | 1100 |
| 5 | 5 | 0101 | 13 | D | 1101 |
| 6 | 6 | 0110 | 14 | E | 1110 |
| 7 | 7 | 0111 | 15 | F | 1111 |

### Konwersje - krok po kroku

#### Dziesietny → Binarny (metoda dzielenia przez 2)

```
Przyklad: 45 (dec) → binarny

45 : 2 = 22  reszta 1  ← LSB (najmniej znaczacy bit)
22 : 2 = 11  reszta 0
11 : 2 =  5  reszta 1
 5 : 2 =  2  reszta 1
 2 : 2 =  1  reszta 0
 1 : 2 =  0  reszta 1  ← MSB (najbardziej znaczacy bit)

Czytamy reszty od dolu: 101101
Wynik: 45 (dec) = 101101 (bin)
Sprawdzenie: 32+8+4+1 = 45 ✓
```

#### Binarny → Dziesietny (metoda poteg)

```
Przyklad: 10110011 (bin) → dziesietny

Pozycje:  7  6  5  4  3  2  1  0
Bity:     1  0  1  1  0  0  1  1

Obliczenia:
1 × 2^7 = 128
0 × 2^6 =   0
1 × 2^5 =  32
1 × 2^4 =  16
0 × 2^3 =   0
0 × 2^2 =   0
1 × 2^1 =   2
1 × 2^0 =   1

Suma: 128 + 32 + 16 + 2 + 1 = 179

Wynik: 10110011 (bin) = 179 (dec)
```

#### Dziesietny → Szesnastkowy

```
Przyklad: 255 (dec) → hex

255 : 16 = 15  reszta 15 = F  ← LSB
 15 : 16 =  0  reszta 15 = F  ← MSB

Czytamy od dolu: FF
Wynik: 255 (dec) = FF (hex)

Przyklad 2: 200 (dec) → hex
200 : 16 = 12  reszta  8 = 8
 12 : 16 =  0  reszta 12 = C

Wynik: 200 (dec) = C8 (hex)
```

#### Szesnastkowy → Dziesietny

```
Przyklad: 2F (hex) → dziesietny

2F = 2 × 16^1 + F × 16^0
   = 2 × 16   + 15 × 1
   = 32 + 15
   = 47

Wynik: 2F (hex) = 47 (dec)

Przyklad 2: 1A3 (hex) → dziesietny
1A3 = 1 × 16^2 + A × 16^1 + 3 × 16^0
    = 1 × 256 + 10 × 16 + 3 × 1
    = 256 + 160 + 3
    = 419
```

#### Binarny → Szesnastkowy (grupowanie po 4 bity)

```
Przyklad: 10111010 (bin) → hex

Grupujemy od prawej po 4 bity:
1011 | 1010
  B  |  A

Wynik: 10111010 (bin) = BA (hex)

Przyklad 2: 110100111101 (bin) → hex
0011 | 0100 | 1111 | 0100
   3 |    4 |    F |    4

Wynik: 34F4 (hex)
```

#### Dziesietny → Osemkowy

```
Przyklad: 100 (dec) → oktalny

100 : 8 = 12  reszta 4
 12 : 8 =  1  reszta 4
  1 : 8 =  0  reszta 1

Wynik: 100 (dec) = 144 (oct)
Sprawdzenie: 1×64 + 4×8 + 4×1 = 64+32+4 = 100 ✓
```

---

## 8. KOD UZUPELNIEN DO 2 (U2 / Two's Complement)

**Cel:** Reprezentacja liczb ujemnych w systemie binarnym.

### Zasada U2 dla n bitow

1. Liczba dodatnia: zapisujemy normalnie binarnie
2. Liczba ujemna: invertujemy bity (NOT), dodajemy 1

### Przyklad 8-bitowy

```
Zakres 8-bitowy: od -128 do +127

+5  = 00000101
-5:
  Krok 1 - inwersja bitow +5:  11111010
  Krok 2 - dodanie 1:         +00000001
                               ---------
  -5 (U2) =                   11111111... nie
  
  Poprawnie:
  +5  = 00000101
  ~+5 = 11111010  (inwersja)
        +       1
        ---------
  -5  = 11111011

Weryfikacja -5:
-128 + 64 + 32 + 16 + 8 + 0 + 2 + 1
= -128 + 123 = -5 ✓
```

### Jak sprawdzic czy liczba jest ujemna?

- Jesli **MSB (bit najwyzszy) = 1** → liczba ujemna
- Jesli **MSB = 0** → liczba dodatnia lub zero

### Zakresy

| Bity | Min | Max |
|------|-----|-----|
| 4 | -8 | +7 |
| 8 | -128 | +127 |
| 16 | -32 768 | +32 767 |
| 32 | -2 147 483 648 | +2 147 483 647 |

---

## 9. OPERACJE LOGICZNE I ARYTMETYCZNE NA LICZBACH BINARNYCH

### Operacje logiczne (bramki logiczne)

#### AND (iloczyn logiczny) - oba musza byc 1

```
Tabliczka prawdy:    Przyklad:
A  B  A AND B        1010
0  0     0           AND
0  1     0           1100
1  0     0           ----
1  1     1           1000
```

#### OR (suma logiczna) - co najmniej jeden = 1

```
Tabliczka prawdy:    Przyklad:
A  B  A OR B         1010
0  0    0            OR
0  1    1            1100
1  0    1            ----
1  1    1            1110
```

#### NOT (negacja) - odwrocenie

```
A  NOT A
0    1
1    0

NOT 10110011 = 01001100
```

#### XOR (rozlaczna alternatywa) - rozne = 1

```
Tabliczka prawdy:    Przyklad:
A  B  A XOR B        1010
0  0     0           XOR
0  1     1           1100
1  0     1           ----
1  1     0           0110
```

#### NAND, NOR (uzupelnienia AND/OR)

```
A  B  NAND  NOR
0  0    1    1
0  1    1    0
1  0    1    0
1  1    0    0
```

### Dodawanie binarne

```
Reguly:
0 + 0 = 0
0 + 1 = 1
1 + 0 = 1
1 + 1 = 0 (przeniesienie 1)
1 + 1 + 1 = 1 (przeniesienie 1)

Przyklad: 1011 + 1101
    1011   (11 dec)
  + 1101   (13 dec)
  ------
  11000   (24 dec)

Sprawdzenie: 11 + 13 = 24 ✓

Krok po kroku:
  Kolumna 0: 1+1 = 0, przen=1
  Kolumna 1: 1+0+przen(1) = 0, przen=1
  Kolumna 2: 0+1+przen(1) = 0, przen=1
  Kolumna 3: 1+1+przen(1) = 1, przen=1
  Kolumna 4: 0+0+przen(1) = 1
  Wynik: 11000
```

### Przesuniecia bitowe (Bit Shift)

```
Przesuniecie w lewo (<<):  mnozy przez 2^n
  0101 << 1 = 1010  (5 × 2 = 10)
  0101 << 2 = 10100 (5 × 4 = 20)

Przesuniecie w prawo (>>): dzieli przez 2^n (integer)
  1010 >> 1 = 0101  (10 / 2 = 5)
  1100 >> 2 = 0011  (12 / 4 = 3)
```

---

## 10. CYBERBEZPIECZENSTWO

### Rodzaje zlosliwego oprogramowania (Malware)

| Typ | Opis | Przyklad |
|-----|------|---------|
| **Wirus** | Dolacza sie do plikow, rozmnazan przez uruchomienie zainfekowanego pliku | ILOVEYOU |
| **Robak (Worm)** | Rozmnaza sie samodzielnie przez siec bez potrzeby uruchamiania | WannaCry |
| **Trojan** | Ukrywa sie w legalnym programie, otwiera backdoor | Zeus |
| **Ransomware** | Szyfruje pliki i zadania okupu | CryptoLocker |
| **Spyware** | Szpieguje uzytkownika, kradnie dane | Keylogger |
| **Adware** | Wyswietla niechciane reklamy | CoolWebSearch |
| **Rootkit** | Ukrywa sie glęboko w systemie (ring 0/kernel) | Stuxnet |
| **Botnet** | Siec zainfekowanych komputerow pod kontrola hakera | Mirai |
| **Keylogger** | Rejestruje nacisnięcia klawiszy | rodzaj Spyware |
| **Scareware** | Falszywe alarmy bezpieczenstwa | Fake AV |

### Rodzaje atakow hakerskich

| Atak | Opis | Jak sie chronic |
|------|------|-----------------|
| **Phishing** | Falszywe emaile/strony udajace legalne instytucje | Sprawdzaj URL, nie klikaj w linki |
| **Spear Phishing** | Celowany phishing na konkretna osobe | Weryfikuj nadawce |
| **DoS (Denial of Service)** | Przeciazenie serwera jednym zrodlem | Firewall, rate limiting |
| **DDoS** | DoS z wielu zrodel jednoczesnie | CDN, DDoS protection |
| **SQL Injection** | Wstrzykiwanie kodu SQL do formularzy | Prepared statements, sanityzacja |
| **XSS (Cross-Site Scripting)** | Wstrzykiwanie JS do stron | Escape output, CSP |
| **CSRF** | Falszywe zapytania w imieniu zalogowanego uzytkownika | Tokeny CSRF |
| **Brute Force** | Probowanie wszystkich mozliwych hasel | Blokada po bledach, 2FA |
| **Dictionary Attack** | Brute force ze slownikiem slow | Silne hasla, 2FA |
| **Man-in-the-Middle (MITM)** | Przechwytywanie komunikacji | HTTPS, certyfikaty |
| **Eavesdropping** | Nasluchiwanie ruchu sieciowego | Szyfrowanie |
| **Zero-day** | Atak na niezlataná dziure | Szybkie aktualizacje |
| **Social Engineering** | Manipulacja psychologiczna ludzi | Szkolenia, swiadomosc |

### Zabezpieczenia

| Metoda | Opis |
|--------|------|
| **Firewall** | Filtruje ruch sieciowy na podstawie regul |
| **Antywirus / EDR** | Wykrywa i usuwa zlosliwe oprogramowanie |
| **Szyfrowanie (SSL/TLS)** | Chroni dane w transmisji |
| **Szyfrowanie (AES)** | Chroni dane przechowywane |
| **2FA / MFA** | Dwuetapowa weryfikacja tozsamosci |
| **VPN** | Szyfrowany tunel przez publiczna siec |
| **IDS / IPS** | Wykrywanie i zapobieganie wlomaniom |
| **DMZ** | Strefa zdemilitaryzowana - bufor miedzy zewnetrzem a siecia wew. |
| **Backup** | Kopie zapasowe - regula 3-2-1 |
| **Aktualizacje** | Latki bezpieczenstwa (patches) |
| **Silne hasla** | Min 12 znakow, mix liter, cyfr, symboli |
| **Zasada najmniejszych uprawnien** | Uzytkownik ma tylko konieczne uprawnienia |

### Szyfrowanie - typy

| Typ | Opis | Algorytm | Klucz |
|-----|------|----------|-------|
| **Symetryczne** | Ten sam klucz do szyfrowania i deszyfrowania | AES, DES, 3DES | 1 klucz |
| **Asymetryczne** | Para kluczy: publiczny + prywatny | RSA, ECC | 2 klucze |
| **Hashowanie** | Jednokierunkowe - nie mozna odszyfrowa | MD5, SHA-256, bcrypt | - |

---

## 11. PARAMETRY SPRZETOWE

### Procesor (CPU)

| Parametr | Opis | Przyklad |
|----------|------|---------|
| **Czestotliwosc (taktowanie)** | Prędkosc pracy w GHz | 3.6 GHz |
| **Liczba rdzeni** | Rdzenie fizyczne | 8 rdzeni |
| **Watki (threads)** | Rdzenie logiczne (HT/SMT) | 16 watkow |
| **Cache L1** | Najszybsza pamiec podreczna (64-512 KB) | 512 KB |
| **Cache L2** | Srednia pamiec podreczna (256 KB - 4 MB) | 4 MB |
| **Cache L3** | Wspoludzielona (4 - 64 MB) | 32 MB |
| **TDP** | Pobor mocy w watach | 65 W |
| **Architektura** | x86-64, ARM | x86-64 |
| **Litografia** | Rozmiar tranzystorow | 7 nm |

### Pamiec RAM

| Parametr | Opis |
|----------|------|
| **DDR4** | Standard do ~2023, 2133-3600 MHz |
| **DDR5** | Nowszy standard, 4800-7200+ MHz |
| **Pojemnosc** | GB (gigabajty) - 8, 16, 32, 64 GB |
| **Czestotliwosc** | MHz - im wyzsza tym szybsza |
| **Opoznienia (CL)** | Latency - im nizsze tym lepsze |
| **Dwukanalowosc** | 2 modulow = szybszy przeplyw |

### Dyski twarde

| Typ | Predkosc odczytu | Lacze | Zalety | Wady |
|-----|-----------------|-------|--------|------|
| **HDD** | 80-160 MB/s | SATA | Tani, duza pojemnosc | Wolny, ruchome czesci |
| **SSD SATA** | 500-560 MB/s | SATA | Szybszy niz HDD | Drozszy niz HDD |
| **SSD NVMe (M.2)** | 3000-7000 MB/s | PCIe | Bardzo szybki | Drogi |
| **SSD NVMe Gen 4** | do 7000 MB/s | PCIe 4.0 | Najszybszy masowo | Drogi |

### Karty graficzne (GPU)

| Parametr | Opis |
|----------|------|
| **VRAM** | Dedykowana pamiec karty (4-24 GB GDDR6) |
| **Shader cores** | Rdzenie CUDA (nVidia) / Stream Processors (AMD) |
| **TDP** | Pobor mocy (150-450W) |
| **Lacze** | PCIe x16 |
| **Wyjscia** | HDMI, DisplayPort |

---

## 12. PRZELICZANIE JEDNOSTEK PAMIECI

### Jednostki (system binarny - SI)

| Jednostka | Skrot | Wartosc |
|-----------|-------|---------|
| Bit | b | 0 lub 1 |
| Bajt (Byte) | B | 8 bitow |
| Kilobajt | KB | 1 024 B (2^10) |
| Megabajt | MB | 1 024 KB = 1 048 576 B (2^20) |
| Gigabajt | GB | 1 024 MB = 2^30 B |
| Terabajt | TB | 1 024 GB = 2^40 B |
| Petabajt | PB | 1 024 TB = 2^50 B |

### Jednostki SI (dekadyczne - stosowane przez producentow diskow)

| Jednostka | Skrot | Wartosc |
|-----------|-------|---------|
| Kilobajt | kB | 1 000 B |
| Megabajt | MB | 1 000 000 B |
| Gigabajt | GB | 1 000 000 000 B |

> **UWAGA:** Dysk "1 TB" ma w rzeczywistosci 1000^4 B, a system Windows pokaze ~931 GB (bo liczy binarnie: 1000^4 / 1024^4 = ~0.91)

### Przeliczanie szybkosci transferu

```
1 MB/s = 8 Mb/s (megabitow na sekunde)
Lacze 100 Mb/s = 12,5 MB/s realnego transferu
Lacze 1 Gb/s  = 125 MB/s realnego transferu

UWAGA: Male 'b' = bit, duze 'B' = bajt!
```

---

## 13. RODO / GDPR

**RODO** = Rozporządzenie o Ochronie Danych Osobowych (GDPR po angielsku)
Obowiazuje od **25 maja 2018** w calej UE.

### Podstawowe zasady RODO

| Zasada | Opis |
|--------|------|
| **Zgodnosc z prawem** | Dane mozna przetwarzac tylko na podstawie prawnej (zgoda, umowa, prawo) |
| **Rzetelnosc i przejrzystosc** | Uzytkownik musi wiedziec jak sa przetwarzane jego dane |
| **Ograniczenie celu** | Dane zbieramy tylko w konkretnym, okreslonym celu |
| **Minimalizacja danych** | Zbieramy tylko to co niezbedne |
| **Prawidlowosc** | Dane musza byc aktualne i prawidlowe |
| **Ograniczenie przechowywania** | Dane nie moga byc trzymane dluzej niz potrzeba |
| **Integralnosc i poufnosc** | Odpowiednie zabezpieczenia techniczne |

### Prawa uzytkownikow w RODO

- Prawo dostepu do danych
- Prawo do poprawiania danych
- Prawo do usuniecia ("prawo do bycia zapomnianym")
- Prawo do przenoszenia danych
- Prawo do sprzeciwu
- Prawo do ograniczenia przetwarzania

### Kary za naruszenie RODO

- Do **20 mln EUR** lub **4% rocznego globalnego obrotu** (wieksza kwota)
- Do **10 mln EUR** lub **2% obrotu** (mniejsze naruszenia)

### Obowiazkowe elementy przy zbieraniu danych (Privacy Policy)

- Kim jest administrator danych
- W jakim celu zbierane sa dane
- Jak dlugo sa przechowywane
- Komu sa udostepniane
- Jakie prawa ma uzytkownik

---

## 14. NETYKIETA I ZASADY BEZPIECZNEGO KORZYSTANIA Z SIECI

### Netykieta (Internet Etiquette)

| Zasada | Opis |
|--------|------|
| Nie KRZYCZ | Pisanie CAPS LOCK = krzyk, uzywaj go oszczednie |
| Szanuj innych | Nie obrązaj, nie trolluj, nie hejt |
| Cytuj odpowiednio | Cytuj tylko potrzebne fragmenty |
| Nie spamuj | Nie wysylaj niechcianych wiadomosci |
| Sprawdzaj zrodla | Weryfikuj informacje przed udostepnieniem |
| Chronologicznosc | Nie pisz na stare watki bez potrzeby (necroposting) |
| Prywatnosc | Nie ujawniaj danych osobowych innych |

### Zasady bezpiecznego korzystania z sieci

1. **Silne, unikalne hasla** - inne dla kazdego serwisu
2. **Menedzer hasel** - KeePass, Bitwarden
3. **2FA wszdzie gdzie mozliwe**
4. **Aktualizuj system i oprogramowanie**
5. **Nie klikaj w podejrzane linki**
6. **Sprawdzaj certyfikat SSL** (klamka/HTTPS)
7. **Uzywaj VPN** w publicznych sieciach WiFi
8. **Twoz regularne kopie zapasowe**
9. **Nie pobieraj oprogramowania z nieznanych zrodel**
10. **Ogranicz dane udostepniane w mediach spolecznosciowych**
11. **Weryfikuj email nadawcy** (nie tylko nazwe, ale adres)
12. **Zasada ograniczonego zaufania** do wiadomosci prosszacych o dane

---

## 15. WCAG 2.0 - DOSTEPNOSC

**WCAG** = Web Content Accessibility Guidelines (Wytyczne Dostepnosci Tresci Internetowych)
Wydane przez **W3C (World Wide Web Consortium)**.

### 4 Zasady WCAG (POUR)

| Zasada | Opis |
|--------|------|
| **P - Postrzegalnosc (Perceivable)** | Tresci musza byc dostepne dla zmyslow (wzrok, sluch) |
| **O - Funkcjonalnosc (Operable)** | Interfejs musi byc obslugiwany klawiatura i myszka |
| **U - Zrozumialosci (Understandable)** | Informacje i interfejs musza byc zrozumiale |
| **R - Solidnosc (Robust)** | Tresc musi dzialac w roznych technologiach wspomagajacych |

### Poziomy zgodnosci

| Poziom | Opis | Wymagania |
|--------|------|-----------|
| **A** | Minimalny | Bez tego strona jest niedostepna dla duzej grupy |
| **AA** | Sredni (standard) | Wymagany przez wiekszos przepisow prawa | 
| **AAA** | Najwyzszy | Optymalna dostepnosc, trudna do osiagniecia wszdzie |

### Kluczowe wymagania WCAG 2.0

#### Poziom A (must have)

- Alternatywy tekstowe dla grafiki (`alt=""`)
- Napisy dla filmow
- Mozliwosc obslugi klawiatura
- Brak tresci migajacych ponad 3 razy/s
- Strona ma tytuł (`<title>`)
- Jezyk strony okreslony (`lang="pl"`)

#### Poziom AA (standard)

- Kontrast tekstu: min **4,5:1** dla normalnego tekstu
- Kontrast tekstu: min **3:1** dla duzego tekstu (18pt lub 14pt bold)
- Zmiana rozmiaru tekstu do 200% bez utraty funkcjonalnosci
- Wiele sposobow nawigacji (menu, mapa strony, wyszukiwarka)
- Etykiety dla formularzy
- Komunikaty o bledach

#### Poziom AAA (optimal)

- Kontrast: min 7:1
- Jezyk migowy dla filmow
- Pomoc kontekstowa
- Rezygnacja z limitu czasu

### Przyklady w HTML

```html
<!-- Dobry alt -->
<img src="logo.png" alt="Logo firmy ABC - powrot do strony glownej">

<!-- Dekoracyjna grafika (pusty alt) -->
<img src="ozdoba.png" alt="">

<!-- Formularz z etykieta -->
<label for="email">Adres email:</label>
<input type="email" id="email" name="email" required>

<!-- Jezyk strony -->
<html lang="pl">

<!-- Skip link - pomija nawigacje -->
<a href="#main-content" class="skip-link">Przejdz do tresci</a>

<!-- Rola ARIA gdy potrzebna -->
<button aria-label="Zamknij okno dialogowe" aria-expanded="false">X</button>
```

---

## 16. PODSUMOWANIE DO EGZAMINU

### Najwazniejsze do zapamietania

**Topologie:**
- Gwiazda = najczesciej stosowana w LAN (hub/switch w centrum)
- Siatka = internet (redundancja)
- Magistrala = stara, awaria kabla = brak sieci

**OSI vs TCP/IP:**
- OSI = 7 warstw (teoryczne), TCP/IP = 4 warstwy (praktyczne)
- Router = warstwa 3 (sieciowa)
- Switch = warstwa 2 (lacza danych)
- Hub = warstwa 1 (fizyczna)

**Porty kluczowe:**
- 80 HTTP, 443 HTTPS, 22 SSH/SFTP, 21 FTP, 25/587 SMTP, 110 POP3, 143 IMAP, 53 DNS, 67/68 DHCP

**IP:**
- Prywatne: 10.x.x.x, 172.16-31.x.x, 192.168.x.x
- Loopback: 127.0.0.1
- /24 = 255.255.255.0 = 254 hosty

**Systemy liczbowe:**
- Bin → Dec: sumuj potegi 2
- Dec → Bin: dziel przez 2, reszty od dolu
- Hex ↔ Bin: grupuj po 4 bity
- Ujemne U2: invertuj bity, dodaj 1

**Cyberbezpieczenstwo:**
- SQL Injection → Prepared Statements
- XSS → Escape output
- Brute Force → 2FA + blokada
- HTTPS → szyfrowanie TLS

**WCAG:**
- AA = standard = kontrast 4.5:1 dla tekstu
- alt="" dla grafik dekoracyjnych, alt="opis" dla znaczacych
- lang="pl" w HTML

**RODO:**
- Obowiazuje od 25.05.2018
- Kara max 20 mln EUR lub 4% obrotu
- Minimalizacja danych, cel, zgoda uzytkownika

**Jednostki:**
- 1 KB = 1024 B (binarnie) = 1000 B (SI/producenci)
- 1 MB/s = 8 Mb/s
- Wielkie B = bajt, male b = bit
