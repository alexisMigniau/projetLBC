<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evaluation
 *
 * @ORM\Table(name="evaluation", indexes={@ORM\Index(name="id_visite", columns={"id_visite"})})
 * @ORM\Entity(repositoryClass="App\Repository\EvaluationRepository")
 */
class Evaluation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_evaluation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEvaluation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="commentaire", type="string", length=255, nullable=true)
     */
    private $commentaire;

    /**
     * @var \Visite
     *
     * @ORM\ManyToOne(targetEntity="Visite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_visite", referencedColumnName="id_visite")
     * })
     */
    private $idVisite;

    public function getIdEvaluation(): ?int
    {
        return $this->idEvaluation;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getIdVisite(): ?Visite
    {
        return $this->idVisite;
    }

    public function setIdVisite(?Visite $idVisite): self
    {
        $this->idVisite = $idVisite;

        return $this;
    }


}
