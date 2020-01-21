<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Secteur
 *
 * @ORM\Table(name="secteur")
 * @ORM\Entity(repositoryClass="App\Repository\SecteurRepository")
 */
class Secteur
{
    /**
     * @var int
     * 
     * @ORM\Column(name="sec_num", type="integer", nullable=false)
     * @ORM\Id
     */
    private $secNum;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_secteur", type="string", length=50, nullable=true)
     */
    private $nomSecteur;

     /**
     * @var int
     * 
     * @ORM\Column(name="idResponsable", type="integer", nullable=true)
     */
    private $idResponsable;

    public function __construct($id)
    {
        $this->secNum = $id;
    }
    
    public function getSecNum(): ?int
    {
        return $this->secNum;
    }

    public function getNomSecteur(): ?string
    {
        return $this->nomSecteur;
    }

    public function setNomSecteur(string $nomSecteur): self
    {
        $this->nomSecteur = $nomSecteur;

        return $this;
    }

    public function getIdResponsable(): ?int
    {
        return $this->idResponsable;
    }

    public function setIdResponsable(?int $idResponsable): self
    {
        $this->idResponsable = $idResponsable;

        return $this;
    }


}
