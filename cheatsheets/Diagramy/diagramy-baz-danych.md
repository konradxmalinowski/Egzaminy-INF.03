# Diagramy Związków Encji (ERD) – Kompleksowe Opracowanie

## 1. Wstęp
**Diagram ERD (Entity-Relationship Diagram)**, czyli diagram związków encji, to graficzne przedstawienie struktury danych w systemie. Jest to kluczowe narzędzie w procesie projektowania relacyjnych baz danych, pozwalające na wizualizację obiektów, ich cech oraz relacji zachodzących między nimi.

Na diagram ERD składają się trzy podstawowe elementy:
1. **Zbiory encji** (obiekty)
2. **Atrybuty encji** (cechy)
3. **Związki** (relacje między encjami)

---

## 2. Encja (Entity)
Encja to reprezentacja obiektu świata rzeczywistego, który jest przechowywany w bazie danych (np. *Klient*, *Zamówienie*, *Towar*).

* **Graficzna reprezentacja:** Najczęściej prostokąt z nazwą encji w środku.
* **W bazie danych:** Encja zazwyczaj odpowiada pojedynczej **tabeli**.

---

## 3. Atrybut (Attribute)
Atrybuty opisują cechy danej encji. Przechowują one konkretne informacje o obiekcie.

* **Typy danych:** Liczby, tekst, daty, wartości logiczne.
* **W bazie danych:** Atrybut jest reprezentowany przez **kolumnę w tabeli**.
* **Przykłady dla encji "Klient":** `Id_klienta`, `Nazwisko`, `Imię`, `Adres`, `PESEL`, `Telefon`.
* **Klucz Główny (Primary Key):** Specyficzny atrybut (np. `Id_klienta`), który jednoznacznie identyfikuje każdy rekord w tabeli. Na diagramach często oznaczany jest podkreśleniem.

---

## 4. Związki (Relationships)
Związek to powiązanie między dwoma zbiorami encji. Każdy związek charakteryzuje się kilkoma parametrami:

### A. Stopień związku (Kardynalność)
Określa, ile wystąpień jednej encji może być powiązanych z wystąpieniami drugiej encji:
* **Jeden do jednego (1:1):** Jednej encji odpowiada dokładnie jedna encja z drugiego zbioru.
* **Jeden do wielu (1:N):** Jednej encji z pierwszego zbioru odpowiada wiele encji z drugiego (najczęstszy typ relacji).
* **Wiele do wielu (M:N):** Wielu encjom z pierwszego zbioru odpowiada wiele encji z drugiego.

### B. Opcjonalność związku (Uczestnictwo)
Określa, czy związek musi zaistnieć, czy jest dobrowolny:
* **Związek opcjonalny:** Oznaczany kółkiem (`O`). Oznacza, że encja może, ale nie musi uczestniczyć w relacji.
* **Związek wymagany:** Oznaczany pionową kreską (`|`). Oznacza, że encja musi brać udział w relacji.

---

## 5. Przegląd Notacji
Diagramy ERD mogą być rysowane w różnych stylach graficznych:

1. **Notacja Martina (Crow's Foot):**
   * Najpopularniejsza w biznesie.
   * Używa symbolu "kurzej łapki" do oznaczenia strony "wiele".
   * Wykorzystuje kombinacje kresek i kółek do oznaczania liczebności i opcjonalności.
2. **Notacja Chena:**
   * Bardziej akademicka.
   * Związki są reprezentowane przez **romby** z wpisaną nazwą relacji (np. "zamawia").
   * Atrybuty są rysowane jako owale odchodzące od prostokąta encji.
3. **Notacja Bachmana:**
   * Wykorzystuje strzałki i kropki (pełne lub puste) na końcach linii do określenia charakteru związku.
4. **Notacja IDEF1X:**
   * Bardzo sformalizowana, stosowana często w projektach inżynierskich i rządowych.
   * Rozróżnia encje zależne (zaokrąglone rogi) i niezależne.

---

## 6. Przykład Praktyczny
Na przykładzie relacji **Klient – Zamówienie**:
* Zamówienie **musi** mieć przypisanego Klienta (związek wymagany).
* Klient **może** (ale nie musi w danej chwili) złożyć Zamówienie (związek opcjonalny).
* Klient może złożyć **wiele** zamówień, ale konkretne złożone zamówienie dotyczy tylko **jednego** klienta (relacja 1:N).