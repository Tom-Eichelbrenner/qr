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

class UserType extends AbstractType
{

    public const STEP1 = 1;
    public const STEP2 = 2;
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['step'] === self::STEP1) {
            $builder
                ->add('civility', ChoiceType::class, [
                    'choices' => array_flip(User::CIVILITY),
                    'expanded' => false,
                    'multiple' => false,
                    'label' => 'Civilité *',
                ])
                ->add('lastName', null, [
                    'label' => 'Nom *',
                ])
                ->add('firstName', null, [
                    'label' => 'Prénom *',
                ])
                ->add('email', null, [
                    'label' => 'Email *',
                    'disabled' => true,
                ])
                ->add('phone', TelType::class, [
                    'label' => 'Téléphone mobile *',
                    'help' => 'Ce numéro sera utilisé uniquement pour vous envoyer des informations sur l\'événement en cas de besoin.',
                ])
                ->add('imageRight', CheckboxType::class, [
                    'label' => 'Droit a l\'image',
                    'attr' => [
                        'class' => 'switch-custom',
                    ],
                    'required' => true,
                ])
                ->add('submit', SubmitType::class, [
                    'label' => 'Etape suivante',
                ]);
        }
        // get user data

        $user = $this->security->getUser();
        if ($options['step'] === self::STEP2) {
            $builder
                ->add('hotel', CheckboxType::class, [
                    'label' => 'Je confirme souhaiter bénéficier de cette réservation hôtelière.',
                    'help' => "Les coordonnées et accès vous seront précisés dans le mail de confirmation",
                    'required' => false,
                    'attr' => [
                        'class' => 'switch-custom',
                    ],
                ]);
            if ($user->getHotel()) {
                if ($user->getHotelName() === "1") {
                    $builder
                        ->add('transfertPleniereWestin', CheckboxType::class, [
                            'label' => 'Transfert de la plénière au Westin',
                            'required' => false,
                            'attr' => [
                                'class' => 'switch-custom',
                            ],
                        ]);
                    if ($user->getDinner()) {
                        $builder
                            ->add('transfertWestinDinner', CheckboxType::class, [
                                'label' => 'Transfert du Westin au restaurant',
                                'required' => false,
                                'attr' => [
                                    'class' => 'switch-custom',
                                ],
                            ])
                            ->add('transfertDinnerWestin', CheckboxType::class, [
                                'label' => 'Transfert du repas au Westin',
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
                            'label' => 'Transfert de la plénière au Inter',
                            'required' => false,
                            'attr' => [
                                'class' => 'switch-custom',
                            ],
                        ]);
                    if ($user->getDinner()) {
                        $builder
                            ->add('transfertInterDinner', CheckboxType::class, [
                                'label' => 'Transfert du Inter au restaurant',
                                'required' => false,
                                'attr' => [
                                    'class' => 'switch-custom',
                                ],
                            ])
                            ->add('transfertDinnerInter', CheckboxType::class, [
                                'label' => 'Transfert du repas au Inter',
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
                        'label' => 'Transfert en taxi',
                        'required' => false,
                        'attr' => [
                            'class' => 'switch-custom',
                        ],
                    ]);
                if ($user->getTransfertTaxi()) {
                    $builder
                        ->add('taxiAdress', null, [
                            'label' => 'Adresse pour le taxi',
                        ]);
                }
            }
            if ($user->getDinner()) {
                $builder
                    ->add('dinner', CheckboxType::class, [
                        'label' => 'J\'ai un régime ou une intolérance alimentaire spécifique',
                        'required' => false,
                        'attr' => [
                            'class' => 'switch-custom',
                        ],
                    ])
                    ->add('diet', null, [
                        'required' => false,
                        'label' => 'Si oui, veuillez nous le préciser',
                    ]);
            }
            $builder
                ->add('submit', SubmitType::class, [
                    'label' => 'Valider mon inscription',
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
