// ********************* test errors on login/register modal
export function resetPswd() {

    const resetPswd = document.getElementById('resetPswd');

    if (resetPswd) {
        // envoie un mail pour reset pswd
        resetPswd.addEventListener('click', function () {

            fetch('index.php?route=resetFetch', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(result => {
                console.log(result);
            })
            .catch(error => {
                console.error('Erreur lors de la requête Fetch:', error);
            });
        });
    }
}