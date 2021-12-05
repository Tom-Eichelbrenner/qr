<?php

namespace App\Entity;

use DateTime;
use Exception;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

class User implements UserInterface
{
    public const HOTEL_NAME = [
        1 => 'WESTIN',
        2 => 'INTERCONTINENTAL',
    ];

    public const CIVILITY = [
        1 => 'M.',
        2 => 'Mme',
    ];

    public const ATTRIBUTES = [
        "PRENOM" => "firstName",
        "NOM" => "lastName",
        "CIVILITE" => "civility",
        "SMS" => "phone",
        "PARTICIPATION" => "participation",
        "DATE_PARTICIPATION" => "dateParticipation",
        "DROIT_IMAGE" => "imageRight",
        "HOTEL" => "hotel",
        "NOM_HOTEL" => "hotelName",
        "PLENIERE" => "pleniere1",
        "PLENIERE2" => "pleniere2",
        "DINER" => "dinner",
        "RESTRICTION_ALIMENTAIRE" => "diet",
        "CHECKIN1" => "check1",
        "CHECKIN2" => "check2",
        "TOKEN_2022" => "token",
        "TRANSFERT_WESTIN_DINER" => "transfertWestinDinner",
        "TRANSFERT_INTER_DINER" => "transfertInterDinner",
        "TRANSFERT_PLENIERE_WESTIN" => "transfertPleniereWestin",
        "TRANSFERT_PLENIERE_INTER" => "transfertPleniereInter",
        "TRANSFERT_DINER_WESTIN" => "transfertDinnerWestin",
        "TRANSFERT_DINER_INTER" => "transfertDinnerInter",
        "TRANSFERT_TAXI" => "transfertTaxi",
        "TAXI_ADRESSE" => "taxiAdress",
        "HOTEL_USER" => "hotelUser",
        "DINER_USER" => "dinnerUser"
    ];

    /**
     * @var array - static attributes that should not be updated
     */
    public const STATIC_ATTRIBUTES = [
        'hotel',
        'dinner',
    ];
    /**
     * Id in sendmail
     *
     * @var string
     */
    private $token;

    /**
     * @var string
     * @Assert\NotBlank(groups={"group_1"})
     *
     *
     */
    private $email;

    /**
     * @var bool
     * @Assert\Type("bool")
     */
    private $participation;

    /**
     * @var bool
     * @Assert\Type("bool", groups={"group_1"})
     */
    private $image_right;

    /**
     * @var bool
     * @Assert\Type("bool", groups={"group_2"})
     */
    private $hotel;

    /**
     * @var bool
     * @Assert\Type("bool", groups={"group_2"})
     */
    private $hotel_user;

    /**
     * @var bool
     * @Assert\Type("bool")
     */
    private $pleniere_1;

    /**
     * @var bool
     * @Assert\Type("bool")
     */
    private $pleniere_2;

    /**
     * @var bool
     * @Assert\Type("bool", groups={"group_2"})
     */
    private $dinner;

    /**
     * @var bool
     * @Assert\Type("bool", groups={"group_2"})
     */
    private $dinner_user;

    /**
     * @var DateTime
     */
    private $date_participation;

    /**
     * @var DateTime
     */
    private $check1;

    /**
     * @var DateTime
     */
    private $check2;

    /**
     * @var string
     * @Assert\NotBlank(groups={"group_1"})
     */
    private $civility;

    /**
     * @var boolean
     * @Assert\Type("bool", groups={"group_2"})
     */
    private $transfert_westin_dinner;
    /**
     * @var boolean
     * @Assert\Type("bool", groups={"group_2"})
     */
    private $transfert_inter_dinner;
    /**
     * @var boolean
     * @Assert\Type("bool", groups={"group_2"})
     */
    private $transfert_pleniere_westin;
    /**
     * @var boolean
     * @Assert\Type("bool", groups={"group_2"})
     */
    private $transfert_pleniere_inter;
    /**
     * @var boolean
     * @Assert\Type("bool", groups={"group_2"})
     */
    private $transfert_dinner_westin;
    /**
     * @var boolean
     * @Assert\Type("bool", groups={"group_2"})
     */
    private $transfert_dinner_inter;
    /**
     * @var boolean
     * @Assert\Type("bool", groups={"group_2"})
     */
    private $transfert_taxi;

    /**
     * @return bool
     */
    public function getTransfertWestinDinner(): ?bool
    {
        return $this->transfert_westin_dinner;
    }

