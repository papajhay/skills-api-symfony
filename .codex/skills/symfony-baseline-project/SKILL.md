---
name: symfony-baseline-project
description: Generate a classic Symfony 7 web project with Twig, Doctrine ORM, MySQL, and YAML-only configuration. Use when bootstrapping or updating a standard Symfony site without API Platform or EasyAdmin.
---

# Symfony Baseline Project

Use this skill for a conventional Symfony 7 web application built around Twig, Doctrine ORM, and MySQL.

## Workflow

1. Start from the Symfony webapp baseline or the closest equivalent project skeleton.
2. Keep project configuration in YAML wherever Symfony supports it.
3. Use the standard folders: `src/Controller/`, `src/Entity/`, `templates/`, `migrations/`, `config/packages/`, and `config/routes/`.
4. Install and configure the minimal web stack: Twig, Doctrine ORM, Doctrine Migrations, Validator, Security, and the Symfony tooling needed for local development.
5. Configure MySQL through environment variables and `config/packages/doctrine.yaml`.
6. Build pages with controllers and Twig templates, not API resources or admin generators.
7. Use Doctrine migrations for schema changes and keep entities/repositories under `src/`.

## Project Rules

- Prefer YAML routing and service configuration.
- Keep controllers thin; move reusable logic into services.
- Use Twig for all HTML rendering.
- Use Doctrine ORM for persistence and MySQL as the database.
- Keep the file structure predictable and conventional.
- Do not add API Platform.
- Do not add EasyAdmin.
- Do not introduce extra architectural layers unless the user asks for them.

## Reference

Read [bootstrap.md](references/bootstrap.md) for the baseline package set, folder layout, and the expected YAML configuration files.
