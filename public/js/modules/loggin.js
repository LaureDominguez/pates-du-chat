// ********************* show/hide modal
export function toogleModal() {
        
    let loggin = document.getElementById('loggin');
    let logWindow = document.getElementById('log-window');

    let register = document.getElementById('register');
    let registerWindow = document.getElementById('register-window');

    let modal = document.getElementById('modal');

    let closeLog = document.getElementById('close-log');
    let validateLog = document.getElementById('validate-log');
    let newAccount = document.getElementById('new-account');

    let closeRegister = document.getElementById('close-register');
    let validateRegister = document.getElementById('validate-register')
    let cancelRegister = document.getElementById('cancel');

    

    window.addEventListener('click', function (e) {

        console.log(e.clientX + " " + e.clientY) 
        console.log(e.target.id)
        switch (e.target.id) {
            case "loggin":
                modal.style.display = 'block';
                logWindow.style.display = 'block';
                break;

            case "register":
                modal.style.display = 'block';
                registerWindow.style.display = 'block';
                break;
            
            case "close-log":
                // console.log("CLOSEL")
                modal.style.display = 'none';
                logWindow.style.display = 'none';
                break;
            
            case "close-register":
                // console.log("CLOSER")
                modal.style.display = 'none';
                registerWindow.style.display = 'none';
                break;
            
            case "modal":
                // console.log("CLOSER")
                modal.style.display = 'none';
                registerWindow.style.display = 'none';
                break;
            
            // default:
            //     modal.style.display = 'none';
            //     logWindow.style.display = 'none';
            //     registerWindow.style.display = "none";
        }

        // if (loggin.contains(e.target)) {
        //     modal.style.display = 'block';
        //     logWindow.style.display = 'block';
        // }
        // else if (newAccount.contains(e.target)) {
        //     logWindow.style.display = "none";
        //     registerWindow.style.display = "block";
        // }
        
        // else if (register.contains(e.target)) {
        //         modal.style.display = 'block';
        //         registerWindow.style.display = 'block';
        // }
            
        // else if (closeLog.contains(e.target) || validateLog.contains(e.target)){
        // modal.style.display = 'none';
        // logWindow.style.display = 'none';
        // }
        // else if (closeRegister.contains(e.target) || cancelRegister.contains(e.target)) {
        //         modal.style.display = 'none';
        //         registerWindow.style.display = 'none';
        //     }
    })
}