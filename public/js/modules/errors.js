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
        // if ("pas d'errreurs") {
        //     loginForm.submit();
        // }
    }

////////////////////////////////////////////////////////////////////

    // login form

    const loginForm = document.querySelector('#login-form');
    loginForm.addEventListener("submit", handleSubmitLogin);

    function handleSubmitLogin(e) {
        e.preventDefault(); //bloque l'envoi du formulaire

        const formData = new FormData(loginForm);
        const errorMail = document.getElementById('error_log_mail')
        const errorPswd = document.getElementById('error_log_pswd')

        if (!formData.get('email')) {
            return errorMail.innerHTML = 'entrer votre adresse email';
        } else {
            errorMail.style.display = 'none';
        };
        if (!formData.get('pswd')) {
            return errorPswd.innerHTML = 'entrer votre mot de passe';
        } else {
            errorPswd.style.display = 'none';
        };
        
        const jsonData = JSON.stringify(Object.fromEntries(formData))
        console.log(jsonData);

    // Envoyez la requête POST au fichier PHP
    fetch('./controllers/UsersController.php', {
        method: 'POST',
        body: jsonData
    })
    .then(response => response.text())
    .then(errors => {
        // Traitez les erreurs renvoyées
        if (Object.keys(errors).length > 0) {
        // Affichez les erreurs à l'utilisateur
        for (let field in errors) {
            // Exemple : Afficher les erreurs à côté des champs correspondants
            console.log('ya des erreurs');
            // const errorContainer = document.getElementById(`${field}-error`);
            // errorContainer.textContent = errors[field];
            console.log(field)
        }
        } else {
        // Les données du formulaire sont valides, effectuez l'action souhaitée
        // Exemple : Redirigez l'utilisateur vers une autre page
        // window.location.href = 'succes.html';
            console.log('succès ?')
        }
    })
    .catch(error => {
        // Traitez les erreurs de la requête Fetch
        console.error('Erreur de requête Fetch :', error);
    });


        
        // data.get('pswd').setAttribute('type') === 'password';
        // if ("pas d'errreurs") {
        //     loginForm.submit();
        // }
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
}