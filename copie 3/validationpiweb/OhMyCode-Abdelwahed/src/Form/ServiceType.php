<?php

namespace App\Form;

use App\Entity\Service;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       
        parent::buildForm($builder, $options);

        
        $builder
    
      
            
          
            ->add('duree')
            ->add('niveau')
            ->add('submit',SubmitType::class)
        ;
    }
    public function getParent()
    {
        return ArticleType::class;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
            'attr' => [
                'novalidate' => true, // Ajout de l'attribut novalidate
            ],
        ]);
       
    }
}
