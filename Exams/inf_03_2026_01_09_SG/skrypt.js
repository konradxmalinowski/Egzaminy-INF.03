const sekcja1 = document.querySelector('#sekcja-1');
const sekcja2 = document.querySelector('#sekcja-2');
const sekcja3 = document.querySelector('#sekcja-3');
const br = document.querySelector('#sekcja-3 br');

const kolorButton = document.querySelector('#kolor-button');
const ksztaltButton = document.querySelector('#ksztalt-button');
const wzorButton = document.querySelector('#wzor-button');

for (let i = 1; i <= 10; i++) {
    const img = document.createElement('img');
    img.setAttribute('src', `${i}.jpg`);
    img.setAttribute('alt', `${i}.jpg`);
    img.setAttribute('title', i);
    img.classList.add('wzory');

    sekcja3.insertBefore(img, br);
}

kolorButton.addEventListener('mouseover', () => {
    sekcja1.style.display = 'block';
    sekcja2.style.display = 'none';
    sekcja3.style.display = 'none';

    kolorButton.style.backgroundColor = 'Salmon';
    ksztaltButton.style.backgroundColor = 'Crimson';
    wzorButton.style.backgroundColor = 'Crimson';
});

ksztaltButton.addEventListener('mouseover', () => {
    sekcja1.style.display = 'none';
    sekcja2.style.display = 'block';
    sekcja3.style.display = 'none';

    ksztaltButton.style.backgroundColor = 'Salmon';
    kolorButton.style.backgroundColor = 'Crimson';
    wzorButton.style.backgroundColor = 'Crimson';
});

wzorButton.addEventListener('mouseover', () => {
    sekcja1.style.display = 'none';
    sekcja2.style.display = 'none';
    sekcja3.style.display = 'block';

    kolorButton.style.backgroundColor = 'Crimson';
    ksztaltButton.style.backgroundColor = 'Crimson';
    wzorButton.style.backgroundColor = 'Salmon';
});
