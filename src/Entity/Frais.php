<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Frais
 *
 * @ORM\Table(name="frais", indexes={@ORM\Index(name="id_fiche", columns={"id_fiche"})})
 * @ORM\Entity(repositoryClass="App\Repository\FraisRepository")
 */
class Frais
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_frais", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFrais;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="valide", type="boolean", nullable=true)
     */
    private $valide;

    /**
     * @var \Fichefrais
     *
     * @ORM\ManyToOne(targetEntity="Fichefrais")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_fiche", referencedColumnName="id_fiche")
     * })
     */
    private $idFiche;

    public function getIdFrais(): ?int
    {
        return $this->idFrais;
    }

    public function getValide(): ?bool
    {
        return $this->valide;
    }

    public function setValide(?bool $valide): self
    {
        $this->valide = $valide;

        return $this;
    }

    public function getIdFiche(): ?Fichefrais
    {
        return $this->idFiche;
    }

    public function setIdFiche(?Fichefrais $idFiche): self
    {
        $this->idFiche = $idFiche;

        return $this;
    }


}
