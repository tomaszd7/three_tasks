<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(schema="homestead", name="user")
 */
class User
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    private $surname;

    /**
     * @var string
     * @ORM\Column(type="string", length=11)
     * @Assert\NotBlank()
     */
    private $pesel;

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return string
     */
    public function getPesel(): string
    {
        return $this->pesel;
    }

    /**
     * @param string $pesel
     */
    public function setPesel(string $pesel): void
    {
        $this->pesel = $pesel;
    }

}