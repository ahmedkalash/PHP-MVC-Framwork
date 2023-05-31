<?php

return function (array $params):array
{
    include_once \app\core\Application::HELPERS_DIR."loadViewData.php";
    return [
        "layout"=>'main',
        'title' => "<title>Page Not Fount</title>",
        'content'=> <<<HTML
            <h1>Page Not Fount</h1>
        HTML
    ];

};




