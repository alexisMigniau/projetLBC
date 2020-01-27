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

    /**
    * @Route("/gestionPraticiens")
    */
    class modulePraticiensController extends AbstractController
    {
         /**
         * @Route("/", name="gestionPraticiens")
         */
        public function gestionPraticiens()
        {
            $user = $this->getUser();

            //On recupère la liste des régions, la liste des spécialités
            $em = $this->getDoctrine()->getManager();

            $listeRegion =  $em->getRepository(Region::class)->getRegionsByResponsable($user->getId());
            $listeSpec = $em->getRepository(Specialite::class)->findAll();

            $html = $this->render('modulePraticiens/modulePraticiens.html.twig' , array(
                'title' => 'Gestion des praticiens' , 
                'listeRegion' => $listeRegion,
                'listeSpec' => $listeSpec));

            return $html;
        }

        /**
         * @Route("/creationPraticien", name="creationPraticien", methods={"POST"})
         */
        public function creationPraticien(Request $request)
        {   
            $user = $this->getUser();

            if($user->hasRole('ROLE_RESPONSABLE'))
            {
                $entityManager = $this->getDoctrine()->getManager();
                $data = $request->request;

                //On récupère l'entité spécialité, et région grâce au formulaire
                $specialite = $entityManager->getRepository(Specialite::class)->findOneBy(array('idSpecialite' => $data->get('specialite')));
                $region = $entityManager->getRepository(Region::class)->findOneBy(array('regCode' => $data->get('region')));

                // On crée un praticien
                $praticien = new Praticiens();

                $praticien->setMail($data->get('email'));
                $praticien->setNom($data->get('nom'));
                $praticien->setPrenom($data->get('Prenom'));
                $praticien->setNotoriete($data->get('notoriete'));
                $praticien->setAdresse($data->get('adresse'));
                $praticien->setLongitude($data->get('longitude'));
                $praticien->setLatitude($data->get('latitude'));
                $praticien->setIdSpecialite($specialite);

                // On ajoute le praticien au portefeuille des visiteurs qui sont sélectionnées
                $listeIdVisiteur = $data->get('listeVisiteur');
                
                foreach($listeIdVisiteur as $visiteur)
                {
                    $objectVisiteur = $entityManager->getRepository(Visiteur::class)->findOneBy(array('matricule' => $visiteur));
                    $praticien->addMatricule($objectVisiteur);
                }

                // On fait l'affectation entre le praticien et la région
                $praticienRegion = new PraticiensRegion();
                $praticienRegion->setIdPraticiens($praticien);
                $praticienRegion->setRegCode($region);

                // On enregistre la création du praticiens, et son affectation
                $entityManager->persist($praticienRegion);
                $entityManager->persist($praticien);

                // On execute les requêtes qui ont été générer précédement
                $entityManager->flush();

                $this->addFlash('success', 'Vous avez créer un praticiens');
                return $this->redirectToRoute('gestionPraticiens');

            }
        }

        /**
         * @Route("/ajouterSpecialite", name="ajouterSpecialite")
         */
        public function ajouterSpecialite(Request $request)
        {
            $user = $this->getUser();

            if($user->hasRole('ROLE_RESPONSABLE'))
            {
                $nomSpec = $request->get('nomSpecialite');

                $em = $this->getDoctrine()->getManager();

                //On créée un région avec le nom demandée en paramêtre qui est liée au secteur du responsable connectée
                $spec = new Specialite();

                $spec->setNomSpecialite($nomSpec);

                $em->persist($spec);
                $em->flush();

                return new Response($spec->getIdSpecialite());
            }
        }

        /**
         * @Route("/getVisiteurByRegion", name="getVisiteurByRegion")
         */
        public function getVisiteurByRegion(Request $request)
        {
            $user = $this->getUser();

            if($user->hasRole('ROLE_RESPONSABLE'))
            {
                $regCode = $request->get('regCode');

                $em = $this->getDoctrine()->getManager();
                $listeVisiteur = $em->getRepository(VisiteurRegion::class)->getVisiteurByIdRegion($regCode);

                return new JsonResponse($listeVisiteur);
            }
        }
    }
?>