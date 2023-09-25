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
                case !/[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?\s]/.test(pswd):
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
    const reset = document.getElementById('forgot');
    const submit = document.getElementById('validate-log');
    const emailInput = document.getElementById('email_log');
    const errorMail = document.getElementById('error_log_mail');
    const errorPswd = document.getElementById('error_log_pswd');

    if (loginForm) {

        reset.addEventListener('click', function () {
            const email = emailInput.value.trim();

            console.log("prout");
            console.log(email);
            if (validateEmail(email)) {
                console.log("shprout");
            }
        });

        submit.addEventListener('click', function () {
            console.log("pouet")

            loginForm.addEventListener("submit", handleSubmitLogin);

            async function handleSubmitLogin(e) {
                e.preventDefault(); //bloque l'envoi du formulaire

                const logData = new FormData(loginForm);
                const email = logData.get('email');
                const pswd = logData.get('pswd');

                // Réinitialiser les messages d'erreur
                errorMail.textContent = '';
                errorPswd.textContent = '';

                // Test email
                // validateEmail(email);

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
                if (validateEmail(email) && pswdIsValid) {
                    loginForm.submit();
                }
            }
        })
        function validateEmail(email) {
            // const email = emailInput.value.trim();

            // Réinitialiser les messages d'erreur
            errorMail.style.display = 'none'
            errorMail.textContent = '';
            // errorPswd.style.display = 'block'
            // errorPswd.textContent = '';

            // Valider l'e-mail
            // let emailIsValid = false;
            if (!email) {
                errorMail.style.display = 'block'
                errorMail.textContent = 'Entrer une adresse e-mail';
                return false;
            } else if (!isValidEmail(email)) {
                errorMail.style.display = 'block'
                errorMail.textContent = 'Entrer une adresse e-mail valide';
                return false;
            } else {
                return true;
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
