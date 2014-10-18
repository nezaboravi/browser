<?php
/**
 * Browser file, responsible to return json to front end
 */
require __DIR__ . '/../vendor/autoload.php';

use \Core\Browser as Browser;

$browser = new Browser();
$browser->setPath(realpath(__DIR__));

$root       = Browser::BROWSE_URL;
$browse_dir = !empty($_REQUEST['dir']) ? urldecode($_REQUEST['dir']) : $root;
$path = $browser->getPath() . '/' . $browse_dir;

$files      = Browser::listDirectory($path, $browse_dir);

echo json_encode([
    "name" => "files",
    "type" => "folder",
    "path" => 'public/files',
    "items" => $files
]);