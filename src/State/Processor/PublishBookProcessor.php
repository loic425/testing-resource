<?php

declare(strict_types=1);

namespace App\State\Processor;

use Sylius\Component\Resource\Context\Context;
use Sylius\Component\Resource\Doctrine\Common\State\PersistProcessor;
use Sylius\Component\Resource\Metadata\Operation;
use Sylius\Component\Resource\State\ProcessorInterface;
use Symfony\Component\Workflow\WorkflowInterface;

final class PublishBookProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly WorkflowInterface $bookPublishingStateMachine,
        private readonly PersistProcessor $persistProcessor,
    ) {
    }

    public function process(mixed $data, Operation $operation, Context $context): mixed
    {
        if ($this->bookPublishingStateMachine->can($data, 'publish')) {
            $this->bookPublishingStateMachine->apply($data, 'publish');
        }

        return $this->persistProcessor->process($data, $operation, $context);
    }
}
