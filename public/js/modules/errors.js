// ********************* show/hide modal

export function checkErrors() {

    // register form ///////////////////

    const registerForm = document.querySelector('#register-form');
    registerForm.addEventListener("submit", handleSubmitRegister);

    function handleSubmitRegister(e) {
        e.preventDefault(); //bloque l'envoi du formulaire

        const newData = new FormData(registerForm);
        const email = newData.get('email');
        const pswd = newData.get('pswd');
        const pswd_confirm = newData.get('pswd_confirm');
        const errorMail = document.getElementById('error_new_mail')
        const errorPswd = document.getElementById('error_new_pswd')
        const errorChk = document.getElementById('error_new_verif')
        let errors = false;

        if (!email) {
            errorMail.innerHTML = 'entrer une adresse email';
            errors = true;
            return;
        }
        if (!isValidEmail(email)) {
            errorMail.innerHTML = 'entrer une adresse email valide';
            errors = true;
            return;
        }
        errorMail.style.display = 'none';


        if (!pswd) {
            errorPswd.innerHTML = 'entrer un mot de passe';
            errors = true;
            return;
        }
        errorPswd.style.display = 'none';

        if (pswd.length > 1 && !pswd_confirm) {
            error_new_verif.innerHTML = 'confirmer le mot de passe';
            errors = true;
            return;
        }
        error_new_verif.style.display = 'none';


        // console.error(error);
        console.log('renvois les erreurs ?')
        if (errors == false) {
            console.log('squalala');
            fetchData(newData);
            return;
        }

        // if ("pas d'errreurs") {
        //     registerForm.submit();
        // }
    }

////////////////////////////////////////////////////////////////////

    // login form

    const loginForm = document.querySelector('#login-form');
    loginForm.addEventListener("submit", handleSubmitLogin);

    function handleSubmitLogin(e) {
        e.preventDefault(); //bloque l'envoi du formulaire

        const logData = new FormData(loginForm);
        const errorMail = document.getElementById('error_log_mail')
        const errorPswd = document.getElementById('error_log_pswd')
        const email = logData.get('email');
        let errors = false;

        if (!email) {
            errorMail.innerHTML = 'entrer une adresse email';
            errors = true;
            return;
        }
        if (!isValidEmail(email)) {
            errorMail.innerHTML = 'entrer une adresse email valide';
            errors = true;
            return;
        }
        errorMail.style.display = 'none'

        console.log(errors);

        if (!logData.get('pswd')) {
            errorPswd.innerHTML = 'entrer votre mot de passe';
            errors = true;
            return;
        }
        errorPswd.style.display = 'none';

        if (errors === false) {
            console.log('nous sommes partis');
            fetchData(logData);
            return;
        }
        
        // if ("pas d'errreurs") {
        //     loginForm.submit();
        // }
    }



    // button toggle show/hide password :
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

function isValidEmail(email) {
  // Expression régulière pour valider le format d'une adresse e-mail
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return emailRegex.test(email);
}

// Fonction pour crypter le mot de passe côté client
function encryptPassword(password) {
    const encoder = new TextEncoder();
    const data = encoder.encode(password);
    return window.crypto.subtle.digest('SHA-256', data).then(buffer => {
        const hexCodes = [];
        const view = new DataView(buffer);
        for (let i = 0; i < view.byteLength; i += 4) {
        const value = view.getUint32(i);
        const stringValue = value.toString(16);
        const padding = '00000000';
        const paddedValue = (padding + stringValue).slice(-padding.length);
        hexCodes.push(paddedValue);
        }
        return hexCodes.join('');
    });
}

//     // Exemple d'utilisation :
//     const password = 'mon_mot_de_passe';
//     encryptPassword(password).then(encryptedPassword => {
//     // Utilisez l'encryptedPassword pour l'envoyer au serveur avec fetch.
//     // Par exemple :
//     fetch('votre_script_de_verification.php', {
//         method: 'POST',
//         body: JSON.stringify({ password: encryptedPassword }),
//         headers: {
//         'Content-Type': 'application/json'
//         }
//     }).then(response => {
//         // Gérer la réponse du serveur ici.
//     }).catch(error => {
//         console.error('Erreur lors de l\'envoi du mot de passe :', error);
//     });
// });

function fetchData(data) {
    const jsonData = JSON.stringify(Object.fromEntries(data))
    // console.log(jsonData);

    fetch('./config/ajax.php', {
        method: 'POST',
        body: jsonData
    })
        .then(response => {
    if (!response.ok) {
        throw new Error('Erreur de requête : ' + response.status);
        }
        return response.text();
    })
    .then(errors => {
        // Traitez les données de réponse ici
        if (errors.length > 0) {
            console.log('liste des erreurs register :')
            console.log(errors);
            console.log('fin de liste');
        }
        else {
            console.log('ca passe');
            // window.location.href = 'index.php?route=connect';
            loginForm.submit();
        }
        console.log("pouet 1");
        
    })
    .catch(error => {
        // Traitez les erreurs de la requête Fetch
        console.error('Erreur de requête Fetch :', error);
    });
}

