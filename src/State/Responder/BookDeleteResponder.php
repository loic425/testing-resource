<?php


declare(strict_types=1);

namespace App\State\Responder;

use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Resource\Context\Context;
use Sylius\Component\Resource\Metadata\Operation;
use Sylius\Component\Resource\State\ResponderInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

final class BookDeleteResponder implements ResponderInterface
{

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function respond(mixed $data, Operation $operation, Context $context): Response
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();

        return new RedirectResponse('/books');
    }
}
