// ********************* show/hide modal
export function toogleModal() {

    function showElement(element) {
        element.style.display = 'flex';
    }
    
    function hideElement(element) {
        element.style.display = 'none';
    }

    const modal = document.getElementById('modal');
    const logWindow = document.getElementById('log_window');
    const registerWindow = document.getElementById('register-window');
    const mediaQuery = window.matchMedia('(max-width: 768px)');
    const burger = document.getElementById('burger');
    const menuMobile = document.getElementById('menu-mobile');

    const promptLogin = document.getElementById('errorL');
    const promptRegister = document.getElementById('errorR');

    //////////////////////////////////////////////////
    // Show / hide password

    function showPassword(password) {
        password.setAttribute('type', 'text');
    }
    function hidePassword(password) {
        password.setAttribute('type', 'password');
    }
    // register form
    const registerShow = document.getElementById('register-show')
    const registerHide = document.getElementById('register-hide')
    const registerPswd = document.getElementById('pswd_new');
    const pswdConfirm = document.getElementById('pswd_confirm_new')

    // login form
    const loginShow = document.getElementById('login-show')
    const loginHide = document.getElementById('login-hide')
    const loginPswd = document.getElementById('pswd_log');
    //////////////////////////////////////////////////


    // prompt modale with php error
    if (promptLogin || promptRegister) {
        if (mediaQuery.matches) {
            hideElement(menuMobile);
            hideElement(burger);
            logWindow.classList.add('bg-animed');
        } else {
            showElement(modal);
        }
        
        if (promptLogin) {
            showElement(logWindow);
        } else if (promptRegister) {
            showElement(registerWindow);
        }
    } 



    if (logWindow || registerWindow) {
        // display login form from large screen
        document.getElementById('login').addEventListener('click', function () {
            showElement(modal);
            showElement(logWindow);
        })

        // display login form from mobile
        document.getElementById('login-mobile').addEventListener('click', function () {
            hideElement(menuMobile);
            hideElement(burger);
            showElement(logWindow);
            logWindow.classList.add('bg-animed');
        })

        // switch to register form
        document.getElementById('register').addEventListener('click', function () {
            if (mediaQuery.matches) {
                hideElement(menuMobile);
                showElement(registerWindow);
                registerWindow.classList.add('bg-animed');
            } else {
                showElement(registerWindow);
                hideElement(logWindow);
            }
        })

        // switch to login form
        document.getElementById('connexion').addEventListener('click', function () {
            if (mediaQuery.matches) {
                hideElement(registerWindow);
                showElement(logWindow);
            } else {
                showElement(modal);
                hideElement(registerWindow);
                showElement(logWindow);
            }
        })

        //close login form
        document.getElementById('close-log').addEventListener('click', function () {
            if (mediaQuery.matches) {
                hideElement(registerWindow);
                hideElement(logWindow);
                showElement(burger);
            } else {
                hideElement(modal);
                hideElement(logWindow);
            }
        })

    //close login form
        document.getElementById('close-register').addEventListener('click', function () {
            if (mediaQuery.matches) {
                hideElement(registerWindow)
                hideElement(logWindow);
                showElement(burger);
            } else {
                hideElement(modal);
                hideElement(registerWindow)
            }
        })

        //close both forms
        modal.addEventListener('click', function (e) {
            hideElement(modal);
            hideElement(logWindow);
            hideElement(registerWindow);
        })

        logWindow.addEventListener('click', function (e) {
            e.stopPropagation();
        });

        registerWindow.addEventListener('click', function (e) {
            e.stopPropagation();
        });


        //////////////////////////////////////////////////
        // Show / hide password
        registerShow.style.display = 'inline-flex';
        registerHide.style.display = 'none';
        registerPswd.setAttribute('type', 'password');
        pswdConfirm.setAttribute('type', 'password');
        
        loginShow.style.display = 'inline-flex';
        loginHide.style.display = 'none';
        loginPswd.setAttribute('type', 'password');
        
        registerHide.addEventListener('click', function () {
            hideElement(registerHide);
            registerShow.style.display = 'inline-flex';
            showPassword(registerPswd);
            showPassword(pswdConfirm);
        })

        registerShow.addEventListener('click', function () {
            hideElement(registerShow);
            registerHide.style.display = 'inline-flex';
            hidePassword(registerPswd);
            hidePassword(pswdConfirm);
        })

        loginShow.addEventListener('click', function () {
            hideElement(loginShow);
            loginHide.style.display = 'inline-flex';
            showPassword(loginPswd);
        })

        loginHide.addEventListener('click', function () {
            hideElement(loginHide);
            loginShow.style.display = 'inline-flex';
            hidePassword(loginPswd);
        })
    }
}