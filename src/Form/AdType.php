<?php

namespace App\Form;

use App\Entity\Ad;
//use Doctrine\DBAL\Types\IntegerType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdType extends AbstractType
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
            ->add('title',TextType::class,$this->getConfiguration("Titre","Tapez un super titre pour votre annonce"))


            ->add('slug',TextType::class,$this->getConfiguration("Adresse web","Tapez l'adresse web(automatique)"))
            ->add('coverImage',UrlType::class,$this->getConfiguration("Url de l image principal","Donnez l adresse image qui donne envie"))
            ->add('introduction',TextType::class,$this->getConfiguration("Introduction","Donner une description globale de l'annoce"))
            ->add('rooms',IntegerType::class,$this->getConfiguration("Nombre de chambre","le nombre de chambre dsponibles"))
            ->add('content',TextareaType::class,$this->getConfiguration("Adresse web","Description detaillé"))
            ->add('price',MoneyType::class,$this->getConfiguration("Prix par nuit","Indiquer le prix que vous voulez ppur une nuit"))
            ->add('images',CollectionType::class,[
                'entry_type'=>ImageType::class,
                'allow_add'=>true
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
