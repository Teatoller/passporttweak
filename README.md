# Passport API Authentication

1. Create a folder on your machine `mkdir myproject`
2. `cd myproject`
3. Run `git clone https://github.com/Teatoller/passporttweak.git`
4. cd `passporttweak`
5. open **passporttweak** in your chosen editor. For **vscode** enter `code .` on terminal and press enter.
6. `git checkout develop`
7. create database in mysql name **tweak** and through the .env file connect to your local mysql database. Use the .env.example file as a guide.
8. Run `composer install`
9. Run `php artisan migrate`
10. Run `php artisan passport:install`
11. Run `php artisan serve`.

12. Endpoints to use on **POSTMAN**

Base url: http://localhost:8000/api/

| # | Endpoint                   |                              |
|---|----------------------------|------------------------------|
| 1 | register                   | to register user             |
| 2 | verification/verify/{user} | to confirm registration      |
| 3 | verification/resend        | to resend verification email |
| 4 | login                      | to login user                |
| 5 | password/email             | to request password reset    |
| 6 | reset                      | to reset password            |
| 7 | me                         | to get user profile          |