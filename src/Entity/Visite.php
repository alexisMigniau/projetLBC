<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Visite
 *
 * @ORM\Table(name="visite", indexes={@ORM\Index(name="matricule", columns={"matricule"}), @ORM\Index(name="id_praticiens", columns={"id_praticiens"})})
 * @ORM\Entity(repositoryClass="App\Repository\VisiteRepository")
 */
class Visite
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_visite", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idVisite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_visite", type="date", nullable=false)
     */
    private $dateVisite;

    /**
     * @var string
     *
     * @ORM\Column(name="motif", type="string", length=255, nullable=false)
     */
    private $motif;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="convaincu", type="boolean", nullable=true)
     */
    private $convaincu;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="visitePlanifie", type="datetime", nullable=true)
     */
    private $visiteplanifie;

    /**
     * @var \Praticiens
     *
     * @ORM\ManyToOne(targetEntity="Praticiens")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_praticiens", referencedColumnName="id_praticiens")
     * })
     */
    private $idPraticiens;

    /**
     * @var \Visiteur
     *
     * @ORM\ManyToOne(targetEntity="Visiteur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="matricule", referencedColumnName="matricule")
     * })
     */
    private $matricule;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Medicament", inversedBy="idVisite")
     * @ORM\JoinTable(name="presentation",
     *  
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_visite", referencedColumnName="id_visite")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_medicament", referencedColumnName="id_medicament")
     *   }
     * )
     */
    private $idMedicament;

    /**
     * @ORM\OneToMany(targetEntity="Offrir", mappedBy="idVisite")
     */
    private $offrir;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idMedicament = new \Doctrine\Common\Collections\ArrayCollection();
        $this->offrir = new ArrayCollection();
    }

    public function getIdVisite(): ?int
    {
        return $this->idVisite;
    }

    public function getDateVisite(): ?\DateTimeInterface
    {
        return $this->dateVisite;
    }

    public function setDateVisite(\DateTimeInterface $dateVisite): self
    {
        $this->dateVisite = $dateVisite;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): self
    {
        $this->motif = $motif;

        return $this;
    }

    public function getConvaincu(): ?bool
    {
        return $this->convaincu;
    }

    public function setConvaincu(?bool $convaincu): self
    {
        $this->convaincu = $convaincu;

        return $this;
    }

    public function getVisiteplanifie(): ?\DateTimeInterface
    {
        return $this->visiteplanifie;
    }

    public function setVisiteplanifie(?\DateTimeInterface $visiteplanifie): self
    {
        $this->visiteplanifie = $visiteplanifie;

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

    public function getMatricule(): ?Visiteur
    {
        return $this->matricule;
    }

    public function setMatricule(?Visiteur $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * @return Collection|Medicament[]
     */
    public function getIdMedicament(): Collection
    {
        return $this->idMedicament;
    }

    public function addIdMedicament(Medicament $idMedicament): self
    {
        if (!$this->idMedicament->contains($idMedicament)) {
            $this->idMedicament[] = $idMedicament;
        }

        return $this;
    }

    public function removeIdMedicament(Medicament $idMedicament): self
    {
        if ($this->idMedicament->contains($idMedicament)) {
            $this->idMedicament->removeElement($idMedicament);
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
            $offrir->setIdVisite($this);
        }

        return $this;
    }

    public function removeOffrir(Offrir $offrir): self
    {
        if ($this->offrir->contains($offrir)) {
            $this->offrir->removeElement($offrir);
            // set the owning side to null (unless already changed)
            if ($offrir->getIdVisite() === $this) {
                $offrir->setIdVisite(null);
            }
        }

        return $this;
    }

}
