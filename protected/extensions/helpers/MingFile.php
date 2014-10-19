<?php
/**
 *	Ming类库-文件类
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2012-2013
 *	@version	1.0
 *	@package	MING
 *
 *	$Id$
 */

class MingFile
{
    /**
     * this returns an array of all of the files of a set type in a directory path
     * if type is an array then it will return all files of the types in the array ( $types = array('png', 'jpg', 'gif'); )
     *
     * @param string $path, the filepath to search
     * @param mixed $type, the file extension to return
     * @param string $appendPath, the path to append to the returned files
     */
    public static function getFilesByType($path, $type = false, $appendPath = false, $includeExtension = true)
    {
        if (is_dir($path)) {
            $dir = scandir($path); //open directory and get contents
            if (is_array($dir)) { //it found files
                $returnFiles = false;
                foreach ($dir as $file) {
                    if (!is_dir($path . '/' . $file)) {
                        if ($type) { //validate the type
                            $fileParts = explode('.', $file);
                            if (is_array($fileParts)) {
                                $fileType = array_pop($fileParts);
                                $file = implode('.', $fileParts);

                                //check whether the filetypes were passed as an array or string
                                if (is_array($type)) {
                                    if (in_array($fileType, $type)) {
                                        $filePath =  $appendPath . $file;
                                        if ($includeExtension == true) {
                                            $filePath .= '.' . $fileType;
                                        }
                                        $returnFiles[] = $filePath;
                                    }
                                } else {
                                    if ($fileType == $type) {
                                        $filePath =  $appendPath . $file;
                                        if ($includeExtension == true) {
                                            $filePath .= '.' . $fileType;
                                        }
                                        $returnFiles[] = $filePath;
                                    }
                                }
                            }
                        } else { //the type was not set.  return all files and directories
                            $returnFiles[] = $file;
                        }
                    }
                }

                if ($returnFiles) {
                    return $returnFiles;
                }
            }
        }
    }

    /**
     * creates a new file from a string
     *
     * @param string $path
     * @param string $content
     * @return string
     */
    public static function saveFile($path, $content)
    {
        $content = stripslashes($content);
        try {
            file_put_contents($path, $content);
            return 'Your page was saved successfully';
        } catch(Zend_Exception $e) {
            return 'Sorry, there was an error saving your page';
        }
    }

    /**
     * rename the selected file
     *
     * @param string $source
     * @param string $newName
     */
    public static function rename($source, $newName)
    {
        if (file_exists($source)) {
            rename($source, $newName);
        }
    }

    /**
     * copy a file
     *
     * @param string $source
     * @param string $target
     * @return bool
     */
    public static function copy( $source, $target )
    {
        if (file_exists( $source )) {
            return copy($source, $target);
        }
    }

    /**
     * move a file
     *
     * @param string $source
     * @param string $target
     */
    public static function move($source, $target)
    {
        if (file_exists($source)) {
            rename($source, $target);
        }
    }

    /**
     * delete a file
     *
     * @param string $path
     */
    public static function delete($path)
    {
        @unlink($path);
    }

    /**
     * this function cleans up the filename
     * it strips ../ and ./
     * it spaces with underscores
     *
     * @param string $fileName
     */
    public static function cleanFilename($fileName)
    {
        $fileName = str_replace('../', '', $fileName);
        $fileName = str_replace('./', '', $fileName);
        $fileName = str_replace(' ', '_', $fileName);
        return $fileName;
    }

    public static function getFileExtension($filename)
    {
        if (!empty($filename)) {
            $fileparts = explode(".", $filename);
            if (is_array($fileparts)) {
                $index = count($fileparts) - 1;
                $extension = $fileparts[$index];
                return $extension;
            }
        }
        return null;
    }
    
    public static function getCsv($file)
    {
        if(!file_exists($file)) return false;
        $handle = fopen($file, 'r');
        $csv = $fields = array();$i = 0;
        setlocale(LC_ALL, 'zh_CN');
        while($data = fgetcsv($handle, 1000, ','))
        {
            $i++;
            if($i == 1)
                $fields = $data;
            else{
                foreach($data as $k => $v)
                    //$csv[$i][$fields[$k]] = iconv("gb2312", "utf-8//IGNORE", $v);
                    $csv[$i][$fields[$k]] = mb_convert_encoding($v, 'utf-8', 'gb2312,gbk,utf-8');
            }
        }
        fclose($handle);
        setlocale(LC_ALL, NULL);
        return $csv;
    }
}