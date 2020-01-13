<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Forfaitaires
 *
 * @ORM\Table(name="forfaitaires", indexes={@ORM\Index(name="nom_1", columns={"nom_1"}), @ORM\Index(name="nom", columns={"nom"})})
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
     *   @ORM\JoinColumn(name="id_frais", referencedColumnName="id_frais")
     * })
     */
    private $idFrais;

    /**
     * @var \ReferenceForfait
     *
     * @ORM\ManyToOne(targetEntity="ReferenceForfait")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="nom", referencedColumnName="nom")
     * })
     */
    private $nom;

    /**
     * @var \ReferenceForfait
     *
     * @ORM\ManyToOne(targetEntity="ReferenceForfait")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="nom_1", referencedColumnName="nom")
     * })
     */
    private $nom1;

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

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

    public function getNom(): ?ReferenceForfait
    {
        return $this->nom;
    }

    public function setNom(?ReferenceForfait $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getNom1(): ?ReferenceForfait
    {
        return $this->nom1;
    }

    public function setNom1(?ReferenceForfait $nom1): self
    {
        $this->nom1 = $nom1;

        return $this;
    }


}
