const botonMenu = document.getElementById('boton_menu');
const menuLateral = document.getElementById('menu_lateral');
const contenidoPanel = document.getElementById('contenido_panel');

botonMenu.addEventListener('click', () => {
    menuLateral.classList.toggle('oculto');
    contenidoPanel.classList.toggle('expandido');
});

function toggleSubmenu(id) {
    const submenu = document.getElementById(id);
    submenu.style.display = submenu.style.display === 'flex' ? 'none' : 'flex';
}

const ventasCtx = document.getElementById('ventasChart').getContext('2d');
const ventasChart = new Chart(ventasCtx, {
    type: 'line',
    data: {
        labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
        datasets: [{
            label: 'Ventas ($)',
            data: [820, 1250, 940, 1100, 1500, 1700, 1400],
            borderColor: '#f59e0b',
            backgroundColor: 'rgba(245, 158, 11, 0.2)',
            tension: 0.4,
        }]
    }
});

const productosCtx = document.getElementById('productosChart').getContext('2d');
const productosChart = new Chart(productosCtx, {
    type: 'bar',
    data: {
        labels: ['Pan francés', 'Croissant', 'Arepa', 'Torta', 'Galleta'],
        datasets: [{
            label: 'Unidades Vendidas',
            data: [120, 95, 85, 60, 40],
            backgroundColor: ['#84cc16', '#10b981', '#3b82f6', '#8b5cf6', '#ef4444']
        }]
    }
});