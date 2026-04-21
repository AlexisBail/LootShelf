import './stimulus_bootstrap.js';
import './styles/app.css';

// --- 1. MODALE DE CONNEXION (CODE PERSONNALISÉ) ---
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
    const modalTrigger = e.target.closest('[data-bs-toggle="modal"]');
    
    if (modalTrigger) {
        e.preventDefault();
        const targetId = modalTrigger.getAttribute('data-bs-target');
        const modalElement = document.querySelector(targetId);
        
        if (modalElement) {
            console.log("Tentative d'ouverture manuelle de : " + targetId);
            
            // 1. On essaie la méthode propre via Bootstrap
            if (window.bootstrap) {
                const modalInstance = bootstrap.Modal.getOrCreateInstance(modalElement);
                modalInstance.show();
            }
            
            // 2. SÉCURITÉ : Si Bootstrap fait grève, on force le CSS
            modalElement.classList.add('show');
            modalElement.style.display = 'block';
            document.body.classList.add('modal-open');
            
            // On crée un backdrop (fond noir) manuel si besoin
            if (!document.querySelector('.modal-backdrop')) {
                const backdrop = document.createElement('div');
                backdrop.className = 'modal-backdrop fade show';
                document.body.appendChild(backdrop);
            }
        }
    }

    // Gestion de la fermeture (bouton close ou clic extérieur)
    if (e.target.closest('[data-bs-dismiss="modal"]') || e.target.classList.contains('modal')) {
        const activeModal = document.querySelector('.modal.show');
        if (activeModal) {
            activeModal.classList.remove('show');
            activeModal.style.display = 'none';
            document.body.classList.remove('modal-open');
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();
        }
    }
    
        // --- FERMETURE DES MODALES (Croix ou Fond) ---
    if (e.target.closest('.close-modal') || e.target.id === 'loginModal') {
        closeModal();
    }

    // --- GESTION DE LA SIDEBAR (Toggle) ---
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
    
    // Initialisation des tooltips Bootstrap si présents
    if (window.bootstrap) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    }

    initPasswordValidation();
};

// Événements pour que ça marche au premier chargement ET après navigation
document.addEventListener('DOMContentLoaded', init);
document.addEventListener('turbo:load', init);