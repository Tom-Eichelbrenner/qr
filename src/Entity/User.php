<?php

namespace App\Entity;

use DateTime;
use Exception;

class User
{
    const HOTEL_NAME = [
        1 => 'WESTIN',
        2 => 'INTERCONTINENTAL',
    ];
    const CIVILITY = [
        1 => 'M.',
        2 => 'Mme',
    ];

    const ATTRIBUTES = [
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
        "TOKEN_2022" => "token"
    ];
    /**
     * Id in sendmail
     *
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $email;

    /**
     * @var bool
     */
    private $participation;

    /**
     * @var bool
     */
    private $image_right;

    /**
     * @var bool
     */
    private $hotel;

    /**
     * @var bool
     */
    private $pleniere_1;

    /**
     * @var bool
     */
    private $pleniere_2;

    /**
     * @var bool
     */
    private $dinner;

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
     */
    private $civility;

    /**
     * @return string
     */
    public function getHotelName(): ?string
    {
        return $this->hotel_name;
    }

    /**
     * @param string $hotel_name
     */
    public function setHotelName(string $hotel_name): void
    {
        $this->hotel_name = $hotel_name;
    }
    /**
     * @var string
     */
    private $hotel_name;
    /**
     * @var string
     */
    private $first_name;

    /**
     * @var string
     */
    private $last_name;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $diet;


    public function setToken(string $token)
    {
        $this->token = $token;
    }

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
    public function setParticipation(bool $participation): void
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
    public function setImageRight(bool $image_right): void
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
    public function setHotel(bool $hotel): void
    {
        $this->hotel = $hotel;
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
    public function setPleniere1(bool $pleniere_1): void
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
    public function setPleniere2(bool $pleniere_2): void
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
    public function setDinner(bool $dinner): void
    {
        $this->dinner = $dinner;
    }

    /**
     * @return DateTime
     */
    public function getDateParticipation(): ?DateTime
    {
        return $this->date_participation;
    }

    /**
     * @param DateTime $date_participation
     *
     * @throws Exception
     */
    public function setDateParticipation(DateTime $date_participation): void
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
     * @param DateTime $check1
     *
     * @throws Exception
     */
    public function setCheck1(DateTime $check1): void
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
     * @param DateTime $check2
     */
    public function setCheck2(DateTime $check2): void
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
     * @param string $civility
     */
    public function setCivility(string $civility): void
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
     * @param string $first_name
     */
    public function setFirstName(string $first_name): void
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
     * @param string $last_name
     */
    public function setLastName(string $last_name): void
    {
        $this->last_name = $last_name;
    }

    /**
     * @return string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getDiet(): ?string
    {
        return $this->diet;
    }

    /**
     * @param string $diet
     */
    public function setDiet(string $diet): void
    {
        $this->diet = $diet;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

}
