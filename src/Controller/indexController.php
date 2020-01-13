<?php
    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
    use Symfony\Component\HttpFoundation\Request;
    use App\Entity\Profil;

    class indexController extends AbstractController
    {
        /**
         * @Route("/", name="home")
         */
        public function home()
        {
            $html = $this->render('base.html.twig' , array('title' => 'Bonjour'));

            return $html;
        }

        /**
         * @Route("/login", name="login")
         */
        public function login()
        {
            $html = $this->render('login.html.twig');

            return $html;
        }

        /**
         * @Route("/register", name="register")
         */
        public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
        {
            //Si c'est une méthode POST cela veut dire que l'utilisateur à renvoyer le formulaire on doit donc lui créer un compte
            if($request->isMethod('post'))
            {
                $profil = new Profil();

                $passwordChiffrer = $passwordEncoder->encodePassword($profil, $request->get('InputPassword'));

                $profil->setPassword($passwordChiffrer);
                $profil->setUsername($request->request->get('email'));
                $profil->setNom($request->get('nom'));
                $profil->setPrenom($request->get('prenom'));

                //On enregistre ce qu'on vient de faire avant
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($profil);
                $entityManager->flush();

                $this->addFlash('success', 'Votre compte à bien été enregistré.');
                return $this->redirectToRoute('login');
            }
            
            $html = $this->render('register.html.twig');

            return $html;
        }
    }
?>