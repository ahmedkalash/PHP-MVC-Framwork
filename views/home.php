<?php

return function (array $params):array
{
    include_once \app\core\Application::HELPERS_DIR."loadViewData.php";
    return [
        "layout"=>'main',
        'title' => "<title>Home</title>",
        'content'=> <<<HTML
            <h1>Home</h1>
        HTML
    ];

};




