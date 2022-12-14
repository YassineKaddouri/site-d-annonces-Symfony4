<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    /*
    * @param string $label
    * @param string $placeholder
    * @return array
    */
    private function getConfiguration($label,$placeholer){
        return[
            'label'=>$label,
            'attr'=>[
                'placeholder' => $placeholer
            ]
        ];
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',TextType::class,$this->getConfiguration("Prénom","Votre prénom"))
            ->add('lastName',TextType::class,$this->getConfiguration("Nom","Votre Nom ..."))
            ->add('email',EmailType::class,$this->getConfiguration("Email","Votre adresse email ..."))
            ->add('picture',UrlType::class,$this->getConfiguration("Photo de profil","Url de votre avatar ..."))
            ->add('hash',PasswordType::class,$this->getConfiguration("Mot de passe","Choisissez un bon mot se passe !"))
            ->add('passwordConfirm',PasswordType::class,$this->getConfiguration("Confirmation de mot de passe",'Veuillez confirmer votre mot de passe'))
            ->add('introduction',TextType::class,$this->getConfiguration("Introduction","Presentez vous en quelques mots .."))
            ->add('description',TextareaType::class,$this->getConfiguration("Description detaillee","cest le moment de vous presenter en details"))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
