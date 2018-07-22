<?php
/**
 * Created by PhpStorm.
 * User: KRÓL ŻYCIA
 * Date: 21.07.2018
 * Time: 13:51
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage()
    {
        return $this->render('index.html.twig');
    }

}