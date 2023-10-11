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

                // cln error div
                // const errorDiv
            })
            .catch(error => {
                console.error('Erreur lors de la requête Fetch:', error);
            });
        });
    }

    //////////////////////////////////////////////////
    // Show / hide password
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

    if (resetPswdInput) {
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
    }

}