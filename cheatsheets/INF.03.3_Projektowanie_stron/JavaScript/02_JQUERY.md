# jQuery - Biblioteka JavaScript

> Ściągawka do egzaminu INF.03 - INF.03.3 Projektowanie stron WWW

---

## 1. CZYM JEST JQUERY?

jQuery to szybka, mała biblioteka JavaScript ułatwiająca:
- Manipulację DOM (HTML/CSS)
- Obsługę zdarzeń (events)
- Animacje
- Zapytania AJAX
- Wsparcie dla różnych przeglądarek (cross-browser)

**Slogan jQuery**: *"Write less, do more"*

### Dlaczego jQuery?

| Vanilla JS (ES5)                        | jQuery                            |
|-----------------------------------------|-----------------------------------|
| `document.getElementById("id")`        | `$("#id")`                        |
| `document.querySelectorAll(".klasa")`  | `$(".klasa")`                     |
| `element.addEventListener("click", fn)`| `$("el").click(fn)`               |
| `element.style.display = "none"`       | `$("el").hide()`                  |
| `XMLHttpRequest` - wiele linii         | `$.ajax({...})` - prosto          |

### Importowanie jQuery (CDN)

```html
<!-- W sekcji <head> lub przed </body> -->
<!-- Wersja 3.x (aktualna) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Alternatywnie - lokalna kopia -->
<script src="js/jquery.min.js"></script>

<!-- UWAGA: jQuery musi być załadowane PRZED własnym kodem! -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="js/moj-skrypt.js"></script>
```

### Podstawowa składnia jQuery

```javascript
// Wzorzec: $(selektor).akcja()
$("p").hide();               // ukrywa wszystkie <p>
$("#box").show();            // pokazuje element o id="box"
$(".aktywny").css("color", "red");  // zmienia kolor

// Kod wewnątrz $(document).ready() wykonuje się po załadowaniu DOM
$(document).ready(function() {
    // Tu bezpiecznie pisać kod jQuery
    $("button").click(function() {
        $("p").toggle();
    });
});

// Skrót $(document).ready():
$(function() {
    // Identyczne działanie
});
```

---

## 2. SELEKTORY JQUERY

Selektory jQuery działają tak samo jak selektory CSS.

### Podstawowe selektory

```javascript
$("p")          // wszystkie elementy <p>
$(".klasa")     // elementy z class="klasa"
$("#identyf")   // element z id="identyf"
$("*")          // wszystkie elementy

$("div.klasa")  // <div> z class="klasa"
$("p, h1, h2")  // p ORAZ h1 ORAZ h2 (wielokrotny)
$("ul li")      // <li> wewnątrz <ul> (potomek)
$("ul > li")    // bezpośredni potomek
$("h1 + p")     // <p> bezpośrednio po <h1>
$("h1 ~ p")     // wszystkie <p> po tym samym <h1>
```

### Selektory atrybutów

```javascript
$("[href]")                 // ma atrybut href
$("[href='url.html']")      // href równa się dokładnie
$("[href^='https']")        // href zaczyna się od 'https'
$("[href$='.pdf']")         // href kończy się na '.pdf'
$("[href*='google']")       // href zawiera 'google'
$("input[type='text']")     // input z type="text"
```

### Selektory filtrujące (specyficzne dla jQuery)

```javascript
$("li:first")               // pierwszy <li>
$("li:last")                // ostatni <li>
$("li:even")                // parzyste (0, 2, 4...)
$("li:odd")                 // nieparzyste (1, 3, 5...)
$("li:eq(2)")               // trzeci <li> (indeks od 0)
$("li:gt(3)")               // <li> po indeksie 3
$("li:lt(3)")               // <li> przed indeksem 3
$("li:not(.aktywny)")       // <li> bez klasy aktywny
$("p:contains('tekst')")    // <p> zawierające 'tekst'
$("div:has(p)")             // <div> zawierające <p>
$("input:checked")          // zaznaczone checkbox/radio
$("input:disabled")         // wyłączone pola
$("input:enabled")          // aktywne pola
$("input:focus")            // pole z fokusem
$("p:empty")                // puste <p>
$("p:visible")              // widoczne <p>
$("p:hidden")               // ukryte <p>
```

