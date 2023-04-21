// import { modalLog } from "./modules/nav";
// then(modalLog());
// import { dropdownNav } from "./modules/nav";
// then(dropdownNav());


// ********************* show/hide nav

let dropdown = document.getElementById('dropdown-toggle');
let menu = document.getElementById('dropdown-menu');

window.addEventListener('click', function (e) {
    if (dropdown.contains(e.target)) {
        menu.style.display = "block";
    }
    else if (menu.style.display == "block") {
        menu.style.display = "none";
    }
})


// ********************* show/hide modal

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
    if (loggin.contains(e.target)) {
        modal.style.display = 'block';
        logWindow.style.display = 'block';
    }
    else if (!logWindow.contains(e.target) || closeLog.contains(e.target) || validateLog.contains(e.target)){
        modal.style.display = 'none';
        logWindow.style.display = 'none';
    }
    else if (newAccount.contains(e.target)) {
        logWindow.style.display = "none";
        registerWindow.style.display = "block";
    }
})

//     window.addEventListener('click', function (e) {
//         if (register.contains(e.target)) {
//             modal.style.display = 'block';
//             registerWindow.style.display = 'block';
//         }
//         else if (!registerWindow.contains(e.target) || closeRegister.contains(e.target) || cancelRegister.contains(e.target)) {
//             modal.style.display = 'none';
//             registerWindow.style.display = 'none';
//         }
// })

// ********************* switch active

    let switchCat = document.querySelectorAll('.switchCat');
for (let i = 0; i < switchCat.length; i++){
    switchCat[i].addEventListener('change', checked);
}

function checked(e) {
    let catID = e.target.id.replace("switch_","")
}

let req = new Request('getID.php', {
    method: 'POST',
    body: JSON.stringify({id : catID})
})

fetch(req)
    .then(res => res.text())


// ********************* sort tableau (marche pas bien)
const allTables = document.querySelectorAll("table");

for (const table of allTables) {
    const tBody = table.tBodies[0];
    const rows = Array.from(tBody.rows);
    const headerCells = table.tHead.rows[0].cells;

    for (const th of headerCells) {
        const cellIndex = th.cellIndex;

        th.addEventListener("click", () => {
        rows.sort((tr1, tr2) => {
            const tr1Text = tr1.cells[cellIndex].textContent;
            const tr2Text = tr2.cells[cellIndex].textContent;
            return tr1Text.localeCompare(tr2Text);
        });

        tBody.append(...rows);
        });
    }
}


// ********************* tooltip (marche pas)
const tooltip = document.getElementsByClassName("aide");
const screenX = window.screenX;
// if screenX est à +50%, alors add class "left" à "aide"

// ********************* confirm delete

// confirmDelete(){
//     // const id = id;
//     // const route = route; 
//     if (confirm("Voulez-vous supprimer cet élément ?") == true) {
//         window.location.href = "index.php?route=deleteNews&id=<?= $actu['id'] ?>";
//         // window.location.href = "index.php?route=".route."&id=".id."?>"
//     }
// }
