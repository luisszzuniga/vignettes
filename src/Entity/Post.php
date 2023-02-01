<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PostRepository;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Vich\UploaderBundle\Entity\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


#[ORM\Entity(repositoryClass: PostRepository::class)]
#[Vich\Uploadable]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ManyToOne(targetEntity: User::class)]
    #[JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User|null $user = null;

    #[ManyToOne(targetEntity: Category::class)]
    #[JoinColumn(name: 'category_id', referencedColumnName: 'id')]
    private Category|null $category = null;

    #[ManyToOne(targetEntity: GridSize::class)]
    #[JoinColumn(name: 'grid_size_id', referencedColumnName: 'id')]
    private GridSize|null $gridSize = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $file = null;

    #[ORM\Column(length: 255, nullable: true)]
    private $image;

    #[Vich\UploadableField(mapping: 'posts')]
    private $imageFile;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?int
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
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

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(?string $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function setImageFile(File $image = null): self
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        // if ($image) {
        //     // if 'updatedAt' is not defined in your entity, use another property
        //     $this->updatedAt = new \DateTime('now');
        // }
        return $this;
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }
}
