<?php
/**
 * Created by PhpStorm.
 * User: KRÓL ŻYCIA
 * Date: 22.07.2018
 * Time: 13:53
 */

namespace App\Controller;


use App\Entity\Note;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NoteController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage()
    {
        $userId = $this->getUser()->getId();
        $note = $this->getDoctrine()
            ->getRepository(Note::class)
            ->findBy([
                'user_id' => $userId
            ]);
        if (!$note) {
            throw $this->createNotFoundException(
                'Notes not found'
            );
        }

        $this->denyAccessUnlessGranted('view', $note);

        return $this->render('index.html.twig', [
            'notes' => $note,
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

        $this->denyAccessUnlessGranted('edit', $note);

        $note->setContent($noteContent);
        $em->persist($note);
        $em->flush();

        return new Response();
    }

}