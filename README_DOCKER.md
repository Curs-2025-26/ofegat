# Quickstart amb Docker

## 1) Al directori arrel (aquest), arranca serveis
```bash
docker compose up -d --build
```

## 2) Instal·la dependències al contenidor PHP
```bash
docker compose exec php composer install
```

## 3) Executa proves i autoavaluació
```bash
docker compose exec php composer test
docker compose exec php composer grade:e1   # o e2/e3
docker compose exec php composer stan
docker compose exec php composer lint
```

## 4) Navega
- Obri http://localhost/  (Nginx serveix /var/www/php/public)

**Nota:** el projecte està dins de `./php`, que es munta a `/var/www/php`.  
El Nginx apunta a `/var/www/php/public` i PHP-FPM està a `php:9000