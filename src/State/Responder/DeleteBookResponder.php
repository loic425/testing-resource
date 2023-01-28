<?php


declare(strict_types=1);

namespace App\State\Responder;

use Sylius\Component\Resource\Context\Context;
use Sylius\Component\Resource\Metadata\Operation;
use Sylius\Component\Resource\State\ResponderInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

final class DeleteBookResponder implements ResponderInterface
{
    public function respond(mixed $data, Operation $operation, Context $context): Response
    {
        return new RedirectResponse('/books');
    }
}
