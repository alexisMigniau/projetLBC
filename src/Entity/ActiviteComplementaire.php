<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ActiviteComplementaire
 *
 * @ORM\Table(name="activite_complementaire")
 * @ORM\Entity(repositoryClass="App\Repository\ActiviteComplementaireRepository")
 */
class ActiviteComplementaire
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_ac", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAc;

    /**
     * @var string
     *
     * @ORM\Column(name="theme", type="string", length=50, nullable=false)
     */
    private $theme;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_ac", type="date", nullable=false)
     */
    private $dateAc;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu", type="string", length=50, nullable=false)
     */
    private $lieu;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="accepter", type="boolean", nullable=true)
     */
    private $accepter;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Praticiens", mappedBy="idAc")
     */
    private $idPraticiens;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Visiteur", mappedBy="idAc")
     */
    private $matricule;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idPraticiens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->matricule = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdAc(): ?int
    {
        return $this->idAc;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    public function getDateAc(): ?\DateTimeInterface
    {
        return $this->dateAc;
    }

    public function setDateAc(\DateTimeInterface $dateAc): self
    {
        $this->dateAc = $dateAc;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getAccepter(): ?bool
    {
        return $this->accepter;
    }

    public function setAccepter(?bool $accepter): self
    {
        $this->accepter = $accepter;

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
            $idPraticien->addIdAc($this);
        }

        return $this;
    }

    public function removeIdPraticien(Praticiens $idPraticien): self
    {
        if ($this->idPraticiens->contains($idPraticien)) {
            $this->idPraticiens->removeElement($idPraticien);
            $idPraticien->removeIdAc($this);
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
            $matricule->addIdAc($this);
        }

        return $this;
    }

    public function removeMatricule(Visiteur $matricule): self
    {
        if ($this->matricule->contains($matricule)) {
            $this->matricule->removeElement($matricule);
            $matricule->removeIdAc($this);
        }

        return $this;
    }

}
