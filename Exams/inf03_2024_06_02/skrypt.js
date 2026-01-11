const wyslijButton = document.querySelector('#wyslij');
const generujButton = document.querySelector('#generuj');
const wiadomoscInput = document.querySelector('#wiadomosc');
const chat = document.querySelector('main > section');

const WYPOWIEDZI = [
  'Świetnie!',
  'Kto gra główną rolę?',
  'Lubisz filmy Tego reżysera?',
  'Będę 10 minut wcześniej',
  'Może kupimy sobie popcorn?',
  'Ja wolę Colę',
  'Zaproszę jeszcze Grześka',
  'Tydzień temu też byłem w kinie na Diunie',
  'Ja funduję bilety',
];

wyslijButton.addEventListener('click', () => {
  const wiadomosc = wiadomoscInput.value;

  const wiadomoscHTML = document.createElement('section');
  wiadomoscHTML.classList.add('jolanta');
  wiadomoscHTML.innerHTML = `
     <img src="Jolka.jpg" alt="Jolanta Nowak" />
     <p>${wiadomosc}</p>
     <span style="clear: both"></span>
    `;

  chat.append(wiadomoscHTML);
  wiadomoscHTML.scrollIntoView();
});

generujButton.addEventListener('click', () => {
  const losowaLiczba = Math.floor(Math.random() * 9);

  const wiadomoscHTML = document.createElement('section');
  wiadomoscHTML.classList.add('krzysztof');
  wiadomoscHTML.innerHTML = `
     <img src="Krzysiek.jpg" alt="Krzysztof Łukasiński" />
     <p>${WYPOWIEDZI[losowaLiczba]}</p>
     <span style="clear: both"></span>
    `;

  chat.append(wiadomoscHTML);
  wiadomoscHTML.scrollIntoView();
});
