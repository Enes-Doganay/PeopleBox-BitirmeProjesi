document.addEventListener("DOMContentLoaded", function () {
    // Dropdown menülerini açma işlemini gerçekleştiren JavaScript kodu
    let dropdowns = document.querySelectorAll(".nav-item.dropdown");

    dropdowns.forEach(function (dropdown) {
        dropdown.addEventListener("mouseover", function () {
            let menu = this.querySelector(".dropdown-menu");
            if (menu) {
                menu.classList.add("show");
            }
        });

        dropdown.addEventListener("mouseout", function () {
            let menu = this.querySelector(".dropdown-menu");
            if (menu) {
                menu.classList.remove("show");
            }
        });
    });
});
