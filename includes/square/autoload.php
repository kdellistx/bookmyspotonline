<?php
/********************************************************
 * Created by: Randy S. Baker
 * Created on: 17-MAY-2018
 * ------------------------------------------------------
 * Purchase Subscription Page (purchase_subscription.php)
 ********************************************************/

/********************************************************************************
 * After registering this autoload function with SPL, the following line
 * would cause the function to attempt to load the \SquareConnect\Baz\Qux class
 * from /path/to/project/lib/Baz/Qux.php:
 * 
 *      new \SquareConnect\Baz\Qux;
 *      
 * @param string $class The fully-qualified class name.
 * @return void
 *********************************************************************************/

/************************************
 * Initialize the Square API...
 ************************************/
spl_autoload_register(function ($class)
{
    $prefix = 'SquareConnect\\';
    $base_dir = __DIR__ . '/lib/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) 
    {
        return;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file))
    {
        require $file;
    }
});
?>