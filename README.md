## Technical test for a simple web service written in Laravel.

### Description
The goal of this assignment is to create a simple web service that will handle articles and their related comments, as well as send the articles to at least one external service.

---

### Set up
```
1. git clone git@github.com:geobas/elearning_industry_assignment.git elearning_industry_assignment
2. docker-compose up -d && docker exec -it elearning-industry-app bash
3. composer install
4. composer run-script post-root-package-install
5. Modify the generated .env accordingly to .docker/mysql/.env
6. ./artisan migrate --seed
7. Go to http://localhost:8080
```

### Postman collection
* A collection of all endpoints is available [here](https://www.getpostman.com/collections/c16dcee27323e69c3695)
* Create a new Environment and set a 'domain' variable with value http://localhost:8080

### Execute tests
```
composer test
```
