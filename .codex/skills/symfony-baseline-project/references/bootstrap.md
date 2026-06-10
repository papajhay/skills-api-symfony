# Symfony Baseline Bootstrap

This skill describes a classic Symfony 7 web app:

- Twig for HTML rendering
- Doctrine ORM for persistence
- MySQL as the database
- YAML for configuration and routing
- No API Platform
- No EasyAdmin

## Baseline package set

Install the standard web dependencies for a classic Symfony site:

- `symfony/twig-bundle`
- `doctrine/doctrine-bundle`
- `doctrine/doctrine-migrations-bundle`
- `doctrine/orm`
- `symfony/security-bundle`
- `symfony/validator`
- Symfony Maker where development scaffolding is needed

Add other bundles only when the user explicitly needs them.

## Expected structure

Use the usual Symfony folders and keep them present even in small projects:

```text
config/
  packages/
  routes/
migrations/
src/
  Controller/
  Entity/
  Repository/
templates/
public/
```

If the project grows, keep new code in the same Symfony-native places rather than inventing new top-level layers.

## YAML configuration files

Prefer these files for a baseline web project:

- `config/packages/framework.yaml`
- `config/packages/twig.yaml`
- `config/packages/doctrine.yaml`
- `config/packages/doctrine_migrations.yaml`
- `config/packages/security.yaml`
- `config/packages/validator.yaml`
- `config/packages/routing.yaml`
- `config/services.yaml`
- `config/routes.yaml`

## Doctrine and MySQL

Use environment variables for the database connection, then map them into Doctrine:

```dotenv
DATABASE_URL="mysql://app:app@127.0.0.1:3306/app?serverVersion=8.0&charset=utf8mb4"
```

Keep entity mapping in `src/Entity/` and generate schema changes through migrations.

## Web flow

For a basic page:

1. Add a controller in `src/Controller/`.
2. Add or update a YAML route in `config/routes.yaml` or a file under `config/routes/`.
3. Render a Twig template from `templates/`.
4. Move any non-trivial logic into a service in `src/`.

## Guardrails

- Do not create API resource YAML, API Platform routes, or serializer metadata.
- Do not create EasyAdmin controllers or routes.
- Do not switch to JSON-first responses unless the user explicitly asks for an API.
- Do not replace YAML configuration with PHP config when a YAML file already fits the need.
