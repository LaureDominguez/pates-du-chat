// ********************* prolonge la session user
export function cookieSession() {
        function extendSession() {
        // var expirationTime = 3600; // Durée d'expiration en secondes

        // // Réinitialiser le cookie en utilisant JavaScript
        // document.cookie = "PHPSESSID=" + encodeURIComponent("<?php echo session_id(); ?>") + ";expires=" + new Date(new Date().getTime() + expirationTime * 1000).toUTCString() + ";path=/";
            
            fetch("index.php")
            .then(response => {
                if (response.ok) {
                    console.log("Session prolongée avec succès !");
                } else {
                    console.error("Échec de la prolongation de la session !");
                }
            })
            .catch(error => {
                console.error("Une erreur s'est produite lors de la prolongation de la session :", error);
            });
    }

    // Écouter les événements d'interaction de l'utilisateur et mettre à jour le cookie
    document.addEventListener("click", extendSession);
    document.addEventListener("scroll", extendSession);
    // Vous pouvez ajouter d'autres événements d'interaction en fonction de votre application

    // Vous pouvez également appeler updateSessionCookie() à intervalles réguliers (par exemple toutes les 5 minutes) pour garantir que la session est prolongée même si l'utilisateur n'interagit pas.
    // setInterval(updateSessionCookie, 300000); // 5 minutes en millisecondes
}

