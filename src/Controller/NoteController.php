<?php
    namespace App\Controller;

    use App\Entity\Note;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;

    class NoteController extends Controller {
        /**
         * @Route("/", name="note_list")
         * @Method({"GET"})
         */
        public function index(){
            // $notes = ['Note 1', 'Note 2'];
            $notes = $this->getDoctrine()->getRepository(Note::class)->findAll();

            // return new Response ('<html><body>Hello</body></html>');
            return $this->render('notes/index.html.twig', array('notes' => $notes));
        }

        /**
         * @Route("/note/new")
         * Method({"GET", "POST"})
         */
        public function new(Request $request){
            $note = new Note();

            $form = $this->createFormBuilder($note)
            ->add('title', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('body', TextareaType::class, array(
                'required' => false,
                'attr' => array('class' => 'form-control')
              ))
              ->add('save', SubmitType::class, array(
                'label' => 'Create',
                'attr' => array('class' => 'btn btn-primary mt-3')
              ))
              ->getForm();

              $form->handleRequest($request);
              if($form->isSubmitted() && $form->isValid()){
                $note = $form->getData();

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($note);
                $entityManager->flush();

                return $this->redirectToRoute('note_list');
              }

              return $this->render('notes/new.html.twig', array('form' => $form->createView()));
        }

    /**
     * @Route("/note/edit/{id}", name="edit_edit")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
        $note = new Note();
        $note = $this->getDoctrine()->getRepository(Note::class)->find($id);
        $form = $this->createFormBuilder($note)
          ->add('title', TextType::class, array('attr' => array('class' => 'form-control')))
          ->add('body', TextareaType::class, array(
            'required' => false,
            'attr' => array('class' => 'form-control')
          ))
          ->add('save', SubmitType::class, array(
            'label' => 'Update',
            'attr' => array('class' => 'btn btn-primary mt-3')
          ))
          ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->flush();
          return $this->redirectToRoute('note_list');
        }
        return $this->render('notes/edit.html.twig', array(
          'form' => $form->createView()
        ));
      }

        /**
         * @Route("/note/{id}")
         */
        public function show($id){
            $note = $this->getDoctrine()->getRepository(Note::class)->find($id);

            return $this->render('notes/show.html.twig', array('note' => $note));
        }

        /**
         * @Route("/note/delete/{id}")
         * @Method({"DELETE"})
         */
        public function delete(Request $request, $id) {
            $note = $this->getDoctrine()->getRepository(Note::class)->find($id);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($note);
            $entityManager->flush();
            $response = new Response();
            $response->send();
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