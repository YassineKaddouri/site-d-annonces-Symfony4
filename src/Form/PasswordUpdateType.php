<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class PasswordUpdateType extends AbstractType
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
            ->add('oldPassword',PasswordType::class,$this->getConfiguration("Ancien mot de passe","Donnez votre mot de passe actuel..."))
            ->add('newPassword',PasswordType::class,$this->getConfiguration('Nouveau mot de passe','Tapez votre nouveau mot de passe'))
            ->add('ConfirmPassword',PasswordType::class,$this->getConfiguration('Confirmation mot de passe','Confirmez votre nouveau mot de passe'))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
