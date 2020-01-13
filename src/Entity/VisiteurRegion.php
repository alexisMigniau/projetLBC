<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VisiteurRegion
 *
 * @ORM\Table(name="visiteur_region", indexes={@ORM\Index(name="matricule", columns={"matricule"}), @ORM\Index(name="IDX_25720CBAAB3AA2BA", columns={"reg_code"})})
 * @ORM\Entity(repositoryClass="App\Repository\VisiteurRegionRepository")
 */
class VisiteurRegion
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
     * @var bool|null
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
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
     * @var \Visiteur
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Visiteur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="matricule", referencedColumnName="matricule")
     * })
     */
    private $matricule;

    public function getDateaffectation(): ?\DateTimeInterface
    {
        return $this->dateaffectation;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): self
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

    public function getMatricule(): ?Visiteur
    {
        return $this->matricule;
    }

    public function setMatricule(?Visiteur $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }


}
