// ********************* show/hide navbar on mobile, and dropdown on large screan

// dropdown menu
export function dropdownNav() {
    let dropdown = document.getElementById('dropdown-toggle');
    let menu = document.getElementById('dropdown-menu');

    window.addEventListener('click', function (e) {
        if (dropdown !== null) {
            if (dropdown.contains(e.target)) {
                console.log('pouet')
                menu.style.display = "flex";
            }
            else if (menu.style.display == "flex") {
                menu.style.display = "none";
            }
        }
    })
}

// mobile navbar
export function mobileNav() {
    const burger = document.getElementById('burger');
    const menuMobile = document.getElementById('menu-mobile');
    const main = document.querySelector('main');
    if(burger) {
        burger.addEventListener('click', function (e) {
            const currentDisplay = window.getComputedStyle(menuMobile).display;

            if (currentDisplay === 'none') {
                menuMobile.style.display = 'flex';
                main.classList.add('noScroll');
            } else {
                menuMobile.style.display = 'none';
                main.classList.remove('noScroll');
            }
        })
    }
}