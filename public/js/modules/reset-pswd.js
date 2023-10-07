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
                

                // affiche success ou error dans une div
                const addDiv = document.createElement('div');
                const msg = document.createElement('p');
                if (result.success) {
                    addDiv.classList.add('success');
                    msg.textContent = result.message;
                    addDiv.appendChild(msg);
                    // addDiv.style.display = "flex";
                } else {
                    addDiv.classList.add('error');
                    msg.textContent = result.message;
                    addDiv.appendChild(msg);
                    // addDiv.style.display = "flex";
                }

                document.body.appendChild(addDiv);

                // cln error div
                // const errorDiv
            })
            .catch(error => {
                console.error('Erreur lors de la requête Fetch:', error);
            });
        });
    }
}