// ********************* switch active
/*
    let switchCat = document.querySelectorAll('.switchCat');
for (let i = 0; i < switchCat.length; i++){
    switchCat[i].addEventListener('change', checked);
}

function checked(e) {
    let catID = e.target.id.replace("switch_","")
}

let req = new Request('getID.php', {
    method: 'POST',
    body: JSON.stringify({id : catID})
})

fetch(req)
    .then(res => res.text())
*/
export function checkboxProducts() {
    
    //affiche ou masque les fenetres en fonction du clic
    window.addEventListener('click', function (e) {
        switch (e.target.id) {
            case "switchProducts":
                window.location.href = "index.php?route=checkboxProducts&id="+e.target.value;
                break;
        }  
    })
}