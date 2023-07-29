// ********************* modifier le tableau d'horaires

export function editContact() {

    // rend les champs et le bouton dispo pour admin
    const saveBtn = document.getElementById('saveBtn');
    const elements = document.querySelectorAll('.editable');
    
    // l'edition n'est dispo que sur la page admin
    if (window.location.search != "?route=admin") {
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
        
        //fonction quand on clique sur le boutton
        saveBtn.addEventListener('click', function () {
            // Créer un tableau qui stock les données à enregistrer
            const dataToSave = [];

            // Parcourir toutes les lignes du tableau
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

                    // Ajouter les données modifiées au tableau 
                    dataToSave.push({ day, time, city, place });
                }
            });

            // Effectuer la requête fetch pour enregistrer les données sur le serveur
            fetch('index.php?route=horairesFetch', {
                method: 'POST', // Utiliser la méthode POST pour envoyer les données
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(dataToSave) // Convertir les données en format JSON pour l'envoi
            })
                .then(response => response.json())
            .then(data => {
                // Traiter la réponse du serveur ici si nécessaire
                console.log('réponse', data);
                alert('Données enregistrées avec succès !');
                // on supprime la classe "modified" après envoi
                tableRows.forEach(function (row) {
                        row.querySelector('[data-field="time"]').classList.remove('modified');
                        row.querySelector('[data-field="city"]').classList.remove('modified');
                        row.querySelector('[data-field="place"]').classList.remove('modified');
                    });
            })
                .catch(error => {
                    console.log('Erreur :', error);
                // Gérer les erreurs ici si nécessaire
                alert('Une erreur est survenue lors de l\'enregistrement des données.');
            });
        });
    }
}