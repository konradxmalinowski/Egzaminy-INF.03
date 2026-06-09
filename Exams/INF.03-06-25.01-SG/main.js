const przeliczButton = document.querySelector('#przelicz');
const input = document.querySelector('#liczba');
const p = document.querySelector('.sekcja-srodkowa p');

const zamienNaDziesietny = (liczbaDziesietna) => {
    let liczbaBinarna = "";
    while (liczbaDziesietna > 0) {
        liczbaBinarna += liczbaDziesietna % 2;
        liczbaDziesietna = Math.floor(liczbaDziesietna / 2);
    }

    return liczbaBinarna;
}

const wyswietl = () => {
    const cyfra = String(zamienNaDziesietny(parseInt(input.value)));
    let wynik = "";
    for (let i = cyfra.length - 1; i >= 0; i--) {
        wynik += cyfra[i];
        if (i % 4 === 0) {
            wynik += " ";
        }
    }
    wynik += "<sub>2</sub>";
    return wynik;
}

przeliczButton.addEventListener('click', () => {
    p.innerHTML = wyswietl();
});