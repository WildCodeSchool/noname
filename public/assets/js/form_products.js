function fAddInput1() {
    let contenu = document.getElementById('color');
    let color_picker2 = document.createElement("input");
    color_picker2.classList.add("palette");
    color_picker2.setAttribute("type", "color");
    color_picker2.setAttribute("name", "palette2");
    contenu.appendChild(color_picker2);
    let contenu2 = document.getElementById('add');
    contenu2.parentNode.removeChild(contenu2);
    // contenu2 = document.getElementById("add").style.display = "none";

}

function fAddInput2() {
    let contenu = document.getElementById('color');
    let color_picker2 = document.createElement("input");
    color_picker2.classList.add("palette");
    color_picker2.setAttribute("type", "color");
    color_picker2.setAttribute("name", "palette3");
    contenu.appendChild(color_picker2);
    let contenu2 = document.getElementById('add2');
    contenu2.parentNode.removeChild(contenu2);
}

function delete_click() {
    let delete_click = document.getElementById("palette2");
    delete_click.parentNode.removeChild(delete_click);
}

function delete_click2() {
    let delete_click = document.getElementById("palette3");
    delete_click.parentNode.removeChild(delete_click);
}