    /**
     * @param bool $transfert_westin_dinner
     */
    public function setTransfertWestinDinner(?bool $transfert_westin_dinner = null): void
    {
        $this->transfert_westin_dinner = $transfert_westin_dinner;
    }

    /**
     * @return bool
     */
    public function getTransfertInterDinner(): ?bool
    {
        return $this->transfert_inter_dinner;
    }

    /**
     * @param bool $transfert_inter_dinner
     */
    public function setTransfertInterDinner(?bool $transfert_inter_dinner = null): void
    {
        $this->transfert_inter_dinner = $transfert_inter_dinner;
    }

    /**
     * @return bool
     */
    public function getTransfertPleniereWestin(): ?bool
    {
        return $this->transfert_pleniere_westin;
    }

    /**
     * @param bool $transfert_pleniere_westin
     */
    public function setTransfertPleniereWestin(?bool $transfert_pleniere_westin = null): void
    {
        $this->transfert_pleniere_westin = $transfert_pleniere_westin;
    }

    /**
     * @return bool
     */
    public function getTransfertPleniereInter(): ?bool
    {
        return $this->transfert_pleniere_inter;
    }

    /**
     * @param bool $transfert_pleniere_inter
     */
    public function setTransfertPleniereInter(?bool $transfert_pleniere_inter = null): void
    {
        $this->transfert_pleniere_inter = $transfert_pleniere_inter;
    }

    /**
     * @return bool
     */
    public function getTransfertDinnerWestin(): ?bool
    {
        return $this->transfert_dinner_westin;
    }

    /**
     * @param bool $transfert_dinner_westin
     */
    public function setTransfertDinnerWestin(?bool $transfert_dinner_westin = null): void
    {
        $this->transfert_dinner_westin = $transfert_dinner_westin;
    }

    /**
     * @return bool
     */
    public function getTransfertDinnerInter(): ?bool
    {
        return $this->transfert_dinner_inter;
    }

    /**
     * @param bool $transfert_dinner_inter
     */
    public function setTransfertDinnerInter(?bool $transfert_dinner_inter = null): void
    {
        $this->transfert_dinner_inter = $transfert_dinner_inter;
    }

    /**
     * @return bool
     */
    public function getTransfertTaxi(): ?bool
    {
        return $this->transfert_taxi;
    }

    /**
     * @param bool $transfert_taxi
     */
    public function setTransfertTaxi(?bool $transfert_taxi = null): void
    {
        $this->transfert_taxi = $transfert_taxi;
    }

    /**
     * @return string
     */
    public function getTaxiAdress(): ?string
    {
        return $this->taxi_adress;
    }

    /**
     * @param string|null $taxi_adress
     */
    public function setTaxiAdress(?string $taxi_adress = null): void
    {
        $this->taxi_adress = $taxi_adress;
    }

    /**
     * @var string
     */
    private $taxi_adress;

    /**
     * @return string
     */
    public function getHotelName(): ?string
    {
        return $this->hotel_name;
    }

    /**
     * @param string|null $hotel_name
     */
    public function setHotelName(?string $hotel_name = null): void
    {
        $this->hotel_name = $hotel_name;
    }

    /**
     * @var string
     */
    private $hotel_name;
    /**
     * @var string
     * @Assert\NotBlank(groups={"group_1"})
     */
    private $first_name;

    /**
     * @var string
     * @Assert\NotBlank(groups={"group_1"})
     */
    private $last_name;

    /**
     * @var string
     *
     *
     * @Assert\Regex("/^\d{11,}$/", message="Le numéro de téléphone doit comprendre le code international suivi du numéro sans le 0 initial", groups={"group_1"})
     */
    private $phone;

    /**
     * @var string|null
     *
     */
    private $diet;


