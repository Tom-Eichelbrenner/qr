<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomAbstractType extends AbstractType
{
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['container_attr'] = $options['container_attr'];
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('container_attr', []);
    }
}
