<?php namespace Core;

/**
 * Browser class
 *
 * @author    Vladimir Nikolic <nezaboravi@gmail.com>
 * @copyright Vladimir Nikolic <nezaboravi@gmail.com>
 */

/**
 * Class Browser
 *
 * @package   Core
 * @author    Vladimir Nikolic <nezaboravi@gmail.com>
 * @copyright Vladimir Nikolic <nezaboravi@gmail.com>
 */
class Browser
{
    /**
     * constanta
     */
    const BROWSE_URL = 'files';

    /**
     * @var string
     */
    public $path;

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * Static method for listing given directory
     *
     * @param string $path       path to directory (set to public/files as deafult for example)
     *
     * @param string $browse_dir browsing dir
     *
     * @return array
     */
    public static function listDirectory($path = 'files', $browse_dir = '')
    {
        $files = [];
        $dir   = realpath($path);
        if (!file_exists($dir))
        {
            return $files[] = ['ERROR' => 'No files or folders in given path ' . $path];
        }
        foreach (scandir($dir) as $object)
        {
            $modified  = self::getCorrectModificationTime($browse_dir . '/' . $object);
            $file_kind = filetype($browse_dir . '/' . $object);
            if (!$object || $object[0] == '.')
            {
                continue; // Ignore hidden objects
            }
            if (is_dir($dir . '/' . $object))
            {
                $files[] = array(
                    'name'     => $object,
                    'type'     => 'folder',
                    'path'     => htmlentities($browse_dir . '/' . $object),
                    'modified' => self::getReadableTime($modified),
                    'size'     => '--',
                    'kind'     => $file_kind,
                    // "items" => self::listDirectory($dir . '/' . $object)
                );
            }
            else
            {
                $files[] = array(
                    'name'     => $object,
                    'type'     => 'file',
                    'path'     => htmlentities($browse_dir . '/' . $object),
                    'size'     => self::formatSizeUnits(filesize($dir . '/' . $object)),
                    'modified' => self::getReadableTime($modified),
                    'kind'     => $file_kind,

                );
            }
        }

        return $files;
    }

    /**
     * Convert unix time to readable format
     *
     * @param string $unix_time
     *
     * @return string
     */
    public static function getReadableTime($unix_time)
    {
        $modified = '';
        if ($unix_time >= strtotime('today'))
        {
            $modified = 'Today, ' . date('g:i A', $unix_time);
        }
        else if ($unix_time >= strtotime('yesterday'))
        {
            $modified = 'Yesterday, ' . date('g:i A', $unix_time);
        }
        else
        {
            $modified = date('M dd Y g:i A', $unix_time);
        }
        return $modified;
    }
    /**
     * Get corrected file modification time
     * small correction for windows users
     *
     * @param string $file_path path to file/folder
     *
     * @return int
     */
    public static function getCorrectModificationTime($file_path)
    {
        $time       = \filemtime($file_path);
        $isDST      = (date('I', $time) == 1);
        $systemDST  = (date('I') == 1);
        $adjustment = 0;
        if ($isDST == false && $systemDST == true)
        {
            $adjustment = 3600;
        }
        else if ($isDST == true && $systemDST == false)
        {
            $adjustment = -3600;
        }
        else
        {
            $adjustment = 0;
        }

        return ($time + $adjustment);
    }

    /**
     * Format size of files
     *
     * @param integer $bytes size of file
     *
     * @return string
     */
    public static function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}