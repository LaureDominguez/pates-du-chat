// ********************* show/hide nav

export function dropdownNav() {
    let dropdown = document.getElementById('dropdown-toggle');
    let menu = document.getElementById('dropdown-menu');

    window.addEventListener('click', function (e) {
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