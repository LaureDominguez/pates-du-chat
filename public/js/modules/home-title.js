// ********************* home title move to nav on scroll
export function titleOnNav() {

    const title = document.querySelector("#title");


    window.addEventListener("scroll", () => { 
        let scrollPosition = window.scrollY + 80;
        
        if (scrollPosition >= 500) {
            title.classList.remove("hidden");
        } else {
            title.classList.add("hidden");
        }
    });
}