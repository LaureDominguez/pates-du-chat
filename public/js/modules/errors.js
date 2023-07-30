// ********************* test errors on login/register modal
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
                console.log(errorFound);
                return;
            }
            errorPswd.style.display = 'none';

            // Sinon envoi le form
            if (errorFound === false) {
                console.log('ca passe');
                registerForm.submit();
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
            const email = logData.get('email');
            const pswd = logData.get('pswd');
            const errorMail = document.getElementById('error_log_mail')
            const errorPswd = document.getElementById('error_log_pswd')

            console.log(email);
            console.log(pswd);

            // Test email
            let emailIsValid = false;
            if (!email) {
                errorMail.style.display = 'block'
                errorMail.innerHTML = 'entrer une adresse email';
            } else if (!isValidEmail(email)) {
                errorMail.style.display = 'block'
                errorMail.innerHTML = 'entrer une adresse email valide';
            } else {
                emailIsValid = true;
                errorMail.style.display = 'none'
            }

            // Test pswd
            let pswdIsValid = false;
            if (!pswd) {
                errorPswd.style.display = 'block';
                errorPswd.innerHTML = 'entrer votre mot de passe';
            } else {
                pswdIsValid = true;
                errorPswd.style.display = 'none';
            }

            // Si ok, on envoi le form
            if (emailIsValid && pswdIsValid) {
                loginForm.submit();
            }
        }
    }
}

///////////// check email validation ////////

function isValidEmail(email) {
  // Expression régulière pour valider le format d'une adresse e-mail
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return emailRegex.test(email);
}
