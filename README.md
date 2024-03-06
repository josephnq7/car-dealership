# Car Dealership Site

## Technical Stack

- PHP 8.x
- Laravel 10.x
- Vue 3.x
- Vite 5.x
- Bootstrap 5
- MySQL


## Setup
- Navigate to the root of project
- Run `cp .env.example .env`
- Fill in the value for `DB_USERNAME=` and `DB_PASSWORD=` in your `.env`
- Run this command to create the database on your MySQL: 
```
CREATE SCHEMA `car_dealership` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
```
- Run `composer install`
- Run `npm install`
- Run `php artisan key:generate`
- Run `php artisan serve`
- Run `npm run dev`
- Run `php artisan initialize-local` : this will fresh your migrations, clear cache, run seeders

## Test
- Run the test suite `php artisan test`
- Note: the test will clean up the database, so if you want to test site after that, please re-run: `php artisan initialize-local`
