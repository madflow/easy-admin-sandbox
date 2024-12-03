<?php

namespace App\Entity;

use App\Repository\PokemonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PokemonRepository::class)]
class Pokemon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, PokemonMove>
     */
    #[ORM\OneToMany(targetEntity: PokemonMove::class, mappedBy: 'pokemon')]
    private Collection $moves;

    public function __construct()
    {
        $this->moves = new ArrayCollection();
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

    /**
     * @return Collection<int, PokemonMove>
     */
    public function getMoves(): Collection
    {
        return $this->moves;
    }

    public function addMove(PokemonMove $move): static
    {
        if (!$this->moves->contains($move)) {
            $this->moves->add($move);
            $move->setPokemon($this);
        }

        return $this;
    }

    public function removeMove(PokemonMove $move): static
    {
        if ($this->moves->removeElement($move)) {
            // set the owning side to null (unless already changed)
            if ($move->getPokemon() === $this) {
                $move->setPokemon(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
