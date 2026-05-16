# Język Angielski Zawodowy - Słownictwo IT

> Ściągawka do egzaminu INF.03 - INF.03.6 Język obcy zawodowy

---

## 1. BAZY DANYCH (Databases)

| Angielski         | Polski                  | Przykład użycia                                      |
|-------------------|-------------------------|------------------------------------------------------|
| database          | baza danych             | *The database stores all user information.*          |
| table             | tabela                  | *Create a table named "users".*                      |
| field / column    | pole / kolumna          | *Add a new field to the table.*                      |
| record / row      | rekord / wiersz         | *Each record has a unique ID.*                       |
| query             | zapytanie               | *Run this query to get the results.*                 |
| index             | indeks                  | *Add an index to speed up searches.*                 |
| primary key       | klucz główny            | *The primary key must be unique.*                    |
| foreign key       | klucz obcy              | *The foreign key links two tables.*                  |
| join              | łączenie (tabel)        | *Use JOIN to combine data from two tables.*          |
| constraint        | ograniczenie            | *A NOT NULL constraint prevents empty values.*       |
| relation          | relacja                 | *This is a one-to-many relation.*                    |
| schema            | schemat                 | *The database schema defines all tables.*            |
| transaction       | transakcja              | *Roll back the transaction on error.*                |
| stored procedure  | procedura składowana    | *Call the stored procedure to process data.*         |
| view              | widok                   | *Create a view for the report.*                      |
| trigger           | wyzwalacz               | *The trigger fires on INSERT.*                       |
| migration         | migracja                | *Run the database migration to update the schema.*   |
| backup            | kopia zapasowa          | *Schedule a nightly database backup.*                |
| restore           | przywracanie            | *Restore the database from the backup file.*         |
| normalization     | normalizacja            | *Normalization reduces data redundancy.*             |

### Przydatne SQL po angielsku

```sql
-- Select records from table
SELECT * FROM users WHERE active = 1;

-- Insert a new record
INSERT INTO products (name, price) VALUES ('Widget', 9.99);

-- Update an existing record
UPDATE orders SET status = 'shipped' WHERE id = 42;

-- Delete a record
DELETE FROM sessions WHERE expires < NOW();

-- Join two tables
SELECT users.name, orders.total
FROM users
JOIN orders ON orders.user_id = users.id;
```

---

## 2. FRONTEND

| Angielski            | Polski                      | Przykład użycia                                        |
|----------------------|-----------------------------|--------------------------------------------------------|
| browser              | przeglądarka                | *The browser renders the HTML and CSS.*                |
| markup               | znaczniki                   | *HTML is a markup language.*                           |
| stylesheet           | arkusz stylów               | *Link an external stylesheet to the page.*             |
| responsive           | responsywny                 | *The layout is responsive on all screen sizes.*        |
| viewport             | obszar widoczny             | *Set the viewport meta tag for mobile devices.*        |
| framework            | środowisko / framework      | *We use the React framework for the UI.*               |
| library              | biblioteka                  | *jQuery is a popular JavaScript library.*              |
| component            | komponent                   | *Create a reusable button component.*                  |
| template             | szablon                     | *The HTML template is used for all pages.*             |
| placeholder          | tekst zastępczy             | *Add a placeholder to the input field.*                |
| tooltip              | dymek podpowiedzi           | *Show a tooltip when hovering over the icon.*          |
| dropdown             | lista rozwijana             | *The dropdown menu shows category options.*            |
| modal                | okno modalne                | *Click the button to open the modal dialog.*           |
| carousel             | karuzela / slider           | *The image carousel rotates every 5 seconds.*          |
| pagination           | paginacja / stronicowanie   | *Add pagination to show 10 results per page.*          |
| breadcrumb           | ścieżka nawigacji           | *The breadcrumb shows where the user is.*              |
| grid                 | siatka                      | *Use a 12-column grid for the layout.*                 |
| flexbox              | flexbox                     | *Flexbox makes centering elements easy.*               |
| media query          | zapytanie medialne          | *Add a media query for mobile screens.*                |
| accessibility (a11y) | dostępność                  | *Add alt text for accessibility.*                      |
| SEO                  | pozycjonowanie              | *Good meta tags improve SEO rankings.*                 |

---

## 3. BACKEND

