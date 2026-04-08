<?php

namespace App\Entity;

use App\Repository\JeuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JeuRepository::class)]
class Jeu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 150)]
    private ?string $developpeur = null;

    #[ORM\Column(length: 150)]
    private ?string $editeur = null;

    #[ORM\Column(length: 255)]
    private ?string $genre = null;

    #[ORM\Column(length: 255)]
    private ?string $plateform_disponible = null;

    /**
     * @var Collection<int, UtilisateurJeu>
     */
    #[ORM\OneToMany(targetEntity: UtilisateurJeu::class, mappedBy: 'jeu')]
    private Collection $dansLesEtagere;

    public function __construct()
    {
        $this->dansLesEtagere = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getDeveloppeur(): ?string
    {
        return $this->developpeur;
    }

    public function setDeveloppeur(string $developpeur): static
    {
        $this->developpeur = $developpeur;

        return $this;
    }

    public function getEditeur(): ?string
    {
        return $this->editeur;
    }

    public function setEditeur(string $editeur): static
    {
        $this->editeur = $editeur;

        return $this;
    }

    public function getGenre(): string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getPlateformDisponible(): string
    {
        return $this->plateform_disponible;
    }

    public function setPlateformDisponible(string $plateform_disponible): static
    {
        $this->plateform_disponible = $plateform_disponible;

        return $this;
    }

    /**
     * @return Collection<int, UtilisateurJeu>
     */
    public function getDansLesEtagere(): Collection
    {
        return $this->dansLesEtagere;
    }

    public function addDansLesEtagere(UtilisateurJeu $dansLesEtagere): static
    {
        if (!$this->dansLesEtagere->contains($dansLesEtagere)) {
            $this->dansLesEtagere->add($dansLesEtagere);
            $dansLesEtagere->setJeu($this);
        }

        return $this;
    }

    public function removeDansLesEtagere(UtilisateurJeu $dansLesEtagere): static
    {
        if ($this->dansLesEtagere->removeElement($dansLesEtagere)) {
            // set the owning side to null (unless already changed)
            if ($dansLesEtagere->getJeu() === $this) {
                $dansLesEtagere->setJeu(null);
            }
        }

        return $this;
    }
}
