const czcionkaInput = document.querySelector('#rozmiar');
const przyciskCzerwony = document.querySelector('#czerwony');
const przyciskZielony = document.querySelector('#zielony');
const przyciskNiebieski = document.querySelector('#niebieski');
const stylCzcionki = document.querySelector('#styl');
const paragraf = document.querySelector('#tekst');

const zmienStyl = (kolor) => {
  const wielkoscCzcionki = Number(czcionkaInput.value);
  const styl = stylCzcionki.value;
  console.log(wielkoscCzcionki, styl);

  paragraf.style.fontSize = wielkoscCzcionki + '%';
  paragraf.style.fontStyle = styl === 'kursywa' ? 'italic' : 'normal';
  paragraf.style.color = kolor;
};

przyciskCzerwony.addEventListener('click', () => zmienStyl('red'));
przyciskZielony.addEventListener('click', () => zmienStyl('green'));
przyciskNiebieski.addEventListener('click', () => zmienStyl('blue'));