| Angielski          | Polski                      | Przykład użycia                                          |
|--------------------|-----------------------------|----------------------------------------------------------|
| server             | serwer                      | *The server processes all incoming requests.*            |
| request            | żądanie                     | *Send a POST request with the form data.*                |
| response           | odpowiedź                   | *The server returns a 200 OK response.*                  |
| session            | sesja                       | *Store the user ID in the session.*                      |
| cookie             | ciasteczko                  | *The cookie expires after 30 days.*                      |
| authentication     | uwierzytelnianie            | *Require authentication before accessing the dashboard.*  |
| authorization      | autoryzacja                 | *Check authorization before deleting records.*           |
| endpoint           | punkt końcowy (API)         | *Call the /users endpoint to get all users.*             |
| middleware         | oprogramowanie pośrednie    | *Add middleware to log all requests.*                    |
| cache              | pamięć podręczna            | *Cache the query results for 1 hour.*                    |
| payload            | ładunek / dane              | *Parse the JSON payload from the request body.*          |
| header             | nagłówek                    | *Set the Content-Type header to application/json.*       |
| status code        | kod statusu                 | *Return a 404 status code if not found.*                 |
| API                | interfejs programistyczny   | *The API returns data in JSON format.*                   |
| REST               | REST (styl architektury)    | *This is a RESTful API with standard HTTP methods.*      |
| log / logging      | dziennik / logowanie        | *Log all errors to a file.*                              |
| environment        | środowisko                  | *Use different settings for dev and production.*         |
| configuration      | konfiguracja                | *Store sensitive data in the config file.*               |

### Kody statusu HTTP po angielsku

| Kod  | Nazwa                  | Znaczenie                          |
|------|------------------------|------------------------------------|
| 200  | OK                     | Żądanie zakończyło się sukcesem    |
| 201  | Created                | Zasób został utworzony             |
| 301  | Moved Permanently      | Stałe przekierowanie               |
| 302  | Found                  | Tymczasowe przekierowanie          |
| 400  | Bad Request            | Błędne żądanie                     |
| 401  | Unauthorized           | Wymagane uwierzytelnienie          |
| 403  | Forbidden              | Brak uprawnień                     |
| 404  | Not Found              | Zasób nie istnieje                 |
| 500  | Internal Server Error  | Błąd po stronie serwera            |

---

## 4. SIEĆ I HOSTING

| Angielski         | Polski                      | Przykład użycia                                         |
|-------------------|-----------------------------|---------------------------------------------------------|
| protocol          | protokół                    | *HTTP and HTTPS are web protocols.*                     |
| domain            | domena                      | *Register the domain name first.*                       |
| subdomain         | subdomena                   | *Use blog.example.com as a subdomain.*                  |
| hosting           | hosting                     | *We use shared hosting for the website.*                |
| bandwidth         | przepustowość               | *The bandwidth limit is 100 GB per month.*              |
| latency           | opóźnienie                  | *High latency causes the page to load slowly.*          |
| SSL certificate   | certyfikat SSL              | *Install an SSL certificate for HTTPS.*                 |
| DNS               | system nazw domenowych      | *Update the DNS records to point to the new server.*    |
| IP address        | adres IP                    | *The server has a static IP address.*                   |
| port              | port                        | *The web server listens on port 80.*                    |
| firewall          | zapora sieciowa             | *The firewall blocks unauthorized access.*              |
| VPN               | wirtualna sieć prywatna     | *Use a VPN to secure the connection.*                   |
| FTP / SFTP        | protokół transferu plików   | *Upload files via SFTP to the server.*                  |
| uptime            | dostępność / czas działania | *The server has 99.9% uptime guarantee.*                |
| downtime          | niedostępność               | *Scheduled downtime for maintenance tonight.*           |

---

## 5. BEZPIECZENSTWO (Security)

