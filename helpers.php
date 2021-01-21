<?php

if (! function_exists('old_input_value')) {
    function old_input_value($value, $default = '')
    {
        echo e( $_SESSION['oldInputValues'][$value] ?? $default );
    }
}
// {{ old('title', $post->title) }}
if (! function_exists('e')) {
    function e($value)
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}

if (! function_exists('method')) {
    function method($spoof_method)
    {
        echo "<input type='hidden' name='_method' value='$spoof_method'>";
    }
}

if (! function_exists('csrf')) {
    function csrf()
    {
        $token = 'zx#rkesfk';

        echo "<input type='hidden' name='_token' value='$token'>";
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