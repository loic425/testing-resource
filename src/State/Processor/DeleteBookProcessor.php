<?php

declare(strict_types=1);

namespace App\State\Processor;

use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Resource\Context\Context;
use Sylius\Component\Resource\Metadata\Operation;
use Sylius\Component\Resource\State\ProcessorInterface;

final class DeleteBookProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, Context $context): mixed
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();

        return null;
    }
}
