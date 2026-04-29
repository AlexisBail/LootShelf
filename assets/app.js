import './stimulus_bootstrap.js';
import './styles/app.css';

// --- MODALE DE CONNEXION ---
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

document.addEventListener('click', (e) => {
    
    // --- A. GESTION DU MENU UTILISATEUR (PSEUDO) ---
    const userMenu = e.target.closest('.user-menu');
    const isPseudoClick = e.target.closest('.pseudo-text');

    if (userMenu && isPseudoClick) {
        // On bascule la classe active pour afficher/cacher le menu
        userMenu.classList.toggle('active');
        console.log("Menu utilisateur basculé !");
    } else if (!userMenu) {
        // Si on clique n'importe où ailleurs sur la page, on ferme le menu
        document.querySelectorAll('.user-menu.active').forEach(menu => {
            menu.classList.remove('active');
        });
    }

    // --- B. GESTION DU BOUTON "SE CONNECTER" (ID login-trigger) ---
    const loginTrigger = e.target.closest('#login-trigger');
    if (loginTrigger) {
        if (window.location.pathname === '/' || window.location.pathname === '/home') {
            e.preventDefault();
            openModal();
        }
    }

    // --- C. FORCE L'OUVERTURE DES MODALES BOOTSTRAP (Admin) ---
    const modalTrigger = e.target.closest('[data-bs-toggle="modal"]');
    if (modalTrigger) {
        e.preventDefault();
        const targetId = modalTrigger.getAttribute('data-bs-target');
        const modalElement = document.querySelector(targetId);
        
        if (modalElement) {
            console.log("Tentative d'ouverture manuelle de : " + targetId);
            
            if (window.bootstrap) {
                const modalInstance = bootstrap.Modal.getOrCreateInstance(modalElement);
                modalInstance.show();
            }
            
            // SÉCURITÉ : Force l'affichage si Bootstrap ne répond pas
            modalElement.classList.add('show');
            modalElement.style.display = 'block';
            document.body.classList.add('modal-open');
            
            if (!document.querySelector('.modal-backdrop')) {
                const backdrop = document.createElement('div');
                backdrop.className = 'modal-backdrop fade show';
                document.body.appendChild(backdrop);
            }
        }
    }

    // --- D. GESTION DE LA FERMETURE DES MODALES (Bootstrap + Login) ---
    if (e.target.closest('[data-bs-dismiss="modal"]') || e.target.classList.contains('modal') || e.target.id === 'loginModal' || e.target.closest('.close-modal')) {
        
        // Ferme la modale Bootstrap active
        const activeModal = document.querySelector('.modal.show');
        if (activeModal) {
            activeModal.classList.remove('show');
            activeModal.style.display = 'none';
            document.body.classList.remove('modal-open');
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();
        }
        
        // Ferme la modale Login personnalisée
        closeModal();
    }

    // --- E. GESTION DE LA SIDEBAR (Toggle) ---
    const toggleBtn = e.target.closest('#toggle-sidebar');
    if (toggleBtn) {
        const sidebar = document.getElementById('sidebar');
        if (sidebar) {
            sidebar.classList.toggle('closed');
            const menuIcon = toggleBtn.querySelector('.menu-icon');
            if (menuIcon) {
                menuIcon.textContent = sidebar.classList.contains('closed') ? '☰' : '✕';
            }
        }
    }
});


// --- 3. VALIDATION DU MOT DE PASSE (INFO-BULLE) ---
function initPasswordValidation() {
    const passwordInput = document.querySelector('input[type="password"][name*="plainPassword"]');
    const tooltip = document.getElementById('password-help');

    if (!passwordInput || !tooltip) return;

    const requirements = {
        length:  { el: document.getElementById('length'),  regex: /.{12,}/ },
        upper:   { el: document.getElementById('upper'),   regex: /[A-Z]/ },
        lower:   { el: document.getElementById('lower'),   regex: /[a-z]/ },
        number:  { el: document.getElementById('number'),  regex: /[0-9]/ },
        special: { el: document.getElementById('special'), regex: /[@$!%*?&.]/ }
    };

    passwordInput.addEventListener('focus', () => tooltip.style.display = 'block');
    passwordInput.addEventListener('blur', () => tooltip.style.display = 'none');

    passwordInput.addEventListener('input', () => {
        const value = passwordInput.value;
        for (const key in requirements) {
            const item = requirements[key];
            if (item.el) {
                if (item.regex.test(value)) {
                    item.el.classList.add('valid');
                    item.el.innerHTML = `✅ ${item.el.innerText.substring(2)}`;
                } else {
                    item.el.classList.remove('valid');
                    item.el.innerHTML = `❌ ${item.el.innerText.substring(2)}`;
                }
            }
        }
    });
}

// --- 4. INITIALISATION TURBO ---
const init = () => {
    console.log("LootShelf : JavaScript chargé !");
    
    if (window.bootstrap) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    }

    initPasswordValidation();
};

// Événements pour que ça marche au premier chargement ET après navigation Turbo
document.addEventListener('DOMContentLoaded', init);
document.addEventListener('turbo:load', init);