| Angielski           | Polski                   | Przykład użycia                                           |
|---------------------|--------------------------|-----------------------------------------------------------|
| vulnerability       | luka (w zabezpieczeniach)| *A critical vulnerability was found in the plugin.*       |
| exploit             | wykorzystanie luki       | *Hackers used an exploit to access the database.*         |
| patch               | łatka / aktualizacja     | *Apply the security patch immediately.*                   |
| encryption          | szyfrowanie              | *All passwords must be stored with encryption.*           |
| hashing             | hashowanie               | *Use bcrypt for hashing passwords.*                       |
| SQL Injection       | wstrzyknięcie SQL        | *Validate input to prevent SQL injection.*                |
| XSS                 | cross-site scripting     | *Escape output to prevent XSS attacks.*                   |
| CSRF                | fałszowanie żądań        | *Add a CSRF token to all forms.*                          |
| sanitization        | oczyszczanie danych      | *Sanitize all user input before saving.*                  |
| validation          | walidacja                | *Validate the email format before sending.*               |
| brute force         | atak siłowy              | *Limit login attempts to prevent brute force.*            |
| two-factor auth     | uwierzytelnianie 2FA     | *Enable two-factor authentication for security.*          |
| HTTPS               | bezpieczny HTTP          | *Always use HTTPS for secure connections.*                |
| permissions         | uprawnienia              | *Check file permissions on the server.*                   |
| rate limiting       | ograniczenie szybkości   | *Rate limiting prevents API abuse.*                       |

---

## 6. PROGRAMOWANIE (Programming)

| Angielski            | Polski                     | Przykład użycia                                          |
|----------------------|----------------------------|----------------------------------------------------------|
| variable             | zmienna                    | *Declare a variable to store the result.*                |
| constant             | stała                      | *Define a constant for the tax rate.*                    |
| function             | funkcja                    | *Write a function to calculate the total.*               |
| method               | metoda                     | *Call the save() method on the object.*                  |
| class                | klasa                      | *Create a User class with properties and methods.*       |
| object               | obiekt                     | *Instantiate a new object from the class.*               |
| array                | tablica                    | *Store the results in an array.*                         |
| loop                 | pętla                      | *Use a loop to iterate over all records.*                |
| condition            | warunek                    | *Add a condition to check the user's role.*              |
| return value         | wartość zwracana           | *The function returns a boolean value.*                  |
| parameter / argument | parametr / argument        | *Pass the ID as a parameter to the function.*            |
| string               | ciąg znaków                | *Concatenate two strings with the dot operator.*         |
| integer              | liczba całkowita           | *Cast the value to an integer with intval().*            |
| boolean              | wartość logiczna           | *The function returns true or false.*                    |
| null                 | wartość pusta              | *Check if the result is null before using it.*           |
| exception            | wyjątek                    | *Catch the exception and log the error.*                 |
| debugging            | debugowanie                | *Use var_dump() for debugging.*                          |
| refactoring          | refaktoryzacja             | *Refactor the code to remove duplication.*               |
| recursion            | rekurencja                 | *Use recursion to traverse the tree.*                    |
| algorithm            | algorytm                   | *Choose an efficient sorting algorithm.*                  |
| inheritance          | dziedziczenie              | *The Admin class inherits from User.*                    |
| interface            | interfejs                  | *Implement the interface to enforce structure.*          |

---

## 7. NARZĘDZIA DEWELOPERSKIE (Dev Tools & Workflow)

| Angielski          | Polski                         | Przykład użycia                                          |
|--------------------|--------------------------------|----------------------------------------------------------|
| version control    | kontrola wersji                | *Use version control to track changes.*                  |
| repository         | repozytorium                   | *Clone the repository from GitHub.*                      |
| commit             | zatwierdzenie zmian            | *Commit your changes with a clear message.*              |
| branch             | gałąź                          | *Create a new branch for the feature.*                   |
| merge              | scalenie                       | *Merge the feature branch into main.*                    |
| pull request       | propozycja zmian (PR)          | *Open a pull request for code review.*                   |
| code review        | przegląd kodu                  | *Code review helps catch bugs early.*                    |
| deployment         | wdrożenie                      | *Deploy the application to the production server.*       |
| staging            | środowisko testowe             | *Test the changes on staging before deploying.*          |
| rollback           | cofnięcie zmian                | *Rollback to the previous version if it fails.*          |
| CI/CD              | ciągła integracja/dostarczanie | *The CI/CD pipeline runs tests automatically.*           |
| dependency         | zależność                      | *Install all dependencies with npm install.*             |
| package manager    | menedżer pakietów              | *Use Composer as the PHP package manager.*               |
| IDE                | zintegrowane środowisko        | *VS Code is a popular IDE for web development.*          |
| linter             | narzędzie analizy kodu         | *The linter flags unused variables.*                     |
| breakpoint         | punkt przerwania               | *Set a breakpoint to pause execution.*                   |
| console            | konsola                        | *Check the browser console for errors.*                  |

---

