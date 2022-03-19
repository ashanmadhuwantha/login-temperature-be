# login-temperature-be
 back end of login temperature web application


# instructions on how to set up, configure and run the project

1.clone the project from GitHub
2.run in terminal composer install
3.run in terminal npm install
4.create database and change the .env DB_DATABASE=../database/database.sqlite
4.run in terminal php artisan migrate (If you are a macOS user please run migrations by changing .env DB_DATABASE=database/database.sqlite. after migration done change it to DB_DATABASE=../database/database.sqlite)
5.run in terminal php artisan serve


used Laravel passport library (Laravel Passport is a package used to implement authentication in a Laravel REST API).
