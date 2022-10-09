<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class HomeController extends Controller{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        //return new Response("Bonjour yassine hhh ");
        return $this->render(
            'home.html.twig',
        [
            'title' => "Formation Symfony"
        ]
        );
    }


}

?>
