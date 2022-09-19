<?php

function authenticateUser($email, $password) {
    $user = findUserbyEmail($email);

    if (empty($user)) {
        return NULL;
    }
    if (md5(trim($password)) == trim($user['password'])) {
        $_SESSION["email"] = $user['email'];
        return $user;
    }
    return NULL;
}

function doesUserExist($email) {
    $user = findUserbyEmail($email);
    return !empty($user);
}

function saveUser($name, $email, $password) {
    $file = fopen("users/users.txt", "a");
    $newUser = $email . '|' . $name . '|' . md5($password);
    fwrite($file, PHP_EOL . $newUser); 
    fclose($file);
}

?>