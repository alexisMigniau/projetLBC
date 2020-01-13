<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReferenceForfait
 *
 * @ORM\Table(name="reference_forfait")
 * @ORM\Entity(repositoryClass="App\Repository\ReferenceForfaitRepository")
 */
class ReferenceForfait
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prixUnitaire", type="decimal", precision=19, scale=2, nullable=false)
     */
    private $prixunitaire;

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function getPrixunitaire(): ?string
    {
        return $this->prixunitaire;
    }

    public function setPrixunitaire(string $prixunitaire): self
    {
        $this->prixunitaire = $prixunitaire;

        return $this;
    }


}
