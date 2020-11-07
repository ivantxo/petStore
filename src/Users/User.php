<?php


namespace App\Users;


final class User
{
    /**
     * @var int $id
     */
    public $id;

    /**
     * @var string $userName
     */
    public $userName;

    /**
     * @var string $firstName
     */
    public $firstName;

    /**
     * @var string $lastName
     */
    public $lastName;

    /**
     * @var string $email
     */
    public $email;

    /**
     * @var string $password
     */
    public $password;

    /**
     * @var string $phone
     */
    public $phone;

    /**
     * @var string $status
     */
    public $status;

    /**
     * @var string $createdAt
     */
    public $createdAt;

    public function __construct(
        int $id,
        string $userName,
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        string $phone,
        string $status,
        string $createdAt)
    {
        $this->id = $id;
        $this->userName = $userName;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->phone = $phone;
        $this->status = $status;
        $this->createdAt = $createdAt;
    }
}
