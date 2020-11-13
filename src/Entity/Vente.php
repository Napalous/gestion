<?php

namespace App\Entity;

use App\Repository\VenteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VenteRepository::class)
 */
class Vente
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ventes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $gerant;

    /**
     * @ORM\Column(type="datetime")
     */
    private $venteAt;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="ventes")
     */
    private $article;

    // /**
    //  * @ORM\ManyToMany(targetEntity=Article::class, inversedBy="ventes")
    //  */
    // private $article;

    // public function __construct()
    // {
    //     $this->article = new ArrayCollection();
    // }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getGerant(): ?User
    {
        return $this->gerant;
    }

    public function setGerant(?User $gerant): self
    {
        $this->gerant = $gerant;

        return $this;
    }

    public function getVenteAt(): ?\DateTimeInterface
    {
        return $this->venteAt;
    }

    public function setVenteAt(\DateTimeInterface $venteAt): self
    {
        $this->venteAt = $venteAt;

        return $this;
    }

    // /**
    //  * @return Collection|Article[]
    //  */
    // public function getArticle(): Collection
    // {
    //     return $this->article;
    // }

    // public function addArticle(Article $article): self
    // {
    //     if (!$this->article->contains($article)) {
    //         $this->article[] = $article;
    //     }

    //     return $this;
    // }

    // public function removeArticle(Article $article): self
    // {
    //     $this->article->removeElement($article);

    //     return $this;
    // }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }
}
