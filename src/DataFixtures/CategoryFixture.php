<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixture extends Fixture
{
    public const COUNT = 10;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::COUNT; $i++) {
            $category = new Category();
            $category->setName($faker->unique()->words(2, true));
            $category->setDescription($faker->optional()->sentence());
            $category->setIsActive($faker->boolean(90));
            $category->setCreatedAt(new \DateTimeImmutable('-' . $faker->numberBetween(0, 365) . ' days'));

            $manager->persist($category);
            $this->addReference('category_' . $i, $category);
        }

        $manager->flush();
    }
}
