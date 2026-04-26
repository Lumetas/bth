По развёртке:
```
git clone https://github.com/lumetas/bth.git
cd bth
cp .env.example .env
npm install
composer install
php artisan key:generate
docker-compose up -d
docker-compose exec app php artisan migrate --seed
```
Так же если host отличается от localhost:8000 необходимо добавить в файле .env в строку SANCTUM_STATEFUL_DOMAINS

