<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomTextType extends CustomAbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        return parent::configureOptions($resolver);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        return parent::buildForm($builder, $options);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);
        $class = explode(" ", $options['label_attr']['class'] ?? "");

        if (in_array("options", $class) && $form->getData() === null) {
            $class[] = 'hidden';
        }

        $view->vars['label_attr']['class'] = implode(" ", $class);
    }
    public function getParent()
    {
        return TextType::class;
    }
}
