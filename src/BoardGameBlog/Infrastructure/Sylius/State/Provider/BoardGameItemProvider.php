<?php

declare(strict_types=1);

namespace App\BoardGameBlog\Infrastructure\Sylius\State\Provider;

use App\BoardGameBlog\Infrastructure\Sylius\Resource\BoardGameResource;
use Sylius\Component\Resource\Context\Context;
use Sylius\Component\Resource\Context\Option\RequestOption;
use Sylius\Component\Resource\Metadata\Operation;
use Sylius\Component\Resource\State\ProviderInterface;
use Webmozart\Assert\Assert;

final class BoardGameItemProvider implements ProviderInterface
{
    public function __construct(private readonly string $dataDir)
    {
    }

    public function provide(Operation $operation, Context $context): ?BoardGameResource
    {
        $request = $context->get(RequestOption::class)?->request();
        Assert::notNull($request);

        /** @var string|null $id */
        $id = $request->attributes->get('id');
        Assert::nullOrString($id);

        [$id, $name, $shortDescription] = $this->getFileData()[$id] ?? null;

        if (null === $id) {
            return null;
        }

        Assert::notNull($name);
        Assert::notNull($shortDescription);

        return new BoardGameResource(
            id: $id,
            name: $name,
            shortDescription: $shortDescription,
        );
    }

    private function getFileData(): array
    {
        return array_column(
            array_map(
                'str_getcsv',
                file($this->dataDir . '/board_games.csv')
            ),
            null,
            0,
        );
    }
}
