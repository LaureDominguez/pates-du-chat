// ********************* show/hide login/regiter modal and password

export function toogleModal() {

    function showElementFlex(element) {
        element.style.display = 'flex';
    }
    function showElementInline(element) {
        element.style.display = 'inline-flex';
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
    const divLog = document.getElementById('error_log_mail');
    const promptRegister = document.getElementById('errorR');
    const divReg = document.getElementById('error_new_mail');


    // prompt modale with php error
    if (promptLogin || promptRegister) {
        if (mediaQuery.matches) {
            hideElement(menuMobile);
            hideElement(burger);
            logWindow.classList.add('bg-animed');
        } else {
            showElementFlex(modal);
        }
        
        if (promptLogin) {
            showElementFlex(logWindow);
        } else if (promptRegister) {
            showElementFlex(registerWindow);
        }
    } 

    if (promptLogin) {
        showElementFlex(divLog);
    }

    if (promptRegister) {
        showElementFlex(divReg);
    }

/////////////////////////////////

    if (logWindow || registerWindow) {
        // display login form from large screen
        document.getElementById('login').addEventListener('click', function () {
            showElementFlex(modal);
            showElementFlex(logWindow);
        })

        // display login form from mobile
        document.getElementById('login-mobile').addEventListener('click', function () {
            hideElement(menuMobile);
            hideElement(burger);
            showElementFlex(logWindow);
            logWindow.classList.add('bg-animed');
        })

        // switch to register form
        document.getElementById('register').addEventListener('click', function () {
            if (mediaQuery.matches) {
                hideElement(menuMobile);
                showElementFlex(registerWindow);
                registerWindow.classList.add('bg-animed');
            } else {
                showElementFlex(registerWindow);
                hideElement(logWindow);
            }
        })

        // switch to login form
        document.getElementById('connexion').addEventListener('click', function () {
            if (mediaQuery.matches) {
                hideElement(registerWindow);
                showElementFlex(logWindow);
            } else {
                showElementFlex(modal);
                hideElement(registerWindow);
                showElementFlex(logWindow);
            }
        })

        //close login form
        document.getElementById('close-log').addEventListener('click', function () {
            if (mediaQuery.matches) {
                hideElement(registerWindow);
                hideElement(logWindow);
                showElementFlex(burger);
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
                showElementFlex(burger);
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
        const pswdConfirmShow = document.getElementById('confirm-register-show')
        const pswdConfirmHide = document.getElementById('confirm-register-hide')
        const pswdConfirm = document.getElementById('pswd_confirm_new')

        // login form
        const loginShow = document.getElementById('login-show')
        const loginHide = document.getElementById('login-hide')
        const loginPswd = document.getElementById('pswd_log');

        // set display at load
        showElementInline(loginShow);
        hideElement(loginHide);
        loginPswd.setAttribute('type', 'password');

        showElementInline(registerShow);
        showElementInline(pswdConfirmShow);
        hideElement(registerHide);
        hideElement(pswdConfirmHide);

        registerPswd.setAttribute('type', 'password');
        pswdConfirm.setAttribute('type', 'password');

        // toogle on register form
        registerShow.addEventListener('click', function () {
            hideElement(registerShow);
            hideElement(pswdConfirmShow);
            showElementInline(registerHide);
            showElementInline(pswdConfirmHide);
            showPassword(registerPswd);
            showPassword(pswdConfirm);
        })

        pswdConfirmShow.addEventListener('click', function () {
            hideElement(registerShow);
            hideElement(pswdConfirmShow);
            showElementInline(registerHide);
            showElementInline(pswdConfirmHide);
            showPassword(registerPswd);
            showPassword(pswdConfirm);
        })
        
        registerHide.addEventListener('click', function () {
            hideElement(registerHide);
            hideElement(pswdConfirmHide);
            showElementInline(registerShow);
            showElementInline(pswdConfirmShow);
            hidePassword(registerPswd);
            hidePassword(pswdConfirm);
        })

        pswdConfirmHide.addEventListener('click', function () {
            hideElement(registerHide);
            hideElement(pswdConfirmHide);
            showElementInline(registerShow);
            showElementInline(pswdConfirmShow);
            hidePassword(registerPswd);
            hidePassword(pswdConfirm);
        })

        // toogle on login form
        loginShow.addEventListener('click', function () {
            hideElement(loginShow);
            showElementInline(loginHide);
            showPassword(loginPswd);
        })

        loginHide.addEventListener('click', function () {
            hideElement(loginHide);
            showElementInline(loginShow);
            hidePassword(loginPswd);
        })
    }


    
}