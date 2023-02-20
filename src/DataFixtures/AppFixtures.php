<?php

namespace App\DataFixtures;

use App\Story\DefaultBooksStory;
use App\Story\DefaultSubscriptionsStory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        DefaultBooksStory::load();
        DefaultSubscriptionsStory::load();
    }
}
