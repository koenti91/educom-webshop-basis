<?php

session_start();

require_once ("constants.php");
require_once ("session_manager.php");
require_once ("validations.php");
require_once ("user_service.php");
require_once ("file_repository.php");

// Main
$page = getRequestedPage();
$data = processRequest($page);
showResponsePage($data);


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
            showHomeContent($data);
            break;

        case 'about':
            showAboutContent($data);
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

function showResponsePage($data)
{
    // if (!empty($_GET['logout'])) {
    //     session_destroy();
    //     $data['page'] = 'home';
    // } else if (!empty($_SESSION['email'])) {        
    //     $data['page'] = 'home';
    // }

    beginDocument();
    showHeadSection($data);
    showBodySection($data);
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

function showBodySection($data)
{
    echo '<body>';
    showHeader($data);
    showMenu();
    showContent($data);
    showFooter();
    echo '</body>';
}

function showHeader($data) {   
    echo ' <header>';
    switch ($data['page'])
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
        echo showMenuItem("logout", "Logout " . getLoggedInUsername());
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