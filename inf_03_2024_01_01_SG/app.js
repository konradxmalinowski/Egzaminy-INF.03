const przyciskPrzeslij = document.querySelector('#przeslij-button');
const formularz = document.querySelector('form');
const imieInput = document.querySelector('#imie');
const nazwiskoInput = document.querySelector('#nazwisko');
const emailInput = document.querySelector('#email');
const zgloszenieTextarea = document.querySelector('#zgloszenie');
const regulaminInput = document.querySelector('#regulamin');
const wynik = document.querySelector('#wynik');

formularz.addEventListener('submit', (event) => {
  event.preventDefault();
});

przyciskPrzeslij.addEventListener('click', () => {
  const imie = imieInput.value;
  const nazwisko = nazwiskoInput.value;
  const email = emailInput.value;
  const zgloszenie = zgloszenieTextarea.value;
  const regulamin = regulaminInput.checked;

  if (!regulamin) {
    wynik.textContent = 'Musisz zapoznać się z regulaminem';
    wynik.style.color = 'red';
    return;
  }

  wynik.innerHTML = `${imie.toUpperCase()} ${nazwisko.toUpperCase()} <br> Treść Twojej sprawy: ${zgloszenie}.`;
  wynik.style.color = 'navy';
});
