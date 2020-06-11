## Code Test


What is included in this repo?
- Completed code
- EER diagram
- Postman file [![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/4eed44d861eb687dbfde)
- Database migrations and seedrs
- basic unit tests
- Installation guide (docker, laravel and database)
- .env files will be emailed to you(if needed)

**if above postman button doesn't work then please let me know**
<https://www.getpostman.com/collections/4eed44d861eb687dbfde>

Installation instructions
1. Clone the repo via this url git@https://github.com/swaami/playback
2. Get inside the project folder and run ``composer update``
3. Create a .env file by running the following command cp .env.example .env. Update your database credentials inside this .env file.
4. Install various packages and dependencies: composer install. Note: you have to be inside your Laravel development environment for this to work. 
5. Run `` docker-compose build && docker-compose up -d`` (please refer to section below if any problem persists)
5. Generate an encryption key for the app: php artisan key:generate.
6. Run migrations and seed database with some sample data: php artisan migrate:refresh --seed.
7. You are now good to go.

##Additional Information: 

The project uses following environment 
- docker -- linux, apache, mysql, nginx, php 7.4
- Laravel 7
- composer

## Composer Libraries
- codesniffer
- goldspecdigital/laravel-eloquent-uuid

##Docker Installation(optional)
- In case, you do not have docker or vagrant installed then follow these steps. If you've working environment then simply ignore docker installation steps and ``docker-compose exec php`` from all command below. 
- Run a docker desktop on your machine
- Goto your development folder and download this code
- Run a docker build command and it should copy all the required images
`` docker-compose build && docker-compose up -d``
- Check if the docker container is running with following command
``docker-compose ps``
- If any issue occurs execute ``docker-compose down -v `` and then once again execute `` docker-compose build && docker-compose up -d``
- if any issue occurs check folder perssions from the docker desktop
- if everything ok then execute ``docker-compose exec php php artisan config:cache``

##composer(already added these packages)
- add code sniffer for psr12 standards checking
``composer require squizlabs/php_codesniffer --dev``
- to check PSR12 standards run ``./vendor/bin/phpcs app/ --standard=PSR12``
- for uuid generation package, please run following command 
``composer require goldspecdigital/laravel-eloquent-uuid:^7.0``

##Create Database
- the database connection details can be found in the .env file at the root folder
- This project uses mysql(for given task) and sqlite(for unit testing). 
- create a user on the mysql by executing following command ``docker-compose exec mysql bash``
- Login to mysql bash here with ``mysql -u root -p``. 
- The password is the word `secret`
- ``create database simplestream;``
- ``GRANT ALL PRIVILEGES ON `simplestream`.* TO 'homestead'@'localhost';``
- ``exit``

##Migrate and seed database
- The factory and migration files are provided along with this repo
- to run the migrations, run 
``docker-compose exec php php artisan migrate``
- Then seed
``    docker-compose exec php php artisan db:seed``

If you face any issue with migrate and seeding then follow these steps
- Rollback 
``docker-compose exec php php artisan migrate:rollback``
``composer dump-autoload``
``docker-compose exec php php artisan migrate:refresh --seed``


##ENDPOINT

>GET /v1/product

>POST /v1/product/:sku/:title

>POST /v1/cart/:sku/:quantity/:userId

>GET /v1/cart/checkout/:userId


# Installation

Install the dependencies and start the server to test the Api.

```sh
$ Composer install
$ php artisan key:generate
$ php artisan migrate
$ php artisan passport:install
$ php artisan db:seed
```
