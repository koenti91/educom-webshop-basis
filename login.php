<?php

function showLoginHeader() {
    echo ' Login';
}

function showLoginContent () {

    if (!empty($_SESSION['email'])) {
        header("Location: http://" . $_SERVER["HTTP_HOST"]. "/educom-webshop-basis/index.php?page=home");
        die();
    }

    $data = validateLogin();
    if(!$data ["valid"]) {
        showLoginForm($data);
    } else {
        header("Location: http://" . $_SERVER["HTTP_HOST"]. "/educom-webshop-basis/index.php?page=home");
        die();
    }
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
    if (md5(trim($password)) == trim($user['password'])) {
        $_SESSION["email"] = $user['email'];
        return $user;
    }
    return NULL;
}

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

function showLoginForm($data) {
    echo '
    <h3> Login</h3>

    <form action="index.php?page=home" method="post">

    <fieldset>
      <label for="email"><b>E-mailadres: </b></label>
      <input class="email" type="email" name="email" placeholder="Vul je e-mailadres in." maxlength="60" value="' . $data["email"] . '" required>
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