# ⚙️ ŚCIĄGAWKA: JavaScript Podstawy (INF.03.3 & 05)

## 1️⃣ ZMIENNE I TYPY DANYCH

```javascript
// Zmienne
var x = 10;           // Stary standard (unikać)
let y = 20;           // Nowoczesny, scoped
const PI = 3.14159;   // Stała (nie można zmienić)

// Typy danych
let liczba = 42;              // Number
let tekst = "Hello";          // String
let logika = true;            // Boolean
let pusty = null;             // Null
let niezdefiniowany;          // Undefined
let objekt = {imie: "Jan"};   // Object
let tablica = [1, 2, 3];      // Array

// Template strings
let wiadomosc = `Cześć ${imie}, masz ${wiek} lat`;
```

## 2️⃣ OPERATORY

```javascript
// Arytmetyczne
+ - * / % ** // Potęga

// Przypisania
=, +=, -=, *=, /=

// Porównania
== === != !== > < >= <=
// === lepsze niż == (nie konwertuje typów)

// Logiczne
&& (AND) || (OR) ! (NOT)

// Bitowe
& | ^ ~ << >> >>>
```

## 3️⃣ INSTRUKCJE STERUJĄCE

```javascript
// If
if (age >= 18) {
    console.log("Dorosły");
} else if (age >= 13) {
    console.log("Nastolatek");
} else {
    console.log("Dziecko");
}

// Switch
switch (dzien) {
    case 1:
        console.log("Poniedziałek");
        break;
    case 2:
        console.log("Wtorek");
        break;
    default:
        console.log("Inny dzień");
}

// Ternary
let status = age >= 18 ? "Dorosły" : "Niepełnoletni";
```

## 4️⃣ PĘTLE

```javascript
// For
for (let i = 0; i < 10; i++) {
    console.log(i);
}

// While
let i = 0;
while (i < 10) {
    console.log(i);
    i++;
}

// Do-while (minimum raz)
do {
    console.log(i);
    i++;
} while (i < 10);

// For...of (wartości)
for (const val of [1, 2, 3]) {
    console.log(val);
}

// For...in (klucze)
for (const key in {a: 1, b: 2}) {
    console.log(key);
}

// ForEach
[1, 2, 3].forEach(function(val, index) {
    console.log(val, index);
});
```

## 5️⃣ FUNKCJE

```javascript
// Funkcja zwykła
function add(a, b) {
    return a + b;
}

// Arrow function (nowoczesne)
const multiply = (a, b) => a * b;
const greet = name => `Hello ${name}`;
const log = () => console.log("Done");

// Parametry domyślne
function power(base, exponent = 2) {
    return base ** exponent;
}

// Rest parameters
function sum(...numbers) {
    return numbers.reduce((a, b) => a + b, 0);
}

// Callback
function process(data, callback) {
    let result = data * 2;
    callback(result);
}
process(5, (res) => console.log(res));
```

## 6️⃣ OBIEKTY I TABLICE

```javascript
// Obiekt
let osoba = {
    imie: "Jan",
    wiek: 30,
    greetings: function() {
        return `Cześć, jestem ${this.imie}`;
    }
};

osoba.imie;        // Dostęp
osoba["imie"];     // Nawiasowy dostęp
osoba.greetings(); // Metoda

// Tablica
let liczby = [1, 2, 3, 4, 5];

// Metody tablicy
liczby.push(6);           // Dodaj na koniec
liczby.pop();             // Usuń z końca
liczby.shift();           // Usuń z początku
liczby.unshift(0);        // Dodaj na początek
liczby.slice(1, 3);       // Nowa tablica [2,3]
liczby.splice(2, 1);      // Usuń od indeksu 2, 1 element
liczby.indexOf(3);        // Indeks elementu
liczby.includes(2);       // Czy zawiera?
liczby.join("-");         // String: "1-2-3"
liczby.reverse();         // Odwróć
liczby.sort((a,b) => a-b); // Sortuj

// Iteracja
liczby.map(x => x * 2);           // Nowa tablica [2,4,6...]
liczby.filter(x => x > 2);        // Filtruj [3,4,5]
liczby.reduce((sum, x) => sum+x); // Zwinięcie 15
```

## 7️⃣ DOM (Document Object Model)

```javascript
// Pobieranie elementów
document.getElementById("myId");
document.querySelector(".my-class");
document.querySelectorAll("p");
document.getElementsByTagName("div");

// Modyfikacja
element.textContent = "Nowy tekst";
element.innerHTML = "<strong>HTML</strong>";
element.setAttribute("class", "active");
element.classList.add("highlight");
element.classList.remove("highlight");
element.classList.toggle("active");
element.style.color = "red";

// Tworzenie elementów
let newDiv = document.createElement("div");
newDiv.textContent = "Hello";
document.body.appendChild(newDiv);
element.removeChild(child);
```

## 8️⃣ EVENTY

```javascript
// Event listener
button.addEventListener("click", function(event) {
    console.log("Kliknięto!");
    event.preventDefault();  // Zapobiegaj domyślnemu działaniu
});

// Event delegation
document.addEventListener("click", function(e) {
    if (e.target.classList.contains("btn")) {
        console.log("Kliknięty przycisk");
    }
});

// Popularne eventy
// click, dblclick, mouseenter, mouseleave
// focus, blur, change, input
// keydown, keyup, submit, scroll
```

## 9️⃣ PROMISE I ASYNC/AWAIT

```javascript
// Promise
let prom = new Promise((resolve, reject) => {
    setTimeout(() => {
        resolve("Sukces!");
    }, 1000);
});

prom.then(result => console.log(result))
    .catch(error => console.error(error));

// Async/Await
async function fetchData() {
    try {
        let response = await fetch("url");
        let data = await response.json();
        return data;
    } catch (error) {
        console.error(error);
    }
}
```

## 🔟 FETCH API

```javascript
// GET request
fetch("https://api.example.com/data")
    .then(response => response.json())
    .then(data => console.log(data))
    .catch(error => console.error(error));

// POST request
fetch("https://api.example.com/data", {
    method: "POST",
    headers: {
        "Content-Type": "application/json"
    },
    body: JSON.stringify({
        imie: "Jan",
        wiek: 30
    })
})
.then(r => r.json())
.then(data => console.log(data));

// Async version
async function getData() {
    const response = await fetch("url");
    const data = await response.json();
    return data;
}
```

## 1️⃣1️⃣ PODSUMOWANIE

- **Zmienne**: let, const (preferować)
- **Funkcje**: Arrow functions (nowoczesne)
- **DOM**: querySelector, addEventListener
- **Tablice**: map, filter, reduce
- **Async**: async/await (zamiast .then())
- **HTTP**: fetch API

---

**Powodzenia! 🎓**
