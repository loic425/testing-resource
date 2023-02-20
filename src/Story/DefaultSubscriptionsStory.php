<?php

namespace App\Story;

use App\Factory\SubscriptionFactory;
use Zenstruck\Foundry\Story;

final class DefaultSubscriptionsStory extends Story
{
    public function build(): void
    {
        SubscriptionFactory::createMany(200);
    }
}
