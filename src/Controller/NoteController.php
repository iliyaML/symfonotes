<?php
    namespace App\Controller;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    class NoteController extends Controller {
        /**
         * @Route("/")
         * @Method({"GET"})
         */
        public function index(){
            $notes = ['Note 1', 'Note 2'];

            // return new Response ('<html><body>Hello</body></html>');
            return $this->render('notes/index.html.twig', array('notes' => $notes));
        }
    }