# Architektura CMS — WordPress i Joomla — INF.03 Technik Programista

> CMS (Content Management System) to system zarządzania treścią. Na egzaminie INF.03
> wymagana jest znajomość architektury WordPress i Joomla, modelu MVC, struktury
> folderów oraz schematu bazy danych.

---

## SPIS TREŚCI

1. [Model MVC — diagram i opis](#1-model-mvc)
2. [Architektura WordPress](#2-architektura-wordpress)
3. [Architektura Joomla](#3-architektura-joomla)
4. [Porównanie WordPress vs Joomla](#4-porownanie-wordpress-vs-joomla)
5. [Przepływ żądania HTTP w WordPress](#5-przeplyw-zadania-http-w-wordpress)
6. [Struktura folderów WordPress](#6-struktura-folderow-wordpress)
7. [Struktura folderów Joomla](#7-struktura-folderow-joomla)
8. [Schemat bazy danych WordPress](#8-schemat-bazy-danych-wordpress)
9. [Schemat bazy danych Joomla](#9-schemat-bazy-danych-joomla)
10. [Cykl życia pluginu WordPress](#10-cykl-zycia-pluginu-wordpress)

---

## 1. MODEL MVC

> MVC (Model-View-Controller) to wzorzec architektoniczny, który oddziela logikę
> aplikacji od warstwy prezentacji. Używany w Joomla (jawnie) i WordPress (niejawnie).

### 1.1 Schemat MVC

```
                    +========================+
                    |       UZYTKOWNIK       |
                    |   (przeglądarka www)   |
                    +========================+
                           |        ^
                    Żądanie HTTP    |  Odpowiedź HTML
                           |        |
                           v        |
                    +========================+
                    |      CONTROLLER        |
                    |  (kontroler/router)    |
                    +========================+
                    | - Odbiera żądanie HTTP |
                    | - Waliduje dane wejśc. |
                    | - Wywołuje Model       |
                    | - Wybiera View         |
                    | - Przekazuje dane      |
                    +========================+
                        |           |
              Pobierz   |           |  Dane do
              dane      |           |  wyświetlenia
                        v           v
          +===========+           +==========+
          |   MODEL   |           |   VIEW   |
          | (model)   |           | (widok)  |
          +===========+           +==========+
          | - Logika  |           | - HTML   |
          |   biznes. |           | - CSS    |
          | - SQL     |           | - JS     |
          | - Baza    |           | - Szabl. |
          |   danych  |           +-----------+
          +===========+
                |
                v
         +===========+
         |   BAZA    |
         |  DANYCH   |
         |  (MySQL)  |
         +===========+

PRZEPŁYW:
=========
1. Użytkownik wysyła żądanie HTTP (np. GET /produkty?id=5)
2. Controller odbiera żądanie, wyciąga parametry (id=5)
3. Controller wywołuje Model: "pobierz produkt o id=5"
4. Model wykonuje SQL: SELECT * FROM produkty WHERE id=5
5. Model zwraca dane do Controllera
6. Controller przekazuje dane do View
7. View generuje HTML z danymi
8. HTML wraca do użytkownika przez Controller

ZASADA:
  Model    — co (dane, logika)
  View     — jak wygląda (prezentacja)
  Controller — kto zarządza (logika sterowania)
```

### 1.2 MVC w WordPress (niejawny)

```
+=======================+
|  WORDPRESS MVC        |
+=======================+

  WordPress nie implementuje MVC wprost,
  ale ma analogiczne warstwy:

  CONTROLLER (odpowiednik):
    - wp-blog-header.php
    - wp-load.php
    - index.php
    - query vars / WP_Query

  MODEL (odpowiednik):
    - wpdb (klasa obsługi bazy)
    - WP_Post, WP_User, WP_Term
    - functions w wp-includes/

  VIEW (odpowiednik):
    - Pliki szablonów motywu:
      index.php, single.php, page.php
      archive.php, search.php
    - Hierarchia szablonów WordPress
```

### 1.3 MVC w Joomla (jawny)

```
+=======================+
|  JOOMLA MVC           |
+=======================+

  Joomla implementuje MVC jawnie w każdym komponencie.

  Każdy komponent ma strukturę:
  /components/com_example/
    controllers/         <- Controller
      example.php
    models/              <- Model
      example.php
    views/               <- View
      example/
        tmpl/
          default.php    <- szablon HTML

  CONTROLLER: com_example -> ExampleController
  MODEL:      ExampleModel -> getData() -> SQL
  VIEW:       ExampleView  -> display() -> HTML
```

---

## 2. ARCHITEKTURA WORDPRESS

### 2.1 Warstwy architektury

```
+========================================================+
|                    UZYTKOWNIK                          |
|              (przeglądarka internetowa)                |
+========================================================+
                          |
                          | HTTP Request (GET/POST)
                          v
+========================================================+
|                  SERWER WWW (Apache/Nginx)             |
|           /etc/apache2/   lub   /etc/nginx/            |
|    .htaccess -> mod_rewrite -> przekierowanie do PHP   |
+========================================================+
                          |
                          | Przekazanie do interpretera
                          v
+========================================================+
|                  PHP (interpreter)                     |
|              wersja 7.4+ / 8.0+ / 8.1+                |
|   - Wykonuje pliki .php                                |
|   - Ładuje WordPress Core                              |
|   - Obsługuje pluginy i motywy                         |
+========================================================+
          |                           |
          | Zapytania SQL             | Pliki statyczne
          v                           v
+==================+        +==================+
|     MySQL/       |        |   wp-content/    |
|   MariaDB        |        |   (media, motywy,|
|                  |        |    pluginy)      |
|  wp_posts        |        |  uploads/        |
|  wp_users        |        |  themes/         |
|  wp_options      |        |  plugins/        |
|  wp_meta         |        +==================+
+==================+

LEGENDA:
========
HTTP Request — żądanie od przeglądarki
Apache — serwer HTTP, obsługuje .htaccess, mod_rewrite
PHP — przetwarza kod, generuje HTML
MySQL — przechowuje treść, użytkowników, opcje
wp-content — pliki motywu, pluginów, zdjęcia
```

### 2.2 Warstwa PHP WordPress — szczegóły

```
+========================================================+
|                 WORDPRESS PHP CORE                     |
+========================================================+
|                                                        |
|  index.php  ->  wp-blog-header.php                    |
|                        |                               |
|              wp-load.php  (ładuje konfigurację)       |
|                        |                               |
|              wp-config.php (DB, klucze, prefix)       |
|                        |                               |
|              wp-settings.php (inicjalizacja WP)       |
|                        |                               |
|         +--------------+------------------+            |
|         |                                 |            |
|   wp-includes/                    wp-content/          |
|   (core WordPress)                (rozszerzenia)       |
|   - functions.php                 - plugins/           |
|   - class-wp.php                  - themes/            |
|   - class-wpdb.php                - uploads/           |
|   - class-wp-query.php            - mu-plugins/        |
|   - template-loader.php                                |
|                                                        |
+========================================================+
```

### 2.3 Hierarchia szablonów WordPress

```
HIERARCHIA SZABLONÓW (Template Hierarchy):
==========================================
WordPress szuka szablonu od najbardziej do najmniej szczegółowego.

Przykład dla posta o ID=5, slug="hello-world":

  Żądanie: /hello-world/
      |
      v
  Czy istnieje single-post-hello-world.php ?  -> TAK: użyj tego
      |
      | NIE
      v
  Czy istnieje single-post-5.php ?            -> TAK: użyj tego
      |
      | NIE
      v
  Czy istnieje single-post.php ?              -> TAK: użyj tego
      |
      | NIE
      v
  Czy istnieje single.php ?                   -> TAK: użyj tego
      |
      | NIE
      v
  Użyj index.php                              -> ZAWSZE istnieje

INNE SZABLONY:
  Strona główna:  front-page.php > home.php > index.php
  Archiwum:       archive-{post-type}.php > archive.php > index.php
  Wyszukiwanie:   search.php > index.php
  404:            404.php > index.php
  Strona:         page-{slug}.php > page-{id}.php > page.php > index.php
```

---

## 3. ARCHITEKTURA JOOMLA

### 3.1 Warstwy architektury

```
+========================================================+
|                    UZYTKOWNIK                          |
|              (przeglądarka internetowa)                |
+========================================================+
                          |
                          | HTTP Request
                          v
+========================================================+
|                  SERWER WWW (Apache/Nginx)             |
|         .htaccess -> mod_rewrite -> index.php          |
+========================================================+
                          |
                          v
+========================================================+
|                  PHP (interpreter)                     |
|                  Joomla Framework                      |
|                                                        |
|   index.php                                            |
|      |                                                 |
|   JFactory -> JApplication -> JRouter                 |
|                                    |                   |
|                              Komponenty (MVC)          |
|                              - com_content             |
|                              - com_users               |
|                              - com_menus               |
|                              - pluginy (events)        |
|                              - moduły                  |
+========================================================+
          |                           |
          v                           v
+==================+        +==================+
|     MySQL/       |        |   /media/        |
|   MariaDB        |        |   /images/       |
|  jos_content     |        |   /templates/    |
|  jos_users       |        |   /components/   |
|  jos_modules     |        |   /modules/      |
|  jos_menu        |        |   /plugins/      |
+==================+        +==================+
```

### 3.2 Komponenty Joomla — szczegóły MVC

```
ARCHITEKTURA KOMPONENTU JOOMLA:
================================

  HTTP żądanie: index.php?option=com_content&view=article&id=1
                                |                |         |
                          komponent          widok      ID artykułu
                         (option)           (view)       (id)

  +==========================+
  |  com_content (komponent) |
  +==========================+
  |                          |
  | controllers/             |
  |   article.php            |  <- odbiera żądanie, wywołuje model
  |                          |
  | models/                  |
  |   article.php            |  <- pobiera dane z MySQL
  |                          |
  | views/                   |
  |   article/               |
  |     view.html.php        |  <- przygotowuje dane dla szablonu
  |     tmpl/                |
  |       default.php        |  <- szablon HTML (View)
  |                          |
  +==========================+

TYPY ROZSZERZEŃ JOOMLA:
  Komponenty  — główna funkcjonalność (com_content, com_users)
  Moduły      — bloki na stronie (mod_menu, mod_search)
  Pluginy     — obsługa zdarzeń (plg_content_pagebreak)
  Szablony    — wygląd (templateDetails.xml + index.php)
  Języki      — tłumaczenia (en-GB.ini, pl-PL.ini)
```

---

## 4. POROWNANIE WORDPRESS VS JOOMLA

```
+==============================+====================+====================+
|         CECHA                |    WORDPRESS       |      JOOMLA        |
+==============================+====================+====================+
| Trudność obsługi             | Łatwa              | Średnia            |
| Wzorzec architektoniczny     | Niejawny MVC       | Jawny MVC          |
| Rozszerzenia                 | Pluginy + Motywy   | Komp.+Moduły+Plug. |
| Język szablonów              | PHP (natywny)      | PHP (natywny)      |
| Domyślne CMS do bloga        | TAK (blog-first)   | NIE (ogólny CMS)   |
| Wielojęzyczność (wbudowana)  | NIE (plugin WPML)  | TAK (wbudowana)    |
| SEO (wbudowane)              | Częściowe          | Częściowe          |
| Rynek udział (2025)          | ~43% stron         | ~2% stron          |
| Prefiks tabel DB             | wp_                | jos_ / własny      |
| Panel admina URL             | /wp-admin/         | /administrator/    |
| Plik konfiguracyjny          | wp-config.php      | configuration.php  |
| Główny plik inicjalizacji    | wp-settings.php    | libraries/joomla/  |
| System hooków/eventów        | add_action()       | JEvent / plugins   |
| Klasa obsługi DB             | wpdb               | JDatabase/JFactory |
| REST API                     | TAK (wbudowane)    | TAK (wbudowane)    |
| Wbudowany koszyk sklep.      | NIE (WooCommerce)  | NIE (VirtueMart)   |
| Aktualizacje automatyczne    | TAK                | TAK                |
| Wymagania PHP (min)          | PHP 7.4+           | PHP 7.2.5+         |
| Wymagania MySQL (min)        | MySQL 5.7+         | MySQL 5.6+         |
+==============================+====================+====================+

KIEDY WYBRAĆ WORDPRESS:
  - Blog / strona firmowa / portfolio
  - Brak doświadczenia technicznego
  - Potrzeba wielu gotowych motywów
  - Sklep (WooCommerce)

KIEDY WYBRAĆ JOOMLA:
  - Portal z zaawansowaną kontrolą dostępu
  - Strona wielojęzyczna bez dodatkowych pluginów
  - Aplikacja wymagająca MVC od razu
  - System społecznościowy / portal
```

---

## 5. PRZEPLYW ZADANIA HTTP W WORDPRESS

```
PELNY PRZEPŁYW: Od URL do wyświetlonej strony
==============================================

KROK 1: Przeglądarka
+=============================+
| Użytkownik wpisuje URL:     |
| https://example.com/post/   |
+=============================+
          |
          | DNS lookup -> IP serwera
          | TCP connection -> port 80/443
          v

KROK 2: Serwer Apache
+=============================+
| Apache odbiera żądanie GET  |
| Sprawdza .htaccess          |
| mod_rewrite: wszystko ->    |
|   index.php                 |
+=============================+
          |
          v

KROK 3: index.php (WordPress)
+=============================+
| include wp-blog-header.php  |
+=============================+
          |
          v

KROK 4: wp-blog-header.php
+=============================+
| require wp-load.php         |
| -> wp-config.php            |
|    (konfiguracja DB, klucze)|
| -> wp-settings.php          |
|    (ładuje core WP)         |
| wp()  -> główna pętla WP    |
+=============================+
          |
          v

KROK 5: WP_Query (Model)
+=============================+
| Parsowanie URL -> query vars|
| Budowanie zapytania SQL     |
| SELECT * FROM wp_posts      |
|   WHERE post_name = 'post'  |
| Wykonanie zapytania MySQL   |
| Załadowanie danych do posta |
+=============================+
          |
          | dane postów
          v

KROK 6: template-loader.php (Controller)
+=============================+
| Określa typ strony          |
| (is_single? is_page? ...)   |
| Szuka pliku szablonu wg     |
| hierarchii szablonów        |
| Ładuje odpowiedni .php      |
+=============================+
          |
          | ładuje plik szablonu
          v

KROK 7: Motyw (View)
+=============================+
| single.php lub index.php    |
| get_header()                |
| The Loop:                   |
|   while(have_posts()):      |
|     the_post()              |
|     the_title()             |
|     the_content()           |
| get_footer()                |
+=============================+
          |
          | wygenerowany HTML
          v

KROK 8: Odpowiedź HTTP
+=============================+
| PHP zwraca HTML do Apache   |
| Apache wysyła response HTTP |
| Przeglądarka renderuje HTML |
+=============================+
          |
          v
+=============================+
|  Strona wyświetlona         |
|  użytkownikowi              |
+=============================+

CZAS ODPOWIEDZI TYPOWY:
  DNS:       ~10-50ms
  TCP:       ~20-100ms
  PHP/MySQL: ~50-500ms (zależy od serwera i cache)
  Transfer:  ~50-200ms
```

---

## 6. STRUKTURA FOLDEROW WORDPRESS

```
wordpress/
|
+-- wp-admin/                    <- Panel administracyjny
|   +-- css/                     <- Style panelu
|   +-- images/                  <- Obrazy panelu
|   +-- includes/                <- Pliki funkcjonalności admina
|   +-- js/                      <- Skrypty JS panelu
|   +-- network/                 <- Multisite
|   +-- index.php                <- Strona główna panelu
|   +-- admin.php                <- Kontroler admina
|   +-- post.php                 <- Edytor postów
|   +-- users.php                <- Zarządzanie użytkownikami
|   +-- plugins.php              <- Zarządzanie pluginami
|   +-- themes.php               <- Zarządzanie motywami
|   +-- options-general.php      <- Ustawienia ogólne
|
+-- wp-includes/                 <- Core WordPress (NIE modyfikuj!)
|   +-- blocks/                  <- Bloki Gutenberg
|   +-- css/                     <- Style wp
|   +-- fonts/                   <- Czcionki
|   +-- images/                  <- Obrazy core
|   +-- js/                      <- Skrypty JS core (jQuery, etc.)
|   +-- pomo/                    <- Obsługa tłumaczeń
|   +-- rest-api/                <- WordPress REST API
|   +-- theme-compat/            <- Kompatybilność motywów
|   +-- class-wp.php             <- Główna klasa WordPress
|   +-- class-wpdb.php           <- Klasa obsługi bazy danych
|   +-- class-wp-query.php       <- Klasa zapytań (WP_Query)
|   +-- functions.php            <- Funkcje pomocnicze
|   +-- post.php                 <- Funkcje postów
|   +-- user.php                 <- Funkcje użytkowników
|   +-- pluggable.php            <- Funkcje do nadpisania
|   +-- template-loader.php      <- Ładowanie szablonów
|   +-- template.php             <- Funkcje szablonów
|   +-- formatting.php           <- Formatowanie tekstu
|
+-- wp-content/                  <- TWOJE PLIKI (edytuj tutaj!)
|   +-- plugins/                 <- Zainstalowane pluginy
|   |   +-- akismet/             <- Plugin Akismet (antyspam)
|   |   +-- woocommerce/         <- Plugin WooCommerce
|   |   +-- twoj-plugin/         <- Twój własny plugin
|   |       +-- twoj-plugin.php  <- Główny plik pluginu
|   |       +-- includes/        <- Klasy pluginu
|   |       +-- assets/          <- CSS, JS, obrazy
|   |
|   +-- themes/                  <- Zainstalowane motywy
|   |   +-- twentytwentyfour/    <- Motyw domyślny
|   |   |   +-- functions.php    <- Funkcje motywu
|   |   |   +-- style.css        <- Główny arkusz stylów
|   |   |   +-- index.php        <- Fallback szablon
|   |   |   +-- single.php       <- Szablon posta
|   |   |   +-- page.php         <- Szablon strony
|   |   |   +-- header.php       <- Nagłówek
|   |   |   +-- footer.php       <- Stopka
|   |   |   +-- sidebar.php      <- Pasek boczny
|   |   |   +-- archive.php      <- Archiwum
|   |   |   +-- search.php       <- Wyniki wyszukiwania
|   |   |   +-- 404.php          <- Strona błędu 404
|   |   |   +-- screenshot.png   <- Miniatura motywu
|   |   |   +-- parts/           <- Block parts (FSE)
|   |   |   +-- patterns/        <- Block patterns
|   |   |   +-- templates/       <- Block templates (FSE)
|   |   |
|   |   +-- twoj-motyw/          <- Twój własny motyw
|   |
|   +-- uploads/                 <- Pliki mediów
|   |   +-- 2025/                <- Rok
|   |       +-- 01/              <- Miesiąc
|   |           +-- obraz.jpg
|   |
|   +-- languages/               <- Tłumaczenia (.po, .mo)
|   +-- mu-plugins/              <- Must-Use plugins (zawsze aktywne)
|
+-- index.php                    <- Punkt wejścia
+-- wp-blog-header.php           <- Nagłówek bloga
+-- wp-config.php                <- KONFIGURACJA (hasła DB!)
+-- wp-config-sample.php         <- Przykład konfiguracji
+-- wp-cron.php                  <- Zadania cron WordPress
+-- wp-login.php                 <- Strona logowania
+-- wp-signup.php                <- Rejestracja (multisite)
+-- wp-trackback.php             <- Obsługa trackbacków
+-- xmlrpc.php                   <- XML-RPC API (stare)
+-- .htaccess                    <- Konfiguracja Apache (permalinki)
+-- readme.html                  <- Info o wersji
```

---

## 7. STRUKTURA FOLDEROW JOOMLA

```
joomla/
|
+-- administrator/               <- Panel administracyjny
|   +-- components/             <- Komponenty panelu admina
|   |   +-- com_content/        <- Zarządzanie artykułami
|   |   +-- com_users/          <- Zarządzanie użytkownikami
|   |   +-- com_modules/        <- Zarządzanie modułami
|   |   +-- com_menus/          <- Zarządzanie menu
|   |   +-- com_installer/      <- Instalator rozszerzeń
|   |
|   +-- language/               <- Tłumaczenia panelu
|   +-- modules/                <- Moduły panelu admina
|   +-- templates/              <- Szablony panelu (isis, atum)
|   +-- index.php               <- Punkt wejścia panelu
|
+-- api/                         <- Joomla REST API (od 4.0)
|   +-- components/             <- API endpointy komponentów
|
+-- cache/                       <- Pliki cache (nie edytuj)
+-- cli/                         <- Skrypty CLI
|
+-- components/                  <- Komponenty front-end
|   +-- com_content/            <- Wyświetlanie artykułów
|   |   +-- controllers/        <- Kontrolery MVC
|   |   +-- models/             <- Modele MVC (SQL)
|   |   +-- views/              <- Widoki MVC
|   |   |   +-- article/        <- Widok artykułu
|   |   |       +-- tmpl/       <- Szablony widoku
|   |   +-- helpers/            <- Funkcje pomocnicze
|   |
|   +-- com_users/              <- Rejestracja/logowanie
|   +-- com_search/             <- Wyszukiwarka
|   +-- com_contact/            <- Formularz kontaktowy
|
+-- images/                      <- Obrazy (jak wp uploads)
|   +-- stories/                <- Obrazy do artykułów (stare)
|   +-- headers/                <- Obrazy nagłówkowe
|
+-- includes/                    <- Pliki pomocnicze core Joomla
+-- installation/                <- Instalator (USUŃ po instalacji!)
|
+-- language/                    <- Pliki językowe front-end
|   +-- en-GB/                  <- Angielski
|   +-- pl-PL/                  <- Polski
|
+-- layouts/                     <- Layouty wielokrotnego użytku
+-- libraries/                   <- Biblioteki Joomla Framework
|   +-- joomla/                 <- Core biblioteki JFramework
|   |   +-- application/        <- JApplication
|   |   +-- database/           <- JDatabase, JFactory
|   |   +-- factory.php         <- JFactory (serwis locator)
|   |   +-- user/               <- JUser
|   |
|   +-- vendor/                 <- Biblioteki zewnętrzne (Composer)
|
+-- logs/                        <- Logi błędów
+-- media/                       <- JS, CSS, obrazy komponentów
|   +-- com_content/
|   +-- jui/                    <- jQuery UI
|   +-- system/                 <- Pliki systemu
|
+-- modules/                     <- Moduły front-end
|   +-- mod_menu/               <- Moduł menu
|   +-- mod_breadcrumbs/        <- Okruszki nawigacyjne
|   +-- mod_login/              <- Formularz logowania
|   +-- mod_search/             <- Wyszukiwarka
|
+-- plugins/                     <- Pluginy (obsługa zdarzeń)
|   +-- authentication/         <- Uwierzytelnianie
|   +-- content/                <- Przetwarzanie treści
|   +-- editors/                <- Edytory WYSIWYG (TinyMCE)
|   +-- search/                 <- Wyszukiwarki
|   +-- system/                 <- Pluginy systemowe
|   +-- user/                   <- Pluginy użytkownika
|
+-- templates/                   <- Szablony front-end
|   +-- protostar/              <- Domyślny szablon (Joomla 3)
|   +-- cassiopeia/             <- Domyślny szablon (Joomla 4+)
|   |   +-- css/
|   |   +-- html/               <- Override szablonów
|   |   +-- images/
|   |   +-- index.php           <- Główny plik szablonu
|   |   +-- templateDetails.xml <- Opis szablonu
|
+-- tmp/                         <- Pliki tymczasowe
+-- index.php                    <- Punkt wejścia
+-- configuration.php            <- KONFIGURACJA (hasła DB!)
+-- htaccess.txt                 <- Wzór .htaccess (zmień nazwę!)
+-- joomla.xml                   <- Manifest Joomla
+-- robots.txt                   <- Instrukcje dla robotów
```

---

## 8. SCHEMAT BAZY DANYCH WORDPRESS

```
GŁÓWNE TABELE WORDPRESS (prefiks: wp_):
========================================

+=====================+         +======================+
|     wp_posts        |         |    wp_postmeta       |
+=====================+         +======================+
| PK ID         BIGINT|-------->| PK meta_id    BIGINT |
|    post_author BINT |    1:N  | FK post_id    BIGINT |
|    post_date DATETIME         |    meta_key   VARCHAR|
|    post_content LONG|         |    meta_value LONGTEXT
|    post_title  TEXT |         +======================+
|    post_status  VAR |         (niestandardowe pola postów)
|    post_type    VAR |
|    post_name    VAR |         +======================+
|    post_parent BINT |         |    wp_termmeta       |
+=====================+         +======================+
         |                      | PK meta_id    BIGINT |
         | N                    | FK term_id    BIGINT |
         |                      |    meta_key   VARCHAR|
+=====================+         |    meta_value LONG   |
|  wp_term_relation.  |         +======================+
+=====================+
| FK object_id  BIGINT|
| FK term_tax_id BINT |
+=====================+
         |
         | N
+=====================+         +======================+
| wp_term_taxonomy    |         |     wp_terms         |
+=====================+         +======================+
| PK term_tax_id BINT |-------->| PK term_id    BIGINT |
| FK term_id     BINT |    N:1  |    name       VARCHAR|
|    taxonomy    VAR  |         |    slug       VARCHAR|
|    description TEXT |         |    term_group BIGINT |
|    parent      BINT |         +======================+
|    count       BINT |
+=====================+

+======================+         +======================+
|     wp_users         |         |     wp_usermeta      |
+======================+         +======================+
| PK ID         BIGINT |-------->| PK umeta_id   BIGINT |
|    user_login   VAR  |    1:N  | FK user_id    BIGINT |
|    user_pass    VAR  |         |    meta_key   VARCHAR|
|    user_email   VAR  |         |    meta_value LONG   |
|    user_regist DTIME |         +======================+
|    display_name VAR  |
+======================+

+======================+
|     wp_options       |
+======================+
| PK option_id  BIGINT |
|    option_name  VAR  |   <- unikalna nazwa opcji
|    option_value LONG |   <- wartość (serializowana PHP)
|    autoload     VAR  |   <- 'yes'/'no'
+======================+
(Ustawienia WordPress: nazwa strony, URL, motyw, etc.)

+======================+
|     wp_comments      |
+======================+
| PK comment_ID  BIGINT|
| FK comment_post BINT |  -> wp_posts.ID
|    comment_author VAR|
|    comment_content TX|
|    comment_date DTIME|
|    comment_approved VA
+======================+

WAŻNE TYPY POSTÓW (post_type w wp_posts):
  post        — standardowy wpis blogowy
  page        — strona statyczna
  attachment  — plik/obraz
  revision    — wersja robocza/rewizja
  nav_menu_item — element menu
  custom_post — własny typ (przez register_post_type())

WAŻNE TAKSONOMIE (taxonomy w wp_term_taxonomy):
  category    — kategorie postów
  post_tag    — tagi postów
  nav_menu    — menu nawigacyjne
  własna      — przez register_taxonomy()
```

---

## 9. SCHEMAT BAZY DANYCH JOOMLA

```
GŁÓWNE TABELE JOOMLA (prefiks: jos_ lub własny):
=================================================

+======================+         +======================+
|    jos_content       |         |   jos_categories     |
+======================+         +======================+
| PK id         INT    |         | PK id         INT    |
|    title    VARCHAR  |         |    title    VARCHAR  |
|    alias    VARCHAR  |         |    alias    VARCHAR  |
|    introtext  MEDIUM |         |    extension  VARCHAR|
|    fulltext   MEDIUM |         |    parent_id  INT    |
|    state      TINYINT|         |    published  TINYINT|
|    catid      INT    |-------->|    access     INT    |
|    created    DATETIME         +======================+
|    created_by INT    |
|    access     INT    |
|    hits       INT    |
+======================+

+======================+         +======================+
|     jos_users        |         |   jos_user_groups    |
+======================+         +======================+
| PK id         INT    |         | PK id         INT    |
|    name     VARCHAR  |         |    parent_id  INT    |
|    username VARCHAR  |         |    title    VARCHAR  |
|    email    VARCHAR  |         +======================+
|    password VARCHAR  |                  |
|    block    TINYINT  |                  | M:N
|    registerDate DT   |                  |
|    lastvisitDate DT  |         +======================+
+======================+         |  jos_user_usergroup  |
                                 +======================+
                                 | FK user_id    INT    |
                                 | FK group_id   INT    |
                                 +======================+

+======================+
|    jos_modules       |
+======================+
| PK id         INT    |
|    title    VARCHAR  |
|    content    TEXT   |
|    ordering   INT    |
|    position VARCHAR  |   <- pozycja w szablonie (np. "top")
|    published  INT    |
|    module   VARCHAR  |   <- np. "mod_menu"
|    access     INT    |
+======================+

+======================+
|    jos_menu          |
+======================+
| PK id         INT    |
|    menutype VARCHAR  |   <- nazwa menu
|    title    VARCHAR  |
|    alias    VARCHAR  |
|    link     VARCHAR  |   <- URL lub link komponentu
|    type     VARCHAR  |   <- component, url, alias, etc.
|    component_id INT  |
|    parent_id  INT    |   <- dla submenu
|    ordering   INT    |
|    published  INT    |
|    access     INT    |
+======================+

+======================+
|   jos_extensions     |
+======================+
| PK extension_id INT  |
|    name     VARCHAR  |
|    type     VARCHAR  |  <- component, module, plugin, template
|    element  VARCHAR  |  <- np. com_content, mod_menu
|    enabled  TINYINT  |
|    protected TINYINT |
|    manifest_cache TX |
+======================+

+======================+
|    jos_session       |
+======================+
| PK session_id VARCHAR|
|    guest    TINYINT  |
|    time     VARCHAR  |
|    userid   INT      |
|    data     MEDIUM   |  <- dane sesji (serializowane)
+======================+
```

---

## 10. CYKL ZYCIA PLUGINU WORDPRESS

```
CYKL ZYCIA PLUGINU WORDPRESS:
==============================

FAZA 1: INSTALACJA
+=============================+
| Admin klika "Zainstaluj"    |
| WordPress pobiera plik .zip |
| Rozpakowuje do wp-content/  |
|   plugins/nazwa-pluginu/    |
| Wywołuje:                   |
|   register_activation_hook()|
| -> Tworzysz tabele, opcje,  |
|    domyślne ustawienia      |
+=============================+
          |
          v

FAZA 2: AKTYWACJA
+=============================+
| Admin klika "Aktywuj"       |
| WordPress:                  |
|   1. Sprawdza wymagania     |
|      (wersja WP, PHP)       |
|   2. Wywołuje callback      |
|      aktywacji              |
|   3. Dodaje plugin do listy |
|      aktywnych pluginów     |
|      (wp_options: active_p.)|
+=============================+
          |
          v

FAZA 3: DZIAŁANIE (każde żądanie HTTP)
+=============================+
| WordPress ładuje pluginy    |
| (z wp-settings.php)         |
|                             |
| 1. require główny plik.php  |
| 2. Plugin rejestruje hooki: |
|    add_action('init', ...)  |
|    add_filter('the_content')|
|    add_action('wp_head', ..)| 
|                             |
| 3. WP wykonuje hooki        |
|    w określonej kolejności  |
+=============================+
          |
          v

FAZA 4: DEAKTYWACJA
+=============================+
| Admin klika "Deaktywuj"     |
| WordPress wywołuje:         |
|   register_deactivation_hook|
| -> Możesz: wyczyść cache,   |
|    usuń zaplanowane zadania |
|    (NIE usuwaj danych!)     |
+=============================+
          |
          v

FAZA 5: DEINSTALACJA (opcjonalna)
+=============================+
| Admin klika "Usuń"          |
| WordPress wywołuje:         |
|   register_uninstall_hook() |
|   lub uninstall.php         |
| -> Usuń tabele, opcje,      |
|    wszystkie dane pluginu   |
+=============================+

HOOKI WORDPRESS — SYSTEM ZDARZEŃ:
==================================

Actions (zdarzenia — wykonaj coś):
  add_action('init',    'moja_funkcja');
  add_action('wp_head', 'dodaj_style');
  add_action('save_post', 'po_zapisie');
  
Filters (filtry — zmodyfikuj dane):
  add_filter('the_content', 'zmien_tresc');
  add_filter('the_title',   'zmien_tytul');
  add_filter('wp_title',    'zmien_meta');

KOLEJNOŚĆ HOOKÓW (uproszczona):
  muplugins_loaded  -> Ładowanie mu-plugins
  plugins_loaded    -> Ładowanie pluginów
  setup_theme       -> Ładowanie motywu
  after_setup_theme -> Po załadowaniu motywu
  init              -> Inicjalizacja (rejestruj CPT, taksonomie)
  wp_loaded         -> Wszystko załadowane
  wp                -> Główne zapytanie WP gotowe
  template_redirect -> Przed ładowaniem szablonu
  wp_head           -> Wewnątrz <head> HTML
  wp_footer         -> Przed </body>
  shutdown          -> Koniec skryptu PHP

PRZYKŁADOWY PLUGIN (minimalny):
================================
<?php
/*
Plugin Name: Mój Plugin
Description: Przykładowy plugin WordPress
Version: 1.0
Author: Jan Kowalski
*/

// Aktywacja: tworzenie tabeli
register_activation_hook(__FILE__, 'moj_plugin_aktywacja');
function moj_plugin_aktywacja() {
    global $wpdb;
    $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}moje_dane (
        id INT PRIMARY KEY AUTO_INCREMENT,
        dane TEXT
    )");
}

// Hook: dodaj treść po każdym poście
add_filter('the_content', 'moj_plugin_tresc');
function moj_plugin_tresc($tresc) {
    return $tresc . '<p>Dodane przez plugin!</p>';
}

// Deaktywacja
register_deactivation_hook(__FILE__, 'moj_plugin_deaktywacja');
function moj_plugin_deaktywacja() {
    // wyczyść cache, usuń crony
    wp_clear_scheduled_hook('moje_zadanie_cron');
}
```

---

*Plik wygenerowany dla kursu INF.03 — Technik Programista*
*Dotyczy: architektura CMS, WordPress, Joomla, model MVC*
