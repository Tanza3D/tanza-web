

<?php
$time_start = microtime(true);
$request_time = $_SERVER['REQUEST_TIME_FLOAT'];
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . "/global/php/functions.php");
?>
<!DOCTYPE html>
<html>
<?php
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
error_reporting(E_ALL);

echo "<style>html { background-color: #4A226E; color: white; font-family: sans-serif; }</style>";


$request = $_SERVER['REQUEST_URI'];
$request = strtok($request, '?');

$request = str_replace("admin", "", $request);

$request = ltrim($request, "/");

$request = (array)explode("/", $request);

$arguments = $request;
array_shift($arguments);

function logIn()
{
    $post = [
        'client_id' => OAUTH_ID,
        'client_secret' => OAUTH_SECRET,
        'code'   => $_GET['code'],
        'grant_type' => 'authorization_code'
    ];

    $ch = curl_init('https://id.untone.uk/api/oauth/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

    $response = curl_exec($ch);

    curl_close($ch);
    echo "<pre>";
    print_r($response);
    echo "</pre>";

    $response = json_decode($response, true);
    updateData($response['access_token']);
}

function updateData($token)
{
    echo "updating data";
    $headers = [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json'
    ];

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://id.untone.uk/api/users/me");
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    
    $response = json_decode(curl_exec($curl), true);
    $_SESSION['id'] = $response['id']; // set session vars
    $_SESSION['username'] = $response['username'];
}

if ($request[0] == "auth") {
    if (isset($_GET['code'])) {
        logIn();
    }
    Redirect("/admin/gallery");
} else {
    if (!isset($_SESSION['id'])) {
        echo "Please authorize.";
        //Redirect(OAUTH_REDIRECT_URL);
        exit;
    }
    if ($_SESSION['id'] != 1 && $_SESSION['id'] != 24117032) {
        echo "Unauthorized.";
        exit;
    }
}

$templates = [
    "basic" => [
        "name" => "basic",
        "path" => "basic.php"
    ]
];

include("routing.php");

$page_name = $request[0];

$meta_template = [
    "name" => "Tanza - Unknown Page",
    "description" => "We don't know what this page is."
];

$found = false;



foreach ($pages as $page) {
    if ($page['name'] == $page_name) {
        $found = true;
        $ref_page = $page;
    }
}



?>

<head>
    <?php
    // TODO: print meta here
    ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <?php
    Css("global/css/main.css");
    Css("admin/global/css/main.css");
    Css("admin/css/" . $ref_page['name'] . ".css");
    ?>
</head>

<body>
    <div class="background"></div>

    <div class="page">
        <?php
        if ($found == true) {
            ob_start();
            if (isset($ref_page['page'])) {
                include "views/" . $ref_page['page'];
            } else {
                include "views/" . $ref_page['name'] . "/" . $ref_page_inner['page'];
            }
            $meta = $meta_template;
            $page = ob_get_clean();
            ob_end_flush();
        }
        ob_start();
        if ($found == true) {
            if (isset($ref_page['template']) && $ref_page['template'] != "none") {
                // if 404 is called it wipes all page content
                $template = $templates[$ref_page['template']];
                include("templates/" . $template['path']);
            } else {
                echo $page;
            }
        } else {
            echo "404";
        }
        ?>
    </div>
</body>

<?php
foreach($ref_page['js'] as $js) {
    Js($js);
}

foreach($ref_page['css'] as $css) {
    Css($css);
}

Js("global/js/global.js");
Js("admin/global/js/global.js");
Js("admin/js/" . $ref_page['name'] . ".js");

$time = microtime(true) - $time_start;
$time = round($time, 4);
?>

</html>