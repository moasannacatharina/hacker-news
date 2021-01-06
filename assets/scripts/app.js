console.log("Hello World");

// Hamburger menu
const menuBtn = document.querySelector(".menu-btn");
const menuContainer = document.querySelector(".menu-list");
const closeBtn = document.querySelector(".close-btn");
const body = document.querySelector("body");
let menuBoxOpen = false;

menuBtn.addEventListener("click", () => {
    menuContainer.style.display = "flex";
    menuContainer.style.animation = "smooth 0.2s linear";
    menuBtn.style.display = "none";
});

closeBtn.addEventListener("click", () => {
    menuContainer.style.display = "none";
    menuBtn.style.display = "block";
});

// // Adding active state to NEW button and MOST LIKED button on index-page
// const newBtn = document.querySelector(".new-btn");
// const mostLikedBtn = document.querySelector(".most-liked-btn");

// newBtn.addEventListener("click", () => {
//     newBtn.classList.add("active");
//     mostLikedBtn.classList.remove("active");
// });
// mostLikedBtn.addEventListener("click", () => {
//     newBtn.classList.remove("active");
//     mostLikedBtn.classList.add("active");
// });
