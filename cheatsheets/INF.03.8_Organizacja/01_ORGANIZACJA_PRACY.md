# INF.03.8 - Organizacja pracy malych zespolow

> Kwalifikacja: INF.03 | Obszar: Organizacja i zarzadzanie projektem IT
> Egzamin: czesc pisemna - pytania teoretyczne

---

## 1. PLANOWANIE I ORGANIZACJA PRACY ZESPOLU

### Struktura malego zespolu IT (2-10 osob)
```
Project Manager
├── Lead Developer
│   ├── Backend Developer
│   ├── Frontend Developer
│   └── Full-stack Developer
├── Tester (QA Engineer)
├── Designer (UI/UX)
├── DBA (Database Administrator)
└── DevOps Engineer
```

### Przydzial zadan
- **Task assignment** na podstawie kompetencji i dostepnosci
- Unikanie bottleneck (w 1 osoby zalez wszystko)
- Rotacja zadan - rozwijanie kompetencji cross-funkcjonalnych
- Zasada WIP (Work In Progress) - ogranicz liczbe rownolegych zadan

### Harmonogram projektu
Elementy harmonogramu:
1. Wymagania i analiza (Requirements)
2. Projektowanie (Design)
3. Implementacja (Development)
4. Testowanie (Testing / QA)
5. Wdrozenie (Deployment)
6. Utrzymanie (Maintenance)

---

## 2. ROLE W PROJEKCIE IT

### Project Manager (PM)
- **Odpowiada za**: termin, budzet, zakres (trojkat ograniczen)
- **Narzedzia**: Jira, MS Project, Trello, Gantt
- **Kompetencje**: komunikacja, zarzadzanie ryzykiem, negocjacje
- **Artefakty**: Project Charter, harmonogram, raport statusu

### Developer (Programista)
- **Backend Developer**: logika biznesowa, API, bazy danych (PHP, Python, Java, Node.js)
- **Frontend Developer**: interfejs uzytkownika, HTML/CSS/JS, React, Vue
- **Full-stack Developer**: obie warstwy
- **Odpowiada za**: implementacje, code review, testy jednostkowe

### Tester / QA Engineer
- Testowanie manualne i automatyczne
- Tworzenie przypadkow testowych (test cases)
- Raportowanie bledow (bug reports) w Jirze
- Testy regresji, integracji, akceptacyjne (UAT)

### Designer (UI/UX)
- **UI (User Interface)**: wyglad, kolory, typografia, layout
- **UX (User Experience)**: uzywalnosc, flow uzytkownika, badania
- Narzedzia: Figma, Adobe XD, Photoshop
- Artefakty: wireframes, mockups, prototypy, design system

### DBA (Database Administrator)
- Projektowanie schematu bazy danych
- Optymalizacja zapytan SQL, indeksy
- Backupy i odtwarzanie baz danych
- Bezpieczenstwo i uprawnienia do danych

### DevOps Engineer
- CI/CD (Continuous Integration / Continuous Deployment)
- Zarzadzanie serwerami i infrastruktura (Docker, Kubernetes)
- Monitoring aplikacji produkcyjnej
- Narzedzia: Jenkins, GitHub Actions, Ansible, Terraform

---

## 3. METODOLOGIE ZARZADZANIA PROJEKTAMI

### WATERFALL (Model kaskadowy)

#### Etapy modelu Waterfall
```
1. Wymagania (Requirements)
        ↓
2. Projektowanie (Design)
        ↓
3. Implementacja (Implementation)
        ↓
4. Testowanie (Testing)
        ↓
5. Wdrozenie (Deployment)
        ↓
6. Utrzymanie (Maintenance)
```

#### Waterfall - charakterystyka
| Aspekt | Opis |
|--------|------|
| **Dokumentacja** | Bardzo obszerna, na kazdy etap |
| **Wymagania** | Zamrozone na poczatku projektu |
| **Zmiany** | Trudne i kosztowne w trakcie |
| **Klient** | Zaangazowany na poczatku i na koncu |
| **Czas dostawy** | Caly produkt na raz, na koncu |

#### Zalety Waterfall
- Prosta, zrozumiala struktura
- Dokladna dokumentacja
- Latwa kontrola postepu (etapy sa jednoznaczne)
- Dobra dla projektow o stalych wymaganiach (np. systemy wbudowane)

