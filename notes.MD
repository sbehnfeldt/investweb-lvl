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
$> npm i -D node-sass
$> php artisan make:model -cfm MutualFund  
```
## Run Dev Env
```shell
npm run sass:compile
npm run sass:watch
npm run dev
php artisan serve
```

## New Model
Generate the Post model and all other associated classes:

```php
php artisan make:model -a MutualFund
```

- Edit the migration
- Run the migration `php artisan migrate`
- Define the MutualFund seeding in `MutualFundFactory::definition()`
- Update `DatabaseSeeder::run()` to include the MutualFund seeding
- php artisan migrate:fresh --seed

## Breeze

```
composer require laravel/breeze --dev
php artisan breeze:install
```