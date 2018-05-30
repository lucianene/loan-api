<?php
return new class {
    private $namespaces = [];

    public function add($prefix, $directory)
    {
        $this->namespaces[] = [
            'prefix' => $prefix,
            'directory' => $directory
        ];
    }

    public function make()
    {
        foreach($this->namespaces as $namespace)
        {
            spl_autoload_register(function($class) use($namespace) {
                // does the class use the namespace prefix?
                $len = strlen($namespace['prefix']);
                if (strncmp($namespace['prefix'], $class, $len) !== 0) {
                    // no, move to the next registered autoloader
                    return;
                }

                // get the relative class name
                $relativeClass = substr($class, $len);

                // replace the namespace prefix with the base directory, replace namespace
                // separators with directory separators in the relative class name, append
                // with .php
                $file = __DIR__ . $namespace['directory'] . str_replace('\\', '/', $relativeClass) . '.php';

                // if the file exists, require it
                if (file_exists($file)) {
                    require $file;
                }
            });
        }
    }
};
