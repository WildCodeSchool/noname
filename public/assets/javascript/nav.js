// Burger button
function myFunction(x) {
    x.classList.toggle("change");
}

/* Search disappear
const searchBox = document.querySelector("search-box");
const burgerClick = document.querySelector("container");


//window.onload = function () {
burgerClick.onclick = function myFunction() {
    if (searchBox.style.visibility !== "none") {
        searchBox.style.visibility = "none";
    } else {
        searchBox.style.visibility = "hidden";
    }
};
//}; */

function searchHide() {

    var x = document.getElementById("search")
    if (x.style.visibility === "hidden") {
        x.style.visibility = "visible";
    } else {
        x.style.visibility = "hidden";
    }

    var x = document.getElementById("icons")
    if (x.style.visibility === "visible") {
        x.style.visibility = "hidden";
    } else {
        x.style.visibility = "visible";
    }

}