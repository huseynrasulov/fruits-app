<?php

namespace App\Form\Type;

use App\Entity\Fruit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ToggleFavoriteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('isFavorite', CheckboxType::class, [
            'label' => 'Add to favorites',
            'required' => false,
        ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Fruit::class,
            'method' => 'POST',
            'csrf_protection' => false,
        ]);
    }
}