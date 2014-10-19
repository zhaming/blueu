<?php
/**
 *	类库-文件夹类
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2012-2013
 *	@version	1.0
 *	@package	MING
 *
 *	$Id$
 */

class MingDir
{
    /**
     * returns the directories in the path
     * if append path is set then this path will appended to the results
     *
     * @param string $path
     * @param string $appendPath
     * @return array
     */
    public static function getDirectories($path, $appendPath = false)
    {
        if (is_dir($path)) {
            $contents = scandir($path); //open directory and get contents
            if (is_array($contents)) { //it found files
                $returnDirs = false;
                foreach ($contents as $dir) {
                    //validate that this is a directory
                    if (is_dir($path . '/' . $dir) && $dir != '.' && $dir != '..' && $dir != '.svn') {
                        $returnDirs[] = $appendPath . $dir;
                    }
                }

                if ($returnDirs) {
                    return $returnDirs;
                }
            }

        }
    }

    /**
     * this is getting a little extreme i know
     * but it will help out later when we want to keep updated indexes
     * for right now, not much
     *
     * @param unknown_type $path
     */
    public static function make($path)
    {
        return mkdir($path, 0755);
    }

    /**
     * adds a complete directory path
     * eg: /my/own/path
     * will create
     * >my
     * >>own
     * >>>path
     *
     * @param string $base
     * @param string $path
     */
    public static function makeRecursive($base, $path)
    {
        $pathArray = explode('/', $path);
        if (is_array($pathArray)) {
            $strPath = null;
            foreach ($pathArray as $path) {
                if (!empty($path)) {
                    $strPath .= '/' . $path;
                    if (!is_dir($base . $strPath)) {
                        if (!self::make($base . $strPath)) {
                            return false;
                        }
                    }
                }
            }
            return true;
        }
    }

    /**
     * renames a directory
     *
     * @param string $source
     * @param string $newName
     */
    public static function rename($source, $newName)
    {
        if (is_dir($source)) {
            return rename($source, $newName);
        }
    }

    /**
     * copies a directory recursively
     * if you want to move the directory then follow this with deleteRecursive()...
     * @param string $source
     * @param string $target
     */
    public static function copyRecursive( $source, $target )
    {
        if (is_dir($source)) {
            @mkdir( $target );

            $d = dir( $source );

            while (false !== ($entry = $d->read())) {
                if ( $entry == '.' || $entry == '..' ) {
                    continue;
                }

                $Entry = $source . '/' . $entry;
                if (is_dir($Entry)) {
                    continue;
                }
                copy( $Entry, $target . '/' . $entry );
            }

            $d->close();
        } else {
            copy( $source, $target );
        }
    }

    /**
     * deletes a directory recursively
     *
     * @param string $target
     * @param bool $verbose
     * @return bool
     */
    public static function deleteRecursive($target,$verbose=false)
    {
        $exceptions=array('.','..');
        if (!$sourcedir=@opendir($target)) {
            if ($verbose) {
                echo '<strong>Couldn&#146;t open '.$target."</strong><br />\n";
            }
            return false;
        }
        while (false!==($sibling=readdir($sourcedir))) {
            if (!in_array($sibling,$exceptions)) {
                $object=str_replace('//','/',$target.'/'.$sibling);
                if ($verbose)
                    echo 'Processing: <strong>'.$object."</strong><br />\n";
                if (is_file($object)) {
                    $result=@unlink($object);
                    if ($verbose&&$result)
                        echo "File has been removed<br />\n";
                    if ($verbose&&(!$result))
                        echo "<strong>Couldn&#146;t remove file</strong>";
                }
            }
        }
        closedir($sourcedir);


        if ($result=@rmdir($target)) {
            if ($verbose) {
                echo "Target directory has been removed<br />\n";
                return true;
            }
        } else {
            if ($verbose) {
                echo "<strong>Couldn&#146;t remove target directory</strong>";
                return false;
            }
        }
    }
}