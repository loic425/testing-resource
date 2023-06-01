<?php

namespace App\Grid;

use App\Entity\Book;
use Sylius\Bundle\GridBundle\Builder\Action\Action;
use Sylius\Bundle\GridBundle\Builder\Action\CreateAction;
use Sylius\Bundle\GridBundle\Builder\Action\DeleteAction;
use Sylius\Bundle\GridBundle\Builder\Action\ShowAction;
use Sylius\Bundle\GridBundle\Builder\Action\UpdateAction;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\BulkActionGroup;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\ItemActionGroup;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\MainActionGroup;
use Sylius\Bundle\GridBundle\Builder\Field\DateTimeField;
use Sylius\Bundle\GridBundle\Builder\Field\StringField;
use Sylius\Bundle\GridBundle\Builder\Field\TwigField;
use Sylius\Bundle\GridBundle\Builder\Filter\StringFilter;
use Sylius\Bundle\GridBundle\Builder\GridBuilderInterface;
use Sylius\Bundle\GridBundle\Grid\ResourceAwareGridInterface;
use Sylius\Bundle\GridBundle\Grid\AbstractGrid;

final class BookGrid extends AbstractGrid implements ResourceAwareGridInterface
{
    public static function getName(): string
    {
        return 'app_book';
    }

    public function buildGrid(GridBuilderInterface $gridBuilder): void
    {
        $gridBuilder
            ->orderBy('name', 'asc')
//            ->addFilter(
//                StringFilter::create('search', ['name', 'author'])
//                    ->setLabel('sylius.ui.search')
//            )
            ->addField(
                StringField::create('name')
                    ->setLabel('sylius.ui.name')
                    ->setSortable(true)
            )
            ->addField(
                StringField::create('author')
                    ->setLabel('sylius.ui.author')
                    ->setSortable(true)
            )
            ->addField(
                TwigField::create('state', '@SyliusUi/Grid/Field/state.html.twig')
                    ->setLabel('sylius.ui.state')
                    ->setOption('vars', ['labels' => 'admin/book/label/state']),
            )
            ->addActionGroup(
                MainActionGroup::create(
                    CreateAction::create(),
                )
            )
            ->addActionGroup(
                ItemActionGroup::create(
                    // ShowAction::create(),
                    UpdateAction::create(),
                    Action::create('publish', 'apply_transition')
                        ->setLabel('app.ui.publish')
                        ->setIcon('icon: checkmark')
                        ->setOptions([
                            'link' => [
                                'route' => 'app_admin_book_publish',
                                'parameters' => [
                                    'id' => 'resource.id',
                                ],
                            ],
                            'class' => 'green',
                            'transition' => 'publish',
                        ]),
                    DeleteAction::create(),
                )
            )
            ->addActionGroup(
                BulkActionGroup::create(
                    DeleteAction::create(),
                    Action::create('publish', 'apply_transition')
                        ->setLabel('app.ui.publish')
                        ->setIcon('icon: checkmark')
                        ->setOptions([
                            'link' => [
                                'route' => 'app_admin_book_bulk_publish',
                            ],
                            'class' => 'green',
                            'transition' => 'publish',
                        ]),
                )
            )
        ;
    }

    public function getResourceClass(): string
    {
        return Book::class;
    }
}
