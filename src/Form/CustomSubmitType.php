<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomSubmitType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {


    }

    public function getParent(): string
    {
        return SubmitType::class;
    }
}
