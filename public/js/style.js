
import { titleOnNav } from "./modules/home-title.js";
import { dropdownNav, mobileNav } from "./modules/dropdown.js";
import { filterCategory } from "./modules/fitler.js";
import { toogleModal } from "./modules/loggin-display.js";
import { checkErrors } from "./modules/loggin-errors.js";
import { switchProducts } from "./modules/switch.js";
import { editContact } from "./modules/horaires.js";
import { sortTable } from "./modules/sort-table.js";
// import { lazy } from "./modules/lazy.js";
import { disableAccount } from "./modules/disable.js";
import { uploadImages } from "./modules/images.js";
import { draggingGrid } from "./modules/dragging.js";
import { hrefOnclick } from "./modules/hrefOnclick.js";
import { resetPswd } from "./modules/reset-pswd.js";
// import { addLineBreak } from "./modules/title-contact.js";

window.addEventListener("DOMContentLoaded", function () {
    titleOnNav(); // animation du titre dans la barre de nav
    dropdownNav(); // menu dropdown de gestion de compte dans barre de nav
    mobileNav(); // navbar pour version mobile

    hrefOnclick(); // pour pas utiliser onclick dans la balise html

    draggingGrid(); // dragging sur la grille des produits
    filterCategory(); // tri des produits dans partie shop

    toogleModal(); // affiche les fenetres de connexion
    checkErrors(); // gestion des erreurs dans fenetres de connexion 
    resetPswd(); // changer de mdp
    disableAccount();// desactive son compte

    uploadImages(); // upload images dans partie admin
    switchProducts(); // hide/show produits dans partie admin
    editContact(); // gestion des horaires dans partie admin
    sortTable(); // tri des tableaux dans partie admin
})