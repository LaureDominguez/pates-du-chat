// ********************* home title move to nav on scroll
export function titleOnNav() {
    const title = document.getElementById("title-nav");
    const template = document.getElementById("template");

    if (window.location.search === "?route=home") {
        template.classList.remove("container");
        let lastScrollPosition = window.scrollY;

        window.addEventListener("scroll", () => {
            let scrollPosition = window.scrollY;

            if (scrollPosition > lastScrollPosition) {
                // Scroll vers le bas
                title.classList.remove("move-out");
                title.classList.add("move-up");
            } else {
                // Scroll vers le haut
                title.classList.remove("move-up");
                title.classList.add("move-out");
            }

            lastScrollPosition = scrollPosition;
        });
        
    } else {
        title.style.display = "flex";
        title.style.opacity= 1;
    }
}