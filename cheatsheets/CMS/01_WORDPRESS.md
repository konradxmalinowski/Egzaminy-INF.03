# 🔍 SCIĄGAWKA: Zajęcia 3 - WordPress CMS

## Czym jest WordPress?
- **Definicja**: Najpopularniejszy CMS na świecie
- Używany do: blogów, pełnych witryn, e-commerce
- Darmowy i otwartoźródłowy
- Najlepszy dla początkujących i małych biznesów

## Instalacja WordPress

### Przygotowanie
1. **Zainstaluj XAMPP** (serwer lokalny)
2. **Pobierz WordPress** z wordpress.org
3. **Rozpakuj folder** `wordpress` do `htdocs`

### Baza danych
1. Otwórz `http://127.0.0.1/phpmyadmin/`
2. Utwórz nową bazę danych (np. `wordpress`)
3. Zapamiętaj nazwę bazy

### Konfiguracja WordPress
1. Wejdź na `http://127.0.0.1/wordpress`
2. Uzupełnij dane:
   - **Nazwa bazy danych**: wordpress
   - **Nazwa użytkownika**: root
   - **Hasło**: (puste)
   - **Adres serwera**: localhost
   - **Prefiks tabeli**: wp_ (domyślny)
3. Kliknij **Wyślij**

### Instalacja
1. Uzupełnij informacje witryny:
   - **Nazwa witryny**: np. "tworzenie-stron-nauka"
   - **Nazwa użytkownika**: admin
   - **Hasło**: można słabe (zaznacz checkbox)
   - **E-mail**: login@example.com
   - **Indeksowanie**: brak znaczenia na localhost
2. Kliknij **Zainstaluj WordPressa**
3. Zaloguj się do panelu: `http://127.0.0.1/wordpress/wp-admin`

## Panel administracyjny WordPress

### Kokpit (Dashboard)
- **Lewy pasek**: menu nawigacyjne
- **Prawy górny róg**: informacje o zalogowanym koncie
- **Środek**: informacje o stronie

### Menu główne (lewy pasek)
- 📝 **Wpisy** - tworzenie i edytowanie postów
- 📸 **Media** - zarządzanie plikami multimedialnymi
- 📄 **Strony** - tworzenie stron statycznych
- 💬 **Komentarze** - moderacja komentarzy
- 👤 **Użytkownicy** - zarządzanie użytkownikami
- 🎨 **Wygląd** - motywy, menu, widgety
- 📋 **Wtyczki** - zarządzanie wtyczkami
- ⚙️ **Ustawienia** - konfiguracja strony

## Pierwsza konfiguracja WordPress

### 1. Opcje ekranu (Cockpit)
- **Prawy górny róg** → "Opcje ekranu"
- Wybierz co chcesz widzieć na pulpicie

### 2. Bezpośrednie odnośniki (Permalinks)
- **Ustawienia** → **Bezpośrednie odnośniki**
- Wybierz strukturę URL:
  - Proste: `http://127.0.0.1/?p=123`
  - Dzień i nazwa: `2022/10/17/przykladowy-wpis/`
  - Nazwa wpisu: `http://127.0.0.1/przykladowy-wpis/`
  - Własne: dostosuj formatowanie

### 3. Zmiana ustawień użytkownika
- **Użytkownicy** → **Profil**
- Dodaj pseudonim (wymagane dla SEO)
- Ustaw sposób wyświetlania:
  - Admin (nazw a konta)
  - Pseudonim (lepiej dla SEO)

### 4. Zmiana tytułu i opisu strony
- **Ustawienia** → **Ogólne**
- **Nazwa witryny**: zmień na bardziej przyjazną
- **Slogan**: krótki opis strony
- **Adres WordPress (URL)**: http://127.0.0.1/wordpress
- **Adres witryny (URL)**: j.w.
- **E-mail administratora**: zmień na rzeczywisty
- **Całokolstwo**: czy założyć się wszyscy bez zgody

## Tworzenie struktury strony

### 1. Dodanie strony głównej (statycznej)
1. **Strony** → **Dodaj nową**
2. Tytuł: "Strona Główna"
3. **Opublikuj**
4. **Ustawienia** → **Czytanie**
5. Wybierz: "Statyczna strona" → "Strona główna: Strona Główna"
6. **Zapisz**

### 2. Tworzenie treści

#### Strony (statyczne)
- **Strony** → **Dodaj nową**
- Tytuł, zawartość, publikuj
- Przykład: strona "Kontakt", "O nas", "Usługi"

#### Wpisy (dynamiczne)
- **Wpisy** → **Dodaj nowy**
- Tytuł, zawartość, kategoria, tagi
- Pojawiają się na głównej w kolejności chronologicznej

#### Kategorie
- **Wpisy** → **Kategorie**
- Dodaj kategorię (np. "Poradniki", "Nowości")
- Możliwe hierarchie: kategoria rodzic/dziecko

#### Tagi
- **Wpisy** → **Tagi**
- Dodaj tagi do artykułów
- Pomoc w organizacji treści

## Menu

### Tworzenie menu
1. **Wygląd** → **Menu**
2. Utwórz nowe menu (np. "Główne")
3. **Dodaj pozycje menu**:
   - Strony
   - Wpisy
   - Własne linki
   - Kategorie
4. Ustal hierarchię (przeciąganie)
5. Zaznacz "Menu główne"
6. **Zapisz menu**

### Elementy menu
- Można dodawać strony, wpisy, własne linki, kategorie
- Hierarchia (pozycje rodzic/dziecko)
- Zmiana kolejności

## Motywy (Wygląd)

### Instalacja motywu
1. **Wygląd** → **Motywy**
2. **Dodaj** → szukaj motywu
3. **Zainstaluj** → **Aktywuj**

### Dostosowanie motywu
1. **Wygląd** → **Dostosuj**
2. Personalizuj:
   - Tożsamość witryny
   - Kolory i czcionki
   - Menu
   - Widgety
   - Ustawienia strony głównej

### Instalacja zewnętrznego motywu
1. Pobierz szablon (ZIP)
2. **Wygląd** → **Motywy** → **Dodaj** → **Wyślij motyw na serwer**
3. Rozpakowuje się automatycznie
4. Często dodatkowe opcje w menu wyglądu

## Wtyczki (Rozszerzenia)

- **Wtyczki** → **Dodaj nową**
- Szukaj wtyczki
- **Zainstaluj** → **Aktywuj**

Popularne wtyczki:
- SEO: Yoast SEO
- Formularze: WPForms
- Backup: UpdraftPlus
- Cache: WP Super Cache

## Podsumowanie do egzaminu

✅ **Najczęściej używany CMS** - najprostszy dla początkujących
✅ **Struktura**: Wpisy (dynamiczne) vs Strony (statyczne)
✅ **Instalacja**: XAMPP → baza danych → WordPress → konfiguracja
✅ **Konfiguracja**: Permalinks, tytuł, opcje główne
✅ **Treść**: Wpisy/Strony → Kategorie → Tagi
✅ **Menu**: Budowanie nawigacji
✅ **Motywy**: Instalacja i dostosowywanie wyglądu
✅ **Wtyczki**: Dodawanie funkcjonalności

**Kluczowe różnice od Joomli**: Prostszy, bardziej intuicyjny, lepszy dla blogów i małych stron
