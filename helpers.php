<?php

/**
 * Get the config directory path
 *
 * @param  string $path Path to concatenate with the config directory
 * @return string       Full path
 */
function config_dir(string $path = '') {
    return __DIR__ . '/config' . $path;
}

/**
 * Get the core directory path
 *
 * @param  string $path Path to concatenate with the core directory
 * @return string       Full path
 */
function core_dir(string $path = '') {
    return __DIR__ . '/core' . $path;
}

/**
 * Get the routes directory path
 *
 * @param  string $path Path to concatenate with the routes directory
 * @return string       Full path
 */
function routes_dir(string $path = '') {
    return __DIR__ . '/routes' . $path;
}

/**
 * Get the controllers directory path
 *
 * @param  string $path Path to concatenate with the controllers directory
 * @return string       Full path
 */
function controllers_dir(string $path = '') {
    return __DIR__ . '/controllers' . $path;
}

function load_file_as_array(string $filePath = '')
{
    if(!file_exists($filePath)) {
        throw new Exception("File $filePath not found.");
    }

    return require_once($filePath);
}