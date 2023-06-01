<?php

declare(strict_types=1);

namespace App\BoardGameBlog\Infrastructure\Sylius\State\Processor;

use App\BoardGameBlog\Infrastructure\Sylius\Resource\BoardGameResource;
use Sylius\Component\Resource\Context\Context;
use Sylius\Component\Resource\Metadata\Operation;
use Sylius\Component\Resource\State\ProcessorInterface;
use Symfony\Component\Uid\Uuid;
use Webmozart\Assert\Assert;

final class CreateBoardGameProcessor implements ProcessorInterface
{
    public function __construct(private readonly string $dataDir)
    {
    }

    /**
     * @param BoardGameResource $data
     */
    public function process(mixed $data, Operation $operation, Context $context): mixed
    {
        Assert::isInstanceOf($data, BoardGameResource::class);

        $this->createBoardGame($data);

        return null;
    }

    private function createBoardGame(BoardGameResource $boardGameResource): void
    {
        $handle = fopen($this->dataDir . '/board_games.csv', 'a');

        fputcsv($handle, [(string) Uuid::v4(), $boardGameResource->name, $boardGameResource->shortDescription]);

        fclose($handle);
    }
}
