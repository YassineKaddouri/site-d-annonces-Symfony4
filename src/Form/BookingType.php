<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
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
            ->add('startDate',DateType::class,$this->getConfiguration("Date d'arrivée","La date á date a laquele vous comptez arrivez"))
            ->add('endDate',DateType::class,$this->getConfiguration("Date de depart","La date  a laquele vous quittez les lieux"))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
