<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Praticiens
 *
 * @ORM\Table(name="praticiens", indexes={@ORM\Index(name="id_specialite", columns={"id_specialite"})})
 * @ORM\Entity(repositoryClass="App\Repository\PraticiensRepository")
 */
class Praticiens
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_praticiens", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPraticiens;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mail", type="string", length=50, nullable=true)
     */
    private $mail;

    /**
     * @var int
     *
     * @ORM\Column(name="notoriete", type="integer", nullable=false)
     */
    private $notoriete;

    /**
     * @var string|null
     *
     * @ORM\Column(name="longitude", type="string", length=50, nullable=true)
     */
    private $longitude;

    /**
     * @var string|null
     *
     * @ORM\Column(name="latitude", type="string", length=50, nullable=true)
     */
    private $latitude;

    /**
     * @var \Specialite
     *
     * @ORM\ManyToOne(targetEntity="Specialite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_specialite", referencedColumnName="id_specialite")
     * })
     */
    private $idSpecialite;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ActiviteComplementaire", inversedBy="idPraticiens")
     * @ORM\JoinTable(name="est_convie",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_praticiens", referencedColumnName="id_praticiens")
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
     * @ORM\ManyToMany(targetEntity="Visiteur", mappedBy="idPraticiens")
     */
    private $matricule;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idAc = new \Doctrine\Common\Collections\ArrayCollection();
        $this->matricule = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdPraticiens(): ?int
    {
        return $this->idPraticiens;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getNotoriete(): ?int
    {
        return $this->notoriete;
    }

    public function setNotoriete(int $notoriete): self
    {
        $this->notoriete = $notoriete;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getIdSpecialite(): ?Specialite
    {
        return $this->idSpecialite;
    }

    public function setIdSpecialite(?Specialite $idSpecialite): self
    {
        $this->idSpecialite = $idSpecialite;

        return $this;
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
     * @return Collection|Visiteur[]
     */
    public function getMatricule(): Collection
    {
        return $this->matricule;
    }

    public function addMatricule(Visiteur $matricule): self
    {
        if (!$this->matricule->contains($matricule)) {
            $this->matricule[] = $matricule;
            $matricule->addIdPraticien($this);
        }

        return $this;
    }

    public function removeMatricule(Visiteur $matricule): self
    {
        if ($this->matricule->contains($matricule)) {
            $this->matricule->removeElement($matricule);
            $matricule->removeIdPraticien($this);
        }

        return $this;
    }

}