#### Wady Waterfall
- Brak elastycznosci na zmiany wymagań
- Klient widzi produkt dopiero na koncu
- Bledy wykrywane pozno (faza testowania na koncu)
- Duze ryzyko przy niejasnych wymaganiach

---

### SCRUM

#### Zasady Scruma
- Iteracyjno-przyrostowe podejscie
- Sprinty: krotkie iteracje (1-4 tygodnie, najczesciej 2)
- Samoorganizujacy sie zespol
- Ciagle doskonalenie (kaizen)

#### Role w Scrumie
| Rola | Odpowiedzialnosc |
|------|-----------------|
| **Product Owner (PO)** | Definiuje i priorytyzuje Product Backlog, reprezentuje klienta |
| **Scrum Master (SM)** | Facylituje proces, usuwa przeszkody (impediments), chroni zespol |
| **Development Team** | 3-9 osob, cross-funkcjonalne, samoorganizujace sie |

#### Artefakty Scrum
- **Product Backlog**: lista WSZYSTKICH zadan do wykonania, priorytyzowana przez PO
- **Sprint Backlog**: zadania wybrane na dany sprint
- **Increment**: dzialajacy produkt po kazdym sprincie

#### Zdarzenia w Scrumie (Scrum Events)
| Event | Cel | Czas |
|-------|-----|------|
| **Sprint Planning** | Planowanie co zrobimy w sprincie | Max 8h (dla 4-tygodniowego sprintu) |
| **Daily Scrum (Standup)** | Codzienne synchronizacja | 15 minut, stojac |
| **Sprint Review** | Prezentacja rezultatow klientowi | Max 4h |
| **Sprint Retrospective** | Co poprawic w procesie pracy | Max 3h |

#### Daily Scrum - 3 pytania
1. Co zrobilem wczoraj?
2. Co zrobie dzis?
3. Czy mam jakies przeszkody (impedimenty)?

#### Burndown Chart
- Os X: dni sprintu
- Os Y: pozostala praca (Story Points lub godziny)
- Linia idealna: rowna, opadajaca
- Ponad linia idealna: spozniamy sie
- Ponizej linii idealnej: jestesmy do przodu

---

### KANBAN

#### Podstawy Kanbanu
- Wizualizacja przepływu pracy na tablicy
- Ograniczenie pracy w trakcie (WIP - Work In Progress)
- Ciagly przeplyw (flow), brak sprintow
- Ciagla dostawa (continuous delivery)

#### Tablica Kanban
```
| BACKLOG  | TODO    | IN PROGRESS | REVIEW  | DONE    |
|----------|---------|-------------|---------|---------|
| zadanie5 | zadanie3| zadanie1    |zadanie2 |zadanieA |
| zadanie6 | zadanie4|             |         |zadanieB |
|          |         |  WIP: 1/2   | WIP:1/2 |         |
```

#### Limity WIP (Work In Progress)
- Kazda kolumna ma maksymalna liczbe kart (np. max 2 zadania w IN PROGRESS)
- Cel: ujawnienie waskich gardel (bottleneck)
- Nie zaczynaj nowego, dopoki nie skonczysz biezacego

#### Metryki Kanban
- **Lead Time**: od momentu dodania zadania do dostarczenia
- **Cycle Time**: od momentu rozpoczecia do dostarczenia
- **Throughput**: liczba zadan dostarczonych w jednostce czasu
- **CFD (Cumulative Flow Diagram)**: wykres narastajacego przepływu

---

### AGILE (Zwinne zarzadzanie)

#### Manifest Agile (2001) - 4 wartosci
1. **Ludzie i interakcje** ponad procesy i narzedzia
2. **Dzialajace oprogramowanie** ponad obszerna dokumentacje
3. **Wspolpraca z klientem** ponad negocjacje kontraktu
4. **Reagowanie na zmiany** ponad podazanie za planem

#### 12 zasad Manifestu Agile (wybor)
- Najwyzszy priorytet: szybkie i ciagle dostarczanie wartosci
- Witaj zmiany wymagan, nawet pozno w projekcie
- Dostarczaj dzialajace oprogramowanie czesto (co 2 tygodnie do 2 miesiecy)
- Wspolpraca biznesu i developerow codziennie
- Najlepsza forma komunikacji: rozmowa twarzą w twarz
- Dzialajace oprogramowanie = miara postepu
- Samoorganizujace sie zespoly tworza najlepsza architekture

