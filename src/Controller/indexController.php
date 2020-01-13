<?php
    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Routing\Annotation\Route;

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
        public function register()
        {
            $html = $this->render('register.html.twig');

            return $html;
        }
    }
?>