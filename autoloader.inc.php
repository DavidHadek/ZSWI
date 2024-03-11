<?php

const BASE_NAMESPACE_NAME = "zswi";
const BASE_APP_DIR_NAME = "app";
const FILE_EXTENSIONS = [".interface.php", ".inc.php", ".abstract.php", ".class.php", ".php", ".enum.php"];

spl_autoload_register(function ($className)
{
    $className = str_replace(BASE_NAMESPACE_NAME, BASE_APP_DIR_NAME, $className);
    $className = str_replace("\\", DIRECTORY_SEPARATOR, $className);



    $className = dirname(__FILE__) . DIRECTORY_SEPARATOR . $className;

    foreach (FILE_EXTENSIONS as $ext) {
        if (is_file($className . $ext)) {
            require_once($className . $ext);
            break;
        }
    }
});
