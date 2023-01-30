<?php

declare(strict_types=1);

namespace App\State\Processor;

use Sylius\Component\Resource\Context\Context;
use Sylius\Component\Resource\Context\Option\RequestOption;
use Sylius\Component\Resource\Doctrine\Common\State\PersistProcessor;
use Sylius\Component\Resource\Metadata\Operation;
use Sylius\Component\Resource\State\ProcessorInterface;
use Symfony\Component\Form\FormInterface;
use Webmozart\Assert\Assert;

final class UpdateBookProcessor implements ProcessorInterface
{
    public function __construct(

        private PersistProcessor $decorated,
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
            return $this->decorated->process($data, $operation, $context);
        }

        return null;
    }
}
