<?php 
    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\Mailer\MailerInterface;
    use Symfony\Component\Mime\Email;

    use Dompdf\Dompdf;
    use Dompdf\Options;

    use App\Entity\Region;
    use App\Entity\Profil;
    use App\Entity\VisiteurRegion;
    use App\Entity\Praticiens;
    use App\Entity\PraticiensRegion;
    use App\Entity\Visiteur;
    use App\Entity\Visite;
    use App\Entity\Medicament;
    use App\Entity\Offrir;
	
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

            $entityManager = $this->getDoctrine()->getManager();

            if ($user->hasRole('ROLE_RESPONSABLE'))
            {
                $listeRegions =  $entityManager->getRepository(Region::class)->getRegionsByResponsable($user->getId());
                $listeMedicament = $entityManager->getRepository(Medicament::class)->findAll();
                $listePraticiens = $entityManager->getRepository(PraticiensRegion::class)->findBy(array('regCode' => array_column($listeRegions , "regCode") , 'active' => 1));
                $listeVisiteurs = $entityManager->getRepository(VisiteurRegion::class)->findBy(array('regCode' => array_column($listeRegions , "regCode") , 'active' => 1));

                // On crée un tableau vide ou on va ajouter chaque objet Visiteurs
                $listeVisiteursTmp = array();

                //On parcours la liste de tous les visiteurs et on ajoute l'objet dans notre tableau
                foreach($listeVisiteurs as $visiteur)
                    array_push($listeVisiteursTmp , $visiteur->getMatricule());

                $listeVisites = $entityManager->getRepository(Visite::class)->findBy(array("matricule" => $listeVisiteursTmp));
                
                $html = $this->render('moduleVisiteurs/moduleVisiteurs.html.twig', array(
                    'title' => 'Gestion des visites',
                    'listePraticiens' => $listePraticiens,
                    'listeRegions' => $listeRegions,
                    'listeVisiteurs' => $listeVisiteurs,
                    'listeVisites' => $listeVisites,
                    'listeMedicament' => $listeMedicament
                ));

                return $html;

            } else if ($user->hasRole('ROLE_VISITEUR'))
            {
                $listeVisites = $entityManager->getRepository(Visite::class)->findBy(array('matricule' => $user->getId()));
                $listePraticiens = $entityManager->getRepository(Visiteur::class)->findOneBy(array('matricule' => $user->getId()))->getIdPraticiens();
                $listeMedicament = $entityManager->getRepository(Medicament::class)->findAll();

                $html = $this->render('moduleVisiteurs/moduleVisiteurs.html.twig', array(
                    'title' => 'Gestion des visites',
                    'listePraticiens' => $listePraticiens,
                    'listeVisites' => $listeVisites,
                    'matricule' => $user->getId(),
                    'nom' => $user->getNom(),
                    'prenom' => $user->getPrenom(),
                    'listeMedicament' => $listeMedicament
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

            for ($i=1; $i <= $data->get('nbMedicaments'); $i++)
            { 
                $numMedicament = "medicament".$i;
                $$numMedicament = $entityManager->getRepository(Medicament::class)->findOneBy(array('idMedicament' => $data->get('medicament'.$i)));
                $visite->addIdMedicament($$numMedicament);

                $offrir = new Offrir();
                $offrir->setIdVisite($visite);
                $offrir->setIdMedicament($$numMedicament);
                $offrir->setQuantiteEchantillon($data->get('quantite'.$i));
                $entityManager->persist($offrir); 
            }

            $entityManager->persist($visite);
            $entityManager->flush();

            return $this->redirectToRoute('gestionVisite');
        }

        /**
         * @Route("/modificationVisite", name="modificationVisite", methods={"POST"})
         */
        public function modificationVisite(Request $request)
        {
            $user = $this->getUser();

            $entityManager = $this->getDoctrine()->getManager();
            $data = $request->request;

            $visite = $entityManager->getRepository(Visite::class)->findOneBy(array('idVisite' => $data->get('id')));
            $praticien = $entityManager->getRepository(Praticiens::class)->findOneBy(array('idPraticiens' => $data->get('praticien')));
            $visiteur = $entityManager->getRepository(Visiteur::class)->findOneBy(array('matricule' => $data->get('visiteur')));

            $visite->setIdPraticiens($praticien);
            $visite->setMatricule($visiteur);
            $visite->setDateVisite(new \DateTime($data->get('date_visite')));
            $visite->setMotif($data->get('motif'));
            $visite->setConvaincu($data->get('convaincu'));
            $visite->setVisitePlanifie(new \DateTime($data->get('contre_visite')));

            $visite->clearMedicamentOffrir();

            $listeOffrirASupprimer = $entityManager->getRepository(Offrir::class)->findBy(array('idVisite' => $visite));

            foreach ($listeOffrirASupprimer as $offrirASupprimer)
            {
                $entityManager->remove($offrirASupprimer);
                $entityManager->flush();
            }

            for ($i=1; $i <= $data->get('nbMedicaments'); $i++) { 
                $numMedicament = "medicament".$i;
                $$numMedicament = $entityManager->getRepository(Medicament::class)->findOneBy(array('idMedicament' => $data->get('medicament'.$i)));
                if (isset($$numMedicament)) 
                {
                    $visite->addIdMedicament($$numMedicament);
                    $offrir = new Offrir();
                    $offrir->setIdVisite($visite);
                    $offrir->setIdMedicament($$numMedicament);
                    $offrir->setQuantiteEchantillon($data->get('quantite'.$i));
                    $entityManager->persist($offrir); 
                }
            }

            $entityManager->persist($visite);
            $entityManager->flush();

            return $this->redirectToRoute('gestionVisite');
        }

        /**
         * @Route("/suppressionVisite", name="suppressionVisite", methods={"POST"})
         */
        public function suppressionVisite(Request $request)
        {
            $entityManager = $this->getDoctrine()->getManager();
            $data = $request->request;

            $visite = $entityManager->getRepository(Visite::class)->findOneBy(array('idVisite' => $data->get('id')));

            $entityManager->remove($visite);
            $entityManager->flush();

            return $this->redirectToRoute('gestionVisite');
        }

        /**
         * @Route("/genererPdf", name="genererPdf", methods={"POST"})
         */
        public function genererPdf(Request $request)
        {
            $data = $request->request;
            $entityManager = $this->getDoctrine()->getManager();

            $visite = $entityManager->getRepository(Visite::class)->findOneBy(array('idVisite' => $data->get('id')));
            $praticien = $entityManager->getRepository(Praticiens::class)->findOneBy(array('idPraticiens' => $data->get('praticien')));
            $visiteur = $entityManager->getRepository(Profil::class)->findOneBy(array('id' => $data->get('visiteur')));

            if ($data->get('convaincu') == "on") 
                {   $convaincu = "Oui";  }
            else {  $convaincu = "Non";  }

            $infosVisite = array(
                'visite' => $visite,
                'idVisite' => $data->get('id'),
                'prenomPraticien' => $praticien->getPrenom(),
                'nomPraticien' => $praticien->getNom(),
                'prenomVisiteur' => $visiteur->getPrenom(),
                'nomVisiteur' => $visiteur->getNom(),
                'dateVisite' => date('d/m/Y', strtotime($data->get('date_visite'))),
                'contreVisite' => date('d/m/Y', strtotime($data->get('contre_visite'))),
                'motif' => $data->get('motif'),
                'convaincu' => $convaincu,
                'nbMedicaments' => $data->get('nbMedicaments')
            );

            $html = $this->renderView('moduleVisiteurs/compterendupdf.html.twig', $infosVisite);
            
            $pdfOptions = new Options();
            $pdfOptions->set('defaultFont', 'Lato');
            $compteRenduPdf = new Dompdf($pdfOptions);
            $compteRenduPdf->loadHtml($html);
            $compteRenduPdf->setPaper('A4', 'portrait');
            $compteRenduPdf->render();

            $nomFichier = "compte_rendu_". $data->get('id');

            return new Response($compteRenduPdf->stream($nomFichier));
        }

        /**
         * @Route("/envoiMail", name="envoiMail", methods={"POST"})
         */
        public function envoiMail(Request $request, \Swift_Mailer $mailer)
        {
            $data = $request->request;
            $entityManager = $this->getDoctrine()->getManager();

            $visite = $entityManager->getRepository(Visite::class)->findOneBy(array('idVisite' => $data->get('id')));
            $praticien = $entityManager->getRepository(Praticiens::class)->findOneBy(array('idPraticiens' => $data->get('praticien')));
            $visiteur = $entityManager->getRepository(Profil::class)->findOneBy(array('id' => $data->get('visiteur')));

            if ($data->get('convaincu') == "on") 
                {   $convaincu = "Oui";  }
            else {  $convaincu = "Non";  }

            $infosVisite = array(
                'visite' => $visite,
                'idVisite' => $data->get('id'),
                'prenomPraticien' => $praticien->getPrenom(),
                'nomPraticien' => $praticien->getNom(),
                'prenomVisiteur' => $visiteur->getPrenom(),
                'nomVisiteur' => $visiteur->getNom(),
                'dateVisite' => date('d/m/Y', strtotime($data->get('date_visite'))),
                'contreVisite' => date('d/m/Y', strtotime($data->get('contre_visite'))),
                'motif' => $data->get('motif'),
                'convaincu' => $convaincu,
                'nbMedicaments' => $data->get('nbMedicaments')
            );

            $html = $this->renderView('moduleVisiteurs/compterendupdf.html.twig', $infosVisite);
            
            $pdfOptions = new Options();
            $pdfOptions->set('defaultFont', 'Arial');
            $compteRenduPdf = new Dompdf($pdfOptions);
            $compteRenduPdf->loadHtml($html);
            $compteRenduPdf->setPaper('A4', 'portrait');
            $compteRenduPdf->render();

            $nomFichier = "compte_rendu_". $data->get('id');
            $data = $compteRenduPdf->output();

            $email = (new \Swift_Message('Compte rendu de la visite de '. $visiteur->getPrenom(). ' '. $visiteur->getNom()))
            ->setFrom('projetlbc2020@gmail.com')
            ->setTo('client.projetlbc@gmail.com')
            ->setBody('Voici le compte rendu de la visite effectuée. Ceci est un mail automatique !');

            $attachement = new \Swift_Attachment($data, $nomFichier, 'application/pdf' );
            $email->attach($attachement);
            $mailer->send($email);

            return $this->redirectToRoute('gestionVisite');
        }
    }

 ?>