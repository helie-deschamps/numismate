<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 400)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Coin::class, mappedBy: 'categories')]
    private Collection $coins;

    public function __construct()
    {
        $this->coins = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Coin>
     */
    public function getCoins(): Collection
    {
        return $this->coins;
    }

    public function addCoin(Coin $coin): static
    {
        if (!$this->coins->contains($coin)) {
            $this->coins->add($coin);
            $coin->addCategory($this);
        }

        return $this;
    }

    public function removeCoin(Coin $coin): static
    {
        if ($this->coins->removeElement($coin)) {
            $coin->removeCategory($this);
        }

        return $this;
    }
}
