<?php
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
    header("Status: 301 Moved Permanently", false, 301);
    header("Location: https://www.youtube.com/watch?v=dQw4w9WgXcQ");
    # If file is called from a web browser, rick roll ! :)
    # otherwise, give variables to PHP
} else {
    # https://medium.com/@hfally/how-to-create-an-environment-variable-file-like-laravel-symphonys-env-37c20fc23e72
    $variables = [
        #<general>
        'title' => 'OpenLongr', // site name
        'ext_url' => 'http://127.0.0.1', // External URL !!! Don't put '/' at the end
        'char_per_id' => 8, // Number of characters to use per message ID
        #</general>

        #<MySQL>
        'mysql_address' => '127.0.0.1',
        'mysql_port' => '3306',
        'mysql_database' => 'openlongr',
        'mysql_username' => 'openlongr',
        'mysql_password' => 'openlongr'
        #</MySQL>
    ];
    foreach ($variables as $key => $value) {
        putenv("$key=$value");
    }
}