#### Agile vs Waterfall - porownanie
| Kryterium | Agile | Waterfall |
|-----------|-------|-----------|
| Wymagania | Zmienne, ewoluujace | Stale, zamrozone |
| Dostawa | Czesta (iteracje) | Raz na koncu |
| Klient | Zaangazowany caly czas | Poczatek i koniec |
| Dokumentacja | Lekka | Obszerna |
| Zmiany | Latwe, tanie | Trudne, kosztowne |
| Ryzyko | Niskie (szybka informacja zwrotna) | Wysokie |
| Wielkosc zespolu | Maly (3-10) | Dowolna |

---

## 4. NARZEDZIA ZARZADZANIA PROJEKTAMI

### Jira (Atlassian)
- Zaawansowane zarzadzanie projektami Agile/Scrum/Kanban
- Backlog, sprinty, burndown chart
- Raportowanie i dashboardy
- Integracja z Confluence (dokumentacja), GitHub, Slack
- **Dla kogo**: srednie i duze zespoly, firmy enterprise

### Trello
- Proste tablice Kanban z kartami
- Interfejs drag-and-drop
- Power-ups (integracje: GitHub, Slack, Google Drive)
- **Dla kogo**: male zespoly, freelancerzy, proste projekty
- Bezplatny plan wystarcza dla malych zespolow

### GitHub Projects
- Wbudowane w GitHub, blisko kodu
- Tablice Kanban powiazane z Issues i Pull Requestami
- Automatyzacje (np. zamknij Issue po merge PR)
- **Dla kogo**: zespoly developerskie, projekty open source

### Asana
- Zarzadzanie zadaniami i projektami
- Widoki: lista, tablica, oś czasu (Gantt), kalendarz
- Workload view - obciazenie czlonkow zespolu
- **Dla kogo**: male i srednie firmy, nie tylko IT

### Porownanie narzedzi
| Kryterium | Jira | Trello | GitHub Projects | Asana |
|-----------|------|--------|----------------|-------|
| Zlozonos | Wysoka | Niska | Srednia | Srednia |
| Cena | Plany od free | Free/plany | Free z GitHub | Free/plany |
| Scrum | Pelny | Ograniczony | Podstawowy | Ograniczony |
| Integracja z kodem | Swietna | Dobra | Natywna | Dobra |
| Nauka | Stroma krzywa | Latwa | Latwa | Latwa |

---

## 5. GIT I KONTROLA WERSJI

### Podstawowe pojecia Git
| Pojecie | Definicja |
|---------|-----------|
| **Repository (repo)** | Repozytorium - miejsce przechowywania kodu i historii |
| **Commit** | Zapisanie zmian z opisem ("dodaj formularz logowania") |
| **Branch** | Galaz - oddzielna linia rozwoju kodu |
| **Merge** | Laczenie galezi |
| **Pull Request (PR)** | Propozycja wlaczenia zmian do glownej galezi |
| **Clone** | Sklonowanie zdalnego repo na lokalny komputer |
| **Push** | Wyslanie lokalnych commitow na serwer |
| **Pull** | Pobieranie zmian z serwera |
| **Fetch** | Pobranie info o zmianach bez mergowania |

### Git Workflow (przebieg pracy)
```
main/master
    ↑ merge (po code review)
    |
feature/login-form ← (pracujesz tu)
    |
    commit 1 → commit 2 → commit 3
```

### Typowe komendy Git
```bash
git init                    # inicjalizacja repo
git clone URL               # sklonowanie repo
git status                  # status plikow
git add plik.php            # dodanie pliku do staging
git add .                   # dodanie wszystkich plikow
git commit -m "opis"        # zapisanie commita
git push origin main        # wyslanie na serwer
git pull origin main        # pobranie zmian
git branch feature/x        # stworzenie galezi
git checkout feature/x      # przeladz sie do galezi
git checkout -b feature/x   # stworz + przelacz
git merge feature/x         # polacz galaz do biezacej
git log --oneline           # historia commitow
git diff                    # podglaad zmian
```

### Strategia galeziowania (Branching Strategy)
#### Git Flow
```
main        ← produkcja (tylko stable, tagi wersji)
    ↑
develop     ← integracja wszystkich features
    ↑
feature/X   ← nowa funkcja (od develop)
hotfix/Y    ← pilna poprawka (od main)
release/Z   ← przygotowanie wydania
```

