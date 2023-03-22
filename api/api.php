<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/global/php/functions.php");

$endpoints = array();
function addendpoint($name, $file, $needskey = false, $keyperms = 0)
{
    global $endpoints;
    $endpoints[$name] = array("needskey" => $needskey, "keyperms" => $keyperms, "file" => $file);
}



addendpoint("projects/items", "endpoints/projects/items.php");

addendpoint("gallery/webitems", "endpoints/gallery/webitems.php");

$requestedPage = $_SERVER['REQUEST_URI'];
$requestedPage = str_replace("/api/", "", $requestedPage);
if (str_contains($requestedPage, "?")) {
    $requestedPage = substr($requestedPage, 0, strpos($requestedPage, "?"));
}
$requestedKey = null;

if (isset($_GET['key'])) {
    $requestedKey = $_GET['key'];
}
if (isset($_POST['key'])) {
    $requestedKey = $_POST['key'];
}


function printerror($title = "Error", $message = "An error has occurred.")
{
    global $requestedPage;
    header("HTTP/1.1 500 Internal Server Error");
    echo "<center>";
    echo "<h1>$title</h1>";
    echo "<hr>";
    echo "<p>$message<p>";
    echo "<small>$requestedPage</small><br>";
    echo "<small>Tanza API</small>";
    echo "</center>";
    exit();
}

if (!isset($endpoints[$requestedPage])) {
    header("HTTP/1.1 404 Not Found");
    printerror("404 Not Found", "The page you requested was not found.");
    print_r($_GET);
    exit();
}

include_once($_SERVER['DOCUMENT_ROOT'] . "//global/php/functions.php");

$pageinfo = $endpoints[$requestedPage];

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include($endpoints[$requestedPage]["file"]);
