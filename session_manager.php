<?php

function doLoginUser($name) {
    $_SESSION['login'] = $name; 
}

function isUserLoggedIn() {
    return isset($_SESSION['login']);
}

function getLoggedInUsername() {
    return $_SESSION['login'];
}

function doLogoutUser() {
    unset($_SESSION['login']);
}

?>