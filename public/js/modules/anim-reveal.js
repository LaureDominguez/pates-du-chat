// ********************* anim reveal on scroll
export function revealOnScroll(){

    window.addEventListener("scroll", reveal);
    window.addEventListener("scroll", revealR);
    window.addEventListener("scroll", revealL);
    reveal();
    revealR();
    revealL();

    let section = document.querySelectorAll("section");
    let menu = document.querySelectorAll("#nav ul li a");

    window.onscroll = ()=> {
        section.forEach(i =>{
            let top = window.scrollY;
            let offset = i.offsetTop -150;
            let height = i.offsetHeight;
            let id = i.getAttribute("id");

            if (top >= offset && top < offset + height){
                menu.forEach(link => {
                    link.classList.remove("active");
                    document.querySelector("#nav ul li a[href*=" + id + "]").classList.add("active");
                })
            }
        })
    }

    function reveal(){
        let reveals = document.querySelectorAll(".reveal");
        for (i = 0; i < reveals.length; i++){
            let windowHeight = window.innerHeight;
            let elementTop = reveals[i].getBoundingClientRect().top;
            let elementVisible = 150;
            if (elementTop < windowHeight - elementVisible){
                reveals[i].classList.add("active");
            } else {
                reveals[i].classList.remove("active");
            }
        }
    }

    function revealR(){
        let reveals = document.querySelectorAll(".revealR");
        for (i = 0; i < reveals.length; i++){
            let windowHeight = window.innerHeight;
            let elementTop = reveals[i].getBoundingClientRect().top;
            let elementVisible = 150;
            if (elementTop < windowHeight - elementVisible){
                reveals[i].classList.add("active");
            } else {
                reveals[i].classList.remove("active");
            }
        }
    }

    function revealL(){
        let reveals = document.querySelectorAll(".revealL");
        for (i = 0; i < reveals.length; i++){
            let windowHeight = window.innerHeight;
            let elementTop = reveals[i].getBoundingClientRect().top;
            let elementVisible = 150;
            if (elementTop < windowHeight - elementVisible){
                reveals[i].classList.add("active");
            } else {
                reveals[i].classList.remove("active");
            }
        }
    }

    window.addEventListener("scroll", reveal());
    window.addEventListener("scroll", revealR());
    window.addEventListener("scroll", revealL());
    reveal();
    revealR();
    revealL();

}