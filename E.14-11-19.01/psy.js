const zdjeciaPsow = document.querySelectorAll('.psy');
const panelDolnyPsy = document.querySelector('#panel-dolny-psy');

const zmienZdjecie = (element, noweZdjecie) => {
  element.src = `./${noweZdjecie}.jpg`;
};

zdjeciaPsow[0].addEventListener('mouseover', () =>
  zmienZdjecie(zdjeciaPsow[0], 'pies1-szary')
);
zdjeciaPsow[1].addEventListener('mouseover', () =>
  zmienZdjecie(zdjeciaPsow[1], 'pies2-szary')
);
zdjeciaPsow[2].addEventListener('mouseover', () =>
  zmienZdjecie(zdjeciaPsow[2], 'pies3-szary')
);

zdjeciaPsow[0].addEventListener('mouseout', () =>
  zmienZdjecie(zdjeciaPsow[0], 'pies1')
);
zdjeciaPsow[1].addEventListener('mouseout', () =>
  zmienZdjecie(zdjeciaPsow[1], 'pies2')
);
zdjeciaPsow[2].addEventListener('mouseout', () =>
  zmienZdjecie(zdjeciaPsow[2], 'pies3')
);

zdjeciaPsow[0].addEventListener('click', () => {
  zmienZdjecie(zdjeciaPsow[0], 'pies1');
  zmienZdjecie(panelDolnyPsy, 'pies1');
});
zdjeciaPsow[1].addEventListener('click', () => {
  zmienZdjecie(zdjeciaPsow[1], 'pies2');
  zmienZdjecie(panelDolnyPsy, 'pies2');
});
zdjeciaPsow[2].addEventListener('click', () => {
  zmienZdjecie(zdjeciaPsow[2], 'pies3');
  zmienZdjecie(panelDolnyPsy, 'pies3');
});