## 8. DOKUMENTACJA TECHNICZNA

### Jak czytać dokumentację API

```
GET /api/users/{id}
```
- `GET` - metoda HTTP (GET, POST, PUT, DELETE, PATCH)
- `/api/users/{id}` - ścieżka, `{id}` = parametr
- **Returns**: zwraca
- **Parameters**: parametry
- **Request body**: ciało żądania
- **Response**: odpowiedź
- **Example**: przykład
- **Deprecated**: przestarzały (nie używaj)
- **Required**: wymagany
- **Optional**: opcjonalny
- **Default**: domyślna wartość

### Typowa struktura README

```markdown
# Project Name
Short description.

## Requirements
- PHP 8.0+
- MySQL 5.7+

## Installation
1. Clone the repository
2. Run composer install
3. Configure .env file

## Usage
Brief instructions on how to use the project.

## Contributing
How to contribute to the project.

## License
MIT License
```

### Słownictwo README / Changelog

| Angielski        | Polski              |
|------------------|---------------------|
| installation     | instalacja          |
| requirements     | wymagania           |
| usage            | użycie              |
| configuration    | konfiguracja        |
| contributing     | wkład w projekt     |
| license          | licencja            |
| changelog        | dziennik zmian      |
| release          | wydanie / wersja    |
| breaking change  | niekompatybilna zmiana |
| bug fix          | naprawa błędu       |
| new feature      | nowa funkcja        |
| improvement      | ulepszenie          |
| deprecated       | przestarzały        |

---

## 9. PRZYDATNE FRAZY W PRACY ZAWODOWEJ

### Frazy do opisywania błędów i rozwiązań

| Fraza angielska                             | Tłumaczenie polskie                              |
|---------------------------------------------|--------------------------------------------------|
| The bug was fixed in version 2.1            | Błąd został naprawiony w wersji 2.1              |
| This feature is not supported               | Ta funkcja nie jest obsługiwana                  |
| Please refer to the documentation           | Proszę zapoznaj się z dokumentacją              |
| The issue occurs when...                    | Problem występuje gdy...                         |
| As a workaround, you can...                 | Jako obejście, możesz...                         |
| This has been deprecated                    | To zostało oznaczone jako przestarzałe           |
| It throws an exception if...               | Zgłasza wyjątek jeśli...                         |
| The function returns null if not found      | Funkcja zwraca null gdy nie znajdzie             |
| Check the error log for details             | Sprawdź dziennik błędów dla szczegółów           |
| The default value is...                     | Wartość domyślna to...                           |
| Make sure to escape the output              | Upewnij się, że escapujesz dane wyjściowe        |
| Handle the edge case where...               | Obsłuż przypadek graniczny gdy...                |

### Opisy kodu po angielsku

```php
// This function validates the user input
// Returns true if valid, false otherwise
// Parameters:
//   $data - array of form fields
//   $required - array of required field names
function validateForm(array $data, array $required): bool {
    foreach ($required as $field) {
        if (empty($data[$field])) {
            return false;
        }
    }
    return true;
}
```

### Komunikaty błędów po angielsku

| Komunikat                          | Co oznacza                            |
|------------------------------------|---------------------------------------|
| `Access denied for user 'root'`    | Błędne hasło do bazy danych          |
| `Table doesn't exist`              | Tabela nie istnieje w bazie          |
| `Column not found`                 | Kolumna nie istnieje w tabeli        |
| `Connection refused`               | Serwer MySQL nie działa              |
| `Syntax error in SQL`              | Błąd składni w zapytaniu SQL         |
| `Undefined variable`               | Zmienna nie jest zadeklarowana       |
| `Undefined index`                  | Klucz tablicy nie istnieje           |
| `Fatal error: Call to undefined function` | Funkcja nie istnieje          |
| `Warning: Division by zero`        | Dzielenie przez zero                 |
| `Maximum execution time exceeded`  | Skrypt trwa za długo                 |
| `Out of memory`                    | Przekroczono limit pamięci           |
| `File not found`                   | Plik nie istnieje                    |
| `Permission denied`                | Brak uprawnień do pliku/katalogu     |

---

## 10. PRZYKŁADOWE ZDANIA TECHNICZNE EN/PL

### Opis strony internetowej

- EN: *The website consists of a header, main content area, sidebar, and footer.*
- PL: *Strona składa się z nagłówka, obszaru głównej treści, paska bocznego i stopki.*

