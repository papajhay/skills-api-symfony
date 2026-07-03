<?php

declare(strict_types=1);

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

final class AppUserTest extends ApiTestCase
{
    protected static ?bool $alwaysBootKernel = false;

    public function testCreateAppUserValid(): void
    {
        [$client, $token] = $this->createAuthenticatedClient();

        $client->request('POST', '/api/users', [
            'auth_bearer' => $token,
            'json' => [
                'email' => sprintf('user-%s@example.com', bin2hex(random_bytes(4))),
                'password' => 'Secret123!',
                'roles' => ['ROLE_USER'],
                'firstName' => 'Jane',
                'lastName' => 'Doe',
                'isActive' => true,
            ],
        ]);

        self::assertResponseStatusCodeSame(201);
        self::assertJsonContains(['@type' => 'User']);
    }

    public function testGetAppUsers(): void
    {
        [$client, $token, $entityManager] = $this->createAuthenticatedClient();

        $user = (new User())
            ->setEmail(sprintf('list-%s@example.com', bin2hex(random_bytes(4))))
            ->setPassword('Secret123!')
            ->setRoles(['ROLE_USER'])
            ->setFirstName('List')
            ->setLastName('User')
        ;

        $entityManager->persist($user);
        $entityManager->flush();

        $client->request('GET', '/api/users', [
            'auth_bearer' => $token,
        ]);

        self::assertResponseStatusCodeSame(200);
        self::assertJsonContains(['@type' => 'Collection']);
    }

    public function testGetAppUserById(): void
    {
        [$client, $token, $entityManager] = $this->createAuthenticatedClient();

        $user = (new User())
            ->setEmail(sprintf('item-%s@example.com', bin2hex(random_bytes(4))))
            ->setPassword('Secret123!')
            ->setRoles(['ROLE_USER'])
            ->setFirstName('Item')
            ->setLastName('User')
        ;

        $entityManager->persist($user);
        $entityManager->flush();

        $client->request('GET', $this->getIriFromResource($user), [
            'auth_bearer' => $token,
        ]);

        self::assertResponseStatusCodeSame(200);
        self::assertJsonContains(['@type' => 'User']);
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