---

## 3. METODY DOM

### Pobieranie i ustawianie treści

```javascript
// .html() - odpowiednik innerHTML
$("p").html();                          // pobiera HTML
$("p").html("<strong>Nowy tekst</strong>"); // ustawia HTML

// .text() - tylko tekst, bez HTML (bezpieczniejsze!)
$("p").text();                          // pobiera tekst
$("p").text("Nowy tekst");              // ustawia tekst (HTML jest escapowany)

// .val() - wartość pola formularza
$("input").val();                       // pobiera wartość
$("input").val("Nowa wartość");         // ustawia wartość
$("select").val();                      // pobiera wybraną opcję
$("select").val("opcja2");              // ustawia wybraną opcję
```

### Atrybuty

```javascript
// .attr() - HTML atrybuty
$("a").attr("href");                    // pobiera href
$("a").attr("href", "nowy-url.html");   // ustawia href
$("img").attr({                         // ustawia wiele naraz
    src: "zdjecie.jpg",
    alt: "Opis zdjęcia"
});
$("a").removeAttr("href");              // usuwa atrybut

// .prop() - właściwości DOM (checked, disabled itp.)
$("input").prop("checked");             // true/false
$("input").prop("checked", true);       // zaznacza checkbox
$("input").prop("disabled", false);     // aktywuje pole
```

### CSS i klasy

```javascript
// .css() - style inline
$("p").css("color");                    // pobiera kolor
$("p").css("color", "red");             // ustawia kolor
$("div").css({                          // ustawia wiele naraz
    "background-color": "blue",
    "font-size": "20px",
    "padding": "10px"
});

// .addClass() - dodaje klasę
$("p").addClass("aktywny");
$("p").addClass("aktywny duzy");        // dodaje dwie klasy

// .removeClass() - usuwa klasę
$("p").removeClass("aktywny");

// .toggleClass() - przełącza klasę (dodaje jeśli nie ma, usuwa jeśli jest)
$("p").toggleClass("aktywny");

// .hasClass() - sprawdza czy ma klasę
if ($("p").hasClass("aktywny")) { /* ... */ }
```

### Widoczność

```javascript
$("p").show();              // pokazuje (display: block)
$("p").hide();              // ukrywa (display: none)
$("p").toggle();            // przełącza widoczność

// Z animacją (prędkość: "slow", "fast" lub ms)
$("p").show("slow");
$("p").hide(500);           // 500ms
$("p").toggle("fast");
```

---

## 4. EVENTY (zdarzenia)

### Podstawowe metody eventów

```javascript
// .on() - rekomendowana metoda (działa też dla dynamicznych elementów)
$("button").on("click", function() {
    alert("Kliknięto!");
});

// .click() - skrót
$("button").click(function() {
    $(this).text("Kliknięto!"); // $(this) = kliknięty element
});

// .hover() - najechanie i opuszczenie myszą
$("div").hover(
    function() { $(this).addClass("nad-elementem"); },  // mouseenter
    function() { $(this).removeClass("nad-elementem"); } // mouseleave
);

// .submit() - wysłanie formularza
$("form").submit(function(event) {
    event.preventDefault();   // blokuje domyślne wysłanie!
    // własna logika
});

// .keyup() - zwolnienie klawisza
$("input").keyup(function() {
    console.log($(this).val());
});

// .keydown() - naciśnięcie klawisza
$("input").keydown(function(event) {
    if (event.key === "Enter") { /* ... */ }
});

// .change() - zmiana wartości (dla select, checkbox, itp.)
$("select").change(function() {
    console.log($(this).val());
});

// .focus() i .blur()
$("input").focus(function() { $(this).css("border", "2px solid blue"); });
$("input").blur(function()  { $(this).css("border", "1px solid gray"); });
```

