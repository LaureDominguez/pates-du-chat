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
    })

    // switch to register form
    document.getElementById('register').addEventListener('click', function () {
        if (mediaQuery.matches) {
            hideElement(menuMobile);
            showElement(registerWindow);
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
            hideElement(logWindow);
        } else {
            hideElement(modal);
            hideElement(logWindow);
        }
    })

   //close login form
    document.getElementById('close-register').addEventListener('click', function () {
        if (mediaQuery.matches) {
            hideElement(registerWindow)
            showElement(burger);
        } else {
            hideElement(modal);
            hideElement(registerWindow)
        }
    })

     //close both forms
    modal.addEventListener('click', function (e) {
        if (mediaQuery.matches) {
            hideElement(registerWindow)
            hideElement(logWindow);
            showElement(burger);
        } else {
            hideElement(modal);
            hideElement(logWindow);
            hideElement(registerWindow);
        }
    })

    logWindow.addEventListener('click', function (e) {
        e.stopPropagation();
    });

    registerWindow.addEventListener('click', function (e) {
        e.stopPropagation();
    });

    modal.addEventListener('click', function (e) {
        e.stopPropagation();
    });

}