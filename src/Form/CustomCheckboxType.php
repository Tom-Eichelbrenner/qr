<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomCheckboxType extends CustomAbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setRequired([
            'ok',
            'ko',
            'ok_html',
            'ko_html',
        ]);



        $resolver->setDefaults([
            'ok_html' => false,
            'ko_html' => false,
        ]);
    }


    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        $classes = explode(' ', $view->vars['label_attr']['class'] ?? '');

        if ($view->vars['value'] === null) {
            $classe[] = 'hidden';
        }
        if (!in_array('check', $classes)) {
            $classes[] = 'check';
        }

        if ($form->getData() == 1) {
            $view->vars['attr']['checked'] = true;
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
