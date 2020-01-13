<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Valide
 *
 * @ORM\Table(name="valide", indexes={@ORM\Index(name="id_comptable", columns={"id_comptable"}), @ORM\Index(name="IDX_C25492E2A2968D48", columns={"id_fiche"})})
 * @ORM\Entity(repositoryClass="App\Repository\ValideRepository")
 */
class Valide
{
    /**
     * @var \Fichefrais
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Fichefrais")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_fiche", referencedColumnName="id_fiche")
     * })
     */
    private $idFiche;

    /**
     * @var \Comptable
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Comptable")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_comptable", referencedColumnName="id_comptable")
     * })
     */
    private $idComptable;

    public function getIdFiche(): ?Fichefrais
    {
        return $this->idFiche;
    }

    public function setIdFiche(?Fichefrais $idFiche): self
    {
        $this->idFiche = $idFiche;

        return $this;
    }

    public function getIdComptable(): ?Comptable
    {
        return $this->idComptable;
    }

    public function setIdComptable(?Comptable $idComptable): self
    {
        $this->idComptable = $idComptable;

        return $this;
    }
}
