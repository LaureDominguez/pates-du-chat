// ********************* show/hide modal

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


export function checkErrors() {

    // register form ///////////////////
    const registerForm = document.querySelector('#register-form');
    registerForm.addEventListener("submit", handleSubmitRegister);

    function handleSubmitRegister(e) {
        e.preventDefault(); //bloque l'envoi du formulaire

        const newData = new FormData(registerForm);
        const errorMail = document.getElementById('error_new_mail')
        const errorPswd = document.getElementById('error_new_pswd')
        const errorChk = document.getElementById('error_new_verif')
        const email = newData.get('email');
        const pswd = newData.get('pswd')

        if (!email) {
            errorMail.innerHTML = 'entrer une adresse email';
            return;
        }
        if (!isValidEmail(email)) {
            errorMail.innerHTML = 'entrer une adresse email valide';
            return;
        }
        errorMail.style.display = 'none';


        if (!newData.get('pswd')) {
            errorPswd.innerHTML = 'entrer un mot de passe';
        } else {
            errorPswd.style.display = 'none';
        };
        if (newData.get('pswd').length > 1 && !newData.get('pswd_confirm')) {
            error_new_verif.innerHTML = 'confirmer le mot de passe';
        } else {
            error_new_verif.style.display = 'none';
        };

        console.log('renvois les erreurs ?')
        
        
        
        const jsonData = JSON.stringify(Object.fromEntries(newData))
        console.log(jsonData);

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
            console.log('pas d\'erreur');
            // window.location.href = 'index.php?route=connect';
            loginForm.submit();
        }
        console.log("pouet 1");

        
    })
    .catch(error => {
        // Traitez les erreurs de la requête Fetch
        console.error('Erreur de requête Fetch :', error);
    });

        // newData.get('pswd').setAttribute('type') === 'password';
        // newData.get('pswd_confirm').setAttribute('type') === 'password';
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
    // fetch('./controllers/UsersController.php', {
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
            console.log('liste des erreurs loggin :')
            console.log(errors);
            console.log('fin de liste');
        }
        else {
            console.log('pas d\'erreur');
            // window.location.href = 'index.php?route=connect';
            loginForm.submit();
        }
        console.log("pouet2");

        
    })
    .catch(error => {
        // Traitez les erreurs de la requête Fetch
        console.error('Erreur de requête Fetch :', error);
    });
        
        
        // errorMail.innerHTML = data;
    // .then(response => response.blob())
    // .then(errors => {
    //     // Traitez les erreurs renvoyées
    //     console.log(Object);
    //     if (Object.keys(errors).length > 0) {
    //     // Affichez les erreurs à l'utilisateur
    //     for (let field in errors) {
    //         // Exemple : Afficher les erreurs à côté des champs correspondants
    //         console.log('ya des erreurs');
    //         // const errorContainer = document.getElementById(`${field}-error`);
    //         // errorContainer.textContent = errors[field];
    //         console.log(field)
    //     }
    //     } else {
    //     // Les données du formulaire sont valides, effectuez l'action souhaitée
    //     // Exemple : Redirigez l'utilisateur vers une autre page
    //     // window.location.href = 'succes.html';
    //         console.log('succès ?')
    //     }
    // })
    // .catch(error => {
    //     // Traitez les erreurs de la requête Fetch
    //     console.error('Erreur de requête Fetch :', error);
    // });


        
    //     data.get('pswd').setAttribute('type') === 'password';
    //     if ("pas d'errreurs") {
    //         loginForm.submit();
    //     }
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