<?php
// src/Twig/AppExtension.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Secteur;

class AppExtension extends \Twig_Extension
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('nomSecteur', [$this, 'getNomSecteur']),
        ];
    }

    public function getNomSecteur(int $idResponsable)
    {
        return $this->em->getRepository(Secteur::class)->findOneBy(array( 'idResponsable' => $idResponsable))->getNomSecteur();
    }
}

?>