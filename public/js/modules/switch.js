// ********************* switch product and category active

export function switchProducts() {
    
    if (window.location.search == "?route=admin") {
        //affiche ou masque les produits
        window.addEventListener('click', function (e) {
            switch (e.target.id) {
                case "switchProducts":
                    const productId = e.target.value
                    const dataProd = {
                        id: productId,
                        type: 'product'
                    };

                    fetch('index.php?route=productsFetch', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(dataProd),
                    })
                        .then(response => {
                            if (response.ok) {
                                alert('Le produit a été activé/désactivé avec succès !');
                            } else {
                                alert('Erreur lors de l\'activation/désactivation du produit.');
                            }
                        })
                        .catch(error => {
                            console.error('Une erreur s\'est produite lors de la requête Fetch :', error);
                        });
                    break;
            
                case "switchCategory":
                    const categoryId = e.target.value
                    const dataCat = {
                        id: categoryId,
                        type: 'category'
                    };
                
                    fetch('index.php?route=productsFetch', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(dataCat),
                    })
                        .then(response => {
                            if (response.ok) {
                                alert('La catégorie a été activée/désactivée avec succès !');
                            } else {
                                alert('Erreur lors de l\'activation/désactivation de la catégorie.');
                            }
                        })
                        .catch(error => {
                            console.error('Une erreur s\'est produite lors de la requête Fetch :', error);
                        });
                    break;
            }
        })
    }
}