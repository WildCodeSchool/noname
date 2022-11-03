
document.getElementById('add').onclick = remplace_click
document.getElementById('add2').onclick = remplace_click



function fAddInputColor(contenu, name) {
    const element_create = document.createElement("input");
    element_create.classList.add("palette");
    element_create.setAttribute("type", "color");
    element_create.setAttribute("name", name);
    contenu.appendChild(element_create);
}

function delete_element(target) {
    const parent = target.parentNode;
    parent.removeChild(target);
}

function remplace_click(event) {
    const parent = event.target.parentNode;
    delete_element(event.target);
    fAddInputColor(parent, parent.id);
}

