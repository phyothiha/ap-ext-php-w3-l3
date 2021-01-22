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
        $token = 'zx#rkesfk';

        echo "<input type='hidden' name='_token' value='{$token}'>";
    }
}

if (! function_exists('not_found_template')) {
    function not_found_template()
    {
        echo '
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- place_content -->
                    <div class="col-md-12 d-flex justify-content-center">
                        <h4 class="code">404</h4>
                        <div class="mx-2" style="width: 2px; height: 30px; background: #cbd3db;"></div>
                        <h4 class="message">
                            Not Found            
                        </h4>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        ';
    }
}