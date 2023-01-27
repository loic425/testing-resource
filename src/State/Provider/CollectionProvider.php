<?php


declare(strict_types=1);

namespace App\State\Provider;

use Psr\Container\ContainerInterface;
use Sylius\Component\Resource\Context\Context;
use Sylius\Component\Resource\Context\Option\RequestOption;
use Sylius\Component\Resource\Metadata\Operation;
use Sylius\Component\Resource\Reflection\CallableReflection;
use Sylius\Component\Resource\State\ProviderInterface;
use Sylius\Component\Resource\Symfony\Request\RepositoryArgumentResolver;

final class CollectionProvider implements ProviderInterface
{
    public function __construct(
        private ContainerInterface $locator,
        private RepositoryArgumentResolver $argumentResolver,
    ) {
    }

    public function provide(Operation $operation, Context $context): iterable
    {
        $request = $context->get(RequestOption::class)?->request();
        $repository = $operation->getRepository();

        if (
            null === $request ||
            null === $repository
        ) {
            return null;
        }

        if (\is_string($repository)) {
            $method = $operation->getRepositoryMethod() ?? 'createPaginator';

            if (!$this->locator->has($repository)) {
                throw new \RuntimeException(sprintf('Repository "%s" not found on operation "%s"', $repository, $operation->getName() ?? ''));
            }

            $repositoryInstance = $this->locator->get($repository);

            // make it as callable
            /** @var callable $repository */
            $repository = [$repositoryInstance, $method];
        }

        $reflector = CallableReflection::from($repository);
        $arguments = $this->argumentResolver->getArguments($request, $reflector);

        return $repository(...$arguments);
    }
}
