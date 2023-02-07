<style>
    * {
        padding: 0px;
        margin: 0px;
        /* use monospace */
        font-family: monospace;
        background-color: #000;
        color: #f55;
    }

    b {
        color: inherit;
    }

    p {
        margin: 4px;
        padding: 4px;
        background-color: #111;
    }

    .big {
        background-color: #0c0c0c;
        font-size: 18px;
    }
</style>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/global/php/functions.php");
function doLog($text, $title = "log", $color = "#000", $big = false)
{
    echo "<p style='color: $color;'";
    if ($big) {
        echo " class='big'";
    }
    echo ">";

    echo "<b>" . $title . "</b>: " . $text;
    echo "</p>";
}

ini_set('memory_limit', '-1');
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

function getAspectRatio(int $width, int $height)
{
    // search for greatest common divisor
    $greatestCommonDivisor = static function($width, $height) use (&$greatestCommonDivisor) {
        return ($width % $height) ? $greatestCommonDivisor($height, $width % $height) : $height;
    };

    $divisor = $greatestCommonDivisor($width, $height);

    return $width / $divisor . ':' . $height / $divisor;
}

function doResize($directory)
{
    $dir    = $directory . 'original';
    $files1 = scandir($dir);

    foreach ($files1 as $image) {
        if(isset($_REQUEST['id'])) {
            if(!str_contains($image, $_REQUEST['id'])) {
                continue;
            }
        }
        $image_orig = $directory . "original/" . $image;
        if (str_contains($image, ".png") || str_contains($image, ".jpg")) {
            // let's say it's 1920x1080. 1920/1080 1.7777777777777...
            // now let's downscale this to 1280x720, we can set the height to 720
            // then set the width to 720*1.7777777777 (aka 720*widthMultiplier)
            // that leaves us with 1280
            // which gives us perfect downscaling to 720p without changing aspect ratio
            if (!file_exists($directory . "thumbnails/" . $image) || !file_exists($directory . "small/" . $image)) {
                doLog("Resizing " . $image, "info", "#85f", true);
                if (mime_content_type($image_orig) == "image/png") {
                    $img = imagecreatefrompng($image_orig);
                    doLog("Loading from PNG", "info", "#42c", false);
                } else {
                    $img = imagecreatefromjpeg($image_orig);
                    doLog("Loading from JPG", "info", "#42c", false);
                }

                $widthMultiplier = imagesx($img) / imagesy($img); // imgx / imgy

                $heightMultiplier = imagesy($img) / imagesx($img); // imgx / imgy

                $aspectRatio = getAspectRatio(imagesx($img), imagesy($img));

                doLog("Aspect ratio is " . $aspectRatio, "extra", "#666", false);
                Database::execOperation("UPDATE `Gallery` SET `Ratio`=? WHERE `Filename`=?", "ss", [$aspectRatio, $image]);

                $simpleAspectRatio = "square";
                $ar = explode(":", $aspectRatio);
                // round to nearest 100ths, some square images are like 1024x1023 so we just do this to make sure we get it right most of the time:tm:
                $w = floor(imagesx($img) / 10) * 10;  // Output:700
                $h = ceil(imagesy($img) / 10) * 10;  // Output:800
                if($w > $h) {
                    $simpleAspectRatio = "wide";
                } else if($h > $w) {
                    $simpleAspectRatio = "tall";
                }

                Database::execOperation("UPDATE `Gallery` SET `SimpleRatio`=? WHERE `Filename`=?", "ss", [$simpleAspectRatio, $image]);


                if (!file_exists($directory . "thumbnail/" . $image)) {
                    $imgResize = imagescale($img, 200, 200 * $heightMultiplier);
                    $jpg = imagepng($imgResize, $directory . "thumbnail/" . $image, 2);
                } else {
                    doLog("Skipping Thumbnail because already processed", "info", "#2f6", false);
                }

                if (!file_exists($directory . "small/" . $image)) {
                    $imgResize_small = imagescale($img, 720 * $widthMultiplier, 720);
                    imagealphablending($imgResize_small, false);
                    imagesavealpha($imgResize_small, true);
                    $jpg = imagepng($imgResize_small, $directory . "small/" . $image, 2);
                } else {
                    doLog("Skipping Small because already processed", "info", "#2f6", false);
                }
                unset($img);
                unset($jpg);
                unset($imgResize);
                unset($imgResize_small);

                doLog("Done!", "info", "#2f6", true);
            }
        }
    }
}

doResize("../../img/gallery/");
