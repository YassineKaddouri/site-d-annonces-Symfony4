<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Image;
use App\Form\AdType;
use App\Repository\AdRepository;
use Doctrine\Common\Persistence\ManagerRegestry;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class AdController extends Controller
{
    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $repo)
    {

       // $repo=$this->getDoctrine()->getRepository(Ad::class);
        $ads= $repo->findAll();
        return $this->render('ad/index.html.twig', [
              'ads'=> $ads
        ]);
    }

    /**
     * Permet de creer une annonce
     *
     * @Route("/ads/new",name="ads_create")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function create(Request $request,ManagerRegistry $managerRegistry){
        $ad = new Ad();

      $form =$this->createForm(AdType::class,$ad);
      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()){
          $ad->setAuthor($this->getUser());
          $em = $managerRegistry->getManager();
          $em->persist($ad);
          $em->flush();
          $this->addFlash(
              'success',
              "L'annonce <strong>{$ad->getTitle()}</strong> bien été enregestée!"
          );

          return $this->redirectToRoute('ads_show',[
              'slug'=> $ad->getSlug()
          ]);

      }

        return $this->render('ad/new.html.twig',[
            'form' => $form->createView()
        ]);

    }

    /**
     * Permet d'afficher le formulaire d'edition
     * @Route("/ads/{slug}/edit",name="ads_edit")
     * @Security("is_granted('ROLE_USER') and user ===ad.getAuthor()",message="Cette annonce ne vous appartient pas ,
      vous ne pouvez pas la modifier")
     * @return Response
     */
    public function edit(Ad $ad,Request  $request,ManagerRegistry $managerRegistry){

        $form =$this->createForm(AdType::class,$ad);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $em = $managerRegistry->getManager();
            $em->persist($ad);
            $em->flush();
            $this->addFlash(
                'success',
                "Les modifications de L'annonce <strong>{$ad->getTitle()}</strong> bien été enregestée!"
            );

            return $this->redirectToRoute('ads_show',[
                'slug'=> $ad->getSlug()
            ]);

        }
        return $this->render('ad/edit.html.twig',[
            'form' =>$form->createView(),
            'ad'=>$ad
        ]);

     }
    /**
     * Permet d'afficher une seule annoce
     *
     * @Route("/ads/{slug}",name="ads_show")
     *
     * @return Response
     */
   // public function show($slug,AdRepository $repo){
        public function show(Ad $ad){
        //$ad =$repo->findOneBySlug($slug);
        return $this->render('ad/show.html.twig',[
            'ad'=> $ad
        ]);

    }

    /**
     * Permet de supprimer une annonce
     * @Route("/ads/{slug}/delete",name="ads_delete")
     * @Security("is_granted('ROLE_USER') and user ===ad.getAuthor()",message="Vous n'avez pas le droit d'acceder a cette ressource")
     */
  public function delete(Ad $ad,ManagerRegistry $managerRegistry){
      $em = $managerRegistry->getManager();
      $em->remove($ad);
      $em->flush();
      $this->addFlash(
          'success',
          " de L'annonce <strong>{$ad->getTitle()}</strong> bien été supprimer!"
      );
    return $this->redirectToRoute('ads_index');
  }
}
