<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProductFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $categoryCount = CategoryFixture::COUNT;

        for ($i = 0; $i < 100; $i++) {
            $product = new Product();
            $product->setName($faker->words(3, true));
            $product->setSku($faker->unique()->bothify('SKU-????-###'));
            $product->setDescription($faker->optional()->sentence());
            $product->setPrice(number_format($faker->randomFloat(2, 1, 500), 2, '.', ''));
            $product->setStock($faker->numberBetween(0, 500));
            $product->setIsPublished($faker->boolean(80));
            $product->setCreatedAt(new \DateTimeImmutable('-' . $faker->numberBetween(0, 365) . ' days'));
            $updated = $faker->optional(0.7)->dateTimeBetween('-90 days', 'now');
            if ($updated) {
                $product->setUpdatedAt(\DateTimeImmutable::createFromMutable($updated));
            }

            // assign a random existing category
            $randomIndex = $faker->numberBetween(0, $categoryCount - 1);
            /** @var \App\Entity\Category $category */
            $category = $this->getReference('category_' . $randomIndex, \App\Entity\Category::class);
            $product->setCategory($category);

            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CategoryFixture::class];
    }
}
