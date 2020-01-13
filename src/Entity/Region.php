<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Region
 *
 * @ORM\Table(name="region", indexes={@ORM\Index(name="sec_num", columns={"sec_num"})})
 * @ORM\Entity(repositoryClass="App\Repository\RegionRepository")
 */
class Region
{
    /**
     * @var int
     *
     * @ORM\Column(name="reg_code", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $regCode;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_region", type="string", length=50, nullable=false)
     */
    private $nomRegion;

    /**
     * @var \Secteur
     *
     * @ORM\ManyToOne(targetEntity="Secteur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sec_num", referencedColumnName="sec_num")
     * })
     */
    private $secNum;

    public function getRegCode(): ?int
    {
        return $this->regCode;
    }

    public function getNomRegion(): ?string
    {
        return $this->nomRegion;
    }

    public function setNomRegion(string $nomRegion): self
    {
        $this->nomRegion = $nomRegion;

        return $this;
    }

    public function getSecNum(): ?Secteur
    {
        return $this->secNum;
    }

    public function setSecNum(?Secteur $secNum): self
    {
        $this->secNum = $secNum;

        return $this;
    }


}
