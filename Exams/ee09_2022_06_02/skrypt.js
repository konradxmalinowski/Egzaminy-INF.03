const przycisk = document.querySelector('#generuj-palete-button');
const wierszeTabeli = document.querySelectorAll('table tr');

przycisk.addEventListener('click', () => {
  const skladowaH = document.querySelector('#skladowa-h').value;
  wierszeTabeli.forEach((wiersz, wierszIdx) => {
    if (wierszIdx === 0) {
      wiersz.style.backgroundColor = `hsl(${skladowaH}, 100%, 50%)`;
      return;
    }

    let drugaWartosc = 80;
    wiersz.querySelectorAll('td').forEach((kolumna, kolumnIdx) => {
      kolumna.style.backgroundColor = `hsl(${skladowaH}, ${drugaWartosc}%, 50%)`;
      drugaWartosc -= 20;
    });
  });
});
