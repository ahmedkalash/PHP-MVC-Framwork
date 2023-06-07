<?php

use JetBrains\PhpStorm\NoReturn;



#[NoReturn] function dd($var): void
{
    dump($var);
    exit();
}

#[NoReturn] function dump($var): void
{
    ob_start();
    var_dump($var);
    $var = ob_get_clean();
    highlight_string("<?php\n\n" . $var . ";\n?>");

}
