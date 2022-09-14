<?php

        define("GENDERS", array("sir" => "De heer", "madam" => "Mevrouw", "other" => "Anders"));
        define("PREFERRED", array("email" => "E-mail", "phone" => "Telefoon", "pidgeon" => "Postduif"));

function showContactHeader() {
    echo 'Contactformulier';
}

function showContactContent () {
    $data = validateContact();
    if (!$data ["valid"]) {
        showContactForm ($data);
        } else {
            showContactThanks ($data);
    }
}

function validateContact () {
    $gender = $name = $email = $phone = $preferred = $question = '';
    $genderErr = $nameErr = $emailErr = $phoneErr = $preferredErr = $questionErr = '';
    $valid = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $gender = testInput(getPostVar("gender"));
        if (empty($gender)) { 
            $genderErr = "Aanhef is verplicht.";
        } else if (!array_key_exists($gender, GENDERS)) {
            $genderErr = "Aanhef is niet correct.";
        }

        $name = testInput(getPostVar("name"));
        if (empty($name)) {
            $nameErr = "Naam is verplicht";
        }
            else if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
            $nameErr = "Alleen letters en spaties zijn toegestaan.";
        }
        
        $email = testInput(getPostVar("email"));
        if (empty($email)) {
            $emailErr = "E-mail is verplicht";
        } 
            else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Vul een correct e-mailadres in";
        }
        
        $phone = testInput(getPostVar("phone"));
        if (empty($phone)) {
            $phoneErr = "Telefoonnummer is verplicht";
        } 
            else if (!preg_match("/^0([0-9]{9})$/",$phone)) {
            $phoneErr = "Vul een geldig telefoonnummer in.";
        }

        $preferred = testInput(getPostVar("preferred"));
        if (!isset($preferred)) {  
            $preferredErr = "Vul een voorkeur in."; 
        } 
            else if (!array_key_exists($preferred, PREFERRED)) {
            $preferredErr = "Vul een voorkeur in.";  
        }

        $question = testInput(getPostVar("question"));    
        if (empty($question)) {
            $questionErr = " Vul hier je vraag of opmerking in.";
        }   
            else {
            $question = testInput($_POST["question"]);
        }  

        if (empty($genderErr) && empty($nameErr) && empty($emailErr) && 
            empty($phoneErr) && empty($preferredErr) && empty($questionErr))  {
       
            $valid = true;
        } 
     }
     return array("gender" => $gender, "genderErr" => $genderErr, 
                    "name" => $name, "nameErr" => $nameErr, "email" => $email, 
                    "emailErr" => $emailErr, "phone" => $phone, "phoneErr" => $phoneErr,  
                    "preferred" => $preferred, "preferredErr" => $preferredErr, 
                    "question" => $question, "questionErr" => $questionErr,
                    "valid" => $valid);
}

function testInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function showContactForm($data) {
    echo '<form action="index.php" method="post">
            <fieldset>
            <label for="gender"><b>Aanhef:</b></label>
            <select class="gender" name="gender" id="gender" required>
              <option value="">Kies aanhef</option>';
                foreach(GENDERS as $gender_key => $gender_value) {
                    echo '<option value="' . $gender_key . '"';
                    if ($data["gender"] == $gender_key) { 
                        echo ' selected="selected"'; 
                    }
                    echo '>' . $gender_value . '</option>' . PHP_EOL; 
                } 
 
            echo'</select>
            <span class="error">* ' . $data["genderErr"] . '</span>
            <br>
            <label for="name"><b>Naam: </b></label>
            <input class="name" type="text" id="name" name="name" placeholder="Henk de Vries" maxlength="50" value="' . $data["name"] . '" required>
            <span class="error">* ' . $data["nameErr"] . '</span>
            <br>
            <label for="email"><b>E-mail: </b></label>
            <input class="email" type="email" id="email" name="email" placeholder="henk74@gmail.com" maxlength="60" value="' . $data["email"] . '" required>
            <span class="error">* ' . $data["emailErr"] . '</span>
            <br>
            <label for="phone"><b>Telefoon: </b></label>
            <input class="phone" type="text" id="phone" name="phone" placeholder="0612345678" maxlength="10" pattern="[0-9]{10}" value="' . $data["phone"] . '" required>
            <span class="error">* ' . $data["phoneErr"] . '</span>
            </fieldset>
                
            <fieldset>
                <label class="choose"   for="preferred"><b>Voorkeur contact: </b></label>';
                    foreach(PREFERRED as $preferred_key => $preferred_value) {
                        echo '<input type="radio" id="pref-' . $preferred_key . '" name="preferred" '; 
                        if ($data["preferred"]==$preferred_key) { echo "checked";}
                        echo ' value="'.$preferred_key.'"> ' . PHP_EOL . '<label for="pref-' . $preferred_key . '" class="option">'.$preferred_value.'</label>' . PHP_EOL; 
                    }
                echo'     
                <span class="error">* ' . $data["preferredErr"] . '</span>
                <br>

                <label for="question"><b>Opmerking: </b></label>
                <textarea type="text" id="question" name="question" maxlength="1000" placeholder="Iets:)">' . $data["question"] . '</textarea>
                <span class="error">* ' . $data["questionErr"] . '</span>
            </fieldset>
            <input class="submit" name="submit" type="submit" value="Versturen">
            <input type="hidden" name="page" value="contact" />
            </form> ';
}

function showContactThanks ($data) {
    echo
        '<p class="bedankt">Bedankt voor het invullen. Ik neem zo snel mogelijk contact met je op!</p>
        <h2>Jouw gegevens:</h2>
        <div class="results">';
        echo 'Aanhef: ' . GENDERS[$data["gender"]];
        echo "<br>";
        echo 'Naam: ' . $data["name"];
        echo "<br>";
        echo 'E-mailadres: ' . $data["email"];
        echo "<br>";
        echo ' Telefoonnummer: ' . $data["phone"];
        echo "<br>";
        echo ' Voorkeur voor: ' . PREFERRED[$data["preferred"]];
        echo "<br>";
        echo ' Opmerking: ' . $data["question"];echo '
        </div>';
}
?>