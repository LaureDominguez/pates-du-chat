// ********************* test errors on login/register modal
export function displayAlerts() {

/////////// register form ///////////////////
    const alertDiv = document.getElementById('promptAlert');
    if (alertDiv) {
        const success = document.querySelector('.success');
        const error = document.querySelector('.error');

        // Affiche les erreurs si besoin
        if (success) {
            success.style.display = 'flex';
        }
        if (error) {
            error.style.display = 'flex';
        }
    }
}
