<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Article;
use App\Entity\Categorie;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('description', TextareaType::class, [
            'label' => 'Description',
            'attr' => [
                'rows' => 5,
                'class' => 'form-control',
            ],
        ])
          
            ->add('estimation')
            ->add('image', FileType::class, [
                'label' => 'Image (JPEG, PNG or GIF file)',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'accept' => 'image/jpeg, image/png, image/gif'
                ]
            ])
            ->add('dateAjout', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd',
                'data' => new \DateTime(),
            ])
            ->add('nom')
            
            
            
            
            ->add('user',EntityType::class,[
                'expanded'=>false,
                'class'=>User::class,
                'multiple'=>false
                ,'attr'=>['class'=>'users']
            ])
            
            ->add('categorie',EntityType::class,[
                'expanded'=>false,
                'class'=>Categorie::class,
                'multiple'=>false
                ,'attr'=>['class'=>'categories']
            ])
           ->add('souscategorie')
            
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
