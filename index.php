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
    showHeadSection();
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
    // zelf invullen
}

function showHeader($page)
{
    // zelf invullen
}

function showMenu()
{
    // zelf invullen
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
            // zelf invullen
    }
}

function showFooter()
{
    // zelf invullen
}

function closeBody()
{
    // zelf invullen
}

function endDocument()
{
    // zelf invullen
}

?>