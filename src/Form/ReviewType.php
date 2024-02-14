<?php

namespace App\Form;

use App\Entity\Coin;
use App\Entity\Review;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('score', RangeType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 5
                ],
            ])
            ->add('content', TextareaType::class, [
                'required'   => false,
                'attr' => ['placeholder' => 'Entrez votre message ici ...']
            ])
            ->add('moderation_accepted')
            ->add('coin', EntityType::class, [
                'class' => Coin::class,
                'choice_label' => 'name',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
