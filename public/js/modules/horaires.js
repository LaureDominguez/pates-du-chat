// ********************* opening hour editable table

// Fonction pour vérifier si des modifications ont été apportées
function hasModifications() {
    const modifiedElements = document.querySelectorAll('.modified');
    return modifiedElements.length > 0;
}

// Fonction pour éditer le tableau
export function editContact() {
    const saveBtn = document.getElementById('saveBtn');
    const elements = document.querySelectorAll('.editable');

    if (saveBtn) {
        // rend les champs et le bouton save dispo sur page admin
        if (window.location.search !== "?route=admin") {
            saveBtn.style.display = "none";
            elements.forEach(function (field) {
                field.classList.remove('editable');
            });
        } else {
            elements.forEach(function (field) {
                field.setAttribute('contenteditable', 'true');
                // Ajouter la classe 'modified' lorsque le contenu est modifié
                field.addEventListener('input', function () {
                    this.classList.add('modified');
                });
            });
            
            // bouton save
            saveBtn.addEventListener('click', function () {
                if (!hasModifications()) {
                    alert('Aucune modification à enregistrer.');
                    return;
                }

                // Créer un tableau qui stock les données à enregistrer
                const dataToSave = [];

                //vérifie tout le tableau
                const tableRows = document.querySelectorAll('tr[data-day]');
                tableRows.forEach(function (row) {
                    const day = row.getAttribute('data-day');
                    const timeCell = row.querySelector('[data-field="time"]');
                    const cityCell = row.querySelector('[data-field="city"]');
                    const placeCell = row.querySelector('[data-field="place"]');

                    // récupère les case modifées
                    if (timeCell.classList.contains('modified') || cityCell.classList.contains('modified') || placeCell.classList.contains('modified')) {
                        const time = timeCell.textContent;
                        const city = cityCell.textContent;
                        const place = placeCell.textContent;
                        // Ajoute les données modifiées au tableau 
                        dataToSave.push({ day, time, city, place });
                    }
                });

                // envoi les données en fetch au serveur
                fetch('index.php?route=horairesFetch', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(dataToSave)
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log('réponse', data);
                        alert('Données enregistrées avec succès !');
                        // supprime la classe "modified" après envoi
                        tableRows.forEach(function (row) {
                            row.querySelector('[data-field="time"]').classList.remove('modified');
                            row.querySelector('[data-field="city"]').classList.remove('modified');
                            row.querySelector('[data-field="place"]').classList.remove('modified');
                        });
                    })
                    .catch(error => {
                        console.log('Erreur :', error);
                        alert('Une erreur est survenue lors de l\'enregistrement des données.');
                    });
            });
        }
    }
}