#### Zasady dobrego commita
- Krotki opis (50 znaków): "Add user authentication"
- Tryb rozkazujacy: "Fix bug" nie "Fixed bug"
- Jeden commit = jedna logiczna zmiana
- Nie commituj: hasel, kluczy API, plikow .env

### Code Review (przeglad kodu)
Cel:
- Wylapywanie bledow zanim trafi na produkcje
- Dzielenie sie wiedza w zespole
- Utrzymanie standardow kodu
- Collective ownership

Jak robic dobry code review:
- Sprawdz logike, nie tylko styl
- Pisz konstruktywne uwagi ("Moze warto tu uzyc..." zamiast "Zrob tak")
- Nie blokuj przez wiele dni - review w ciagu 24h
- Sprawdz testy

---

## 6. DIAGRAM GANTTA

### Co to jest Diagram Gantta?
Wykres slupkowy pokazujacy harmonogram projektu:
- Os pozioma (X): czas (dni, tygodnie, miesiace)
- Os pionowa (Y): zadania
- Slupki: czas trwania zadania
- Zaleznosci (strzalki): kolejnosc zadan

### Jak czytac Diagram Gantta?
```
Zadanie             | Tydz.1 | Tydz.2 | Tydz.3 | Tydz.4 |
--------------------|--------|--------|--------|--------|
Analiza wymagan     |========|        |        |        |
Projektowanie DB    |   =====|===     |        |        |
Implementacja       |        |========|========|        |
Testowanie          |        |        |    ====|====    |
Wdrozenie           |        |        |        |   =====|
```

### Elementy Diagramu Gantta
- **Milestone** (kamien milowy): kluczowy moment projektu (diament na wykresie)
- **Zaleznosc**: zadanie B zaczyna sie po zakonczeniu zadania A
- **Sciezka krytyczna**: sekwencja zadan wyznaczajaca minimalny czas projektu
- **Buffer**: czas zapasowy dodany do zadan ryzykownych

### Tworzenie Diagramu Gantta
Narzedzia: MS Project, Google Sheets, Jira (Roadmap), Notion, Ganttproject (free)

---

## 7. OCENA JAKOSCI PRACY

### Kryteria odbioru (Definition of Done)
Definicja "Gotowe" (DoD) - lista warunkow ktore MUSI spelniac zadanie/story:
- Kod napisany i zcommitowany
- Testy jednostkowe napisane i przechodza
- Code review zaakceptowany przez co najmniej 1 osobe
- Testy funkcjonalne przechodza
- Dokumentacja zaktualizowana
- Feature dziala na srodowisku testowym
- Brak krytycznych bugów

### Testy akceptacyjne (UAT - User Acceptance Testing)
- Przeprowadzane przez klienta lub uzytkownikow koncowych
- Weryfikacja ze system spelnia wymagania biznesowe
- Kryteria akceptacji: zdefiniowane przed rozpoczeciem pracy
- User stories: "Jako [uzytkownik] chce [akcja] aby [cel]"

### Metryki jakosci kodu
| Metryka | Opis | Dobre wartosci |
|---------|------|----------------|
| **Code coverage** | % kodu pokrytego testami | >80% |
| **Cyclomatic complexity** | Zlozonos sciezek w kodzie | <10 na funkcje |
| **Technical debt** | Dlugi techniczny (zly kod) | Minimalizowac |
| **Bug density** | Bledy na 1000 linii kodu | Niska |
| **Mean Time to Fix** | Sredni czas naprawy bledu | Krotki |

---

## 8. DOKUMENTACJA PROJEKTU

### Specyfikacja wymagan (SRS - Software Requirements Specification)
Zawiera:
- Cel i zakres systemu
- Wymagania funkcjonalne: co system ROBI (lista funkcji)
- Wymagania niefunkcjonalne: jak dziala (wydajnosc, bezpieczenstwo, dostepnosc)
- Ograniczenia technologiczne
- Diagramy przypadkow uzycia (Use Case)

### Projekt techniczny (Technical Design Document)
- Architektura systemu (diagramy, warstwy)
- Schemat bazy danych (ERD - Entity Relationship Diagram)
- API endpoints (dokumentacja REST API)
- Technologie i biblioteki (stack technologiczny)
- Infrastruktura (serwery, chmura)

