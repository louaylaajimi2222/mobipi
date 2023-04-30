<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       
        parent::buildForm($builder, $options);

        
        $builder
    
      
            ->add('etat')
            ->add('poid')
            ->add('duree_de_vie')

            
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
            'data_class' => Produit::class,
            'attr' => [
                'novalidate' => true, // Ajout de l'attribut novalidate
            ],
        ]);
    }
}
