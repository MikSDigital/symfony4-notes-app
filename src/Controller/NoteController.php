<?php
/**
 * Created by PhpStorm.
 * User: KRÓL ŻYCIA
 * Date: 22.07.2018
 * Time: 13:53
 */

namespace App\Controller;


use App\Entity\Note;
use App\Form\NoteShareType;
use App\Repository\NoteRepository;
use App\Service\UrlGenerator;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NoteController extends Controller
{
    /**
     * @Route("/", name="homepage", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_USER')", statusCode=404, message="Resource not found.")
     * @param NoteRepository $notes
     * @return Response
     */
    public function homepage(NoteRepository $notes, Request $request): Response
    {
        $userId = $this->getUser();
        $authorNotes = $notes->findBy(
            ['user_id' => $userId]
        );

        $forms = array();

        foreach ($authorNotes as $note) {
            $forms[] = $this->createForm(NoteShareType::class, $note)->createView();
        }


        return $this->render('index.html.twig', [
            'notes' => $authorNotes,
            'forms' => $forms
        ]);
    }


    /**
     * @Route("/save", name="save_note")
     */
    public function saveNote(Request $request)
    {

        $userId = $this->getUser();

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

        if ($note->getUserId() === $userId) {
            $note->setContent($noteContent);
            $em->persist($note);
            $em->flush();
        }
        return new Response();
    }

    /**
     * @Route("/share", name="share_note")
     */
    public function shareNote(Request $request, NoteRepository $noteRepository, UrlGenerator $urlGenerator)
    {

        $userId = $this->getUser();

        $url = $request->getSchemeAndHttpHost() . '/';

        $id = (int)$request->request->get('id');
        $input = (string)$request->request->get('title');

        $title = preg_replace('/\s+/', '-', $input);

        $note = $noteRepository->find($id);

        $em = $this->getDoctrine()->getManager();

        if (!$note) {
            throw $this->createNotFoundException(
                'Not found note!'
            );
        }

        if ($note->getUserId() === $userId) {
            while ($noteRepository->findOneBy(
                    ['url' => $title]
                ) !== null) {
                $title = $urlGenerator->urlGenerate($input, $title);
            }

            $note->setUrl($title);
            $em->persist($note);
            $em->flush();
        }


        return new JsonResponse(
            ['url' => $url . $title]
        );
    }

    /**
     * @Route("/{url}", name="note_from_url", methods={"GET"})
     * @Security("is_granted('IS_AUTHENTICATED_ANONYMOUSLY')", statusCode=404, message="Resource not found.")
     */
    public function displayNoteFromUrl($url, NoteRepository $noteRepository)
    {
        $em = $this->getDoctrine()->getManager();

        $note = $noteRepository->findOneBy([
            'url' => $url,
        ]);

        return $this->render('note.html.twig', [
            'note' => $note,
        ]);
    }
}