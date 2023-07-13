// ********************* show/hide modal
export function checkErrors() {

    // register form
    const registerForm = document.querySelector('#register-form');
    registerForm.addEventListener("submit", handleSubmitRegister);

    function handleSubmitRegister(e) {
        e.preventDefault(); //bloque l'envoi du formulaire

        const data = new FormData(registerForm);
        const errorMail = document.getElementById('error_new_mail')
        const errorPswd = document.getElementById('error_new_pswd')
        const errorChk = document.getElementById('error_new_verif')

        if (data.get('email').length === 0) {
            errorMail.innerHTML = 'entrer une adresse email';
        } else {
            errorMail.style.display = 'none';
        };
        if (data.get('pswd').length === 0) {
            errorPswd.innerHTML = 'entrer un mot de passe';
        } else {
            errorPswd.style.display = 'none';
        };
        if (data.get('pswd').length > 1 && data.get('pswd_confirm').length === 0) {
            error_new_verif.innerHTML = 'confirmer le mot de passe';
        } else {
            error_new_verif.style.display = 'none';
        };

        // data.get('pswd').setAttribute('type') === 'password';
        // data.get('pswd_confirm').setAttribute('type') === 'password';
    }



    // login form
    const loginForm = document.querySelector('#login-form');
    loginForm.addEventListener("submit", handleSubmitLogin);

    function handleSubmitLogin(e) {
        e.preventDefault(); //bloque l'envoi du formulaire

        const data = new FormData(loginForm);
        const errorMail = document.getElementById('error_log_mail')
        const errorPswd = document.getElementById('error_log_pswd')

        if (data.get('email').length === 0) {
            errorMail.innerHTML = 'entrer votre adresse email';
        } else {
            errorMail.style.display = 'none';
        };
        if (data.get('pswd').length === 0) {
            errorPswd.innerHTML = 'entrer votre mot de passe';
        } else {
            errorPswd.style.display = 'none';
        };
        
        // data.get('pswd').setAttribute('type') === 'password';
    }



    // toggle show / hide password
    // register form
    const registerShow = document.getElementById('register-show')
    const registerHide = document.getElementById('register-hide')
    const registerPswd = document.getElementById('pswd_new');
    const pswdConfirm = document.getElementById('pswd_confirm_new')
    
    // login form
    const loginShow = document.getElementById('login-show')
    const loginHide = document.getElementById('login-hide')
    const loginPswd = document.getElementById('pswd_log');


    window.addEventListener('click', function (e) {
        switch (e.target.id) {
            case "register-show":
                registerShow.style.display = 'none';
                registerHide.style.display = 'inline-flex';
                registerPswd.setAttribute('type', 'text');
                pswdConfirm.setAttribute('type', 'text');
                break;
            case "register-hide":
                registerShow.style.display = 'inline-flex';
                registerHide.style.display = 'none';
                registerPswd.setAttribute('type', 'password');
                pswdConfirm.setAttribute('type', 'password');
                break;
            case "login-show":
                loginShow.style.display = 'none';
                loginHide.style.display = 'inline-flex';
                loginPswd.setAttribute('type', 'text');
                break;
            case "login-hide":
                loginShow.style.display = 'inline-flex';
                loginHide.style.display = 'none';
                loginPswd.setAttribute('type', 'password');
                break;
        }
        });





    // const mail = document.getElementById('email_new')
    // const errorMail = document.getElementById('error_new_mail')
    // const pswd = document.getElementById('pswd_new')
    // const errorPswd = document.getElementById('error_new_pswd')
    // const chkPswd = document.getElementById('pswd_confirm_new')
    // const errorChk = document.getElementById('error_new_verif')

    // const data = new FormData(form);

    // fetch('./views/users/login.phtml', { method: 'GET' })
    //     .then((response) => response.FormData())
    //     .then((FormData) => {
    //     for (let entry of data) {
    //         console.log(entry);
    //     }
    // })

    // form.addEventListener("submit", () => {
    //     let error = {}
    //     if (data.length === 0) {
    //         error.email = "Veuillez entrer une adresse mail"
    //         e.preventDefault()
    //     }
    // })
}