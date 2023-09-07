// ********************* upload d'images
export function uploadImages() {

    // Creation de produit -> img -> php + preview d'img + pas de fetch + msg flash
    //-> revoir formulaire -> test js -> envoi php -> redirect

    // done ! update produit -> php -> rediriger vers accueil + msg flash

    // delete img -> fetch

    /////////// images form ///////////////////
    
    //  Formulaire de produit
    const productForm = document.getElementById("productForm");
    const imageForm = document.getElementById("imgForm");
    const imgBtn = document.getElementById("imgBtn");

    if (productForm) {

        // preview d'image pour création de produit
        if (!imgBtn) { // dispo que si les boutons de modification ne sont pas affichés
            const imgInput = imageForm.querySelector('input[type="file"]');
            const previewImage = document.getElementById('previewImage');

            imgInput.addEventListener('change', function () {
                const file = this.files[0]; // Récupère le fichier sélectionné

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        // Met à jour l'attribut src de l'élément img avec l'URL de l'image chargée
                        previewImage.src = e.target.result;
                        previewImage.style.display = 'block'; // Affiche l'image
                    };

                    reader.readAsDataURL(file); // Charge le fichier en tant qu'URL Data
                } else {
                    // Si aucun fichier n'est sélectionné, masque l'image
                    previewImage.src = '#';
                    previewImage.style.display = 'none';
                }
            });
        }

        // upload d'image fetch pour product updating
        imageForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(imageForm);
            const imgMsg = document.getElementById("imgMsg");
            const formDataObject = {};
                for (const [key, value] of formData.entries()) {
                    formDataObject[key] = value;
            }
            console.log(formDataObject);
            
            //Tests
            if (formDataObject.img.size === 0) {
                imgMsg.innerHTML = "Selectionnez une image à envoyer";
                return;
            } 

            const allowedTypes = ["image/jpeg", "image/png", "image/gif"];

            if (!allowedTypes.includes(formDataObject.img.type)) {
                imgMsg.innerHTML = "Le format de l'image doit être de type jpeg, png ou gif.";
            } else if (formDataObject.img.size > 10000000) {
                imgMsg.innerHTML = "La taille de l'image doit être inférieur à 10 Mo.";
            } else { // Si pas d'erreur, on envoi la requete fetch
                fetch("index.php?route=imagesFetch", {
                    method: "POST",
                    body: formData,
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Erreur lors de la requête Fetch");
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        imgMsg.innerHTML = "L'image a été téléchargée avec succès.";
                         // Mise à jour de la balise <img> avec le chemin de la nouvelle image
                        const productImage = document.getElementById('productImage');
                        productImage.src = 'public/img/produits/' + formDataObject.img.name;
                    } else {
                        imgMsg.innerHTML = "Erreur lors du téléchargement de l'image.";
                    }
                })
                .catch(error => {
                    console.error("Erreur :", error);
                });
            }
        })

        // envoi du product form
        productForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(productForm);
            const formDataObject = {};

            for (const [key, value] of formData.entries()) {
                formDataObject[key] = value;
            }
            console.log(imgInput);

            // Test

            const nameInput = document.getElementById("nameInput");
            const prodtuctName = document.getElementById("name");
            const descriptInput = document.getElementById("descriptInput");
            const productDescript = document.getElementById("descript");
            const priceInput = document.getElementById("priceInput");
            const productPrice = document.getElementById("price");
            
            let errorFound = false;

            if (formDataObject.name.trim() === "") {
                prodtuctName.placeholder = "Veuillez donner un nom au produit";
                nameInput.style.color = "red";
                errorFound = true;
            } else {
                nameInput.style.color = "black";
            }

            if (formDataObject.descript.trim() === "") {
                productDescript.placeholder = "Veuillez donner une description au produit";
                descriptInput.style.color = "red";
                errorFound = true;
            } else {
                descriptInput.style.color = "black";
            }

            if (formDataObject.price.trim() === "") {
                productPrice.placeholder = "Veuillez donner un prix au produit";
                priceInput.style.color = "red";
                errorFound = true;
            } else {
                priceInput.style.color = "black";
            }

            if (errorFound === false) {
                productForm.submit();
            }
        })
    }



    //preview d'image
    // const imgInput = imageForm.querySelector('input[type="file"]');
    // const previewImage = document.getElementById('previewImage');

    // imgInput.addEventListener('change', function () {
    //     const file = this.files[0]; // Récupère le fichier sélectionné

    //     if (file) {
    //         const reader = new FileReader();

    //         reader.onload = function (e) {
    //             // Met à jour l'attribut src de l'élément img avec l'URL de l'image chargée
    //             previewImage.src = e.target.result;
    //             previewImage.style.display = 'block'; // Affiche l'image
    //         };

    //         reader.readAsDataURL(file); // Charge le fichier en tant qu'URL Data
    //     } else {
    //         // Si aucun fichier n'est sélectionné, masque l'image
    //         previewImage.src = '#';
    //         previewImage.style.display = 'none';
    //     }
    // });
}
