<?php

    function __autoload($className)
    {
        $className = ltrim($className, '\\');
        $dir  = array(
            'app/calls/',
            'app/database/',
            'app/orders/',
            'app/shedule/',
            'app/users/',
            'app/users/auth/',
            'app/utils/',
            'controllers/auth/'
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
