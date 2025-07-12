const inputA = document.querySelector('#a');
const inputB = document.querySelector('#b');
const dodawanieButton = document.querySelector('.dodawanie');
const odejmowanieButton = document.querySelector('.odejmowanie');
const mnozenieButton = document.querySelector('.mnozenie');
const dzielenieButton = document.querySelector('.dzielenie');
const potegowanieButton = document.querySelector('.potegowanie');
const wynik = document.querySelector('#wynik');

const pobierzWartosci = () => {
  const a = Number(inputA.value);
  const b = Number(inputB.value);

  return { a, b };
};

dodawanieButton.addEventListener('click', () => {
  const { a, b } = pobierzWartosci();
  wynik.textContent = `Wynik: ${a + b}`;
});

odejmowanieButton.addEventListener('click', () => {
  const { a, b } = pobierzWartosci();
  wynik.textContent = `Wynik: ${a - b}`;
});

mnozenieButton.addEventListener('click', () => {
  const { a, b } = pobierzWartosci();
  wynik.textContent = `Wynik: ${a * b}`;
});

dzielenieButton.addEventListener('click', () => {
  const { a, b } = pobierzWartosci();
  wynik.textContent = `Wynik: ${a / b}`;
});

potegowanieButton.addEventListener('click', () => {
  const { a, b } = pobierzWartosci();
  wynik.textContent = `Wynik: ${Math.pow(a, b)}`;
});
