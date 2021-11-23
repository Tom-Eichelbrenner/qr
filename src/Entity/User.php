<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints\Date;

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
    /**
     * Id in sendmail
     *
     * @var string
     */
    private $token;

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
     * @var Date
     */
    private $date_participation;

    /**
     * @var Date
     */
    private $check1;

    /**
     * @var Date
     */
    private $check2;

    /**
     * @var int
     */
    private $civility;

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

    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return bool
     */
    public function getParticipation(): bool
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
    public function getImageRight(): bool
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
    public function getHotel(): bool
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
    public function getPleniere1(): bool
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
    public function getPleniere2(): bool
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
    public function getDinner(): bool
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
     * @return Date
     */
    public function getDateParticipation(): Date
    {
        return $this->date_participation;
    }

    /**
     * @param Date $date_participation
     */
    public function setDateParticipation(Date $date_participation): void
    {
        $this->date_participation = $date_participation;
    }

    /**
     * @return Date
     */
    public function getCheck1(): Date
    {
        return $this->check1;
    }

    /**
     * @param Date $check1
     */
    public function setCheck1(Date $check1): void
    {
        $this->check1 = $check1;
    }

    /**
     * @return Date
     */
    public function getCheck2(): Date
    {
        return $this->check2;
    }

    /**
     * @param Date $check2
     */
    public function setCheck2(Date $check2): void
    {
        $this->check2 = $check2;
    }

    /**
     * @return int
     */
    public function getCivility(): int
    {
        return $this->civility;
    }

    /**
     * @param int $civility
     */
    public function setCivility(int $civility): void
    {
        $this->civility = $civility;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
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
    public function getLastName(): string
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
    public function getPhone(): string
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
    public function getDiet(): string
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

}
