// ********************* show/hide modal
export function toogleModal() {
        
    let loggin = document.getElementById('loggin'); //bouton de la nav 'connexion'
    let logWindow = document.getElementById('log_window'); //fenetre de connexion
    let errorLogMail = document.getElementById('error_log_mail'); //msgs d'erreur
    let errorLogPswd = document.getElementById('error_log_pswd');

    let registerWindow = document.getElementById('register-window'); //fenetre de formulaire
    let errorNewMail = document.getElementById('error_new_mail'); // msgs d'erreur
    let errorNewPswd = document.getElementById('error_new_pswd');
    let errorNewVerif = document.getElementById('error_new_verif');

    let modal = document.getElementById('modal'); //div de flou sur tout l'ecran
    
    let clearMsg = "index.php?route=clearMsg" //methode pour effacer les messages d'erreur


    let closeLog = document.getElementById('close-log'); //croix de la fenetre de connexion
    let validateLog = document.getElementById('validate-log'); //bouton 'valider'
    let newAccount = document.getElementById('new-account'); //bouton 'nouveau compte'

    let closeRegister = document.getElementById('close-register'); //croix de la fenetre nouveau compte
    let validateRegister = document.getElementById('validate-register') //bouton 'valider'
    let cancelRegister = document.getElementById('cancel'); //bouton 'annuler'

    //s'il y a une erreur dans le formulaire de connexion, affiche la fenetre avec les erreurs
    if(errorLogMail || errorLogPswd !== null) {
            modal.style.display = 'block';
            logWindow.style.display = 'flex';
    }
    
    //pareil avec le formulaire de connexion
    if(errorNewMail || errorNewPswd || errorNewVerif !== null) {
            modal.style.display = 'block';
            registerWindow.style.display = 'flex';
    }
    
    //affiche ou masque les fenetres en fonction du clic
    window.addEventListener('click', function (e) {
        switch (e.target.id) {
            case "loggin":
                modal.style.display = 'block';
                logWindow.style.display = 'flex';
                break;
            
            case "new-account":
                logWindow.style.display = "none";
                registerWindow.style.display = "flex";
                break;
            
            case "close-log":
                modal.style.display = 'none';
                logWindow.style.display = 'none';
                // window.location.href = "index.php?route=clearMsg";
                break;
            
            case "register":
                modal.style.display = 'block';
                registerWindow.style.display = 'flex';
                break;
            
            // case "cancel":
            //     modal.style.display = 'none';
            //     registerWindow.style.display = 'none';
            //     logWindow.style.display = 'none';
            //     // window.location.href = "index.php?route=clearMsg";
            //     break;
            
            case "close-register":
                modal.style.display = 'none';
                registerWindow.style.display = 'none';
                // window.location.href = "index.php?route=clearMsg";
                break;
            
            case "modal":
                modal.style.display = 'none';
                registerWindow.style.display = 'none';
                // window.location.href = "index.php?route=clearMsg";
                break;
        }
    })
}