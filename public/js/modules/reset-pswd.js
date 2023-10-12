// ********************* test errors on reset function
export function resetPswd() {

    const resetPswd = document.getElementById('resetPswd');

    if (resetPswd) {
        // envoie un mail pour reset pswd
        resetPswd.addEventListener('click', function () {
            console.log("pouet");

            fetch('index.php?route=resetFetch', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(result => {
                console.log(result);

                // affiche success ou error dans une div
                const addDiv = document.createElement('div');
                const msg = document.createElement('p');
                if (result.success) {
                    addDiv.classList.add('success');
                    msg.textContent = result.message;
                    addDiv.appendChild(msg);
                    addDiv.style.display = "flex";
                } else {
                    addDiv.classList.add('error');
                    msg.textContent = result.message;
                    addDiv.appendChild(msg);
                    addDiv.style.display = "flex";
                }

                document.body.appendChild(addDiv);
            })
            .catch(error => {
                console.error('Erreur lors de la requête Fetch:', error);
            });
        });
    }
    //////////////////////////////////////////////////

    // Reset form
    const resetForm = document.querySelector('#reset-form');

    if (resetForm) {
        //////////////////////////////////////////////////
        // Show / hide password on reset form
        function showElementInline(element) {
            element.style.display = 'inline-flex';
        }
        function hideElement(element) {
            element.style.display = 'none';
        }
        function showPassword(password) {
            password.setAttribute('type', 'text');
        }
        function hidePassword(password) {
            password.setAttribute('type', 'password');
        }
        
        const resetShow = document.getElementById('rst-show')
        const resetHide = document.getElementById('rst-hide')
        const resetPswdInput = document.getElementById('pswd_rst');

        const pswdConfirmShow = document.getElementById('confirm-rst-show')
        const pswdConfirmHide = document.getElementById('confirm-rst-hide')
        const resetPswdConfirmInput = document.getElementById('pswd_confirm_rst')

        // set display at load
        showElementInline(resetShow);
        showElementInline(pswdConfirmShow);

        hideElement(resetHide);
        hideElement(pswdConfirmHide);

        resetPswdInput.setAttribute('type', 'password');
        resetPswdConfirmInput.setAttribute('type', 'password');

        // toogle on register form
        resetShow.addEventListener('click', function () {
            hideElement(resetShow);
            hideElement(pswdConfirmShow);
            showElementInline(resetHide);
            showElementInline(pswdConfirmHide);
            showPassword(resetPswdInput);
            showPassword(resetPswdConfirmInput);
        })

        pswdConfirmShow.addEventListener('click', function () {
            hideElement(resetShow);
            hideElement(pswdConfirmShow);
            showElementInline(resetHide);
            showElementInline(pswdConfirmHide);
            showPassword(resetPswdInput);
            showPassword(resetPswdConfirmInput);
        })
        
        resetHide.addEventListener('click', function () {
            hideElement(resetHide);
            hideElement(pswdConfirmHide);
            showElementInline(resetShow);
            showElementInline(pswdConfirmShow);
            hidePassword(resetPswdInput);
            hidePassword(resetPswdConfirmInput);
        })

        pswdConfirmHide.addEventListener('click', function () {
            hideElement(resetHide);
            hideElement(pswdConfirmHide);
            showElementInline(resetShow);
            showElementInline(pswdConfirmShow);
            hidePassword(resetPswdInput);
            hidePassword(resetPswdConfirmInput);
        })
        //////////////////////////////////////////////////

        // test and submit for reset form
        resetForm.addEventListener("submit", handleSubmitReset);

        async function handleSubmitReset(e) {
            e.preventDefault();

            const newData = new FormData(resetForm);
            const pswd = newData.get('pswd_rst');
            const confirmPswd = newData.get('pswd_confirm_rst')
            const errorPswd = document.getElementById('error_rst');
            const errorConfirm = document.getElementById('error_rst_verif');

            let errorFound = false;

            // Tests
            const numberMinimal = 8;
            let errorMsgPswd = '';

            if (!pswd) {
                errorPswd.style.display = 'block';
                errorPswd.innerHTML = 'entrer un mot de passe';
                errorFound = true;
            } else {
                errorPswd.style.display = 'none';
                
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
            }

            // Affiche les erreurs si besoin
            if (errorMsgPswd) {
                errorPswd.style.display = 'block';
                errorPswd.innerHTML = errorMsgPswd;
            }
            
            if (pswd.length > 1 && !confirmPswd) {
                errorConfirm.style.display = 'block';
                errorConfirm.innerHTML = 'confirmer le mot de passe';
                errorFound = true;
            } else if (pswd !== confirmPswd) {
                errorConfirm.style.display = 'block';
                errorConfirm.innerHTML = "Les mots de passe ne correspondent pas";
                errorFound = true;
            } else {
                errorConfirm.style.display = 'none';
            }

            // Sinon envoi le form
            if (!errorFound) {
                console.log("c'est gagné");
                // resetForm.submit();
            }
        }
    }

}