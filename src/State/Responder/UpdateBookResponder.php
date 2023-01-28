<?php


declare(strict_types=1);

namespace App\State\Responder;

use Sylius\Component\Resource\Context\Context;
use Sylius\Component\Resource\Context\Option\RequestOption;
use Sylius\Component\Resource\Metadata\Operation;
use Sylius\Component\Resource\State\ResponderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Webmozart\Assert\Assert;

final class UpdateBookResponder implements ResponderInterface
{

    public function __construct(
        private Environment $twig,
    ) {
    }

    public function respond(mixed $data, Operation $operation, Context $context): Response
    {
        $request = $context->get(RequestOption::class)?->request();
        Assert::notNull($request);

        /** @var FormInterface $form */
        $form = $request->attributes->get('form');
        Assert::notNull($form, 'Form was not found but it should');

        if ($form->isSubmitted() && $form->isValid()) {
            return new RedirectResponse('/books');
        }

        return new Response($this->twig->render($operation->getTemplate(), [
            'book' => $data,
            'form' => $form->createView(),
        ]));
    }
}
