document.getElementById('add').onclick = replace_click
document.getElementById('add2').onclick = replace_click

let colorNameId = 1;

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

function replace_click(event) {
    const parent = event.target.parentNode;
    delete_element(event.target);
    fAddInputColor(parent, "palette[" + colorNameId + "]");
    colorNameId++;
}
