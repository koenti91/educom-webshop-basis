<?php

function beginDocument()
{
    echo '<!doctype html>
    <html>';
}

function renderView($options) {
    beginDocument();

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


function endDocument()
{
    echo '</html>';
}