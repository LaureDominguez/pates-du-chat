import { toogleModal } from "./modules/loggin.js";
import { dropdownNav } from "./modules/dropdown.js";
import { toogleCart } from "./modules/shopCart.js";
import { checkboxProducts } from "./modules/switch.js";
import { revealOnScroll } from "./modules/anim-reveal.js";
// import { dynamicFields } from "./modules/dynamicFields.js";

window.addEventListener("DOMContentLoaded", function () {
    toogleModal();
    dropdownNav();
    toogleCart();
    checkboxProducts();
    revealOnScroll();
    // dynamicFields();
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
