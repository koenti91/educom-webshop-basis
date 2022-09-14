<?php

function showRegisterHeader() {
    echo 'Registreren';
}

function showRegisterContent() {
    $data=validateRegister();
    if(!$data ["valid"]) {
        showRegisterForm($data);
    }   else {
        // Go to login page
    }
}

function validateRegister() {
    $name = $email = $password = $passwordRepeat = '';
    $nameErr = $emailErr = $passwordErr = $passwordRepeatErr = '';
    $valid = false;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (empty($_POST["name"])) {  
            $nameErr = "Naam is verplicht";
        } 
            else {
                $name = testInput($_POST["name"]);
            if (!preg_match("/^[a-zA-Z' ]*$/",$name)) {
                $nameErr = "Alleen letters en spaties zijn toegestaan.";
             }
         }

        if (empty($_POST["email"])) {
            $emailErr = "E-mail is verplicht";
        }
            else {
                $email = testInput($_POST["email"]);    
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Vul een correct e-mailadres in.";
             }
         }

        if (empty($password)) {
            $passwordErr = "Vul hier een wachtwoord in.";
        }
            else {
                $password = testInput($_POST["password"]);
            if (!preg_match('@[A-Z@', $password)) { 
                $passwordErr = "Wachtwoord moet tenminste een hoofdletter bevatten.";
            }
        }   
            if (!preg_match('@[a-z]@', $password)) {
                $passwordErr = "Wachtwoord moet tenminste een kleine letter bevatten.";    
        }
            if (!preg_match('@[0-9]@', $password)) {
                $passwordErr = "Wachtwoord moet tenminste een cijfer bevatten.";
        }
            if (!preg_match('@[^/w]@', $password)) {
                $passwordErr = "Wachtwoord moet tenminste een speciaal teken bevatten.";
        }
            if (strlen($password) < 8) {
                $passwordErr = "Wachtwoord moet tenminste acht tekens bevatten.";
        }

        if (empty($passwordRepeat)) {
            $passwordRepeatErr = "Herhaal hier je gekozen wachtwoord.";
        }
            else {
                $passwordRepeat = testInput($_POST["passwordRepeat"]);
                  if ($_POST["password"]!= $_POST["passwordRepeat"]) {
                    $passwordRepeatErr = "Je wachtwoorden komen niet overeen.";
                }
            }

        if (empty($nameErr) && (empty($emailErr) && empty($passwordErr) && empty($passwordRepeatErr))) {
            $valid = true;
        }   
    }

    return array ("name" => $name, "email" => $email, "password" => $password, "passwordRepeat" => $passwordRepeat,
                    "nameErr" => $nameErr, "emailErr" => $emailErr, "passwordErr" => "passwordErr",
                    "passwordRepeatErr" => $passwordRepeatErr, "valid" => $valid); 
}

function testInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
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