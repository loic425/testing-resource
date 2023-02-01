<?php

namespace App\Entity;

use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Metadata\Create;
use Sylius\Component\Resource\Metadata\Delete;
use Sylius\Component\Resource\Metadata\Index;
use Sylius\Component\Resource\Metadata\Resource;
use Sylius\Component\Resource\Metadata\Show;
use Sylius\Component\Resource\Metadata\Update;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Symfony\Request\State\TwigResponder;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[Resource(
    alias: 'app.book',
    section: 'admin',
    formType: BookType::class,
    templatesDir: 'book',
    operations: [
        new Index(
            responder: TwigResponder::class,
        ),
        new Create(
            responder: TwigResponder::class,
            redirectToRoute: 'app_admin_book_index',
        ),
        new Update(
            responder: TwigResponder::class,
            redirectToRoute: 'app_admin_book_index',
        ),
        new Delete(
            responder: TwigResponder::class,
            redirectToRoute: 'app_admin_book_index',
        ),
        new Show(
            responder: TwigResponder::class,
        ),
    ],
)]
class Book implements ResourceInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $author = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
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
}
