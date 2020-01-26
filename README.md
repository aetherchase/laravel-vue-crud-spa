# Одностраничное веб-приложение, реализующее каталог товаров.

# Установка:

```
git clone https://github.com/aetherchase/laravel-vue-crud-spa.git
cd laravel-vue-crud-spa
composer install
npm install
cp .env.example .env
php artisan key:generate
```
Затем создайте базу данных в папке database и настройте `.env` файл. После запустите миграцию
```
php artisan migrate
```

# Запуск:
в папке проекта

```
php artisan serve
```
