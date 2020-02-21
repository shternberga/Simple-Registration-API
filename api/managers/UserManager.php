<?php

class UserManager
{
    private $db;
    private $user;

    public function __construct(object $db)
    {
        $this->db = $db;
    }

    //store new user in the database, create user object if stored successfully
    public function create(array $data): bool
    {

        // save data params to simple variables for PDO query
        $name = $data['name'];
        $email = $data['email'];

        //hash password for correct storage in DB
        $password_hashed = password_hash($data['password'], PASSWORD_BCRYPT);

        // prepare insert query
        $query = "INSERT INTO user
            SET
                name = '$name',
                email = '$email',
                password = '$password_hashed'";

        // prepare statement
        $stmt = $this->db->prepare($query);

        // execute and return bool type value to know if user was saved successfully
        if ($stmt->execute()) {
            $this->user = new User(
                $this->db->lastInsertId(),
                $name,
                $email,
                $data['password']
            );
            return true;
        }
        return false;
    }

    // check if given email exist in the database, create user object if exists
    public function emailExists(string $email): bool
    {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE email = '$email'");
        $stmt->execute();

        // get user from database
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // if user found return true and add username to Session
        if ($user) {
            $this->user = new User($user['id'], $user['name'], $user['email'], $user['password']);
            $_SESSION['_response_message'] = 'User email exists.';
            return true;
        }

        // return false if user was not found in the database
        return false;
    }

    public function getUser(): ?object
    {
        return $this->user;
    }

    public function resetPassword(string $password): bool
    {
        //hash password for correct storage in DB
        $password_hashed = password_hash($password, PASSWORD_BCRYPT);
        $userId = $this->user->id();

        $stmt = $this->db->prepare("UPDATE user SET password='$password_hashed' 
                                    WHERE id='$userId'");
        if ($stmt->execute()) return true;
        return false;
    }
}