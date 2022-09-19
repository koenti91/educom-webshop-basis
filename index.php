<?php

session_start();
require_once ("session_manager.php");

// Main
$page = getRequestedPage();
$data = processRequest($page);
showResponsePage($page);

// Functions

function processRequest($page) {
    switch ($page) {
        case "login":
            $data = validateLogin();
            if ($data['valid']) {
                doLoginUser($data['name']);
                $page = 'home';
            }
            break;

        case 'logout':
            doLogoutUser();
            $page = 'home';
            break;

        case 'contact':
            $data = validateContact();
            if($data['valid']) {
                $page = 'thanks';
            }
            break;
            
        case 'register':
            $data = validateRegister();
            if ($data['valid']) {
                saveUser($data["name"], $data["email"], $data["password"]);
                $page = 'login';
            }
            break;
    }

    $data['page'] = $page;

    return $data;
}

function showContent($data) {
    switch ($data['page']) {
        case 'home':
            showHomeContent();
            break;

        case 'about':
            showAboutContent();
            break;

        case 'contact':
            showContactForm($data);
            break;

        case 'thanks':
            showContactThanks($data);
            break;

        case 'login':
            showLoginForm($data);
            break;

        case 'register':
            showRegisterForm($data);
            break;
    }
}

function getRequestedPage()
{
    $requested_type = $_SERVER['REQUEST_METHOD'];
    if ($requested_type == 'POST') 
    {
        $requested_page = getPostVar('page','home');
    }
    else
    {
        $requested_page = getUrlVar('page','home');
    }
    return $requested_page;
}

function showResponsePage($page)
{
    if (!empty($_GET['logout'])) {
        session_destroy();
        header("Location: http://" . $_SERVER["HTTP_HOST"]. "/educom-webshop-basis/index.php?page=home");
        die();
    } else if (!empty($_SESSION['email'])) {

    }

    beginDocument();
    showHeadSection($page);
    showBodySection($page);
    endDocument();
}

function getArrayVar($array, $key, $default ='')
{
    return isset($array[$key]) ? $array[$key] : $default;
}

function getPostVar($key, $default ='')
    {    
    return getArrayVar($_POST, $key, $default);
}

function getUrlVar($key, $default = '')
{
    return getArrayVar($_GET, $key, $default);
}

function beginDocument()
{
    echo '<!doctype html>
    <html>';
}

function showHeadSection($page)
{
    echo '<head> <title>';
    switch ($page)
    {
        case 'home':
            require_once('home.php');
            showHomeHeader();
            break;
        case 'about':
            require_once('about.php');
            showAboutHeader();
            break;
        case 'contact':
            require_once('contact.php');
            showContactHeader();
            break;
        case 'register':
            require_once('register.php');
            showRegisterHeader();
            break;
        case 'login':
            require_once('login.php');
            showLoginHeader();
            break;
        default:
            echo 'Error: Page NOT found';
    }
    echo '</title> <link rel="stylesheet" href="css/stylesheet.css"> </head>';
}

function showBodySection($page)
{
    echo '<body>';
    showHeader($page);
    showMenu();
    showContent($page);
    showFooter();
    echo '</body>';
}

function showHeader($page) {   
    echo ' <header>';
    switch ($page)
    {
        case 'home':
            require_once('home.php');
            showHomeHeader();
            break;
        case 'about':
            require_once('about.php');
            showAboutHeader();
            break;
        case 'contact':
            require_once('contact.php');
            showContactHeader();
            break;
        case 'register':
            require_once('register.php');
            showRegisterHeader();
            break;
        case 'login':
            require_once('login.php');
            showLoginHeader();
            break;
        default:
            echo 'Error: Page not found';
    }
    echo '</header>';
}

function showMenu()
{
    echo '<div class="menu"><ul class="nav-tabs">';

    echo showMenuItem('home', 'Home'); 
    echo showMenuItem('about', 'About'); 
    echo showMenuItem('contact', 'Contact'); 

    if (isUserLoggedIn()) {
        echo showMenuItem("logout", "Logout" + getLoggedInUsername());
    } else {
        echo showMenuItem ("login", "Login");
        echo showMenuItem ("register", "Registreer");
    }

    echo '</ul></div>';
}

function showMenuItem($page, $label) {
    return '<li><a href="index.php?page='.$page.'">'.$label.'</a></li>';
}


function showFooter()
{
    echo '<footer>';
    echo '<p class="copyright">&copy; 2022 Koen Tiepel</p>';
    echo '</footer>';
}

function endDocument()
{
    echo '</html>';
}

?>