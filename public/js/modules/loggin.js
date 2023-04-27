// ********************* show/hide modal
export function toogleModal() {
        
    let loggin = document.getElementById('loggin');
    let logWindow = document.getElementById('log-window');

    let register = document.getElementById('register');
    let registerWindow = document.getElementById('register-window');

    let modal = document.getElementById('modal');
    let errorLog = document.getElementById('error-log');

    let closeLog = document.getElementById('close-log');
    let validateLog = document.getElementById('validate-log');
    let newAccount = document.getElementById('new-account');

    let closeRegister = document.getElementById('close-register');
    let validateRegister = document.getElementById('validate-register')
    let cancelRegister = document.getElementById('cancel');


    if(errorLog !== null) {
            modal.style.display = 'block';
            logWindow.style.display = 'block';
        }

    window.addEventListener('click', function (e) {

        switch (e.target.id) {
            case "loggin":
                modal.style.display = 'block';
                logWindow.style.display = 'block';
                break;
            
            case "new-account":
                logWindow.style.display = "none";
                registerWindow.style.display = "block";
                break;
            
            case "close-log":
                modal.style.display = 'none';
                logWindow.style.display = 'none';
                break;
            
            case "register":
                modal.style.display = 'block';
                registerWindow.style.display = 'block';
                break;
            
            case "cancel":
                registerWindow.style.display = 'none';
                logWindow.style.display = 'block';
                break;
            
            case "close-register":
                modal.style.display = 'none';
                registerWindow.style.display = 'none';
                break;
            
            case "modal":
                modal.style.display = 'none';
                registerWindow.style.display = 'none';
                break;
            
            // default:
            //     modal.style.display = 'none';
            //     logWindow.style.display = 'none';
            //     registerWindow.style.display = "none";
        }
    })
}