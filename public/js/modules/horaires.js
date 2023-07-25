// ********************* modifier le tableau d'horaires

export function editContact() {
    if (window.location.search === "?route=admin") {
        const saveBtn = document.getElementById('saveBtn');
        let elements = document.querySelectorAll('.editable');
        saveBtn.style.display = "flex";

        elements.forEach(element => {
            const dataField = element.getAttribute('data-field');
            const dataDay = element.parentNode.getAttribute('data-day');
                
                
            
            element.setAttribute('contenteditable', 'true');
            element.addEventListener('focus', () => {
                if (dataField.parentNode == dataDay.parentNode) {
                    //faire un index des datafield modifiés
                    console.log('pouet')
                    console.log(dataField);
                    console.log(dataDay)
                }
                // Sauvegarder la valeur originale lorsque l'élément est en focus
                element.dataset.originalValue = element.innerText;
            });
        });

        saveBtn.addEventListener('click', () => {
            elements.forEach((element) => {
                const dataField = element.getAttribute('data-field');
                const dataDay = element.parentNode.getAttribute('data-day');
                const value = element.innerText;
                const originalValue = element.dataset.originalValue;
                
                console.log(dataField);
                console.log(dataDay)

                // Vérifier s'il y a eu une modification
                if (value !== originalValue) {
                    saveChanges(dataField, dataDay, value);
                    // Réinitialiser la valeur originale pour l'élément
                    element.dataset.originalValue = value;
                }
            });
        });
    }

    function saveChanges(field, day, value) {
        const data = {
            day: day,
            field: field,
            value: value
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