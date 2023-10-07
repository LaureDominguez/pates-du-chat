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

            //Tests supplémentaires du mot de passe
            const numberMinimal = 8;
            let errorMsgPswd = '';
            let errorMsgChk = '';

            switch (true) {
                case pswd.length < numberMinimal:
                    errorMsgPswd = `Le mot de passe doit contenir au minimum ${numberMinimal} caractères`;
                    errorFound = true;
                    break;
                case !/[A-Z]/.test(pswd):
                    errorMsgPswd = "Le mot de passe doit inclure au moins une lettre majuscule";
                    errorFound = true;
                    break;
                case !/[a-z]/.test(pswd):
                    errorMsgPswd = "Le mot de passe doit inclure au moins une lettre minuscule";
                    errorFound = true;
                    break;
                case !/\d/.test(pswd):
                    errorMsgPswd = "Le mot de passe doit inclure au moins un chiffre";
                    errorFound = true;
                    break;
                case !/[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?\s]/.test(pswd):
                    errorMsgPswd = "Le mot de passe doit inclure au moins un caractère spécial";
                    errorFound = true;
                    break;
            }

            // Affiche les erreurs si besoin
            if (errorFound) {
                if (errorMsgPswd) {
                    errorPswd.style.display = 'block';
                    errorPswd.innerHTML = errorMsgPswd;
                    return;
                } else if (errorMsgChk) {
                    errorChk.style.display = 'block';
                    errorChk.innerHTML = errorMsgChk;
                    return;
                }
            }

            if (pswd.length > 1 && !pswd_confirm) {
                errorChk.style.display = 'block';
                errorChk.innerHTML = 'confirmer le mot de passe';
                errorFound = true;
                return;
            } else if (pswd !== pswd_confirm) {
                errorChk.style.display = 'block';
                errorChk.innerHTML = "Les mots de passe ne correspondent pas";
                errorFound = true;
                return;
            } else {
                errorChk.style.display = 'none';
            }

            // Sinon envoi le form
            if (!errorFound) {
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
        // envoie un mail pour reset pswd
        reset.addEventListener('click', function () {
            const email = emailInput.value.trim();
            console.log("reset");

            if (validateEmail(email)) {
                const data = {
                    email: email
                };

                fetch('index.php?route=resetFetch', {
                    method: 'POST',
                    body: JSON.stringify(data), 
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(result => {
                    console.log(result);
                })
                .catch(error => {
                    console.error('Erreur lors de la requête Fetch:', error);
                });
            }
        });

        // envoi le form de loggin
        submit.addEventListener('click', function () {
            loginForm.addEventListener("submit", handleSubmitLogin);
            console.log("login");

            async function handleSubmitLogin(e) {
                e.preventDefault(); //bloque l'envoi du formulaire

                const logData = new FormData(loginForm);
                const email = logData.get('email');
                const pswd = logData.get('pswd');

                // Réinitialiser les messages d'erreur
                errorMail.textContent = '';
                errorPswd.textContent = '';

                // Test pswd
                let pswdIsValid = false;
                if (!pswd) {
                    errorPswd.style.display = 'block';
                    errorPswd.innerHTML = 'entrer votre mot de passe';
                } else {
                    pswdIsValid = true;
                    errorPswd.style.display = 'none';
                }

                // Test email & si ok, on envoi le form
                if (validateEmail(email) && pswdIsValid) {
                    loginForm.submit();
                }
            }
        })

        function validateEmail(email) {
            errorMail.style.display = 'none'
            errorMail.textContent = '';

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
