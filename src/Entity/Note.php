<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Note
 *
 * @ORM\Table(name="note", indexes={@ORM\Index(name="id_evaluation", columns={"id_evaluation"})})
 * @ORM\Entity(repositoryClass="App\Repository\NoteRepository")
 */
class Note
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_note", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idNote;

    /**
     * @var string
     *
     * @ORM\Column(name="nomCritere", type="string", length=50, nullable=false)
     */
    private $nomcritere;

    /**
     * @var string|null
     *
     * @ORM\Column(name="noteCritere", type="string", length=50, nullable=true)
     */
    private $notecritere;

    /**
     * @var \Evaluation
     *
     * @ORM\ManyToOne(targetEntity="Evaluation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_evaluation", referencedColumnName="id_evaluation")
     * })
     */
    private $idEvaluation;

    public function getIdNote(): ?int
    {
        return $this->idNote;
    }

    public function getNomcritere(): ?string
    {
        return $this->nomcritere;
    }

    public function setNomcritere(string $nomcritere): self
    {
        $this->nomcritere = $nomcritere;

        return $this;
    }

    public function getNotecritere(): ?string
    {
        return $this->notecritere;
    }

    public function setNotecritere(?string $notecritere): self
    {
        $this->notecritere = $notecritere;

        return $this;
    }

    public function getIdEvaluation(): ?Evaluation
    {
        return $this->idEvaluation;
    }

    public function setIdEvaluation(?Evaluation $idEvaluation): self
    {
        $this->idEvaluation = $idEvaluation;

        return $this;
    }


}
