const lewyButton = document.querySelector('#lewy-button');
const prawyButton = document.querySelector('#prawy-button');
const aktywneZdjecie = document.querySelector('main img');
let aktywneZdjecieIndeks = 1;
const ZDJECIA = [
  './1.jpg',
  './2.jpg',
  './3.jpg',
  './4.jpg',
  './5.jpg',
  './6.jpg',
  './7.jpg',
];

const podmienZdjecie = () => {
  aktywneZdjecie.src = ZDJECIA[aktywneZdjecieIndeks - 1];
};

const nastepne = () => {
  if (aktywneZdjecieIndeks === 7) {
    aktywneZdjecieIndeks = 1;
  } else {
    aktywneZdjecieIndeks++;
  }
  podmienZdjecie();
};

const poprzednie = () => {
  if (aktywneZdjecieIndeks === 1) {
    aktywneZdjecieIndeks = 7;
  } else {
    aktywneZdjecieIndeks--;
  }
  podmienZdjecie();
};

lewyButton.addEventListener('click', poprzednie);
prawyButton.addEventListener('click', nastepne);
