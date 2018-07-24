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
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $notes = $this->getDoctrine()
            ->getRepository(Note::class)
            ->findBy([
                'user_id' => $userId
            ]);
        if (!$notes) {
            throw $this->createNotFoundException(
                'Notes not found'
            );
        }

        return $this->render('index.html.twig', [
            'notes' => $notes,
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

//        return new JsonResponse(array(
//            'id' => $id,
//            'content' => $noteContent,
//
//        ));

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

}