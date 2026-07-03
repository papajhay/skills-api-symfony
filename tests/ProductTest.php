<?php

declare(strict_types=1);

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

final class ProductTest extends ApiTestCase
{
    protected static ?bool $alwaysBootKernel = false;

    public function testCreateProductWithValidCategory(): void
    {
        [$client, $token, $entityManager] = $this->createAuthenticatedClient();

        $category = (new Category())
            ->setName(sprintf('Category %s', bin2hex(random_bytes(3))))
            ->setDescription('Product category for the create test')
            ->setIsActive(true)
        ;

        $entityManager->persist($category);
        $entityManager->flush();

        $client->request('POST', '/api/products', [
            'auth_bearer' => $token,
            'json' => [
                'category' => $this->getIriFromResource($category),
                'name' => sprintf('Product %s', bin2hex(random_bytes(3))),
                'sku' => strtoupper(bin2hex(random_bytes(4))),
                'description' => 'Product created by the functional test',
                'price' => '19.99',
                'stock' => 10,
                'isPublished' => true,
            ],
        ]);

        self::assertResponseStatusCodeSame(201);
        self::assertJsonContains(['@type' => 'Product']);
    }

    //public function testCreateProductWithInvalidCategory(): void
    //{
    //    [$client, $token] = $this->createAuthenticatedClient();

    //    $client->request('POST', '/api/products', [
    //        'auth_bearer' => $token,
    //        'json' => [
    //            'category' => '/api/categories/99999999',
    //            'name' => sprintf('Product %s', bin2hex(random_bytes(3))),
    //            'sku' => strtoupper(bin2hex(random_bytes(4))),
    //            'description' => 'Product with an invalid category reference',
    //            'price' => '19.99',
    //            'stock' => 10,
    //            'isPublished' => true,
    //        ],
    //    ]);

    //    self::assertResponseStatusCodeSame(422);
    //    self::assertJsonContains(['@type' => 'Error']);
    //}

    //public function testCreateProductDuplicateSku(): void
    //{
    //    [$client, $token, $entityManager, $adminUser] = $this->createAuthenticatedClient();

    //    $client->loginUser($adminUser, 'api');

    //    $category = (new Category())
    //        ->setName(sprintf('Category %s', bin2hex(random_bytes(3))))
    //        ->setDescription('Product category for the duplicate sku test')
    //        ->setIsActive(true)
    //    ;

    //    $entityManager->persist($category);
    //    $entityManager->flush();

    //    $sku = strtoupper(bin2hex(random_bytes(4)));

    //    $existingProduct = (new Product())
    //        ->setCategory($category)
    //        ->setName('Existing product')
    //        ->setSku($sku)
    //        ->setDescription('Existing product for duplicate sku')
    //        ->setPrice('9.99')
    //        ->setStock(1)
    //        ->setIsPublished(true)
    //    ;

    //    $entityManager->persist($existingProduct);
    //    $entityManager->flush();

    //    $client->request('POST', '/api/products', [
    //        'json' => [
    //            'category' => $this->getIriFromResource($category),
    //            'name' => sprintf('Product %s', bin2hex(random_bytes(3))),
    //            'sku' => $sku,
    //            'description' => 'Duplicate sku product',
    //            'price' => '19.99',
    //            'stock' => 10,
    //            'isPublished' => true,
    //        ],
    //    ]);

    //    self::assertResponseStatusCodeSame(422);
    //    self::assertJsonContains(['@type' => 'Error']);
    //}

    public function testGetProducts(): void
    {
        [$client, $token, $entityManager] = $this->createAuthenticatedClient();

        $category = (new Category())
            ->setName(sprintf('Category %s', bin2hex(random_bytes(3))))
            ->setDescription('Product category for the list test')
            ->setIsActive(true)
        ;

        $entityManager->persist($category);
        $entityManager->flush();

        $product = (new Product())
            ->setCategory($category)
            ->setName(sprintf('Product %s', bin2hex(random_bytes(3))))
            ->setSku(strtoupper(bin2hex(random_bytes(4))))
            ->setDescription('Product created for the list test')
            ->setPrice('19.99')
            ->setStock(10)
            ->setIsPublished(true)
        ;

        $entityManager->persist($product);
        $entityManager->flush();

        $client->request('GET', '/api/products', [
            'auth_bearer' => $token,
        ]);

        self::assertResponseStatusCodeSame(200);
        self::assertJsonContains(['@type' => 'Collection']);
    }

    public function testGetProductById(): void
    {
        [$client, $token, $entityManager] = $this->createAuthenticatedClient();

        $category = (new Category())
            ->setName(sprintf('Category %s', bin2hex(random_bytes(3))))
            ->setDescription('Product category for the item test')
            ->setIsActive(true)
        ;

        $entityManager->persist($category);
        $entityManager->flush();

        $product = (new Product())
            ->setCategory($category)
            ->setName(sprintf('Product %s', bin2hex(random_bytes(3))))
            ->setSku(strtoupper(bin2hex(random_bytes(4))))
            ->setDescription('Product created for the item test')
            ->setPrice('19.99')
            ->setStock(10)
            ->setIsPublished(true)
        ;

        $entityManager->persist($product);
        $entityManager->flush();

        $client->request('GET', $this->getIriFromResource($product), [
            'auth_bearer' => $token,
        ]);

        self::assertResponseStatusCodeSame(200);
        self::assertJsonContains(['@type' => 'Product']);
    }

    /**
     * @return array{0:\ApiPlatform\Symfony\Bundle\Test\Client,1:string,2:EntityManagerInterface,3:User}
     */
    private function createAuthenticatedClient(): array
    {
        $client = static::createClient();
        $container = static::getContainer();

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $container->get(EntityManagerInterface::class);

        $adminUser = (new User())
            ->setEmail(sprintf('admin-%s@example.com', bin2hex(random_bytes(4))))
            ->setPassword('AdminSecret123!')
            ->setRoles(['ROLE_ADMIN'])
            ->setFirstName('Admin')
            ->setLastName('User')
        ;

        $entityManager->persist($adminUser);
        $entityManager->flush();

        /** @var JWTTokenManagerInterface $tokenManager */
        $tokenManager = $container->get(JWTTokenManagerInterface::class);

        return [$client, $tokenManager->create($adminUser), $entityManager, $adminUser];
    }
}
