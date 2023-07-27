// ********************* show/hide modal
export function toogleModal() {
// Fonction pour afficher un élément
    function afficherElement(element) {
    element.classList.add('affiche'); // Ajoute la classe CSS "affiche" pour afficher l'élément
    }

    // Fonction pour masquer un élément
    function masquerElement(element) {
    element.classList.remove('affiche'); // Supprime la classe CSS "affiche" pour masquer l'élément
    }

  // Sélection des éléments
    const modal = document.getElementById('modal');
    const logWindow = document.getElementById('log_window');
    const registerWindow = document.getElementById('register-window');

    // Sélection des boutons pour ouvrir les fenêtres modales
    const loginBtn = document.getElementById('login');
    const registerBtn = document.getElementById('register');

    // Sélection des boutons pour fermer les fenêtres modales
    const closeLoginBtn = document.getElementById('close-log');
    const closeRegisterBtn = document.getElementById('close-register');

    // Afficher le formulaire de connexion
    loginBtn.addEventListener('click', function () {
        console.log('prout')
        afficherElement(modal);
        afficherElement(logWindow);
    });

    document.getElementById('login').addEventListener('click', function () {
        console.log('fait chier')
    })

    // Afficher le formulaire d'inscription
    registerBtn.addEventListener('click', function () {
        afficherElement(modal);
        afficherElement(registerWindow);
    });

    // Fermer le formulaire de connexion
    closeLoginBtn.addEventListener('click', function () {
        masquerElement(logWindow);
        masquerElement(modal);
    });

    // Fermer le formulaire d'inscription
    closeRegisterBtn.addEventListener('click', function () {
        masquerElement(registerWindow);
        masquerElement(modal);
    });

    // Masquer les formulaires lorsque l'utilisateur clique à l'extérieur
    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
        masquerElement(logWindow);
        masquerElement(registerWindow);
        masquerElement(modal);
        }
    });

}