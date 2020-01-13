<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PraticiensRegion
 *
 * @ORM\Table(name="praticiens_region", indexes={@ORM\Index(name="id_praticiens", columns={"id_praticiens"}), @ORM\Index(name="IDX_EA2507E8AB3AA2BA", columns={"reg_code"})})
 * @ORM\Entity(repositoryClass="App\Repository\PraticiensRegionRepository")
 */
class PraticiensRegion
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAffectation", type="date", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $dateaffectation;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    /**
     * @var \Region
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Region")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="reg_code", referencedColumnName="reg_code")
     * })
     */
    private $regCode;

    /**
     * @var \Praticiens
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Praticiens")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_praticiens", referencedColumnName="id_praticiens")
     * })
     */
    private $idPraticiens;

    public function getDateaffectation(): ?\DateTimeInterface
    {
        return $this->dateaffectation;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getRegCode(): ?Region
    {
        return $this->regCode;
    }

    public function setRegCode(?Region $regCode): self
    {
        $this->regCode = $regCode;

        return $this;
    }

    public function getIdPraticiens(): ?Praticiens
    {
        return $this->idPraticiens;
    }

    public function setIdPraticiens(?Praticiens $idPraticiens): self
    {
        $this->idPraticiens = $idPraticiens;

        return $this;
    }


}
