# FitLife

An application that provides health and sports services nutritious with a database designed by specialists in the field of nutrition and sports and designed to follow the performance of athletes and provide resistance exercise schedules according to preference using artificial intelligence and machine learning


## Prerequisites

If you don't already have an Apache local environment with PHP and MySQL, use one of the following links:

- Windows: https://updivision.com/blog/post/beginner-s-guide-to-setting-up-your-local-development-environment-on-windows
- Linux: https://howtoubuntu.org/how-to-install-lamp-on-ubuntu
- Mac: https://wpshout.com/quick-guides/how-to-install-mamp-on-your-mac/
- GD Library (>=2.0)
- Imagick PHP extension (>=6.5.7)

Also, you will need to install Composer: https://getcomposer.org/doc/00-intro.md   

# Dependencies

- [PHP](https://www.php.net/) - PHP v8.0.2

- [Laravel V8](https://laravel.com/)

- Composer is an application-level dependency manager for the PHP programming language that provides a standard format for managing dependencies of PHP software and required libraries.

- MySQl Database / SQL Server

- Boostrap v5
- Jquery

## Dev Dependencies

- [PEST](https://pestphp.com/) An elegant php testing framework

- Run the following commands :-
    - `composer require pestphp/pest --dev --with-all-dependencies`
    - `composer require pestphp/pest-plugin-laravel --dev`
    - `php artisan pest:install`
    
# Local Installation

- Go to Cloned directory :-
       ```cd fitlife```
- Create new a file .env in the root directory.
- Copy all content in the .env-example and paste into .env you just created in the previous step.
- create a database and add your database name in the DB_DATABASE value in the .env file.
- Run the following commands :
  - `composer install`
  - `php artisan migrate --seed`
  - `php artisan serve`
    
# Unit & Feature testing (Backend)

In the root directory Follow these steps to run the tests.

1. You will need to create a .env.testing file in root directory.
2. Create new a database & set the new database configuration in the .env.testing file
3. run `php artisan test`
