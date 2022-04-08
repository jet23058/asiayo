# Jet AsiaYo 考題

## Setup

### Prerequisites
 - PHP >= 7.4.0
 - Laravel >= 8.0
 - MySQL >= 8.0

### Installations

    # 安裝 composer 套件
    $ composer install

    # 複製環境檔
    $ cp .env.example .env

    # 建立環境 local key
    $ php artisan key:generate
    
    # 開啟 passport
    $ php artisan passport:install

### Docker

    # 安裝 laradock
    $ git clone https://github.com/laradock/laradock.git

    $ vi .env
    change 
        PHP_VERSION=7.4
        WORKSPACE_INSTALL_MONGO=true
        PHP_FPM_INSTALL_MONGO=true
        LARAVEL_HORIZON_INSTALL_MONGO=true

    # 啟用 laradock
    $ docker-compose up -d workspace php-fpm nginx mongo mysql

### Migrations

    $ php artisan migrate

### Seeds

    $ php artisan db:seed

### Testing

    $ php artisan test 

or

    $ ./vendor/bin/phpunit

### Document

    $ php artisan apidoc:generate
    
