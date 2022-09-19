<?php

function findUserByEmail($email) {
    $file = fopen("users/users.txt", "r");
    $user = NULL;
    $line = fgets($file);

    while (!feof($file)) {
        $line = fgets($file);
        $parts = explode("|", $line);
        if ($parts[0] === $email) {
            $user = array("email" => $parts[0], "name" => $parts[1], "password" => $parts[2]);
        }
    }
    fclose($file);
    return $user;
}

?>