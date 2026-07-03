<# Uploads

The project uses VichUploaderBundle plus a custom API controller for multipart Post creation.

## Vich config

```yaml
vich_uploader:
    db_driver: orm
    mappings:
        post_images:
            uri_prefix: /uploads/images
            upload_destination: '%kernel.project_dir%/public/uploads/images'
            namer: Vich\UploaderBundle\Naming\SmartUniqueNamer
```

## Entity mapping

`src/Entity/Post.php` contains:

```php
#[ApiProperty(readable: false, writable: false)]
#[Vich\UploadableField(mapping: 'entity_images', fileNameProperty: 'imageName')]
private ?File $imageFile = null;
```

The entity also exposes:

```php
public function getImageUrl(): ?string
{
    if (!$this->imageName) {
        return null;
    }

    return '/uploads/images/' . $this->imageName;
}
```

## API resource pattern

The Post resource uses multipart upload handling:

```yaml
ApiPlatform\Metadata\Post:
    controller: App\Controller\UploadEntityImageAction
    read: false
    deserialize: false
    inputFormats:
        multipart: ['multipart/form-data']
```

It also documents the multipart schema in OpenAPI.

## Custom controller

`src/Controller/UploadPostImageAction.php` is the current upload controller pattern.

### Behavior

- `#[AsController]`
- `__invoke(Request $request, Security $security, EntityManagerInterface $entityManager): Response`
- validates `title` and `content`
- reads `imageFile` from `$request->files`
- falls back to `file` if needed
- requires an authenticated `User`
- persists the `Post` manually
- returns a JSON response with `id`, `title`, `content`, `imageName`, `imageUrl`, and `author`

### Representative code

```php
$uploadedFile = $request->files->get('imageFile');
if (!$uploadedFile instanceof UploadedFile) {
    $uploadedFile = $request->files->get('file');
}

if (!$uploadedFile instanceof UploadedFile) {
    throw new BadRequestHttpException('Missing required multipart field "imageFile".');
}
```

## Admin upload pattern

The EasyAdmin CRUD controllers use form-only upload widgets for any upload-enabled entity.

```php
yield Field::new('imageFile')
    ->setFormType(\Vich\UploaderBundle\Form\Type\VichImageType::class)
    ->setFormTypeOptions([
        'block_name' => 'dropzone_image',
    ])
    ->onlyOnForms();
```

And display fields:

```php
yield ImageField::new('imageName')
    ->setBasePath('/uploads/images')
    ->onlyOnIndex();
```

```php
yield ImageField::new('imageName')
    ->setBasePath('/uploads/images')
    ->onlyOnDetail();
```

## Existing conventions

- Uploads are image-based and stored under `/uploads/images/posts`.
- The API upload endpoint is custom only for the multipart Post create flow.
- Do not replace this with DTOs, processors, or a new upload abstraction.
