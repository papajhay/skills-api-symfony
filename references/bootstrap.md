# Bootstrap

Symfony 7 API application with API Platform, Doctrine ORM, MySQL, JWT auth, and YAML-based API metadata.

## Packages

- `api-platform/core`
- `lexik/jwt-authentication-bundle`
- `gesdinet/jwt-refresh-token-bundle`
- `nelmio/cors-bundle`
- `vich/uploader-bundle`

## Commands

```bash
composer install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console lexik:jwt:generate-keypair
```
