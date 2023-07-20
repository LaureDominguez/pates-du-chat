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
            errorMail.style.display = 'block';
            errorMail.innerHTML = 'entrer une adresse email';
            errors = true;
            return;
        }
        errorMail.style.display = 'none';

        if (!isValidEmail(email)) {
            errorMail.style.display = 'block';
            errorMail.innerHTML = 'entrer une adresse email valide';
            errors = true;
            return;
        }
        errorMail.style.display = 'none';


        if (!pswd) {
            errorPswd.style.display = 'block';
            errorPswd.innerHTML = 'entrer un mot de passe';
            errors = true;
            return;
        }
        errorPswd.style.display = 'none';

        if (pswd.length > 1 && !pswd_confirm) {
            error_new_verif.style.display = 'block';
            error_new_verif.innerHTML = 'confirmer le mot de passe';
            errors = true;
            return;
        }
        error_new_verif.style.display = 'none';


        if (errors === false) {
            fetchData(newData)
                // .then(response => {
                //     if (!response.ok) {
                //         throw new Error('Erreur de requête : ' + response.status);
                //     }
                //     console.log(response.status);
                //     return response.json(); // Analyser les données JSON renvoyées par le serveur
                // })
                // .then(data => {
                //     console.log(data);
                //     const parsedData = JSON.parse(data);
                //     console.log(parsedData);
                    
                //     // Traitez les erreurs ici
                //     if (parsedData.mail) {
                //         console.log("pouet 1");
                //         errorMail.style.display = 'block'
                //         errorMail.innerHTML = parsedData.mail;
                //         return;
                //     }
                //     errorMail.style.display = 'none'

                //     if (parsedData.pswd) {
                //         console.log("pouet 2");
                //         errorPswd.style.display = 'block'
                //         errorPswd.innerHTML = parsedData.pswd;
                //         return;
                //     }
                //     errorPswd.style.display = 'none'

                //     if (parsedData.pswd_confirm) {
                //         console.log("pouet 3");
                //         error_new_verif.style.display = 'block'
                //         error_new_verif.innerHTML = parsedData.pswd_confirm;
                //         return;
                //     }
                //     error_new_verif.style.display = 'none'

                //     // Si pas d'erreur, alors on envoi le formlaire
                //     registerForm.submit();
                // })
                .then(data => {
                // Traitez les erreurs ici
                if (data.mail) {
                    errorMail.style.display = 'block';
                    errorMail.innerHTML = data.mail;
                } else if (data.pswd) {
                    errorPswd.style.display = 'block';
                    errorPswd.innerHTML = data.pswd;
                } else if (data.pswd_confirm) {
                    error_new_verif.style.display = 'block';
                    error_new_verif.innerHTML = data.pswd_confirm;
                } else {
                    // Si pas d'erreur, alors on envoie le formulaire
                    registerForm.submit();
                }
            })
                .catch(error => {
                    console.error('Erreur lors de la requête POST', error);
                });
            return;
        }
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
            errorMail.style.display = 'block'
            errorMail.innerHTML = 'entrer une adresse email';
            errors = true;
            return;
        }
        if (!isValidEmail(email)) {
            errorMail.style.display = 'block'
            errorMail.innerHTML = 'entrer une adresse email valide';
            errors = true;
            return;
        }
        errorMail.style.display = 'none'

        if (!logData.get('pswd')) {
            errorPswd.style.display = 'block'
            errorPswd.innerHTML = data;
            // errorPswd.innerHTML = 'entrer votre mot de passe';
            errors = true;
            return;
        }
        errorPswd.style.display = 'none';

        if (errors === false) {
            fetchData(logData)
                // .then(response => {
                //     if (!response.ok) {
                //         throw new Error('Erreur de requête : ' + response.status);
                //     }
                //     console.log(response);
                //     return response.json(); // Analyser les données JSON renvoyées par le serveur
                // })
                // .then(data => {
                //     // Traitez les erreurs ici
                //     console.log(data);
                //     if (data.error) {
                //         // const parsedData = JSON.parse(data);
                //         // console.log(parsedData);
                //         errorMail.style.display = 'block'
                //         errorMail.innerHTML = data.error;
                //     }
                // })
                .then(data => {
                    // Traitez les erreurs ici
                    if (data.pswd) {
                        errorMail.style.display = 'block';
                        errorMail.innerHTML = data.pswd;
                    } else {
                        // Aucune erreur, vous pouvez envoyer le formulaire de connexion ici
                        loginForm.submit();
                    }
                })
                .catch(error => {
                console.error('Erreur lors de la requête POST', error);
                });
            return;
        }
        
        // if ("pas d'errreurs") {
        //     loginForm.submit();
        // }
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

