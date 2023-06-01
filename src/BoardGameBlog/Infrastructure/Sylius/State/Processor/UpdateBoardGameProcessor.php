<?php

declare(strict_types=1);

namespace App\BoardGameBlog\Infrastructure\Sylius\State\Processor;

use App\BoardGameBlog\Infrastructure\Sylius\Resource\BoardGameResource;
use Sylius\Component\Resource\Context\Context;
use Sylius\Component\Resource\Metadata\Operation;
use Sylius\Component\Resource\State\ProcessorInterface;
use Webmozart\Assert\Assert;

final class UpdateBoardGameProcessor implements ProcessorInterface
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

        $this->updateBoardGame($data);

        return null;
    }

    private function updateBoardGame(BoardGameResource $boardGameResource): void
    {
        $fileData = $this->getFileData();
        $row = &$fileData[$boardGameResource->id];
        Assert::isArray($row);

        $row[1] = $boardGameResource->name;
        $row[2] = $boardGameResource->shortDescription;

        $handle = fopen($this->dataDir . '/board_games.csv', 'wb');

        foreach ($fileData as $data) {
            fputcsv($handle, $data);
        }

        fclose($handle);
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
