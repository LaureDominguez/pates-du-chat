// ********************* show/hide modal
export function checkErrors() {

    const registerForm = document.querySelector('#register-form');
    registerForm.addEventListener("submit", handleSubmit);

    function handleSubmit(e) {
        e.preventDefault();

        const data = new FormData(registerForm);
        const errorMail = document.getElementById('error_new_mail')
        const errorPswd = document.getElementById('error_new_pswd')
        const errorChk = document.getElementById('error_new_verif')

        if (data.get('email').length === 0) {
            errorMail.innerHTML = 'entrer un email';
        };
        if (data.get('pswd').length === 0) {
            errorPswd.innerHTML = 'entrer un mot de passe';
        };
        if (data.get('pswd').length > 8 && data.get('pswd_confirm').length === 0) {
            error_new_verif.innerHTML = 'confirmer le mot de passe';
        };







// let email = data.get('email');
//         switch (email.length) {
//             case 0:
//                 errorMail.innerHTML = 'entrer une adresse email';
//                 break;
//             case 1,8:
//                 errorMail.innerHTML = 'entrer une adresse email';
//                 break;
//             default:
//                 errorMail.innerHTML = 'email inconnu';
//         }

        // for (let entry of data) {
        //     console.log(entry);
        //     if (entry[1] <= 2) {
        //         console.log('renseigner le champs');
        //     }
        // }

        // const mail = document.getElementById('email_new')
        // const errorMail = document.getElementById('error_new_mail')
        // const pswd = document.getElementById('pswd_new')
        // const errorPswd = document.getElementById('error_new_pswd')
        // const chkPswd = document.getElementById('pswd_confirm_new')
        // const errorChk = document.getElementById('error_new_verif')

        // console.log(mail);
        // console.log(data.get('email'));
    }





    // const mail = document.getElementById('email_new')
    // const errorMail = document.getElementById('error_new_mail')
    // const pswd = document.getElementById('pswd_new')
    // const errorPswd = document.getElementById('error_new_pswd')
    // const chkPswd = document.getElementById('pswd_confirm_new')
    // const errorChk = document.getElementById('error_new_verif')

    // const data = new FormData(form);

    // fetch('./views/users/login.phtml', { method: 'GET' })
    //     .then((response) => response.FormData())
    //     .then((FormData) => {
    //     for (let entry of data) {
    //         console.log(entry);
    //     }
    // })

    // form.addEventListener("submit", () => {
    //     let error = {}
    //     if (data.length === 0) {
    //         error.email = "Veuillez entrer une adresse mail"
    //         e.preventDefault()
    //     }
    // })
}