<?php

namespace App\Form;

use App\Entity\Config;
use Doctrine\ORM\Query\Expr\Select;
use SebastianBergmann\Type\NullType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ConfigType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            
            ->add('value', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('value_type', ChoiceType::class, [ 
                'attr' => [
                    'class' => 'form-control'
                ],
                'choices'  => [ 
                    'Text' => Config::STRING,
                    'Fichier' => Config::FILE,
                ] 
            ])
            
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'form-control'
                ]
            ]);  
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Config::class,
        ]);
    }
}