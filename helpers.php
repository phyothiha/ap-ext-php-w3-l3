<?php

if (! function_exists('image_asset_url')) {
    function image_asset_url($url)
    {
        return '/public/images/' . $url;
    }
}

if (! function_exists('old')) {
    function old(string $value, string $default = '')
    {
        return $_SESSION['oldInputValues'][$value] ?? $default;
    }
}

if (! function_exists('error')) {
    function error(string $value)
    {
        return isset( $_SESSION['errorMessageBag'][$value] ) 
                ? $_SESSION['errorMessageBag'][$value] 
                : false;
    }
}

if (! function_exists('is_current_uri')) {
    function is_current_uri( string $uri ) 
    {
        $path = $_SERVER['REQUEST_URI'];
        $position = strpos($path, '?');
        $trim_path = str_replace('.php', '', $path);

        if ( 
            $trim_path == $uri || ( $position && ( str_replace('.php', '', substr($path, 0, $position )) == $uri ) ) 
        ) {
            return true;
        }
    }
}

if (! function_exists('e')) {
    function e(string $value)
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}

if (! function_exists('method')) {
    function method(string $method)
    {
        echo "<input type='hidden' name='_method' value='{$method}'>";
    }
}

if (! function_exists('csrf')) {
    function csrf()
    {
        echo "<input type='hidden' name='_token' value='{$_SESSION['_token']}'>";
    }
}

if (! function_exists('generate_token')) {
    function generate_token()
    {
        if (function_exists( 'random_bytes' )) {
            $_SESSION['_token'] = bin2hex( random_bytes(32) );
        } elseif (function_exists( 'mcrypt_create_iv' )) {
            $_SESSION['_token'] = bin2hex( mcrypt_create_iv(32, MCRYPT_DEV_URANDOM) );
        } else {
            $_SESSION['_token'] = bin2hex( openssl_random_pseudo_bytes(32) );
        }
    }
}