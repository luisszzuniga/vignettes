<?php

namespace App\Entity;

use App\Repository\GridSizeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GridSizeRepository::class)]
class GridSize
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $grid_column = null;

    #[ORM\Column(length: 255)]
    private ?string $grid_row = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGridColumn(): ?string
    {
        return $this->grid_column;
    }

    public function setGridColumn(string $grid_column): self
    {
        $this->grid_column = $grid_column;

        return $this;
    }

    public function getGridRow(): ?string
    {
        return $this->grid_row;
    }

    public function setGridRow(string $grid_row): self
    {
        $this->grid_row = $grid_row;

        return $this;
    }
}
