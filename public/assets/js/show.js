//Carousel
let container = document.getElementById("productImgs");
let nbrImage = container.querySelectorAll('li').length;
let positionImage = 0;
let left = document.getElementById("left");
let right = document.getElementById("right");
container.style.width = (600 * nbrImage) + "px";

showHidden();

left.onclick = function () {
    if (positionImage > 0)
        positionImage--;
    container.style.transform = "translateX(" + positionImage * -600 + "px)";
    showHidden();
}

right.onclick = function () {
    if (positionImage < nbrImage - 1)
        positionImage++;
    container.style.transform = "translateX(" + positionImage * -600 + "px)";
    showHidden();
}

function showHidden() {
    if (positionImage == 0) {
        left.style.visibility = "hidden";
    } else left.style.visibility = "visible";

    if (positionImage == (nbrImage - 1)) {
        right.style.visibility = "hidden";
    } else right.style.visibility = "visible";
}

//Big Carousel
let bigCarousel = document.getElementsByClassName("productBigCarousel")[0];
let bigContainer = document.getElementById("productBigImgs");
let bigNbrImage = bigContainer.querySelectorAll('li').length;
let bigPositionImage = 0;
let bigLeft = document.getElementById("bigLeft");
let bigRight = document.getElementById("bigRight");
let bigQuit = document.getElementById("quitFullscreen");

container.onclick = function () { showBigCarousel() }//("click", showBigCarousel());

bigQuit.onclick = function () { hideBigCarousel() }

bigContainer.style.width = (100 * nbrImage) + "vw";

bigLeft.onclick = function () {
    if (bigPositionImage > 0)
        bigPositionImage--;
    bigContainer.style.transform = "translateX(" + bigPositionImage * -100 + "vw)";
    bigShowHidden();
}

bigRight.onclick = function () {
    if (bigPositionImage < bigNbrImage - 1)
        bigPositionImage++;
    bigContainer.style.transform = "translateX(" + bigPositionImage * -100 + "vw)";
    bigShowHidden();
}

function bigShowHidden() {
    if (bigPositionImage == 0) {
        bigLeft.style.visibility = "hidden";
    } else bigLeft.style.visibility = "visible";

    if (bigPositionImage == (nbrImage - 1)) {
        bigRight.style.visibility = "hidden";
    } else bigRight.style.visibility = "visible";
}

function showBigCarousel() {
    bigCarousel.style.visibility = "visible";
    bigQuit.style.visibility = "visible";
    bigShowHidden();
    document.body.style.overflow = "hidden";
}

function hideBigCarousel() {
    bigCarousel.style.visibility = "hidden"
    bigLeft.style.visibility = "hidden";
    bigRight.style.visibility = "hidden";
    bigQuit.style.visibility = "hidden";
    document.body.style.overflow = "auto";
}
