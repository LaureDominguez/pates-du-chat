// ********************* checkbox categories

export function draggingGrid() {
    let isDragging = false;
    let startX, scrollLeft;

    const containers = document.querySelectorAll(".shop-cat");

    if (containers) {
        containers.forEach(container => {
            console.log("pouet");
            container.addEventListener("mousedown", (e) => {
                console.log("prout");
                isDragging = true;
                startX = e.pageX - container.offsetLeft;
                scrollLeft = container.scrollLeft;
            });

            container.addEventListener("mouseleave", () => {
                isDragging = false;
            });

            container.addEventListener("mouseup", () => {
                isDragging = false;
            });

            container.addEventListener("mousemove", (e) => {
                if (!isDragging) return;
                e.preventDefault();
                const x = e.pageX - container.offsetLeft;
                const walk = (x - startX) * 2;
                container.scrollLeft = scrollLeft - walk;
            });
        });
    }



}