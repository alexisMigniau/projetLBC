<?php
    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\JsonResponse;

    use App\Entity\Region;
    use App\Entity\VisiteurRegion;
    use App\Entity\Specialite;
    use App\Entity\Praticiens;
    use App\Entity\PraticiensRegion;
    use App\Entity\Visiteur;
    use App\Entity\Medicament;
    use App\Entity\Quotamedicament;
    use App\Entity\Stockmedicament;

    /**
    * @Route("/gestionEchantillons")
    */
    class moduleEchantillonsController extends AbstractController
    {
        /**
         * @Route("/", name="gestionEchantillons")
         */
        public function gestionEchantillons()
        {
            $user = $this->getUser();
            $em = $this->getDoctrine()->getManager();
            $listeMedicamentsInfos = $em->getRepository(Medicament::class)->findAll();

            if($user->hasRole('ROLE_RESPONSABLE'))
            {
                // $html = $this->render('moduleEchantillons/moduleEchantillons_Responsable.htm.twig');

                $listeRegion =  $em->getRepository(Region::class)->getRegionsByResponsable($user->getId());
                $listeVisiteurs = $em->getRepository(VisiteurRegion::class)->findBy(array('regCode' => array_column($listeRegion , "regCode") , 'active' => 1));
                $listeMedicaments = $em->getRepository(Quotamedicament::class)->findBy(array('matricule' => array_column($listeVisiteurs, "matricule")));

                // $stockMedicaments = $em->getRepository(Stockmedicament::class)->findBy(array('id_medicament' => array_column($listeVisiteurs, "matricule")));

                $html = $this->render('moduleEchantillons/moduleEchantillons_Responsable.htm.twig' , array(
                    'title' => 'Gestion des echantillons',
                    'listeRegion' => $listeRegion,
                    'listeVisiteurs' => $listeVisiteurs,
                    'listeMedicaments' => $listeMedicaments,
                    'repertoireMedicaments' => $listeMedicamentsInfos));
            }
            else if($user->hasRole('ROLE_VISITEUR'))
            {
                $listeMedicaments = $em->getRepository(Quotamedicament::class)->findBy(array('matricule' => $user->getId()));
                
                $html = $this->render('moduleEchantillons/moduleEchantillons_Visiteur.html.twig' , array(
                    'title' => 'Gestion des echantillons',
                    'listeMedicaments' => $listeMedicaments,
                    'repertoireMedicaments' => $listeMedicamentsInfos));

                    // ,
                    // 'listeMedicamentsInfos' => $listeMedicamentsInfos
            }

            return $html;
        }

        /**
         * @Route("/lectureFichierXML", name="lectureFichierXML")
         */
        public function lectureFichierXML()
        {
            $fichier = 'etudiant/Bureau/test.xml';
            
            $xml = simplexml_load_file($fichier);
            
            $annee = $xml->annee;

            foreach($xml->Code as $medicamentSecteur)
            {
                $nomMedoc = $medicamentSecteur['nom'] ;
                $quantite = $medicamentSecteur['Quantite'] ;

                $em = $this->getDoctrine()->getManager();

                $medicament = new Medicament();
                $medicamentStock = new Stockmedicament();

                $medicament->setNomMedicament($nomMedoc);
                
                $medicamentStock->setSecNum($medicamentSecteur);
                $medicamentStock->setIdMedicament($medicament.getIdMedicament());
                $medicamentStock->setStock($quantite);

                $em->persist($medicament);
                $em->persist($medicamentStock);
                $em->flush();

                return new Response($spec->getIdSpecialite());
            }
        }

        /**
         * @Route("/ajoutMedicament", name="ajoutMedicament", methods={"POST"})
         */
        public function ajoutMedicament(Request $request)
        {   
            
        }
    }

?>