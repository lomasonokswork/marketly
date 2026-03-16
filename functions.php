<?php
function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}

function redirectIfNotFound($location = "/")
{
    http_response_code(404);
    header("Location: $location", true, 302);
    exit();
}
function redirectIfCatNotFound($location = "/categories/index")
{
    http_response_code(404);
    header("Location: $location", true, 302);
    exit();
}
?>