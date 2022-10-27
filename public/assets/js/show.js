let container = document.getElementById("productImgs");
let nbrImage = container.querySelectorAll('li').length;
let positionImage = 0;
let left = document.getElementById("left");
let right = document.getElementById("right");
container.style.width = (500 * nbrImage) + "px";

showHidden();

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

console.log(right);

function showHidden() {
    if (positionImage == 0) {
        left.style.visibility = "hidden";
    } else left.style.visibility = "visible";

    if (positionImage == (nbrImage - 1)) {
        right.style.visibility = "hidden";
    } else right.style.visibility = "visible";
}
