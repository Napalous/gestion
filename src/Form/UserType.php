<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('tel')            
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Administrateur' => 'ROLE_ADMINISTRATEUR',
                    'Caissier' => 'ROLE_CAISSIER',
                    'Gérant' => 'ROLE_GERANT',
                ],
                'multiple' => true,
                'choice_label' => function ($choice, $key, $value) {
                    if (true === $choice) {
                        return 'Definitely!';
                    }

                    return strtoupper($key);

                    // or if you want to translate some key
                    //return 'form.choice.'.$key;
                },
            ])
            ->add('password',PasswordType::class,[
                'label'=> "Mot de Passe",
                'required' => true
                
            ])
            ->add('confirme_password',PasswordType::class,[
                'label'=> "Confirmation de Mot de Passe",
                'required' => true
                
            ])
            ->add('active');

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