### Instrukcja uzytkownika
- Opis interfejsu
- Instrukcja krok-po-kroku dla typowych operacji
- FAQ (najczesciej zadawane pytania)
- Zrzuty ekranu / screenshoty
- Wymagania sprzetowe i systemowe

### README.md - dokumentacja projektu w repozytorium
```markdown
# Nazwa Projektu

## Opis
Co robi ten projekt.

## Uruchomienie
```bash
git clone URL
cd projekt
composer install
```

## Wymagania
- PHP 8.1+
- MySQL 8.0+
- Apache/Nginx

## Autorzy
- Jan Kowalski
```

### Narzedzia do dokumentacji
- **Confluence** (Atlassian) - wiki firmowe, integracja z Jira
- **Notion** - all-in-one: dokumenty, tablice, bazy danych
- **GitBook** - dokumentacja techniczna API
- **Swagger/OpenAPI** - automatyczna dokumentacja REST API
- **phpDoc / JSDoc** - generowanie dokumentacji z komentarzy w kodzie

---

## 9. KOMUNIKACJA W ZESPOLE

### Ceremonie Scrum (spotkania)

#### Daily Standup (Codzienne spotkanie)
- Codziennie o stalej godzinie (np. 9:00)
- Max 15 minut, stojac (dlatego "standup")
- 3 pytania: zrobilem / zrobie / przeszkody
- Nie rozwiazujemy problemow podczas standupu (po nim)
- Zdalnie: Zoom, Teams, Google Meet lub pisemnie na Slacku

#### Sprint Planning (Planowanie Sprintu)
- Na poczatku kazdego sprintu
- PO prezentuje top priorytety z Product Backlog
- Zespol szacuje story points (Planning Poker: 1, 2, 3, 5, 8, 13, 21)
- Wybor ile zadań zmiesci sie w sprincie (velocity)
- Wynik: Sprint Backlog

#### Sprint Review (Przeglad Sprintu)
- Na koncu sprintu
- Prezentacja DZIALAJACEGO oprogramowania klientowi
- Klient daje feedback
- PO aktualizuje backlog

#### Sprint Retrospektywa
- Na koncu sprintu, po Review
- Co poszlo DOBRZE? (Keep)
- Co POPRAWIC? (Improve)
- Co PRZESTAC robic? (Stop)
- Akcje na nastepny sprint (Action Items)
- Format: Start / Stop / Continue lub 4 Ls (Liked, Lacked, Learned, Longed For)

### Komunikacja zdalna
- **Slack / Teams / Discord**: komunikacja tekstowa, kanaly (#frontend, #bugs, #random)
- **Zoom / Meet / Teams**: wideokonferencje, screensharing
- **Confluence / Notion**: asynchroniczna dokumentacja
- **Asynchroniczna komunikacja**: wazna w zespolach rozproszonych (rozne strefy czasowe)

### Zasady efektywnej komunikacji w zespole IT
1. Preferuj pismo nad telefon (zostawia slad)
2. Uzyj watku (thread) aby nie zasmiecac kanalu
3. Dla skomplikowanych tematow: najpierw zadzwon, potem podsuumuj pisemnie
4. Informuj o postepach zanim ktos zapyta
5. Transparentnosc: informuj o problemach i opoznieniach wczesnie

---

## SLOWNIK POJEC (ORGANIZACJA)

| Pojecie | Definicja |
|---------|-----------|
| **Agile** | Zwinne podejscie do zarzadzania projektem |
| **Backlog** | Lista wszystkich zadan do wykonania |
| **Burndown** | Wykres pokazujacy pozostala prace w sprincie |
| **DoD** | Definition of Done - definicja "gotowe" |
| **Gantt** | Wykres slupkowy harmonogramu projektu |
| **Impediment** | Przeszkoda blokujaca prace zespolu |
| **Milestone** | Kamien milowy - kluczowy moment projektu |
| **PR / Pull Request** | Proponowane zmiany do recenzji i polaczenia |
| **Scrum** | Framework zwinny oparty na sprintach |
| **Stakeholder** | Interesariusz projektu (klient, uzytkownik, szef) |
| **UAT** | User Acceptance Testing - testy akceptacyjne |
| **Velocity** | Predkosc zespolu - ile story points na sprint |
| **WIP** | Work In Progress - praca w toku |

---

*Opracowanie do egzaminu INF.03 - Organizacja pracy malych zespolow (INF.03.8)*
