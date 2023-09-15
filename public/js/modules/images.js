// ********************* upload d'images
export function uploadImages() {

    // success message stocké dans msg flash, effacé par session_start lors de la redirection...

    // delete img -> fetch

    /////////// images form ///////////////////
    
    const productForm = document.getElementById("productForm");
    const imageForm = document.getElementById("imgForm");
    const imgMsg = document.getElementById("imgMsg");

    if (productForm) {
        // preview d'image pour création de produit
        const imgInput = productForm.querySelector('input[type="file"]');
        const previewImage = document.getElementById('previewImage');
        
        if (imgInput && previewImage) {
            imgInput.addEventListener('change', function () {
                const file = this.files[0]; // Récupère fichier sélectionné
                
                // Réinitialise l'image et message d'erreur
                previewImage.src = '#';
                imgMsg.innerHTML = "";

                if (file) {
                    const allowedTypes = ["image/jpeg", "image/png", "image/gif"];
                    const maxSize = 10000000;

                    if (!allowedTypes.includes(file.type)) {
                        imgMsg.innerHTML = "Le format de l'image doit être de type jpeg, png ou gif.";
                    } else if (file.size > maxSize) {
                        imgMsg.innerHTML = "La taille de l'image doit être inférieure à 10 Mo.";
                    } else {
                        const reader = new FileReader();

                        reader.onload = function (e) {
                            // Met à jour la balise img avec l'image chargée
                            previewImage.src = e.target.result;
                            previewImage.style.display = 'block'; // Affiche l'image
                        };
                        reader.readAsDataURL(file); // Charge le fichier en tant qu'URL Data
                    }
                }
            });
        }
        

        // envoi du product form
        productForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(productForm);
            const formDataObject = formDataToObject(formData);

            // Test
            const nameInput = document.getElementById("nameInput");
            const productName = document.getElementById("name");
            const descriptInput = document.getElementById("descriptInput");
            const productDescript = document.getElementById("descript");
            const priceInput = document.getElementById("priceInput");
            const productPrice = document.getElementById("price");
            
            let errorFound = false;

            if (formDataObject.name.trim() === "") {
                productName.placeholder = "Veuillez donner un nom au produit";
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

    
        // upload d'image fetch pour product updating

        if (imageForm) {
            imageForm.addEventListener("submit", function (e) {
                e.preventDefault();
                const formData = new FormData(imageForm);
                const formDataObject = formDataToObject(formData);
                let errorFound = false;
                imgMsg.innerHTML = ""
                
                //Tests
                const allowedTypes = ["image/jpeg", "image/png", "image/gif"];
                if (formDataObject.img.size === 0) {
                    imgMsg.innerHTML = "Selectionnez une image à envoyer";
                    errorFound = true;
                } else if (formDataObject.img.size > 10000000) {
                    imgMsg.innerHTML = "La taille de l'image doit être inférieur à 10 Mo.";
                    errorFound = true;
                } else if (!allowedTypes.includes(formDataObject.img.type)) {
                    imgMsg.innerHTML = "Le format de l'image doit être de type jpeg, png ou gif.";
                    errorFound = true;
                } 
                
                // Si pas d'erreur, on envoi la requete fetch
                if (!errorFound) { 
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
                            imgMsg.innerHTML = "L'image a été enregistrée avec succès.";
                            // Mise à jour de la balise <img> avec le chemin de la nouvelle image
                            const productImage = document.getElementById('productImage');
                            productImage.src = 'public/img/produits/' + formDataObject.img.name;
                            // location.reload();
                        } else {
                            imgMsg.innerHTML = "Erreur lors du téléchargement de l'image.";
                        }
                    })
                    .catch(error => {
                        console.error("Erreur :", error);
                    });
                }
            })

            // suppression d'image fetch
            const deleteBtn = imageForm.querySelector("#delete-btn");

            if (deleteBtn) {
                deleteBtn.addEventListener("click", function (e) {
                    const imageData = document.getElementById('productImage');
                    const productId = document.getElementById('productId').value;
                    const imageId = imageData.getAttribute('data-id');
                    const imageName = imageData.getAttribute('data-name');

                    console.log(imageId);
                    console.log(productId);

                    const verif = window.confirm("Êtes-vous sûr de vouloir supprimer l'image ?");

                    if (verif) {
                        fetch('index.php?route=deleteFetch', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `product_id=${productId}&image_id=${imageId}`,
                        })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                location.reload();
                            } else {
                                // Gérez l'erreur ou affichez un message d'erreur
                                console.error(data.error);
                            }
                        })
                        .catch((error) => {
                            console.error('Une erreur s\'est produite :', error);
                        });
                    }
                })
            }
    }
    

    function formDataToObject(formData) {
        const formDataObject = {};
        for (const [key, value] of formData.entries()) {
            formDataObject[key] = value;
        }
        return formDataObject;
    }
}
