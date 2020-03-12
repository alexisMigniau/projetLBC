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
    use App\Entity\Visiteur;
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
                $listePraticiens = $em->getRepository(Praticiens::class)->findAll();
                $listeRegions =  $em->getRepository(Region::class)->getRegionsByResponsable($user->getId());
                $listeVisiteurs = $em->getRepository(VisiteurRegion::class)->findBy(array('regCode' => array_column($listeRegions , "regCode") , 'active' => 1));
                $listeVisites = $em->getRepository(Visite::class)->findAll();
                //$listeVisites = $em->getRepository(Visite::class)->findBy(array_column($listeVisiteurs, "matricule")));

                $html = $this->render('moduleVisiteurs/moduleVisiteurs.html.twig', array(
                    'title' => 'Gestion des visites',
                    'listePraticiens' => $listePraticiens,
                    'listeRegions' => $listeRegions,
                    'listeVisiteurs' => $listeVisiteurs,
                    'listeVisites' => $listeVisites
                ));

                return $html;

            } else if ($user->hasRole('ROLE_VISITEUR'))
            {
                $listeVisites = $em->getRepository(Visite::class)->findBy(array('matricule' => $user->getId()));
                $listePraticiens = $em->getRepository(Visiteur::class)->findOneBy(array('matricule' => $user->getId()))->getIdPraticiens();

                $html = $this->render('moduleVisiteurs/moduleVisiteurs.html.twig', array(
                    'title' => 'Gestion des visites',
                    'listePraticiens' => $listePraticiens,
                    'listeVisites' => $listeVisites,
                    'matricule' => $user->getId()
                ));

                return $html;
            }
    	}

        /**
         * @Route("/creationVisite", name="creationVisite", methods={"POST"})
         */
        public function creationVisite(Request $request)
        {
            $user = $this->getUser();

            if($user->hasRole('ROLE_RESPONSABLE'))
            {
                $entityManager = $this->getDoctrine()->getManager();
                $data = $request->request;

                $praticien = $entityManager->getRepository(Praticiens::class)->findOneBy(array('idPraticiens' => $data->get('praticien')));
                
                $visiteur = $entityManager->getRepository(Visiteur::class)->findOneBy(array('matricule' => $data->get('visiteur')));

                $visite = new Visite();
                $visite->setIdPraticiens($praticien);
                $visite->setMatricule($visiteur);
                $visite->setDateVisite(new \DateTime($data->get('date_visite')));
                $visite->setMotif($data->get('motif'));
                $visite->setConvaincu($data->get('convaincu'));
                $visite->setVisitePlanifie(new \DateTime($data->get('contre_visite')));

                $entityManager->persist($visite);
                $entityManager->flush();

                return $this->redirectToRoute('gestionVisite');
            }
            
        }
    }

 ?>