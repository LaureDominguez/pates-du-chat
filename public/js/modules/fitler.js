// ********************* checkbox categories

export function filterCategory() {

// Show/hide les filtres quand on click sur le boutton "filtrer"
    const filterBtn = document.getElementById('filterBtn');
    const filterDiv = document.getElementById('filter');

//le script ne se lance que si la classe existe
    if (filterDiv) {
        filterDiv.style.display = "none";
    
        //gestion de la boite de filtres
        filterBtn.addEventListener('click', function (e) {
            const currentDisplay = filterDiv.style.display;
            filterDiv.style.display = currentDisplay === "none" ? "flex" : "none";
        });


    // Filtres les produits par catégorie
        let checkboxes = document.querySelectorAll('.filter');

        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                // récup nom de la catégorie
                const categoryName = checkbox.dataset.name;
                // et de l'article associé
                const categories = document.querySelectorAll('.category');

                // console.log(categories);
                
                // puis parcours chaque catégorie pour appliquer la fonction
                categories.forEach(function (category) {
                    // si le nom de la catégorie == la valeur de la checkbox
                    if (category.querySelector('h3').textContent === categoryName) {
                        // show/hide la catégorie en fonction de l'état de la checkbox
                        category.style.display = checkbox.checked ? 'block' : 'none';
                    }
                });
            });
        });
    }
}