const botonMenu = document.getElementById('boton-menu');
const menuVertical = document.getElementById('menu-vertical');

botonMenu.addEventListener('click', () => {
  menuVertical.style.display = menuVertical.style.display === 'flex' ? 'none' : 'flex';
});