### Delegacja eventów (dla dynamicznych elementów)

```javascript
// Obsługuje event dla elementów dodanych PO załadowaniu strony
$(document).on("click", ".dynamiczny-przycisk", function() {
    // Działa nawet dla elementów stworzonych później
});

// Lub na konkretnym rodzicu (wydajniejsze)
$(".lista").on("click", "li", function() {
    $(this).toggleClass("zaznaczony");
});
```

### Usuwanie eventów

```javascript
$("button").off("click");               // usuwa wszystkie click handlery
$("button").off("click", nazwaFunkcji); // usuwa konkretny handler
```

---

## 5. AJAX Z JQUERY

### $.ajax() - pełna konfiguracja

```javascript
$.ajax({
    url: "api/dane.php",           // adres URL
    type: "GET",                    // metoda: GET, POST
    data: { id: 5, typ: "admin" }, // dane do wysłania
    dataType: "json",               // oczekiwany typ odpowiedzi
    success: function(odpowiedz) {
        console.log(odpowiedz);     // dane z serwera
        $("div").html(odpowiedz.tekst);
    },
    error: function(xhr, status, error) {
        console.error("Błąd: " + error);
    },
    complete: function() {
        // Wykonuje się zawsze (po success lub error)
    }
});
```

### Skróty AJAX

```javascript
// $.get() - proste pobieranie danych
$.get("dane.php", { id: 1 }, function(odpowiedz) {
    $("#wynik").html(odpowiedz);
});

// $.post() - wysyłanie danych
$.post("zapisz.php", { imie: "Jan", wiek: 25 }, function(odpowiedz) {
    alert("Zapisano!");
});

// $.getJSON() - pobieranie JSON
$.getJSON("api/produkty.json", function(dane) {
    $.each(dane, function(index, produkt) {
        $("ul").append("<li>" + produkt.nazwa + "</li>");
    });
});

// .load() - ładuje HTML bezpośrednio do elementu
$("#kontener").load("fragment.html");
$("#kontener").load("fragment.html #sekcja"); // tylko element #sekcja
```

### Nowoczesny AJAX z Promise

```javascript
$.get("dane.php")
    .done(function(dane) { console.log(dane); })
    .fail(function(err)  { console.error(err); })
    .always(function()   { console.log("Zakończono"); });
```

---

## 6. ANIMACJE

### Podstawowe animacje

```javascript
// Fade (przeźroczystość)
$("div").fadeIn();              // pojawia się
$("div").fadeIn("slow");        // powoli
$("div").fadeIn(1000);          // 1 sekunda
$("div").fadeOut();             // znika
$("div").fadeOut(500);
$("div").fadeToggle();          // przełącza
$("div").fadeTo(400, 0.5);      // do 50% przeźroczystości w 400ms

// Slide (wysuwanie)
$("div").slideDown();           // wysuwa (odkrywa)
$("div").slideUp();             // chowa (zwija)
$("div").slideToggle();         // przełącza

// Własna animacja z .animate()
$("div").animate({
    left: "250px",
    opacity: "0.5",
    height: "150px",
    width: "150px"
}, 1000);                       // 1000ms

// Animacja z callback (po zakończeniu)
$("div").animate({ width: "300px" }, 500, function() {
    $(this).css("background-color", "green"); // wykonuje się po animacji
});
```

### Zatrzymywanie animacji

```javascript
$("div").stop();                // zatrzymuje aktualną animację
$("div").stop(true);            // czyści kolejkę animacji
$("div").stop(true, true);      // czyści i skacze do końca
```

---

## 7. TRAVERSAL (poruszanie się po DOM)

### Znajdowanie elementów

