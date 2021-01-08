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

// DROPDOWN MENU

const dropDownBtn = document.querySelector(".dropbtn");
const dropDownContent = document.querySelector(".dropdown-content-hidden");

dropDownBtn.addEventListener("click", () => {
    if (dropDownContent.className === "dropdown-content-hidden") {
        dropDownContent.classList.add("dropdown-content");
        dropDownContent.classList.remove("dropdown-content-hidden");
    } else {
        dropDownContent.classList.remove("dropdown-content");
        dropDownContent.classList.add("dropdown-content-hidden");
    }
});

const numberOfVotes = document.querySelectorAll(".number-of-votes");
const upvoteButtons = document.querySelectorAll(".upvote-btn");

upvoteButtons.forEach((upvoteBtn) => {
    upvoteBtn.addEventListener("click", (e) => {
        const url = e.currentTarget.dataset.url;
        fetch(`'../../app/posts/upvote.php?id=${url}'`, {
            credentials: "include",
            method: "POST",
        })
            .then(function (res) {
                return res.json();
            })
            .then((upvote) => {
                numberOfVotes.forEach((item) => {
                    if (item.dataset.url == url) {
                        if (upvote == 1) {
                            item.textContent = `${upvote} vote`;
                        } else {
                            item.textContent = `${upvote} votes`;
                        }
                    }
                });
            });
    });
});

upvoteButtons.forEach((upvoteBtn) => {
    upvoteBtn.addEventListener("click", () => {
        upvoteBtn.classList.toggle("upvote-btn-darker");
    });
});
