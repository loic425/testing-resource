<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\BoardGameBlog\Infrastructure\Sylius\Grid\DataProvider;

use App\BoardGameBlog\Infrastructure\Sylius\Resource\BoardGameResource;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Sylius\Component\Grid\Data\DataProviderInterface;
use Sylius\Component\Grid\Definition\Grid;
use Sylius\Component\Grid\Parameters;
use Webmozart\Assert\Assert;

final class BoardGameGridProvider implements DataProviderInterface
{
    public function __construct(private readonly string $dataDir)
    {
    }

    public function getData(Grid $grid, Parameters $parameters): Pagerfanta
    {
        $data = [];

        $fileData = $this->getFileData();

        $sorting = $parameters->get('sorting') ?? $grid->getSorting();
        Assert::isArray($sorting);

        $fileData = $this->sortData($fileData, $sorting);

        foreach ($fileData as $row) {
            [$id, $name, $shortDescription] = $row;

            Assert::notNull($id);
            Assert::notNull($name);

            $data[] = new BoardGameResource(
                id: $id,
                name: $name,
                shortDescription: $shortDescription,
            );
        }

        return new Pagerfanta(new ArrayAdapter($data));
    }

    private function sortData(array $data, array $sorting): array
    {
        if ('asc' === ($sorting['name'] ?? null)) {
            usort($data, [$this, 'sortByNameAsc']);
        }

        if ('desc' === ($sorting['name'] ?? null)) {
            usort($data, [$this, 'sortByNameDesc']);
        }

        return $data;
    }

    private function sortByNameAsc($a, $b): int
    {
        return strcmp($a[1], $b[1]);
    }

    private function sortByNameDesc($a, $b): int
    {
        return strcmp($b[1], $a[1]);
    }

    private function getFileData(): array
    {
        return array_map('str_getcsv', file($this->dataDir . '/board_games.csv'));
    }
}
