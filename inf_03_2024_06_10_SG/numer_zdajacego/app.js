const blockquotes = document.querySelectorAll('blockquote');

blockquotes[0].addEventListener('click', () => {
  blockquotes[0].style.display = 'none';
  blockquotes[1].style.display = 'block';
});

blockquotes[1].addEventListener('click', () => {
  blockquotes[1].style.display = 'none';
  blockquotes[2].style.display = 'block';
});

blockquotes[2].addEventListener('click', () => {
  blockquotes[2].style.display = 'none';
  blockquotes[0].style.display = 'block';
});
