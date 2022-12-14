<?php

namespace App\Controller;
use App\Entity\PasswordUpdate;
use App\Entity\User;
use App\Form\AccountType;
use App\Form\PasswordUpdateType;
use App\Form\RegistrationType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ManagerRegestry;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;



class AccountController extends Controller
{
    /**
     * @Route("/login", name="account_login")
     */
    public function login(AuthenticationUtils $utils): Response
    {
        $error =$utils->getLastAuthenticationError();
        $username =$utils->getLastUsername();
        return $this->render('account/login.html.twig',[
            'hasError'=> $error !==null,
            'username' => $username
        ]);
    }

    /**
     * Permet de se déconnecter
     * @route("/logout",name="account_logout")
     * @return void
     */
    public function logout(){
    //.. rien
    }

    /**
     * Permet d'afficher le formulaire d'inscription
     * @route("/register",name="account_register")
     * @return Response
     */
    public function register(Request  $request,ManagerRegistry $managerRegistry,UserPasswordEncoderInterface $encoder){
       $user= new User();
       $form = $this->createForm(RegistrationType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $hash= $encoder->encodePassword($user,$user->getHash());
            $user->setHash($hash);
            $em = $managerRegistry->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash(
                'success',
                "Votre compte a bien été créé ! Vous pouvez maintenant vous connecter"
            );
            return $this->redirectToRoute('account_login');

        }
       return $this->render('account/registration.html.twig',[
           'form'=>$form->createView()
       ]);

    }

    /**
     * Permet d'afficher et de traiter le formulaire de modification de profil
     * @route("/account/profile" ,name="account_profile")
     * @IsGranted("ROLE_USER")
     */
    public function profile(Request  $request,ManagerRegistry $managerRegistry){
        $user =$this->getUser();
        $form = $this->createForm(AccountType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $managerRegistry->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash(
                'success',
                "Les données du profil ont été enregisté avec succée !"
            );
    }
        return $this->render('account/profile.html.twig', [

          'form' => $form->createView()
     ]);


  }

    /**
     * Permet de modifier le mot de passe
     *
     * @Route("/account/password-update", name="account_password")
     * @IsGranted("ROLE_USER")
     */
    public function updatePassword(Request  $request,ManagerRegistry $managerRegistry,UserPasswordEncoderInterface $encoder){
        $passwordUpdate=new PasswordUpdate();
        $user=$this->getUser();
        $form=$this->createForm(PasswordUpdateType::class,$passwordUpdate);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //1. vérifier que le oldPassword du formulaire soit le méme que le password de l'user
            if(!password_verify($passwordUpdate->getOldPassword(),$user->getHash())){
                //Gérer l'erreur
                $form->get('oldPassword')->addError(new FormError("le mot de passe que vous avez tapé 
                n'est pas votre mot de passe actuel !"));
            }else{
                $newPassword =$passwordUpdate->getNewPassword();
                $hash=$encoder->encodePassword($user,$newPassword);
                $user->setHash($hash);
                $em = $managerRegistry->getManager();
                $em->persist($user);
                $em->flush();
                $this->addFlash(
                    'success',
                    "Votre mot de passe a bien été modifier !"
                );
                return  $this->redirectToRoute('home');
            }
        }



        return $this->render('account/password.html.twig',[
            'form' => $form->createView()
        ]);


    }

    /**
     * Permet d'afficher le profil de l'utilisateur connecter
     * @Route("/account",name="account_index")
     * @IsGranted("ROLE_USER")
     */
    public function myAccount(){
        return $this->render('user/index.html.twig',[
            'user' =>$this->getUser()
        ]);
    }
}
