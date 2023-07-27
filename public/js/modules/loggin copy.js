// ********************* show/hide modal
// export function toogleModal() {
    
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


        /////// media query ////
    
    const mediaQuery = window.matchMedia('(max-width: 768px)');
    const burger = document.getElementById('burger');
    const closeBtn = document.getElementById('close-log');
    const menuMobile = document.getElementById('menu-mobile');
    if (burger) {
        
    }


    //affiche ou masque les fenetres en fonction du clic
    window.addEventListener('click', function (e) {
        switch (e.target.id) {
            //display login modale
            case "loggin":
                if (mediaQuery.matches) {
                    menuMobile.style.display = "none";
                    burger.style.display = "none";
                    modal.style.display = 'none';
                    registerWindow.style.display = 'none';
                    logWindow.style.display = 'flex';
                } else {
                    modal.style.display = 'block';
                    registerWindow.style.display = 'none';
                    logWindow.style.display = 'flex';
                }
                break;
            
            
            // switch to register form
            case "new-account":
                if (mediaQuery.matches) {
                    menuMobile.style.display = "none";
                    burger.style.display = "none";
                    modal.style.display = 'none';
                    registerWindow.style.display = "flex";
                } else {
                    logWindow.style.display = "none";
                    registerWindow.style.display = "flex";}
                break;
            
            // display register form
            case "register":
                case "new-account":
                if (mediaQuery.matches) {
                    burger.style.display = "none";
                    modal.style.display = 'none';
                    logWindow.style.display = 'none';
                    registerWindow.style.display = 'flex';
                } else {
                    logWindow.style.display = 'none';
                    modal.style.display = 'block';
                    registerWindow.style.display = 'flex';
                }
                break;
            
            //send login form
            case "connexion":
                if (mediaQuery.matches) {
                    burger.style.display = "none";
                    modal.style.display = 'none';
                    logWindow.style.display = 'flex';
                    registerWindow.style.display = 'none';
                } else {
                    logWindow.style.display = 'flex';
                    modal.style.display = 'block';
                    registerWindow.style.display = 'none';
                }
                break;
            
            //close login form
            case "close-log":
                if (mediaQuery.matches) {
                    burger.style.display = "block";
                    modal.style.display = 'none';
                    logWindow.style.display = 'none';
                } else {
                    modal.style.display = 'none';
                    logWindow.style.display = 'none';
                }
                break;
            
            //close register form
            case "close-register":
                if (mediaQuery.matches) {
                    burger.style.display = "block";
                    modal.style.display = 'none';
                    registerWindow.style.display = 'none';
                } else {
                    modal.style.display = 'none';
                    registerWindow.style.display = 'none';
                }
                break;
            
            //close both forms
            case "modal":
                if (mediaQuery.matches) {
                    burger.style.display = "block";
                    modal.style.display = 'none';
                }
                modal.style.display = 'none';
                logWindow.style.display = 'none';
                registerWindow.style.display = 'none';
                break;
            
            default:
                if (mediaQuery.matches) {
                    burger.style.display = "block";
                }
                modal.style.display = 'none';
                logWindow.style.display = 'none';
                registerWindow.style.display = 'none';
        }
    })


// }