```javascript
// .find() - szuka potomków pasujących do selektora
$("div").find("p");             // wszystkie <p> w <div>
$("form").find("input");        // wszystkie inputy w formularzu

// .children() - bezpośrednie dzieci
$("ul").children();             // bezpośrednie <li>
$("ul").children(".aktywny");   // dzieci z klasą aktywny

// .parent() - bezpośredni rodzic
$("li").parent();               // <ul> rodzic
$("li").parent("ul.menu");      // tylko jeśli rodzic pasuje

// .parents() - wszyscy przodkowie
$("span").parents();
$("span").parents("div");       // tylko przodkowie <div>

// .closest() - najbliższy przodek pasujący do selektora
$("input").closest("form");     // najbliższy formularz

// .siblings() - rodzeństwo (wszyscy poza sobą)
$("li.aktywny").siblings();
$("li.aktywny").siblings("li"); // tylko <li> rodzeństwo

// .next() i .prev() - sąsiedzi
$("h2").next();                 // następny element
$("h2").next("p");              // następny <p>
$("h2").prev();                 // poprzedni element
$("h2").nextAll();              // wszystkie następne
$("h2").prevAll();              // wszystkie poprzednie
```

### Filtrowanie zestawu

```javascript
$("li").first();                // pierwszy element zestawu
$("li").last();                 // ostatni
$("li").eq(2);                  // trzeci (indeks 0)
$("li").filter(".aktywny");     // tylko z klasą aktywny
$("li").not(".aktywny");        // bez klasy aktywny
$("li").has("a");               // <li> które zawierają <a>
```

---

## 8. MANIPULACJA DOM

### Dodawanie elementów

```javascript
// .append() - dodaje NA KOŃCU wewnątrz elementu
$("ul").append("<li>Nowy element</li>");

// .prepend() - dodaje NA POCZĄTKU wewnątrz elementu
$("ul").prepend("<li>Pierwszy element</li>");

// .after() - dodaje po elemencie (poza nim)
$("h2").after("<p>Tekst po nagłówku</p>");

// .before() - dodaje przed elementem (poza nim)
$("h2").before("<p>Tekst przed nagłówkiem</p>");

// Odwrócony zapis - element "wchodzi" do wskazanego miejsca
$("<li>Nowy</li>").appendTo("ul");
$("<li>Pierwszy</li>").prependTo("ul");
```

### Usuwanie elementów

```javascript
$("p").remove();                // usuwa element z DOM (i eventy)
$("p").detach();                // usuwa z DOM, zachowuje eventy
$("div").empty();               // czyści zawartość (zostawia sam element)
```

### Kopiowanie i przenoszenie

```javascript
$("p").clone();                 // klonuje element
$("p").clone(true);             // klonuje razem z eventami

// Przenoszenie: append przesuwa istniejący element
$("div#cel").append($("p#zrodlo")); // przesuwa p do div
```

### Iteracja .each()

```javascript
// Iteruje po zestawie jQuery
$("li").each(function(index, element) {
    console.log(index + ": " + $(element).text());
    // lub: $(this).text()
});

// Iteracja po tablicy/obiekcie
$.each(["a", "b", "c"], function(i, val) {
    console.log(i + ": " + val);
});
```

---

## 9. WALIDACJA FORMULARZY Z JQUERY

```javascript
$(function() {
    $("form#kontakt").submit(function(event) {
        event.preventDefault();     // blokuje wysłanie

        var imie  = $("#imie").val().trim();
        var email = $("#email").val().trim();
        var bledy = [];

        // Walidacja
        if (imie === "") {
            bledy.push("Imię jest wymagane.");
        }

        if (email === "") {
            bledy.push("Email jest wymagany.");
        } else if (!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
            bledy.push("Podaj prawidłowy email.");
        }

        // Wyświetlenie błędów lub wysłanie
        if (bledy.length > 0) {
            $("#komunikaty").html(
                "<ul><li>" + bledy.join("</li><li>") + "</li></ul>"
            ).addClass("blad");
        } else {
            // Formularz poprawny - wysyłamy AJAX
            $.post("wyslij.php", $(this).serialize(), function(odp) {
                $("#komunikaty").html("Wysłano pomyślnie!").addClass("sukces");
            });
        }
    });

    // Czyszczenie błędu po poprawie
    $("input").keyup(function() {
        if ($(this).val().trim() !== "") {
            $(this).removeClass("pole-blad");
        }
    });
});
```

