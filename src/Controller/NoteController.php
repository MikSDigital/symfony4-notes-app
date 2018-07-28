<?php
/**
 * Created by PhpStorm.
 * User: KRÓL ŻYCIA
 * Date: 22.07.2018
 * Time: 13:53
 */

namespace App\Controller;


use App\Entity\Note;
use App\Repository\NoteRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NoteController extends Controller
{
    /**
     * @Route("/", name="homepage", methods={"GET"})
     * @Security("is_granted('ROLE_USER')", statusCode=404, message="Resource not found.")
     * @param NoteRepository $notes
     * @return Response
     */
    public function homepage(NoteRepository $notes): Response
    {
        $userId = $this->getUser();
        $authorNotes = $notes->findBy(
            ['user_id' => $userId]
        );

        return $this->render('index.html.twig', [
            'notes' => $authorNotes,
        ]);
    }


    /**
     * @Route("/save", name="save_note")
     */
    public function saveNote(Request $request)
    {

        $userId = $this->getUser()->getId();

        $id = (int)$request->request->get('id');
        $noteContent = $request->request->get('content');


        $note = $this->getDoctrine()
            ->getRepository(Note::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();

        if (!$note) {
            throw $this->createNotFoundException(
                'Not found note!'
            );
        }


        $note->setContent($noteContent);
        $em->persist($note);
        $em->flush();

        return new Response();
    }


//    /**
//     * @Route("/share/{id}", requirements={"id" = "\d+"} name="share_note")
//     */
//    public function share($id)
//    {
//
//    }

}