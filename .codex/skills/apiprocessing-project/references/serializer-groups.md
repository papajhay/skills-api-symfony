# Serializer Groups

The project keeps serializer metadata in YAML files under `config/serializer/`.

## Files

Serializer configuration is entity-driven.

For every API Platform entity, a matching serializer file must exist:

- `config/serializer/<Entity>.yaml`

The `<Entity>` name must match the Symfony entity class name.

## Entity groups pattern

```yaml
App\Entity\<entity>:
    attributes:
        id:
            groups: ['<entity>:read']
        title:
            groups: ['<entity>:read', '<entity>:write']
        content:
            groups: ['<entity>:read', '<entity>:write']
        imageName:
            groups: ['<entity>:read']
        imageUrl:
            groups: ['<entity>:read']
        author:
            groups: ['<entity>:read', '<entity>:write']
        comments:
            groups: ['<entity>:read']
```


## Matching API Platform contexts
The YAML resources use a consistent read/write naming convention based on the entity name:

- `<entity>:read` / `<entity>:write`

## Existing conventions

- Read groups include display fields and relations.
- Write groups include mutable scalar fields and relations.
- Password is write-only.
- Upload metadata is not exposed as a write target unless the endpoint explicitly handles multipart upload.
