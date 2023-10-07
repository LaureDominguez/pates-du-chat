// ********************* test errors on login/register modal
export function displayAlerts() {

/////////// register form ///////////////////
    const alertDiv = document.getElementById('promptAlert');
    if (alertDiv) {
        const success = document.querySelectorAll('.success');
        const error = document.querySelectorAll('.error');

        // Affiche les erreurs si besoin
        if (success) {
            success.style.display = 'block';
            return;
        } else if (error) {
            error.style.display = 'block';
            return;
        }
    }
}
