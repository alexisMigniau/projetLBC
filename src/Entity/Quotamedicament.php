<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Quotamedicament
 *
 * @ORM\Table(name="quotaMedicament", indexes={@ORM\Index(name="matricule", columns={"matricule"}), @ORM\Index(name="id_medicament", columns={"id_medicament"}), @ORM\Index(name="IDX_AF663A0F762BEF34", columns={"sec_num"})})
 * @ORM\Entity(repositoryClass="App\Repository\QuotamedicamentRepository")
 */
class Quotamedicament
{
    /**
     * @var int
     *
     * @ORM\Column(name="annee", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $annee;

    /**
     * @var int|null
     *
     * @ORM\Column(name="quota", type="integer", nullable=true)
     */
    private $quota;

    /**
     * @var \Secteur
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Secteur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sec_num", referencedColumnName="sec_num")
     * })
     */
    private $secNum;

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

    /**
     * @var \Medicament
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Medicament")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_medicament", referencedColumnName="id_medicament")
     * })
     */
    private $idMedicament;

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function getQuota(): ?int
    {
        return $this->quota;
    }

    public function setQuota(?int $quota): self
    {
        $this->quota = $quota;

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

    public function getMatricule(): ?Visiteur
    {
        return $this->matricule;
    }

    public function setMatricule(?Visiteur $matricule): self
    {
        $this->matricule = $matricule;

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
