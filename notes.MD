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