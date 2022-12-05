# Laravel Backend Coding Simulation


### Getting Started

Setup your working environment by executing the following commands:

```
cd <trax repo directory>
docker-compose build
docker-compose up
docker exec -it trax_php_1 composer install
docker exec -it trax_php_1 npm install
docker exec -it trax_php_1 npm install -g npm@9.1.3      *if you have problem with "...npm install" and "...npm run dev"
docker exec -it trax_php_1 npm run dev 
docker exec -it trax_php_1 php artisan migrate

docker exec -it trax_php_1 php artisan db:seed --class=DatabaseSeeder
```