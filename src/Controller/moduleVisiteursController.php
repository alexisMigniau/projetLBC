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

                // Ducoup cela ne marchait pas car dans $listeVisiteurs tu as des objets de type VisiteurRegion car c'est le repository que l'on utilise
                // Et sur ta fonction qui devait recuperer les visites , vu que l'attribut matricule dans la table Visite est de type Visiteur et non VisiteurRegion il ne trouvait rien

                // On crée un tableau vide ou on va ajouter chaque objet Visiteurs
                $listeVisiteursTmp = array();

                //On parcours la liste de tous les visiteurs et on ajoute l'objet dans notre tableau
                foreach($listeVisiteurs as $visiteur)
                    array_push($listeVisiteursTmp , $visiteur->getMatricule());

                $listeVisites = $em->getRepository(Visite::class)->findBy(array("matricule" => $listeVisiteursTmp));
                
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