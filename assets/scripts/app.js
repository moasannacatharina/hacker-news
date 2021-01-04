console.log("Hello World");

// const editPostBtns = document.querySelectorAll(".edit-post");
// const editForms = document.querySelectorAll(".edit-invisible");
// const listItems = document.querySelectorAll(".submitted-post");

// listItems.forEach((listItem) => {
//   editPostBtns.forEach((editPostBtn) => {
//     editForms.forEach((editForm) => {
//       editPostBtn.addEventListener("click", () => {
//         editForm.style.display = "block";
//         listItem.style.display = "none";
//       });
//     });
//   });
// });

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

// body.addEventListener("click", (e) => {
//   const targetIsMenu = e.target.className.match("menu-list");

//   if (!targetIsMenu) {
//     menuBoxOpen = false;
//     menuContainer.style.display = "none";
//   }
// });

const newBtn = document.querySelector(".new-btn");
const mostLikedBtn = document.querySelector(".most-liked-btn");

newBtn.addEventListener("click", () => {
    newBtn.classList.add("active");
    mostLikedBtn.classList.remove("active");
});
mostLikedBtn.addEventListener("click", () => {
    newBtn.classList.remove("active");
    mostLikedBtn.classList.add("active");
});

// const upvoteBtn = document.querySelector(".upvote-btn");
// const count = document.querySelector(".count");
// let index = 0;

// upvoteBtn.addEventListener("click", () => {
//     index++;
//     count.textContent = index;
// });
