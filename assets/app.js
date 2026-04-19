import './stimulus_bootstrap.js';
import './styles/app.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';

// --- 1. FONCTIONS D'OUVERTURE / FERMETURE ---
function openModal() {
    const modal = document.getElementById('loginModal');
    if (modal) {
        modal.style.display = 'flex'; // Toujours flex pour le centrage
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

// --- 2. ÉCOUTE GLOBALE DES CLICS (Anti-Bug Symfony Turbo) ---
document.addEventListener('click', (e) => {
    
    // Si on clique sur le bouton "SE CONNECTER"
    const loginTrigger = e.target.closest('#login-trigger');
    if (loginTrigger) {
        
        // 🚀 NOUVEAUTÉ : Vérification de la page actuelle
        if (window.location.pathname !== '/home' && window.location.pathname !== '/') {
            // On n'est PAS sur l'accueil. On arrête le script ici.
            // Le navigateur va suivre le lien naturellement vers /home#login
            return; 
        }

        // Si on est déjà sur l'accueil, on bloque le rechargement et on ouvre la boîte
        e.preventDefault();
        openModal();
    }

    // Si on clique sur la croix "X"
    const closeBtn = e.target.closest('.close-modal');
    if (closeBtn) {
        closeModal();
    }

    // Si on clique dans le vide (sur le fond sombre)
    if (e.target.id === 'loginModal') {
        closeModal();
    }
});

// --- 3. DÉTECTION DU LIEN (#login) ---
function checkHash() {
    if (window.location.hash === '#login') {
        openModal();
        // On efface le #login de l'URL pour faire propre
        history.replaceState(null, null, window.location.pathname);
    }
}

// Dans ton app.js existant ou via la délégation d'événements
document.addEventListener('click', (e) => {
    // Toggle Sidebar
    const toggleBtn = e.target.closest('#toggle-sidebar');
    if (toggleBtn) {
        document.getElementById('sidebar').classList.toggle('closed');
        const arrow = toggleBtn.querySelector('.arrow');
        arrow.textContent = arrow.textContent === '◀' ? '▶' : '◀';
    }
});

// On lance la vérification au chargement normal ET au chargement Turbo
document.addEventListener('DOMContentLoaded', checkHash);
document.addEventListener('turbo:load', checkHash);