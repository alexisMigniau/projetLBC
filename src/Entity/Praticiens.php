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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", nullable=false)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", nullable=false)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="notoriete", type="string", nullable=false)
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
     *  @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="App\Entity\Visite", mappedBy="idPraticiens", orphanRemoval=true)
     */
    private $visites;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idAc = new \Doctrine\Common\Collections\ArrayCollection();
        $this->matricule = new \Doctrine\Common\Collections\ArrayCollection();
        $this->visites = new ArrayCollection();
    }

    public function getIdPraticiens(): ?int
    {
        return $this->idPraticiens;
    }

    public function getNotoriete(): ?string
    {
        return $this->notoriete;
    }

    public function setNotoriete(string $notoriete): self
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

    public function setMatricule(Collection $c)
    {
        $this->matricule = $c;
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVisites(): Collection
    {
        return $this->visites;
    }

    public function getDerniereVisite()
    {
        if($this->visites->get(0) != null)
        {
            $dateRef = $this->visites->get(0)->getDateVisite();

            foreach($this->visites as $visite)
            {
                if($dateRef < $visite->getDateVisite())
                    $dateRef = $visite->getDateVisite();
            }

            return $dateRef;
        }      
        else
            return null;
    }

    public function addVisite(Visite $visite): self
    {
        if (!$this->visites->contains($visite)) {
            $this->visites[] = $visite;
            $visite->setPraticiens($this);
        }

        return $this;
    }

    public function removeVisite(Visite $visite): self
    {
        if ($this->visites->contains($visite)) {
            $this->visites->removeElement($visite);
            // set the owning side to null (unless already changed)
            if ($visite->getPraticiens() === $this) {
                $visite->setPraticiens(null);
            }
        }

        return $this;
    }

}