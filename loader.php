<?php
/**
 * Register namespaces
 *
 * @param  string $prefix    Namespace prefix path
 * @param  string $directory Directory to load files from
 * @return void
 */
function register_namespace($prefix, $directory) {
    spl_autoload_register(function($class) use($prefix, $directory) {
        // does the class use the namespace prefix?
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            // no, move to the next registered autoloader
            return;
        }

        // get the relative class name
        $relativeClass = substr($class, $len);

        // replace the namespace prefix with the base directory, replace namespace
        // separators with directory separators in the relative class name, append
        // with .php
        $file = __DIR__ . $directory . str_replace('\\', '/', $relativeClass) . '.php';

        // load the file if found
        if (file_exists($file)) {
            require $file;
        }
    });
}
