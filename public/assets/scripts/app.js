// HAMBURGER MENU
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

// DROPDOWN MENU

const dropDownBtn = document.querySelector(".dropbtn");
const dropDownContent = document.querySelector(".dropdown-content-hidden");

if (dropDownBtn) {
  dropDownBtn.addEventListener("click", () => {
    if (dropDownContent.className === "dropdown-content-hidden") {
      dropDownContent.classList.add("dropdown-content");
      dropDownContent.classList.remove("dropdown-content-hidden");
    } else {
      dropDownContent.classList.remove("dropdown-content");
      dropDownContent.classList.add("dropdown-content-hidden");
    }
  });
}

/// LIKE BUTTON
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

// EDIT-COMMENT-BOX. INVISIBLE BY DEFAULT.
const editCommentBtns = document.querySelectorAll(".edit-comment");
hiddenCommentForm = document.querySelectorAll(".comment-form-hidden");
commentContainer = document.querySelectorAll(".comment-content");

editCommentBtns.forEach((editBtn) => {
  editBtn.addEventListener("click", (e) => {
    const id = e.currentTarget.dataset.id;
    const commentId = e.currentTarget.dataset.commentid;

    hiddenCommentForm.forEach((form) => {
      if (form.dataset.id == id && form.dataset.commentid == commentId) {
        form.style.display = "block";
      }
    });

    commentContainer.forEach((comment) => {
      if (comment.dataset.id == id && comment.dataset.commentid == commentId) {
        comment.style.display = "none";
      }
    });
  });
});

//PREVENT DEFAULT EVENT ON LINKS IN FOOTER
const links = document.querySelectorAll("footer a");

links.forEach((link) => {
  link.addEventListener("click", (e) => {
    e.preventDefault();
  });
});
