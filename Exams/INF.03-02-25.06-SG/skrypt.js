const wykonaneButton = document.querySelectorAll('.wykonane-button');
const elementySpan = document.querySelectorAll('li span');
const input = document.querySelector('#notatka');
const dodajButton = document.querySelector('.dodaj-button');
const ul = document.querySelector('ul');

wykonaneButton.forEach((button, idx) => {
    button.addEventListener('click', () => {
        elementySpan[idx].style.textDecoration = "line-through 1px black";
    });
});

dodajButton.addEventListener('click', () => {
    const wartoscNowejNotatki = input.value;
    const li = document.createElement('li');
    const span = document.createElement('span');
    span.textContent = wartoscNowejNotatki;
    const button = document.createElement('button');
    button.textContent = "Wykonane";
    button.classList.add('wykonane-button');

    li.append(span, button);
    ul.appendChild(li);
});