    /**
     * @param string $token
     */
    public function setToken(string $token)
    {
        $this->token = $token;
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @return bool
     */
    public function getParticipation(): ?bool
    {
        return $this->participation;
    }

    /**
     * @param bool $participation
     */
    public function setParticipation(?bool $participation = null): void
    {
        $this->participation = $participation;
    }

    /**
     * @return bool
     */
    public function getImageRight(): ?bool
    {
        return $this->image_right;
    }

    /**
     * @param bool $image_right
     */
    public function setImageRight(?bool $image_right = null): void
    {
        $this->image_right = $image_right;
    }

    /**
     * @return bool
     */
    public function getHotel(): ?bool
    {
        return $this->hotel;
    }

    /**
     * @param bool $hotel
     */
    public function setHotel(?bool $hotel = null): void
    {
        $this->hotel = $hotel;
    }

    /**
     * @return bool
     */
    public function getHotelUser(): ?bool
    {
        return $this->hotel_user;
    }

    /**
     * @param bool $hotel
     */
    public function setHotelUser(?bool $hotel_user = null): void
    {
        $this->hotel_user = $hotel_user;
    }

    /**
     * @return bool
     */
    public function getPleniere1(): ?bool
    {
        return $this->pleniere_1;
    }

    /**
     * @param bool $pleniere_1
     */
    public function setPleniere1(?bool $pleniere_1 = null): void
    {
        $this->pleniere_1 = $pleniere_1;
    }

    /**
     * @return bool
     */
    public function getPleniere2(): ?bool
    {
        return $this->pleniere_2;
    }

    /**
     * @param bool $pleniere_2
     */
    public function setPleniere2(?bool $pleniere_2 = null): void
    {
        $this->pleniere_2 = $pleniere_2;
    }

    /**
     * @return bool
     */
    public function getDinner(): ?bool
    {
        return $this->dinner;
    }

    /**
     * @param bool $dinner
     */
    public function setDinner(?bool $dinner = null): void
    {
        $this->dinner = $dinner;
    }

    /**
     * @return bool
     */
    public function getDinnerUser(): ?bool
    {
        return $this->dinner_user;
    }

    /**
     * @param bool $dinner
     */
    public function setDinnerUser(?bool $dinner_user = null): void
    {
        $this->dinner_user = $dinner_user;
    }

    /**
     * @return DateTime
     */
    public function getDateParticipation(): ?DateTime
    {
        return $this->date_participation;
    }

    /**
     * @param DateTime|null $date_participation
     *
     * @throws Exception
     */
    public function setDateParticipation(?DateTime $date_participation = null): void
    {
        if (is_string($date_participation)) {
            $date_participation = new DateTime($date_participation);
        }
        $this->date_participation = $date_participation;
    }

    /**
     * @return DateTime
     */
    public function getCheck1(): ?DateTime
    {
        return $this->check1;
    }

    /**
     * @param DateTime|null $check1
     *
     * @throws Exception
     */
    public function setCheck1(?DateTime $check1 = null): void
    {
        if (is_string($check1)) {
            $check1 = new DateTime($check1);
        }
        $this->check1 = $check1;
    }

    /**
     * @return DateTime|null
     */
    public function getCheck2(): ?DateTime
    {
        return $this->check2;
    }

    /**
     * @param DateTime|null $check2
     *
     * @throws Exception
     */
    public function setCheck2(?DateTime $check2 = null): void
    {
        if (is_string($check2)) {
            $check2 = new DateTime($check2);
        }
        $this->check2 = $check2;
    }

    /**
     * @return string
     */
    public function getCivility(): ?string
    {
        return $this->civility;
    }

    /**
     * @param string|null $civility
     */
    public function setCivility(?string $civility = null): void
    {
        $this->civility = $civility;
    }

    /**
     * @return string
     */
    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    /**
     * @param string|null $first_name
     */
    public function setFirstName(?string $first_name = null): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string
     */
    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    /**
     * @param string|null $last_name
     */
    public function setLastName(?string $last_name = null): void
    {
        $this->last_name = $last_name;
    }

    /**
     * @param bool|null $withCivility
     *
     * @return string
     */
    public function getFullName(?bool $withCivility = false): string
    {
        $fullName = "{$this->getFirstName()} {$this->getLastName()}";

        if ($withCivility) {
            $fullName = "{$this->getCivilityToString()} $fullName";
        }

        return $fullName ?? "";
    }

    /**
     * @return string
     */
    public function getCivilityToString(): string
    {
        return self::CIVILITY[$this->getCivility()];
    }

    /**
     * @return string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone(?string $phone = null): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getDiet(): ?string
    {
        if ($this->diet == "null") {
            return null;
        }
        return $this->diet;
    }

    /**
     * @param string|null $diet
     */
    public function setDiet(?string $diet = null): void
    {
        $this->diet = $diet;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(?string $email = null): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getUserIdentifier(): ?string
    {
        return $this->getToken();
    }

    /**
     *
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return string|void|null
     */
    public function getPassword()
    {
        // TODO: Implement getPassword() method.
    }

    /**
     * @return string[]
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * @return string|void|null
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->getEmail();
    }
}
