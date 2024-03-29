## Technical test for a simple web service written in Laravel [![CI](https://github.com/geobas/laravel-web-service-assignment/actions/workflows/ci.yaml/badge.svg)](https://github.com/geobas/laravel-web-service-assignment/actions/workflows/ci.yaml)

### Description
The goal of this assignment is to create a simple web service that will handle articles and their related comments, as well as send the articles to at least one external service.

---

### Set up
```
1. git clone git@github.com:geobas/laravel-web-service-assignment.git
2. docker-compose up -d && docker exec -it laravel-web-service-app bash
3. composer install
4. composer run-script post-root-package-install
5. Modify the generated .env accordingly to .docker/mysql/.env
6. ./artisan migrate --seed
7. Go to http://localhost:8080
```

### Postman collection
* A collection of all endpoints is available [here](https://api.postman.com/collections/18571919-7528ebdc-7125-473b-8866-beeab031ac2a?access_key=PMAT-01GNZ86K9ENKRA9Y4H8MBYWD7P)
* Create a new Environment and set a 'domain' variable with value http://localhost:8080

### Execute tests
```
composer test
```
