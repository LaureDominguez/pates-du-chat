// ********************* show/hide modal

export function checkErrors() {

/////////// register form ///////////////////
    const registerForm = document.querySelector('#register-form');
    if (registerForm) {
        registerForm.addEventListener("submit", handleSubmitRegister);

        async function handleSubmitRegister(e) {
            e.preventDefault(); //bloque l'envoi du formulaire

            const newData = new FormData(registerForm);
            const email = newData.get('email');
            const pswd = newData.get('pswd');
            const pswd_confirm = newData.get('pswd_confirm');
            const errorMail = document.getElementById('error_new_mail')
            const errorPswd = document.getElementById('error_new_pswd')
            const errorChk = document.getElementById('error_new_verif')
            let errorFound = false;


            // Tests
            if (!email) {
                errorMail.style.display = 'block';
                errorMail.innerHTML = 'entrer une adresse email';
                errorFound = true;
                return;
            }
            errorMail.style.display = 'none';

            if (!isValidEmail(email)) {
                errorMail.style.display = 'block';
                errorMail.innerHTML = 'entrer une adresse email valide';
                errorFound = true;
                return;
            }
            errorMail.style.display = 'none';

            if (!pswd) {
                errorPswd.style.display = 'block';
                errorPswd.innerHTML = 'entrer un mot de passe';
                errorFound = true;
                return;
            }

            if (pswd.length > 1 && !pswd_confirm) {
                error_new_verif.style.display = 'block';
                error_new_verif.innerHTML = 'confirmer le mot de passe';
                errorFound = true;
                return;
            }
            error_new_verif.style.display = 'none';

            //Tests supplémentaires du mot de passe
            const numberMinimal = 8;
            let errorMessage = '';

            switch (true) {
                case pswd.length < numberMinimal:
                    errorMessage = `Le mot de passe doit contenir au minimum ${numberMinimal} caractères`;
                    errorFound = true;
                    break;
                case !/[A-Z]/.test(pswd):
                    errorMessage = "Le mot de passe doit inclure au moins une lettre majuscule";
                    errorFound = true;
                    break;
                case !/[a-z]/.test(pswd):
                    errorMessage = "Le mot de passe doit inclure au moins une lettre minuscule";
                    errorFound = true;
                    break;
                case !/\d/.test(pswd):
                    errorMessage = "Le mot de passe doit inclure au moins un chiffre";
                    errorFound = true;
                    break;
                case !/\W/.test(pswd):
                    errorMessage = "Le mot de passe doit inclure au moins un caractère spécial";
                    errorFound = true;
                    break;
                case pswd !== pswd_confirm:
                    errorMessage = "Les mots de passe ne correspondent pas";
                    errorFound = true;
                    break;
            }

            // Affiche les erreurs si besoin
            if (errorFound) {
                errorPswd.style.display = 'block';
                errorPswd.innerHTML = errorMessage;
                return;
            }
            errorPswd.style.display = 'none';

            // Sinon envoi requête fetch pour vérifier la db
            if (errorFound === false) {
                try {
                    const hashedPassword = await encryptPassword(pswd);
                    console.log(hashedPassword);
                    newData.set('pswd', hashedPassword);
                    fetchData(newData)
                        .then(data => {
                            // Affiche les erreurs si besoin
                            console.log(data);
                            if (data.mail) {
                                errorMail.style.display = 'block';
                                errorMail.innerHTML = data.mail;
                            } else {
                                // Si pas d'erreur, alors on envoie le formulaire
                                registerForm.submit();
                            }
                        })
                    .catch(error => {
                            console.error('Erreur lors de la requête POST', error);
                        });
                } catch (error) {
                    console.error('Erreur lors du hachage du mot de passe', error);
                    }
                return;
            }
        }
    }

////////////////////////////////////////////////////////////////////

////////// login form //////////
    const loginForm = document.querySelector('#login-form');
    if (loginForm) {
        loginForm.addEventListener("submit", handleSubmitLogin);

        async function handleSubmitLogin(e) {
            e.preventDefault(); //bloque l'envoi du formulaire

            const logData = new FormData(loginForm);
            const errorMail = document.getElementById('error_log_mail')
            const errorPswd = document.getElementById('error_log_pswd')
            const email = logData.get('email');
            const pswd = logData.get('pswd');
            let errors = false;

            // Tests
            if (!email) {
                errorMail.style.display = 'block'
                errorMail.innerHTML = 'entrer une adresse email';
                errors = true;
            } else if (!isValidEmail(email)) {
                errorMail.style.display = 'block'
                errorMail.innerHTML = 'entrer une adresse email valide';
                errors = true;
            } else {
                errorMail.style.display = 'none'
            }

            if (!logData.get('pswd')) {
                errorPswd.style.display = 'block'
                errorPswd.innerHTML = data;
                errorPswd.innerHTML = 'entrer votre mot de passe';
                errors = true;
            } else {
                errorPswd.style.display = 'none';
            }

            // Sinon envoi requête fetch pour vérifier la db
            if (errors === false) {
                try {
                    const hashedPassword = await encryptPassword(pswd);
                    console.log(hashedPassword);
                    logData.set('pswd', hashedPassword);
                    fetchData(logData)
                        .then(data => {
                            // Affiche les erreurs si besoin
                            if (data.pswd) {
                                errorMail.style.display = 'block';
                                errorMail.innerHTML = data.pswd;
                            } else {
                                // Si pas d'erreur, alors on envoie le formulaire
                                loginForm.submit();
                            }
                        })
                        .catch(error => {
                            console.error('Erreur lors de la requête POST', error);
                        });
                    } catch (error) {
                        console.error('Erreur lors du hachage du mot de passe', error);
                    }
                return;
            }
        }
    }


///////////// button toggle show/hide password //////////////////
    // register form
    const registerShow = document.getElementById('register-show')
    const registerHide = document.getElementById('register-hide')
    const registerPswd = document.getElementById('pswd_new');
    const pswdConfirm = document.getElementById('pswd_confirm_new')

    // login form
    const loginShow = document.getElementById('login-show')
    const loginHide = document.getElementById('login-hide')
    const loginPswd = document.getElementById('pswd_log');


    // actions des bouttons
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
            default:
                registerShow.style.display = 'inline-flex';
                registerHide.style.display = 'none';
                registerPswd.setAttribute('type', 'password');
                pswdConfirm.setAttribute('type', 'password');
                
                loginShow.style.display = 'inline-flex';
                loginHide.style.display = 'none';
                loginPswd.setAttribute('type', 'password');
        }
    });

    // empêche les champs de repasser en masqué lorsqu'on tape le mot de passe
    if (registerPswd) {
        registerPswd.addEventListener('click', function (e) {
            e.stopPropagation();
        });
    }
    if (pswdConfirm) {
        pswdConfirm.addEventListener('click', function (e) {
            e.stopPropagation();
        });
    }
}

///////////// Différentes fonctions nécessaires aux formulaires ////////

function isValidEmail(email) {
  // Expression régulière pour valider le format d'une adresse e-mail
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return emailRegex.test(email);
}

// Fonction pour crypter le mot de passe côté client
async function encryptPassword(password) {
    const encoder = new TextEncoder();
    const data = encoder.encode(password);
    const hashBuffer = await window.crypto.subtle.digest('SHA-256', data);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    const hashedPassword = hashArray.map(byte => ('00' + byte.toString(16)).slice(-2)).join('');
    return hashedPassword;
}

function fetchData(data) {
    const jsonData = JSON.stringify(Object.fromEntries(data));
    // console.log(jsonData);

    return fetch('./config/ajax.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: jsonData,
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur de requête : ' + response.status);
        }
        return response.json();
    })
    .catch(error => {
        console.error('Erreur lors de la requête POST', error);
    });
}

