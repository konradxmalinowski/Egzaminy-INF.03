const przyciski = document.querySelectorAll('button');
const radioButtony = document.querySelectorAll('input[type="radio"]');
const suwaki = document.querySelectorAll('input[type="range"]');
const obrazki = document.querySelectorAll('img');

// obraz 1
przyciski[0].addEventListener('click', () => {
  if (radioButtony[0].checked) {
    obrazki[0].style.filter = `blur(6px)`;
  } else if (radioButtony[1].checked) {
    obrazki[0].style.filter = 'sepia(100%)';
  } else if (radioButtony[2].checked) {
    obrazki[0].style.filter = 'invert(100%)';
  }
});

// obraz 2
przyciski[1].addEventListener('click', () => {
  obrazki[1].style.filter = 'grayscale(0%)';
});

przyciski[2].addEventListener('click', () => {
  obrazki[1].style.filter = 'grayscale(100%)';
});

// obraz 3
przyciski[3].addEventListener('click', () => {
  obrazki[2].style.filter = `opacity(${suwaki[0].value}%)`;
});

// obraz 4
przyciski[4].addEventListener('click', () => {
  obrazki[3].style.filter = `brightness(${suwaki[1].value}%)`;
});
