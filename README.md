# Symfony API Platform Docker Stack

Symfony 7 API Platform application running on PHP-FPM, Nginx, and PostgreSQL.

## Stack

- PHP 8.2-FPM
- Nginx
- PostgreSQL 16
- API Platform 4
- Doctrine ORM and Doctrine Migrations
- Lexik JWT Authentication and Gesdinet refresh tokens
- VichUploaderBundle for file uploads

## Folder layout

```text
docker/
  nginx/
  php/
config/
  api_platform/
  doctrine/
  packages/
  routes.yaml
migrations/
public/
src/
  Entity/
  Repository/
templates/
```

## WSL Ubuntu Setup

Install Docker Engine and the Compose plugin inside Ubuntu running under WSL:

```bash
sudo apt update
sudo apt install ca-certificates curl
sudo install -m 0755 -d /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo tee /etc/apt/keyrings/docker.asc >/dev/null
sudo chmod a+r /etc/apt/keyrings/docker.asc
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.asc] https://download.docker.com/linux/ubuntu \
  $(. /etc/os-release && echo "${UBUNTU_CODENAME:-$VERSION_CODENAME}") stable" | \
  sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
sudo apt update
sudo apt install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
sudo systemctl enable --now docker
sudo docker run hello-world
```

If you want to use Docker without `sudo`, add your user to the `docker` group and open a new shell:

```bash
sudo usermod -aG docker "$USER"
newgrp docker
docker run hello-world
```

## Docker Startup

Use `make` to avoid repeating long `docker compose` commands:

```bash
make help
make build
make up
make logs
```

Common targets:

```bash
make down
make restart
make shell
make composer-install
make migrate
make fixtures
make test
```

Equivalent Compose commands are still available if you prefer them directly.

Build and start the full stack:

```bash
docker compose up -d --build
```

Install PHP dependencies inside the container if needed:

```bash
docker compose exec php composer install
```

Create or update the database schema:

```bash
docker compose exec php php bin/console doctrine:migrations:migrate --no-interaction
```

Open the application at:

```text
http://localhost:8080
http://localhost:8080/api/docs
```

## Useful CLI commands

```bash
docker compose exec php php bin/console debug:router
docker compose exec php php bin/console debug:container
docker compose exec php php bin/console cache:clear
docker compose logs -f
```

## Database

The Docker stack uses PostgreSQL by default. The Doctrine connection is configured through `DATABASE_URL`.

```dotenv
DATABASE_URL="postgresql://app:app@database:5432/app?serverVersion=16&charset=utf8"
```

The first database container start also creates an `app_test` database for the PHPUnit environment.
If you already started the stack before adding this init script, recreate the database volume once so PostgreSQL reruns the initialization step.

## Notes

- The PHP container keeps `vendor/` and `var/` in named volumes so bind-mounting the project does not wipe dependencies or cache.
- The Nginx container serves `public/` and forwards PHP requests to the PHP-FPM container.
- If Docker Engine is installed directly in WSL Ubuntu, do not also start Docker Desktop with WSL integration for the same distribution.
