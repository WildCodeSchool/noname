
document.getElementById('add').onclick = remplace_click
document.getElementById('add2').onclick = remplace_click


function fAddInput(contenu, name) {
    const color_picker = document.createElement("input");
    color_picker.classList.add("palette");
    color_picker.setAttribute("type", "color");
    color_picker.setAttribute("name", name);
    contenu.appendChild(color_picker);
}

function delete_element(target) {
    const parent = target.parentNode;
    parent.removeChild(target);
}

function remplace_click(event) {
    const parent = event.target.parentNode;
    delete_element(event.target);
    fAddInput(parent, parent.id);
}
