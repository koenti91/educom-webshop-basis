<?php

function validateLogin() {
        $email = $password = '';
        $emailErr = $passwordErr = '';
        $valid = false;
        $name = '';
    
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
                $user = authenticateUser ($email, $password);
                if (empty($user)) {
                    $valid = false;
                    $emailErr = "E-mailadres is niet bekend of wachtwoord wordt niet herkend.";
                } else {
                    $email = $user["email"];
                    $name = $user["name"];
                }
            }
        }
        
        return array(
                    "email" => $email, 
                    "password" => $password, 
                    "name" => $name,
                    "emailErr" => $emailErr, 
                    "passwordErr" => $passwordErr, 
                    "valid" => $valid);
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

?>