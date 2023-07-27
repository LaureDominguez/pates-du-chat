// ********************* show/hide nav

export function dropdownNav() {
    let dropdown = document.getElementById('dropdown-toggle');
    let menu = document.getElementById('dropdown-menu');

    window.addEventListener('click', function (e) {
        console.log('pouet')
        if (dropdown !== null) {
            if (dropdown.contains(e.target)) {
                menu.style.display = "block";
            }
            else if (menu.style.display == "block") {
                menu.style.display = "none";
            }
        }
    })

    const burger = document.getElementById('burger');
    const menuMobile = document.getElementById('menu-mobile');
    if(burger) {
        burger.addEventListener('click', function (e) {
            switch (menuMobile.style.opacity) {
                case '0':
                    menuMobile.style.opacity = '1';
                    break;
                case '1':
                    menuMobile.style.opacity = '0';
                    break;
                default:
                    menuMobile.style.opacity = '1';
                    break;
            }
        })
    }
}