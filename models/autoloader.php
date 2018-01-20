<?php

    function __autoload($className)
    {
        $className = ltrim($className, '\\');
        $dir  = array(
            'models/calls/',
            'models/database/',
            'models/orders/',
            'models/shedule/',
            'models/users/',
            'models/users/auth/',
            'models/utils/',
            'models/spreaders/',
            'models/files/',
            'models/vats/',
            'controllers/',
            'controllers/auth/',
            'api/'
            );
        $namespace = '';

        while (sizeof($dir) != 0) {

            $fileName = array_pop($dir);

            if ($lastNsPos = strrpos($className, '\\')) {
                $namespace = substr($className, 0, $lastNsPos);
                $className = substr($className, $lastNsPos + 1);
                $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
            }
            $fileName .= $className . '.class.php';

            if (file_exists($fileName)) {
                require $fileName;
            }
        }
    }
