<?php
    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use App\Service\FileUploader;

    use App\Entity\Region;
    use App\Entity\VisiteurRegion;
    use App\Entity\Specialite;
    use App\Entity\Praticiens;
    use App\Entity\PraticiensRegion;
    use App\Entity\Visiteur;

    use App\Entity\ReferenceForfait;
    use App\Entity\Fichefrais;
    use App\Entity\Forfaitaires;
    use App\Entity\Frais;
    use App\Entity\Horsforfait;

    use Dompdf\Dompdf;
    use Dompdf\Options;

    /**
    * @Route("/gestionFrais")
    */
    class moduleFraisController extends AbstractController
    {
         /**
         * @Route("/", name="gestionFrais") 
         */
        public function gestionFrais()
        {
            //On recupère la liste des références de forfait
            $em = $this->getDoctrine()->getManager();

            $listeRefForfait = $em->getRepository(ReferenceForfait::class)->findAll();

            // On recupère le  visiteur qui est connecté actuellement
            $user = $this->getUser();
            
            // On recupère la fiche du mois actuelle si il n'y en a pas alors on crée une fiche
            $moisActuelle = new \DateTime();

            $moisActuelle = new \DateTime($moisActuelle->format('Y-m-1'));
            $ficheActuelle = $em->getRepository(Fichefrais::class)->findOneBy(array('matricule' => $user->getId() , 'mois' => $moisActuelle));

            // Si il ne trouve pas de résultat alors on crée la fiche
            if($ficheActuelle == null)
            { //ficheFrais: enregistrer dans la bdd
                $fiche = new Fichefrais();

                $fiche->setMatricule($user->getId());
                $fiche->setMois($moisActuelle);
                $fiche->setEtat(0);

                $em->persist($fiche);
                $em->flush();

                $fiche = $ficheActuelle;
            }
            //SELECT ALL FROM Frais WHERE Fiche = $ficheactuelle (qui est un param) idFiche est le nom du champs dans Frais

            $listeFrais = $em->getRepository(Frais::class)->findBy(array('idFiche' => $ficheActuelle));
            //en haut, la ligne pour récuperer la données de la table Frais

            // Je parcours la liste de tous les frais, et je met leur id dans un tableau , ce tableau permet de faire la recherche 
            $listeIdFrais = array();

            foreach($listeFrais as $frais)
            {
                array_push($listeIdFrais, $frais->getIdFrais());
            }

            $listeForfaitaires = $em->getRepository(Forfaitaires::class)->findBy(array('idFrais' => $listeIdFrais));
            $listeHorsForfait = $em->getRepository(HorsForfait::class)->findBy(array('idFrais' => $listeIdFrais));

            // Je recupère  les fiches qui sont liée à l'utilisateur et l'etat = 2  ET MOIS ACTUELLE
            $listeFicheValide = $em->getRepository(Fichefrais::class)->findBy(array('matricule' => $user->getId()));
            $listeFicheRembourse = $em->getRepository(Fichefrais::class)->findBy(array('matricule' => $user->getId(), 'etat' => '4' ));


            //On récupère les frais validées
            $listeFraisValide = $em->getRepository(Frais::class)->findBy(array('idFiche' => $listeFicheValide ));

            $listeForfaitairesValide = $em->getRepository(Forfaitaires::class)->findBy(array('idFrais' => $listeFraisValide));
            $listeHorsForfaitValide = $em->getRepository(HorsForfait::class)->findBy(array('idFrais' => $listeFraisValide));
           
            $html = $this->render('moduleFrais/moduleFrais.html.twig', array(
                'title' => 'Gestion des frais' ,
                'listeRefForfait' => $listeRefForfait,
                'listeForfaitaires' => $listeForfaitaires,
                'listeHorsForfait' => $listeHorsForfait,
                'listeFicheValide' => $listeFicheValide,
                'listeForfaitairesValide' => $listeForfaitairesValide,
                'listeHorsForfaitValide' => $listeHorsForfaitValide,
                'listeFicheRembourse' => $listeFicheRembourse
                
            ));
            return $html;
        }
        
        /**
         * @Route("/ajouterFrais", name="ajouterFrais", methods={"POST"}) 
         */
        public function ajouterFrais(Request $request)
        {
            //On recupère la liste données saisit par le visiteurs
            $em = $this->getDoctrine()->getManager();

            // On recupère le  visiteur qui est connecté actuellement
            $user = $this->getUser();
            $visiteur = $em->getRepository(Visiteur::class)->findOneBy(array('matricule' => $user->getId()));

            // On recupère la fiche du mois courant
            $moisActuelle = new \DateTime();

            $moisActuelle = new \DateTime($moisActuelle->format('Y-m-1'));
            $ficheActuelle = $em->getRepository(Fichefrais::class)->findOneBy(array('matricule' => $user->getId() , 'mois' => $moisActuelle));

            $data = $request->request; // recuperer les données du formulaire ($_POST)

            // On crée un nouveau objet frais
            $frais = new Frais();
            $frais->setValide(false);
            $frais->setIdFiche($ficheActuelle);
            $em->persist($frais);

            if($data->get('typeFrais') == "0")
            {
                $forfait = new Forfaitaires();

                //On lie le forfataires au frais
                $forfait->setIdFrais($frais);

                $forfait->setQuantite($data->get('quantite'));

                // On recupère le type de frais forfaitaires
                $referenceForfait = $em->getRepository(ReferenceForfait::class)->findOneBy(array('nom' => $data->get('typeFraisForfaitaires')));
                $forfait->setTypeFrais($referenceForfait);

                $em->persist($forfait);
                $em->flush();

            } else if($data->get('typeFrais') == "1")
            {
                $forfait = new Horsforfait();

                //On lie le forfataires au frais
                $forfait->setIdFrais($frais);

                $forfait->setNomHorsforfait($data->get('libelle'));
                $forfait->setMontant($data->get('montant'));
                $forfait->setDateHorsforfait(new \DateTime($data->get('Date')));
                
                // On recupère le fichier
                $uploadedFile = $request->files->get('facture');

                // On rajoute un id au début du nom de fichier
                $filename = uniqid() . '-' . $uploadedFile->getClientOriginalName();
                
                $uploadedFile->move("gestionFrais/" , $filename);
                $forfait->setFacture($filename);

                $em->persist($forfait);
                $em->flush();
            }

            //addFlash petite flash notification
            $this->addFlash('success', 'Vous avez bien ajouté un frais');

            // Permet de rediriger vers la page des frais
            return $this->redirectToRoute('gestionFrais');
        }

        /**
         * @Route("/genererFicheFrais/{idFiche}", name="genererFicheFrais")
         */
        public function genererPdf($idFiche)
        {
            $em = $this->getDoctrine()->getManager();

            // On recupère l'objet fiche
            $fiche = $em->getRepository(Fichefrais::class)->findOneBy(array("idFiche" => $idFiche));

            $listeFrais = $em->getRepository(Frais::class)->findBy(array('idFiche' => $fiche));
            //en haut, la ligne pour récuperer la données de la table Frais

            // Je parcours la liste de tous les frais, et je met leur id dans un tableau , ce tableau permet de faire la recherche 
            $listeIdFrais = array();

            foreach($listeFrais as $frais)
            {
                array_push($listeIdFrais, $frais->getIdFrais());
            }

            //On récupere la liste des Frais de la fiche valide
            $listeForfaitairesValide = $em->getRepository(Forfaitaires::class)->findBy(array('idFrais' => $listeIdFrais));
            $listeHorsForfaitValide = $em->getRepository(HorsForfait::class)->findBy(array('idFrais' => $listeIdFrais));
            $user = $this->getUser();

            
            $fichePdf = array(
                    'fiche' => $fiche,
                    'listeForfaitaires' => $listeForfaitairesValide,
                    'listeHorsForfait' => $listeHorsForfaitValide,
                    'user' => $user
            );
            
            $html = $this->renderView('moduleFrais/fiche_frais_pdf.html.twig' , $fichePdf);

            $pdfOptions = new Options();
            $pdfOptions->set('defaultFont', 'Arial');
            $fiche_frais_pdf = new Dompdf($pdfOptions);
            $fiche_frais_pdf->loadHtml($html);
            $fiche_frais_pdf->setPaper('A4', 'portrait');
            $fiche_frais_pdf->render();

            $nomFichier = "fiche_frais";
            return new Response($fiche_frais_pdf->stream($nomFichier));
        }

        /**
         * @Route("/genererRemboursement/{idFiche}", name="genererRemboursement")
         */
        public function genererPdfRemboursement($idFiche)
        {
            $em = $this->getDoctrine()->getManager();

            // On recupère l'objet fiche
            $fiche = $em->getRepository(Fichefrais::class)->findOneBy(array("idFiche" => $idFiche));

            $listeFrais = $em->getRepository(Frais::class)->findBy(array('idFiche' => $fiche));
            //en haut, la ligne pour récuperer la données de la table Frais

            // Je parcours la liste de tous les frais, et je met leur id dans un tableau , ce tableau permet de faire la recherche 
            $listeIdFrais = array();

            foreach($listeFrais as $frais)
            {
                array_push($listeIdFrais, $frais->getIdFrais());
            }

            //On récupere la liste des Frais de la fiche valide
            $listeForfaitairesValide = $em->getRepository(Forfaitaires::class)->findBy(array('idFrais' => $listeIdFrais));
            $listeHorsForfaitValide = $em->getRepository(HorsForfait::class)->findBy(array('idFrais' => $listeIdFrais));
            $user = $this->getUser();

            
            $fichePdf = array(
                    'fiche' => $fiche,
                    'listeForfaitaires' => $listeForfaitairesValide,
                    'listeHorsForfait' => $listeHorsForfaitValide,
                    'user' => $user
            );
            
            $html = $this->renderView('moduleFrais/remboursement_pdf.html.twig' , $fichePdf);

            $pdfOptions = new Options();
            $pdfOptions->set('defaultFont', 'Arial');
            $pdfOptions->set('isRemoteEnabled',true);   
            $fiche_frais_pdf = new Dompdf($pdfOptions);
            $fiche_frais_pdf->loadHtml($html);
            $fiche_frais_pdf->setPaper('A4', 'portrait');
            $fiche_frais_pdf->render();

            $nomFichier = "remboursement";
            return new Response($fiche_frais_pdf->stream($nomFichier));
        }

         /**
         * @Route("/SupprimerFrais/{id}", name="SupprimerFrais") 
         */
        public function supprimerFrais(Request $request, $id) 
        {
            // On recupère l'entity manager
            $entityManager = $this->getDoctrine()->getManager();

            $repository = $entityManager->getRepository(Frais::class);
            // Récupération du frais (donc automatiquement géré par Doctrine)
            $lignefrais = $repository->findOneBy(array('idFrais' => $id));
            $entityManager->remove($lignefrais);
            $entityManager->flush();

            //addFlash petite flash notification
            $this->addFlash('success', 'Vous avez supprimé le frais');

            // Permet de rediriger vers la page des frais
            return $this->redirectToRoute('gestionFrais');
        }
 
    }
?>