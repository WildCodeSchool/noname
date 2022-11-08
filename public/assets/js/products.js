const searchPanelButton = document.getElementById("searchPanelButton");
const searchPanel = document.getElementById("searchPanel");
const closeSearchPanelButton = document.getElementById("closeSearchPanelButton");

searchPanelButton.onclick = () => {
    searchPanel.classList.add("isOpen");
}

closeSearchPanelButton.onclick = () => {
    searchPanel.classList.remove("isOpen");
}
