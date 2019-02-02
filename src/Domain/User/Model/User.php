<?php declare(strict_types=1);

namespace Oat\UserApi\Domain\User\Model;

class User
{
    /** @var string */
    private $login;

    /** @var string */
    private $password;

    /** @var string */
    private $title;

    /** @var string */
    private $lastname;

    /** @var string */
    private $firstname;

    /** @var string */
    private $gender;

    /** @var string */
    private $email;

    /** @var string */
    private $picture;

    /** @var string */
    private $address;

    public function __construct(
        string $login,
        string $password,
        string $title,
        string $lastname,
        string $firstname,
        string $gender,
        string $email,
        string $picture,
        string $address
    ) {
        $this->login = $login; // I assume that the login will be used to identify a user and is unique
        $this->password = $password;
        $this->title = $title;
        $this->lastname = $lastname;
        $this->firstname = $firstname;
        $this->gender = $gender;
        $this->email = $email;
        $this->picture = $picture;
        $this->address = $address;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPicture(): string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }
}