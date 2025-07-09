const glowneZdjecie = document.querySelector('img[alt="galeria"]');
const zdjecia = document.querySelectorAll('.lewy img');

zdjecia.forEach((zdjecie) => {
  zdjecie.addEventListener('click', () =>
    glowneZdjecie.setAttribute(
      'src',
      `./pliki7/${zdjecie.getAttribute('alt')}.jpg`
    )
  );
});

const offIcon = document.querySelector('img[alt="icon off"]');

offIcon.addEventListener('click', () => {
  offIcon.setAttribute(
    'src',
    `../pliki7/${
      offIcon.src.includes('icon-off.png') ? 'icon-on' : 'icon-off'
    }.png`
  );
});
