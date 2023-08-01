// ********************* test errors on login/register modal
export function disableAccount() {

    /////////// register form ///////////////////
    const disableRequest = document.getElementById('disable');
    if (disableRequest) {
        disableRequest.addEventListener("submit", handleSubmitDisable);

        async function handleSubmitDisable(e) {
            e.preventDefault();

            const verif = window.confirm("Êtes-vous sûr de vouloir continuer ?");
            if (verif) {
                disableRequest.submit();
            }
        }
    }
}