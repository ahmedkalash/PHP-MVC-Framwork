<?php

use JetBrains\PhpStorm\NoReturn;

#[NoReturn] function dd($var): void
{
    highlight_string("<?php\n\n" . var_export($var, true) . ";\n?>");
    exit();
}

#[NoReturn] function dump($var): void
{
    highlight_string("<?php\n\n" . var_export($var, true) . ";\n?>");
    echo "<hr>";
}
