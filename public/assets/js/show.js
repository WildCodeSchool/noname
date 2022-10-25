let nbrImage = 3;
positionImage = 0;

showHidden();

container = document.getElementById("product_imgs");
left = document.getElementById("left");
right = document.getElementById("right");
container.style.width = (500 * nbrImage) + "px";

for (i = 1; i <= nbrImage; i++) {
    div = document.createElement("div");
    div.className = "photo";
    div.style.backgroundImage = "url('image" + i + ".jpg')";//images avec le même nom mais numérotées
    container.appendChild(div);
}


left.onclick = function () {
    if (positionImage > 0)
        positionImage--;
    container.style.transform = "translateX(" + positionImage * -500 + "px)";
    showHidden();
}

right.onclick = function () {
    if (positionImage < nbrImage - 1)
        positionImage++;
    container.style.transform = "translateX(" + positionImage * -500 + "px)";
    showHidden();
}

function showHidden() {
    if (positionImage == 0)
        left.style.visibility = "hidden";
    else left.style.visibility = "visible";

    if (positionImage == (nbrImage - 1))
        right.style.visibility = "hidden";
    else right.style.visibility = "visible";
}
