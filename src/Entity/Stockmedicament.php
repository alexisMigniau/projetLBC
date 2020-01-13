<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stockmedicament
 *
 * @ORM\Table(name="StockMedicament", indexes={@ORM\Index(name="id_medicament", columns={"id_medicament"}), @ORM\Index(name="IDX_88050881762BEF34", columns={"sec_num"})})
 * @ORM\Entity(repositoryClass="App\Repository\StockmedicamentRepository")
 */
class Stockmedicament
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
     * @ORM\Column(name="stock", type="integer", nullable=true)
     */
    private $stock;

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

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): self
    {
        $this->stock = $stock;

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
