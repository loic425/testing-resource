<?php

namespace App\Entity;

use App\BookStates;
use App\Repository\BookRepository;
use App\State\Processor\PublishBookProcessor;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Annotation\SyliusCrudRoutes;
use Sylius\Component\Resource\Annotation\SyliusRoute;
use Sylius\Resource\Metadata\AsResource;
use Sylius\Resource\Metadata\BulkDelete;
use Sylius\Resource\Metadata\BulkUpdate;
use Sylius\Resource\Metadata\Create;
use Sylius\Resource\Metadata\Delete;
use Sylius\Resource\Metadata\Index;
use Sylius\Resource\Metadata\Show;
use Sylius\Resource\Metadata\Update;
use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[AsResource(
    alias: 'app.book',
    section: 'admin',
    //formType: BookType::class,
    routePrefix: '/admin',
    operations: [
        new Index(grid: 'app_book'),
        new Create(redirectToRoute: 'app_admin_book_update'),
        new Update(redirectToRoute: 'app_admin_book_update'),
        new BulkDelete(),
        new Delete(),
        //new ApplyStateMachineTransition(redirectToRoute: 'app_admin_book_update', stateMachineTransition: 'publish'),
        new Update(
            methods: ['PUT', 'PATCH'],
            path: 'books/{id}/publish',
            shortName: 'publish',
            processor: PublishBookProcessor::class,
            validate: false,
            redirectToRoute: 'app_admin_book_update',
        ),
        new BulkUpdate(
            shortName: 'bulk_publish',
            processor: PublishBookProcessor::class,
            validate: false,
            redirectToRoute: 'app_admin_book_index',
        ),
        new Show(template: 'book/show.html.twig'),
    ],
)]
#[SyliusCrudRoutes(
    alias: 'app.book',
    path: 'legacy/books',
    section: 'legacy',
    templates: '@SyliusAdminUi/crud',
    grid: 'app_book',
)]
#[SyliusRoute(
    name: 'app_legacy_book_show',
    path: '/legacy/books/{id}',
    controller: 'app.controller.book::showAction',
    template: 'book/show.html.twig',
    section: 'legacy',
)]
class Book implements ResourceInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[NotBlank]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[NotBlank]
    private ?string $author = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private string $state = BookStates::DRAFT;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }
}
