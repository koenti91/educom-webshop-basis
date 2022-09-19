<?php

function showRegisterHeader() {
    echo 'Registreren';
}

function showRegisterContent() {
    $data = validateRegister();
    if(!$data ["valid"]) {
        showRegisterForm($data);
    }  else {
        saveUser($data["name"], $data["email"], $data["password"]);
        header("Location: http://" . $_SERVER["HTTP_HOST"]. "/educom-webshop-basis/index.php?page=login");
        die();
    }
}

function testInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
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

function saveUser($name, $email, $password) {
    $file = fopen("users/users.txt", "a");
    $newUser = $email . '|' . $name . '|' . md5($password);
    fwrite($file, PHP_EOL . $newUser); 
    fclose($file);
}

function showRegisterForm($data) {
echo '
<h3> Registreren</h3>

    <form action="index.php" method="post">
        <fieldset>
            <label for="name"><b>Naam: </b></label>
            <input class="name" type="text" name="name" value="'. $data["name"] .'" placeholder="Henk de Vries" maxlength="50" required>
            <span class="error">* '. $data["nameErr"] .' </span>
            <br>
            <label for="email"><b>Email: </b></label>
            <input class="email" type="text" name="email" value="'. $data["email"] .'" placeholder="henk74@gmail.com" maxlength="60" required>
            <span class="error">* '. $data ["emailErr"] .' </span>
            <br>
            <label for="password"><b>Wachtwoord: </b></label>
            <input class="password" type="password" name="password" value="'. $data["password"] .'" placeholder="Kies een wachtwoord." maxlength="20" required>
            <span class="error">* '. $data["passwordErr"] .' </span>
            <br>
            <label for="password-repeat"><b>Herhaal je wachtwoord: </b></label>
            <input class="password-repeat" type="password" name="password-repeat" value="'. $data["passwordRepeat"] .'" placeholder="Herhaal het gekozen wachtwoord." maxlength="20" required>
            <span class="error">* '. $data["passwordRepeatErr"] .' </span>
        </fieldset>
        <input class="submit" name="submit" type="submit" value="Doorgaan">
        <input type="hidden" name="page" value="register" />
    </form>';
}
?>