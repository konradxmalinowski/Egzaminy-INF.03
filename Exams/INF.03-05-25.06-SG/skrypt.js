const dodajDoKoszykaButton = document.querySelector("#dodaj-button");
const rezultat = document.querySelector("#rezultat");
const obrazInput = document.querySelector("input#zdjecie");
const kopieInput = document.querySelector("input#kopie");
const czyMatowyInput = document.querySelector("input#papier-matowy")
const czyBlyszczacyInput = document.querySelector("input#papier-blyszczacy");

const CENA_PAPIERU_BLYSZCZACEGO = 1.5;
const CENA_PAPIERU_MATOWEGO = 2;

const stworzBloki = (nazwaPliku, iloscKopii, cena) => {
    const blok = document.createElement("section");
    
    const zdjecie = document.createElement('img');
    zdjecie.src = nazwaPliku;
    zdjecie.alt = nazwaPliku;

    const kontener = document.createElement("section");
    /* ----- */
    kontener.style.float = "left";
    kontener.style.display = "flex";
    kontener.style.flexDirection = "column";
    kontener.style.justifyContent = "space-between";
    /* ----- */

    const tekst1 = document.createElement('p');
    tekst1.innerText = `Liczba kopii: ${iloscKopii}`;
    const tekst2 = document.createElement('p');
    tekst2.innerText = `Cena: ${cena}`;
    const clearBoth = document.createElement('p');

    kontener.append(tekst1, tekst2);

    blok.append(zdjecie, kontener, clearBoth);
    rezultat.append(blok);
}

const dodajDoKoszyka = () => {
    const nazwaPliku = obrazInput.files[0].name;

    const czyBlyszczacy = czyBlyszczacyInput.checked;
    const iloscKopii = parseInt(kopieInput.value);

    const cena = iloscKopii * (czyBlyszczacy ? CENA_PAPIERU_BLYSZCZACEGO : CENA_PAPIERU_MATOWEGO);

    stworzBloki(nazwaPliku, iloscKopii, cena);
}

dodajDoKoszykaButton.addEventListener('click', dodajDoKoszyka);

// Kod objęty komentarzami : /* ----- */ został dodany przeze mnie na potrzeby odwzorowania wyglądu dodawanego elementu na ilustracji 4.