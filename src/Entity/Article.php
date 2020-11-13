<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @UniqueEntity(fields={"codebarre"}, message="Le codebarre existe déjà")
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $libelle;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $prixUnitaire;

    /**
     * @ORM\Column(type="integer")
     */
    private $stock;

    // /**
    //  * @ORM\ManyToMany(targetEntity=Vente::class, mappedBy="article")
    //  */
    // private $ventes;

    /**
     * @ORM\Column(type="string", length=255,unique=true)
     */
    private $codebarre;

    /**
     * @ORM\OneToMany(targetEntity=Vente::class, mappedBy="article")
     */
    private $ventes;

    public function __construct()
    {
        $this->ventes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

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

    public function getPrixUnitaire(): ?float
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(float $prixUnitaire): self
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    // /**
    //  * @return Collection|Vente[]
    //  */
    // public function getVentes(): Collection
    // {
    //     return $this->ventes;
    // }

    // public function addVente(Vente $vente): self
    // {
    //     if (!$this->ventes->contains($vente)) {
    //         $this->ventes[] = $vente;
    //         $vente->addArticle($this);
    //     }

    //     return $this;
    // }

    // public function removeVente(Vente $vente): self
    // {
    //     if ($this->ventes->removeElement($vente)) {
    //         $vente->removeArticle($this);
    //     }

    //     return $this;
    // }
    public function __toString()
    {
        return (string)$this->libelle;
    }

    public function getCodebarre(): ?string
    {
        return $this->codebarre;
    }

    public function setCodebarre(string $codebarre): self
    {
        $this->codebarre = $codebarre;

        return $this;
    }

    /**
     * @return Collection|Vente[]
     */
    public function getVentes(): Collection
    {
        return $this->ventes;
    }

    public function addVente(Vente $vente): self
    {
        if (!$this->ventes->contains($vente)) {
            $this->ventes[] = $vente;
            $vente->setArticle($this);
        }

        return $this;
    }

    public function removeVente(Vente $vente): self
    {
        if ($this->ventes->removeElement($vente)) {
            // set the owning side to null (unless already changed)
            if ($vente->getArticle() === $this) {
                $vente->setArticle(null);
            }
        }

        return $this;
    }
}
