<?php
    namespace App\Controller;

    use App\Entity\Note;

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
            // $notes = ['Note 1', 'Note 2'];
            $notes = $this->getDoctrine()->getRepository(Note::class)->findAll();

            // return new Response ('<html><body>Hello</body></html>');
            return $this->render('notes/index.html.twig', array('notes' => $notes));
        }

        /**
         * @Route("/note/{id}")
         */
        public function show($id){
            $note = $this->getDoctrine()->getRepository(Note::class)->find($id);

            return $this->render('notes/show.html.twig', array('note' => $note));
        }

        // /**
        //  * @Route("/note/save")
        //  */
        // public function save(){
        //     $entityManager = $this->getDoctrine()->getManager();

        //     $note = new Note();
        //     $note->setTitle('Note Two');
        //     $note->setBody('This is the body for note two');

        //     // Tells us to eventually save it
        //     $entityManager->persist($note);

        //     // Actually save it
        //     $entityManager->flush();

        //     return new Response('Saved a note with the id of ' . $note->getId());
        // }
    }