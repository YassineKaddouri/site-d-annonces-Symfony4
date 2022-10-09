<?php

namespace App\Controller;

use App\Entity\User;
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class UserController extends Controller
{
    /**
     * @Route("/user/{slug}", name="user_show")
     */
    public function index(User $user): Response
    {
        return $this->render('user/index.html.twig', [
            'user' => $user
        ]);
    }
}
