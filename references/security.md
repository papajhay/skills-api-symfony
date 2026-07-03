# Security

## Provider

- entity: `App\Entity\User`
- property: `email`

## Firewalls

- `api`: stateless, JSON login, JWT authenticator, refresh token support
- `main`: existing web firewall remains available

## Access control

- public: `/api/docs`, `/api`, `/api/login_check`, `/api/token/refresh`
- authenticated: all other `/api` routes
