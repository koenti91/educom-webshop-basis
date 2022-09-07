<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" href="css/stylesheet.css">
    </head>

    <body>
       <?php

         $gender = $name = $email = $phone = $preferred = $question = '';
         $genderErr = $nameErr = $emailErr = $phoneErr = $preferredErr = $questionErr = '';
         $valid = false;

        
         if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (!isset($_POST['gender'])) { 
                $genderErr = "Aanhef is verplicht.";
            } else {
                $gender = test_input($_POST['gender']);
            
                switch ($gender) {
                    case 'sir':
                    case 'madam':
                    case 'other':
                       break;

                    default:
                      $genderErr = "Aanhef is niet correct.";
                      break;       
                }
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

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
          }
       ?>

        <header>Contact
        </header>

        <div class="menu">
            <ul class="nav-tabs">
                <li><a href="index.html">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div> 

        <h3>Contactformulier</h3>

        <?php if (!$valid) { ?>

        <form action="contact.php" method="post">
            <fieldset>
            <label for="gender">Aanhef:</label>
            <select class="gender" name="gender" id="gender" required>
              <option value="">Kies aanhef</option>
              <option value="sir" <?php if ($gender=="sir") echo 'selected="selected"';?>>De heer</option>
              <option value="madam" <?php if ($gender=="madam") echo 'selected="selected"';?>>Mevrouw</option>
              <option value="other" <?php if ($gender=="other") echo 'selected="selected"';?>>Anders</option>
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
                <input type="radio" id="pref-1" name="preferred" <?php if (isset($preferred) && $preferred=="email") echo "checked";?> value="email" required>
                <label for="pref-1" class="option">Mailen</label>
                <input type="radio" id="pref-2" name="preferred" <?php if (isset($preferred) && $preferred=="phone") echo "checked";?> value="phone">
                <label for="pref-2" class="option">Bellen</label>
                <span class="error">* <?php echo $preferredErr; ?></span>
                <br>

                <label for="question">Vraag/suggestie: </label>
                <textarea id="question" name="question" maxlength="1000" required><?php echo $question; ?></textarea>
                <span class="error">* <?php echo $questionErr; ?></span>
            </fieldset>
            <input class="submit" name="submit" type="submit" value="Submit">
        </form> 
        <br>
        <?php } else { ?>
            <p>Bedankt voor het invullen. Ik neem zo snel mogelijk contact met je op!</p>
            <?php
            echo "<h2>Jouw gegevens:</h2>";
            echo $name;
            echo "<br>";
            echo $email;
            echo "<br>";
            echo $phone;
            echo "<br>";
            echo $preferred;
            echo "<br>";
            echo $question;?>
        <?php } ?>
        <footer><p class="copyright">&copy; 2022 Koen Tiepel</p></footer>
    </body>

</html> 