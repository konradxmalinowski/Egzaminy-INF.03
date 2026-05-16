# ŚCIĄGAWKA: JavaScript w Aplikacjach Webowych (INF.03.5)

> Zakres: programowanie po stronie klienta, komunikacja z PHP, DOM, zdarzenia, bezpieczeństwo
> Egzamin: INF.03 — Technik Programista

---

## SPIS TREŚCI

1. [Klient vs Serwer — gdzie działa JS?](#1-klient-vs-serwer)
2. [DOM Manipulation — praktyczne wzorce](#2-dom-manipulation)
3. [Fetch API z backendem PHP](#3-fetch-api)
4. [AJAX — XMLHttpRequest i Fetch](#4-ajax)
5. [LocalStorage i SessionStorage](#5-localstorage-i-sessionstorage)
6. [JSON — stringify, parse, walidacja](#6-json)
7. [Obsługa formularzy HTML](#7-obsluga-formularzy)
8. [Zdarzenia i delegacja](#8-zdarzenia-i-delegacja)
9. [Komunikacja PHP ↔ JS](#9-komunikacja-php-js)
10. [Bezpieczeństwo JavaScript](#10-bezpieczenstwo)
11. [Moduły ES6 — import/export](#11-moduly-es6)
12. [Promises vs async/await](#12-promises-vs-asyncawait)
13. [Error handling](#13-error-handling)
14. [Najczęstsze błędy JS](#14-najczestsze-bledy)
15. [Debugging](#15-debugging)
16. [Wzorce projektowe](#16-wzorce-projektowe)
17. [Przykłady z egzaminu INF.03](#17-przyklady-z-egzaminu)
18. [Anti-patterns — czego unikać](#18-anti-patterns)
19. [Kompatybilność i transpilacja](#19-kompatybilnosc-i-transpilacja)
20. [jQuery vs Vanilla JS](#20-jquery-vs-vanilla-js)

---

## 1. Klient vs Serwer

### JavaScript po stronie klienta (przeglądarka)

- Kod JS jest pobierany z serwera i **wykonywany w przeglądarce użytkownika**
- Ma dostęp do: DOM, window, localStorage, navigator, fetch
- NIE ma dostępu do: systemu plików, bazy danych, zmiennych środowiskowych
- Użytkownik **może go zobaczyć i zmodyfikować** (DevTools → Sources)

```
Przeglądarka ← HTML+CSS+JS ← Serwer Apache/MAMP
     |
     JS wykonuje się tutaj
     Może wysyłać żądania do serwera (fetch/AJAX)
```

### Node.js (JavaScript po stronie serwera)

- JS wykonywany na serwerze, podobnie jak PHP
- Ma dostęp do: systemu plików (`fs`), bazy danych, portów sieciowych
- NIE ma dostępu do: DOM, window (bo nie ma przeglądarki)
- Na egzaminie INF.03 — głównie JS po stronie klienta, PHP po stronie serwera

### Porównanie — tabela

| Cecha                    | JS (przeglądarka)    | Node.js (serwer)    | PHP (serwer)        |
|--------------------------|----------------------|---------------------|---------------------|
| Gdzie działa             | u klienta            | na serwerze         | na serwerze         |
| Dostęp do DOM            | TAK                  | NIE                 | NIE                 |
| Dostęp do plików         | NIE                  | TAK (`fs`)          | TAK                 |
| Dostęp do bazy danych    | NIE (pośrednio)      | TAK                 | TAK                 |
| Widoczny dla użytkownika | TAK                  | NIE                 | NIE                 |
| Uruchamiany przez        | przeglądarkę         | Node runtime        | Apache/PHP-FPM      |

### Kiedy JS nie wystarczy

```javascript
// TO NIE ZADZIAŁA w przeglądarce:
const fs = require('fs'); // Node.js - nie ma w przeglądarce!
$conn = new mysqli(...);  // To jest PHP, nie JS

// Zamiast tego JS wysyła żądanie do PHP:
fetch('pobierz_dane.php')
  .then(r => r.json())
  .then(dane => wyswietl(dane));
```

---

## 2. DOM Manipulation

### Podstawowe selektory

```javascript
// Jeden element
const el = document.getElementById('myId');
const el = document.querySelector('.klasa');      // pierwszy pasujący
const el = document.querySelector('#id');
const el = document.querySelector('input[type="email"]');

// Wiele elementów (HTMLCollection lub NodeList)
const els = document.querySelectorAll('.klasa');  // NodeList (można forEach)
const els = document.getElementsByClassName('klasa'); // HTMLCollection
const els = document.getElementsByTagName('li');

// Iteracja
els.forEach(el => console.log(el.textContent));

// HTMLCollection nie ma forEach — konwersja:
Array.from(els).forEach(el => console.log(el));
```

### Tworzenie i wstawianie elementów

```javascript
// Tworzenie
const nowy = document.createElement('div');
nowy.textContent = 'Bezpieczny tekst';     // BEZPIECZNE
nowy.innerHTML = '<b>Uwaga!</b>';           // NIEBEZPIECZNE (XSS)
nowy.className = 'card alert';
nowy.id = 'mojaKarta';
nowy.setAttribute('data-id', '42');
nowy.style.color = 'red';

// Wstawianie
document.body.appendChild(nowy);           // na końcu body
parent.insertBefore(nowy, referencyjny);   // przed elementem
parent.prepend(nowy);                      // na początku rodzica
parent.append(nowy);                       // na końcu rodzica
el.insertAdjacentHTML('beforeend', html);  // wstawia HTML (ostrożnie z XSS!)

// Usuwanie
el.remove();
parent.removeChild(el);
```

### Formularz dynamiczny — dodawanie/usuwanie pól

```javascript
// HTML:
// <div id="kontener-pol"></div>
// <button id="dodaj">Dodaj pole</button>

let licznikPol = 0;

document.getElementById('dodaj').addEventListener('click', function() {
    licznikPol++;
    const kontener = document.getElementById('kontener-pol');

    // Tworzymy wrapper dla pola
    const wrapper = document.createElement('div');
    wrapper.className = 'pole-wrapper';
    wrapper.dataset.id = licznikPol;

    // Tworzymy input
    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'pole[]';
    input.id = 'pole-' + licznikPol;
    input.placeholder = 'Pole ' + licznikPol;
    input.className = 'form-control';

    // Tworzymy label
    const label = document.createElement('label');
    label.htmlFor = 'pole-' + licznikPol;
    label.textContent = 'Pole ' + licznikPol + ':';

    // Tworzymy przycisk usunięcia
    const btnUsun = document.createElement('button');
    btnUsun.type = 'button';
    btnUsun.textContent = 'Usuń';
    btnUsun.className = 'btn-usun';
    btnUsun.addEventListener('click', function() {
        wrapper.remove();
    });

    // Składamy w całość
    wrapper.appendChild(label);
    wrapper.appendChild(input);
    wrapper.appendChild(btnUsun);
    kontener.appendChild(wrapper);
});
```

### Walidacja formularza przed wysłaniem

```javascript
document.getElementById('moiFormularz').addEventListener('submit', function(e) {
    e.preventDefault(); // ZAWSZE zatrzymaj domyślne wysyłanie!

    let czyPoprawny = true;
    const komunikaty = [];

    // Pobierz wartości
    const imie = document.getElementById('imie').value.trim();
    const email = document.getElementById('email').value.trim();
    const haslo = document.getElementById('haslo').value;
    const hasloPotwierdzenie = document.getElementById('haslo2').value;

    // Walidacja imienia
    if (imie.length < 2) {
        komunikaty.push('Imię musi mieć co najmniej 2 znaki');
        czyPoprawny = false;
        document.getElementById('imie').classList.add('blad');
    } else {
        document.getElementById('imie').classList.remove('blad');
    }

    // Walidacja emaila
    const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regexEmail.test(email)) {
        komunikaty.push('Podaj prawidłowy adres email');
        czyPoprawny = false;
    }

    // Walidacja hasła
    if (haslo.length < 8) {
        komunikaty.push('Hasło musi mieć co najmniej 8 znaków');
        czyPoprawny = false;
    }

    // Potwierdzenie hasła
    if (haslo !== hasloPotwierdzenie) {
        komunikaty.push('Hasła nie są identyczne');
        czyPoprawny = false;
    }

    // Wyświetl błędy lub wyślij
    const divBledow = document.getElementById('bledy');
    if (!czyPoprawny) {
        divBledow.innerHTML = komunikaty.map(k => `<p class="blad">${k}</p>`).join('');
        divBledow.style.display = 'block';
    } else {
        divBledow.style.display = 'none';
        // Tutaj wysyłamy dane — np. przez fetch do PHP
        wyslijFormularz(new FormData(this));
    }
});
```

### Dynamiczne tabele — dodawanie wierszy

```javascript
// Dodaj wiersz do tabeli
function dodajWiersz(tabela, dane) {
    const tbody = tabela.querySelector('tbody');
    const tr = document.createElement('tr');

    dane.forEach(wartosc => {
        const td = document.createElement('td');
        td.textContent = wartosc; // textContent — bezpieczne!
        tr.appendChild(td);
    });

    // Kolumna akcji
    const tdAkcje = document.createElement('td');
    const btnUsun = document.createElement('button');
    btnUsun.textContent = 'Usuń';
    btnUsun.addEventListener('click', () => tr.remove());
    tdAkcje.appendChild(btnUsun);
    tr.appendChild(tdAkcje);

    tbody.appendChild(tr);
}

// Użycie
const tabela = document.getElementById('mojaTabela');
dodajWiersz(tabela, ['Jan Kowalski', 'jan@example.com', '2024-01-01']);
dodajWiersz(tabela, ['Anna Nowak', 'anna@example.com', '2024-02-15']);
```

---

## 3. Fetch API

### GET request do PHP — odbieranie JSON

```javascript
// PHP: pobierz_dane.php zwraca JSON: {"status":"ok","dane":[...]}

fetch('pobierz_dane.php')
    .then(function(response) {
        // Sprawdź czy odpowiedź jest OK (status 200-299)
        if (!response.ok) {
            throw new Error('Błąd serwera: ' + response.status);
        }
        return response.json(); // parsuje JSON do obiektu JS
    })
    .then(function(dane) {
        console.log(dane);
        wyswietlDane(dane);
    })
    .catch(function(blad) {
        console.error('Błąd:', blad);
        document.getElementById('komunikat').textContent = 'Nie udało się pobrać danych.';
    });

// Wyświetlenie danych z JSON
function wyswietlDane(dane) {
    const lista = document.getElementById('lista');
    lista.innerHTML = ''; // wyczyść

    dane.forEach(function(element) {
        const li = document.createElement('li');
        li.textContent = element.nazwa + ' — ' + element.cena + ' zł';
        lista.appendChild(li);
    });
}
```

### GET z parametrami URL

```javascript
const id = 5;
const kategoria = 'elektronika';

fetch(`szukaj.php?id=${id}&kategoria=${encodeURIComponent(kategoria)}`)
    .then(r => r.json())
    .then(dane => console.log(dane));

// Lub z URLSearchParams (bezpieczniejsze — automatycznie koduje):
const params = new URLSearchParams({
    id: 5,
    kategoria: 'elektronika',
    strona: 1
});
fetch('szukaj.php?' + params.toString())
    .then(r => r.json())
    .then(dane => console.log(dane));
```

### POST request z danymi formularza do PHP

```javascript
// Metoda 1: JSON
async function wyslijJSON(dane) {
    try {
        const response = await fetch('zapisz.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(dane)
        });

        const wynik = await response.json();

        if (wynik.status === 'ok') {
            alert('Zapisano pomyślnie!');
        } else {
            alert('Błąd: ' + wynik.komunikat);
        }
    } catch (blad) {
        console.error('Błąd sieci:', blad);
    }
}

// Metoda 2: FormData (multipart — też obsługuje pliki)
async function wyslijFormularz(formularz) {
    const formData = new FormData(formularz);

    try {
        const response = await fetch('zapisz.php', {
            method: 'POST',
            body: formData
            // NIE ustawiaj Content-Type — przeglądarka ustawi go automatycznie z boundary
        });

        const wynik = await response.json();
        console.log(wynik);
    } catch (blad) {
        console.error('Błąd:', blad);
    }
}

// PHP odbiera POST:
// $_POST['pole'] lub json_decode(file_get_contents('php://input'), true)
```

### Obsługa błędów sieciowych — kompletny wzorzec

```javascript
async function bezpieczneFetch(url, opcje = {}) {
    try {
        const response = await fetch(url, opcje);

        // Błąd HTTP (404, 500 itp.) — fetch NIE rzuca wyjątku dla błędów HTTP!
        if (!response.ok) {
            throw new Error(`Błąd HTTP: ${response.status} ${response.statusText}`);
        }

        // Sprawdź typ zawartości
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            return await response.json();
        } else {
            return await response.text();
        }

    } catch (blad) {
        if (blad instanceof TypeError) {
            // Brak połączenia sieciowego, CORS, itp.
            console.error('Błąd sieci (brak połączenia lub CORS):', blad.message);
        } else {
            // Błąd HTTP lub JSON parse error
            console.error('Błąd żądania:', blad.message);
        }
        throw blad; // rzuć dalej żeby wywołujący mógł obsłużyć
    }
}

// Użycie
bezpieczneFetch('api.php?akcja=lista')
    .then(dane => wyswietl(dane))
    .catch(blad => {
        document.getElementById('blad').textContent = 'Wystąpił błąd. Spróbuj ponownie.';
    });
```

---

## 4. AJAX

### XMLHttpRequest (stary sposób — nadal na egzaminach!)

```javascript
// GET z XMLHttpRequest
const xhr = new XMLHttpRequest();
xhr.open('GET', 'dane.php', true); // true = asynchronicznie

xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) { // DONE
        if (xhr.status === 200) {
            const dane = JSON.parse(xhr.responseText);
            console.log(dane);
        } else {
            console.error('Błąd:', xhr.status);
        }
    }
};

xhr.send();

// POST z XMLHttpRequest
const xhrPost = new XMLHttpRequest();
xhrPost.open('POST', 'zapisz.php', true);
xhrPost.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

xhrPost.onload = function() {
    if (xhrPost.status === 200) {
        console.log(xhrPost.responseText);
    }
};

xhrPost.send('imie=Jan&email=jan@example.com');
```

### Stany XMLHttpRequest

| readyState | Nazwa          | Opis                              |
|------------|----------------|-----------------------------------|
| 0          | UNSENT         | obiekt utworzony, open() nie wywołane |
| 1          | OPENED         | open() wywołane                   |
| 2          | HEADERS_RECEIVED | nagłówki odebrane               |
| 3          | LOADING        | trwa pobieranie danych            |
| 4          | DONE           | operacja zakończona               |

### Ładowanie treści bez przeładowania strony

```javascript
// Kliknięcie w link ładuje treść do <div id="tresc">
document.querySelectorAll('.ajax-link').forEach(function(link) {
    link.addEventListener('click', function(e) {
        e.preventDefault(); // zatrzymaj domyślną nawigację

        const url = this.getAttribute('href');
        const kontener = document.getElementById('tresc');

        // Pokaż spinner ładowania
        kontener.innerHTML = '<div class="spinner">Ładowanie...</div>';

        fetch(url)
            .then(r => r.text())
            .then(html => {
                kontener.innerHTML = html;
                // Zaktualizuj URL w pasku adresu (opcjonalnie)
                history.pushState(null, '', url);
            })
            .catch(() => {
                kontener.innerHTML = '<p class="blad">Nie udało się załadować treści.</p>';
            });
    });
});
```

### Live search — wyszukiwanie w locie

```javascript
// HTML: <input id="szukaj" type="search" placeholder="Szukaj...">
//       <div id="wyniki-szukania"></div>

const inputSzukaj = document.getElementById('szukaj');
const wyniki = document.getElementById('wyniki-szukania');

// Debouncing — czekamy 300ms po wpisaniu zanim wysyłamy zapytanie
let timer;

inputSzukaj.addEventListener('input', function() {
    const fraza = this.value.trim();
    clearTimeout(timer);

    if (fraza.length < 2) {
        wyniki.innerHTML = '';
        return;
    }

    timer = setTimeout(function() {
        fetch('szukaj.php?q=' + encodeURIComponent(fraza))
            .then(r => r.json())
            .then(function(dane) {
                if (dane.length === 0) {
                    wyniki.innerHTML = '<p>Brak wyników dla: ' + escapeHTML(fraza) + '</p>';
                    return;
                }

                wyniki.innerHTML = dane.map(function(item) {
                    return `<div class="wynik">
                        <strong>${escapeHTML(item.nazwa)}</strong>
                        <span>${escapeHTML(item.kategoria)}</span>
                    </div>`;
                }).join('');
            })
            .catch(() => {
                wyniki.innerHTML = '<p class="blad">Błąd wyszukiwania.</p>';
            });
    }, 300); // 300ms debounce
});

// Funkcja bezpiecznego escapowania HTML (unikanie XSS)
function escapeHTML(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}
```

### Infinite scroll — ładowanie kolejnych wyników

```javascript
let strona = 1;
let ladowanie = false;
let koniecDanych = false;

function ladujWiecej() {
    if (ladowanie || koniecDanych) return;

    ladowanie = true;
    strona++;

    const spinner = document.getElementById('spinner');
    spinner.style.display = 'block';

    fetch(`produkty.php?strona=${strona}`)
        .then(r => r.json())
        .then(function(dane) {
            spinner.style.display = 'none';
            ladowanie = false;

            if (dane.length === 0) {
                koniecDanych = true;
                document.getElementById('koniec').style.display = 'block';
                return;
            }

            const kontener = document.getElementById('lista-produktow');
            dane.forEach(function(produkt) {
                const div = document.createElement('div');
                div.className = 'produkt';
                div.textContent = produkt.nazwa;
                kontener.appendChild(div);
            });
        });
}

// Obserwuj kiedy użytkownik zbliża się do końca strony
window.addEventListener('scroll', function() {
    const scrollBottom = document.documentElement.scrollTop + window.innerHeight;
    const wysokoscStrony = document.documentElement.offsetHeight;

    if (scrollBottom >= wysokoscStrony - 200) {
        ladujWiecej();
    }
});
```

---

## 5. LocalStorage i SessionStorage

### Różnice

| Cecha             | localStorage              | sessionStorage             |
|-------------------|---------------------------|----------------------------|
| Czas życia        | do ręcznego usunięcia     | do zamknięcia karty/okna   |
| Zasięg            | wszystkie karty tej domeny | tylko bieżąca karta        |
| Pojemność         | ~5MB                      | ~5MB                       |
| Dostęp z JS       | TAK                       | TAK                        |
| Dostęp z PHP      | NIE (tylko JS)            | NIE (tylko JS)             |
| Przesyłane do serwera | NIE                   | NIE                        |

### Podstawowe operacje

```javascript
// Zapisywanie
localStorage.setItem('klucz', 'wartość');
localStorage.setItem('liczba', String(42));          // wartości MUSZĄ być stringiem
localStorage.setItem('obiekt', JSON.stringify({a:1})); // obiekty — JSON.stringify

// Odczytywanie
const wartosc = localStorage.getItem('klucz');       // zwraca null jeśli nie ma
const liczba = parseInt(localStorage.getItem('liczba'));
const obiekt = JSON.parse(localStorage.getItem('obiekt')); // może rzucić SyntaxError!

// Bezpieczny odczyt obiektu
function pobierzZLS(klucz, domyslna = null) {
    try {
        const wartosc = localStorage.getItem(klucz);
        return wartosc ? JSON.parse(wartosc) : domyslna;
    } catch (e) {
        console.error('Błąd odczytu localStorage:', e);
        return domyslna;
    }
}

// Usuwanie
localStorage.removeItem('klucz');
localStorage.clear();            // usuwa WSZYSTKO dla tej domeny

// Iteracja
for (let i = 0; i < localStorage.length; i++) {
    const klucz = localStorage.key(i);
    console.log(klucz, localStorage.getItem(klucz));
}
```

### Koszyk zakupowy w LocalStorage

```javascript
// Klasa do zarządzania koszykiem
class Koszyk {
    constructor() {
        this.klucz = 'koszyk';
        this.pozycje = this.wczytaj();
    }

    wczytaj() {
        try {
            return JSON.parse(localStorage.getItem(this.klucz)) || [];
        } catch (e) {
            return [];
        }
    }

    zapisz() {
        localStorage.setItem(this.klucz, JSON.stringify(this.pozycje));
    }

    dodaj(produkt) {
        const istniejacy = this.pozycje.find(p => p.id === produkt.id);
        if (istniejacy) {
            istniejacy.ilosc++;
        } else {
            this.pozycje.push({ ...produkt, ilosc: 1 });
        }
        this.zapisz();
        this.aktualizujWidok();
    }

    usun(id) {
        this.pozycje = this.pozycje.filter(p => p.id !== id);
        this.zapisz();
        this.aktualizujWidok();
    }

    zmienIlosc(id, ilosc) {
        const pozycja = this.pozycje.find(p => p.id === id);
        if (pozycja) {
            pozycja.ilosc = parseInt(ilosc);
            if (pozycja.ilosc <= 0) {
                this.usun(id);
                return;
            }
        }
        this.zapisz();
        this.aktualizujWidok();
    }

    lacznaKwota() {
        return this.pozycje.reduce((suma, p) => suma + (p.cena * p.ilosc), 0);
    }

    aktualizujWidok() {
        const kontener = document.getElementById('koszyk');
        if (!kontener) return;

        kontener.innerHTML = this.pozycje.map(p => `
            <div class="pozycja" data-id="${p.id}">
                <span>${escapeHTML(p.nazwa)}</span>
                <input type="number" value="${p.ilosc}" min="1" class="ilosc-input">
                <span>${(p.cena * p.ilosc).toFixed(2)} zł</span>
                <button class="btn-usun-z-koszyka">Usuń</button>
            </div>
        `).join('') + `<p>Razem: ${this.lacznaKwota().toFixed(2)} zł</p>`;

        // Licznik w nagłówku
        const licznik = document.getElementById('licznik-koszyka');
        if (licznik) {
            licznik.textContent = this.pozycje.reduce((s, p) => s + p.ilosc, 0);
        }
    }
}

const koszyk = new Koszyk();

// Dodaj produkt po kliknięciu
document.querySelectorAll('.dodaj-do-koszyka').forEach(btn => {
    btn.addEventListener('click', function() {
        koszyk.dodaj({
            id: parseInt(this.dataset.id),
            nazwa: this.dataset.nazwa,
            cena: parseFloat(this.dataset.cena)
        });
    });
});
```

### Zapamiętywanie ustawień użytkownika

```javascript
// Motyw (ciemny/jasny)
function ustawMotyw(motyw) {
    document.body.className = motyw;
    localStorage.setItem('motyw', motyw);
}

// Przy ładowaniu strony — przywróć ustawienia
document.addEventListener('DOMContentLoaded', function() {
    const motyw = localStorage.getItem('motyw') || 'jasny';
    document.body.className = motyw;

    const toggleMotyw = document.getElementById('toggle-motyw');
    if (toggleMotyw) {
        toggleMotyw.addEventListener('click', function() {
            const biezacy = document.body.className;
            ustawMotyw(biezacy === 'jasny' ? 'ciemny' : 'jasny');
        });
    }

    // Zapamiętanie ostatnio otwartej zakładki
    const ostatniaZakladka = localStorage.getItem('aktywna-zakladka');
    if (ostatniaZakladka) {
        document.querySelector(`[data-tab="${ostatniaZakladka}"]`)?.click();
    }
});
```

---

## 6. JSON

### JSON.stringify() i JSON.parse()

```javascript
// Konwersja obiektu JS na string JSON
const obiekt = {
    imie: 'Jan',
    wiek: 25,
    hobby: ['gry', 'programowanie'],
    adres: { miasto: 'Kraków', kod: '31-001' }
};

const json = JSON.stringify(obiekt);
// '{"imie":"Jan","wiek":25,"hobby":["gry","programowanie"],"adres":{"miasto":"Kraków","kod":"31-001"}}'

// Z formatowaniem (czytelny dla człowieka)
const jsonPiekny = JSON.stringify(obiekt, null, 2);

// Parsowanie JSON na obiekt JS
const sparsowany = JSON.parse(json);
console.log(sparsowany.imie); // 'Jan'
console.log(sparsowany.adres.miasto); // 'Kraków'
```

### Praca z zagnieżdżonymi obiektami

```javascript
const odpowiedz = {
    status: 'ok',
    strona: 1,
    lacznie: 100,
    dane: [
        { id: 1, nazwa: 'Produkt A', kategoria: { id: 2, nazwa: 'Elektronika' }, cena: 299.99 },
        { id: 2, nazwa: 'Produkt B', kategoria: { id: 3, nazwa: 'AGD' }, cena: 599.00 }
    ]
};

// Dostęp do zagnieżdżonych danych
console.log(odpowiedz.dane[0].kategoria.nazwa); // 'Elektronika'

// Iteracja z destrukturyzacją
odpowiedz.dane.forEach(({ id, nazwa, kategoria, cena }) => {
    console.log(`${id}: ${nazwa} (${kategoria.nazwa}) — ${cena} zł`);
});

// Optional chaining — bezpieczny dostęp
const pierwszaKategoria = odpowiedz?.dane?.[0]?.kategoria?.nazwa;
// nie rzuca błędu jeśli jakaś właściwość nie istnieje

// Filtrowanie
const elektronika = odpowiedz.dane.filter(p => p.kategoria.id === 2);
// map do wyciągania tylko nazw
const nazwy = odpowiedz.dane.map(p => p.nazwa);
```

### Walidacja JSON

```javascript
function czyPoprawnyJSON(str) {
    try {
        JSON.parse(str);
        return true;
    } catch (e) {
        return false;
    }
}

// Bezpieczny parse z wartością domyślną
function bezpiecznyParse(str, domyslna = null) {
    try {
        return JSON.parse(str);
    } catch (e) {
        console.warn('Nieprawidłowy JSON:', str);
        return domyslna;
    }
}

// Typowe błędy JSON:
// JSON.parse("undefined")  → SyntaxError
// JSON.parse("")           → SyntaxError
// JSON.parse("'tekst'")    → SyntaxError (JSON wymaga cudzysłowów)
// JSON.parse("{a: 1}")     → SyntaxError (klucze muszą być w cudzysłowach)
```

---

## 7. Obsługa formularzy HTML

### FormData API

```javascript
const formularz = document.getElementById('mojFormularz');

formularz.addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    // Odczyt wartości
    console.log(formData.get('imie'));
    console.log(formData.get('email'));

    // Dodawanie dodatkowych pól
    formData.append('timestamp', Date.now());
    formData.append('csrf_token', document.getElementById('csrf').value);

    // Iteracja
    for (const [klucz, wartosc] of formData.entries()) {
        console.log(`${klucz}: ${wartosc}`);
    }

    // Konwersja na obiekt
    const dane = Object.fromEntries(formData.entries());
    console.log(dane);

    // Wysłanie
    const response = await fetch('formularz.php', {
        method: 'POST',
        body: formData
    });
    const wynik = await response.json();
    console.log(wynik);
});
```

### Walidacja HTML5 Constraint API

```javascript
const input = document.getElementById('email');

// Sprawdzenie czy pole jest poprawne
console.log(input.validity.valid);       // true/false
console.log(input.validity.valueMissing); // true jeśli required i puste
console.log(input.validity.typeMismatch); // true jeśli zły typ (np. email)
console.log(input.validity.patternMismatch); // true jeśli nie pasuje do pattern
console.log(input.validity.tooShort);    // true jeśli minlength
console.log(input.validity.tooLong);     // true jeśli maxlength

// Własna wiadomość błędu
input.setCustomValidity('Podaj poprawny email firmowy');
input.setCustomValidity(''); // czyści błąd

// Sprawdzenie całego formularza
const formularz = document.getElementById('mojFormularz');
console.log(formularz.checkValidity()); // true jeśli wszystkie pola OK
formularz.reportValidity();             // pokazuje komunikaty błędów
```

### Niestandardowa walidacja

```javascript
// Walidacja NIP
function walidujNIP(nip) {
    nip = nip.replace(/[\s-]/g, '');
    if (nip.length !== 10 || !/^\d+$/.test(nip)) return false;

    const wagi = [6, 5, 7, 2, 3, 4, 5, 6, 7];
    const suma = wagi.reduce((s, w, i) => s + w * parseInt(nip[i]), 0);
    return suma % 11 === parseInt(nip[9]);
}

// Walidacja PESEL
function walidujPESEL(pesel) {
    if (pesel.length !== 11 || !/^\d+$/.test(pesel)) return false;
    const wagi = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3];
    const suma = wagi.reduce((s, w, i) => s + w * parseInt(pesel[i]), 0);
    return (10 - (suma % 10)) % 10 === parseInt(pesel[10]);
}

// Walidacja polskiego numeru telefonu
function walidujTelefon(tel) {
    return /^(\+48)?[\s-]?\d{3}[\s-]?\d{3}[\s-]?\d{3}$/.test(tel);
}

// Podłączenie do pola
document.getElementById('nip').addEventListener('blur', function() {
    const komunikat = document.getElementById('nip-komunikat');
    if (!walidujNIP(this.value)) {
        komunikat.textContent = 'Nieprawidłowy NIP';
        this.classList.add('pole-blad');
    } else {
        komunikat.textContent = '';
        this.classList.remove('pole-blad');
    }
});
```

### preventDefault — najważniejsze zastosowania

```javascript
// 1. Formularz — zapobiegamy wysłaniu i robimy to przez AJAX
formularz.addEventListener('submit', e => e.preventDefault());

// 2. Link — zapobiegamy nawigacji
link.addEventListener('click', function(e) {
    e.preventDefault();
    // własna logika...
});

// 3. Kliknięcie prawym — własne menu kontekstowe
document.addEventListener('contextmenu', function(e) {
    e.preventDefault();
    pokazMenuKontekstowe(e.clientX, e.clientY);
});

// 4. Drag and drop — zezwolenie na upuszczanie
dropZone.addEventListener('dragover', e => e.preventDefault());
dropZone.addEventListener('drop', function(e) {
    e.preventDefault();
    const pliki = e.dataTransfer.files;
    obsluzPliki(pliki);
});
```

---

## 8. Zdarzenia i delegacja

### Najważniejsze zdarzenia

```javascript
// Klik / mysz
element.addEventListener('click', handler);
element.addEventListener('dblclick', handler);
element.addEventListener('mouseenter', handler); // nie bąbelkuje
element.addEventListener('mouseover', handler);  // bąbelkuje
element.addEventListener('mouseout', handler);

// Formularz
input.addEventListener('change', handler);   // po zmianie i opuszczeniu pola
input.addEventListener('input', handler);    // natychmiast przy każdym znaku
input.addEventListener('focus', handler);
input.addEventListener('blur', handler);
formularz.addEventListener('submit', handler);

// Klawiatura
document.addEventListener('keydown', function(e) {
    console.log(e.key);    // 'Enter', 'Escape', 'a', 'ArrowUp' itp.
    console.log(e.code);   // 'KeyA', 'Digit1', 'Enter'
    console.log(e.ctrlKey, e.shiftKey, e.altKey); // modyfikatory

    if (e.key === 'Escape') zamknijModal();
    if (e.ctrlKey && e.key === 's') {
        e.preventDefault();
        zapiszDane();
    }
});

// Okno / dokument
window.addEventListener('load', handler);             // po załadowaniu wszystkiego
document.addEventListener('DOMContentLoaded', handler); // po załadowaniu DOM (szybciej)
window.addEventListener('resize', handler);
window.addEventListener('scroll', handler);
window.addEventListener('beforeunload', function(e) {
    e.preventDefault();
    e.returnValue = ''; // przeglądarka pokazuje dialog "Czy chcesz opuścić?"
});
```

### Event delegation — dla dynamicznych elementów

```javascript
// PROBLEM: elementy dodane dynamicznie nie mają event listenerów

// ZLE — nie działa dla dynamicznie dodanych .przycisk
document.querySelectorAll('.przycisk').forEach(btn => {
    btn.addEventListener('click', handler); // tylko istniejące elementy!
});

// DOBRZE — delegacja na rodzica
document.getElementById('kontener').addEventListener('click', function(e) {
    // e.target — element na który faktycznie kliknięto
    if (e.target.matches('.przycisk')) {
        handler.call(e.target, e);
    }

    // Obsługa kliknięcia w element wewnątrz .przycisk
    const przycisk = e.target.closest('.przycisk');
    if (przycisk) {
        const id = przycisk.dataset.id;
        console.log('Kliknięto przycisk ID:', id);
    }
});

// Usuwanie wierszy tabeli przez delegację
document.getElementById('tabela').addEventListener('click', function(e) {
    if (e.target.matches('.btn-usun-wiersz')) {
        const wiersz = e.target.closest('tr');
        wiersz.remove();
    }
});
```

### Debouncing — opóźnienie wykonania

```javascript
// Debounce — wykonaj funkcję dopiero gdy użytkownik PRZESTAŁ wpisywać
function debounce(fn, opoznienie) {
    let timer;
    return function(...args) {
        clearTimeout(timer);
        timer = setTimeout(() => fn.apply(this, args), opoznienie);
    };
}

const debouncedSzukaj = debounce(function(e) {
    szukaj(e.target.value);
}, 300);

document.getElementById('szukaj').addEventListener('input', debouncedSzukaj);
```

### Throttling — ograniczenie częstotliwości

```javascript
// Throttle — wykonaj funkcję co najwyżej raz na X ms
function throttle(fn, limit) {
    let ostatnieWywolanie = 0;
    return function(...args) {
        const teraz = Date.now();
        if (teraz - ostatnieWywolanie >= limit) {
            ostatnieWywolanie = teraz;
            fn.apply(this, args);
        }
    };
}

const throttledScroll = throttle(function() {
    console.log('scroll', window.scrollY);
}, 100);

window.addEventListener('scroll', throttledScroll);
```

---

## 9. Komunikacja PHP ↔ JS

### PHP generuje JSON dla JS

```php
<?php
// api.php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *'); // CORS

$conn = new mysqli('localhost', 'root', 'root', 'sklep');

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'komunikat' => 'Błąd połączenia']);
    exit;
}

$wynik = $conn->query('SELECT id, nazwa, cena FROM produkty ORDER BY nazwa');
$produkty = [];

while ($row = $wynik->fetch_assoc()) {
    $produkty[] = $row;
}

echo json_encode([
    'status' => 'ok',
    'dane' => $produkty,
    'lacznie' => count($produkty)
]);
?>
```

```javascript
// JavaScript odczytuje JSON z PHP
fetch('api.php')
    .then(r => r.json())
    .then(odpowiedz => {
        if (odpowiedz.status === 'ok') {
            odpowiedz.dane.forEach(produkt => {
                console.log(produkt.nazwa, produkt.cena);
            });
        }
    });
```

### JS wysyła dane do PHP przez fetch

```php
<?php
// zapisz.php — odbiera POST w formacie JSON
header('Content-Type: application/json');

// Odczyt JSON z body żądania
$dane = json_decode(file_get_contents('php://input'), true);

// Walidacja po stronie serwera (ZAWSZE!)
if (empty($dane['imie']) || empty($dane['email'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'komunikat' => 'Brakujące pola']);
    exit;
}

// Sanityzacja
$imie = htmlspecialchars(trim($dane['imie']));
$email = filter_var($dane['email'], FILTER_SANITIZE_EMAIL);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'komunikat' => 'Nieprawidłowy email']);
    exit;
}

// Zapis do bazy...
echo json_encode(['status' => 'ok', 'komunikat' => 'Zapisano']);
?>
```

### Sesje PHP a JavaScript — granice

```javascript
// JavaScript NIE MA dostępu do sesji PHP!

// PHP ustawia sesję:
// session_start();
// $_SESSION['uzytkownik'] = 'Jan';

// JS nie może odczytać $_SESSION bezpośrednio.
// Musi zapytać PHP przez AJAX:

fetch('sprawdz_sesje.php')
    .then(r => r.json())
    .then(dane => {
        if (dane.zalogowany) {
            document.getElementById('powitalnie').textContent = 'Witaj, ' + dane.imie + '!';
        } else {
            window.location.href = 'logowanie.php';
        }
    });
```

```php
<?php
// sprawdz_sesje.php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['uzytkownik'])) {
    echo json_encode([
        'zalogowany' => true,
        'imie' => $_SESSION['uzytkownik']['imie']
    ]);
} else {
    echo json_encode(['zalogowany' => false]);
}
?>
```

---

## 10. Bezpieczeństwo JavaScript

### XSS — Cross-Site Scripting

```javascript
// CO TO JEST: wstrzykiwanie złośliwego JS do strony przez dane użytkownika

// NIEBEZPIECZNE — XSS możliwy!
const imie = 'Jan<script>alert("XSS!")</script>';
document.getElementById('powitanie').innerHTML = 'Witaj, ' + imie;
// → uruchomi złośliwy skrypt!

// BEZPIECZNE — użyj textContent
document.getElementById('powitanie').textContent = 'Witaj, ' + imie;
// → wyświetli tekst dosłownie, bez wykonania

// Jeśli MUSISZ wstawić HTML — escapuj:
function escapeHTML(str) {
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#x27;');
}

// Używaj escapeHTML przy budowaniu HTML z danych użytkownika:
element.innerHTML = `<span>${escapeHTML(danePodUzytkownika)}</span>`;
```

### CSRF — Cross-Site Request Forgery

```javascript
// CO TO JEST: złośliwa strona wykonuje żądania w imieniu zalogowanego użytkownika

// OCHRONA: Token CSRF
// PHP generuje unikalny token przy każdej sesji,
// JS musi go dołączać do każdego żądania POST.

// HTML: <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">

// JS pobiera token z meta tagu:
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

// Dołącz do każdego POST fetch:
fetch('akcja.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-Token': csrfToken
    },
    body: JSON.stringify(dane)
});
```

### Walidacja — klient NIE zastępuje serwera

```
WAŻNE NA EGZAMINIE:
┌─────────────────────────────────────────────────────────┐
│  Walidacja po stronie KLIENTA (JS):                     │
│  - Szybka informacja zwrotna dla użytkownika            │
│  - Wygoda UX                                            │
│  - Można ją OMINĄĆ (DevTools, Postman, cURL)            │
│                                                         │
│  Walidacja po stronie SERWERA (PHP):                    │
│  - OBOWIĄZKOWA dla bezpieczeństwa                       │
│  - Nie można jej ominąć                                 │
│  - Ostatnia linia obrony                               │
│                                                         │
│  ZAWSZE waliduj PO OBU STRONACH!                        │
└─────────────────────────────────────────────────────────┘
```

---

## 11. Moduły ES6

### Eksport

```javascript
// plik: matematyka.js

// Eksport nazwaną (named export)
export function dodaj(a, b) {
    return a + b;
}

export function odejmij(a, b) {
    return a - b;
}

export const PI = 3.14159;

// Eksport domyślny (default export) — tylko jeden na plik
export default class Kalkulator {
    constructor() {
        this.wynik = 0;
    }
    dodaj(n) { this.wynik += n; return this; }
    pobierzWynik() { return this.wynik; }
}
```

### Import

```javascript
// plik: main.js

// Import named exports
import { dodaj, odejmij, PI } from './matematyka.js';
console.log(dodaj(2, 3)); // 5
console.log(PI);           // 3.14159

// Import z aliasem
import { dodaj as suma } from './matematyka.js';

// Import wszystkiego
import * as mat from './matematyka.js';
mat.dodaj(1, 2);

// Import default export
import Kalkulator from './matematyka.js';
const k = new Kalkulator();

// W HTML: <script type="module" src="main.js"></script>
// Moduły działają tylko przez HTTP (nie file://)
```

---

## 12. Promises vs async/await

### Promise — tworzenie i łańcuchowanie

```javascript
// Tworzenie Promise
function pobierzDane(url) {
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', url);
        xhr.onload = () => {
            if (xhr.status === 200) {
                resolve(JSON.parse(xhr.responseText));
            } else {
                reject(new Error('Błąd: ' + xhr.status));
            }
        };
        xhr.onerror = () => reject(new Error('Błąd sieci'));
        xhr.send();
    });
}

// Łańcuchowanie .then()
pobierzDane('users.php')
    .then(uzytkownicy => {
        console.log('Użytkownicy:', uzytkownicy);
        return pobierzDane('orders.php?user=' + uzytkownicy[0].id);
    })
    .then(zamowienia => {
        console.log('Zamówienia:', zamowienia);
    })
    .catch(blad => {
        console.error('Błąd:', blad.message);
    })
    .finally(() => {
        document.getElementById('spinner').style.display = 'none';
    });

// Promise.all — czekaj na kilka jednocześnie
Promise.all([
    fetch('users.php').then(r => r.json()),
    fetch('products.php').then(r => r.json()),
    fetch('orders.php').then(r => r.json())
]).then(([uzytkownicy, produkty, zamowienia]) => {
    console.log(uzytkownicy, produkty, zamowienia);
}).catch(blad => console.error(blad));
```

### async/await — czytelniejszy zapis

```javascript
// Każda funkcja async zwraca Promise
async function pobierzIWyswietl() {
    // Pokaż spinner
    document.getElementById('spinner').style.display = 'block';

    try {
        // await zatrzymuje wykonanie do czasu resolve
        const odpUzytkownicy = await fetch('users.php');
        const uzytkownicy = await odpUzytkownicy.json();

        const odpZamowienia = await fetch('orders.php?user=' + uzytkownicy[0].id);
        const zamowienia = await odpZamowienia.json();

        wyswietlDane(uzytkownicy, zamowienia);

    } catch (blad) {
        console.error('Błąd:', blad);
        pokazKomunikat('Nie udało się pobrać danych');
    } finally {
        document.getElementById('spinner').style.display = 'none';
    }
}

// Wywołanie
pobierzIWyswietl();

// Porównanie Promise vs async/await
// Promise:
fetch(url).then(r => r.json()).then(d => wyswietl(d)).catch(e => blad(e));

// async/await:
async function f() {
    try {
        const r = await fetch(url);
        const d = await r.json();
        wyswietl(d);
    } catch(e) { blad(e); }
}
```

---

## 13. Error Handling

### try/catch/finally

```javascript
function bezpiecznaOperacja() {
    try {
        // Kod który może rzucić wyjątek
        const wynik = ryzykownaFunkcja();
        const sparsowany = JSON.parse(wynik);
        return sparsowany;

    } catch (e) {
        if (e instanceof SyntaxError) {
            console.error('Nieprawidłowy JSON:', e.message);
        } else if (e instanceof TypeError) {
            console.error('Błąd typu:', e.message);
        } else {
            console.error('Nieznany błąd:', e);
        }
        return null;

    } finally {
        // Zawsze się wykona — niezależnie od błędu
        console.log('Operacja zakończona');
    }
}
```

### .catch() w Promises i fetch

```javascript
fetch('api.php')
    .then(r => {
        if (!r.ok) throw new Error('HTTP ' + r.status);
        return r.json();
    })
    .then(dane => wyswietl(dane))
    .catch(e => {
        console.error('Błąd fetch:', e.message);
        pokazBlad('Nie udało się pobrać danych');
    });
```

### window.onerror — globalny handler błędów

```javascript
// Łapie nieobsłużone błędy JS
window.onerror = function(komunikat, zrodlo, linia, kolumna, blad) {
    console.error(`Błąd: ${komunikat} w ${zrodlo}:${linia}:${kolumna}`);
    // Możesz wysłać raport do serwera
    fetch('log_bledy.php', {
        method: 'POST',
        body: JSON.stringify({ komunikat, zrodlo, linia })
    });
    return true; // nie pokazuj domyślnego okna błędu
};

// Dla nieobsłużonych odrzuceń Promise
window.addEventListener('unhandledrejection', function(event) {
    console.error('Nieobsłużone odrzucenie Promise:', event.reason);
});
```

---

## 14. Najczęstsze błędy JS

### "Cannot read property of undefined"

```javascript
// BŁĄD: próba dostępu do właściwości null/undefined
const dane = null;
console.log(dane.imie); // TypeError: Cannot read properties of null

// NAPRAWY:
// 1. Sprawdź przed dostępem
if (dane && dane.imie) { console.log(dane.imie); }

// 2. Optional chaining (ES2020)
console.log(dane?.imie); // undefined zamiast błędu
console.log(dane?.adres?.miasto);

// 3. Nullish coalescing
const imie = dane?.imie ?? 'Nieznany';
```

### "is not a function"

```javascript
// BŁĄD: wywołanie czegoś co nie jest funkcją
const wynik = "tekst";
wynik();          // TypeError: wynik is not a function

// Przyczyny:
// - nadpisanie zmiennej o tej samej nazwie co funkcja
// - zapomnienie o nawiasach (referencja zamiast wywołania)
// - brak importu funkcji

// SPRAWDŹ:
console.log(typeof wynik); // 'string', 'object', nie 'function'
```

### "Uncaught TypeError"

```javascript
// Najczęstsze przyczyny:
// 1. null zamiast elementu DOM (błąd w selektorze)
const el = document.getElementById('nieIstniejacy'); // null
el.style.display = 'none'; // TypeError!

// Napraw:
if (el) el.style.display = 'none';
el?.style?.display; // optional chaining

// 2. Zły typ danych
const liczba = "5";
liczba.toFixed(2); // TypeError — string nie ma toFixed

// Napraw:
parseFloat(liczba).toFixed(2);
```

### CORS errors

```javascript
// BŁĄD: "Access to fetch at 'http://...' from origin 'http://...' has been blocked by CORS policy"

// PRZYCZYNA: PHP nie pozwala na żądania z innego origin
// NAPRAW w PHP:
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
// header('Access-Control-Allow-Headers: Content-Type, X-CSRF-Token');

// Na MAMP — żądania z localhost:3000 do localhost:8080 też mogą mieć CORS!
// Rozwiązanie: trzymaj frontend i backend na tym samym origin
// lub skonfiguruj odpowiednie nagłówki w PHP
```

---

## 15. Debugging

### console — rodzaje

```javascript
console.log('Zwykłe info');
console.warn('Ostrzeżenie — żółty');
console.error('Błąd — czerwony');
console.info('Informacja — niebieska ikona');

// Tabela (świetne do tablic obiektów!)
const uzytkownicy = [
    { id: 1, imie: 'Jan', email: 'jan@example.com' },
    { id: 2, imie: 'Anna', email: 'anna@example.com' }
];
console.table(uzytkownicy);

// Pełna struktura obiektu (lepsza niż log dla zagnieżdżonych)
console.dir(document.getElementById('myId'));

// Grupowanie logów
console.group('Inicjalizacja');
console.log('Krok 1');
console.log('Krok 2');
console.groupEnd();

// Pomiar czasu
console.time('fetchDanych');
await fetch('api.php');
console.timeEnd('fetchDanych'); // "fetchDanych: 145ms"

// Asercja — log tylko gdy warunek fałszywy
console.assert(1 === 2, 'To jest fałsz!'); // wyświetli komunikat
```

### Debugger i DevTools

```javascript
// Breakpoint w kodzie
function skomplikowanaFunkcja(x) {
    debugger; // Przeglądarka zatrzyma się tutaj jeśli DevTools jest otwarte
    const wynik = x * 2 + 1;
    return wynik;
}

// DevTools → Sources → wstawianie breakpointów:
// - Klik na numer linii = standardowy breakpoint
// - Prawoklik na linię = conditional breakpoint (np. i === 5)
// - XHR/fetch breakpoints — zatrzymaj gdy fetch jest wysyłany
// - DOM breakpoints — zatrzymaj gdy zmienia się DOM

// Zakładki DevTools:
// Console   — logi, błędy, interaktywna konsola JS
// Sources   — kod, debugger, breakpoints
// Network   — żądania HTTP, fetch, XHR (tu widzisz co wysyłasz do PHP!)
// Elements  — DOM, style CSS
// Application — localStorage, sessionStorage, cookies
```

---

## 16. Wzorce projektowe

### Module Pattern

```javascript
// Ukrywa wewnętrzny stan — prywatne zmienne przez closure
const KoszykModul = (function() {
    // Prywatne
    let pozycje = [];
    let id = 0;

    function zapiszDoLS() {
        localStorage.setItem('koszyk', JSON.stringify(pozycje));
    }

    // Publiczne (eksportowane)
    return {
        dodaj(produkt) {
            pozycje.push({ ...produkt, _id: ++id });
            zapiszDoLS();
        },
        usun(id) {
            pozycje = pozycje.filter(p => p._id !== id);
            zapiszDoLS();
        },
        pobierzPozycje() {
            return [...pozycje]; // kopia — nie daj dostępu do oryginału
        },
        pobierzSume() {
            return pozycje.reduce((s, p) => s + p.cena * p.ilosc, 0);
        }
    };
})(); // IIFE — Immediately Invoked Function Expression

// Użycie:
KoszykModul.dodaj({ nazwa: 'Produkt A', cena: 99.99, ilosc: 1 });
console.log(KoszykModul.pobierzPozycje());
// pozycje — niedostępne bezpośrednio! (private)
```

### Revealing Module Pattern

```javascript
const FormularModul = (function() {
    // Prywatne
    let dane = {};

    function waliduj(pola) {
        return pola.every(p => dane[p] && dane[p].length > 0);
    }

    function wyslij() {
        if (!waliduj(['imie', 'email'])) {
            alert('Wypełnij wymagane pola');
            return;
        }
        fetch('zapisz.php', {
            method: 'POST',
            body: JSON.stringify(dane)
        });
    }

    function ustawDane(nowyDane) {
        dane = { ...nowyDane };
    }

    // Ujawniamy wybrane metody pod nowymi nazwami
    return {
        ustaw: ustawDane,
        wyslij: wyslij,
        sprawdz: waliduj
    };
})();
```

### Observer (EventEmitter)

```javascript
class EventEmitter {
    constructor() {
        this.zdarzenia = {};
    }

    on(zdarzenie, handler) {
        if (!this.zdarzenia[zdarzenie]) {
            this.zdarzenia[zdarzenie] = [];
        }
        this.zdarzenia[zdarzenie].push(handler);
        return this; // chaining
    }

    off(zdarzenie, handler) {
        if (this.zdarzenia[zdarzenie]) {
            this.zdarzenia[zdarzenie] = this.zdarzenia[zdarzenie]
                .filter(h => h !== handler);
        }
        return this;
    }

    emit(zdarzenie, ...args) {
        if (this.zdarzenia[zdarzenie]) {
            this.zdarzenia[zdarzenie].forEach(h => h(...args));
        }
        return this;
    }
}

// Użycie
const emiter = new EventEmitter();

emiter.on('dodanoDoProduktu', function(produkt) {
    console.log('Dodano:', produkt.nazwa);
    aktualizujLicznikKoszyka();
});

emiter.on('dodanoDoProduktu', function(produkt) {
    pokazPowiadomienie('Dodano ' + produkt.nazwa + ' do koszyka');
});

// Gdzieś indziej w kodzie:
emiter.emit('dodanoDoProduktu', { id: 1, nazwa: 'Laptop', cena: 2999 });
```

---

## 17. Przykłady z egzaminu INF.03

### Dynamiczna zmiana zawartości po kliknięciu

```html
<!-- HTML -->
<nav>
    <button class="tab-btn" data-tab="opis">Opis</button>
    <button class="tab-btn" data-tab="sklad">Skład</button>
    <button class="tab-btn" data-tab="opinie">Opinie</button>
</nav>
<div id="opis" class="tab-content">Treść opisu produktu...</div>
<div id="sklad" class="tab-content" style="display:none">Lista składników...</div>
<div id="opinie" class="tab-content" style="display:none">Opinie klientów...</div>
```

```javascript
document.querySelectorAll('.tab-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        // Ukryj wszystkie
        document.querySelectorAll('.tab-content').forEach(function(tab) {
            tab.style.display = 'none';
        });
        document.querySelectorAll('.tab-btn').forEach(function(b) {
            b.classList.remove('aktywny');
        });

        // Pokaż wybrany
        const targetId = this.dataset.tab;
        document.getElementById(targetId).style.display = 'block';
        this.classList.add('aktywny');
    });
});
```

### Filtrowanie tabeli bez przeładowania

```javascript
// Filtrowanie tabeli po wpisaniu tekstu
document.getElementById('filtr').addEventListener('input', function() {
    const fraza = this.value.toLowerCase().trim();
    const wiersze = document.querySelectorAll('#tabela tbody tr');

    wiersze.forEach(function(wiersz) {
        const tekst = wiersz.textContent.toLowerCase();
        wiersz.style.display = tekst.includes(fraza) ? '' : 'none';
    });

    // Informacja o liczbie wyników
    const widoczne = document.querySelectorAll('#tabela tbody tr:not([style*="none"])').length;
    document.getElementById('liczba-wynikow').textContent = `Pokazano: ${widoczne} wyników`;
});

// Filtrowanie po kolumnie
document.getElementById('filtr-kategoria').addEventListener('change', function() {
    const wybrana = this.value;
    document.querySelectorAll('#tabela tbody tr').forEach(function(wiersz) {
        const kategoria = wiersz.querySelector('[data-kategoria]')?.dataset.kategoria;
        wiersz.style.display = (!wybrana || kategoria === wybrana) ? '' : 'none';
    });
});
```

### Walidacja formularza kontaktowego

```html
<!-- HTML -->
<form id="formularz-kontakt">
    <div class="pole">
        <label for="imie">Imię i nazwisko *</label>
        <input type="text" id="imie" name="imie" required minlength="3">
        <span class="blad-pole" id="blad-imie"></span>
    </div>
    <div class="pole">
        <label for="email">Email *</label>
        <input type="email" id="email" name="email" required>
        <span class="blad-pole" id="blad-email"></span>
    </div>
    <div class="pole">
        <label for="temat">Temat *</label>
        <select id="temat" name="temat" required>
            <option value="">Wybierz temat...</option>
            <option value="pytanie">Pytanie</option>
            <option value="skarga">Skarga</option>
            <option value="sugestia">Sugestia</option>
        </select>
        <span class="blad-pole" id="blad-temat"></span>
    </div>
    <div class="pole">
        <label for="wiadomosc">Wiadomość *</label>
        <textarea id="wiadomosc" name="wiadomosc" required minlength="20" rows="5"></textarea>
        <span class="blad-pole" id="blad-wiadomosc"></span>
        <span id="licznik-znakow">0/500</span>
    </div>
    <button type="submit">Wyślij</button>
    <div id="komunikat-sukces" style="display:none">Dziękujemy! Odpiszemy wkrótce.</div>
</form>
```

```javascript
// Licznik znaków w textarea
document.getElementById('wiadomosc').addEventListener('input', function() {
    const dlugosc = this.value.length;
    document.getElementById('licznik-znakow').textContent = dlugosc + '/500';
    if (dlugosc > 500) this.value = this.value.substring(0, 500);
});

// Walidacja
document.getElementById('formularz-kontakt').addEventListener('submit', async function(e) {
    e.preventDefault();

    let czyOk = true;

    // Resetuj błędy
    document.querySelectorAll('.blad-pole').forEach(el => el.textContent = '');
    document.querySelectorAll('input, select, textarea').forEach(el => el.classList.remove('pole-bledne'));

    const pola = {
        imie: { wartość: document.getElementById('imie').value.trim(), minDl: 3 },
        email: { wartość: document.getElementById('email').value.trim() },
        temat: { wartość: document.getElementById('temat').value },
        wiadomosc: { wartość: document.getElementById('wiadomosc').value.trim(), minDl: 20 }
    };

    // Walidacja imienia
    if (pola.imie.wartość.length < 3) {
        document.getElementById('blad-imie').textContent = 'Imię musi mieć co najmniej 3 znaki';
        document.getElementById('imie').classList.add('pole-bledne');
        czyOk = false;
    }

    // Walidacja emaila
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(pola.email.wartość)) {
        document.getElementById('blad-email').textContent = 'Podaj poprawny email';
        document.getElementById('email').classList.add('pole-bledne');
        czyOk = false;
    }

    // Walidacja tematu
    if (!pola.temat.wartość) {
        document.getElementById('blad-temat').textContent = 'Wybierz temat';
        document.getElementById('temat').classList.add('pole-bledne');
        czyOk = false;
    }

    // Walidacja wiadomości
    if (pola.wiadomosc.wartość.length < 20) {
        document.getElementById('blad-wiadomosc').textContent = 'Wiadomość musi mieć co najmniej 20 znaków';
        document.getElementById('wiadomosc').classList.add('pole-bledne');
        czyOk = false;
    }

    if (!czyOk) return;

    // Wyślij
    const przycisk = this.querySelector('button[type="submit"]');
    przycisk.disabled = true;
    przycisk.textContent = 'Wysyłanie...';

    try {
        const response = await fetch('kontakt.php', {
            method: 'POST',
            body: new FormData(this)
        });
        const wynik = await response.json();

        if (wynik.status === 'ok') {
            this.reset();
            document.getElementById('komunikat-sukces').style.display = 'block';
        } else {
            alert('Błąd: ' + wynik.komunikat);
        }
    } catch (err) {
        alert('Błąd połączenia. Spróbuj ponownie.');
    } finally {
        przycisk.disabled = false;
        przycisk.textContent = 'Wyślij';
    }
});
```

---

## 18. Anti-patterns w JavaScript

```javascript
// 1. NIGDY nie używaj eval()
eval("alert('niebezpieczne!')"); // XSS, trudne do debugowania

// 2. Nie modyfikuj prototypów wbudowanych obiektów
Array.prototype.last = function() { return this[this.length - 1]; }; // ZLE

// 3. Nie używaj var (używaj let i const)
var x = 1; // ZLE — var ma zasięg funkcji, nie bloku
let y = 1; // DOBRZE
const z = 1; // DOBRZE — jeśli nie zmieniana

// 4. Nie ignoruj błędów
fetch(url).then(handler); // ZLE — brak .catch()
fetch(url).then(handler).catch(err => console.error(err)); // DOBRZE

// 5. Nie używaj synchronicznego XHR (blokuje UI)
xhr.open('GET', url, false); // ZLE — false = synchroniczne
xhr.open('GET', url, true);  // DOBRZE — asynchroniczne

// 6. Nie porównuj luźno gdy możesz ściśle
if (x == "5") // ZLE — typ konwersja
if (x === "5") // DOBRZE — ścisłe porównanie

// 7. Nie zostawiaj console.log w produkcji
// Użyj flagi środowiskowej:
const DEBUG = false;
if (DEBUG) console.log('debug info');

// 8. Nie trzymaj wrażliwych danych w localStorage
localStorage.setItem('haslo', userPassword); // ZLE!
localStorage.setItem('token_jwt', token);     // NIEBEZPIECZNE (XSS może wykraść)
// Bezpieczniejsze: cookie z HttpOnly i Secure (PHP)

// 9. Nie buduj URL-i przez konkatenację stringów
fetch('api.php?q=' + uzytkownikInput); // ZLE — brak enkodowania
fetch('api.php?q=' + encodeURIComponent(uzytkownikInput)); // DOBRZE

// 10. Unikaj zagnieżdżonych callbacków (callback hell)
getData(function(a) {
    getMore(a, function(b) {
        getEvenMore(b, function(c) {
            // Trudne do czytania i debugowania!
        });
    });
});
// Zamiast tego — Promises lub async/await
```

---

## 19. Kompatybilność i transpilacja

### Problem kompatybilności

```
Nowoczesny JS (ES2020+)         Stare przeglądarki (IE11)
─────────────────────────        ─────────────────────────
optional chaining (?.)     →     NIE obsługiwane
nullish coalescing (??)    →     NIE obsługiwane
async/await                →     NIE obsługiwane (ES2017)
arrow functions            →     NIE obsługiwane (IE nie)
const/let                  →     NIE obsługiwane przez IE
fetch                      →     NIE obsługiwane przez IE (potrzeba polyfill)

Na egzaminie INF.03 — nie musisz znać Babel szczegółowo,
ale rozumiej POJĘCIE transpilacji!
```

### Babel — co to jest (pojęcie)

```
Babel = narzędzie które konwertuje nowoczesny JS (ES2015+)
        na starszą wersję JS (ES5) zrozumiałą przez stare przeglądarki.

Przykład transpilacji:

Kod wejściowy (ES2020):              Kod wyjściowy (ES5, dla IE):
───────────────────────              ──────────────────────────────
const suma = (a, b) => a + b;   →   var suma = function(a, b) { return a + b; }
const imie = dane?.imie ?? 'X'; →   var imie = (dane && dane.imie != null) ? dane.imie : 'X';

Babel nie jest wymagany na egzaminie, ale:
- Warto wiedzieć że istnieje
- Na MAMP/lokalny serwer: używaj Chrome/Firefox — wspierają ES2020+
```

### Polyfill

```javascript
// Polyfill = kod który "dodaje" brakującą funkcjonalność do starszych przeglądarek

// Przykład: fetch polyfill dla IE
if (!window.fetch) {
    // Załaduj skrypt polyfill z CDN
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/whatwg-fetch@3.0.0/fetch.min.js';
    document.head.appendChild(script);
}

// Na egzaminie: używaj can i use (https://caniuse.com) żeby sprawdzić wsparcie
```

---

## 20. jQuery vs Vanilla JS

### Tabela porównawcza

| Zadanie                    | jQuery                             | Vanilla JS (ES6+)                        |
|----------------------------|------------------------------------|------------------------------------------|
| Wybór elementu             | `$('#id')`                         | `document.getElementById('id')`          |
| Wybór wielu                | `$('.klasa')`                      | `document.querySelectorAll('.klasa')`     |
| Zdarzenie click            | `$el.click(fn)`                    | `el.addEventListener('click', fn)`        |
| Ukryj element              | `$el.hide()`                       | `el.style.display = 'none'`               |
| Pokaż element              | `$el.show()`                       | `el.style.display = 'block'`              |
| Zmień tekst                | `$el.text('tekst')`                | `el.textContent = 'tekst'`                |
| Zmień HTML                 | `$el.html('<b>ok</b>')`            | `el.innerHTML = '<b>ok</b>'`              |
| Dodaj klasę                | `$el.addClass('klasa')`            | `el.classList.add('klasa')`               |
| Usuń klasę                 | `$el.removeClass('klasa')`         | `el.classList.remove('klasa')`            |
| AJAX GET                   | `$.get(url, fn)`                   | `fetch(url).then(r=>r.json()).then(fn)`   |
| AJAX POST                  | `$.post(url, dane, fn)`            | `fetch(url, {method:'POST', body:...})`   |
| DOM ready                  | `$(document).ready(fn)`            | `document.addEventListener('DOMContentLoaded', fn)` |
| Animacja fade              | `$el.fadeIn()`                     | CSS `transition` + `classList.add()`      |
| Rozmiar biblioteki         | ~90KB (minified)                   | 0KB (wbudowane)                           |

### Kiedy używać jQuery?

```
Używaj jQuery gdy:
- Projekt już go używa
- Potrzebujesz wsparcia dla IE11 bez konfiguracji Babel
- Pracujesz z WordPressem (jQuery jest wbudowane)
- Szybki prototyp

Używaj Vanilla JS gdy:
- Nowy projekt
- Chcesz zrozumieć co robi kod
- Ważna jest wydajność (mniej danych do załadowania)
- Egzamin INF.03 — lepiej pokazać znajomość czystego JS!
```

### Najczęstsze wzorce jQuery przepisane na Vanilla JS

```javascript
// DOMContentLoaded
// jQuery: $(function() { ... });
document.addEventListener('DOMContentLoaded', function() { /* ... */ });

// Iteracja
// jQuery: $('.item').each(function(i, el) { ... });
document.querySelectorAll('.item').forEach((el, i) => { /* ... */ });

// Delegacja zdarzeń
// jQuery: $(document).on('click', '.btn', fn);
document.addEventListener('click', function(e) {
    if (e.target.matches('.btn')) fn.call(e.target, e);
});

// AJAX
// jQuery: $.ajax({ url, method:'POST', data, success, error });
fetch(url, { method: 'POST', body: JSON.stringify(data) })
    .then(r => r.json())
    .then(success)
    .catch(error);
```

---

## SZYBKA LISTA KONTROLNA — Egzamin INF.03

```
PRZED ODDANIEM PRACY SPRAWDŹ:
[ ] addEventListener zamiast onclick="" (w HTML)
[ ] e.preventDefault() w obsłudze formularza
[ ] textContent zamiast innerHTML dla danych od użytkownika
[ ] Obsługa błędów w fetch (.catch() lub try/catch)
[ ] Sprawdzenie czy element DOM istnieje przed użyciem
[ ] JSON.parse() w try/catch
[ ] encodeURIComponent() dla parametrów URL
[ ] Walidacja zarówno po stronie JS jak i PHP
[ ] localStorage — dane jako string (JSON.stringify/parse)
[ ] Bez eval(), bez var (używaj let/const)
```

---

*Ściągawka: INF.03.5 — Programowanie Aplikacji | JavaScript | Technik Programista*
