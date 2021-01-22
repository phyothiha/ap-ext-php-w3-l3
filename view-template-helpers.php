<?php 

if (! function_exists("get_header")) {

    /**
     * Load header template.
     * Includes the header template for a theme or 
     * if a name is specified then a specialised header will be included.
     * 
     * For the parameter, if the file is called "header-special.php" then specify "special".
     * 
     * @param  string|null  $name    Name of the specific header file to use. Null for the default header.
     * @param  array        $args    Additional arguments passed to the header template. 
     * @return void|false            Void on success, false if the template does not exist.
     */
    function get_header( string $name = null, array $args = array() )
    {
        if (empty($name)) {
            include "partials/header.php";
        } else {
            include "partials/header-{$name}.php";
        }
    }
}

if (! function_exists("get_footer")) {

    /**
     * Load footer template.
     * Includes the footer template for a theme or 
     * if a name is specified then a specialised footer will be included.
     * 
     * For the parameter, if the file is called "footer-special.php" then specify "special".
     * 
     * @param  string|null  $name    Name of the specific footer file to use. Null for the default footer.
     * @param  array        $args    Additional arguments passed to the footer template. 
     * @return void|false            Void on success, false if the template does not exist.
     */
    function get_footer( string $name = null, array $args = array() )
    {
        if (empty($name)) {
            include "partials/footer.php";
        } else {
            include "partials/footer-{$name}.php";
        }
    }
}

if (! function_exists('not_found')) {

    function not_found()
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

if (! function_exists("get_template_part")) {

    /**
     * Loads a template part into a template.
     * @param  string       $slug    The slug name for the generic template.
     * @param  string|null  $name    The name of the specialised template.
     * @param  array        $args    Additional arguments passed to the template. 
     * @return void|false            Void on success, false if the template does not exist.
     */
    function get_template_part( string $slug, string $name = null, array $args = array() )
    {
        if (empty($name)) {
            include "{$slug}.php";
        } else {
            include "{$slug}-{$name}.php";
        }
    }
}