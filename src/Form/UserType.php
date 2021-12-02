<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
                    'required' => false,
                    'empty_data' => false,
                    'false_values' => ['false', 0, null, "0", false]
                ])
                ->add('submit', SubmitType::class, [
                    'label' => $this->getTranslation('form_part_1.submit.label'),
                ]);

            $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $data = $event->getData();

                if (! isset($data['imageRight'])) {
                    $data['imageRight'] = false;
                }
                $event->setData($data);
            });
        }
        // get user data

        /**
         * @var User $user
         */
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
                    'empty_data' => false,
                    'false_values' => [0, '0', 'false']
                ]);
            if ($user->getHotel() === true) {
                if ($user->getHotelName() === "1") {
                    $builder
                        ->add('transfertPleniereWestin', CheckboxType::class, [
                            'label' => $this->getTranslation('form_part_2.transfert.pleniere_westin.label'),
                            'required' => false,
                            'attr' => [
                                'class' => 'switch-custom',
                            ],
                            'empty_data' => false,
                            'false_values' => [0, '0', 'false', null]
                        ]);
                    if ($user->getDinner()) {
                        $builder
                            ->add('transfertWestinDinner', CheckboxType::class, [
                                'label' => $this->getTranslation('form_part_2.transfert.westin_dinner.label'),
                                'required' => false,
                                'attr' => [
                                    'class' => 'switch-custom',
                                ],
                                'empty_data' => false,
                                'false_values' => [0, '0', 'false']
                            ])
                            ->add('transfertDinnerWestin', CheckboxType::class, [
                                'label' => $this->getTranslation('form_part_2.transfert.dinner_westin.label'),
                                'required' => false,
                                'attr' => [
                                    'class' => 'switch-custom',
                                ],
                                'empty_data' => false,
                                'false_values' => [0, '0', 'false']
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
                            'empty_data' => false,
                            'false_values' => [0, '0', 'false']
                        ]);
                    if ($user->getDinner()) {
                        $builder
                            ->add('transfertInterDinner', CheckboxType::class, [
                                'label' => $this->getTranslation('form_part_2.transfert.inter_dinner.label'),
                                'required' => false,
                                'attr' => [
                                    'class' => 'switch-custom',
                                ],
                                'empty_data' => false,
                                'false_values' => [0, '0', 'false']
                            ])
                            ->add('transfertDinnerInter', CheckboxType::class, [
                                'label' => $this->getTranslation('form_part_2.transfert.dinner_inter.label'),
                                'required' => false,
                                'attr' => [
                                    'class' => 'switch-custom',
                                ],
                                'empty_data' => false,
                                'false_values' => [0, '0', 'false']
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
                        'empty_data' => false,
                        'false_values' => [0, '0', 'false']
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
                        'empty_data' => false,
                        'false_values' => [0, '0', 'false']
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

            $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
                /**
                 * @var User
                 */
            });
        }
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
