<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medicament
 *
 * @ORM\Table(name="medicament")
 * @ORM\Entity(repositoryClass="App\Repository\MedicamentRepository")
 */
class Medicament
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_medicament", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMedicament;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_medicament", type="string", length=50, nullable=false)
     */
    private $nomMedicament;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Visite", mappedBy="idMedicament")
     */
    private $idVisite;

    /**
     * @ORM\OneToMany(targetEntity="Offrir", mappedBy="idMedicament")
     */
    private $offrir;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idVisite = new \Doctrine\Common\Collections\ArrayCollection();
        $this->offrir = new ArrayCollection();
    }

    public function getIdMedicament(): ?int
    {
        return $this->idMedicament;
    }

    public function getNomMedicament(): ?string
    {
        return $this->nomMedicament;
    }

    public function setNomMedicament(string $nomMedicament): self
    {
        $this->nomMedicament = $nomMedicament;

        return $this;
    }

    /**
     * @return Collection|Visite[]
     */
    public function getIdVisite(): Collection
    {
        return $this->idVisite;
    }

    public function addIdVisite(Visite $idVisite): self
    {
        if (!$this->idVisite->contains($idVisite)) {
            $this->idVisite[] = $idVisite;
            $idVisite->addIdMedicament($this);
        }

        return $this;
    }

    public function removeIdVisite(Visite $idVisite): self
    {
        if ($this->idVisite->contains($idVisite)) {
            $this->idVisite->removeElement($idVisite);
            $idVisite->removeIdMedicament($this);
        }

        return $this;
    }

    /**
     * @return Collection|Offrir[]
     */
    public function getOffrir(): Collection
    {
        return $this->offrir;
    }

    public function addOffrir(Offrir $offrir): self
    {
        if (!$this->offrir->contains($offrir)) {
            $this->offrir[] = $offrir;
            $offrir->setIdMedicament($this);
        }

        return $this;
    }

    public function removeOffrir(Offrir $offrir): self
    {
        if ($this->offrir->contains($offrir)) {
            $this->offrir->removeElement($offrir);
            // set the owning side to null (unless already changed)
            if ($offrir->getIdMedicament() === $this) {
                $offrir->setIdMedicament(null);
            }
        }

        return $this;
    }

}
