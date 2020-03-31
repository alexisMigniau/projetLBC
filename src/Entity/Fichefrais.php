<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fichefrais
 *
 * @ORM\Table(name="FicheFrais", indexes={@ORM\Index(name="matricule", columns={"matricule"})})
 * @ORM\Entity(repositoryClass="App\Repository\FichefraisRepository")
 */
class Fichefrais
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_fiche", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFiche;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Mois", type="date", nullable=false)
     */
    private $mois;

    /**
     * @var int
     *
     * @ORM\Column(name="etat", type="integer", nullable=false)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="pdf", type="string", length=255, nullable=true)
     */
    private $pdf;

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
     *  @var \Doctrine\Common\Collections\Collection
     * 
     * @ORM\OneToMany(targetEntity="App\Entity\Frais", mappedBy="idFiche", orphanRemoval=true)
     */
    private $listeFrais;

    public function getIdFiche(): ?int
    {
        return $this->idFiche;
    }

    public function getMois(): ?\DateTimeInterface
    {
        return $this->mois;
    }

    public function setMois(\DateTimeInterface $mois): self
    {
        $this->mois = $mois;

        return $this;
    }

    public function getTotal()
    {
        $total = 0;

        foreach($this->listeFrais as $frais)
        {
            
        }

        return $total;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getLibelleEtat()
    {
        switch($this->etat)
        {
            case 0:
                return "Créée";
            break;

            case 1:
                return "Cloturée";
            break;

            case 2:
                return "Validée";
            break;

            case 3:
                return "Mise en paiement";
            break;

            case 4:
                return "Remboursée";
            break;
        } 
    }

    public function getPdf(): ?string
    {
        return $this->pdf;
    }

    public function setPdf(string $pdf): self
    {
        $this->pdf = $pdf;

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