- EN: *The navigation menu contains links to all main sections of the site.*
- PL: *Menu nawigacyjne zawiera linki do wszystkich głównych sekcji strony.*

- EN: *When the user clicks the button, a modal window appears with the form.*
- PL: *Gdy użytkownik klika przycisk, pojawia się okno modalne z formularzem.*

### Opis bazy danych

- EN: *The database contains three tables: users, orders, and products.*
- PL: *Baza danych zawiera trzy tabele: użytkownicy, zamówienia i produkty.*

- EN: *The orders table has a foreign key that references the users table.*
- PL: *Tabela zamówień posiada klucz obcy odwołujący się do tabeli użytkowników.*

- EN: *Run a JOIN query to retrieve data from multiple tables at once.*
- PL: *Uruchom zapytanie JOIN, aby pobrać dane z wielu tabel jednocześnie.*

### Opis kodu PHP

- EN: *The script connects to the database and fetches all records from the products table.*
- PL: *Skrypt łączy się z bazą danych i pobiera wszystkie rekordy z tabeli produktów.*

- EN: *User input must be validated and sanitized before being inserted into the database.*
- PL: *Dane wejściowe użytkownika muszą być zwalidowane i oczyszczone przed zapisem do bazy.*

- EN: *The while loop iterates through all rows returned by the query.*
- PL: *Pętla while iteruje przez wszystkie wiersze zwrócone przez zapytanie.*

### Opis problemów i rozwiązań

- EN: *The page does not display correctly because the stylesheet is missing.*
- PL: *Strona nie wyświetla się poprawnie, ponieważ brakuje arkusza stylów.*

- EN: *The layout breaks on mobile devices because the columns have fixed widths.*
- PL: *Layout psuje się na urządzeniach mobilnych, ponieważ kolumny mają stałą szerokość.*

- EN: *To fix this issue, add `box-sizing: border-box` to all elements.*
- PL: *Aby naprawić ten problem, dodaj `box-sizing: border-box` do wszystkich elementów.*

---

## PODSUMOWANIE DO EGZAMINU

### Najważniejsze terminy - muszę znać

**Bazy danych**: database, table, field, record, query, primary key, foreign key, join, index

**Programowanie**: variable, function, loop, condition, array, object, class, method, string, integer, boolean, null

**Frontend**: browser, stylesheet, responsive, viewport, framework, library, component

**Backend**: server, request, response, session, cookie, authentication, authorization, API

**Sieć**: protocol, domain, hosting, SSL certificate, firewall, bandwidth, latency

**Bezpieczeństwo**: vulnerability, encryption, SQL injection, XSS, validation, sanitization

### Skróty IT które musisz znać

| Skrót | Pełna nazwa                         | Znaczenie PL                        |
|-------|-------------------------------------|-------------------------------------|
| HTTP  | HyperText Transfer Protocol         | Protokół przesyłania stron          |
| HTTPS | HTTP Secure                         | Bezpieczna wersja HTTP              |
| HTML  | HyperText Markup Language           | Język znaczników                    |
| CSS   | Cascading Style Sheets              | Kaskadowe arkusze stylów            |
| SQL   | Structured Query Language           | Język zapytań baz danych            |
| PHP   | PHP: Hypertext Preprocessor         | Język skryptowy backend             |
| API   | Application Programming Interface   | Interfejs programistyczny           |
| URL   | Uniform Resource Locator            | Adres zasobu (strony)               |
| DNS   | Domain Name System                  | System nazw domenowych              |
| FTP   | File Transfer Protocol              | Protokół transferu plików           |
| SSL   | Secure Sockets Layer                | Protokół szyfrowania                |
| IDE   | Integrated Development Environment  | Zintegrowane środowisko deweloperskie|
| CMS   | Content Management System           | System zarządzania treścią          |
| SEO   | Search Engine Optimization          | Optymalizacja wyszukiwarek          |
| CRUD  | Create, Read, Update, Delete        | Podstawowe operacje na danych       |
| JSON  | JavaScript Object Notation          | Format wymiany danych               |
| XML   | Extensible Markup Language          | Rozszerzalny język znaczników       |
| OOP   | Object-Oriented Programming         | Programowanie obiektowe             |
| UML   | Unified Modeling Language           | Ujednolicony język modelowania      |
| VCS   | Version Control System              | System kontroli wersji              |
