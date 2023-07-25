// ********************* check active

export function filterCategory() {

// Show/hide les filtres quand on click sur le boutton "filtrer"
    const filterBtn = document.getElementById('filterBtn');
    const filterDiv = document.getElementById('filter');
    filterDiv.style.opacity = 0;

    console.log('pouet', filterDiv.style)
    
    filterBtn.addEventListener('click', function (e) {
        const currentOpacity = parseFloat(filterDiv.style.opacity);
        filterDiv.style.opacity = currentOpacity === 0 ? 1 : 0;
    });


// Filtres les produits

    let elements = document.querySelectorAll('.filter');
    console.log(elements);

    elements.forEach(element => {
        const checkbox = element.getAttribute('data-field');
        const dataDay = element.parentNode.getAttribute('data-day');
                
                
            
        //         element.setAttribute('contenteditable', 'true');
    
        // //affiche ou masque les produits
        // window.addEventListener('click', function (e) {
        //     switch (e.target.id) {
        //         case "switchProducts":
        //             const productId = e.target.value
        //             const dataProd = {
        //                 id: productId,
        //                 type: 'product'
        //             };

        //             break;
        //     }  
    });
}