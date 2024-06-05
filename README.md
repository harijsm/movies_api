# movies_api

```
    docker-compose up
```

.env izmaiņas, lai pieslēgtos db:

```
    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=root
```

migrācijas:

```
docker exec php_laravel php artisan migrate
```

http://127.0.0.1:7007