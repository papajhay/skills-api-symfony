# Symfony 7 baseline

Classic Symfony 7 web application scaffolded for Twig, Doctrine ORM, and MySQL.

## Stack

- Twig for HTML rendering
- Doctrine ORM for persistence
- Doctrine Migrations for schema changes
- Security bundle for authentication groundwork
- Validator bundle for entity and form validation
- YAML routing and YAML configuration
- No API Platform
- No EasyAdmin

## Folder layout

```text
config/
  doctrine/
  packages/
  routes.yaml
migrations/
public/
src/
  Controller/
  Entity/
  Repository/
templates/
```

## Bootstrap commands

Run these from the project root after installing PHP dependencies:

```bash
composer install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

If you are building the project from scratch instead of using this scaffold:

```bash
composer create-project symfony/skeleton my-project
cd my-project
composer require twig doctrine/doctrine-bundle doctrine/doctrine-migrations-bundle doctrine/orm symfony/security-bundle symfony/validator
composer require --dev symfony/maker-bundle
```

## Useful CLI commands

```bash
php bin/console make:controller HomeController
php bin/console make:entity
php bin/console make:migration
php bin/console doctrine:migrations:migrate
php bin/console debug:router
php bin/console debug:container
```

## Database

Set `DATABASE_URL` in `.env` or `.env.local`:

```dotenv
DATABASE_URL="mysql://app:app@127.0.0.1:3306/app?serverVersion=8.0&charset=utf8mb4"
```
