// część 1
const zakladkiPrzyciski = document.querySelectorAll('main > button');
const zakladki = document.querySelectorAll('main > div');

const zmienZakladke = (idx) => {
  zakladki.forEach((zakladka) => {
    zakladka.style.display = 'none';
  });

  zakladki[idx].style.display = 'block';
};

zakladkiPrzyciski.forEach((przycisk, idx) => {
  przycisk.addEventListener('click', () => zmienZakladke(idx));
});

// część 2
const pasekPostepu = document.querySelector('section > div');
const inputy = document.querySelectorAll('input:not(input[type="checkbox"])');

const zmienWartoscPaskaPostepu = () => {
  const szerokoscPaska = Math.ceil(
    parseFloat(
      window
        .getComputedStyle(document.querySelector('section > div'))
        .width.slice(0, -2)
    )
  );
  const szerokoscRodzica = Math.ceil(
    parseFloat(
      window
        .getComputedStyle(document.querySelector('section'))
        .width.slice(0, -2)
    )
  );

  const szerokoscPaskaProcent = Math.trunc(
    (szerokoscPaska / szerokoscRodzica) * 100
  );

  if (szerokoscPaskaProcent === 100) return;

  pasekPostepu.style.width = `${szerokoscPaskaProcent + 12}%`;
};

inputy.forEach((input) => {
  input.addEventListener('blur', () => zmienWartoscPaskaPostepu());
});

// część 3
const zatwierdzWyslaniePrzycisk = document.querySelector(
  '.zatwierdz-dane-przycisk'
);

const zatwierdzWyslanie = () => {
  const wartosci = [];

  inputy.forEach((input) => {
    wartosci.push(input.value);
  });

  wartosci.push(
    document.querySelector('input[type="checkbox"]').checked ? 'on' : 'off'
  );

  console.log(wartosci.join(', '));
};

zatwierdzWyslaniePrzycisk.addEventListener('click', zatwierdzWyslanie);
