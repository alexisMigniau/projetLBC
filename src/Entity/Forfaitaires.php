<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Forfaitaires
 *
 * @ORM\Table(name="forfaitaires", indexes={@ORM\Index(name="nom", columns={"typeFrais"})})
 * @ORM\Entity(repositoryClass="App\Repository\ForfaitairesRepository")
 */
class Forfaitaires
{
    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer", nullable=false)
     */
    private $quantite;

    /**
     * @var \Frais
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Frais")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_frais", referencedColumnName="id_frais",onDelete="CASCADE")
     * })
     */
    private $idFrais;

    /**
     * @var \ReferenceForfait
     *
     * @ORM\ManyToOne(targetEntity="ReferenceForfait")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="typeFrais", referencedColumnName="nom")
     * })
     */
    private $typeFrais;

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getTotal()
    {
        $prixUnite = $this->typeFrais->getPrixUnitaire();

        return $prixUnite * $this->quantite;
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

    public function getTypeFrais(): ?ReferenceForfait
    {
        return $this->typeFrais;
    }

    public function setTypeFrais(?ReferenceForfait $typeFrais): self
    {
        $this->typeFrais = $typeFrais;

        return $this;
    }
}
