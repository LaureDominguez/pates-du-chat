// ********************* upload d'images
export function uploadImages() {

    /////////// images form ///////////////////
    const imageForm = document.getElementById("imgForm");
    const message = document.getElementById("message");

    if (imageForm) {
        imageForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(imageForm);
            const formDataObject = {};

            for (const [key, value] of formData.entries()) {
                formDataObject[key] = value;
            }

            //Tests
            const allowedTypes = ["image/jpeg", "image/png", "image/gif"];
            if (!allowedTypes.includes(formDataObject.img.type)) {
                message.innerHTML = "Le format de l'image doit être de type jpeg, png ou gif.";
            } else {
                if (formDataObject.img.size > 10000000) {
                    message.innerHTML = "La taille de l'image doit être inférieur à 10 Mo.";
                } else {
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
                            message.innerHTML = "L'image a été téléchargée avec succès.";
                        } else {
                            message.innerHTML = "Erreur lors du téléchargement de l'image.";
                        }
                    })
                    .catch(error => {
                        console.error("Erreur :", error);
                    });
                }
            }
        })
    }
}
