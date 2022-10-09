<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdConotrollerController extends AbstractController
{
    /**
     * @Route("/ad/conotroller", name="ad_conotroller")
     */
    public function index(): Response
    {
        return $this->render('ad_conotroller/login.html.twig', [
            'controller_name' => 'AdConotrollerController',
        ]);
    }
}
