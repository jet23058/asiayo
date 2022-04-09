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

### Migrations

    $ php artisan migrate

### Testing

    $ php artisan test 

or

    $ ./vendor/bin/phpunit

### Document

    $ php artisan apidoc:generate
    
view: http://localhost:8020/docs/index.html
    
