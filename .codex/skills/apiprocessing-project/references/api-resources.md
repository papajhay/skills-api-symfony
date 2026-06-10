# API Resources

The project defines API Platform resources in YAML only.

## Files

- `config/api_platform/resources/<entity>.yaml`
- `config/api_platform/resources/User.yaml`
- `config/api_platform/resources/<entity>.yaml`
- `config/routes/api_platform.yaml`

## Route pattern

```yaml
api_platform:
    resource: .
    type: api_platform
    prefix: /api
```

## Resource shape

Each file uses:

- `resources`
- entity FQCN key
- `class`
- `operations`
- `normalizationContext`
- `denormalizationContext`

## Post resource

```yaml
resources:
    App\Entity\<entity>:
        class: App\Entity\<entity>
        operations:
            ApiPlatform\Metadata\GetCollection:
                filters: ['app.api_platform.filter.<entity>.search']
                security: "is_granted('IS_AUTHENTICATED_FULLY')"
            ApiPlatform\Metadata\Get:
                security: "is_granted('IS_AUTHENTICATED_FULLY')"
            ApiPlatform\Metadata\Post:
                security: "is_granted('ROLE_API_USER') or is_granted('ROLE_SUPER_ADMIN')"
                controller: App\Controller\Upload<entity>ImageAction
                read: false
                deserialize: false
                inputFormats:
                    multipart: ['multipart/form-data']
                openapi:
                    summary: Create a post with an uploaded image
            ApiPlatform\Metadata\Put:
                security: "is_granted('ROLE_API_USER') or is_granted('ROLE_SUPER_ADMIN')"
            ApiPlatform\Metadata\Patch:
                security: "is_granted('ROLE_API_USER') or is_granted('ROLE_SUPER_ADMIN')"
            ApiPlatform\Metadata\Delete:
                security: "is_granted('ROLE_API_USER') or is_granted('ROLE_SUPER_ADMIN')"
        normalizationContext:
            groups: ['<entity>:read']
        denormalizationContext:
            groups: ['<entity>:write']
```

## User resource

```yaml
resources:
    App\Entity\User:
        class: App\Entity\User
        operations:
            ApiPlatform\Metadata\GetCollection:
                security: "is_granted('IS_AUTHENTICATED_FULLY')"
            ApiPlatform\Metadata\Get:
                security: "is_granted('IS_AUTHENTICATED_FULLY')"
            ApiPlatform\Metadata\Post:
                security: "is_granted('ROLE_API_USER') or is_granted('ROLE_SUPER_ADMIN')"
            ApiPlatform\Metadata\Put:
                security: "is_granted('ROLE_API_USER') or is_granted('ROLE_SUPER_ADMIN')"
            ApiPlatform\Metadata\Patch:
                security: "is_granted('ROLE_API_USER') or is_granted('ROLE_SUPER_ADMIN')"
            ApiPlatform\Metadata\Delete:
                security: "is_granted('ROLE_API_USER') or is_granted('ROLE_SUPER_ADMIN')"
        normalizationContext:
            groups: ['user:read']
        denormalizationContext:
            groups: ['user:write']
```

## Comment resource

```yaml
resources:
    App\Entity\<entity>:
        class: App\Entity\<entity>
        operations:
            ApiPlatform\Metadata\GetCollection:
                filters: ['app.api_platform.filter.<entity>.search']
                security: "is_granted('IS_AUTHENTICATED_FULLY')"
            ApiPlatform\Metadata\Get:
                security: "is_granted('IS_AUTHENTICATED_FULLY')"
            ApiPlatform\Metadata\Post:
                security: "is_granted('ROLE_API_USER') or is_granted('ROLE_SUPER_ADMIN')"
            ApiPlatform\Metadata\Put:
                security: "is_granted('ROLE_API_USER') or is_granted('ROLE_SUPER_ADMIN')"
            ApiPlatform\Metadata\Patch:
                security: "is_granted('ROLE_API_USER') or is_granted('ROLE_SUPER_ADMIN')"
            ApiPlatform\Metadata\Delete:
                security: "is_granted('ROLE_API_USER') or is_granted('ROLE_SUPER_ADMIN')"
        normalizationContext:
            groups: ['<entity>:read']
        denormalizationContext:
            groups: ['<entity>:write']
```

## Custom controller pattern

Only `Post` uses a custom controller:

```yaml
controller: App\Controller\Upload<entity>ImageAction
read: false
deserialize: false
```

## Existing conventions

- Reads require authentication.
- Mutations require `ROLE_API_USER` or `ROLE_SUPER_ADMIN`.
- Filters are only attached to collection operations.
- YAML defines the resource metadata, not PHP attributes.
