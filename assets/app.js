import './stimulus_bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    
    // 1. On récupère les éléments
    const loginModal = document.getElementById('loginModal');
    const loginTrigger = document.getElementById('login-trigger');
    const closeBtn = document.querySelector('.close-modal');

    // 2. On vérifie que TOUS les éléments existent sur la page actuelle
    // (Cela évite des erreurs sur les pages où la modale n'est pas présente)
    if (loginModal && loginTrigger && closeBtn) {

        // Ouverture de la modale au clic sur "Se connecter"
        loginTrigger.addEventListener('click', (e) => {
            // e.preventDefault() est crucial ici : 
            // il empêche le navigateur de suivre le lien href="/login"
            e.preventDefault();
            loginModal.style.display = 'flex';
            document.body.style.overflow = 'hidden'; // Optionnel : empêche le scroll du fond
        });

        // Fermeture avec la croix
        closeBtn.addEventListener('click', () => {
            closeModal();
        });

        // Fermeture au clic à l'extérieur de la boîte blanche
        window.addEventListener('click', (e) => {
            if (e.target === loginModal) {
                closeModal();
            }
        });

        // Fonction pour fermer proprement
        function closeModal() {
            loginModal.style.display = 'none';
            document.body.style.overflow = 'auto'; // Réactive le scroll
        }
    }
});

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');