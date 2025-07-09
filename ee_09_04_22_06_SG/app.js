let idZamowienia = 0;
const wiersze = Array.from(document.querySelectorAll('tr'));
wiersze.unshift();
const kolumnaIlosc = document.querySelectorAll('tr td:nth-of-type(3)');
const aktualizacjaButtony = document.querySelectorAll('.aktualizuj');
const zamowButtony = document.querySelectorAll('.zamow');

const zaznaczBraki = () => {
  kolumnaIlosc.forEach((kolumna) => {
    if (Number(kolumna.textContent.trim()) === 0) {
      kolumna.style.backgroundColor = 'red';
    } else if (
      Number(kolumna.textContent.trim()) >= 1 &&
      Number(kolumna.textContent.trim()) <= 5
    ) {
      kolumna.style.backgroundColor = 'yellow';
    } else {
      kolumna.style.backgroundColor = 'honeydew';
    }
  });
};

const aktualizuj = () => {
  aktualizacjaButtony.forEach((button, idx) => {
    button.addEventListener('click', () => {
      const nowaIlosc = parseInt(prompt('Podaj nowa ilość: '));
      kolumnaIlosc[idx].textContent = nowaIlosc;
      zaznaczBraki();
    });
  });
};

const zamow = () => {
  zamowButtony.forEach((button, idx) => {
    button.addEventListener('click', () => {
      idZamowienia++;
      const wiersz = wiersze[idx + 1].querySelector('td');
      alert(`Zamówienie nr: ${idZamowienia} Produkt: ${wiersz.textContent}`);
    });
  });
};

zaznaczBraki();
aktualizuj();
zamow();
