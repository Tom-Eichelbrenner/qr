<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use App\Form\CustomCheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserType extends AbstractType
{
    private $translator;

    public const STEP1 = 1;
    public const STEP2 = 2;

    public const VALIDATION_GROUP_1 = "group_1";
    public const VALIDATION_GROUP_2 = "group_2";
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
        return nl2br($this->translator->trans($message));
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
                    'attr' => ['disabled' => true],
                ])
                ->add('firstName', null, [
                    'label' => $this->getTranslation('form_part_1.prenom.label'),
                    'attr' => ['disabled' => true],
                ])
                ->add('email', null, [
                    'label' => $this->getTranslation('form_part_1.email.label'),
                    'attr' => ['disabled' => true]
                ])
                ->add('phone', TelType::class, [
                    'label' => $this->getTranslation('form_part_1.phone.label'),
                    'help' => $this->getTranslation('form_part_1.phone.help'),
                ])
                ->add('imageRight', CustomCheckboxType::class, [
                    'label_attr' => ['class' => 'check'],
                    'required' => false,
                    'empty_data' => false,
                    'ok' => $this->getTranslation('form_part_1.image_right.ok'),
                    'ko' => $this->getTranslation('form_part_1.image_right.ko'),
                    'false_values' => ['false', 0, null, "0", false]
                ])
                ->add('submit', SubmitType::class, [
                    'label' => $this->getTranslation('form_part_1.submit.label'),
                    'attr' => [
                        'class' => 'button button-primary',
                    ]
                ]);
        }
        // get user data

        /**
         * @var User $user
         */
        $user = $this->security->getUser();
        if ($options['step'] === self::STEP2) {
            $builder
                ->add('hotel', CustomCheckboxType::class, [
                    'help' => $this->getTranslation('form_part_2.hotel.help'),
                    'required' => false,
                    'empty_data' => false,
                    'ok' => $this->getTranslation('form_part_2.hotel.label.ok'),
                    'ko' => $this->getTranslation('form_part_2.hotel.label.ko'),
                    'false_values' => [0, '0', 'false']
                ]);
            if ($user->getHotel() === true) {
                if ($user->getHotelName() === "1") {
                    $builder
                        ->add('transfertPleniereWestin', CustomCheckboxType::class, [
                            'required' => false,
                            'attr' => [
                                'class' => 'switch-custom',
                            ],
                            'empty_data' => false,
                            'ok' => $this->getTranslation('form_part_2.transfert.pleniere_westin.label.ok'),
                            'ko' => $this->getTranslation('form_part_2.transfert.pleniere_westin.label.ko'),
                            'ok_html' => true,
                            'ko_html' => true,
                            'false_values' => [0, '0', 'false', null]
                        ]);
                    if ($user->getDinner()) {
                        $builder
                            ->add('transfertWestinDinner', CustomCheckboxType::class, [
                                'required' => false,
                                'attr' => [
                                    'class' => 'switch-custom',
                                ],
                                'empty_data' => false,
                                'ok' => $this->getTranslation('form_part_2.transfert.westin_dinner.label.ok'),
                                'ko' => $this->getTranslation('form_part_2.transfert.westin_dinner.label.ko'),
                                'ok_html' => true,
                                'ko_html' => true,
                                'false_values' => [0, '0', 'false']
                            ])
                            ->add('transfertDinnerWestin', CustomCheckboxType::class, [
                                'required' => false,
                                'attr' => [
                                    'class' => 'switch-custom',
                                ],
                                'empty_data' => false,
                                'ok' => $this->getTranslation('form_part_2.transfert.dinner_westin.label.ok'),
                                'ko' => $this->getTranslation('form_part_2.transfert.dinner_westin.label.ko'),
                                'ok_html' => true,
                                'ko_html' => true,
                                'help' => $this->getTranslation('form_part_2.transfert.dinner_westin.help'),
                                'false_values' => [0, '0', 'false']
                            ]);
                    }
                }
                if ($user->getHotelName() === "2") {
                    $builder
                        ->add('transfertPleniereInter', CustomCheckboxType::class, [
                            'required' => false,
                            'attr' => [
                                'class' => 'switch-custom',
                            ],
                            'empty_data' => false,
                            'ok' => $this->getTranslation('form_part_2.transfert.pleniere_inter.label.ok'),
                            'ko' => $this->getTranslation('form_part_2.transfert.pleniere_inter.label.ko'),
                            'ok_html' => true,
                            'ko_html' => true,
                            'false_values' => [0, '0', 'false'],

                        ]);
                    if ($user->getDinner()) {
                        $builder
                            ->add('transfertInterDinner', CustomCheckboxType::class, [
                                'required' => false,
                                'attr' => [
                                    'class' => 'switch-custom',
                                ],
                                'empty_data' => false,
                                'ok' => $this->getTranslation('form_part_2.transfert.inter_dinner.label.ok'),
                                'ko' => $this->getTranslation('form_part_2.transfert.inter_dinner.label.ko'),
                                'ok_html' => true,
                                'ko_html' => true,
                                'false_values' => [0, '0', 'false']
                            ])
                            ->add('transfertDinnerInter', CustomCheckboxType::class, [
                                'required' => false,
                                'attr' => [
                                    'class' => 'switch-custom',
                                ],
                                'empty_data' => false,
                                'ok' => $this->getTranslation('form_part_2.transfert.dinner_inter.label.ok'),
                                'ko' => $this->getTranslation('form_part_2.transfert.dinner_inter.label.ko'),
                                'ok_html' => true,
                                'ko_html' => true,
                                'false_values' => [0, '0', 'false']
                            ]);
                    }
                }
            }
            if (!$user->getHotel() && $user->getDinner()) {
                $builder
                    ->add('transfertTaxi', CustomCheckboxType::class, [
                        'required' => false,
                        'attr' => [
                            'class' => 'switch-custom',
                        ],
                        'empty_data' => false,
                        'ok' => $this->getTranslation('form_part_2.transfert.taxi.label.ok'),
                        'ko' => $this->getTranslation('form_part_2.transfert.taxi.label.ko'),
                        'help' => $this->getTranslation('form_part_2.transfert.taxi.label.help'),
                        'false_values' => [0, '0', 'false']
                    ]);
                if ($user->getTransfertTaxi()) {
                    $builder
                        ->add('taxiAdress', null, [
                            'label' => $this->getTranslation('form_part_2.transfert.taxi_adress.label'),
                            'attr' => [
                                'class' => 'options'
                            ],
                        ]);
                }
            }
            if ($user->getDinner()) {
                $builder
                    ->add('dinner', CustomCheckboxType::class, [
                        'required' => false,
                        'attr' => [
                            'class' => 'switch-custom',
                        ],
                        'empty_data' => false,
                        'ok' => $this->getTranslation('form_part_2.dinner.label.ok'),
                        'ko' => $this->getTranslation('form_part_2.dinner.label.ko'),
                        'false_values' => [0, '0', 'false']
                    ])
                    ->add('dietbool', CustomCheckboxType::class, [
                        'required' => false,
                        'attr' => [
                            'class' => 'switch-custom',
                        ],
                        'empty_data' => false,
                        'ok' => $this->getTranslation('form_part_2.diet.label.ok'),
                        'ko' => $this->getTranslation('form_part_2.diet.label.ko'),
                        'false_values' => [0, '0', 'false'],
                        'mapped' => false,
                    ])
                    ->add('diet', null, [
                        'required' => false,
                        'label' => $this->getTranslation('form_part_2.diet.label.message'),
                    ]);
            }
            $builder
                ->add('submit', SubmitType::class, [
                    'label' => $this->getTranslation('form_part_2.submit.label'),
                    'attr' => [
                        'class' => 'button button-primary'
                    ],
                ]);

            $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {

                /**
                 * @var FormInterface - form with current state
                 */
                $form = $event->getForm();

                $data = $form->getData();

                /**
                 * Ensure that assocaited data is set to false if no hotel checked
                 */
                if ($data->getHotel() == false) {
                    dump("breakpoint");
                    $data->setTransfertWestinDinner(false);
                    $data->setTransfertInterDinner(false);
                    $data->setTransfertPleniereWestin(false);
                    $data->setTransfertPleniereInter(false);
                    $data->setTransfertDinnerWestin(false);
                    $data->setTransfertDinnerInter(false);
                    if ($data->getDinner() == false) {
                        $data->setDiet("null");
                    }
                }
                $event->setData($data);
            });
        }

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();

            /**
             * @var User
             */
            $checkboxInputs = [
                'imageRight',
                'hotel',
                'transfertPleniereWestin',
                'transfertWestinDinner',
                'transfertDinnerWestin',
                'transfertPleniereInter',
                'transfertInterDinner',
                'transfertDinnerInter',
                'transfertTaxi',
                'dinner',
            ];

            foreach ($checkboxInputs as $checkboxInput) {
                if ($form->has($checkboxInput) && ! isset($data[$checkboxInput])) {
                    $data[$checkboxInput] = false;
                }
            }


            $event->setData($data);
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => User::class,
            'step' => self::STEP1,
            'validation_groups' => self::VALIDATION_GROUP_1
        ]);
        $resolver->setRequired(['step']);
    }
}
