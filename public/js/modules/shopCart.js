// ********************* show/hide modal
export function toogleCart() {
        
    let cart = document.getElementById('shopping-icon');
    let cartWindow = document.getElementById('cart-window');


    window.addEventListener('click', function (e) {
        if (cart.contains(e.target) && cartWindow.style.display == "none") {
            cartWindow.style.display = "block";
        } else {
            cartWindow.style.display = "none";
        }
    })
}