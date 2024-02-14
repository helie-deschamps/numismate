<?php

namespace App\Entity;

use App\Repository\CoinRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoinRepository::class)]
class Coin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 1500)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photograph_asset_path = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $creation_date = null;

    #[ORM\Column(type: Types::DATETIMETZ_IMMUTABLE)]
    private ?DateTimeImmutable $bdd_add_date = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'coins')]
    private Collection $categories;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'coins_owned')]
    private Collection $users_owners;

    #[ORM\OneToMany(targetEntity: Review::class, mappedBy: 'coin', orphanRemoval: true)]
    private Collection $reviews;

    public function __construct()
    {
        $this->bdd_add_date = new DateTimeImmutable();
        $this->categories = new ArrayCollection();
        $this->users_owners = new ArrayCollection();
        $this->reviews = new ArrayCollection();
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

    public function getPhotographAssetPath(): ?string
    {
        return $this->photograph_asset_path;
    }

    public function setPhotographAssetPath(?string $photograph_asset_path): static
    {
        $this->photograph_asset_path = $photograph_asset_path;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creation_date;
    }

    public function setCreationDate(?\DateTimeInterface $creation_date): static
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    public function getBddAddDate(): ?DateTimeImmutable
    {
        return $this->bdd_add_date;
    }

    public function setBddAddDate(DateTimeImmutable $bdd_add_date): static
    {
        $this->bdd_add_date = $bdd_add_date;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsersOwners(): Collection
    {
        return $this->users_owners;
    }

    public function addUsersOwner(User $usersOwner): static
    {
        if (!$this->users_owners->contains($usersOwner)) {
            $this->users_owners->add($usersOwner);
        }

        return $this;
    }

    public function removeUsersOwner(User $usersOwner): static
    {
        $this->users_owners->removeElement($usersOwner);

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReviews(Review $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setCoin($this);
        }

        return $this;
    }

    public function removeReview(Review $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getCoin() === $this) {
                $review->setCoin(null);
            }
        }

        return $this;
    }
}
