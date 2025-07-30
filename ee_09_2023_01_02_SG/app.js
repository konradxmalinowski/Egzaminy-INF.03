const aktywneZdjecie = document.querySelector('#duzy-obraz');
const przyciskPoprzednie = document.querySelector('#prev');
const przyciskNastepne = document.querySelector('#next');
const miniatury = document.querySelectorAll('.miniatura');

let obecnyIndex = 1;

const podmienZdjecie = () => {
  aktywneZdjecie.src = `${obecnyIndex}.jpg`;
};

const nastepny = () => {
  if (obecnyIndex === 5) {
    obecnyIndex = 1;
  } else {
    obecnyIndex++;
  }
  podmienZdjecie();
};

const poprzedni = () => {
  if (obecnyIndex === 1) {
    obecnyIndex = 5;
  } else {
    obecnyIndex--;
  }
  podmienZdjecie();
};

przyciskNastepne.addEventListener('click', nastepny);
przyciskPoprzednie.addEventListener('click', poprzedni);

miniatury.forEach((miniatura, idx) => {
  miniatura.addEventListener('click', () => {
    obecnyIndex = idx + 1;
    podmienZdjecie();
  });
});
