// ********************* tri des données d'un tableau
export function sortTable(columnIndex) {
    const table = findAncestor(event.target, 'dashboard-table');
    if (!table) {
        return; // Le tableau parent n'a pas la classe 'dashboard-table'
    }

    let tbody = table.tBodies[0];
    if (!tbody) {
        // Si tbody n'est pas trouvé, utilisez directement les lignes <tr> du tableau
        tbody = table;
    }
    const rows = Array.from(tbody.querySelectorAll('tr'));

    // Fonction de comparaison pour le tri
    function compareRows(rowA, rowB) {
        const cellA = rowA.cells[columnIndex];
        const cellB = rowB.cells[columnIndex];

        if (!cellA || !cellB) {
            return 0; // Si la cellule n'existe pas, considérez qu'elle a la même valeur que l'autre cellule
        }

        const cellAText = cellA.textContent.trim() || '';
        const cellBText = cellB.textContent.trim() || '';

        if (!isNaN(cellAText) && !isNaN(cellBText)) {
            return Number(cellAText) - Number(cellBText);
        } else {
            return cellAText.localeCompare(cellBText, undefined, { numeric: true });
        }
    }

    rows.sort(compareRows);
    rows.forEach(row => tbody.appendChild(row)); // Changer l'ordre des lignes
    console.log('Tri terminé !');

    // Si tbody n'est pas trouvé, ajoutez les lignes triées directement au tableau
    if (!table.tBodies[0]) {
        rows.forEach(row => table.appendChild(row));
    }
}

// Fonction pour trouver l'ancêtre avec la classe spécifiée
function findAncestor(element, className) {
    while ((element = element.parentElement) && !element.classList.contains(className));
    return element;
}

// Écouteurs d'événements pour le tri des colonnes
const tableHeaders = document.querySelectorAll('.dashboard-table th');
tableHeaders.forEach((header, index) => {
    header.addEventListener('click', (event) => {
        const columnIndex = Array.from(header.parentNode.children).indexOf(header);
        sortTable(columnIndex);
    });
});
