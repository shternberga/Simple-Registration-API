<?php

// 'user' object
class User
{
    // user properties
    private $id;
    private $name;
    private $email;
    private $password;

    // User class constructor
    public function __construct(int $id, string $name, string $email, string $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    //user getters
    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function email(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function password(): string
    {
        return $this->password;
    }

    /**
     * @return integer
     */
    public function id(): int
    {
        return $this->id;
    }
}