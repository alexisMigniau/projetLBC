<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Visiteur
 *
 * @ORM\Table(name="visiteur")
 * @ORM\Entity(repositoryClass="App\Repository\VisiteurRepository")
 */
class Visiteur
{
    /**
     * @var int
     *
     * @ORM\Column(name="matricule", type="integer", nullable=false)
     * @ORM\Id
     */
    private $matricule;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ActiviteComplementaire", inversedBy="matricule")
     * @ORM\JoinTable(name="organise",
     *   joinColumns={
     *     @ORM\JoinColumn(name="matricule", referencedColumnName="matricule")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_ac", referencedColumnName="id_ac")
     *   }
     * )
     */
    private $idAc;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Praticiens", inversedBy="matricule")
     * @ORM\JoinTable(name="portefeuille",
     *   joinColumns={
     *     @ORM\JoinColumn(name="matricule", referencedColumnName="matricule")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_praticiens", referencedColumnName="id_praticiens")
     *   }
     * )
     */
    private $idPraticiens;

    /**
     * Constructor
     */
    public function __construct($id)
    {
        $this->idAc = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idPraticiens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->matricule = $id;
    }

    public function getMatricule(): ?int
    {
        return $this->matricule;
    }

    /**
     * @return Collection|ActiviteComplementaire[]
     */
    public function getIdAc(): Collection
    {
        return $this->idAc;
    }

    public function addIdAc(ActiviteComplementaire $idAc): self
    {
        if (!$this->idAc->contains($idAc)) {
            $this->idAc[] = $idAc;
        }

        return $this;
    }

    public function removeIdAc(ActiviteComplementaire $idAc): self
    {
        if ($this->idAc->contains($idAc)) {
            $this->idAc->removeElement($idAc);
        }

        return $this;
    }

    /**
     * @return Collection|Praticiens[]
     */
    public function getIdPraticiens(): Collection
    {
        return $this->idPraticiens;
    }

    public function addIdPraticien(Praticiens $idPraticien): self
    {
        if (!$this->idPraticiens->contains($idPraticien)) {
            $this->idPraticiens[] = $idPraticien;
        }

        return $this;
    }

    public function removeIdPraticien(Praticiens $idPraticien): self
    {
        if ($this->idPraticiens->contains($idPraticien)) {
            $this->idPraticiens->removeElement($idPraticien);
        }

        return $this;
    }

}
