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

// DROPDOWN MENU IN NAV

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

if (upvoteButtons) {
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
}

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

// EDIT REPLY-BOX

const editReplyBtns = document.querySelectorAll(".edit-reply");
const editHiddenReplyForm = document.querySelectorAll(
  ".edit-reply-form-hidden"
);
const replyContainer = document.querySelectorAll(".reply-content");

editReplyBtns.forEach((editBtn) => {
  editBtn.addEventListener("click", (e) => {
    const id = e.currentTarget.dataset.id;

    editHiddenReplyForm.forEach((form) => {
      if (form.dataset.id == id) {
        form.style.display = "block";
      }
    });

    replyContainer.forEach((comment) => {
      if (comment.dataset.id == id) {
        comment.style.display = "none";
      }
    });
  });
});

// REPLY BUTTON

const replyBtns = document.querySelectorAll(".reply-btn");
const hiddenReplyForm = document.querySelectorAll(".reply-form-hidden");

replyBtns.forEach((replyBtn) => {
  replyBtn.addEventListener("click", (e) => {
    console.log(replyBtn);
    const id = e.currentTarget.dataset.id;

    hiddenReplyForm.forEach((form) => {
      if (form.dataset.id == id) {
        form.style.display = "block";
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

// IDAS
/// LIKE COMMENT BUTTON
const numberOfCommentVotes = document.querySelectorAll(
  ".number-of-comment-votes"
);
const upvoteCommentButtons = document.querySelectorAll(".upvote-comment-btn");

if (upvoteCommentButtons) {
  upvoteCommentButtons.forEach((upvoteCommentBtn) => {
    upvoteCommentBtn.addEventListener("click", (e) => {
      const url = e.currentTarget.dataset.url;
      fetch(`'../../app/comments/comments-upvotes.php?id=${url}'`, {
        credentials: "include",
        method: "POST",
      })
        .then(function (res) {
          return res.json();
        })
        .then((commentsUpvotes) => {
          numberOfCommentVotes.forEach((item) => {
            if (item.dataset.url == url) {
              if (commentsUpvotes == 1) {
                item.textContent = `${commentsUpvotes} vote`;
              } else {
                item.textContent = `${commentsUpvotes} votes`;
              }
            }
          });
        });
    });
  });
}

upvoteCommentButtons.forEach((upvoteCommentBtn) => {
  upvoteCommentBtn.addEventListener("click", () => {
    upvoteCommentBtn.classList.toggle("upvote-comment-btn-darker");
  });
});
