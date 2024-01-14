require('./bootstrap');
document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebar");
    const toggleButton = document.getElementById("toggleSidebar");

    toggleButton.addEventListener("click", function () {
        const isOpen = sidebar.style.left === "0px";
        sidebar.style.left = isOpen ? "-80px" : "0";
        document.body.classList.toggle("translate-x-80", !isOpen);
    });
});
