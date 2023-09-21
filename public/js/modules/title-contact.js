// ********************* checkbox categories

export function addLineBreak() {
    function applyLineBreak() {
        const title = document.querySelector(".responsive-title");
        if (title) {
            const text = title.textContent;
            const breakPoint = text.indexOf('?');

            if (breakPoint !== -1) {
                const debutText = text.substring(0, breakPoint + 1); // recup debut du text + "?"
                const finText = text.substring(breakPoint + 1); // recup text après "?"

                if (window.innerWidth < 768) {
                    title.innerHTML = debutText + '<br>' + finText;
                } else {
                    title.innerHTML = debutText + finText;
                }
            }
        }
    }

    applyLineBreak();

    window.addEventListener('load', applyLineBreak);
    window.addEventListener('resize', applyLineBreak);
}