// ********************* show/hide nav

export function dropdownNav() {
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
}