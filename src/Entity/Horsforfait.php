<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Horsforfait
 *
 * @ORM\Table(name="horsForfait")
 * @ORM\Entity(repositoryClass="App\Repository\HorsforfaitRepository")
 */
class Horsforfait
{
    /**
     * @var string|null
     *
     * @ORM\Column(name="nom_horsForfait", type="string", length=50, nullable=true)
     */
    private $nomHorsforfait;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_horsForfait", type="date", nullable=false)
     */
    private $dateHorsforfait;

    /**
     * @var string
     *
     * @ORM\Column(name="montant", type="decimal", precision=19, scale=2, nullable=false)
     */
    private $montant;

    
    /**
     * @var string
     *
     * @ORM\Column(name="facture", type="string", length=255, nullable=false)
     */
    private $facture;

    /**
     * @var \Frais
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Frais")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_frais", referencedColumnName="id_frais" ,onDelete="CASCADE")
     * })
     */
    private $idFrais;

    public function getNomHorsforfait(): ?string
    {
        return $this->nomHorsforfait;
    }

    public function setNomHorsforfait(?string $nomHorsforfait): self
    {
        $this->nomHorsforfait = $nomHorsforfait;

        return $this;
    }

    public function getDateHorsforfait(): ?\DateTimeInterface
    {
        return $this->dateHorsforfait;
    }

    public function setDateHorsforfait(?\DateTimeInterface $dateHorsforfait): self
    {
        $this->dateHorsforfait = $dateHorsforfait;

        return $this;
    }
    

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getFacture(): ?string
    {
        return $this->facture;
    }

    public function setFacture(string $facture): self
    {
        $this->facture = $facture;

        return $this;
    }

    public function getIdFrais(): ?Frais
    {
        return $this->idFrais;
    }

    public function setIdFrais(?Frais $idFrais): self
    {
        $this->idFrais = $idFrais;

        return $this;
    }


}
