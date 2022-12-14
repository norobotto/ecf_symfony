<?php

namespace App\Entity;

use App\Repository\ComputerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComputerRepository::class)]
class Computer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?int $releaseYear = null;

    #[ORM\Column(length: 255)]
    private ?string $serialNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column]
    private ?bool $is_visible = null;

    #[ORM\ManyToOne(inversedBy: 'computers')]
    private ?User $author = null;

    #[ORM\ManyToOne(inversedBy: 'computers')]
    private ?Brand $brand = null;

    #[ORM\OneToMany(mappedBy: 'computers', targetEntity: AnnonceListByUser::class)]
    private Collection $computerFav;

    public function __construct()
    {
        $this->computerFav = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getReleaseYear(): ?int
    {
        return $this->releaseYear;
    }

    public function setReleaseYear(int $releaseYear): self
    {
        $this->releaseYear = $releaseYear;

        return $this;
    }

    public function getSerialNumber(): ?string
    {
        return $this->serialNumber;
    }

    public function setSerialNumber(string $serialNumber): self
    {
        $this->serialNumber = $serialNumber;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getisVisible(): ?bool
    {
        return $this->is_visible;
    }

    public function setIsVisible(bool $is_visible): self
    {
        $this->is_visible = $is_visible;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection<int, AnnonceListByUser>
     */
    public function getUsersFav(): Collection
    {
        return $this->usersFav;
    }

    public function addUsersFav(AnnonceListByUser $usersFav): self
    {
        if (!$this->usersFav->contains($usersFav)) {
            $this->usersFav->add($usersFav);
            $usersFav->setcomputers($this);
        }

        return $this;
    }

    public function removeUsersFav(AnnonceListByUser $usersFav): self
    {
        if ($this->computerFav->removeElement($usersFav)) {
            // set the owning side to null (unless already changed)
            if ($usersFav->getcomputers() === $this) {
                $usersFav->setcomputers(null);
            }
        }

        return $this;
    }

    public function isUserfav(User $user) : bool 
    {
        foreach($this->usersFav as $usersFav){
            if($usersFav->getUsers() === $user) return true;
        }
        return false;
    }
}
