// ********************* show/hide modal
export function toogleModal() {
        
    let loggin = document.getElementById('loggin');
    let logWindow = document.getElementById('log_window');
    let errorLogMail = document.getElementById('error_log_mail');
    let errorLogPswd = document.getElementById('error_log_pswd');

    let register = document.getElementById('register');
    let registerWindow = document.getElementById('register-window');
    let errorNewMail = document.getElementById('error_new_mail');
    let errorNewPswd = document.getElementById('error_new_pswd');
    let errorNewVerif = document.getElementById('error_new_verif');

    let modal = document.getElementById('modal');
    
    let clearMsg = "index.php?route=clearMsg"


    let closeLog = document.getElementById('close-log');
    let validateLog = document.getElementById('validate-log');
    let newAccount = document.getElementById('new-account');

    let closeRegister = document.getElementById('close-register');
    let validateRegister = document.getElementById('validate-register')
    let cancelRegister = document.getElementById('cancel');


    if(errorLogMail || errorLogPswd !== null) {
            modal.style.display = 'block';
            logWindow.style.display = 'block';
    }
    
    if(errorNewMail || errorNewPswd || errorNewVerif !== null) {
            modal.style.display = 'block';
            registerWindow.style.display = 'block';
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
                window.location.href = "index.php?route=clearMsg";
                break;
            
            case "close-log":
                modal.style.display = 'none';
                logWindow.style.display = 'none';
                window.location.href = "index.php?route=clearMsg";
                break;
            
            case "register":
                modal.style.display = 'block';
                registerWindow.style.display = 'block';
                break;
            
            case "cancel":
                registerWindow.style.display = 'none';
                logWindow.style.display = 'block';
                window.location.href = "index.php?route=clearMsg";
                break;
            
            case "close-register":
                modal.style.display = 'none';
                registerWindow.style.display = 'none';
                window.location.href = "index.php?route=clearMsg";
                break;
            
            case "modal":
                modal.style.display = 'none';
                registerWindow.style.display = 'none';
                window.location.href = "index.php?route=clearMsg";
                break;
        }
    })
}