<?php

// Main
$page = getRequestedPage();
showResponsePage($page);

// Functions
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
        default:
            echo 'Error: Page not found';
    }
    echo '</header>';
}

function showMenu()
{
    echo '<div class="menu">
    <ul class="nav-tabs">
        <li><a href="index.php?page=home">Home</a></li>
        <li><a href="index.php?page=about">About</a></li>
        <li><a href="index.php?page=contact">Contact</a></li>
    </ul>
    </div>';
}

function showContent($page)
{
    switch ($page)
    {
        case 'home':
            require_once('home.php');
            showHomeContent();
            break;
        case 'about':
            require_once('about.php');
            showAboutContent();
            break;
        case 'contact':
            require_once('contact.php');
            showContactContent();
            break;
        default: 
            echo 'Error: Page not found';
    }
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