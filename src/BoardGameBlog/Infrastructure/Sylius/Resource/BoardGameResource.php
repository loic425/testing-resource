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

use Sylius\Component\Resource\Metadata\Index;
use Sylius\Component\Resource\Metadata\Resource;
use Sylius\Component\Resource\Model\ResourceInterface;

#[Resource(
    alias: 'app.board_game',
    section: 'admin',
    templatesDir: '@SyliusAdminUi/crud',
    routePrefix: '/admin',
)]
#[Index(grid: 'app_board_game')]
final class BoardGameResource implements ResourceInterface
{
    public function __construct(
        public string $id,
        public string $name,
        public string $shortDescription,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
