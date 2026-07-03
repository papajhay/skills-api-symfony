<?php

declare(strict_types=1);

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

final class CategoryTest extends ApiTestCase
{
    protected static ?bool $alwaysBootKernel = false;

    public function testCreateCategoryValid(): void
    {
        [$client, $token] = $this->createAuthenticatedClient();

        $client->request('POST', '/api/categories', [
            'auth_bearer' => $token,
            'json' => [
                'name' => sprintf('Category %s', bin2hex(random_bytes(3))),
                'description' => 'Category created by the functional test',
                'isActive' => true,
            ],
        ]);

        self::assertResponseStatusCodeSame(201);
        self::assertJsonContains(['@type' => 'Category']);
    }

    public function testGetCategories(): void
    {
        [$client, $token, $entityManager] = $this->createAuthenticatedClient();

        $category = (new Category())
            ->setName(sprintf('Category %s', bin2hex(random_bytes(3))))
            ->setDescription('Category created for the list test')
            ->setIsActive(true)
        ;

        $entityManager->persist($category);
        $entityManager->flush();

        $client->request('GET', '/api/categories', [
            'auth_bearer' => $token,
        ]);

        self::assertResponseStatusCodeSame(200);
        self::assertJsonContains(['@type' => 'Collection']);
    }

    public function testGetCategoryById(): void
    {
        [$client, $token, $entityManager] = $this->createAuthenticatedClient();

        $category = (new Category())
            ->setName(sprintf('Category %s', bin2hex(random_bytes(3))))
            ->setDescription('Category created for the item test')
            ->setIsActive(true)
        ;

        $entityManager->persist($category);
        $entityManager->flush();

        $client->request('GET', $this->getIriFromResource($category), [
            'auth_bearer' => $token,
        ]);

        self::assertResponseStatusCodeSame(200);
        self::assertJsonContains(['@type' => 'Category']);
    }

    /**
     * @return array{0:\ApiPlatform\Symfony\Bundle\Test\Client,1:string,2:EntityManagerInterface}
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

        return [$client, $tokenManager->create($adminUser), $entityManager];
    }
}
