<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OffrirRepository")
 * @ORM\Table(name="Offrir")
 */
class Offrir
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Visite", inversedBy="offrir")
     * @ORM\JoinColumn(name="idVisite", referencedColumnName="id_visite", nullable=FALSE)
     */
    private $idVisite;

    /**
     * @ORM\ManyToOne(targetEntity="Medicament", inversedBy="offrir")
     * @ORM\JoinColumn(name="idMedicament", referencedColumnName="id_medicament", nullable=FALSE)
     */
    private $idMedicament;

    /**
     * @ORM\Column(type="integer", name="quantite_echantillon")
     */
    protected $quantiteEchantillon;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantiteEchantillon(): ?int
    {
        return $this->quantiteEchantillon;
    }

    public function setQuantiteEchantillon(int $quantiteEchantillon): self
    {
        $this->quantiteEchantillon = $quantiteEchantillon;

        return $this;
    }

    public function getIdVisite(): ?Visite
    {
        return $this->idVisite;
    }

    public function setIdVisite(?Visite $idVisite): self
    {
        $this->idVisite = $idVisite;

        return $this;
    }

    public function getIdMedicament(): ?Medicament
    {
        return $this->idMedicament;
    }

    public function setIdMedicament(?Medicament $idMedicament): self
    {
        $this->idMedicament = $idMedicament;

        return $this;
    }
}