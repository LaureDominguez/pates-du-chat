
import { revealOnScroll } from "./modules/anim-reveal.js";
import { titleOnNav } from "./modules/home-title.js";
import { dropdownNav } from "./modules/dropdown.js";
import { cookieSession } from "./modules/cookie.js";
import { filterCategory } from "./modules/fitler.js";
import { toogleModal } from "./modules/loggin.js";
import { checkErrors } from "./modules/errors.js";
import { switchProducts } from "./modules/switch.js";
import { editContact } from "./modules/horaires.js";
import { sortTable } from "./modules/sort-table.js";

window.addEventListener("DOMContentLoaded", function () {
    revealOnScroll(); // animation des blocs section sur homepage
    titleOnNav(); // animation du titre dans la barre de nav
    dropdownNav(); // menu dropdown de gestion de compte dans barre de nav
    // cookieSession();

    filterCategory(); // tri des produits dans partie shop

    toogleModal(); // affiche les fenetres de connexion
    checkErrors(); // gestion des erreurs dans fenetres de connexion 


    switchProducts(); // hide/show produits dans partie admin
    editContact(); // gestion des horaires dans partie admin
    sortTable(); // tri des tableaux dans partie admin
})























// ********************* switch active

    let switchCat = document.querySelectorAll('.switchCat');
    
console.log(switchCat);

for (let i = 0; i < switchCat.length; i++){
    switchCat[i].addEventListener('change', checked);
}

function checked(e) {
    let catID = e.target.id.replace("switch_","")
}

// let req = new Request('getID.php', {
//     method: 'POST',
//     body: JSON.stringify({id : catID})
// })

window.addEventListener("click", function (e) {
    checked(e);
});
//fetch(req)
//    .then(res => res.text())

const shop = document.getElementById("shop-tab");
console.log(shop)
/*
shop.addEventListener("click", function () {
  document.getElementById("demo").innerHTML = "Hello World";
});
*/
// // ********************* sort tableau (marche pas bien)
// const allTables = document.querySelectorAll("table");

// for (const table of allTables) {
//     const tBody = table.tBodies[0];
//     const rows = Array.from(tBody.rows);
//     const headerCells = table.tHead.rows[0].cells;

//     for (const th of headerCells) {
//         const cellIndex = th.cellIndex;

//         th.addEventListener("click", () => {
//         rows.sort((tr1, tr2) => {
//             const tr1Text = tr1.cells[cellIndex].textContent;
//             const tr2Text = tr2.cells[cellIndex].textContent;
//             return tr1Text.localeCompare(tr2Text);
//         });

//         tBody.append(...rows);
//         });
//     }
// }


// ********************* tooltip (marche pas)
// const tooltip = document.getElementsByClassName("aide");
// const screenX = window.screenX;
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
