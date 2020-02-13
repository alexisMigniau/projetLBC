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
    * @Route("/gestionVisite")
    */
    class moduleVisiteursController extends AbstractController
    {

    	/**
         * @Route("/", name="gestionVisite")
         */
    	public function gestionVisite()
    	{
    		$html = $this->render('moduleVisiteurs/moduleVisiteurs.html.twig', array(
    			'title' => 'Gestion des visites'
    		));

    		return $html;
    	}

        /**
         * @Route("/", name="creationVisite")
         */
        public function creationVisite()
        {
            return $this->redirectToRoute('gestionVisite');
        }
    }

 ?>