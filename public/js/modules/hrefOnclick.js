// ********************* checkbox categories

export function hrefOnclick() {
    const moreBtn = document.querySelectorAll(".more");

    if (moreBtn) {
        moreBtn.forEach(function (btn) {
            btn.addEventListener('click', function () {
                window.location.href = "index.php?route=shop";
            })
        })
    }
}