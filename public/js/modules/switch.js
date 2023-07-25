// ********************* switch active

export function switchProducts() {
    
    //affiche ou masque les produits
    window.addEventListener('click', function (e) {
        switch (e.target.id) {
            case "switchProducts":
                const productId = e.target.value
                const dataProd = {
                    id: productId,
                    type: 'product'
                };

                fetch('./config/switchActiveFetch.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(dataProd),
                })
                .then(response => {
                    if (response.ok) {
                        console.log('Le produit a été activé/désactivé avec succès !');
                        // Mettre à jour l'affichage ou effectuer d'autres actions si nécessaire
                    } else {
                        console.error('Erreur lors de l\'activation/désactivation du produit.');
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
                
                fetch('./config/switchActiveFetch.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(dataCat),
                })
                .then(response => {
                    if (response.ok) {
                        console.log('La catégorie a été activée/désactivée avec succès !');
                        // Mettre à jour l'affichage ou effectuer d'autres actions si nécessaire
                    } else {
                        console.error('Erreur lors de l\'activation/désactivation de la catégorie.');
                    }
                })
                .catch(error => {
                    console.error('Une erreur s\'est produite lors de la requête Fetch :', error);
                });
                break;
        }  
    })
}