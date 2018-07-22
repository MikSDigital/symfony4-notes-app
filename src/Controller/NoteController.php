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
use Symfony\Component\Routing\Annotation\Route;

class NoteController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage()
    {
        $user_id = $this->getUser()->getId();
        $notes = $this->getDoctrine()
            ->getRepository(Note::class)
            ->findBy([
                'user_id' => $user_id
            ]);
        if (!$notes) {
            throw $this->createNotFoundException(
                'Notes not found'
            );
        }

        return $this->render('index.html.twig', [
            'notes' => $notes
        ]);
    }
}