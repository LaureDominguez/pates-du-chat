// ********************* check active

export function filterCategory() {

// Show/hide les filtres quand on click sur le boutton "filtrer"
    const filterBtn = document.getElementById('filterBtn');
    const filterDiv = document.getElementById('filter');
    filterDiv.style.opacity = 0;
    
    filterBtn.addEventListener('click', function (e) {
        const currentOpacity = parseFloat(filterDiv.style.opacity);
        filterDiv.style.opacity = currentOpacity === 0 ? 1 : 0;
    });


// Filtres les produits par catégorie
    let checkboxes = document.querySelectorAll('.filter');

    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            // récup nom de la catégorie
            const categoryName = checkbox.dataset.id;
            // et de l'article associé
            const categories = document.querySelectorAll('.shop-cat');
            
            // puis parcours chaque catégorie pour appliquer la fonction
            categories.forEach(function (category) {
                // si le nom de la catégorie == la valeur de la checkbox
                if (category.querySelector('h2').textContent === categoryName) {
                    // show/hide la catégorie en fonction de l'état de la checkbox
                    category.style.display = checkbox.checked ? 'block' : 'none';
                }
            });
        });
    });
}