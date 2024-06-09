# movies_api

```
    docker-compose up
```

nokopēt ```.env.example``` un pārsaukt par ```.env```

.env faila izmaiņas, lai pieslēgtos db:

```
    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=root
```

Instalēt dependencies

```
docker exec php_laravel composer install
```

migrācijas (noņemt ```--seed```, ja nav nepieviešami test dati):

```
docker exec php_laravel php artisan migrate --seed
```

Base URL:
```
http://127.0.0.1:7007/api/
```

API pieprasījumu kolekcija Postman failā:
```
movie_api.postman_collection.json
```

kā pirmo uztaisīt pieprasījumu ```User login``` (POST uz http://127.0.0.1:7007/api/login)
lai Postman saglabā autorizācijas tokenu, kurš tiks izmantots API gala pieprasījumiem (create / destroy) kam nepieciešama autorizācija.