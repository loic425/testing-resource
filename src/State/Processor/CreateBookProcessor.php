<?php

declare(strict_types=1);

namespace App\State\Processor;

use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Resource\Context\Context;
use Sylius\Component\Resource\Context\Option\RequestOption;
use Sylius\Component\Resource\Metadata\Operation;
use Sylius\Component\Resource\State\ProcessorInterface;
use Symfony\Component\Form\FormInterface;
use Webmozart\Assert\Assert;

final class CreateBookProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, Context $context): mixed
    {
        $request = $context->get(RequestOption::class)?->request();
        Assert::notNull($request);

        /** @var FormInterface $form */
        $form = $request->attributes->get('form');
        Assert::notNull($form, 'Form was not found but it should');

        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();

            $this->entityManager->persist($book);
            $this->entityManager->flush();
        }

        return null;
    }
}
