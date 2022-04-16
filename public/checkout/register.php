<?php

use Getwhisky\Controllers\Page;
use Getwhisky\Util\Util;

$path = realpath("C:/") ? "C:/wamp64/www/getwhisky-mvc" : "/var/www/getwhisky-mvc";
require_once "$path/vendor/autoload.php";

$page = new Page();
echo $page->displayPage();

$dob = "1997-09-25";
if (Util::verifyAge($dob, 18)) {
    echo "woo!";
} else {
    echo "booo!";
}
?>