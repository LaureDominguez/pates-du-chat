// ********************* prolonge la session user
export function cookieSession() {
        function extendSession() {
            
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
    setInterval(extendSession, 3600000);
}

