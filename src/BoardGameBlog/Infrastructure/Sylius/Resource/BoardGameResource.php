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

namespace App\BoardGameBlog\Infrastructure\Sylius\Resource;

use App\BoardGameBlog\Infrastructure\Sylius\State\Processor\CreateBoardGameProcessor;
use App\BoardGameBlog\Infrastructure\Sylius\State\Processor\DeleteBoardGameProcessor;
use App\BoardGameBlog\Infrastructure\Sylius\State\Processor\UpdateBoardGameProcessor;
use App\BoardGameBlog\Infrastructure\Sylius\State\Provider\BoardGameItemProvider;
use App\BoardGameBlog\Infrastructure\Symfony\Form\BoardGameType;
use Sylius\Resource\Metadata\AsResource;
use Sylius\Resource\Metadata\Create;
use Sylius\Resource\Metadata\Delete;
use Sylius\Resource\Metadata\Index;
use Sylius\Resource\Metadata\Update;
use Sylius\Resource\Model\ResourceInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

#[AsResource(
    alias: 'app.board_game',
    section: 'admin',
    formType: BoardGameType::class,
    templatesDir: '@SyliusAdminUi/crud',
    routePrefix: '/admin',
)]
#[Index(
    grid: 'app_board_game'
)]
#[Create(
    processor: CreateBoardGameProcessor::class,
)]
#[Update(
    provider: BoardGameItemProvider::class,
    processor: UpdateBoardGameProcessor::class,
)]
#[Delete(
    provider: BoardGameItemProvider::class,
    processor: DeleteBoardGameProcessor::class,
)]
final class BoardGameResource implements ResourceInterface
{
    public function __construct(
        public ?string $id = null,

        #[NotBlank]
        public ?string $name = null,

        public ?string $shortDescription = null,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
