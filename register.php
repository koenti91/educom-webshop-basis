<?php

function showRegisterHeader() {
    echo 'Registreren';
}

function showRegisterContent() {
    $data=validateRegister();
    if(!$data ["valid"]) {
        showRegisterForm($data);
    }  else {
        saveUser($data["name"], $data["email"], $data["password"]);
    }
}

function validateRegister() {
    $name = $email = $password = $passwordRepeat = '';
    $nameErr = $emailErr = $passwordErr = $passwordRepeatErr = '';
    $valid = false;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $name = testInput(getPostvar("name"));
        if (empty($name)) {
            $nameErr = "Naam is verplicht";
        } 
        else if (!preg_match("/^[a-zA-Z' ]*$/",$name)) {
            $nameErr = "Alleen letters en spaties zijn toegestaan."; 
        }
        
        $email = testInput(getPostVar("email")); 
        if (empty($email)) {
            $emailErr = "E-mail is verplicht";
        }
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Vul een correct e-mailadres in.";
        }

        $password = testInput(getPostvar("password"));
        if (empty($password)) {
            $passwordErr = "Vul hier een wachtwoord in.";
        }
        else {
            $errors = array();
            if (!preg_match('@[A-Z]@', $password)) { 
                array_push($errors, "een hoofdletter");
            }
           
            if (!preg_match('@[a-z]@', $password)) {
                array_push($errors, "een kleine letter");    
            }
            if (!preg_match('@[0-9]@', $password)) {
                array_push($errors, "een cijfer");
            }
            if (!preg_match('@[^\w]@', $password)) {
                array_push($errors, "een speciaal teken");
            }
            if (strlen($password) < 8) {
                array_push($errors, "acht tekens");
            }
            if (!empty($errors)) {
                $passwordErr = "Wachtwoord moet tenminste " . implode(", ", $errors) . " bevatten.";
            }
        }

        $passwordRepeat = testInput(getPostvar("password-repeat"));
        if (empty($passwordRepeat)) {
            $passwordRepeatErr = "Herhaal hier je gekozen wachtwoord.";
        }
        else if ($password != $passwordRepeat) {
            $passwordRepeatErr = "Je wachtwoorden komen niet overeen.";
        }

        if (empty($nameErr) && empty($emailErr) && empty($passwordErr) && empty($passwordRepeatErr)){
            if (empty(findUserByEmail($email))){
                $valid = true;
            } else {
                $emailErr = "E-mailadres is al in gebruik.";
            }
        }   
    }

    return array ("name" => $name, "email" => $email, "password" => $password, "passwordRepeat" => $passwordRepeat,
                    "nameErr" => $nameErr, "emailErr" => $emailErr, "passwordErr" => $passwordErr,
                    "passwordRepeatErr" => $passwordRepeatErr, "valid" => $valid); 
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
    $newUser = $email . '|' . $name . '|' . $password;
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