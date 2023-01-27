Testing Sylius resource new architecture
========================================

Development
-----------

#### Build: 

```bash
composer install
docker-compose up -d --build
symfony console doctrine:database:create
symfony console doctrine:migrations:migrate -n
symfony console doctrine:fixtures:load -n
symfony serve -d
```
