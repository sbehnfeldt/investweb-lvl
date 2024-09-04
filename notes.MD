# InvestWeb (Laravel) Developer Notes

## Scaffolding
```shell
$> composer global require laravel/installer
$> laravel --version
$> composer create-project laravel/laravel investweb-lvl
$> cd investweb-lvl
$> git init .
$> git remote add origin https://github.com/sbehnfeldt/investweb-lvl.git
$> composer install
$> npm i
```

## Dev Env

Set up a new dev environment as follows:

* Edit the (working) .env file: `DB_CONNECTION=sqlite`
* Manually create a file called _database.sqlite_ in the _database_ directory
* Run migrations and seed the database: `php artisan migrate:fresh --seed`

This will create a single user in the `users` table with user ID `test@example.com` and password `password`,
which will be useful after the `Breeze` starter kit is installed

Launch the vite service and Laravel's development web server:

```shell
npm run dev
php artisan serve
```

## Node-sass

Installation:

```shell
npm i -D node-sass
```

Add appropriate scripts to package.json:

```json
{
    "scripts": {
        "sass:compile": "node-sass resources/sass/main.scss public/style.css",
        "sass:watch": "node-sass resources/sass/main.scss public/style.css -w"
    }
}
```

## Breeze

Install Laravel's Breeze authentication starter kit:

```
composer require laravel/breeze --dev
php artisan breeze:install
```

## `Fund` Model

Generate the `Fund` model and all other associated classes:

```php
php artisan make:model -a Fund
```

Makes 8 files: Migration, model, controller, factory, seeder, policy, and store and update requests

- Edit the migration
- Define the Fund seeding in `FundFactory::definition()`
- Update `DatabaseSeeder::run()` to include the Fund seeding
- php artisan migrate:fresh --seed

Generate a controller for the fund API:

```php
php artisan make:controller Api/FundController --api
```

## `Transaction` Model

```php
php artisan make:model -a Transaction
```

Move TransactionController to Pages directory and namespace.