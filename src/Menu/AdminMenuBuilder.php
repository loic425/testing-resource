<?php

/*
 * This file is part of the Monofony demo project.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Menu;

use Knp\Menu\ItemInterface;
use Sylius\AdminUi\Menu\MenuBuilderInterface;

final class AdminMenuBuilder implements MenuBuilderInterface
{
    public function __construct(private MenuBuilderInterface $menuBuilder)
    {
    }

    public function createMenu(array $options): ItemInterface
    {
        $menu = $this->menuBuilder->createMenu($options);

        $this->addLibrarySubMenu($menu);
        //$this->addConfigurationSubMenu($menu);

        return $menu;
    }

    private function addLibrarySubMenu(ItemInterface $menu): void
    {
        $library = $menu
            ->addChild('library')
            ->setLabel('app.ui.library')
        ;

        $library->addChild('backend_book', ['route' => 'app_admin_book_index'])
            ->setLabel('app.ui.books')
            ->setLabelAttribute('icon', 'book');

//        $library->addChild('backend_board_game', ['route' => 'app_admin_board_game_index'])
//            ->setLabel('app.ui.board_games')
//            ->setLabelAttribute('icon', 'puzzle');
    }

    private function addConfigurationSubMenu(ItemInterface $menu): void
    {
        $library = $menu
            ->addChild('configuration')
            ->setLabel('sylius.ui.configuration')
        ;

        $library->addChild('backend_channel', ['route' => 'app_admin_subscription_index'])
            ->setLabel('app.ui.subscriptions')
            ->setLabelAttribute('icon', 'users');
    }
}
