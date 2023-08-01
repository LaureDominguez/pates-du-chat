// ********************* show/hide navbar on mobile, and dropdown on large screan

// dropdown menu
export function dropdownNav() {
    let dropdown = document.getElementById('dropdown-toggle');
    let menu = document.getElementById('dropdown-menu');

    window.addEventListener('click', function (e) {
        console.log(e.target)
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
    if(burger) {
        burger.addEventListener('click', function (e) {
            switch (menuMobile.style.display) {
                case 'none':
                    menuMobile.style.display = 'flex';
                    break;
                case 'flex':
                    menuMobile.style.display = 'none';
                    break;
                default:
                    menuMobile.style.display = 'none';
                    break;
            }
        })
    }
}