<!doctype html>
<html>
    <head>
        <title>Error Test Page</title>
    </head>
    <body>
<?php 
    echo 'http referer   ======>',$_SERVER['HTTP_REFERER'],'<br>';
    echo 'redirect url   ======>',$_SERVER["REDIRECT_URL"],'<br>';
    
?>
        <hr>
        <pre>
<?php
    var_dump($_SERVER);
?>
        </pre>
    </body>
</html>