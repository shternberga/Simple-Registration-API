<?php

class ResetLinkManager
{
    private $db;

    public function __construct(object $db)
    {
        $this->db = $db;
    }

    //save sent reset link to the database
    public function save(array $data): bool
    {
        // save data params to simple variables for PDO query
        $hash = $data['hash'];
        $email = $data['email'];

        // prepare insert query
        $query = "INSERT INTO resets
            SET
                email = '$email',
                hash = '$hash'";

        // prepare statement
        $stmt = $this->db->prepare($query);

        // execute and return bool type value to know if saved successfully
        if ($stmt->execute())
            return true;
        return false;
    }

    //delete old link from database
    public function updateLinks(string $email): bool
    {
        // prepare insert query
        $query = "DELETE FROM resets WHERE email = '$email'";

        // prepare statement
        $stmt = $this->db->prepare($query);

        // execute and return bool type value to know if deleted successfully
        if ($stmt->execute())
            return true;
        return false;
    }

    // return email
    public function getEmailBy(string $hash): ?string
    {

        $stmt = $this->db->prepare("SELECT * FROM resets WHERE hash = '$hash'");
        $stmt->execute();

        // get reset link info from database
        $reset = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($reset) {
            return $reset['email'];
        }

        // return null if reset link was not found
        return null;
    }

    // check created_at value
    public function isValid(string $hash): bool
    {

        $stmt = $this->db->prepare("SELECT * FROM resets WHERE hash = '$hash'");
        $stmt->execute();

        // get reset link info from database
        $reset = $stmt->fetch(PDO::FETCH_ASSOC);

        // if reset link found check if expired
        if ($reset) {
            $exp_date = strtotime($reset['created_at']);
            if ((time() - $exp_date) <= 3600)
                return true;
        }

        // return false if reset link expired
        return false;
    }
}