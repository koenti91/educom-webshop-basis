<?php

function showRegisterHeader() {
    echo 'Registreren';
}

function showRegisterContent() {
    echo '
    <h3> Registreren</h3>

    <form action="index.php" method="post">
        <fieldset>
            <label for="name"><b>Naam: </b></label>
            <input class="name" type="text" name="name" placeholder="Vul hier je naam in." maxlength="50" required>
            <span class="error"></span>
            <br>
            <label for="email"><b>Email: </b></label>
            <input class="email" type="text" name="email" placeholder="Vul hier je email in." maxlength="60" required>
            <span class="error"></span>
            <br>
            <label for="password"><b>Password: </b></label>
            <input class="password" type="password" name="password" placeholder="Kies een wachtwoord." maxlength="20" required>
            <span class="error"></span>
            <br>
            <label for="password-repeat"><b>Herhaal je wachtwoord: </b></label>
            <input class="password-repeat" type="password" name="password-repeat" placeholder="Herhaal het gekozen wachtwoord." maxlength="20" required>
        </fieldset>
        <input class="submit" name="submit" type="submit" value="Submit">
        <input type="hidden" name="page" value="register" />
    </form>';
}
?>