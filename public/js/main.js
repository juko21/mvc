/**
 * A function to wrap it all in.
 */
(function () {
    "use strict";
    console.log("JavaScript ready.");

    const hamburgerMenu = document.querySelector(".hamburger");
    const hamburgerSpans = document.querySelector(".m_nav").getElementsByTagName("span");
    const dropdown = document.querySelector(".dropdown_menu");

    hamburgerMenu.addEventListener("click", function () {
        hamburgerSpans[0].classList.toggle("m_nav_1st_rotate");
        hamburgerSpans[1].classList.toggle("m_nav_2nd_opacity");
        hamburgerSpans[2].classList.toggle("_nav_3d_rotate");
        dropdown.classList.toggle("dropdown_slide");
    });
}());
