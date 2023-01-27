<?php

namespace App\Entity;

use App\Form\BookType;
use App\Repository\BookRepository;
use App\State\Responder\BookCollectionResponder;
use App\State\Responder\BookCreationResponder;
use App\State\Responder\BookDeleteResponder;
use App\State\Responder\BookEditionResponder;
use App\State\Responder\BookItemResponder;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Metadata\Create;
use Sylius\Component\Resource\Metadata\Delete;
use Sylius\Component\Resource\Metadata\Index;
use Sylius\Component\Resource\Metadata\Resource;
use Sylius\Component\Resource\Metadata\Show;
use Sylius\Component\Resource\Metadata\Update;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Symfony\Request\State\Provider;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[Resource(
    alias: 'app.book',
    section: 'admin',
    operations: [
        new Index(
            template: 'book/index.html.twig',
            provider: Provider::class,
            responder: BookCollectionResponder::class,
        ),
        new Create(
            template: 'book/create.html.twig',
            provider: Provider::class,
            responder: BookCreationResponder::class,
        ),
        new Update(
            template: 'book/update.html.twig',
            provider: Provider::class,
            responder: BookEditionResponder::class,
        ),
        new Delete(
            provider: Provider::class,
            responder: BookDeleteResponder::class,
        ),
        new Show(
            template: 'book/show.html.twig',
            provider: Provider::class,
            responder: BookItemResponder::class,
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
