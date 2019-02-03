# OAT Technical exercise - User API

## install dependencies
* PHP 7.2
* Slim 3.1
* php-di 2.0
* Symfony Serializer 4.2

```
$ composer install
```

## Openapi

You can find the api definition/contract in [openapi/openapi.yml](openapi/openapi.yml)


## Data source Available
- [CSV](dataSource/Csv/testtakers.csv)
- [JSON](dataSource/Json/testtakers.json)

You can change the data source by modifying the [settings](config/settings.php)

Because each action related to a User use the [UserRepositoryInterface](src/Repository/User/UserRepositoryInterface.php)  
You can easily replace a Json implementation with a mysql one that implement the **UserRepositoryInterface**


## Run application
```
$ docker-compose up -d
```
```
$ composer start
```
## Tests

Run tests
```
$ vendor/bin/phpunit
```