---

## 10. PORÓWNANIE JQUERY VS VANILLA JS

### Kiedy używać jQuery

- Projekt musi obsługiwać starsze przeglądarki (IE)
- Szybkie prototypowanie
- AJAX bez zbędnego kodu
- Projekt już używa jQuery (np. Bootstrap 4)

### Kiedy używać Vanilla JS (nowoczesny)

- Nowoczesne przeglądarki (Chrome, Firefox, Edge, Safari)
- Zależy Ci na wydajności (mniejszy rozmiar strony)
- Projekt używa frameworka (React, Vue, Angular)
- Uczysz się dobrze programować JS

### Tabela porównawcza

| Operacja                | jQuery                          | Vanilla JS (nowoczesny)                          |
|-------------------------|---------------------------------|--------------------------------------------------|
| Selektor                | `$(".el")`                      | `document.querySelector(".el")`                  |
| Wiele elementów         | `$("li")`                       | `document.querySelectorAll("li")`                |
| HTML zawartość          | `$(el).html()`                  | `el.innerHTML`                                   |
| Tekst                   | `$(el).text()`                  | `el.textContent`                                 |
| Dodaj klasę             | `$(el).addClass("x")`          | `el.classList.add("x")`                          |
| Usuń klasę              | `$(el).removeClass("x")`       | `el.classList.remove("x")`                       |
| Przełącz klasę          | `$(el).toggleClass("x")`       | `el.classList.toggle("x")`                       |
| Event                   | `$(el).on("click", fn)`         | `el.addEventListener("click", fn)`               |
| AJAX GET                | `$.get(url, fn)`                | `fetch(url).then(r => r.json()).then(fn)`         |
| Ukryj element           | `$(el).hide()`                  | `el.style.display = "none"`                      |
| Append HTML             | `$(el).append("<p>txt</p>")`    | `el.insertAdjacentHTML("beforeend", "<p>txt</p>")`|
| Document ready          | `$(function(){...})`            | `document.addEventListener("DOMContentLoaded",fn)`|

---

## PODSUMOWANIE DO EGZAMINU

### Najważniejsze wzorce jQuery w egzaminie

```javascript
// 1. Dokument gotowy
$(function() {

    // 2. Click na przycisk - pokaż/ukryj div
    $("#btn").click(function() {
        $("#tresc").toggle();
    });

    // 3. Pobierz wartość z inputa
    var wartosc = $("#pole").val();

    // 4. Zmień tekst elementu
    $("#wynik").text("Nowa treść");

    // 5. Dodaj klasę CSS
    $("p").addClass("podswietlony");

    // 6. AJAX - załaduj dane z PHP
    $.get("dane.php", { id: 3 }, function(dane) {
        $("#kontener").html(dane);
    });

    // 7. Iteracja po elementach
    $("li").each(function() {
        console.log($(this).text());
    });

    // 8. Walidacja formularza
    $("form").submit(function(e) {
        e.preventDefault();
        if ($("#email").val() === "") {
            alert("Podaj email!");
        }
    });
});
```

### Pułapki do unikania

- jQuery musi być załadowane PRZED swoim kodem (`<script>` w odpowiedniej kolejności)
- Kod jQuery powinien być wewnątrz `$(document).ready()` (lub `$(function(){})`)
- `$(this)` w handlerze eventu oznacza element który wywołał event
- `.val()` działa dla pól formularza, `.text()` i `.html()` dla innych elementów
- `event.preventDefault()` blokuje domyślne zachowanie (np. wysłanie formularza)
- `.find()` szuka w potomkach, `.filter()` filtruje bieżący zestaw
