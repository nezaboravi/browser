<?php
/**
 * Download file script
 *
 * @author Vladimir Nikolic <nezaboravi@gmail.com>
 *
 */
$file = mysql_real_escape_string($_REQUEST['file_path']);

if (file_exists($file))
{
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}