<?php

 declare(strict_types=1);

namespace App\Validators;

class EmailAlreadyExistis implements Rule
{
    public function __construct(private string $field, private string $table) {}

    public function validate(mixed $data): string
    {
        return isset($data[$this->field]) &&
                !$this->isEmailExists($data[$this->field])
            ? ''
            : "Email {$data[$this->field]} already exists.";
    }

    public function isEmailExists(string $email): bool
    {
        $link = mysqli_connect("register-db", "root", "root", "my_db");
        if (!$link) {
            return false;
        }

        $result = mysqli_query($link, "SELECT * FROM {$this->table} WHERE email = '$email'");
        $exists = $result && mysqli_num_rows($result) > 0;
        mysqli_close($link);
        
        return $exists;
    }
}