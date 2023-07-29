// ********************* affiche le spinner sur l'element à charger
export function lazy() {
    const lazy = document.getElementById('lazy');
    const spinner = document.getElementById('spinner');

    if (lazy) {
        lazy.addEventListener('loadstart', () => {
            spinner.style.display = "flex";
        })
        lazy.addEventListener('load', () => {
            spinner.style.display = 'none';
        })
    }
}

