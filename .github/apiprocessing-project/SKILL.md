---
name: apiprocessing-project
description: Generate API Platform YAML for this Symfony project by matching existing YAML-only resource definitions, serializer groups, operation security, filters, multipart upload handling, and the small set of custom API controllers in src/Controller/.
metadata:
  short-description: Symfony API Platform YAML patterns for this project
---

# API Processing Project

Use this skill when working with Symfony 7 + API Platform + JWT in this repository to produce YAML-first API resources that fit the current architecture.

## Workflow

1. Review conventions: read the minimal reference docs in `references/` and inspect the existing YAML resources under `config/api_platform/resources/` and `config/serializer/`.
2. Generate YAML-first artifacts: create or update resource YAML to match current API Platform patterns, serializer groups, operation security, filters, and multipart upload handling.
3. Validate integration: confirm routes and security match `config/routes/api_platform.yaml` and `config/packages/`, then flag any ambiguous design decisions for manual review.

## References

- [references/bootstrap-symfony.md](references/bootstrap-symfony.md) — project bootstrap and command patterns
- [references/jwt.md](references/jwt.md) — Lexik JWT, refresh tokens, and `/api/login_check`
- [references/security.md](references/security.md) — firewalls, roles, and access control expressions
- [references/api-resources.md](references/api-resources.md) — API Platform YAML resource conventions
- [references/serializer-groups.md](references/serializer-groups.md) — serializer metadata and group naming
- [references/uploads.md](references/uploads.md) — multipart uploads and custom controller handling

## Rules

- YAML-first: keep API Platform resources defined in `config/api_platform/resources/` and serializer metadata in `config/serializer/`.
- Route consistency: generated resources must align with `config/routes/api_platform.yaml`.
- Security fidelity: preserve existing role-based access rules and operation `security` expressions from the repository.
- Filter behavior: use YAML filters and built-in API Platform filter configuration rather than introducing PHP filter classes.
- Multipart uploads: follow the existing pattern with `read: false`, `deserialize: false` and custom controller wiring only where this project already uses it.

## Prohibited anti-patterns

Do not generate:

- DTO classes when the repository already uses YAML resource definitions.
- State Providers or State Processors.
- PHP filter classes for API Platform filters.
- custom resource attributes or extra layers that duplicate existing YAML-defined resources.
- authorization/authentication changes that diverge from existing Lexik JWT, refresh token, and firewall setup.

## Command log

These commands were used to inspect conventions and discover current patterns. Grouped by purpose.

### Environment & metadata
```bash
sed -n '1,260p' composer.json
sed -n '1,220p' .env
sed -n '1,220p' .env.local
```

### API and security configuration
```bash
sed -n '1,220p' config/packages/api_platform.yaml
sed -n '1,220p' config/packages/lexik_jwt_authentication.yaml
sed -n '1,220p' config/packages/gesdinet_jwt_refresh_token.yaml
sed -n '1,220p' config/packages/vich_uploader.yaml
sed -n '1,220p' config/packages/nelmio_cors.yaml
sed -n '1,220p' config/packages/security.yaml
sed -n '1,220p' config/routes/api_platform.yaml
```

### Resource discovery
```bash
find config/api_platform/resources -type f -maxdepth 2
find config/serializer -type f -maxdepth 2
```

### Code and pattern search
```bash
find src/Entity -maxdepth 1 -type f
find src/Controller -type f
rg -n "read:\s*false|deserialize:\s*false|multipart|filters:|operations:|security:" src config -g '!vendor'
```

## Summary of changes

- Reordered sections to a logical flow: description → workflow → references → rules → anti-patterns → commands.
- Simplified the workflow into three clear, actionable steps.
- Consolidated duplicate guidance into a cleaner `Rules` section.
- Made prohibited anti-patterns more specific and easier to enforce.
- Optimized the command log by removing redundant entries and grouping commands by purpose.
