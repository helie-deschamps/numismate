<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    private array $roles;
    function __construct(ParameterBagInterface $SI) // permet de récuperer le service security.role_hierarchy
    {
        $this->roles = $SI->get('security.role_hierarchy.roles');
    }
    private function roleToName($role): string
    {
        return ucfirst(strtolower(substr($role, 5)));
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $choices = [];
        foreach ($this->roles as $role => $subRoles) {
            $choices[$this->roleToName($role)] = $role;
        }
        $builder
            ->add('email', EmailType::class)
            ->add('roles', ChoiceType::class, array(
                'choices' => $choices,
                'multiple' => true,
                'required' => true,
            ))
            ->add('password', PasswordType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
