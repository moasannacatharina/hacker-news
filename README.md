# Hacker News

<img src="https://media.giphy.com/media/LcfBYS8BKhCvK/giphy.gif" width="100%">

## 👀 About

This is an individual assignment in PHP. Our class has created our own brand new version of the site [Hacker News](https://news.ycombinator.com/news).

<details><summary>User stories included in the project</summary>

- As a user I should be able to create an account.
- As a user I should be able to login.
- As a user I should be able to logout.
- As a user I should be able to edit my account email, password and biography.
- As a user I should be able to upload a profile avatar image.
- As a user I should be able to create new posts with title, link and description.
- As a user I should be able to edit my posts.
- As a user I should be able to delete my posts.
- As a user I'm able to view most upvoted posts.
- As a user I'm able to view new posts.
- As a user I should be able to upvote posts.
- As a user I should be able to remove upvote from posts.
- As a user I'm able to comment on a post.
- As a user I'm able to edit my comments.
- As a user I'm able to delete my comments.

</details>

<details><summary> Requirements </summary>

- The application should be written in HTML, CSS, JavaScript, SQL and PHP.
- The application should be built using a SQLite database with at least four different tables.
- The application should be pushed to a public repository on [GitHub](https://github.com/).
- The application should be responsive and be built using the method mobile-first.
- The application should be implement secure [hashed passwords](https://secure.php.net/manual/en/function.password-hash.php) when signing up. <br>
- The project should contain the files and directories in the [`resources`](resources) folder in the root of your repository. <br>
- The project should implement an [accessible](https://a11yproject.com/checklist/) [graphical user interface](https://en.m.wikipedia.org/wiki/Graphical_user_interface).
- The project should [declare strict types](https://php.net/manual/en/functions.arguments.php#functions.arguments.type-declaration.strict) in files containing only PHP code.
- The project should not include any coding errors, warning or notices.
- The project must be tested on at least two of your classmates computers. Add the testers name to the `README.md` file.
- The project must receive a [code review](https://en.m.wikipedia.org/wiki/Code_review) by another student. Add at least 10 comments to the student's `README.md` file through a [pull request](https://help.github.com/en/articles/creating-a-pull-request). Give feedback to the student below your name. The last student gives feedback to the first student in the list. Add your feedback one day before the presentation.

</details>

## 🥳 Extra features

- Delete your account along with all your posts, user info, upvotes and comments.
- Reply to comments.
- Be able to upvote comments. Link to pull request [here](https://github.com/moasannacatharina/hacker-news/pull/3).
- Be able to reset your password with email. Used with [PHPMail](https://github.com/PHPMailer/PHPMailer). Link to pull request [here](https://github.com/moasannacatharina/hacker-news/pull/4).

## 💌 Instructions

1. Clone or fork this repository to your computer.
2. Navigate to the project's `public` directory in your terminal.
3. Start a localhost-server: `php -S localhost: 8000`
4. Open [localhost:8000](http://localhost:8000) in your browser of choice.

## 💪 Built with

- PHP
- SQL
- Javascript
- CSS
- HTML

## 👩‍💻 Tested by

- [Amanda Fager](https://github.com/amandafager)
- [Dante Mogrim](https://github.com/mogrim-91)

## 🍭 Code Review

**Comments by Jon McGarvie**

- `PHP Warning: Undefined array key "id"` in multiple places. Find in console.
- When you first enter the website it signs you in as an empty user, which means you can't see the login button until you log out.
- On `index.php:5` you can do `SELECT posts.*, users.email ...` to select everything from posts (and of course users.email).
- On the post feed you should have the url next to the title so you don't go in completely blind.
- Good solution for the upvotes, as you don't have to reload the site in order to upvote.
- You should make it so that when you make a post it redirects you to that specific post.
- Good error messages.
- After you register or login a user you should unset the password variables so that they cannot be accessed.
- Good icons for editing and deleting comments.
- Don't really get why the profile picture is visable on posts.

## To Do

- Fix error that signs you in as an empty user when you first open the site. At the moment, a workaround is to go to /app/users/logout.php in the browser which signs you out.
- Fix lint issues
- Figure out why the prepare-statement doesn't work in password-reset.php.

## 🎈Created by

- [Moa Berg](https://github.com/moasannacatharina)
- Licensed under [MIT](https://github.com/moasannacatharina/fake-news/blob/main/LICENSE)
