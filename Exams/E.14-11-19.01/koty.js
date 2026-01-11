const panelDolnyKoty = document.querySelector('#panel-dolny-koty');

const kot = document.querySelector('#kot1');

const zmienZdjecie = (element, noweZdjecie) => {
  element.src = `./${noweZdjecie}.jpg`;
};

kot.addEventListener('mouseover', () => zmienZdjecie(kot, 'kot1-szary'));
kot.addEventListener('mouseout', () => zmienZdjecie(kot, 'kot1'));
kot.addEventListener('click', () => {
  zmienZdjecie(kot, 'kot1');
  zmienZdjecie(panelDolnyKoty, 'kot1');
});
