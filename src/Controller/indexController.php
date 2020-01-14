<?php
    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
    use App\Entity\Profil;
    use App\Entity\Secteur;
    use App\Entity\Comptable;
    use App\Entity\Visiteur;

    class indexController extends AbstractController
    {
        /**
         * @Route("/home", name="home")
         */
        public function home()
        {
            $html = $this->render('base.html.twig' , array('title' => 'Bonjour'));

            return $html;
        }

        /**
         * @Route("/", name="login")
         */
        public function login(AuthenticationUtils $authenticationUtils): Response
        {
            // get the login error if there is one
            $error = $authenticationUtils->getLastAuthenticationError();
            // last username entered by the user
            $lastUsername = $authenticationUtils->getLastUsername();

            return $this->render('login.html.twig', [
                'last_username' => $lastUsername,
                'error' => $error
            ]);
        }

        /**
         * @Route("/register", name="register")
         */
        public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
        {
            //Si c'est une méthode POST cela veut dire que l'utilisateur à renvoyer le formulaire on doit donc lui créer un compte
            if($request->isMethod('post'))
            {
                $roleDemande = $request->get('role');

                //On check si il y a deja un compte avec cette adresse email
                $profil = $this->getDoctrine()->getManager()->getRepository(Profil::class)->findBy(array('email' => $request->request->get('email')));

                if(!empty($profil))
                {
                    $this->addFlash('danger', 'Un compte existe déja avec cette adresse email');
                    $html = $this->render('register.html.twig');

                    return $html;
                }

                $profil = new Profil();

                //On chiffre le mot de passe
                $passwordChiffrer = $passwordEncoder->encodePassword($profil, $request->get('password'));

                $profil->setPassword($passwordChiffrer);
                $profil->setUsername($request->request->get('email'));
                $profil->setNom($request->get('nom'));
                $profil->setPrenom($request->get('prenom'));
                $profil->setRoles(array('ROLE_USER', $roleDemande));

                //En fonction du rôle demander, on crée un nouvelle objet
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($profil);
                $entityManager->flush();

                if($roleDemande == 'ROLE_RESPONSABLE')
                {
                    $secteur = new Secteur($profil->getId());
                    $entityManager->persist($secteur);
                }
                else if($roleDemande == 'ROLE_COMPTABLE')
                {
                    $compt = new Comptable($profil->getId());
                    $entityManager->persist($compt);
                }
                else if($roleDemande == 'ROLE_VISITEUR')
                {
                    $visiteur = new Visiteur($profil->getId());
                    $entityManager->persist($visiteur);
                }

                //On enregistre ce qu'on vient de faire avant
                $entityManager->flush();

                $this->addFlash('success', 'Votre compte à bien été enregistré.');
                return $this->redirectToRoute('login');
            }
            
            $html = $this->render('register.html.twig');

            return $html;
        }
    }
?>