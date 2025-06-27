const header = document.querySelector('.encabezado');
let lastScroll = 0;

window.addEventListener('scroll', () => {
    const currentScroll = window.scrollY;
    
    if (currentScroll <= 0) {
        header.classList.add('none-scrolled');
        header.classList.remove('active-scrolled');
    }else if (currentScroll > lastScroll) {
        if (currentScroll > 50) {
            header.classList.remove('none-scrolled');
            header.classList.add('active-scrolled');
        }
    }
    
    lastScroll = currentScroll;
});

const botonMenu = document.getElementById('boton-menu');
const menuCircular = document.getElementById('menu-circular');
const botonBusqueda = document.getElementById('boton-busqueda');
const inputBusqueda = document.getElementById('busqueda');

botonMenu.addEventListener('click', () => {
    if (menuCircular.style.display === 'flex') {
        menuCircular.style.display = 'none';
    } else {
        menuCircular.style.display = 'flex';
        posicionarMenuCircular();
    }
});

botonBusqueda.addEventListener('click', () => {
    inputBusqueda.classList.toggle('oculto');
    if (!inputBusqueda.classList.contains('oculto')) {
        inputBusqueda.style.width = '150px';
        inputBusqueda.style.opacity = '1';
    } else {
        inputBusqueda.style.width = '0';
        inputBusqueda.style.opacity = '0';
    }
});

function posicionarMenuCircular() {
    const items = menuCircular.querySelectorAll('.item');
    const radio = 220;
    const anguloInicial = -90;
    const anguloFinal = 90;
    const total = items.length;

    items.forEach((item, i) => {
        const angulo = anguloInicial + (i * (anguloFinal - anguloInicial) / (total - 1));
        const rad = angulo * (Math.PI / 180);
        const x = 250 + radio * Math.cos(rad);
        const y = 250 + radio * Math.sin(rad);
        item.style.left = `${x}px`;
        item.style.top = `${y}px`;
        item.style.transform = 'translate(-50%, -50%)';
    });
}


const seccionNosotros = document.querySelector('.seccion-nosotros');
const letras = seccionNosotros.querySelectorAll('.letra');

const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            letras.forEach(letra => {
                letra.classList.add('animada');
            });
        } else {
            letras.forEach(letra => {
                letra.classList.remove('animada');
            });
        }
    });
}, {
    threshold: 0.5 // cuando el 50% de la seccion esta visible
});

const slides = document.querySelectorAll('.slide');
let indiceActual = 0;

function mostrarSlide(index) {
    slides.forEach((slide, i) => {
        slide.classList.remove('activo');
        if (i === index) slide.classList.add('activo');
    });
}

function moverSlide(direccion) {
    indiceActual += direccion;
    if (indiceActual < 0) indiceActual = slides.length - 1;
    if (indiceActual >= slides.length) indiceActual = 0;
    mostrarSlide(indiceActual);
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') moverSlide(-1);
    if (e.key === 'ArrowRight') moverSlide(1);
});
observer.observe(seccionNosotros);