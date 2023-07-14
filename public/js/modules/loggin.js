// ********************* show/hide modal
export function toogleModal() {
    
    // loggin form
    // let loggin = document.getElementById('loggin'); //bouton de la nav 'connexion'
    let logWindow = document.getElementById('log_window'); //fenetre de connexion
    // let closeLog = document.getElementById('close-log'); //croix de la fenetre
    // let validateLog = document.getElementById('validate-log'); //bouton 'valider'
    let askNew = document.getElementById('ask-new'); //bouton 'nouveau compte' phase 1
    let newAccount = document.getElementById('new-account'); //bouton 'nouveau compte' phase 2

    // register form
    let registerWindow = document.getElementById('register-window'); //fenetre de formulaire
    // let closeRegister = document.getElementById('close-register'); //croix de la fenetre
    // let validateRegister = document.getElementById('validate-register') //bouton 'valider'
    let askOld = document.getElementById('ask-old'); //bouton 'nouveau compte' phase 1
    let connexion = document.getElementById('connexion'); //bouton 'nouveau compte' phase 2

    // general
    let modal = document.getElementById('modal'); //div de flou sur tout l'ecran


    //affiche ou masque les fenetres en fonction du clic
    window.addEventListener('click', function (e) {
        switch (e.target.id) {
            //display login modale
            case "loggin":
                modal.style.display = 'block';
                registerWindow.style.display = 'none';
                logWindow.style.display = 'flex';
                break;
            
            //show button to switch through register form
            case "ask-new":
                askNew.style.display = "none";
                newAccount.style.display = "block";
                break;
            
            // display register form
            case "new-account":
                logWindow.style.display = "none";
                registerWindow.style.display = "flex";
                break;
            
            // display register form
            case "register":
                logWindow.style.display = 'none';
                modal.style.display = 'block';
                registerWindow.style.display = 'flex';
                break;
            
            case "connexion":
                logWindow.style.display = 'flex';
                modal.style.display = 'block';
                registerWindow.style.display = 'none';
                break;
            
            case "close-log":
                modal.style.display = 'none';
                logWindow.style.display = 'none';
                break;
            
            case "close-register":
                modal.style.display = 'none';
                registerWindow.style.display = 'none';
                break;
            
            case "modal":
                modal.style.display = 'none';
                logWindow.style.display = 'none';
                registerWindow.style.display = 'none';
                break;
        }
    })


}