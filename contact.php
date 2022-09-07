<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" href="css/stylesheet.css">
    </head>

    <body>
       <?php

         $sex = $name = $email = $phone = $preferred = $question = '';
         $sexErr = $nameErr = $emailErr = $phoneErr = $preferredErr = $questionErr = '';
         $valid = false;


         if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (!isset($_POST['sex'])) {
                $sexErr = "Aanhef is verplicht.";
            } else {
                $sex = test_input($_POST['sex']);
                
                switch ($sex) {
                    case 'sir':
                    case 'madam':
                    case 'other':
                       break;

                    default:
                      $sexErr = "Aanhef is niet correct.";
                      break;       
                }
            }

            if (!isset($_POST['name'])) {
                $nameErr = "Naam is verplicht";
            } else {
                $name = test_input($_POST['name']);
                if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
                    $nameErr = "Alleen letters en spaties zijn toegestaan.";
                    }
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
                if (!preg_match("/^[0-9]{10}*$/",$phone)) {
                    $phoneErr = "Alleen telefoonnummers met tien cijfers zijn toegestaan.";
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

        <form action="contact.php" method="post">
            <fieldset>
            <label for="sex">Aanhef:</label>
            <select class="sex" name="sex" id="sex" required>
              <option value="" selected="selected">Kies aanhef</option>
              <option value="sir">De heer</option>
              <option value="madam">Mevrouw</option>
              <option value="other">Anders</option>
            </select>
            <br>
            <label for="name">Naam: </label>
            <input class="name" type="text" id="name" name="name" placeholder="Henk de Vries" maxlength="50" value="<?php echo $name; ?>" required>
            <br>
            <label for="email">E-mail: </label>
            <input class="email" type="email" id="email" name="email" placeholder="henk74@gmail.com" maxlength="60" value="<?php echo $email; ?>" required>
            <br>
            <label for="phone">Telefoon: </label>
            <input class="phone" type="text" id="phone" name="phone" placeholder="0612345678" maxlength="10" pattern="[0-9]{10}" value="<?php echo $phone; ?>" required>
            </fieldset>
                
            <fieldset>
                <label for="preferred">Voorkeur contact: </label>
                <input type="radio" id="pref-1" name="preferred" <?php if (isset($preferred) && $preferred=="email") echo "checked";?> value="email" required>
                <label for="pref-1" class="option">Mailen</label>
                <input type="radio" id="pref-2" name="preferred" <?php if (isset($preferred) && $preferred=="email") echo "checked";?> value="phone">
                <label for="pref-2" class="option">Bellen</label>
                <br>

                <label for="question">Vraag/suggestie: </label>
                <textarea id="question" name="question" maxlength="1000" value="<?php echo $question; ?>" required></textarea>
            </fieldset>
            <input class="submit" name="submit" type="submit" value="Submit">
        </form> 
        <br>
        <footer><p class="copyright">&copy; 2022 Koen Tiepel</p></footer>
    </body>

</html> 