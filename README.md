

# Achievements & Badge Earning

## Requirements

- PHP >= 7.3
- Laravel 8
- Database: MySql( 8.0.28), MariaDB(10.4.22) (will run with lower versions as well)
- Composer 2

## Environment Setup

- Go to root directory and rename `.env.example` to `.env`
- Run `composer install`.
- In the `.env` file change the database connection info
```
    DB_CONNECTION=mysql 
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=database_name
    DB_USERNAME=user_name
    DB_PASSWORD=passwrd
```
- Run migration `php artisan migrate` for migrating the database tables with static data
- Then serve `php artisan serve` or `php artisan serve --port=9000`

## Run Test

- run `php artisan test` from root directory to run the tests


