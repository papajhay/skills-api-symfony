# JWT

## Environment

```dotenv
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=change_me
JWT_TOKEN_TTL=172800
JWT_REFRESH_TOKEN_TTL=2592000
```

## Endpoints

- login: `/api/login_check`
- refresh: `/api/token/refresh`
