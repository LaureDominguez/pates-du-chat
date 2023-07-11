// ********************* home title move to nav on scroll
export function titleOnNav() {

    const title = document.querySelector("#title");

    window.addEventListener("scroll", () => { 
        let scrollPosition = window.scrollY + 80;
        
        if (scrollPosition >= 500) {
            title.style.display = "flex";
            title.classList.add ("move-up");
        } else {
            title.style.display = "none";
            title.classList.remove ("move-up");
        }
    });
}