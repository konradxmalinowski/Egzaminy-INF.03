# Plan: INF.03 Cheatsheets – Dokończenie i porządek
**Data:** 2026-05-16

## Problem
Istnieje 25 plików .md w cheatsheets/, ale brakuje:
- Treści w pustych folderach: `Diagramy/`, `MariaDB/`, `MySQL/`, `PhpMyAdmin/`, `INF.03.5/JavaScript/`
- Ćwiczeń praktycznych (SQL, HTML/CSS, PHP)
- Zestawu pytań egzaminacyjnych (testy)
- Diagramów ASCII (ER, CMS, przepływy danych)

## Pliki do stworzenia (13 nowych)

### Batch 1 – Diagramy
- `cheatsheets/Diagramy/01_ER_DIAGRAMY.md` — diagramy ASCII: sklep, szkoła, przepisy, pogoda
- `cheatsheets/Diagramy/02_ARCHITEKTURA_CMS.md` — WordPress/Joomla architektura, model MVC
- `cheatsheets/Diagramy/03_PRZEPLYW_DANYCH.md` — HTTP request flow, PHP+MySQL flow, OSI flow

### Batch 2 – Bazy danych (puste foldery)
- `cheatsheets/INF.03.4_Bazy_danych/MariaDB/01_MARIADB.md` — MariaDB vs MySQL różnice, specyficzne funkcje
- `cheatsheets/INF.03.4_Bazy_danych/MySQL/01_MYSQL_QUICK.md` — szybka referencja MySQL
- `cheatsheets/INF.03.4_Bazy_danych/PhpMyAdmin/01_PHPMYADMIN.md` — phpMyAdmin krok po kroku

### Batch 3 – INF.03.5 JavaScript
- `cheatsheets/INF.03.5_Programowanie_aplikacji/JavaScript/01_JS_APLIKACJE.md` — JS w kontekście aplikacji webowych

### Batch 4 – Ćwiczenia
- `cheatsheets/Cwiczenia/01_SQL_CWICZENIA.md` — 20 zadań SQL z rozwiązaniami
- `cheatsheets/Cwiczenia/02_HTML_CSS_CWICZENIA.md` — 15 zadań HTML/CSS z rozwiązaniami
- `cheatsheets/Cwiczenia/03_PHP_CWICZENIA.md` — 10 zadań PHP+MySQL z rozwiązaniami

### Batch 5 – Testy egzaminacyjne
- `cheatsheets/Testy/01_TEST_PYTANIA.md` — 50 pytań egzaminacyjnych (wielokrotnego wyboru)
- `cheatsheets/Testy/02_TEST_SQL.md` — 20 pytań SQL z odpowiedziami
- `cheatsheets/Testy/03_TEST_PHP_HTML_CSS.md` — 30 pytań PHP/HTML/CSS

## Aktualizacje
- `cheatsheets/README.md` — dodać mapę nowych plików

## Kryteria ukończenia
- [ ] Wszystkie puste foldery mają co najmniej 1 plik .md
- [ ] Folder Cwiczenia/ z 3 plikami ćwiczeń z rozwiązaniami
- [ ] Folder Testy/ z 3 plikami testów (100 pytań łącznie)
- [ ] Folder Diagramy/ z 3 plikami diagramów ASCII
- [ ] README.md zaktualizowany
