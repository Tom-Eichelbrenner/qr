<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomCheckboxType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'ok',
            'ko',
            'ok_html',
            'ko_html'
        ]);



        $resolver->setDefaults([
            'ok_html' => false,
            'ko_html' => false
        ]);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $classes = explode(' ', $view->vars['label_attr']['class'] ?? '');
        if (!in_array('check', $classes)) {
            $classes[] = 'check';
        }

        $view->vars['label_attr']['class'] = implode(' ', $classes);
        $view->vars['ok'] = $options['ok'];
        $view->vars['ok_html'] = $options['ok_html'];
        $view->vars['ko'] = $options['ko'];
        $view->vars['ko_html'] = $options['ko_html'];
    }

    public function getParent()
    {
        return CheckboxType::class;
    }
}
