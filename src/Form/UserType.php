<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserType extends AbstractType
{
    private $translator;

    public const STEP1 = 1;
    public const STEP2 = 2;
    /**
     * @var Security
     */
    private $security;


    public function __construct(Security $security, TranslatorInterface $translator)
    {
        $this->security = $security;
        $this->translator = $translator;
    }

    /**
     * @param $message
     *
     * @return string
     */
    public function getTranslation($message): string
    {
        return $this->translator->trans($message);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['step'] === self::STEP1) {
            $builder
                ->add('civility', ChoiceType::class, [
                    'choices' => array_flip(User::CIVILITY),
                    'expanded' => false,
                    'multiple' => false,
                    'label' => $this->getTranslation('form_part_1.civilite.label'),
                ])
                ->add('lastName', null, [
                    'label' => $this->getTranslation('form_part_1.nom.label'),
                ])
                ->add('firstName', null, [
                    'label' => $this->getTranslation('form_part_1.prenom.label'),
                ])
                ->add('email', null, [
                    'label' => $this->getTranslation('form_part_1.email.label'),
                    'disabled' => true,
                ])
                ->add('phone', TelType::class, [
                    'label' => $this->getTranslation('form_part_1.phone.label'),
                    'help' => $this->getTranslation('form_part_1.phone.help'),
                ])
                ->add('imageRight', CheckboxType::class, [
                    'label' => $this->getTranslation('form_part_1.image_right.label'),
                    'attr' => [
                        'class' => 'switch-custom',
                    ],
                    'required' => true,
                ])
                ->add('submit', SubmitType::class, [
                    'label' => $this->getTranslation('form_part_1.submit.label'),
                ]);
        }
        // get user data

        $user = $this->security->getUser();
        if ($options['step'] === self::STEP2) {
            $builder
                ->add('hotel', CheckboxType::class, [
                    'label' => $this->getTranslation('form_part_2.hotel.label'),
                    'help' => $this->getTranslation('form_part_2.hotel.help'),
                    'required' => false,
                    'attr' => [
                        'class' => 'switch-custom',
                    ],
                ]);
            if ($user->getHotel()) {
                if ($user->getHotelName() === "1") {
                    $builder
                        ->add('transfertPleniereWestin', CheckboxType::class, [
                            'label' => $this->getTranslation('form_part_2.transfert.pleniere_westin.label'),
                            'required' => false,
                            'attr' => [
                                'class' => 'switch-custom',
                            ],
                        ]);
                    if ($user->getDinner()) {
                        $builder
                            ->add('transfertWestinDinner', CheckboxType::class, [
                                'label' => $this->getTranslation('form_part_2.transfert.westin_dinner.label'),
                                'required' => false,
                                'attr' => [
                                    'class' => 'switch-custom',
                                ],
                            ])
                            ->add('transfertDinnerWestin', CheckboxType::class, [
                                'label' => $this->getTranslation('form_part_2.transfert.dinner_westin.label'),
                                'required' => false,
                                'attr' => [
                                    'class' => 'switch-custom',
                                ],
                            ]);
                    }
                }
                if ($user->getHotelName() === "2") {
                    $builder
                        ->add('transfertPleniereInter', CheckboxType::class, [
                            'label' => $this->getTranslation('form_part_2.transfert.pleniere_inter.label'),
                            'required' => false,
                            'attr' => [
                                'class' => 'switch-custom',
                            ],
                        ]);
                    if ($user->getDinner()) {
                        $builder
                            ->add('transfertInterDinner', CheckboxType::class, [
                                'label' => $this->getTranslation('form_part_2.transfert.inter_dinner.label'),
                                'required' => false,
                                'attr' => [
                                    'class' => 'switch-custom',
                                ],
                            ])
                            ->add('transfertDinnerInter', CheckboxType::class, [
                                'label' => $this->getTranslation('form_part_2.transfert.dinner_inter.label'),
                                'required' => false,
                                'attr' => [
                                    'class' => 'switch-custom',
                                ],
                            ]);
                    }
                }
            }
            if (!$user->getHotel() && $user->getDinner()) {
                $builder
                    ->add('transfertTaxi', CheckboxType::class, [
                        'label' => $this->getTranslation('form_part_2.transfert.taxi.label'),
                        'required' => false,
                        'attr' => [
                            'class' => 'switch-custom',
                        ],
                    ]);
                if ($user->getTransfertTaxi()) {
                    $builder
                        ->add('taxiAdress', null, [
                            'label' => $this->getTranslation('form_part_2.transfert.taxi_adress.label'),
                        ]);
                }
            }
            if ($user->getDinner()) {
                $builder
                    ->add('dinner', CheckboxType::class, [
                        'label' => $this->getTranslation('form_part_2.dinner.label'),
                        'required' => false,
                        'attr' => [
                            'class' => 'switch-custom',
                        ],
                    ])
                    ->add('diet', null, [
                        'required' => false,
                        'label' => $this->getTranslation('form_part_2.diet.label'),
                    ]);
            }
            $builder
                ->add('submit', SubmitType::class, [
                    'label' => $this->getTranslation('form_part_2.submit.label'),
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => User::class,
            'step' => self::STEP1,
        ]);
        $resolver->setRequired(['step']);
    }
}
