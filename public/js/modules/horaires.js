// ********************* modifier le tableau d'horaires

export function editContact() {
    
    if (window.location.search === "?route=admin") {
        let elements = document.querySelectorAll('.editable');
        elements.forEach(element => {
            element.setAttribute('contenteditable', 'true');
            element.addEventListener('blur', () => {
                saveChanges(element);
            });
        })
    }

    function saveChanges(element) {
        const data = {
            field: element.getAttribute('data-field'), // Ajoutez un attribut data-field à chaque élément éditable pour identifier le champ (par exemple, "heure", "ville", "emplacement")
            value: element.innerText
        };
        // Envoie les données modifiées au serveur en utilisant fetch
        fetch('./config/horairesFetch.php', {
            method: 'POST',
            headers: {
            'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            // Traitez la réponse du serveur si nécessaire
            console.log(data);
        })
        .catch(error => {
            console.error('Erreur lors de l\'envoi des modifications au serveur:', error);
        });
    }

}