var modale = document.getElementById('modale');

// const screenLimit = {
//     right: window.innerWidth,
//     bottom: window.innerHeight
// };

const onMouseMove = (e) =>{
    modale.style.left = e.pageX + 150 + 'px';
    // if (modale.style.left <= 0 || modale.style.left >= screenLimit.right) {
    //     modale.style.left = e.pageX - 300 + 'px';
    // }
    modale.style.top = e.pageY + 150 + 'px';
    // if (modale.style.top <= 0 || modale.style.top >= screenLimit.bottom) {
    //     modale.style.left = e.pageX - 300 + 'px';
    // }
}


var canvas = document.createElement('canvas');

window.addEventListener('DOMContentLoaded', function () {
    if (modale != null) {
        document.addEventListener('mousemove', onMouseMove)
    }
})
