// memuat navigasi dan footer ke setiap halaman 

function loadComponent(file, elementId) {
    fetch(file)
        .then(response => response.text())
        .then(data => {
            document.getElementById(elementId).innerHTML = data;
        });
}

document.addEventListener("DOMContentLoaded", function () {
    loadComponent("nav.html", "nav-placeholder");
    loadComponent("footer.html", "footer-placeholder");
});
