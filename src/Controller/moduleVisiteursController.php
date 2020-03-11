<?php 
    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\JsonResponse;

    use App\Entity\Region;
    use App\Entity\Profil;
    use App\Entity\VisiteurRegion;
    use App\Entity\Specialite;
    use App\Entity\Praticiens;
    use App\Entity\PraticiensRegion;
    use App\Entity\Visite;
	
	/**
    * @Route("/gestionVisite")
    */
    class moduleVisiteursController extends AbstractController
    {

    	/**
         * @Route("/", name="gestionVisite")
         */
    	public function gestionVisite()
    	{
            $user = $this->getUser();

            $em = $this->getDoctrine()->getManager();

            if ($user->hasRole('ROLE_RESPONSABLE'))
            {
                $listeRegions =  $em->getRepository(Region::class)->getRegionsByResponsable($user->getId());
                $listeVisiteurs = $em->getRepository(VisiteurRegion::class)->findBy(array('regCode' => array_column($listeRegions , "regCode") , 'active' => 1));
                $listeNomsVisiteurs = $em->getRepository(Profil::class)->findBy(array('id' => array_column($listeVisiteurs, "matricule")));

                $html = $this->render('moduleVisiteurs/moduleVisiteurs.html.twig', array(
                    'title' => 'Gestion des visites',
                    'listeRegions' => $listeRegions,
                    'listeVisiteurs' => $listeVisiteurs,
                    'listeNomsVisiteurs' => $listeNomsVisiteurs
                ));

                return $html;

            } else 
            {
                $html = $this->render('moduleVisiteurs/moduleVisiteurs.html.twig', array(
                    'title' => 'Gestion des visites'
                ));

                return $html;
            }
    	}

        /**
         * @Route("/", name="creationVisite")
         */
        public function creationVisite()
        {
            $user = $this->getUser();

            if($user->hasRole('ROLE_RESPONSABLE'))
            {
                echo "toto";
                $entityManager = $this->getDoctrine()->getManager();
                $data = $request->request;

                $visite = new Visite();

                $visite->setIdPraticien($data->get('id_praticien'));
                $visite->setMatricule($data->get('matricule'));
                $visite->setDateVisite($data->get('date_visite'));
                $visite->setMotif($data->get('motif'));
                $visite->setConvaincu($data->get('convaincu'));
                $visite->setVisitePlanifiee($data->get('contre_visite'));

                $entityManager->persist($visite);
                $entityManager->flush();

                return $this->redirectToRoute('gestionVisite');
            }
            
        }
    }

 ?>