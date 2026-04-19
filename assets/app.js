import './stimulus_bootstrap.js';
import './styles/app.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';

// --- 1. FONCTIONS D'OUVERTURE / FERMETURE DE LA MODALE ---
function openModal() {
    const modal = document.getElementById('loginModal');
    if (modal) {
        modal.style.display = 'flex'; 
        document.body.style.overflow = 'hidden';
    }
}

function closeModal() {
    const modal = document.getElementById('loginModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

// --- 2. ÉCOUTE GLOBALE DES CLICS (Délégation d'événements) ---
document.addEventListener('click', (e) => {
    
    // --- GESTION DE LA MODALE DE CONNEXION ---
    const loginTrigger = e.target.closest('#login-trigger');
    if (loginTrigger) {
        if (window.location.pathname !== '/home' && window.location.pathname !== '/') {
            return; 
        }
        e.preventDefault();
        openModal();
    }

    const closeBtn = e.target.closest('.close-modal');
    if (closeBtn) {
        closeModal();
    }

    if (e.target.id === 'loginModal') {
        closeModal();
    }

    // --- GESTION DE LA SIDEBAR (Burger / Croix) ---
    const toggleBtn = e.target.closest('#toggle-sidebar');
    if (toggleBtn) {
        const sidebar = document.getElementById('sidebar');
        const menuIcon = toggleBtn.querySelector('.menu-icon');

        if (sidebar && menuIcon) {
            sidebar.classList.toggle('closed');
            if (sidebar.classList.contains('closed')) {
                menuIcon.textContent = '☰'; 
            } else {
                menuIcon.textContent = '✕'; 
            }
        }
    }

    // --- 🚀 NOUVEAUTÉ : GESTION DU MENU UTILISATEUR (CLIC) ---
    const userMenu = e.target.closest('.user-menu');
    
    if (userMenu) {
        // On vérifie si on a cliqué spécifiquement sur le pseudo (le déclencheur)
        const isPseudoClick = e.target.closest('.pseudo-text');
        
        if (isPseudoClick) {
            // On bascule l'état du menu
            userMenu.classList.toggle('active');
        }
        // Note : Si on clique sur un lien à l'intérieur du menu, 
        // la page changera et le menu disparaîtra naturellement.
    } else {
        // Si on clique n'importe où en dehors du menu .user-menu, 
        // on retire la classe 'active' de TOUS les menus utilisateur ouverts
        document.querySelectorAll('.user-menu.active').forEach(menu => {
            menu.classList.remove('active');
        });
    }
});

// --- 3. DÉTECTION DU LIEN (#login) DANS L'URL ---
function checkHash() {
    if (window.location.hash === '#login') {
        openModal();
        history.replaceState(null, null, window.location.pathname);
    }
}

document.addEventListener('DOMContentLoaded', checkHash);
document.addEventListener('turbo:load', checkHash);