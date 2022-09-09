<?php

        define("GENDERS", array("sir" => "De heer", "madam" => "Mevrouw", "other" => "Anders"));
        define("PREFERRED", array("email" => "E-mail", "phone" => "Telefoon", "pidgeon" => "Postduif"));

function showContactHeader() {
    echo '<h3>Contactformulier</h3>';
}

function showContactContent () {
    $data=validateContact();
    if (!$data ["valid"]) {
        showContactForm ($data);
        } else {
            showContactThanks ();
    }
}

function validateContact () {
    $gender = $name = $email = $phone = $preferred = $question = '';
    $genderErr = $nameErr = $emailErr = $phoneErr = $preferredErr = $questionErr = '';
    $valid = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (empty($_POST['gender'])) { 
            $genderErr = "Aanhef is verplicht.";
        } else {
            $gender = test_input($_POST['gender']);
            if (!array_key_exists($gender, GENDERS)) {
                  $genderErr = "Aanhef is niet correct.";
            }
        }
            
        if (!isset($_POST['gender'])) {
            $genderErr = "Aanhef is niet correct.";
            } else {
                $gender = test_input($_POST['gender']);
                }
                if (!array_key_exists($gender, GENDERS)) {
                    $genderErr = "Aanhef is niet correct.";
                }

        if (empty($_POST['name'])) {
            $nameErr = "Naam is verplicht";
        } else {
            $name = test_input($_POST['name']);}
            if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
                $nameErr = "Alleen letters en spaties zijn toegestaan.";
                }
        
        if (empty($_POST["email"])) {
            $emailErr = "E-mail is verplicht";
        } else {
            $email = test_input($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              $emailErr = "Vul een correct e-mailadres in";
            }
        }
        
        if (empty($_POST["phone"])) {
            $phoneErr = "Telefoonnummer is verplicht";
        } else {
            $phone = test_input($_POST["phone"]);
            if (!preg_match("/^0([0-9]{9})$/",$phone)) {
                $phoneErr = "Vul een geldig telefoonnummer in.";
            }
        }

        if (empty($_POST["preferred"])) {
            $preferredErr = "Vul een voorkeur in.";
        }   else {
            $preferred = test_input($_POST["preferred"]);
        }

        if (!isset($_POST['preferred'])) {  
            $prederredErr = "Vul een voorkeur in."; 
        } else { 
            $preferred = test_input($_POST['preferred']); 
     
            if (!array_key_exists($preferred, PREFERRED)) {
                 $preferredErr = "Vul een voorkeur in.";  
            }
        } 

        if (empty($_POST["question"])) {
            $questionErr = " Vul hier je vraag of opmerking in.";
        }   else {
            $question = test_input($_POST["question"]);
        }  

        if (empty($genderErr) && empty($nameErr) && empty($emailErr) && 
            empty($phoneErr) && empty($preferredErr) && empty($questionErr))  {
       
            $valid = true;
        } 
     }

     function cleanupInputFromUser($data) {;
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

function showContactForm($data) {
    echo '<form action="contact.php" method="post">
            <fieldset>
            <label for="gender">Aanhef:</label>
            <select class="gender" name="gender" id="gender" required>
              <option value="">Kies aanhef</option>
              <?php 
                foreach(GENDERS as $gender_key => $gender_value) {
                    echo '<option value="' . $gender_key . '"';
                    if ($gender == $gender_key) { 
                        echo ' selected="selected"'; 
                    }
                    echo '>' . $gender_value . '</option>' . PHP_EOL; 
                } 
            ?>
            </select>
            <span class="error">* <?php echo $genderErr; ?></span>
            <br>
            <label for="name">Naam: </label>
            <input class="name" type="text" id="name" name="name" placeholder="Henk de Vries" maxlength="50" value="<?php echo $name; ?>" required>
            <span class="error">* <?php echo $nameErr; ?></span>
            <br>
            <label for="email">E-mail: </label>
            <input class="email" type="email" id="email" name="email" placeholder="henk74@gmail.com" maxlength="60" value="<?php echo $email; ?>" required>
            <span class="error">* <?php echo $emailErr; ?></span>
            <br>
            <label for="phone">Telefoon: </label>
            <input class="phone" type="text" id="phone" name="phone" placeholder="0612345678" maxlength="10" pattern="[0-9]{10}" value="<?php echo $phone; ?>" required>
            <span class="error">* <?php echo $phoneErr; ?></span>
            </fieldset>
                
            <fieldset>
                <label for="preferred">Voorkeur contact: </label>
                <?php 
                    foreach(PREFERRED as $preferred_key => $preferred_value) {
                        echo '<input type="radio" id="pref-' . $preferred_key . '" name="preferred" '; 
                        if (isset($preferred) && $preferred==$preferred_key) echo "checked";
                        echo ' value="'.$preferred_key.'"> ' . PHP_EOL . '<label for="pref-' . $preferred_key . '" class="option">'.$preferred_value.'</label>' . PHP_EOL; 
                    } 
                ?>
                <span class="error">* <?php echo $preferredErr; ?></span>
                <br>

                <label for="question">Vraag/suggestie: </label>
                <textarea id="question" name="question" maxlength="1000" required><?php echo $question; ?></textarea>
                <span class="error">* <?php echo $questionErr; ?></span>
            </fieldset>
            <input class="submit" name="submit" type="submit" value="Submit">
             </form> ';
}

functio showContactThanks () {
    echo
        '<p class="bedankt">Bedankt voor het invullen. Ik neem zo snel mogelijk contact met je op!</p>
        <h2>Jouw gegevens:</h2>
        <div class="results">
        <?php
        echo 'Aanhef: ' . GENDERS[$gender];
        echo "<br>";
        echo 'Naam: ' . $name;
        echo "<br>";
        echo 'E-mailadres: ' . $email;
        echo "<br>";
        echo ' Telefoonnummer: ' . $phone;
        echo "<br>";
        echo ' Voorkeur voor: ' . PREFERRED[$preferred];
        echo "<br>";
        echo ' Vraag/opmerking: ' . $question;?>
        </div>';
}