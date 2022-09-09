<?php

$page = getRequestedPage();
showResponsePage($page);

function getRequestedPage()
{
    $requested_type = $_SERVER('REQUEST_TYPE');
    if ($requested_type == 'POST') 
    {
        $requested_page = getPostVar('page','home');
    }
    else
    {
        $requested_page = getUrlVar['page','home'];
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

$value = filter_input(INPUT_POST, $key); 
    {    
    return getArrayVal($_POST, $key, $default);
}

function getUrlVar($key, $default = '')
{
    // zelf invullen
}

function beginDocument()
{
    echo '<!doctype html>
    <html>';
}

function showHeadSection()
{
    switch ($page)
    {
        case 'home':
            require('home.php');
            showHeadContent();
            break;
        case 'about':
            require('about.php');
            showHeadContent();
            break;
        case 'contact':
            require('contact.php');
            showHeadContent();
            break;
        default:
            echo 'Error: Page NOT found';
    }
}

function showHeader($page)
{
    switch ($page)
    {
        case 'home':
            require('home.php');
            showHeaderContent();
            break;
        case 'about':
            require('about.php');
            showHeaderContent();
            break;
        case 'contact':
            require('contact.php');
            showHeaderContent();
            break;
        default:
            echo 'Error: Page not found';
    }
}

function showMenu()
{
    foreach ($key as $page){
        showMenu($page);
    }
}

function showContent($page)
{
    switch ($page)
    {
        case 'home':
            require('home.php');
            showHomeContent();
            break;
        case 'about':
            require('about.php');
            showHomeContent();
            break;
        case 'contact':
            require('contact.php');
            showHomeContent();
            break;
        default: 
            echo 'Error: Page not found';
    }
}

function showFooter()
{
    echo '<footer></footer>';
}

function closeBody()
{
    echo '</body>';
}

function endDocument()
{
    echo '</html>';
}

?>