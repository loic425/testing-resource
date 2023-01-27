<?php


declare(strict_types=1);

namespace App\State\Responder;

use Sylius\Component\Resource\Context\Context;
use Sylius\Component\Resource\Metadata\Operation;
use Sylius\Component\Resource\State\ResponderInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class BookItemResponder implements ResponderInterface
{

    public function __construct(private Environment $twig)
    {
    }

    public function respond(mixed $data, Operation $operation, Context $context): Response
    {
        return new Response($this->twig->render($operation->getTemplate(), ['book' => $data]));
    }
}
