<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comptable
 *
 * @ORM\Table(name="comptable")
 * @ORM\Entity(repositoryClass="App\Repository\ComptableRepository")
 */
class Comptable
{
    /**
     * @var int
     * @ORM\Column(name="id_comptable", type="integer", nullable=false)
     * @ORM\Id
     */
    private $idComptable;

    /**
     * @var string
     *
     * @ORM\Column(name="signature", type="string", length=50, nullable=true)
     */
    private $signature;

    public function __construct($id)
    {
        $this->idComptable = $id;
    }

    public function getIdComptable(): ?int
    {
        return $this->idComptable;
    }

    public function getSignature(): ?string
    {
        return $this->signature;
    }

    public function setSignature(?string $signature): self
    {
        $this->signature = $signature;

        return $this;
    }


}
