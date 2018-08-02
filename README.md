# symfony4-notes-app built with Symfony 4.

Simple app created with Symfony 4, HTML5, CSS3, jQuery and MySQL database. 

At the moment user can:
- register,
- log in,
- edit his own notes (content is updated ~~2s after stop typing in textarea of the note, using jQuery and AJAX to send content to Symfony controller),
- share these notes to people, creating unique link (user enters the proposed content of a later address URL like domain.com/my-first-symfony-project: 
user only writes it like normal title "My first Symfony project". Symfony controller and before that jQuery - converts it to URL format.

I implemented a few security features as far as i could with Symfony4 like the user can only edit his own notes only after he is logged in, shared notes are available for everyone just read-only to prevent unwanted changes and otheer.



![1](https://user-images.githubusercontent.com/20010675/43581408-1e550616-9659-11e8-9807-12687430414f.png)
