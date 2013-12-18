<?php
function loader($class) {
    $file = $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
}
function class_loader($class) {
    $file = dirname(dirname(__FILE__)).'/src/'.$class . '.php';
    if (file_exists($file)) {
      require_once $file;
    }
}

spl_autoload_register('loader');
spl_autoload_register('class_loader');
?>