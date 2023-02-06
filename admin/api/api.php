<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/global/php/functions.php");
session_start();

if ($_SESSION['id'] != 1) {
    echo "no auth";
    exit;
}

$endpoints = array();
function addendpoint($name, $file, $needskey = false, $keyperms = 0)
{
    global $endpoints;
    $endpoints[$name] = array("needskey" => $needskey, "keyperms" => $keyperms, "file" => $file);
}




// * Base *
addendpoint("gallery/items", "gallery/items.php");






$requestedPage = $_SERVER['REQUEST_URI'];
$requestedPage = str_replace("/admin/api/", "", $requestedPage);
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

// key check
if ($pageinfo["needskey"]) {
    // * note: we'll never need keys, but i'm leaving this here in case we ever want them
    if ($requestedKey == null) {
        header("HTTP/1.1 401 Unauthorized");
        printerror("401 Unauthorized", "You must provide a key to access this page.");
        exit();
    }

    $keys = Database::execSelect("SELECT * FROM ApiKeys WHERE apikey = ?", "s", array($requestedKey));

    if ($keys == null) {
        header("HTTP/1.1 401 Unauthorized");
        printerror("401 Unauthorized", "The key you provided is invalid.");
        exit();
    }

    $key = $keys[0];
    if ($key["keyperms"] < $pageinfo["keyperms"]) {
        header("HTTP/1.1 401 Unauthorized");
        printerror("401 Unauthorized", "You do not have the permissions to access this page.");
        exit();
    }
}
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include($endpoints[$requestedPage]["file"]);
