<?php

function showLoginHeader() {
    echo ' Login';
}

function showLoginContent () {
    $data = validateLogin();
    if(!$data ["valid"]) {
        showLoginForm($data);
    }   else {
        
    }
}

function validateLogin() {
    $email = $password = '';
    $emailErr = $passwordErr = '';
    $valid = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $email = testInput(getPostVar("email"));
        if (empty($email)) {
            $emailErr = "Vul je e-mailadres in.";
        }

        $password = testInput(getPostVar("password"));
        if (empty($password)) {
            $passwordErr = "Vul je gekozen wachtwoord in.";
        }

        if (empty($emailErr) && empty($passwordErr)) {
            $valid = true;
        }

        if ($valid) {
            require_once("users/users.txt");
            $user = authenticateUser ($email, $password);
            if (empty($user)) {
                $valid = false;
                $emailErr = "E-mailadres is niet bekend of wachtwoord wordt niet herkend.";
            }
            else {
                $email = $user["email"];
            }
        }
    }
    
    return array("email" => $email, "password" => $password, "emailErr" => $emailErr, 
                "passwordErr" => $passwordErr, "valid" => $valid);
}

function testInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function doesUserExist($email) {
    $user = findUserbyEmail($email);
    return !empty($user);
}

function authenticateUser($email, $password) {
    $user = findUserbyEmail($email);
    if (empty($user)) {
        return NULL;
    }
    if ($password == $user["password"]) {
        return $user;
    }
    return NULL;
}

function findUserbyEmail($email) {
    $file = fopen("users/users.txt", "r");
    $user = NULL;
    $line = fgets($file);
    
    while (!feof($file)) {
        $line = fgets($file);
        $parts = explode("|", $line);
        if ($parts [0] == "$email") {
            $user = array("email" => $parts[0], "name" => $parts[1], "password" => $parts[2]);
        }
    }
    fclose($file);
    return $user;
}

function showLoginForm($data) {
    echo '
    <h3> Login</h3>

    <form action="index.php?page=home" method="post">

    <fieldset>
      <label for="email"><b>E-mailadres: </b></label>
      <input class="email" type="email" name="email" placeholder="Vul je e-mailadres in." maxlength="60"
        value="' . $data["email"] . '" required>
      <span class="error">*</span>
        <br>
      <label for="password"><b>Wachtwoord: </b></label>
      <input class="password" type="password" name="password" placeholder="Vul hier je wachtwoord in." value ="' . $data["password"] . '"  maxlength="20" required>
      <span class="error">*</span>
        <br>
      <span class="error2">' . $data["emailErr"] . '</span>
        <br>
      <input type="submit" class="submit" value="Login" />
      <input type="hidden" name="page" value="login" />

    </fieldset>
    </form>';
}

?>