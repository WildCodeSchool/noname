//Carousel
const container = document.getElementById("productImgs");
const nbrImage = container.querySelectorAll('li').length;
let positionImage = 0;
const left = document.getElementById("left");
const right = document.getElementById("right");
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
const bigCarousel = document.getElementsByClassName("productBigCarousel")[0];
const bigContainer = document.getElementById("productBigImgs");
const bigNbrImage = bigContainer.querySelectorAll('li').length;
let bigPositionImage = 0;
const bigLeft = document.getElementById("bigLeft");
const bigRight = document.getElementById("bigRight");
const bigQuit = document.getElementById("quitFullscreen");

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
