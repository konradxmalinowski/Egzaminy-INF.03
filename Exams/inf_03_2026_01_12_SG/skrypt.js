const dodajButton = document.querySelector('#dodaj-wzor-button');
const wzorInput = document.querySelector("#wzor");
const kolorInput = document.querySelector("#kolor");
const cenaInput = document.querySelector("#cena");
const sekcja = document.querySelector('section');
const form = document.querySelector('form');

form.addEventListener('submit', (event) => {
    event.preventDefault();
});

dodajButton.addEventListener('click', () => {
    const wzor = wzorInput.files[0].name;
    const kolor = kolorInput.value;
    const cena = cenaInput.value;

    alert(`Wzór: ${wzor}, kolor: ${kolor}, cena: ${cena} zł`);

    const obraz = document.createElement('img');
    obraz.setAttribute('src', wzor);
    obraz.setAttribute('alt', wzor);
    obraz.classList.add('miniatury');

    sekcja.appendChild(obraz);
});