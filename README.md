# SecretAlpha 

See screenshots at the bottom.

The code for the Secret Republic hacker simulation role playing game.

Futuristic UI. Mission designer. Audio AI voice speaks when interacting with the game.

A lot of work has gone into this but it is not a documented (as of yet) project.

It's been through years of development with this being its 3rd full do-over.

However, the project on stand-by so I've decided to make the source available of nothing else

Read more about the history of the game and the more complete older version in the works for open sourcing @ https://medium.com/@adrian.n/secret-republic-open-sourced-hacker-simulation-futuristic-rpg-browser-based-game-php-843d393cb9d7

# Setting up

You can go with a light LAMP setup. Install MAMP (https://www.mamp.info/en/) for windows, WAMP (http://www.wampserver.com/en/) for Mac.

Import db.sql into a fresh MySQL db.

Copy fuel/app/config/db.template into fuel/app/config/config.php and configure it if you want.

Copy fuel/app/config/config.template into fuel/app/config/db.php and add your DB details.

Copy fuel/app/config/email.template into fuel/app/config/email.php and configure it if you want to setup email sending.

Run 'composer install' and 'composer update' (more info about composer: https://getcomposer.org/)

Create an account through the signup form and set your group to 2 in the database in order to become a Cardinal (admin).

# Cron jobs

You may want to setup tasks to run the following code once in a while

your-url/cron/rankings

your-url/cron/emails

e.g.

*/2 * * * * wget -O - http://localhost/cron/emails >/dev/null 2>&1

https://en.wikipedia.org/wiki/Cron

# License

Released under public common MIT license. Please credit and contribute back!

# Screenshots

![Screenshot](images/1.png)

![Screenshot](images/2.png)

![Screenshot](images/3.png)

![Screenshot](images/4.png)

![Screenshot](images/5.png)

![Screenshot](images/6.png)

![Screenshot](images/7.png)

![Screenshot](images/8.png)

![Screenshot](images/9.png)

![Screenshot](images/19.png)

![Screenshot](images/11.png)

![Screenshot](images/12.png)

# Travelling through time

![Screenshot](images/v21.png)

![Screenshot](images/v22.png)

![Screenshot](images/original1.png)

![Screenshot](images/original2.png)
