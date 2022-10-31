const searchPanelButton = document.getElementById("searchPanelButton");
const searchPanel = document.getElementById("searchPanel");
const closeSearchPanelLink = document.getElementById("closeSearchPanelLink");

searchPanelButton.onclick = () => {
    searchPanel.classList.add("isOpen");
}

closeSearchPanelLink.onclick = () => {
    searchPanel.classList.remove("isOpen");
}
